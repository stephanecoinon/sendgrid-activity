<?php

namespace StephaneCoinon\SendGridActivity;

use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\HttpClient;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use StephaneCoinon\SendGridActivity\HttpClientFactory;
use StephaneCoinon\SendGridActivity\Integrations\Framework;
use StephaneCoinon\SendGridActivity\Requests\Request;
use StephaneCoinon\SendGridActivity\Support\Testing\ApiResponseFactory;

/**
 * SendGrid API client.
 */
class SendGrid
{
    /**
     * API base URL.
     *
     * @var string
     */
    protected $apiUrl = 'https://api.sendgrid.com';

    /**
     * API version.
     *
     * @var string
     */
    protected $apiVersion = 'v3';

    /**
     * Underlying HTTP client.
     *
     * @var \Http\Client\HttpClient
     */
    protected $client;

    /**
     * Message factory.
     *
     * @var \Http\Message\MessageFactory
     */
    protected $messageFactory;

    /**
     * Make a new ApiClient instance.
     *
     * If $client is null, a new HttpClient using $apiKey is instantiated.
     * If $apiKey is null, SENDGRID_API_KEY environment variable is used.
     * $apiKey is not used when $client is specified.
     *
     * @param null|string $apiKey
     * @param null|\Http\Client\HttpClient $client
     */
    public function __construct($apiKey = null, HttpClient $client = null)
    {
        $this->messageFactory = MessageFactoryDiscovery::find();
        $this->client = $client ?? HttpClientFactory::create(
            $apiKey ?? getenv('SENDGRID_API_KEY'),
            [
                new BaseUriPlugin(
                    UriFactoryDiscovery::find()->createUri($this->apiUrl)
                )
            ]
        );
    }

    /**
     *
     * @return self
     */

    /**
     * Get a new SendGrid instance.
     *
     * @param null|string $apiKey
     * @param null|\Http\Client\HttpClient $client
     * @return self
     */
    public static function newInstance($apiKey = null, HttpClient $client = null): self
    {
        return Framework::isLaravel()
            ? app(static::class)
            : new static($apiKey, $client);
    }

    /**
     * Static constructor to get a ApiClient instance with a given HTTP client.
     *
     * @param  \Http\Client\HttpClient $client
     * @return self
     */
    public static function newWithClient(HttpClient $client): self
    {
        return static::newInstance()->withClient($client);
    }

    /**
     * Get a new SendGrid instance with a mock client pre-loaded with HTTP responses.
     *
     * @param  array $responses
     * @return self
     */
    public static function mock(array $responses): self
    {
        $client = new \Http\Mock\Client;
        foreach ($responses as $response) {
            $client->addResponse((new ApiResponseFactory)->json()->build($response));
        }

        return static::newWithClient($client);
    }

    /**
     * Set the underlying HTTP client.
     *
     * @param  \Http\Client\HttpClient $client
     * @return self
     */
    public function withClient(HttpClient $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get underlying HTTP client.
     *
     * @return \Http\Client\HttpClient
     */
    public function getClient(): HttpClient
    {
        return $this->client;
    }

    /**
     * Make a "raw" HTTP request.
     *
     * JSON responses are automatically decoded.
     *
     * @param  string $method HTTP method
     * @param  string $url
     * @return string|array
     */
    public function requestRaw(string $method, string $url = '')
    {
        $response = $this->client->sendRequest(
            $this->messageFactory->createRequest(
                $method, "{$this->apiVersion}/{$url}"
            )
        );

        if ($response->getStatusCode() != 200) {
            var_dump(['request failed' => $response->getBody()->getContents()]); die();
            // throw new \Exception('Request failed');
        }

        $content = $response->getBody()->getContents();
        $contentType = $response->getHeader('Content-Type');
        $isJson = in_array('application/json', $contentType);

        return $isJson ? json_decode($content, true) : $content;
    }

    /**
     * Make a request using a Request instance.
     *
     * @param  Request $request
     * @return Response|Response[]
     */
    public function request(Request $request)
    {
        $responseModel = $request->getResponseModel();
        $response = $this->requestRaw(
            $request->getMethod(), $request->buildUrl()
        );

        return $responseModel::createFromApiResponse($response, [
            'api' => $this,
            'request' => $request,
        ]);
    }
}
