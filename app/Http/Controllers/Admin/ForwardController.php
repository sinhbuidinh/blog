<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ForwardService;
use App\Services\ParcelService;
use App\Request\Admin\CreateForward;

class ForwardController extends Controller
{
    private $forwardService;
    private $parcelService;
    public function __construct(ForwardService $service, ParcelService $parcelService)
    {
        $this->forwardService = $service;
        $this->parcelService = $parcelService;
    }

    public function index(Request $request)
    {
        $search = [
            'keyword'  => $request->keyword,
            'guest_id' => $request->guest_id,
            'date'     => $request->date,
        ];
        $data = [
            'user'     => $request->user(),
            'search'   => $search,
            'guests'   => $this->parcelService->guestList(),
            'forwards' => $this->forwardService->getList($search),
        ];
        return view('admin.forward.index', $data);
    }

    public function input()
    {
        $data = [
            'default' => config('setting.default'),
            'provincials' => $this->parcelService->getProvincials(),
            'districts' => $this->parcelService->getDistrictByProvinceId(old('province')),
            'wards' => $this->parcelService->getWardsByDistrictId(old('district')),
            'parcels' => $this->parcelService->getListForForward(),
        ];
        return view('admin.forward.input', $data);
    }

    public function create(CreateForward $request)
    {
        $data = $request->only(['parcel', 'province', 'district', 'ward', 'price', 'cod', 'refund', 'forward', 'support_remote', 'support_gas', 'vat', 'price_vat', 'total_service', 'total', 'note']);
        list($result, $message) = $this->forwardService->forward($data);
        if ($result !== false) {
            session()->flash('success', trans('message.forward_success'));
            return redirect()->route('create.forward.complete');
        }
        session()->flash('error', $message);
        return redirect()->route('forward.input')->withInput();
    }

    public function complete()
    {
        $data['message'] = session()->has('success') ? session()->get('success') : 'Complete';
        return view('admin.forward.complete', $data);
    }
}