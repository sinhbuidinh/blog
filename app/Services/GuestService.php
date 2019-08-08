<?php

namespace App\Services;

use App\Repositories\GuestRepository;

class GuestService
{
    private $repo;

    public function __construct(GuestRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getList($wheres = [])
    {
        return $this->repo->search($wheres);
    }
}
