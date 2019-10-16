<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Request\Admin\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Services\ParcelService;
use App\Models\Parcel;

class InputController extends UserController
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/user_input/input';
    private $parcelService;

    public function __construct(ParcelService $parcelService)
    {
        parent::__construct();
        $this->parcelService = $parcelService;
    }

    public function login()
    {
        if (Auth::guard()->check()) {
            return redirect()->route('user.input');
        }
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
        list($services, $services_display) = $this->parcelService->getServiceList();
        $cal_remote = 0;
        if (old('province') && old('district')) {
            $cal_remote = Parcel::isCalRemote(old('province'), old('district'));
        }
        $val_pack_in = 0;
        $old_services = $services;
        if (!empty(old('services'))) {
            $old_services = stringify2array(old('services'));
            $pack_in = array_first(array_where($old_services, function($v, $k){
                return data_get($v, 'key') == 'package_in';
            }));
            $val_pack_in = data_get($pack_in, 'value');
        }

        $data = [
            'cal_remote'       => $cal_remote,
            'guests'           => $this->parcelService->guestList(),
            'services'         => $old_services,
            'val_pack_in'      => $val_pack_in,
            'services_display' => $services_display,
            'default'          => config('setting.default'),
            'provincials'      => $this->parcelService->getProvincials(),
            'districts'        => $this->parcelService->getDistrictByProvinceId(old('province')),
            'wards'            => $this->parcelService->getWardsByDistrictId(old('district')),
            'parcel_types'     => $this->parcelService->getParcelTypes(),
            'transfer_types'   => $this->parcelService->getTransferTypes(),
        ];
        return view('user.input.form', $data);
    }
}
