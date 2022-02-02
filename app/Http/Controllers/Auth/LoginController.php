<?php

namespace App\Http\Controllers\Auth;

use App\Events\LoginAuthorized;
use App\Events\MyEvent;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Carbon\Carbon;
use Clef\BadSignatureError;
use Clef\Clef;
use Clef\VerificationError;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use JsonException;
use Psr\SimpleCache\InvalidArgumentException;
use Response;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if(app()->runningUnitTests())
        {
            return;
        }
        Clef::configure(array(
            "id" => 1,
            "secret" => env('CLEF_SECRET'),
            "keypair" => env('APP_KEYPAIR'),
            "passphrase" => ""));
    }

    /**
     * Endpoint called when login page is shown. A random ID is generated, and the view is returned.
     *
     * @param \App\User $userID
     * @return Response
     */
    public function show()
    {
        $random_id = $this->generateRandomID();


        return View('auth.login', compact('random_id'));
    }

    /**
     * This endpoint takes a login request from the iOS device, decodes and verifies the payload.
     * If verification is successful, it places a JWT into the cache with a key of the randomly generated ID.
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $payload_bundle = Clef::decode_payload($request["payload"]);
        try
        {
            if(app()->runningUnitTests())
            {
                $signed_payload = json_decode($payload_bundle["payload_json"],
                    true, 512, JSON_THROW_ON_ERROR);
            }
            else
            {
                $signed_payload = json_decode(base64_decode($payload_bundle["payload_json"]),
                    true, 512, JSON_THROW_ON_ERROR);
            }
        }
        catch(JsonException $e)
        {
            return response()->json(['error' => 'Error decoding payload'], 400);
        }

        $userID = (int) $signed_payload["user_id"];
        $user = User::find($userID);
        $randomID = $signed_payload['random_id'];
        $ttl = 2; //Seconds to keep in cache

        if($user === null)
        {
            return response()->json(['Unauthorized' => 'Invalid Login'], 401);
        }

        $public_key = $user->public_key;

        try
        {
            if(Clef::verify_login_payload($payload_bundle, $public_key))
            {
                $token = $this->createResponsePayload($user);
                Cache::put($randomID, $token, $ttl);
                LoginAuthorized::dispatch($randomID);

                return new JsonResponse($token, 200);
            }
        }
        catch(Exception $error)
        {
            return response()->json(['Unauthorized' => 'Invalid Login'], 401);
        }

        return response()->json(['Unauthorized' => 'Invalid Login'], 401);
    }

    /**
     * Uses PHP's random_bytes method to create a cryptographically secure pseudo-random 64 byte nonce.
     * @return JsonResponse|string
     */
    public function generateRandomID()
    {
        try
        {
            $data = random_bytes(64);
        }
        catch(Exception $e)
        {
            return response()->json("Server error, please try again.", 500);
        }

        // Convert bytes to URL safe base64 string.
        return strtr(base64_encode($data), '+/=', '-_,');
    }

    /**
     * Endpoint called for a user logout request.
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function logout(Request $request) : JsonResponse
    {
        if($user = Auth::user())
        {
            $token = $user->token();

            $tokenRepository = app('Laravel\Passport\TokenRepository');

            $tokenRepository->revokeAccessToken($token->id);
            $token->revoke();

            $token->delete();

            $user->logged_out = now();

            return new JsonResponse("You've been logged out", 204);
        }

        return new JsonResponse('Unauthorized', 401);
    }

    /**
     * Endpoint called during login callback by Laravel Echo. Retrieves the JWT if it is present in the cache.
     * The cache stores the JWT using the none ID as the key.
     * @param Request $request
     * @return JsonResponse
     */
    public function confirmLogin(Request $request) : JsonResponse
    {
        try
        {
            $token = Cache::get($request->code);
            Cache::delete($request->code);
            if(!$token)
            {
                return new JsonResponse('Incorrect login data', 401);
            }

        }
        catch(InvalidArgumentException | Exception $e)
        {
            return new JsonResponse('Incorrect login data', 401);
        }

        return new JsonResponse($token, 200);
    }

    /**
     * Builds a response payload with a 1 week expiring JWT in a packaged JSON format that is easy for the
     * front-end to extract.
     * @param $user
     * @return array
     */
    private function createResponsePayload($user) : array
    {
        $tokenResult = $user->createToken('Personal Access Token', ['user']);
        $token = $tokenResult->token;

        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        $user->logged_out_at = Carbon::tomorrow();
        $user->logged_in_at = now();

        return [
            "access_token" => $tokenResult->accessToken,
            "token_type"   => "Bearer",
            "expires_at"   => Carbon::parse(
                $tokenResult->token->expires_at)->toDateTimeString()
        ];
    }
}
