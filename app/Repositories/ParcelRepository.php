<?php

namespace App\Repositories;

use App\Models\Parcel;

class ParcelRepository extends BaseRepository
{
    public function model()
    {
        return Parcel::class;
    }

    public function search(array $wheres = [], $getAll = false)
    {
        $parcels = $this->model;
        $parcels = $parcels->orderBy('created_at', 'desc');
        if ($getAll === true) {
            return $parcels->get();
        }
        $limit = config('setting.pager.common_limit');
        return $parcels->paginate($limit);
    }
}