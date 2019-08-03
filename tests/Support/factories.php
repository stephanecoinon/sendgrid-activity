<?php

use Faker\Generator as Faker;
use StephaneCoinon\SendGridActivity\Responses\Message;
use StephaneCoinon\SendGridActivity\Tests\Support\Factories\Factory;

Factory::define(Message::class, function (Faker $faker) {
    return [
        'from_email' => $faker->safeEmail,
        'msg_id' => 'h2WRhxX2Rl22Dg2nqoI_LQ.filter0097p3iad2-15416-5D42C6A6-72.0',
        'subject' => $faker->sentence,
        'to_email' => $faker->safeEmail,
        'status' => 'delivered',
        'opens_count' => 1,
        'clicks_count' => 0,
        'last_event_time' => '2019-08-02T10:33:12Z'
    ];
});
