<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $rules = [
            $this->username() => 'required|string',
            'password' => 'required|string'
        ];

        if (config('app.env') == 'production') {
            $rules['g-recaptcha-response'] = [new GoogleReCaptchaV3ValidationRule('login')];
        }

        $this->validate($request, $rules);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // Check user is able to challenge
        $challengeable = $user->canChallenge();

        // redirect to home
        return redirect()->route('home')->with('challengeable', $challengeable);
    }
}
