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
    private $random_id = '';

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
     * Display the specified resource.
     *
     * @param \App\User $userID
     * @return Response
     */
    public function show()
    {
        $random_id = $this->generateRandomID();


        return View('auth.login', compact('random_id'));
    }

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
            return response()->json(['error' => 'Error decoding payload'], 401);
        }

        $userID = (int) $signed_payload["user_id"];
        $user = User::find($userID);
        $randomID = $signed_payload['random_id'];
        $ttl = 5; //Seconds to keep in cache

        if($user === null)
        {
            return response()->json(['error' => "No user found"], 401);
        }

        $public_key = $user->public_key;

        try
        {
            if(Clef::verify_login_payload($payload_bundle, $public_key))
            {
                $token = $this->createResponsePayload($user);
                Cache::put($randomID, $token, $ttl);
                LoginAuthorized::dispatch();

                return new JsonResponse($token, 200);
            }
        }
        catch(Exception $error)
        {
            return response()->json(['error' => 'error validating user data'], 401);
        }

        return response()->json(['Unauthorized' => 'Invalid Login'], 401);
    }

    public function generateRandomID()
    {
        $strongResult = false;
        $data = openssl_random_pseudo_bytes(64, $strongResult);

        if($data === "false" || $strongResult === false)
        {
            return response()->json("Server error, please try again.", 500);
        }

        return strtr(base64_encode($data), '+/=', '-_,');
    }

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

    public function confirmLogin(Request $request) : JsonResponse
    {
        try
        {
            $token = Cache::get($request->code);

            if(!$token)
            {
                return new JsonResponse('Incorrect login data', 401);
            }

        }
        catch(\InvalidArgumentException | Exception $e)
        {
            return new JsonResponse('Incorrect login data', 401);
        }

        return new JsonResponse($token, 200);
    }

    /**
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
