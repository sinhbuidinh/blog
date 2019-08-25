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
        })->when(data_get($wheres, 'date'), function ($query, $date) {
            $query->whereRaw("DATE_FORMAT(`created_at`, '%Y-%m-%d') = '$date'");
        });
        if (!is_null(data_get($wheres, 'status'))) {
            $status = $wheres['status'];
            if (is_array($status)) {
                $packages = $packages->whereIn('status', $status);
            } else {
                $packages = $packages->where('status', $status);
            }
        }
        $packages = $packages->orderBy('created_at', 'desc');
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
}