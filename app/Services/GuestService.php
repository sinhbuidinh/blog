<?php

namespace App\Services;

use App\Repositories\GuestRepository;
use App\Models\Guest;
use DB;
use Log;
use Exception;

class GuestService
{
    private $repo;

    public function __construct(GuestRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getList($wheres = [])
    {
        return $this->repo->search($wheres);
    }

    public function newGuest($input)
    {
        $error = null;
        $guest = [];
        try {
            DB::beginTransaction();
            $info = self::formatGuestInfo($input);
            $guest = Guest::create($info);
            if (!data_get($guest, 'id')) {
                throw new Exception('create guest fail');
            }
            $guest->guest_code = genGuestCode(data_get($guest, 'id'));
            $guest->save();
            DB::commit();
            return [$guest, $error];
        } catch (Exception $e) {
            $error = $e->getMessage();
            Log::error(generateTraceMessage($e));
            DB::rollBack();
            return [false, $error];
        }
    }

    private function formatGuestInfo($input)
    {
        return [
            'representative'  => data_get($input, 'representative'),
            'represent_tel'   => data_get($input, 'represent_tel'),
            'represent_email' => data_get($input, 'represent_email'),
            'company_name'    => data_get($input, 'company_name'),
            'email'           => data_get($input, 'email'),
            'tel'             => data_get($input, 'tel'),
            'fax'             => data_get($input, 'fax'),
            'tax_code'        => data_get($input, 'tax_code'),
            'tax_address'     => data_get($input, 'tax_address'),
            'provincial'      => data_get($input, 'province'),
            'district'        => data_get($input, 'district'),
            'ward'            => data_get($input, 'ward'),
            'address'         => data_get($input, 'address'),
            'price_table'     => data_get($input, 'price_table', 'init'),
            'discount'        => data_get($input, 'discount', 0),
            'status'          => Guest::STATUS_ENABLE,
        ];
    }
}
