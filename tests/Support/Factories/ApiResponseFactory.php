<?php

namespace StephaneCoinon\SendGridActivity\Tests\Support\Factories;

use Http\Message\MessageFactory\GuzzleMessageFactory;
use StephaneCoinon\SendGridActivity\Responses\Message;

class ApiResponseFactory
{
    protected $headers = [];

    public function __construct()
    {
        $this->json();
    }

    public function json(): self
    {
        $this->headers['Content-Type'] = 'application/json';

        return $this;
    }

    public function build($payload)
    {
        return (new GuzzleMessageFactory)->createResponse(
            200, '', $this->headers, json_encode($payload)
        );
    }
}
