<?php

namespace App\Models;

class Forward extends BaseModel
{
    const STATUS_DELETED      = 0;
    const STATUS_ENABLE       = 1;
    const STATUS_DELETED_NAME = 'Đã xóa';
    const STATUS_ENABLE_NAME  = 'Nhập hệ thống';
    static $statusNames = [
        self::STATUS_DELETED => self::STATUS_DELETED_NAME,
        self::STATUS_ENABLE  => self::STATUS_ENABLE_NAME,
    ];
    protected $fillable = [
        'parcel_id', 'forward_to', 'forward_tel', 'forward_provincial', 'forward_district', 'forward_ward', 'forward_address', 'forward_time_receive', 'forward_receiver', 'forward_note', 'forward_status'
    ];
}