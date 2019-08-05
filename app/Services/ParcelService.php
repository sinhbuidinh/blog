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

    public function getProvincials()
    {
        $provinces = readJsonFile(config_path('address/provincial.json'));
        $sorted = array_sort($provinces, function($value) {
            return $value['code'];
        });
        return $sorted;
    }

    public function getDistrictByProvinceId($id)
    {
        if (empty($id)) {
            return [];
        }
        $fileName = sprintf('%02d', $id);
        $path = config_path('address/district/'.$fileName.'.json');
        $districts = readJsonFile($path);
        if (empty($districts)) {
            return $districts;
        }
        $sorted = array_sort($districts, function($value) {
            return $value['code'];
        });
        return $sorted;
    }
}