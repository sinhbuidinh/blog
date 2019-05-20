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
            case 'birthday':
                 $query->orderByBirthday();
                break;
            case 'last_interaction':
                 $query->orderByLastInteractionDate();
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
        $query->orderBySub(Company::select('name')->whereRaw('customers.company_id = companies.id'));
    }

    /**
     * Order by (month & day) DESC not care about year
     */
    public function scopeOrderByBirthday($query)
    {
        $query->orderbyRaw("DATE_FORMAT(birth_date, 'MMDD')");
    }

    public function scopeOrderByLastInteractionDate($query)
    {
        $query->orderBySub(Interaction::select('created_at')->whereRaw('customers.id = interactions.customer_id')->latest(), 'desc');
    }

    public function scopeWithLastInteractionDate($query)
    {
        $query->addSubSelect('last_interaction_date', Interaction::select('created_at')
            ->whereRaw('customer_id = customers.id')
            ->latest()
        );
    }

    public function scopeWhereSearch($query, $search)
    {
        foreach (explode(' ', $search) as $term) {
            $query->where(function ($query) use ($term) {
                $query->where('first_name', 'like', '%'.$term.'%')
                   ->orWhere('last_name', 'like', '%'.$term.'%')
                   ->orWhereHas('company', function ($query) use ($term) {
                       $query->where('name', 'like', '%'.$term.'%');
                   });
            });
        }
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
