<?php

namespace App\Repositories;

use App\Models\Package;

class PackageRepository extends BaseRepository
{
    public function model()
    {
        return Package::class;
    }

    public function search(array $wheres = [], $getAll = false)
    {
        $packages = $this->model->when(data_get($wheres, 'keyword'), function ($query, $keyword) {
            $query->where('package_code', 'like', '%' . $keyword . '%');
        })->when(data_get($wheres, 'dates'), function ($query, $dates) {
            list($from, $to) = explode(' to ', $dates);
            $query->whereRaw("DATE_FORMAT(`created_at`, '%Y-%m-%d') >= '$from' AND DATE_FORMAT(`created_at`, '%Y-%m-%d') <= '$to'");
        });
        if (!is_null(data_get($wheres, 'status'))) {
            $status = $wheres['status'];
            if (is_array($status)) {
                $packages = $packages->whereIn('status', $status);
            } else {
                $packages = $packages->where('status', $status);
            }
        }
        $packages = $packages->orderBy('created_at', 'asc');
        if ($getAll === true) {
            return $packages->get();
        }
        $limit = config('setting.pager.common_limit');
        return $packages->paginate($limit);
    }

    public function getStatusList()
    {
        return Package::$statusNames;
    }

    public function getParcelsInPackage($id)
    {
        return $this->model->select('parcels.*')
            ->join('package_items', function ($join) {
                $join->on('packages.id', '=', 'package_items.package_id')
                    ->whereNull('package_items.deleted_at');
            })->join('parcels', function ($join) {
                $join->on('parcels.id', '=', 'package_items.parcel_id')
                    ->whereNull('parcels.deleted_at');
            })->where('packages.id', $id)->get();
    }
}