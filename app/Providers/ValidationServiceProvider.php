<?php

namespace App\Providers;

use App\Models\Contest;
use App\Services\AgeChecker;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Support\ServiceProvider;
use Validator;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('passcheck', function ($attribute, $value, $parameters)
        {
            return Hash::check($value, Auth::user()->getAuthPassword());
        });

        Validator::extend('eligible_age', function ($attribute, $value, $parameters)
        {
            return AgeChecker::isEligibleAge(Carbon::createFromFormat('Y-m-d', $value));
        });

        Validator::extend('unique_team_name_in_current_contest', function ($attribute, $value, $parameters)
        {
            return Contest::current()->teams()->whereName($value)->first() == null;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
