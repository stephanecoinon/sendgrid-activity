<?php

namespace StephaneCoinon\SendGridActivity\Integrations;

class Framework
{
    const PHP = 'PHP';
    const LARAVEL = 'Laravel';

    protected static $name = 'PHP';

    public static function setName(string $name)
    {
        static::$name = $name;
    }

    public static function php()
    {
        static::setName(static::PHP);
    }

    public static function isPhp(): bool
    {
        return static::$name == static::PHP;
    }

    public static function laravel()
    {
        static::setName(static::LARAVEL);
    }

    public static function isLaravel(): bool
    {
        return static::$name == static::LARAVEL;
    }
}
