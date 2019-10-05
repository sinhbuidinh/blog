<?php

namespace App\Models;

class Transfered extends BaseModel
{
    const DRIVE_CONFIG_URL = ' https://docs.google.com/uc?id=';
    protected $fillable = [
        'parcel_id', 'complete_receiver', 'complete_receiver_tel', 'complete_receive_time', 'complete_note', 'picture_confirm'
    ];

    public function getPictureConfirmPublicAttribute()
    {
        return self::DRIVE_CONFIG_URL.$this->picture_confirm;
    }
}