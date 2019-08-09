<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GuestService;
use App\Services\ParcelService;
use App\Request\Admin\CreateGuest;

class GuestController extends Controller
{
    private $parcelService;
    private $guestService;

    public function __construct(GuestService $guestService, ParcelService $parcelService)
    {
        $this->guestService = $guestService;
        $this->parcelService = $parcelService;
    }

    public function index(Request $request)
    {
        $search = ['keyword' => $request->keyword];
        $data = [
            'user'   => $request->user(),
            'search' => $search,
            'guests' => $this->guestService->getList($search),
        ];
        return view('admin.guest.index', $data);
    }

    public function input(Request $request)
    {
        $data = [
            'provincials' => $this->parcelService->getProvincials(),
            'districts'   => $this->parcelService->getDistrictByProvinceId(old('province')),
            'wards'       => $this->parcelService->getWardsByDistrictId(old('district')),
        ];
        return view('admin.guest.input', $data);
    }

    public function create(CreateGuest $request)
    {
        $data = $request->only(['representative', 'represent_tel', 'represent_email', 'company_name', 'email', 'tel', 'fax', 'tax_code', 'tax_address', 'province', 'district', 'ward', 'address']);
        list($result, $message) = $this->guestService->newGuest($data);
        if ($result !== false) {
            session()->flash('success', trans('message.create_guest_success'));
            return redirect()->route('create.guest.complete');
        }
        session()->flash('error', $message);
        return redirect()->route('guest.input')->withInput();
    }

    public function complete()
    {
        $data['message'] = session()->has('success') ? session()->get('success') : 'Complete';
        return view('admin.guest.complete', $data);
    }
}
