<?php

namespace App\Services;

use App\Repositories\ParcelRepository;
use App\Models\Package;
use App\Models\PackageItem;
use App\Models\Parcel;
use App\Models\ParcelHistory;
use DB;
use Log;
use Exception;

class RefundService
{
    private $repo;

    public function __construct(ParcelRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getList($wheres = [])
    {
        return $this->repo->search(array_merge($wheres, [
            'status' => Parcel::STATUS_REFUND
        ]), false, true);
    }

    public function refund($input)
    {
        $error = null;
        $updates = [];
        try {
            DB::beginTransaction();
            $parcels = array_filter(data_get($input, 'parcel', []));
            if (empty($parcels) || empty($parcels['id'])) {
                throw new Exception('Not have parcel for refund');
            }
            //update status of parcel list
            $parcel_ids = $parcels['id'];
            list($refund, $gas, $vat, $total) = $this->repo->priceAfterRefund();
            $updates = Parcel::whereIn('id', $parcel_ids)->update([
                'status'      => Parcel::STATUS_REFUND,
                // 'refund'      => DB::raw($refund),
                // 'support_gas' => DB::raw($gas),
                // 'price_vat'   => DB::raw($vat),
                // 'total'       => DB::raw($total)
                // have format number
                'refund'      => DB::raw(sqlNumberFormat($refund)),
                'support_gas' => DB::raw(sqlNumberFormat($gas)),
                'price_vat'   => DB::raw(sqlNumberFormat($vat)),
                'total'       => DB::raw(sqlNumberFormat($total))
            ]);
            // insert log parcel
            $histories = [];
            $packages = [];
            foreach ($parcel_ids as $parcel_id) {
                $histories[] = [
                    'parcel_id' => $parcel_id,
                    'date_time' => now()->format('Y/m/d H:m:s'),
                    'location'  => trans('message.note_history_refund'),
                    'status'    => Parcel::STATUS_REFUND,
                    'note'      => trans('message.note_history_refund'),
                ];
                $package_id = PackageItem::where('parcel_id', $parcel_id)->pluck('package_id')->first();
                $packages[$package_id][$parcel_id] = true;
            }
            ParcelHistory::insert($histories);
            //find package of parcel for update status
            $need_updates = [];
            foreach ($packages as $package_id => $parcels) {
                $parcel_refund = count($parcels);
                $pack_items = PackageItem::where('package_id', $package_id)->get()->count();
                if ($parcel_refund == $pack_items) {
                    $need_updates[] = $package_id;
                    continue;
                }
                //if refund status before + parcel_refund == pack_items => update too
                $refund_before = $this->repo->countRefundParcel($package_id);
                if (($refund_before + $parcel_refund) == $pack_items) {
                    $need_updates[] = $package_id;
                }
            }
            $pack_updated = 0;
            if (!empty($need_updates)) {
                $pack_updated = Package::whereIn('id', $need_updates)->update(['status' => Package::STATUS_REFUND]);
            }
            DB::commit();
            return [$pack_updated, $error];
        } catch (Exception $e) {
            $error = $e->getMessage();
            Log::error(generateTraceMessage($e));
            DB::rollBack();
            return [false, $error];
        }
    }
}