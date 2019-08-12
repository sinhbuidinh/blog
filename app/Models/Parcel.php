<?php

namespace App\Models;

class Parcel extends BaseModel
{
    // 0:deleted, 1:init, 2:package, 3:transfer, 4:refund, 5:forward, 6:complete
    const STATUS_DELETED        = 0;
    const STATUS_INIT           = 1;
    const STATUS_APPLYBILL      = 2;
    const STATUS_INPACKAGE      = 3;
    const STATUS_REFUND         = 4;
    const STATUS_FORWARD        = 5;
    const STATUS_COMPLETE       = 6;
    const STATUS_DELETED_NAME   = 'Đã xóa';
    const STATUS_INIT_NAME      = 'Nhập hệ thống';
    const STATUS_APPLYBILL_NAME = 'Nhập bill';
    const STATUS_INPACKAGE_NAME = 'Đang phát';
    const STATUS_REFUND_NAME    = 'Chuyển hoàn';
    const STATUS_FORWARD_NAME   = 'Chuyển tiếp';
    const STATUS_COMPLETE_NAME  = 'Đã phát';
    static $statusNames = [
        self::STATUS_DELETED   => self::STATUS_DELETED_NAME,
        self::STATUS_INIT      => self::STATUS_INIT_NAME,
        self::STATUS_APPLYBILL => self::STATUS_APPLYBILL_NAME,
        self::STATUS_INPACKAGE => self::STATUS_INPACKAGE_NAME,
        self::STATUS_REFUND    => self::STATUS_REFUND_NAME,
        self::STATUS_FORWARD   => self::STATUS_FORWARD_NAME,
        self::STATUS_COMPLETE  => self::STATUS_COMPLETE_NAME,
    ];

    protected $fillable = [
        'guest_id', 'guest_code', 'bill_code', 'parcel_code', 'type', 'real_weight', 'weight', 'long', 'wide', 'height', 'num_package', 'type_transfer', 'services', 'total_service', 'time_input', 'time_receive', 'receiver', 'receiver_tel', 'provincial', 'district', 'ward', 'address', 'price', 'cod', 'vat', 'price_vat', 'refund', 'forward', 'support_gas', 'support_remote', 'total', 'status', 'note'
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