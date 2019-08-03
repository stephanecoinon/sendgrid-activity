<?php

use Faker\Factory as Faker;
use StephaneCoinon\SendGridActivity\Tests\Support\Factories\Factory;

function faker($locale = Faker::DEFAULT_LOCALE)
{
    return Faker::create($locale);
}

function factory($model, $attributes = []) {
    return Factory::build($model, $attributes);
}
