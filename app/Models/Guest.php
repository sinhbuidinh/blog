<?php

namespace App\Models;

class Guest extends BaseModel
{
    const STATUS_ENABLE        = 1;
    const STATUS_DISABLE       = 0;
    const STATUS_NAME_ENABLE   = 'enable';
    const STATUS_NAME_DISABLE  = 'disable';
    static $statusNames = [
        self::STATUS_ENABLE  => self::STATUS_NAME_ENABLE,
        self::STATUS_DISABLE => self::STATUS_NAME_DISABLE,
    ];

    protected $fillable = [
        'representative', 'represent_tel', 'represent_email', 'company_name', 'email', 'tel', 'fax', 'tax_code', 'tax_address', 'provincial', 'district', 'ward', 'address', 'guest_code', 'price_table', 'discount', 'status'
    ];
}