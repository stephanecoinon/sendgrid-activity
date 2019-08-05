<?php

namespace StephaneCoinon\SendGridActivity\Requests;

use StephaneCoinon\SendGridActivity\Responses\Response;

/**
 * Base request builder.
 */
class Request
{
    /**
     * Endpoint URL.
     *
     * @var string
     */
    protected $endpoint = '';

    /**
     * Response model class to map request results to.
     *
     * @var string
     */
    protected $response = Response::class;

    /**
     * Request method.
     *
     * @var string
     */
    protected $method = 'GET';

    /**
     * Resource unique identifier.
     *
     * @var string
     */
    protected $key = null;

    /**
     * Query string parameters.
     *
     * @var array
     */
    protected $queryStringParameters = [];

    /**
     * Builder a request to fetch a resource by unique identifier.
     *
     * @param  string $key
     * @return self
     */
    public static function find($key): self
    {
        $request = new static;
        $request->key = $key;

        return $request;
    }

    /**
     * Return the HTTP method used for this request.
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Get the response model class to map request result(s) to.
     *
     * @return string
     */
    public function getResponseModel(): string
    {
        return $this->response;
    }

    /**
     * Add a parameter to the query string.
     *
     * @param  string $key
     * @param  mixed $value
     * @return self
     */
    public function withParameter(string $key, $value): self
    {
        $this->queryStringParameters[$key] = $value;

        return $this;
    }

    /**
     * Encode the query string parameters.
     *
     * @param  array $parameters
     * @return string
     */
    protected function encode(array $parameters): string
    {
        return http_build_query(
            $parameters,
            null,
            '&',
            PHP_QUERY_RFC3986 // use percent-encoding
        );
    }

    /**
     * Build the query string.
     *
     * @return string
     */
    protected function buildQueryString(): string
    {
        return $this->encode($this->queryStringParameters);
    }

    /**
     * Build the request URL.
     *
     * @return string
     */
    public function buildUrl(): string
    {
        $queryString = $this->buildQueryString();

        return $this->endpoint
            . ($this->key ? '/' . $this->key : '')
            . ($queryString ? '?' . $queryString : '');
    }
}
