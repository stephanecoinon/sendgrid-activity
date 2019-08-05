<?php

namespace StephaneCoinon\SendGridActivity\Integrations\Laravel;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;
use StephaneCoinon\SendGridActivity\Integrations\Framework;
use StephaneCoinon\SendGridActivity\SendGrid;

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
        app(Factory::class)->load(__DIR__ . '/factories');
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
