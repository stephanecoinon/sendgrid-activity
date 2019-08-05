<?php

namespace StephaneCoinon\SendGridActivity\Integrations\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class SendGrid extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \StephaneCoinon\SendGridActivity\SendGrid::class;
    }
}
