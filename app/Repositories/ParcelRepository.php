<?php

namespace App\Repositories;

use App\Models\Parcel;

class ParcelRepository extends BaseRepository
{
    public function model()
    {
        return Parcel::class;
    }

    public function search(array $wheres = [], $getAll = false, $getPackage = false)
    {
        $parcels = $this->model->select('parcels.*')->when(data_get($wheres, 'keyword'), function ($query, $keyword) {
            $query->where('bill_code', 'like', '%' . $keyword . '%')
                ->orWhere('parcel_code', 'like', '%' . $keyword . '%');
        })->when($getPackage, function($query) {
            $query->join('package_items', 'package_items.parcel_id', '=', 'parcels.id')
            ->join('packages', 'packages.id', '=', 'package_items.package_id')
            ->addSelect('packages.package_code', 'package_items.parcel_id');
        })->when(data_get($wheres, 'parcel_id'), function($query, $parcelId){
            $query->where('parcels.id', $parcelId);
        })->when(data_get($wheres, 'package_id'), function($query, $packageId){
            $query->where('package_items.package_id', $packageId);
        })->when(data_get($wheres, 'date'), function($query, $date){
            $query->where(function ($query) use ($date) {
                $query->whereRaw("DATE_FORMAT(`time_receive`, '%Y-%m-%d') = '$date'")
                ->orWhereRaw("DATE_FORMAT(`parcels`.`created_at`, '%Y-%m-%d') = '$date'");
            });
        })->when(data_get($wheres, 'guest_id'), function($query, $guestId){
            $query->where('guest_id', $guestId);
        });
        if (!is_null(data_get($wheres, 'status'))) {
            $status = $wheres['status'];
            if (is_array($status)) {
                $parcels = $parcels->whereIn('parcels.status', $status);
            } else {
                $parcels = $parcels->where('parcels.status', $status);
            }
        }
        $parcels = $parcels->orderBy('created_at', 'desc');
        if ($getAll === true) {
            return $parcels->get();
        }
        $limit = config('setting.pager.common_limit');
        return $parcels->paginate($limit);
    }

    public function getLastGuest()
    {
        return $this->model->select('guests.*', 'parcels.id AS parcel_id')->join('guests', 'guests.id', '=', 'parcels.guest_id')->orderBy('parcels.id', 'desc')->first();
    }

    public function getForwardInfo($parcelId)
    {
        return $this->model->select('forwards.*')->join('forwards', 'parcel_id', '=', 'parcels.id')->where('parcel_id', $parcelId)->orderBy('created_at', 'desc')->get();
    }

    public function parcelIncludedHistory($code, $selects = '*')
    {
        return $this->model->join('parcel_histories', 'parcel_histories.parcel_id', '=', 'parcels.id')
        ->where(function($query) use ($code) {
            $query->where('parcel_code', $code)
                ->orWhere('bill_code', $code);
        })->orderBy('parcel_histories.id', 'DESC')->get($selects);
    }

    public function countRefundParcel(int $package_id)
    {
        return $this->model->select('parcels.id')->join('package_items', 'package_items.parcel_id', '=', 'parcels.id')->where('parcels.status', Parcel::STATUS_REFUND)->where('package_items.package_id', $package_id)->count();
    }

    public function priceAfterRefund()
    {
        // refund => change refund
        $refund = sqlPriceReal('price');
        // => affect to gas, total
        $gas = self::genMathGasRefund($refund);
        // gas change => vat change
        $vat = self::genMathVatRefund($gas);
        //cal total
        $total = self::genMathTotalRefund($refund, $gas, $vat);
        return [$refund, $gas, $vat, $total];
    }

    public function genMathTotalRefund($refund, $gas, $vat)
    {
        //not change
        $price   = sqlPriceReal('price');
        $service = sqlPriceReal('total_service');
        $forward = sqlPriceReal('forward');
        $cod     = sqlPriceReal('cod');
        $remote  = sqlPriceReal('support_remote');
        return "($price + $service + $refund + $forward + $vat + $cod + $gas + $remote)";
    }

    public function genMathGasRefund($refund = null)
    {
        // total = parseFloat(price) + parseFloat(refund) + parseFloat(forward) + parseFloat(remote)
        //var gas = parseFloat(total * rate) / 100;
        $price = sqlPriceReal('price');
        $refund = $refund ?: sqlPriceReal('price');
        $forward = sqlPriceReal('forward');
        $remote = sqlPriceReal('support_remote');
        $total = "($price + $refund + $forward + $remote)";
        $rate = config('setting.default.support_gas');
        return "(($total * $rate) / 100)";
    }

    public function genMathVatRefund($gas = null)
    {
        $price   = sqlPriceReal('price');
        $service = sqlPriceReal('total_service');
        $gas     = $gas ?: self::genMathGasRefund();
        $remote  = sqlPriceReal('support_remote');
        return "((($price + $service + $gas + $remote) * `vat`)/100)";
    }

}