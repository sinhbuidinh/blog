<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface as ParentInterface;
use Prettus\Repository\Eloquent\BaseRepository as ParentRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class BaseRepository extends ParentRepository implements ParentInterface
{
    public function model()
    {
        static::model();
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}