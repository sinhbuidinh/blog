<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Request\Admin\Login;

class LoginController extends UserController
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/user_input/input';

    public function login()
    {
        if (auth('web')->check()) {
            return redirect()->route('user.input');
        }
        return view('user.input.login');
    }

    public function authenticate(Login $request)
    {
        $credentials = $request->only('email', 'password');
        if (auth('web')->attempt($credentials)) {
            $is_admin = data_get(auth('web')->user(), 'is_admin');
            if ($is_admin == 0) {
                return redirect()->route('user.input');
            }
            return redirect()->route('user.logout', ['error' => 'Not allow login']);
        }
        session()->flash('error', 'invalid login');
        return redirect()->route('user.login')->withInput();
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // $admin_loged = auth('admin')->check();
        // $web_loged = auth('web')->check();
        // $this->guard()->logout();
        // $this->guard('web')->logout();
        auth('web')->logout();

        $request->session()->invalidate();

        if ($request->get('error')) {
            session()->flash('error', $request->get('error'));
        }
        // dd(auth()->guard()->getName(), $web_loged, $admin_loged, auth('web')->check(), auth('admin')->check());
        return redirect()->route('user.login');
    }
}
