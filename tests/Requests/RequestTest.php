<?php

namespace StephaneCoinon\SendGridActivity\Tests\Requests;

use StephaneCoinon\SendGridActivity\Tests\Support\Stubs\RequestStub;
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

    /** @test */
    function build_url_with_unique_resource_id()
    {
        $request = (new RequestStub)->find('some-id');

        $this->assertEquals('some-endpoint/some-id', $request->buildUrl());
    }
}
