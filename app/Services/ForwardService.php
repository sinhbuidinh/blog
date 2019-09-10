<?php

namespace App\Services;

use App\Repositories\ParcelRepository;
use App\Models\Parcel;
use App\Models\Forward;
use App\Models\ParcelHistory;
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
        $error = null;
        $parcel = [];
        try {
            DB::beginTransaction();
            if (!data_get($input, 'parcel')) {
                throw new Exception('Vận đơn chưa được chọn');
            }
            $id = data_get($input, 'parcel');
            $parcel = self::findById($id);
            if (!data_get($parcel, 'id')) {
                throw new Exception('Không tìm thấy vận đơn');
            }
            //get address
            if (!data_get($input, 'address')) {
                throw new Exception('Không có địa chỉ chuyển tiếp');
            }
            $parcelId = data_get($parcel, 'id');
            //insert history
            $history = [
                'parcel_id' => $parcelId,
                'date_time' => now()->format('Y/m/d H:m:s'),
                'location'  => 'Đang chuyển tiếp tới: '.data_get($input, 'address'),
                'status'    => Parcel::STATUS_FORWARD,
                'note'      => data_get($input, 'note'),
            ];
            ParcelHistory::create($history);
            //format data before update
            list($parcel_update, $forward) = self::formatDataForward($input, $parcelId);
            Forward::create($forward);
            $parcel->update($parcel_update);
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

    private function formatDataForward($input, $parcelId)
    {
        $forward = [
            'parcel_id'          => $parcelId,
            'forward_to'         => data_get($input, 'forward_name'),
            'forward_tel'        => data_get($input, 'forward_tel'),
            'forward_provincial' => data_get($input, 'province'),
            'forward_district'   => data_get($input, 'district'),
            'forward_ward'       => data_get($input, 'ward'),
            'forward_address'    => data_get($input, 'address'),
            'forward_note'       => data_get($input, 'note'),
        ];
        $parcel = [
            'total_service'  => data_get($input, 'total_service'),
            'price'          => data_get($input, 'price'),
            'cod'            => data_get($input, 'cod'),
            'vat'            => data_get($input, 'vat'),
            'price_vat'      => data_get($input, 'price_vat'),
            'refund'         => data_get($input, 'refund'),
            'forward'        => data_get($input, 'forward'),
            'support_gas'    => data_get($input, 'support_gas'),
            'support_remote' => data_get($input, 'support_remote'),
            'total'          => data_get($input, 'total'),
            'status'         => Parcel::STATUS_FORWARD,
        ];
        return [$parcel, $forward];
    }
}