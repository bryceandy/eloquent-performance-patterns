<?php

namespace App\Providers;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerQueryBuilderMacros();
    }

    /**
     * Adds my custom query builder macros
     */
    protected function registerQueryBuilderMacros()
    {
        Builder::macro('orderBySub', function ($query, $direction = 'desc') {

            list($query, $bindings) = $this->createSub($query);

            return $this->addBinding($bindings, 'order')->orderBy(DB::raw('('.$query.')'), $direction);
        });

        Builder::macro('addSubSelect', function($column, $query) {
            if (is_null($this->columns)) {
                $this->select($this->from.'.*');
            }

            return $this->selectSub($query, $column);
        });
    }
}
