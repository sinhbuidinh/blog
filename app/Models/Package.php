<?php

namespace App\Models;

class Package extends BaseModel
{
    // 0:deleted, 1:init, 2:transfer, 3:refund, 4:forward, 5:complete
    const STATUS_DELETED        = 0;
    const STATUS_INIT           = 1;
    const STATUS_TRANSFER       = 2;
    const STATUS_REFUND         = 3;
    const STATUS_FORWARD        = 4;
    const STATUS_COMPLETE       = 5;
    const STATUS_DELETED_NAME   = 'Đã xóa';
    const STATUS_INIT_NAME      = 'Nhập hệ thống';
    const STATUS_TRANSFER_NAME  = 'Đang chuyển';
    const STATUS_REFUND_NAME    = 'Chuyển hoàn';
    const STATUS_FORWARD_NAME   = 'Chuyển tiếp';
    const STATUS_COMPLETE_NAME  = 'Đã phát';
    static $statusNames = [
        self::STATUS_DELETED   => self::STATUS_DELETED_NAME,
        self::STATUS_INIT      => self::STATUS_INIT_NAME,
        self::STATUS_TRANSFER  => self::STATUS_TRANSFER_NAME,
        self::STATUS_REFUND    => self::STATUS_REFUND_NAME,
        self::STATUS_FORWARD   => self::STATUS_FORWARD_NAME,
        self::STATUS_COMPLETE  => self::STATUS_COMPLETE_NAME,
    ];
    protected $casts = [
        'parcel_list' => 'array'
    ];
    protected $fillable = [
        'package_code', 'parcel_list', 'note'
    ];

    public function items()
    {
        return $this->hasMany('App\Models\PackageItem', 'package_id', 'id');
    }

    public function parcelIds()
    {
        $items = $this->items()->get();
        return $items->pluck('parcel_id')->toArray();
    }

    public function getReadyTransferAttribute()
    {
        return $this->status === self::STATUS_INIT;
    }

    public function getParcelDisplayAttribute()
    {
        return implode(', ', array_values($this->parcel_list));
    }

    public function getParcelIdsJsonAttribute()
    {
        return array_keys($this->parcel_list);
    }

    public function getStatusNameAttribute()
    {
        return data_get(self::$statusNames, $this->status);
    }
}