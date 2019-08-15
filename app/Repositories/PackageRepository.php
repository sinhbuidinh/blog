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
        $packages = $this->model;
        if (!empty($keyword = data_get($wheres, 'keyword'))) {
            $packages = $packages->where(function($query) use ($keyword) {
                $query->where('package_code', 'like', '%' . $keyword . '%')
                      ->orWhere('parcel_list', 'like', '%' . $keyword . '%');
            });
        }
        $packages = $packages->orderBy('created_at', 'desc');
        if ($getAll === true) {
            return $packages->get();
        }
        $limit = config('setting.pager.common_limit');
        return $packages->paginate($limit);
    }
}