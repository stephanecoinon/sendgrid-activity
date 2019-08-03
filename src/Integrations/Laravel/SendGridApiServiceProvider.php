<?php

namespace StephaneCoinon\SendGridActivity\Integrations\Laravel;

use Illuminate\Support\ServiceProvider;
use StephaneCoinon\SendGridActivity\SendGrid;

class SendGridApiServiceProvider extends ServiceProvider
{
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
