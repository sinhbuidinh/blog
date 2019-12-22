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
        list($services, $services_display) = $this->parcelService->getServiceList();
        $val_pack_in = 0;
        $old_services = json_encode($services);
        if (!empty(old('services'))) {
            $old_services = stringify2array(old('services'));
            $pack_in = array_first(array_where($old_services, function($v, $k){
                return data_get($v, 'key') == 'package_in';
            }));
            $val_pack_in = data_get($pack_in, 'value');
        }
        //from login id => guest by account_apply
        $loginId = loginId(getGuard());
        $guests = $this->parcelService->getGuestByUserId($loginId);
        if (count($guests) == 0 || count($guests) > 1) {
            return view('user.input.not_found_guest');
        }
        $guest = $guests->first();
        $data = [
            'services' => $old_services,
            'val_pack_in' => $val_pack_in,
            'services_display' => $services_display,
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
        $data = $request->only(['bill_code', 'guest_id', 'guest_code', 'receiver', 'receiver_tel', 'receiver_company', 'value_declare', 'province', 'district', 'ward', 'address', 'type', 'weight', 'real_weight', 'long', 'wide', 'height', 'num_package', 'type_transfer', 'time_receive', 'price', 'cod', 'refund', 'forward', 'vat', 'price_vat', 'support_gas_rate', 'support_gas', 'support_remote_rate', 'support_remote', 'total', 'note', 'total_service', 'services']);
        $data['time_receive'] = now()->format('Y-m-d h:m:s');
        list($result, $message) = $this->parcelService->newParcelByUser($data);
        if ($result === false) {
            session()->flash('error', $message);
            return redirect()->route('user.input')->withInput();
        }
        session()->flash('success', trans('message.create_parcel_success'));
        return redirect()->route('user.success');
    }

    public function success()
    {
        return view('user.input.success');
    }
}