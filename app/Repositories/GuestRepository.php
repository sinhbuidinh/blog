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
        if (!empty($wheres['keyword'])) {
            $keyword = $wheres['keyword'];
            $guests = $guests->where(function($query) use ($keyword) {
                $query->where('guest_code', 'like', '%' . $keyword . '%')
                      ->orWhere('company_name', 'like', '%' . $keyword . '%')
                      ->orWhere('address', 'like', '%' . $keyword . '%')
                      ->orWhere('email', 'like', '%' . $keyword . '%')
                      ->orWhere('tel', 'like', '%' . $keyword . '%')
                      ->orWhere('representative', 'like', '%' . $keyword . '%')
                      ->orWhere('represent_tel', 'like', '%' . $keyword . '%');
            });
        }

        $guests = $guests->orderBy('created_at', 'asc');
        if ($getAll === true) {
            return $guests->get();
        }
        $limit = config('setting.pager.common_limit');
        return $guests->paginate($limit);
    }

    public function getListAvailable()
    {
        return self::search(['status' => Guest::STATUS_ENABLE], true);
    }

    public function getGuestByAccountApplyId($accountApplyId)
    {
        $guest = $this->model->where('account_apply', $accountApplyId)->first();
        dd($guest);
    }
}