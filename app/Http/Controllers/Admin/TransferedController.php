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
    private $varsIndexKeys = [
        'keyword',
        'guest_id',
        'status',
        'dates',
    ];

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
            'parcel'    => $this->parcelService->findById($id),
            'varsIndex' => $request->only($this->varsIndexKeys),
        ];
        return view('admin.transfered.transfer', $data);
    }

    public function completeTransfered(CompleteTransfer $request, $id)
    {
        $data = $request->only(['complete_receiver', 'complete_receiver_tel', 'complete_receive_time', 'complete_note', 'picture_confirm']);
        list($result, $message) = $this->parcelService->completeTransfered($data, $id, $request);
        if ($result !== false) {
            session()->flash('success', trans('message.parcel_complete_transfered'));
            return redirect()->route('transfereds')->withInput($request->only($this->varsIndexKeys));
        }
        session()->flash('error', $message);
        return redirect()->route('transfer', $id)->withInput($request->only($this->varsIndexKeys));
    }

    public function fail(Request $request, $id)
    {
        $data = [
            'reasons'   => $this->parcelService->allReason(),
            'parcel'    => $this->parcelService->findById($id),
            'varsIndex' => $request->only($this->varsIndexKeys),
        ];
        return view('admin.transfered.fail', $data);
    }

    public function failInfo(FailInfo $request, $id)
    {
        $data = $request->only(['reason', 'fail_time', 'fail_note']);
        list($result, $message) = $this->parcelService->failTransfered($data, $id);
        if ($result !== false) {
            session()->flash('success', trans('message.parcel_updated_fail'));
            return redirect()->route('transfereds')->withInput($request->only($this->varsIndexKeys));
        }
        session()->flash('error', $message);
        return redirect()->route('fail', $id)->withInput($request->only($this->varsIndexKeys));
    }
}
