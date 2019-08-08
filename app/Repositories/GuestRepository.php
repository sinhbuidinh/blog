<?php

namespace App\Repositories;

use App\Models\Guest;

class GuestRepository extends BaseRepository
{
    public function model()
    {
        return Guest::class;
    }

    public function search(array $wheres = [], $getAll = false)
    {
        $guests = $this->model;
        $guests = $guests->orderBy('created_at', 'desc');
        if ($getAll === true) {
            return $guests->get();
        }
        $limit = config('setting.pager.common_limit');
        return $guests->paginate($limit);
    }
}