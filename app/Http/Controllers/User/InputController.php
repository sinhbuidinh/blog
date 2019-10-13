<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Request\Admin\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class InputController extends UserController
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
        //login first then show input parcel
        return view('user.input.login');
    }

    public function authenticate(Login $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $is_admin = data_get(auth()->user(), 'is_admin');
            if ($is_admin == 0 || $is_admin == 1) {
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
        $this->guard()->logout();

        $request->session()->invalidate();

        if ($request->get('error')) {
            session()->flash('error', $request->get('error'));
        }
        return $this->loggedOut($request) ?: redirect()->route('user.login');
    }

    public function input()
    {
        dd(__LINE__, 'user input');
        // return view('user.input.form');
    }
}
