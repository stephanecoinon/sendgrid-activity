<?php

namespace StephaneCoinon\SendGridActivity\Integrations\Laravel;

use Illuminate\Support\ServiceProvider;
use StephaneCoinon\SendGridActivity\SendGrid;
use StephaneCoinon\SendGridActivity\Integrations\Framework;

class SendGridApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Framework::laravel();
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SendGrid::class, function ($app) {
            return new SendGrid(config('services.sendgrid.key'));
        });
    }
}
