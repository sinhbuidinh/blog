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
        $logedId = data_get(auth(getGuard())->user(), 'id');

        static::creating(function($model)
        {
            $model->created_by = $logedId;
        });

        static::updating(function($model)
        {
            $model->updated_by = $logedId;
        });

        static::deleting(function($model)
        {
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
