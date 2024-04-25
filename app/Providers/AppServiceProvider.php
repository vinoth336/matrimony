<?php

namespace App\Providers;

use App\Console\Commands\ModelMakeCommand;
use App\Models\City;
use App\Models\Dosham;
use App\Models\SiteInformation;
use App\Models\Star;
use App\Models\State;
use App\Models\Zodiac;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
        $this->app->extend('command.model.make', function ($command, $app) {
            return new ModelMakeCommand($app['files']);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ini_set('memory_limit', -1);
        Schema::defaultStringLength(191);
        if(true) {
            DB::listen(function($query) {
                Log::info(
                     $this->getEloquentSqlWithBindings($query)
                );
            });
        }

        View::composer('*', function ($view) {
            $siteInformation = SiteInformation::first();
            $version = '1.0.10';
            $states = State::get();
            $cities = City::get();
            $rasies = Zodiac::get();
            $stars = Star::get();
            $dhosams = Dosham::orderBy('sequence')->get();

            $view->with('siteInformation', $siteInformation);
            $view->with('states', $states);
            $view->with('cities', $cities);
            $view->with('stars', $stars);
            $view->with('rasies', $rasies);
            $view->with('dhosams', $dhosams);

            $view->with('version', $version);
        });

    }

    public static function getEloquentSqlWithBindings($query)
    {
        return vsprintf(str_replace('?', '%s', $query->sql), collect($query->bindings)->map(function ($binding) {
            $binding = addslashes($binding);
            return is_numeric($binding) ? $binding : "'{$binding}'";
        })->toArray());
    }
}

