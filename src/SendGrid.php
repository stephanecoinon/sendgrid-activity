<?php

namespace StephaneCoinon\SendGridActivity;

use Http\Mock\Client as MockClient;
use StephaneCoinon\SendGridActivity\ApiClient;
use StephaneCoinon\SendGridActivity\Requests\Request;

/**
 * SendGrid API client.
 */
class SendGrid
{
    /**
     * Underlying HTTP client.
     *
     * @var \StephaneCoinon\SendGridActivity\ApiClient
     */
    protected $api;

    /**
     * Get a new SendGrid instance.
     *
     * If $api is null, a new ApiClient instance will be used instead.
     *
     * @param null|ApiClient $api
     */
    public function __construct(ApiClient $api = null)
    {
        $this->api = $api ?? new ApiClient;
    }

    /**
     * Mock the SendGrid API.
     *
     * @param  array $responses
     * @return self
     */
    public static function mock(array $responses = []): self
    {
        $client = new MockClient;

        foreach ($responses as $response) {
            $client->addResponse($response);
        }

        return new static(ApiClient::newWithClient($client));
    }

    /**
     * Make an HTTP request.
     *
     * @param  Request $request
     * @return Response|Response[]
     */
    public function request(Request $request)
    {
        return $this->api->makeRequest($request);
    }
}
