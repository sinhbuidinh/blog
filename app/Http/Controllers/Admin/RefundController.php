<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\RefundService;
use App\Services\ParcelService;

class RefundController extends Controller
{
    private $refundService;
    private $parcelService;
    public function __construct(RefundService $service, ParcelService $parcelService)
    {
        $this->refundService = $service;
        $this->parcelService = $parcelService;
    }

    public function index(Request $request)
    {
        $search = ['keyword' => $request->keyword];
        $data = [
            'user'    => $request->user(),
            'search'  => $search,
            'refunds' => $this->refundService->getList($search),
        ];
        return view('admin.refund.index', $data);
    }

    public function input()
    {
        $data = [
            'parcels' => $this->parcelService->getListForRefund(),
        ];
        return view('admin.refund.input', $data);
    }

    public function create(Request $request)
    {
        $data = $request->only(['parcel', 'note']);
        list($result, $message) = $this->refundService->refund($data);
        if ($result !== false) {
            session()->flash('success', trans('message.refund_success'));
            return redirect()->route('create.refund.complete');
        }
        session()->flash('error', $message);
        return redirect()->route('refund.input')->withInput();
    }

    public function complete()
    {
        $data['message'] = session()->has('success') ? session()->get('success') : 'Complete';
        return view('admin.refund.complete', $data);
    }
}