<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ParcelService;
use App\Models\Parcel;
use App\Exports\DebtExport;
use Excel;

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

    public function export(Request $request)
    {
        $dates = $request->get('dates');
        $guestId = $request->get('guest_id');
        $search = [
            'guest_id' => $guestId,
            'dates'    => $dates,
            'status'   => Parcel::STATUS_COMPLETE,
        ];
        $parcels = $this->parcelService->getList($search);
        $fileName = self::debtFileName($guestId, $dates);
        return Excel::download(new DebtExport($parcels), $fileName);
    }

    private function debtFileName($guestId, $dates)
    {
        $fileName = 'congno';
        if (!empty($guestId)) {
            $guest = $this->guestService->findById($guestId);
            $fileName .= '-'.data_get($guest, 'guest_code');
        }
        $date = now()->format('YmdHms');
        if (!empty($dates)) {
            list($from, $to) = explode(' to ', $dates);
            $date = $from . '_to_' . $to;
        }
        $fileName .= '-'.$date;
        return $fileName.'.xlsx';
    }
}
