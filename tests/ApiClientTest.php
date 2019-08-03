<?php

namespace StephaneCoinon\SendGridActivity\Tests;

use Http\Mock\Client as MockClient;
use StephaneCoinon\SendGridActivity\ApiClient;
use StephaneCoinon\SendGridActivity\Requests\Request;
use StephaneCoinon\SendGridActivity\Responses\Response;
use StephaneCoinon\SendGridActivity\Tests\Support\Factories\ApiResponseFactory;

class ApiClientTest extends TestCase
{
    /** @test */
    function return_json_response_as_an_array()
    {
        $api = $this->mockApiResponse(
            $item = ['id' => 1, 'email' => 'john@example.com']
        );

        $response = $api->request('GET', '/some-endpoint');

        $this->assertEquals($item, $response);
    }

    /** @test */
    function making_a_request_from_a_request_instance_returns_response_instances()
    {
        $api = $this->mockApiResponse([
            'items' => [['id' => 1], ['id' => 2], ['id' => 3]]
        ]);

        $responses = $api->makeRequest(new RequestStub);

        $this->assertCount(3, $responses);
        $this->assertContainsOnlyInstancesOf(ResponseStub::class, $responses);
        $this->assertEquals([1, 2, 3], array_map(function ($response) {
            return $response->id;
        }, $responses));
    }

    function mockApiResponse(array $response): ApiClient
    {
        $client = new MockClient;
        $client->addResponse((new ApiResponseFactory)->json()->build($response));

        return ApiClient::newWithClient($client);
    }
}

class RequestStub extends Request
{
    protected $response = ResponseStub::class;
}

class ResponseStub extends Response
{
    protected $dataKey = 'items';
}
