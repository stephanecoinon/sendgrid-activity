<?php

namespace StephaneCoinon\SendGridActivity\Tests\Integrations;

use StephaneCoinon\SendGridActivity\Integrations\Framework;
use StephaneCoinon\SendGridActivity\Tests\TestCase;

class VanillaPhpTest extends TestCase
{
    /** @test */
    function vanilla_php_is_detected()
    {
        $this->assertTrue(Framework::isPhp());
    }
}
