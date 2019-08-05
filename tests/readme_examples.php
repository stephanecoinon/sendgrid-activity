<?php

// Bootstrap

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::create(__DIR__ . '/..');
$dotenv->load();


// Usage example in read me

use StephaneCoinon\SendGridActivity\Requests\MessagesRequest;
use StephaneCoinon\SendGridActivity\SendGrid;

$api = new SendGrid();

// Fetch the message activity
$messages = $api->request(
    (new MessagesRequest)
        ->limit(50)
        ->query('status="delivered"')
);
dump(['Fetch the message activity' => $messages]);

// Find a message by id
$message = $api->request(MessagesRequest::find($messages[0]->msg_id));
dump(['Find a message by id' => $message]);
