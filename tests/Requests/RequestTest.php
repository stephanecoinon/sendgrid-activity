<?php

namespace StephaneCoinon\SendGridActivity\Tests\Requests;

use StephaneCoinon\SendGridActivity\Requests\Request;
use StephaneCoinon\SendGridActivity\Tests\TestCase;

class RequestTest extends TestCase
{
    /** @test */
    function build_url_with_query_string_parameters()
    {
        $request = (new RequestStub)
            ->withParameter('limit', 10)
            ->withParameter('foo', 'bar baz');

        $this->assertEquals(
            'some-endpoint?limit=10&foo=bar%20baz',
            $request->buildUrl()
        );
    }
}

class RequestStub extends Request
{
    protected $endpoint = 'some-endpoint';
}
