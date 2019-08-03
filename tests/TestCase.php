<?php

namespace StephaneCoinon\SendGridActivity\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use Support\Traits\LoadsEnv;

    public function setUp(): void
    {
        parent::setUp();

        // $this->loadEnv();
    }
}
