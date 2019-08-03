<?php

namespace StephaneCoinon\SendGridActivity\Tests;

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // $this->loadEnv();
    }

    public function loadEnv()
    {
        try {
            $dotenv = Dotenv::create(__DIR__ . '/..');
            $dotenv->load();
        } catch (InvalidPathException $e) {
            // Could not load .env;
        }
    }
}
