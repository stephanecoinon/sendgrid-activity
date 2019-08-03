<?php

namespace StephaneCoinon\SendGridActivity\Tests\Support\Factories;

class Factory
{
    protected static $factories = [];

    public static function define($model, $callback)
    {
        static::$factories[$model] = $callback;
    }

    public static function build($model, $attributes = [])
    {
        return new $model(array_merge(
            static::$factories[$model](faker()),
            $attributes)
        );
    }
}
