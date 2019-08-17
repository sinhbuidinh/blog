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
            $query->where('parcels.status', $status);
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
}