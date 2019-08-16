<?php

namespace App\Services;

use App\Repositories\ParcelRepository;
use App\Models\Parcel;
use DB;
use Log;
use Exception;

class RefundService
{
    private $repo;

    public function __construct(ParcelRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getList($wheres = [])
    {
        return $this->repo->search(array_merge($wheres, [
            'status' => Parcel::STATUS_REFUND
        ]));
    }
}