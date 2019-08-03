<?php

namespace StephaneCoinon\SendGridActivity\Responses;

use Carbon\Carbon;

/**
 * Data model for API response results.
 */
class Response
{
    /**
     * Attributes to cast to a native type.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Name of key under which multiple results are nested.
     *
     * @var string
     */
    protected $dataKey = '';

    /**
     * Make a new Response instance.
     *
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        foreach ($attributes as $key => $value) {
            $this->$key = $this->castAttribute($key, $value);
        }
    }

    /**
     * Build a collection of Response models from an array.
     *
     * @param  mixed $items raw array of results from API response
     * @return static[]
     */
    public static function collection(array $items = []): array
    {
        return array_map(function ($item) {
            return new static($item);
        }, $items);
    }

    /**
     * Cast an attribute to its native type.
     *
     * This method uses the types declared in static::$casts.
     *
     * @param  string $key
     * @param  mixed $value
     * @return self
     */
    public function castAttribute($key, $value)
    {
        switch ($this->casts[$key] ?? null) {
            case 'datetime':
                return Carbon::parse($value);
        }

        return $value;
    }

    /**
     * Cast a JSON-decoded API response to Response instance(s)
     *
     * @param  array $apiResponse
     * @return static|static[]
     */
    public static function createFromApiResponse($apiResponse)
    {
        $dataKey = (new static)->dataKey;

        return isset($apiResponse[$dataKey])
            // Collection of items nested under the data key
            ? static::collection($apiResponse[$dataKey])
            // Single item
            : new static($apiResponse);
    }
}
