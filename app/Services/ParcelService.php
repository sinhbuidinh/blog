<?php

namespace App\Services;

use App\Repositories\ParcelRepository;
use App\Repositories\GuestRepository;
use App\Models\Guest;
use App\Models\Parcel;
use App\Models\ParcelHistory;
use DB;
use Log;
use Exception;

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
            $append = [
                'name'    => $service['name'],
                'value'   => $service['value'],
                'display' => $service['display'],
                'math'    => data_get($service, 'math', '+'),
                'note'    => data_get($service, 'note'),
                'key'     => $key
            ];
            if (!empty($service['atleast'])) {
                $append['atleast'] = $service['atleast'];
            }
            if (!empty($service['limit'])) {
                $append['limit'] = $service['limit'];
            }
            $result[] = $append;
        }
        return [$raw, $result];
    }

    public function newParcel($input)
    {
        $error = null;
        $parcel = [];
        try {
            DB::beginTransaction();
            $guest_code = data_get($input, 'guest_code');
            $info = self::formatDataParcel($input);
            $parcel = Parcel::create($info);
            $parcel_id = data_get($parcel, 'id');
            if (!$parcel_id) {
                throw new Exception('create parcel fail');
            }
            $parcel->parcel_code = genParcelCode($parcel_id, $guest_code);
            $parcel->save();
            //insert history
            $history = [
                'parcel_id' => $parcel_id,
                'date_time' => now()->format('Y/m/d H:m:s'),
                'location'  => trans('message.company_location'),
                'status'    => Parcel::STATUS_INIT,
                'note'      => data_get($input, 'note'),
            ];
            ParcelHistory::create($history);
            DB::commit();
            return [$parcel, $error];
        } catch (Exception $e) {
            $error = $e->getMessage();
            Log::error(generateTraceMessage($e));
            DB::rollBack();
            return [false, $error];
        }
    }

    public function updateParcel($input, $id)
    {
        $error = null;
        $parcel = [];
        try {
            DB::beginTransaction();
            $parcel = self::findById($id);
            if (!data_get($parcel, 'id')) {
                throw new Exception('Not found');
            }
            $new_status = data_get($input, 'status');
            if (!is_null($new_status) && $new_status != $parcel->status) {
                //insert history
                $history = [
                    'parcel_id' => data_get($parcel, 'id'),
                    'date_time' => now()->format('Y/m/d H:m:s'),
                    'location' => data_get($input, 'location', config('setting.company_transfer_location')),
                    'status' => data_get($input, 'status'),
                    'note' => data_get($input, 'note'),
                ];
                ParcelHistory::create($history);
            }
            //format data before update
            $info = self::formatDataParcel($input);
            $parcel->update($info);
            DB::commit();
            return [$parcel, $error];
        } catch (Exception $e) {
            $error = $e->getMessage();
            Log::error(generateTraceMessage($e));
            DB::rollBack();
            return [false, $error];
        }
    }

    public function findById($id)
    {
        return $this->repo->find($id);
    }

    private function formatDataParcel($input)
    {
        return [
            'guest_id'       => data_get($input, 'guest_id'),
            'guest_code'     => data_get($input, 'guest_code'),
            'bill_code'      => data_get($input, 'bill_code'),
            'type'           => data_get($input, 'type'),
            'real_weight'    => data_get($input, 'real_weight'),
            'weight'         => data_get($input, 'weight'),
            'long'           => data_get($input, 'long'),
            'wide'           => data_get($input, 'wide'),
            'height'         => data_get($input, 'height'),
            'num_package'    => data_get($input, 'num_package'),
            'type_transfer'  => data_get($input, 'type_transfer'),
            'services'       => data_get($input, 'services'),
            'total_service'  => data_get($input, 'total_service'),
            'time_input'     => now()->format('Y-m-d H:m:s'),
            'time_receive'   => data_get($input, 'time_receive'),
            'receiver'       => data_get($input, 'receiver'),
            'receiver_tel'   => data_get($input, 'receiver_tel'),
            'provincial'     => data_get($input, 'province'),
            'district'       => data_get($input, 'district'),
            'ward'           => data_get($input, 'ward'),
            'address'        => data_get($input, 'address'),
            'price'          => data_get($input, 'price'),
            'cod'            => data_get($input, 'cod'),
            'vat'            => data_get($input, 'vat'),
            'price_vat'      => data_get($input, 'price_vat'),
            'refund'         => data_get($input, 'refund'),
            'forward'        => data_get($input, 'forward'),
            'support_gas'    => data_get($input, 'support_gas'),
            'support_remote' => data_get($input, 'support_remote'),
            'total'          => data_get($input, 'total', 0),
            'note'           => data_get($input, 'note', 0),
            'status'         => Parcel::STATUS_INIT,
        ];
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

    public function getListForPackage()
    {
        //find list with status = INIT
        $list = $this->repo->search($search = [
            'status' => Parcel::STATUS_INIT
        ], true);
        return $list;
    }

    public function getListForRefund()
    {
        $list = $this->repo->search($search = [
            'status' => Parcel::STATUS_TRANSFER
        ], true);
        return $list;
    }

    public function getListForForward()
    {
        $list = $this->repo->search($search = [
            'status' => Parcel::STATUS_TRANSFER
        ], true);
        return $list;
    }
}