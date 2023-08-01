<?php

namespace App\Providers;

use App\Models\Boarding;
use App\Models\Daycare;
use App\Models\Grooming;
use Illuminate\Database\Eloquent\Relations\Relation;
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
        Relation::enforceMorphMap([
            'daycare' => Daycare::class,
            'grooming' => Grooming::class,
            'boarding' => Boarding::class,
        ]);
    }
}
