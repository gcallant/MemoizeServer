<?php

namespace App\Http\Controllers\Auth;

use App\Events\LoginAuthorizationRequested;
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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
//        $this->middleware('guest')->except('logout');
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
            $signed_payload = json_decode($payload_bundle["payload_json"], true, 512, JSON_THROW_ON_ERROR);
        }
        catch(JsonException $e)
        {
            return response()->json(['error' => 'Error decoding payload'], 401);
        }

        $user = User::find($signed_payload["clef_id"]);
        $randomID = $signed_payload['randomID'];
        $ttl = 60; //Seconds to keep in cache

        if($user === null)
        {
            return response()->json(['error' => "No user found"], 401);
        }

        $public_key = $user->public_key;

        try
        {
            if(Clef::verify_login_payload($payload_bundle, $public_key))
            {
                cache()->set($randomID, $user->id, $ttl);
                return $request->wantsJson()
                    ? new JsonResponse(['status' => true], 200)
                    : redirect('/home');
            }
        }
        catch(VerificationError $error)
        {
            return response()->json(['error' => 'error validating user data'], 401);
        }
        catch(BadSignatureError | InvalidArgumentException | Exception $error)
        {
            return response()->json($error->getMessage(), 401);
        }


        return $this->sendFailedLoginResponse($request);
    }

    private function verifyPayloadData($payload)
    {

    }

    private function generateRandomID()
    {
        if(!session_id())
        {
            session_start();
        }

        if(isset($_SESSION['state']))
        {
            return $_SESSION['state'];
        }

        $data = openssl_random_pseudo_bytes(64);

        if($data === "false")
        {
            return response()->json("Server error, please try again.", 500);
        }

        $session_state = strtr(base64_encode($data), '+/=', '-_,');
        $_SESSION['state'] = $session_state;

        return $session_state;
    }

    public function logout(Request $request)
    {
        if($this->guard()->id() === 0)
        {
            $this->guard()->logout();
            $request->session()->invalidate();

            $request->session()->regenerateToken();
        }

        if($user = Auth::user())
        {
            $token = $user->token();

            $tokenRepository = app('Laravel\Passport\TokenRepository');

            $tokenRepository->revokeAccessToken($token->id);
            $token->revoke();

            $token->delete();

            $user->logged_out = now();

            return $request->wantsJson()
                ? new JsonResponse("You've been logged out", 204)
                : redirect('login');
        }
    }

    public function clientAuthorized(Request $request)
    {
        $request->validate(['hash' => 'required|string']);

        $sentHash = $request->get('hash');
        [$hashKey] = explode('.', $sentHash);
        $storedHash = cache()->get($hashKey . '_login_hash');

        if(!Hash::check($sentHash, $storedHash))
        {
            abort(422);
        }

        event(new LoginAuthorized($sentHash));

        return ['status' => true];
    }

//    public function authorizeLogin(Request $request)
//    {
//        $request->validate([
//            'hash'            => 'required|string',
//            'password'        => 'required|string',
//            $this->username() => 'required|string',
//        ]);
//
//        $sentHash = $request->get('hash');
//        [$hashKey] = explode('.', $sentHash);
//        $storedHash = cache()->get($hashKey . '_login_hash');
//
//        if(!Hash::check($sentHash, $storedHash) || !$this->attemptLogin($request))
//        {
//            abort(422);
//        }
//
//        return ['status' => true];
//    }

    public function confirmLogin(Request $request)
    {
        try
        {
            $user = User::find(1);
            //$user = cache()->get($request->randomID);
        }
        catch(Exception $e)
        {
            return new JsonResponse('Incorrect login data', 401);
        }
        $responsePayload = $this->createResonsePayload($user);

        return new JsonResponse($responsePayload, 200);
    }

//    public function confirLogin(Request $request)
//    {
//        $this->validateLogin($request);
//
//        if($this->hasTooManyLoginAttempts($request))
//        {
//            $this->fireLockoutEvent($request);
//
//            return $this->sendLockoutResponse($request);
//        }
//
//        if($this->guard()->validate($this->credentials($request)))
//        {
//            $username = $request->get($this->username());
//            $hashKey = sha1($username . '_' . Str::random(32));
//            $unhashedLoginHash = $hashKey . '.' . Str::random(32);
//
//            // Store the hash for 5 minutes...
//            $mins = now()->addMinutes(5);
//            $key = "{$hashKey}_login_hash";
//            cache()->put($key, Hash::make($unhashedLoginHash), $mins);
//
//            event(new LoginAuthorizationRequested($unhashedLoginHash, $username));
//
//            return ['status' => true];
//        }
//
//        $this->incrementLoginAttempts($request);
//
//        return $this->sendFailedLoginResponse($request);
//    }

    /**
     * @param $user
     * @return array
     */
    private function createResonsePayload($user) : array
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
