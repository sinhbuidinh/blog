<?php

namespace App\Repositories;

use App\Models\User;
use DB;

class UserRepository extends BaseRepository
{
    public function model()
    {
        return User::class;
    }

    public function search(array $wheres = [], $getAll = false, $selects = [], $orderBy = 'created_at ASC')
    {
        $raws = DB::raw('users.*');
        if (!empty($selects) && is_array($selects)) {
            $raws = implode(', ', $selects);
            $raws = DB::raw($raws);
        }
        $users = $this->model->select($raws)->when(data_get($wheres, 'keyword'), function ($query, $keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            });
        });
        $users = $users->when(array_key_exists('is_admin', $wheres), function ($query) use($wheres) {
            $query->where('is_admin', data_get($wheres, 'is_admin'));
        })->when(array_key_exists('raw', $wheres), function ($query) use($wheres) {
            $query->whereRaw(data_get($wheres, 'raw'));
        });
        $users = $users->orderByRaw($orderBy);
        if ($getAll === true) {
            return $users->get();
        }
        $limit = config('setting.pager.common_limit');
        return $users->paginate($limit);
    }
}