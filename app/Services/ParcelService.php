<?php

namespace App\Services;

use App\Repositories\ParcelRepository;
use App\Repositories\GuestRepository;
use App\Models\Guest;

class ParcelService
{
    private $repo;
    private $guestRepo;

    public function __construct(ParcelRepository $repo, GuestRepository $guestRepo)
    {
        $this->repo      = $repo;
        $this->guestRepo = $guestRepo;
    }

    public function getList($wheres = [])
    {
        return $this->repo->search($wheres);
    }

    public function guestList()
    {
        return $this->guestRepo->getListAvailable();
    }

    public function getServiceList()
    {
        $raw = config('division.services.list');
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
        return Guest::getDistricts($id);
    }

    public function getWardsByDistrictId($id)
    {
        return Guest::getWards($id);
    }

    public function getParcelTypes()
    {
        return code2Name('setting.parcel_type');
    }

    public function getTransferTypes()
    {
        return code2Name('setting.transfer_type');
    }
}