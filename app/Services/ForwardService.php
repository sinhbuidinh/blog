<?php

namespace App\Services;

use App\Repositories\ParcelRepository;
use App\Models\Parcel;
use DB;
use Log;
use Exception;

class ForwardService
{
    private $repo;

    public function __construct(ParcelRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getList($wheres = [])
    {
        return $this->repo->search(array_merge($wheres, [
            'status' => Parcel::STATUS_FORWARD
        ]), false, true);
    }

    public function forward($input)
    {
        //
    }
}