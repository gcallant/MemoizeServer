<?php

namespace App\Http\Controllers\Auth;

use App\Events\LoginAuthorizationRequested;
use App\Events\LoginAuthorized;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
    private $session_id = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Display the specified resource.
     *
     * @param \App\User $userID
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $session_id = "empty";

        return View('auth.login', compact('session_id'));
    }

    public function startLogin()
    {
        //Check if mobile device -> Redirect back to app to continue login ...
        $this->generateSession();
        $session_id = $this->session_id;

        return View('auth.login', compact('session_id'));
    }

    public function login(Request $request)
    {
        $user = User::find($request->input('user_id'));
        if($user == null)
        {
            return response()->json("No user found", 401);
        }
        $public_key = $user->public_key;
        $signature = $request->input('signature');
        $payload = $request->input('payload');

        if($this->verifyPayloadData($payload))
        {
            return $this->authorizeLogin($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    private function verifyPayloadData($payload)
    {

    }

    private function generateSession($id = null)
    {
        if(isset($_SESSION))
        {
            session_destroy();
        }
        if($id == null)
        {
            session_start();
        }
        else
        {
            session_id($id);
            session_start();
        }

        $this->session_id = session_id();
    }

    public function logout()
    {

    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
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

    public function authorizeLogin(Request $request)
    {
        $request->validate([
            'hash'            => 'required|string',
            'password'        => 'required|string',
            $this->username() => 'required|string',
        ]);

        $sentHash = $request->get('hash');
        [$hashKey] = explode('.', $sentHash);
        $storedHash = cache()->get($hashKey . '_login_hash');

        if(!Hash::check($sentHash, $storedHash) || !$this->attemptLogin($request))
        {
            abort(422);
        }

        return ['status' => true];
    }

    public function confirmLogin(Request $request)
    {
        $this->validateLogin($request);

        if($this->hasTooManyLoginAttempts($request))
        {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if($this->guard()->validate($this->credentials($request)))
        {
            $username = $request->get($this->username());
            $hashKey = sha1($username . '_' . Str::random(32));
            $unhashedLoginHash = $hashKey . '.' . Str::random(32);

            // Store the hash for 5 minutes...
            $mins = now()->addMinutes(5);
            $key = "{$hashKey}_login_hash";
            cache()->put($key, Hash::make($unhashedLoginHash), $mins);

            event(new LoginAuthorizationRequested($unhashedLoginHash, $username));

            return ['status' => true];
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
}
