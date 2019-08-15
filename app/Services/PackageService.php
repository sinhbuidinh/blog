<?php

namespace App\Services;

use App\Repositories\PackageRepository;
use App\Repositories\ParcelRepository;
use App\Models\Package;
use App\Models\Parcel;
use App\Models\ParcelHistory;
use DB;
use Log;
use Exception;

class PackageService
{
    private $repo;
    private $parcelRepo;

    public function __construct(PackageRepository $repo, ParcelRepository $parcelRepo)
    {
        $this->repo = $repo;
        $this->parcelRepo = $parcelRepo;
    }

    public function getList($wheres = [])
    {
        return $this->repo->search($wheres);
    }

    public function newPackage($input)
    {
        $error = null;
        $package = [];
        try {
            DB::beginTransaction();
            $parcels = array_filter(data_get($input, 'parcel', []));
            if (empty($parcels) || empty($parcels['id']) || empty($parcels['code']) || count($parcels['id']) != count($parcels['code'])) {
                throw new Exception('Not have parcel for package');
            }
            $parcel_list = array_combine($parcels['id'], $parcels['code']);
            $info = [
                'parcel_list' => $parcel_list,
                'note' => data_get($input, 'note'),
            ];
            $package = Package::create($info);
            $package_id = data_get($package, 'id');
            if (!$package_id || !($package_code = genPackageCode($package_id))) {
                throw new Exception('create package fail');
            }
            $package->package_code = $package_code;
            $package->save();
            //update status of parcel list
            $parcel_ids = data_get($parcels, 'id');
            $updates = Parcel::whereIn('id', $parcel_ids)->update(['status' => Parcel::STATUS_INPACKAGE]);
            DB::commit();
            return [$package, $error];
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

    public function updateTransfer($packageId)
    {
        $error = null;
        $parcel = [];
        try {
            DB::beginTransaction();
            $package = self::findById($packageId);
            $parcels = data_get($package, 'parcelIds');
            foreach($parcels as $id) {
                $parcel = $this->parcelRepo->find($id);
                if (!data_get($parcel, 'id')) {
                    throw new Exception('Not found');
                }
                if (data_get($parcel, 'status') != Parcel::STATUS_INPACKAGE) {
                    throw new Exception('Not allow update parcel: '.$parcel->parcel_code);
                }
                $status_transfer = Parcel::STATUS_TRANSFER;
                //insert history
                ParcelHistory::create([
                    'parcel_id' => data_get($parcel, 'id'),
                    'date_time' => now()->format('Y/m/d H:m:s'),
                    'location'  => 'Trên đường vận chuyển',
                    'status'    => $status_transfer,
                ]);
                //format data before update
                $parcel->update(['status' => $status_transfer]);
            }
            $package->status = Parcel::STATUS_TRANSFER;
            $package->save();
            DB::commit();
            return [$parcel, $error];
        } catch (Exception $e) {
            $error = $e->getMessage();
            Log::error(generateTraceMessage($e));
            DB::rollBack();
            return [false, $error];
        }
    }
}