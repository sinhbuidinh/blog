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
        })->when(data_get($wheres, 'status'), function ($query, $status) {
            if (is_array($status)) {
                $query->whereIn('parcels.status', $status);
            } else {
                $query->where('parcels.status', $status);
            }
        })->when($getPackage, function($query) {
            $query->join('package_items', 'package_items.parcel_id', '=', 'parcels.id')
            ->join('packages', 'packages.id', '=', 'package_items.package_id')
            ->addSelect('packages.package_code');
        });
        $parcels = $parcels->orderBy('created_at', 'desc');
        if ($getAll === true) {
            return $parcels->get();
        }
        $limit = config('setting.pager.common_limit');
        return $parcels->paginate($limit);
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