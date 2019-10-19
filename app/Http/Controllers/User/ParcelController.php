<?php

namespace App\Http\Controllers\User;

use App\Models\Parcel;
use App\Services\ParcelService;
use App\Request\User\InputParcel;
use Illuminate\Http\Request;

class ParcelController extends UserController
{
    private $parcelService;

    public function __construct(ParcelService $parcelService)
    {
        parent::__construct();
        $this->parcelService = $parcelService;
    }

    public function input(Request $request)
    {
        $cal_remote = 0;
        if (old('province') && old('district')) {
            $cal_remote = Parcel::isCalRemote(old('province'), old('district'));
        }
        //from login id => guest by account_apply
        $loginId = loginId(getGuard());
        $guests = $this->parcelService->getGuestByUserId($loginId);
        if (count($guests) == 0 || count($guests) > 1) {
            return view('user.input.not_found_guest');
        }
        $guest = $guests->first();
        $data = [
            'cal_remote' => $cal_remote,
            'guest' => $guest,
            'guests' => $this->parcelService->guestList(),
            'default' => config('setting.default'),
            'provincials' => $this->parcelService->getProvincials(),
            'districts' => $this->parcelService->getDistrictByProvinceId(old('province')),
            'wards' => $this->parcelService->getWardsByDistrictId(old('district')),
            'parcel_types' => $this->parcelService->getParcelTypes(),
            'transfer_types' => $this->parcelService->getTransferTypes(),
        ];
        return view('user.input.form', $data);
    }

    public function create(InputParcel $request)
    {
        dd(__LINE__, 'create');
        $data = $request->only(['bill_code', 'guest_id', 'guest_code', 'receiver', 'receiver_tel', 'receiver_company', 'value_declare', 'province', 'district', 'ward', 'address', 'type', 'weight', 'real_weight', 'long', 'wide', 'height', 'num_package', 'type_transfer', 'time_receive', 'price', 'cod', 'refund', 'forward', 'vat', 'price_vat', 'support_gas_rate', 'support_gas', 'support_remote_rate', 'support_remote', 'total', 'note']);
        list($result, $message) = $this->parcelService->newParcelByUser($data);
        if ($result === false) {
            dd(__LINE__, 'error');
            session()->flash('error', $message);
            return redirect()->route('user.input')->withInput();
        }
        dd(__LINE__, 'success create parcel by user input');
        // session()->flash('success', trans('message.create_parcel_success'));
        // return redirect()->route('create.parcel.complete');
    }
}