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
        $parcels = [];
        $amount = 0;
        // if (!empty($search['dates'])) {
            $parcels = $this->parcelService->getList($search, true);
            $amount = self::calTotalAmount($parcels);
        // }
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
        $fileName = self::debtFileName($guestId, $dates);
        $params = [
            'from' => $from,
            'to' => $to,
            'amount' => formatPrice($amount),
        ];
        return Excel::download(new DebtExport($parcels, $params), $fileName);
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
