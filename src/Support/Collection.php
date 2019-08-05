<?php

namespace StephaneCoinon\SendGridActivity\Support;

use StephaneCoinon\SendGridActivity\Integrations\Framework;

/**
 * Cast an array into the framework native collection (or array for vanilla PHP).
 */
class Collection
{
    /**
     * Collection items.
     *
     * @var array|\Illuminate\Support\Collection
     */
    protected $items = [];

    /**
     * Get a new Collection instance.
     *
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = static::collect($items);
    }

    /**
     * Cast an array into the framework native collection.
     *
     * @param array $items
     * @return array|\Illuminate\Support\Collection
     */
    public static function collect(array $items)
    {
        return Framework::isLaravel() ? collect($items) : $items;
    }

    /**
     * Get a new Collection instance.
     *
     * @param array $items
     * @return self
     */
    public static function make(array $items): self
    {
        return new static($items);
    }

    /**
     * Run a map over each of the items.
     *
     * @param  callable $callback
     * @return array|\Illuminate\Support\Collection
     */
    public function map(callable $callback)
    {
        if (Framework::isLaravel()) {
            return $this->items->map($callback);
        }

        return array_map($callback, $this->items);
    }

    /**
     * Undocumented function
     *
     * @return array|\Illuminate\Support\Collection
     */
    public function mapInto(string $model)
    {
        if (Framework::isLaravel()) {
            return $this->items->mapInto($model);
        }

        return array_map(function ($item) use ($model) {
            return new $model($item);
        }, $this->items);
    }
}
