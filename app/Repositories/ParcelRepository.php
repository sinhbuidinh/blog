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
        if (!empty($keyword = $wheres['keyword'])) {
            $parcels = $parcels->where(function($query) use ($keyword) {
                $query->where('bill_code', 'like', '%' . $keyword . '%')
                      ->orWhere('parcel_code', 'like', '%' . $keyword . '%');
            });
        }
        $parcels = $parcels->orderBy('created_at', 'desc');
        if ($getAll === true) {
            return $parcels->get();
        }
        $limit = config('setting.pager.common_limit');
        return $parcels->paginate($limit);
    }
}