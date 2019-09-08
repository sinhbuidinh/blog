<?php

namespace App\Models;

class Fail extends BaseModel
{
    const FAIL_CANNOT_CONTACT  = 1;
    const FAIL_CLOSE_DOOR      = 2;
    const FAIL_RECEIVE_404     = 3;
    const FAIL_CHANGE_ADDRESS  = 4;
    const FAIL_REFUSE_RECEIVES = 5;
    const FAIL_ADDRESS_404     = 6;
    const FAIL_ADDRESS_WRONG   = 7;
    const FAIL_OTHER           = 8;
    const CANNOT_CONTACT       = 'Người nhận không nghe máy';
    const CLOSE_DOOR           = 'Đóng cửa';
    const RECEIVE_404          = 'Không tồn tại người nhận ở địa chỉ';
    const CHANGE_ADDRESS       = 'Người nhận chuyển địa chỉ';
    const REFUSE_RECEIVES      = 'Người nhận từ chối nhận';
    const ADDRESS_404          = 'Không tìm thấy địa chỉ';
    const ADDRESS_WRONG        = 'Địa chỉ sai';
    const OTHER                = 'Lý do khác';
    static $fails = [
        self::FAIL_CANNOT_CONTACT  => self::CANNOT_CONTACT,
        self::FAIL_CLOSE_DOOR      => self::CLOSE_DOOR,
        self::FAIL_RECEIVE_404     => self::RECEIVE_404,
        self::FAIL_CHANGE_ADDRESS  => self::CHANGE_ADDRESS,
        self::FAIL_REFUSE_RECEIVES => self::REFUSE_RECEIVES,
        self::FAIL_ADDRESS_404     => self::ADDRESS_404,
        self::FAIL_ADDRESS_WRONG   => self::ADDRESS_WRONG,
        self::FAIL_OTHER           => self::OTHER,
    ];
    protected $fillable = [
        'parcel_id', 'reason', 'fail_time', 'fail_note'
    ];
}