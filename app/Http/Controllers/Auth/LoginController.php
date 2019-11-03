<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Request\Admin\Login;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticate(Login $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember') ? true : false;
        if (auth('admin')->viaRemember() || auth('admin')->attempt($credentials, $remember)) {
            if (data_get(auth('admin')->user(), 'is_admin') == 1) {
                return redirect()->intended('/admin/dashboard');
            }
            return redirect()->route('get.logout', ['error' => 'Not allow login']);
        }
        session()->flash('error', 'invalid login');
        return redirect()->route('login')->withInput();
    }

    public function index(Request $request)
    {
        return view('auth.login');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // $this->guard('admin')->logout();
        auth('admin')->logout();

        $request->session()->invalidate();

        if ($request->get('error')) {
            session()->flash('error', $request->get('error'));
        }
        return redirect()->route('login');
    }
}
