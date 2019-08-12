<?php

namespace App\Models;

class ParcelHistory extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'parcel_histories';
    protected $fillable = ['parcel_id', 'date_time', 'location', 'status', 'note'];
}