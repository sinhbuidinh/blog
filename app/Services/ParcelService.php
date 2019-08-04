<?php

namespace App\Services;

use App\Repositories\ParcelRepository;

class ParcelService
{
    private $repo;

    public function __construct(ParcelRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getList($wheres = [])
    {
        return $this->repo->search($wheres);
    }

    public function guestList()
    {
        return [];
    }

    public function getServiceList()
    {
        $raw = config('division.services.types');
        if (empty($raw)) {
            return [$raw, []];
        }
        $result = [];
        foreach ($raw as $key => $service) {
            $result[] = [
                'name'    => $service['name'],
                'value'   => $service['value'],
                'display' => $service['display'],
                'math'    => data_get($service, 'math', '+'),
                'note'    => data_get($service, 'note'),
                'key'     => $key
            ];
        }
        return [$raw, $result];
    }
}