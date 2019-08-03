<?php

namespace StephaneCoinon\SendGridActivity\Tests\Support\Stubs;

use StephaneCoinon\SendGridActivity\Requests\Request;

class RequestStub extends Request
{
    protected $response = ResponseStub::class;
}
