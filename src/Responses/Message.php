<?php

namespace StephaneCoinon\SendGridActivity\Responses;

class Message extends Response
{
    protected $dataKey = 'messages';

    protected $casts =[
        'last_event_time' => 'datetime',
    ];
}
