<?php

namespace App\Services;

use App\Repositories\PackageRepository;
use App\Repositories\ParcelRepository;
use App\Models\Package;
use App\Models\PackageItem;
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
        $now = now()->format('Y/m/d H:m:s');
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
            $parcel_ids = $parcels['id'];
            $updates = Parcel::whereIn('id', $parcel_ids)->update(['status' => Parcel::STATUS_INPACKAGE]);
            // insert log parcel
            $histories = [];
            $package_items = [];
            foreach ($parcel_ids as $parcel_id) {
                $package_items[] = [
                    'package_id' => $package_id,
                    'parcel_id'  => $parcel_id,
                    'created_at' => $now,
                ];
                $histories[] = [
                    'parcel_id' => $parcel_id,
                    'date_time' => $now,
                    'location'  => trans('message.note_history_inpackage'),
                    'status'    => Parcel::STATUS_INPACKAGE,
                    'note'      => trans('message.note_history_inpackage'),
                ];
            }
            ParcelHistory::insert($histories);
            PackageItem::insert($package_items);
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
        $package = [];
        $now = now()->format('Y/m/d H:m:s');
        try {
            DB::beginTransaction();
            $package = self::findById($packageId);

            //find parcel list in package
            $parcels = $package->parcelIds();
            $ids = $histories = [];
            foreach($parcels as $id) {
                $parcel = $this->parcelRepo->find($id);
                $parcel_id = data_get($parcel, 'id');
                if (!$parcel_id) {
                    throw new Exception('Not found');
                }
                if (data_get($parcel, 'status') != Parcel::STATUS_INPACKAGE) {
                    throw new Exception('Not allow update !STATUS_INPACKAGE parcel: '.$parcel->parcel_code);
                }
                $ids[] = $parcel_id;
                $histories[] = [
                    'parcel_id'  => $parcel_id,
                    'date_time'  => $now,
                    'location'   => trans('message.note_history_company_transfer'),
                    'status'     => Parcel::STATUS_TRANSFER,
                    'note'       => trans('message.note_history_company_transfer'),
                ];
            }

            //insert history
            ParcelHistory::insert($histories);
            //format data before update
            Parcel::whereIn('id', $ids)->update(['status' => Parcel::STATUS_TRANSFER]);

            //update package status
            $package->status = Package::STATUS_TRANSFER;
            $package->save();
            DB::commit();
            return [$package, $error];
        } catch (Exception $e) {
            $error = $e->getMessage();
            Log::error(generateTraceMessage($e));
            DB::rollBack();
            return [false, $error];
        }
    }
}