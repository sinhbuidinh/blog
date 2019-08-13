<?php

namespace App\Services;

use App\Repositories\PackageRepository;
use App\Models\Package;
use DB;
use Log;
use Exception;

class PackageService
{
    private $repo;

    public function __construct(PackageRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getList($wheres = [])
    {
        return $this->repo->search($wheres);
    }
}