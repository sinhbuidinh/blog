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
            $query->where('status', $status);
        })->orderBy('created_at', 'desc');
        if ($getAll === true) {
            return $packages->get();
        }
        $limit = config('setting.pager.common_limit');
        return $packages->paginate($limit);
    }
}