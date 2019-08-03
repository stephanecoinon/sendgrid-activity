<?php

namespace StephaneCoinon\SendGridActivity\Tests\Responses;

use Carbon\Carbon;
use StephaneCoinon\SendGridActivity\Responses\Response;
use StephaneCoinon\SendGridActivity\Tests\TestCase;

class ResponseTest extends TestCase
{
    /** @test */
    function cast_datetime_attributes_to_a_carbon_instance()
    {
        $response = new ResponseStub([
            'created' => $now = date('Y-m-d h:i:s')
        ]);

        $this->assertInstanceOf(Carbon::class, $response->created);
        $this->assertEquals($now, $response->created->toDateTimeString());
    }

    /** @test */
    function build_a_collection_of_response_instances()
    {
        $responses = ResponseStub::collection([
            ['id' => 1],
            ['id' => 2],
        ]);

        $this->assertCount(2, $responses);
        $this->assertContainsOnlyInstancesOf(ResponseStub::class, $responses);
        $this->assertEquals([1, 2], array_map(function ($response) {
            return $response->id;
        }, $responses));
    }

    /** @test */
    function convert_one_api_result_to_a_response_instance()
    {
        $response = ResponseStub::createFromApiResponse(['id' => 1]);

        $this->assertInstanceOf(ResponseStub::class, $response);
        $this->assertEquals(1, $response->id);
    }

    /** @test */
    function convert_multiple_api_results_to_an_array_of_response_instances()
    {
        $responses = ResponseStub::createFromApiResponse([
            'items' => [
                ['id' => 1],
                ['id' => 2],
            ]
        ]);

        $this->assertCount(2, $responses);
        $this->assertContainsOnlyInstancesOf(ResponseStub::class, $responses);
        $this->assertEquals([1, 2], array_map(function ($response) {
            return $response->id;
        }, $responses));
    }
}

class ResponseStub extends Response
{
    protected $casts = [
        'created' => 'datetime'
    ];

    protected $dataKey = 'items';
}
