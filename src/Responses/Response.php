<?php

namespace StephaneCoinon\SendGridActivity\Responses;

use Carbon\Carbon;
use StephaneCoinon\SendGridActivity\Support\Collection;

/**
 * Data model for API response results.
 */
class Response
{
    /**
     * Name of the key containing the unique resource id.
     *
     * @var string
     */
    protected $key = 'id';

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
    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    /**
     * Build a collection of Response models from an array.
     *
     * @param  array $items raw array of results from API response
     * @param  array $apiContext
     * @return static[]|Collection
     */
    public static function collection(array $items = [], array $apiContext = [])
    {
        return Collection::make($items)->map(function ($item) use ($apiContext) {
            return (new static($item))->fill($apiContext);
        });
    }

    /**
     * Fill the response with an array of attributes.
     *
     * @param  array $attributes
     * @return self
     */
    public function fill(array $attributes = []): self
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    /**
     * Get the value of an attribute.
     *
     * @param  string $name
     * @return mixed
     */
    public function getAttribute(string $name)
    {
        return $this->$name ?? null;
    }

    /**
     * Set the value of an attribute.
     *
     * @param  string $name
     * @param  mixed $value
     * @return self
     */
    public function setAttribute(string $name, $value): self
    {
        $this->$name = $this->castAttribute($name, $value);

        return $this;
    }

    /**
     * Get the name of the resource unique identifier key.
     *
     * @return string
     */
    public function getKeyName()
    {
        return $this->key;
    }

    /**
     * Get the value of the resource unique identifer.
     *
     * @return mixed
     */
    public function getKey()
    {
        return $this->getAttribute($this->getKeyName());
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
     * @param  array $apiContext
     * @return static|static[]
     */
    public static function createFromApiResponse($apiResponse, array $apiContext = [])
    {
        $dataKey = (new static)->dataKey;

        return isset($apiResponse[$dataKey])
            // Collection of items nested under the data key
            ? static::collection($apiResponse[$dataKey], $apiContext)
            // Single item
            : (new static($apiResponse))->fill($apiContext);
    }

    /**
     * Fetch a fresh resource.
     *
     * @return self
     */
    public function fresh(): self
    {
        return $this->api->request($this->request::find($this->getKey()));
    }
}
