<?php

namespace App\Models;

class Parcel extends BaseModel
{
    const STATUS_INIT           = 0;
    const STATUS_APPLYBILL      = 1;
    const STATUS_INPACKAGE      = 2;
    const STATUS_REFUND         = 3;
    const STATUS_FORWARD        = 4;
    const STATUS_INHAND         = 5;
    const STATUS_UPDATE         = 6;
    const STATUS_INIT_NAME      = 'Nhập hệ thống';
    const STATUS_INPACKAGE_NAME = 'Đang phát';
    const STATUS_APPLYBILL_NAME = 'Nhập bill';
    const STATUS_REFUND_NAME    = 'Chuyển hoàn';
    const STATUS_FORWARD_NAME   = 'Chuyển tiếp';
    const STATUS_INHAND_NAME    = 'Đã phát';
    const STATUS_UPDATE_NAME    = 'Đã update';
    static $statusNames = [
        self::STATUS_INIT      => self::STATUS_INIT_NAME,
        self::STATUS_APPLYBILL => self::STATUS_INPACKAGE_NAME,
        self::STATUS_INPACKAGE => self::STATUS_APPLYBILL_NAME,
        self::STATUS_REFUND    => self::STATUS_REFUND_NAME,
        self::STATUS_FORWARD   => self::STATUS_FORWARD_NAME,
        self::STATUS_INHAND    => self::STATUS_INHAND_NAME,
        self::STATUS_UPDATE    => self::STATUS_UPDATE_NAME,
    ];

    protected $fillable = [
        'guest_id', 'guest_code', 'bill_code', 'type', 'real_weight', 'weight', 'long', 'wide', 'height', 'num_package', 'type_transfer', 'services', 'total_service', 'time_input', 'time_receive', 'receiver', 'receiver_tel', 'provincial', 'district', 'ward', 'address', 'price', 'cod', 'vat', 'price_vat', 'refund', 'forward', 'support_gas', 'support_remote', 'total', 'status'
    ];

    public function getStatusNameAttribute()
    {
        return data_get(self::$statusNames, $this->status);
    }

    public function getTypeNameAttribute()
    {
        $list = config('setting.parcel_type');
        $code = array_search($this->type, $list['code']);
        if ($code === false) {
            return '';
        }
        return data_get($list['name'], $code);
    }

    public function getTransferNameAttribute()
    {
        $list = config('setting.transfer_type');
        $code = array_search($this->type_transfer, $list['code']);
        if ($code === false) {
            return '';
        }
        return data_get($list['name'], $code);
    }

    public function history() 
    {
        return $this->hasMany('App\Models\ParcelHistory', 'parcel_id', 'id');
    }
}