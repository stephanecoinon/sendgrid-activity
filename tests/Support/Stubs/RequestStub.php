<?php

namespace StephaneCoinon\SendGridActivity\Tests\Support\Stubs;

use StephaneCoinon\SendGridActivity\Requests\Request;

class RequestStub extends Request
{
    protected $endpoint = 'some-endpoint';

    protected $response = ResponseStub::class;
}
