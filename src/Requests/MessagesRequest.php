<?php

namespace StephaneCoinon\SendGridActivity\Requests;

use StephaneCoinon\SendGridActivity\Requests\Request;
use StephaneCoinon\SendGridActivity\Responses\Message;

/**
 * Request builder for "/messages" endpoint.
 *
 * @see https://sendgrid.api-docs.io/v3.0/email-activity/filter-all-messages
 */
class MessagesRequest extends Request
{
    protected $endpoint = 'messages';

    protected $response = Message::class;

    /**
     * The parameter named "query" in the query string.
     *
     * It is encoded separately from the other parameters on the query string.
     *
     * @var string
     */
    protected $query = '';

    public function __construct()
    {
        $this->limit(10);
    }

    /**
     * Set the number of results returned per page.
     *
     * @param  int $limit
     * @return self
     */
    public function limit($limit): self
    {
        return $this->withParameter('limit', $limit);
    }

    /**
     * Set the "query" parameter.
     *
     * @param  string $query
     * @return self
     */
    public function query(string $query): self
    {
        return $this->withParameter('query', $query);
    }
}
