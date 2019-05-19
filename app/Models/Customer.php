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

    public function lastInteraction()
    {
        return $this->hasOne(Interaction::class, 'id', 'last_interaction_id');
    }

    /**
     * Load latest interaction.id by sub_select
     * Then eager_loading interaction by interaction.id above
     */
    public function scopeWithLastInteraction($query)
    {
        $query->addSubSelect('last_interaction_id', Interaction::select('id')
            ->whereRaw('customer_id = customers.id')
            ->latest()
        )->with('lastInteraction');
    }

    public function scopeOrderByField($query, $field)
    {
        switch ($field) {
            case 'name':
                 $query->orderByName();
                break;
            case 'company':
                 $query->orderByCompany();
                break;
            default:
                break;
        }
    }

    public function scopeOrderByName($query)
    {
        $query->orderBy('last_name')->orderBy('first_name');
    }

    public function scopeOrderByCompany($query)
    {
        $query->join('companies', 'companies.id', '=', 'customers.company_id')->orderBy('companies.name');
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
