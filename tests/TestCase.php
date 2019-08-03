<?php

namespace StephaneCoinon\SendGridActivity\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use StephaneCoinon\SendGridActivity\Integrations\Framework;

class TestCase extends BaseTestCase
{
    use Support\Traits\LoadsEnv;

    public function setUp(): void
    {
        Framework::php();

        parent::setUp();

        // $this->loadEnv();
    }
}
