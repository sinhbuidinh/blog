<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftDeletes;

    public static function boot()
    {
        parent::boot();

        static::creating(function($model)
        {
            //change to Auth::user() if you are using the default auth provider
            $model->user_id = data_get(auth()->user(), 'id');
        });

        static::updating(function($model)
        {
            //change to Auth::user() if you are using the default auth provider
            $model->user_id = data_get(auth()->user(), 'id');
        });
    }
}
