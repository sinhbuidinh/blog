<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guard = 'web';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getTypeNameAttribute()
    {
        return $this->is_admin == 1 ? trans('label.is_admin') : trans('label.is_user');
    }

    public function getCanActionAttribute()
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