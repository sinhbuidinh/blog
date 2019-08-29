<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ParcelService;
use App\Models\Parcel;

class DebtController extends Controller
{
    private $parcelService;
    public function __construct(ParcelService $parcelService)
    {
        $this->parcelService = $parcelService;
    }

    public function index(Request $request)
    {
        $search = [
            'guest_id' => $request->guest_id,
            'dates'    => $request->dates,
            'status'   => Parcel::STATUS_COMPLETE,
        ];
        $data = [
            'user'     => $request->user(),
            'search'   => $search,
            'guests'   => $this->parcelService->guestList(),
            'parcels'  => $this->parcelService->getList($search),
        ];
        return view('admin.debt.index', $data);
    }
}
