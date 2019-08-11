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
    const STATUS_INIT_NAME      = 'Nhập hệ thống';
    const STATUS_INPACKAGE_NAME = 'Đang phát';
    const STATUS_APPLYBILL_NAME = 'Nhập bill';
    const STATUS_REFUND_NAME    = 'Chuyển hoàn';
    const STATUS_FORWARD_NAME   = 'Chuyển tiếp';
    const STATUS_INHAND_NAME    = 'Đã phát';

    protected $fillable = [
        'guest_id', 'guest_code', 'bill_code', 'type', 'real_weight', 'weight', 'long', 'wide', 'height', 'num_package', 'type_transfer', 'services', 'total_service', 'time_input', 'time_receive', 'receiver', 'receiver_tel', 'provincial', 'district', 'ward', 'address', 'price', 'cod', 'vat', 'price_vat', 'refund', 'forward', 'support_gas', 'support_remote', 'total', 'status'
    ];
}