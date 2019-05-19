<?php

namespace App\Models;

use Illuminate\Support\Carbon;

class Customer extends BaseModel
{
    protected $casts = [
        'birth_date' => 'date',
        'last_interaction_date' => 'datetime',
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

    public function scopeWithLastInteractionDate($query)
    {
        $query->addSubSelect('last_interaction_date', Interaction::select('created_at')
            ->whereRaw('customer_id = customers.id')
            ->latest()
        );
    }

    public function scopeWithLastInteractionType($query)
    {
        $query->addSubSelect('last_interaction_type', Interaction::select('type')
            ->whereRaw('customer_id = customers.id')
            ->latest()
        );
    }

    public function getCompanyNameAttribute()
    {
        return data_get($this->company, 'name');
    }
}
