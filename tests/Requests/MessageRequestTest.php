<?php

namespace StephaneCoinon\SendGridActivity\Tests\Requests;

use StephaneCoinon\SendGridActivity\Requests\MessagesRequest;
use StephaneCoinon\SendGridActivity\Tests\TestCase;

class MessageRequestTest extends TestCase
{
    /** @test */
    function limit_the_number_of_results_to_be_returned()
    {
        $request = (new MessagesRequest)->limit(50);

        $this->assertEquals('messages?limit=50', $request->buildUrl());
    }

    /** @test */
    function limit_is_set_to_10_by_default()
    {
        $request = new MessagesRequest;

        $this->assertEquals('messages?limit=10', $request->buildUrl());
    }

    /** @test */
    function it_url_encodes_the_query_parameter()
    {
        $request = (new MessagesRequest)->query('status="delivered"');

        $this->assertEquals(
            'messages?limit=10&query=status%3D%22delivered%22',
            $request->buildUrl()
        );
    }

    /** @test */
    function build_url_with_a_limit_and_a_query()
    {
        $request = (new MessagesRequest)
            ->limit(50)
            ->query('status="delivered"');

        $this->assertEquals(
            'messages?limit=50&query=status%3D%22delivered%22',
            $request->buildUrl()
        );
    }
}
