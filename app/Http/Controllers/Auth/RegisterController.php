<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('google-recaptcha-v2')->only('register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        if ($user) {
            return redirect()->route('register.success')->with('success', 'Register Succeed.');
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|string|email|max:255|confirmed|unique:users',
            'password' => 'required|string|between:8,20|confirmed',
            'mobile' => 'nullable|integer|digits: 8',
            'agree_tos' => 'required',
        ];

        $messages = [
            'name.required' => '請輸入姓名',
            'email.required' => '請輸入電郵地址',
            'email.email' => '電郵地址格式不正確',
            'email.confirmed' => '確認電郵地址不正確',
            'email.unique' => '電郵地址已登記',
            'password.required' => '請輸入密碼',
            'password.confirmed' => '確認密碼不正確',
            'password.between' => '請輸入8-20位字元密碼',
            'mobile.digits' => '請輸入8位數字電話號碼',
            'agree_tos.required' => '必須同意免責條款才能登記',
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'source' => 'quizfunz',
            'mobile' => $data['mobile'],
            'subscribe' => $data['subscribe'] ?? false,
            'verification_token' => str_random(32),
        ]);
    }

    public function success(Request $request)
    {
        if ($request->session()->exists('success')) {
            return view('auth.register_success');
        }

        return redirect()->route('home');
    }
}
