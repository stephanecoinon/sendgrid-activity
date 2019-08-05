<?php

use Carbon\Carbon;
use Faker\Generator as Faker;
use StephaneCoinon\SendGridActivity\Responses\Message;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'from_email' => $faker->safeEmail,
        'msg_id' => $faker->sha1,
        'subject' => $faker->sentence,
        'to_email' => $faker->safeEmail,
        'status' => 'delivered',
        'opens_count' => 0,
        'clicks_count' => 0,
        'last_event_time' => Carbon::instance($faker->dateTime())->toISOString(),
    ];
});
