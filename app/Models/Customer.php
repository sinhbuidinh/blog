<?php

namespace App\Models;

use Illuminate\Support\Carbon;

class Customer extends BaseModel
{
    protected $casts = [
        'birth_date' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function interactions()
    {
        return $this->hasMany(Interaction::class);
    }

    public function scopeOrderByName($query)
    {
        $query->orderBy('last_name')->orderBy('first_name');
    }

    public function getCompanyNameAttribute()
    {
        return data_get($this->company, 'name');
    }
}
