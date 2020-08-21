<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255|min:2',
            'email' => 'required|string|email|max:255|unique:users|confirmed',
            'phone' => 'required|phone:US|min:10|unique:users'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $confirmation_code = Str::random(64);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'confirmation_code' => $confirmation_code
        ]);

        $userData = array('name' => $data['name'],
                          'email' => $data['email'],
                          'phone' => $data['phone'],
                          'confirmation_code' => $confirmation_code);

        Mail::send('email.verify', $userData, function($message) use($userData){
            $message->to(Input::get('email'), Input::get('name'))->subject('Verify your email address');
        });

        Flash::message('Thanks for signing up for ' . config("app.name"). '! Please check your email for a verification message.');

        return $user;
    }

    public function confirm($confirmation_code)
    {
        if( ! $confirmation_code)
        {
            route('login');
        }

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if ( ! $user)
        {
            route('login');
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        Flash::message('You have successfully verified your account.');

        route('home');
    }
}
