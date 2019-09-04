<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ParcelService;
use App\Services\GuestService;
use App\Models\Parcel;
use App\Exports\DebtExport;
use Excel;

class DebtController extends Controller
{
    private $parcelService;
    private $guestService;
    public function __construct(ParcelService $parcelService, GuestService $guestService)
    {
        $this->parcelService = $parcelService;
        $this->guestService = $guestService;
    }

    public function index(Request $request)
    {
        $guest = $this->parcelService->getLastGuest();
        $guest_id = $request->has('guest_id') ? $request->guest_id : data_get($guest, 'id', -999);
        $dates = $request->has('dates') ? $request->dates : getThisMonthDatepicker();
        $search = [
            'guest_id' => $guest_id,
            'dates'    => $dates,
            'status'   => Parcel::STATUS_COMPLETE,
        ];
        $parcels = [];
        $amount = 0;
        if (!empty($search['dates'])) {
            $parcels = $this->parcelService->getList($search, true);
            $amount = self::calTotalAmount($parcels);
        }
        $data = [
            'user'    => $request->user(),
            'search'  => $search,
            'guests'  => $this->parcelService->guestList(),
            'parcels' => $parcels,
            'amount'  => formatPrice($amount),
        ];
        return view('admin.debt.index', $data);
    }

    private function calTotalAmount($parcels)
    {
        $totals = $parcels->pluck('total', 'id');
        $amount = 0;
        foreach($totals as $id => $total) {
            $amount += removeFormatPrice($total);
        }
        return $amount;
    }

    public function export(Request $request)
    {
        $dates = $request->get('dates');
        if (empty($dates)) {
            session()->flash('error', trans('message.choose_dates'));
            return redirect()->route('debt')->withInput();
        }
        list($from, $to) = explode(' to ', $dates);
        if (empty($from) || empty($to)) {
            session()->flash('error', trans('message.invalid_dates'));
            return redirect()->route('debt')->withInput();
        }
        $guestId = $request->get('guest_id');
        $search = [
            'guest_id' => $guestId,
            'dates'    => $dates,
            'status'   => Parcel::STATUS_COMPLETE,
        ];
        $parcels = $this->parcelService->getList($search, true);
        $amount = self::calTotalAmount($parcels);
        list($fileName, $guest) = self::debtFileName($guestId, $dates);
        $params = [
            'from' => $from,
            'to' => $to,
            'amount' => formatPrice($amount),
        ];
        return Excel::download(new DebtExport($parcels, $params, $guest), $fileName);
    }

    private function debtFileName($guestId, $dates)
    {
        $guest = [];
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
        return [$fileName.'.xlsx', $guest];
    }
}
