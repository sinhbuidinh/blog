<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Get sub query by limit 1 result $query then set that be $column
         * Make $column is sub select
         *
         * @param string  $column [Column name for set result $query]
         * @param Builder $query  [Query builder for get result]
         *
         * @return Builder [select sub query]
         */
        Builder::macro('addSubSelect', function ($column, $query) {
            if (is_null($this->getQuery()->columns)) {
                $this->select($this->getQuery()->from.'.*');
            }
             return $this->selectSub($query->limit(1)->getQuery(), $column);
        });

        Builder::macro('orderBySub', function ($query, $direction = 'asc') {
            return $this->orderByRaw("({$query->limit(1)->toSql()}) {$direction}");
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
