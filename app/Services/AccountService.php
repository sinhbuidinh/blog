<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use DB;
use Log;
use Exception;

class AccountService
{
    private $repo;

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getList($wheres = [], $getAll = false, $orderBy = 'created_at ASC')
    {
        return $this->repo->search($wheres, $getAll, [], $orderBy);
    }
}