<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ParcelService;
use App\Request\Admin\CreateParcel;
use App\Models\Parcel;
use App\Request\Admin\CompleteTransfer;
use App\Request\Admin\FailInfo;

class TransferedController extends Controller
{
    private $parcelService;
    public function __construct(ParcelService $parcelService)
    {
        $this->parcelService = $parcelService;
    }

    public function index(Request $request)
    {
        $status = data_get($request, 'status');
        if (is_null($status)) {
            $status = [
                Parcel::STATUS_TRANSFER,
                Parcel::STATUS_REFUND,
                Parcel::STATUS_FORWARD,
                Parcel::STATUS_FAIL,
                Parcel::STATUS_COMPLETE,
            ];
        }
        $search = [
            'keyword'  => $request->keyword,
            'guest_id' => $request->guest_id,
            'dates'    => $request->dates,
            'status'   => $status,
        ];
        $data = [
            'user'     => $request->user(),
            'guests'   => $this->parcelService->guestList(),
            'search'   => $search,
            'statuses' => $this->parcelService->getStatusesTransfered(),
            'parcels'  => $this->parcelService->getList($search),
        ];
        return view('admin.transfered.index', $data);
    }

    public function transfered(Request $request, $id)
    {
        $data = [
            'parcel' => $this->parcelService->findById($id),
        ];
        return view('admin.transfered.transfer', $data);
    }

    public function completeTransfered(CompleteTransfer $request, $id)
    {
        $data = $request->only(['complete_receiver', 'complete_receiver_tel', 'complete_receive_time', 'complete_note']);
        list($result, $message) = $this->parcelService->completeTransfered($data, $id);
        if ($result !== false) {
            session()->flash('success', trans('message.parcel_complete_transfered'));
            return redirect()->route('transfereds');
        }
        session()->flash('error', $message);
        return redirect()->route('transfer', $id)->withInput();
    }

    public function fail(Request $request, $id)
    {
        $data = [
            'reasons' => $this->parcelService->allReason(),
            'parcel' => $this->parcelService->findById($id),
        ];
        return view('admin.transfered.fail', $data);
    }

    public function failInfo(FailInfo $request, $id)
    {
        $data = $request->only(['reason', 'fail_time', 'fail_note']);
        list($result, $message) = $this->parcelService->failTransfered($data, $id);
        if ($result !== false) {
            session()->flash('success', trans('message.parcel_updated_fail'));
            return redirect()->route('transfereds');
        }
        session()->flash('error', $message);
        return redirect()->route('fail', $id)->withInput();
    }
}
