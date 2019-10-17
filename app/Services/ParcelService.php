<?php

namespace App\Services;

use App\Repositories\ParcelRepository;
use App\Repositories\GuestRepository;
use App\Models\Guest;
use App\Models\Parcel;
use App\Models\ParcelHistory;
use App\Models\Package;
use App\Models\Forward;
use App\Models\PackageItem;
use App\Models\Transfered;
use App\Models\Fail;
use DB;
use Log;
use Exception;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use App\Components\GoogleClient;

class ParcelService
{
    private $repo;
    private $guestRepo;
    private $client;

    public function __construct(ParcelRepository $repo, GuestRepository $guestRepo, GoogleClient $client)
    {
        $this->repo      = $repo;
        $this->guestRepo = $guestRepo;
        $this->client    = $client->getClient();
    }

    public function getList($wheres = [], $getAll = false, $getPackage = false)
    {
        return $this->repo->search($wheres, $getAll, $getPackage);
    }

    public function guestList()
    {
        return $this->guestRepo->getListAvailable();
    }

    public function getLastGuest()
    {
        return $this->repo->getLastGuest();
    }

    public function getServiceList()
    {
        $raw = config('division.services.list');
        $timer = config('price.timer_price');
        $raw['super_fast'] = $timer;
        $raw['package_in'] = config('price.package_price');
        if (empty($raw)) {
            return [$raw, []];
        }
        $result = [];
        foreach ($raw as $key => $service) {
            if ($key == 'super_fast' || $key == 'package_in') {
                continue;
            }
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
            if (!empty($service['price'])) {
                $append['price'] = json_encode($service['price'], true);
            }
            $result[] = $append;
        }
        array_push($result, [
            'name'    => trans('label.superfast'),
            'value'   => 0,
            'display' => trans('message.price_by_area'),
            'math'    => data_get($service, 'math', '+'),
            'note'    => trans('message.superfast_display'),
            'key'     => 'timer_price',
            'price'   => json_encode($timer, true),
        ]);
        array_push($result, [
            'name'    => trans('label.package_in'),
            'value'   => 0,
            'display' => trans('message.package_in'),
            'math'    => '+',
            'note'    => '<input type="text" class="form-control" name="package_price" id="package_price"/>',
            'key'     => 'package_in',
            'price'   => json_encode($raw['package_in'], true),
        ]);
        return [$raw, $result];
    }

    public function newParcel($input)
    {
        $error = null;
        $parcel = [];
        try {
            DB::beginTransaction();
            $guest_code = data_get($input, 'guest_code');
            $info = self::formatDataParcel($input, true);
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
                'location'  => config('setting.company_location'),
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

    public function newParcelByUser($input)
    {
        $error = null;
        $parcel = [];
        try {
            DB::beginTransaction();
            //from login id => guest by account_apply
            $user_id = $this->guestRepo->getGuestByAccountApplyId(loginId());
            $guest_code = data_get($input, 'guest_code');

            $info = self::formatDataParcel($input, true);
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
                'location'  => config('setting.company_location'),
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
            if (($transfered = data_get($input, 'transfered')) && ($transfered_id = data_get($transfered, 'id'))) {
                unset($transfered['id']);
                $transfered = Transfered::where('id', $transfered_id)->update($transfered);
            }
            //format data before update
            $info = self::formatDataParcel($input);
            $new_status = data_get($input, 'status');
            if (!is_null($new_status) && $new_status != $parcel->status) {
                //insert history
                $history = [
                    'parcel_id' => data_get($parcel, 'id'),
                    'date_time' => now()->format('Y/m/d H:m:s'),
                    'location' => data_get($input, 'location', config('setting.company_transfer_location')),
                    'status' => $new_status,
                    'note' => data_get($input, 'note'),
                ];
                ParcelHistory::create($history);
                $info['status'] = $new_status;
            }
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

    public function completeTransfered($input, $id, $request)
    {
        $error = null;
        $parcel = [];
        try {
            DB::beginTransaction();
            $parcel = self::findById($id);
            if (!data_get($parcel, 'id')) {
                throw new Exception('Not found');
            }
            $parcelId = data_get($parcel, 'id');

            //image_id
            $path = null;
            if ($request->hasFile('picture_confirm')) {
                $imageId = self::getImageID($request->file('picture_confirm'));
                if (is_null($imageId)) {
                    throw new Exception('Upload image fail');
                }
                $path = $imageId;
            }
            //insert Transfered
            Transfered::create([
                'parcel_id'             => $parcelId,
                'complete_receiver'     => data_get($input, 'complete_receiver'),
                'picture_confirm'       => $path,
                'complete_receiver_tel' => data_get($input, 'complete_receiver_tel'),
                'complete_receive_time' => data_get($input, 'complete_receive_time'),
                'complete_note'         => data_get($input, 'complete_note'),
            ]);
            //insert history
            $history = [
                'parcel_id' => $parcelId,
                'date_time' => data_get($input, 'complete_receive_time', now()->format('Y-m-d H:m:s')),
                'location'  => self::lastAddressWhenComplete($parcel),
                'status'    => Parcel::STATUS_COMPLETE,
                'note'      => data_get($input, 'complete_note'),
            ];
            ParcelHistory::create($history);
            //update package have parcel
            list($packageId, $package_items, $not_completed) = self::getParcelInSamePackage($parcelId);
            if (empty($packageId)) {
                throw new Exception('Not found package of parcel');
            }
            if (empty($not_completed)) {
                //update package
                Package::where('id', $packageId)->update(['status' => Package::STATUS_COMPLETE]);
            }
            //format data before update
            $parcel->update(['status' => Parcel::STATUS_COMPLETE]);
            DB::commit();
            return [$parcel, $error];
        } catch (Exception $e) {
            // $error = trans('message.error_when_transfered');
            $error = $e->getMessage();
            Log::error(generateTraceMessage($e));
            DB::rollBack();
            if (!empty($path)) {
                self::removeImageID($path);
            }
            return [false, $error];
        }
    }

    private function removeImageID($id)
    {
        try {
            $driveService = new Google_Service_Drive($this->client);
            $file = $driveService->files->delete($id);
            return true;
        } catch (Exception $e) {
            Log::error(generateTraceMessage($e).' with IMG-ID:'.$id);
            return false;
        }
    }

    private function getImageID($image)
    {
        try {
            $driveService = new Google_Service_Drive($this->client);
            $fileMetadata = new \Google_Service_Drive_DriveFile([
                'name' => time().'.'.$image->getClientOriginalExtension(),
            ]);
            $file = $driveService->files->create($fileMetadata, [
                'data'       => file_get_contents($image->getRealPath()),
                'uploadType' => 'multipart',
                'fields'     => 'id',
            ]);
            // bắt đầu phân quyền
            $driveService->getClient()->setUseBatch(true);
            try {
                $batch = $driveService->createBatch();
                $permission = new \Google_Service_Drive_Permission([
                    'type' => 'anyone', // user | group | domain | anyone
                    'role' => 'reader', // organizer | owner | writer | commenter | reader
                ]);
                $request = $driveService->permissions->create($file->id, $permission, ['fields' => 'id']);
                $batch->add($request, 'user');
                $results = $batch->execute();
            } catch (\Exception $e) {
                $error = $e->getMessage();
                Log::error($error);
            } finally {
                $driveService->getClient()->setUseBatch(false);
            }
            return $file->id;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            Log::error($error);
            return null;
        }
    }

    public function failTransfered($input, $id)
    {
        $error = null;
        $parcel = [];
        try {
            DB::beginTransaction();
            $parcel = self::findById($id);
            if (!data_get($parcel, 'id')) {
                throw new Exception('Not found');
            }
            $parcelId = data_get($parcel, 'id');
            //insert Fail
            Fail::create([
                'parcel_id' => $parcelId,
                'reason'    => data_get($input, 'reason'),
                'fail_time' => data_get($input, 'fail_time'),
                'fail_note' => data_get($input, 'fail_note'),
            ]);
            //insert history
            $history = [
                'parcel_id' => $parcelId,
                'date_time' => data_get($input, 'fail_time', now()->format('Y-m-d H:m:s')),
                'location'  => self::lastAddressWhenComplete($parcel),
                'status'    => Parcel::STATUS_FAIL,
                'note'      => data_get($input, 'fail_note'),
            ];
            ParcelHistory::create($history);
            $parcel->update(['status' => Parcel::STATUS_FAIL]);
            DB::commit();
            return [$parcel, $error];
        } catch (Exception $e) {
            // $error = trans('message.error_when_update_fail');
            $error = $e->getMessage();
            Log::error(generateTraceMessage($e));
            DB::rollBack();
            return [false, $error];
        }
    }

    public function deleteParcel($id)
    {
        $error = null;
        $parcel = [];
        try {
            DB::beginTransaction();
            $parcel = self::findById($id);
            //find parcel_histories, package_items, forwards, transfered delete too
            ParcelHistory::where('parcel_id', $id)->delete();
            PackageItem::where('parcel_id', $id)->delete();
            Forward::where('parcel_id', $id)->delete();
            Transfered::where('parcel_id', $id)->delete();
            $parcel->delete();
            $parcel->status = Parcel::STATUS_DELETED;
            $parcel->save();
            DB::commit();
            return [$parcel, $error];
        } catch (Exception $e) {
            $error = $e->getMessage();
            Log::error(generateTraceMessage($e));
            DB::rollBack();
            return [false, $error];
        }
    }

    public function getParcelInSamePackage($parcelId)
    {
        $package = PackageItem::where('parcel_id', $parcelId)->first();
        $packageId = data_get($package, 'package_id');
        $items = $this->repo->search([
            'parcel_id' => $parcelId,
            'package_id' => $packageId,
        ], true, true);
        $except_parcel = $items->filter(function ($value, $key) use ($parcelId) {
            return data_get($value, 'parcel_id') != $parcelId;
        });
        $not_completed = [];
        if (count($except_parcel) > 0) {
            $not_completed = $except_parcel->filter(function ($value, $key) use ($parcelId) {
                return (data_get($value, 'status') != Parcel::STATUS_COMPLETE || data_get($value, 'status') != Parcel::STATUS_REFUND || data_get($value, 'status') != Parcel::STATUS_DELETED);
            });
        }
        return [$packageId, $except_parcel, $not_completed];
    }

    public function lastAddressWhenComplete($parcel)
    {
        $id = data_get($parcel, 'id');
        $forward = $this->repo->getForwardInfo($id);
        $address = data_get($parcel, 'address');
        if (count($forward) > 0) {
            $address = data_get($forward, 'forward_address');
        }
        return $address;
    }

    public function findById($id)
    {
        return $this->repo->find($id);
    }

    public function locateInfo($code)
    {
        if (empty($code)) {
            return [false, false, false];
        }
        //search parcel by parcel_code || bill_code code
        $selects = [
            'parcels.*',
            'parcel_histories.id AS history_id',
            'parcel_histories.parcel_id',
            'parcel_histories.date_time',
            'parcel_histories.location',
            'parcel_histories.status AS history_status',
            'parcel_histories.note AS history_note',
        ];
        $histories = $this->repo->parcelIncludedHistory($code, $selects);
        $parcel = $histories->first();
        $tracks = $histories->reverse();
        return [$parcel, $histories, $tracks];
    }

    private function formatDataParcel($input, $is_new = false)
    {
        $params = [
            'guest_id'         => data_get($input, 'guest_id'),
            'guest_code'       => data_get($input, 'guest_code'),
            'bill_code'        => data_get($input, 'bill_code'),
            'type'             => data_get($input, 'type'),
            'real_weight'      => data_get($input, 'real_weight'),
            'weight'           => data_get($input, 'weight'),
            'long'             => data_get($input, 'long'),
            'wide'             => data_get($input, 'wide'),
            'height'           => data_get($input, 'height'),
            'num_package'      => data_get($input, 'num_package'),
            'type_transfer'    => data_get($input, 'type_transfer'),
            'services'         => data_get($input, 'services'),
            'total_service'    => data_get($input, 'total_service'),
            'time_input'       => now()->format('Y-m-d H:m:s'),
            'time_receive'     => data_get($input, 'time_receive'),
            'receiver_company' => data_get($input, 'receiver_company'),
            'receiver'         => data_get($input, 'receiver'),
            'receiver_tel'     => data_get($input, 'receiver_tel'),
            'provincial'       => data_get($input, 'province'),
            'district'         => data_get($input, 'district'),
            'ward'             => data_get($input, 'ward'),
            'address'          => data_get($input, 'address'),
            'price'            => data_get($input, 'price'),
            'cod'              => data_get($input, 'cod'),
            'vat'              => data_get($input, 'vat'),
            'price_vat'        => data_get($input, 'price_vat'),
            'refund'           => data_get($input, 'refund'),
            'forward'          => data_get($input, 'forward'),
            'support_gas'      => data_get($input, 'support_gas'),
            'support_remote'   => data_get($input, 'support_remote'),
            'total'            => data_get($input, 'total', 0),
            'note'             => data_get($input, 'note', 0),
            'status'           => Parcel::STATUS_INIT,
        ];
        if ($is_new === false) {
            unset($params['status']);
        }
        return $params;
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
            'status' => Parcel::STATUS_INIT,
            'bill_code_check' => true,
        ], true);
        return $list;
    }

    public function getListForRefund()
    {
        $list = $this->repo->search($search = [
            'status' => Parcel::STATUS_TRANSFER,
            'bill_code_check' => true,
        ], true);
        return $list;
    }

    public function getListForForward()
    {
        $list = $this->repo->search($search = [
            'status' => Parcel::STATUS_TRANSFER,
            'bill_code_check' => true,
        ], true);
        return $list;
    }

    public function getStatuses()
    {
        $statuses = Parcel::$statusNames;
        unset($statuses[Parcel::STATUS_DELETED]);
        return $statuses;
    }

    public function allReason()
    {
        return Fail::$fails;
    }

    public function getStatusesTransfered()
    {
        $statuses = Parcel::$statusNames;
        unset($statuses[Parcel::STATUS_DELETED]);
        unset($statuses[Parcel::STATUS_INIT]);
        unset($statuses[Parcel::STATUS_INPACKAGE]);
        unset($statuses[Parcel::STATUS_COMPLETE]);
        unset($statuses[Parcel::STATUS_FAIL]);
        return $statuses;
    }

    public function getStatusesDebt()
    {
        $statuses = Parcel::$statusNames;
        unset($statuses[Parcel::STATUS_DELETED]);
        unset($statuses[Parcel::STATUS_INIT]);
        unset($statuses[Parcel::STATUS_INPACKAGE]);
        return $statuses;
    }
}