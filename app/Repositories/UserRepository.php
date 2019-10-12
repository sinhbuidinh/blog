<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function model()
    {
        return User::class;
    }

    public function search(array $wheres = [], $getAll = false, $orderBy = 'created_at ASC')
    {
        $users = $this->model->select('users.*')->when(data_get($wheres, 'keyword'), function ($query, $keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            });
        });
        $users = $users->orderByRaw($orderBy);
        if ($getAll === true) {
            return $users->get();
        }
        $limit = config('setting.pager.common_limit');
        return $users->paginate($limit);
    }
}