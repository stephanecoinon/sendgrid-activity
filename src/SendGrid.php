<?php

namespace StephaneCoinon\SendGridActivity;

use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\HttpClient;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use StephaneCoinon\SendGridActivity\HttpClientFactory;
use StephaneCoinon\SendGridActivity\Requests\Request;
use StephaneCoinon\SendGridActivity\Support\Collection;

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
     * Static constructor to get a ApiClient instance with a given HTTP client.
     *
     * @param  \Http\Client\HttpClient $client
     * @return self
     */
    public static function newWithClient(HttpClient $client)
    {
        return new static(null, $client);
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
     * JSON responses are automatically decoded to an array.
     *
     * @param  string $method HTTP method
     * @param  string $url
     * @return string|array|\Illuminate\Support\Collection
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

        return $isJson ? Collection::collect(json_decode($content, true)) : $content;
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

        return $responseModel::createFromApiResponse($response);
    }
}
