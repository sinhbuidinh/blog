<?php

namespace App\Models;

class Package extends BaseModel
{
    protected $casts = [
        'parcel_list' => 'array'
    ];
    protected $fillable = [
        'package_code', 'parcel_list', 'note'
    ];

    public function getParcelDisplayAttribute()
    {
        return implode(', ', array_values($this->parcel_list));
    }

    public function getParcelIdsAttribute()
    {
        return array_keys($this->parcel_list);
    }
}