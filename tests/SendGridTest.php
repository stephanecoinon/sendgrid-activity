<?php

namespace StephaneCoinon\SendGridActivity\Tests;

use StephaneCoinon\SendGridActivity\Requests\Request;
use StephaneCoinon\SendGridActivity\Responses\Response;
use StephaneCoinon\SendGridActivity\SendGrid;
use StephaneCoinon\SendGridActivity\Tests\Support\Factories\ApiResponseFactory;

class SendGridTest extends TestCase
{
    /** @test */
    function it_can_make_a_request_from_a_request_instance()
    {
        $sendgrid = SendGrid::mock([
            (new ApiResponseFactory)->build([
                'items' => [
                    new SendGridResponseStub,
                    new SendGridResponseStub,
                    new SendGridResponseStub,
                ]
            ])
        ]);

        $items = $sendgrid->request(new SendGridRequestStub);

        $this->assertCount(3, $items);
        $this->assertContainsOnlyInstancesOf(SendGridResponseStub::class, $items);
    }
}

class SendGridRequestStub extends Request
{
    protected $response = SendGridResponseStub::class;
}

class SendGridResponseStub extends Response
{
    protected $dataKey = 'items';
}
