<?php

namespace StephaneCoinon\SendGridActivity\Tests\Support\Traits;

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

trait LoadsEnv
{
    public function loadEnv()
    {
        try {
            $dotenv = Dotenv::create(__DIR__ . '/../../..');
            $dotenv->load();
        } catch (InvalidPathException $e) {
            // Could not load .env;
        }
    }
}
