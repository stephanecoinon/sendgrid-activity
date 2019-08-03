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
$messages = $api->request(
    (new MessagesRequest)
        ->limit(50)
        ->query('status="delivered"')
);
dump($messages);
