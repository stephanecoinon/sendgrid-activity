<?php

namespace StephaneCoinon\SendGridActivity\Tests\Integrations;

use Http\Mock\Client as MockClient;
use Illuminate\Support\Collection;
use StephaneCoinon\SendGridActivity\Integrations\Framework;
use StephaneCoinon\SendGridActivity\SendGrid;
use StephaneCoinon\SendGridActivity\Tests\LaravelTestCase;
use StephaneCoinon\SendGridActivity\Tests\Support\Factories\ApiResponseFactory;
use StephaneCoinon\SendGridActivity\Tests\Support\Stubs\RequestStub;
use StephaneCoinon\SendGridActivity\Tests\Support\Stubs\ResponseStub;

class LaravelTest extends LaravelTestCase
{
    /** @test */
    function laravel_framework_is_detected()
    {
        $this->assertTrue(Framework::isLaravel());
    }

    /** @test */
    function request_returns_a_collection_instead_of_an_array_in_laravel()
    {
        $this->assertTrue(Framework::isLaravel());
        $api = $this->mockApiResponse([
            'items' => [['id' => 1], ['id' => 2], ['id' => 3]]
        ]);

        $responses = $api->request(new RequestStub);

        $this->assertInstanceOf(Collection::class, $responses);
        $this->assertCount(3, $responses);
        $this->assertContainsOnlyInstancesOf(ResponseStub::class, $responses);
        $this->assertEquals([1, 2, 3], $responses->pluck('id')->all());
    }

    function mockApiResponse(array $response): SendGrid
    {
        $client = new MockClient;
        $client->addResponse((new ApiResponseFactory)->json()->build($response));

        return app(SendGrid::class)->withClient($client);
    }
}
