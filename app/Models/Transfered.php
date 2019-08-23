<?php

namespace App\Models;

class Transfered extends BaseModel
{
    protected $fillable = [
        'parcel_id', 'complete_receiver', 'complete_receiver_tel', 'complete_receive_time', 'complete_note'
    ];
}