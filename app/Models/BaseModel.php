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
            $logedId = data_get(auth(getGuard())->user(), 'id');
            $model->created_by = $logedId;
        });

        static::updating(function($model)
        {
            $logedId = data_get(auth(getGuard())->user(), 'id');
            $model->updated_by = $logedId;
        });

        static::deleting(function($model)
        {
            $logedId = data_get(auth(getGuard())->user(), 'id');
            $model->user_id = $logedId;
        });
    }

    protected function getCanActionAttribute()
    {
        if (isSuperAdmin('admin')) {
            return true;
        }
        if (is_null($this->created_by)) {
            return true;
        }
        $loginId = loginId('admin');
        return ($this->created_by == $loginId || $this->user_id == $loginId);
    }
}
