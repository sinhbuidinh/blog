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
        })->when(data_get($wheres, 'status'), function ($query, $status) {
            if (!is_null($status)) {
                $query->where('status', $status);
            }
        })->when(data_get($wheres, 'date'), function ($query, $date) {
            $query->whereRaw("DATE_FORMAT(`created_at`, '%Y-%m-%d') = '$date'");
        })->orderBy('created_at', 'desc');
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