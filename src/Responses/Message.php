<?php

namespace StephaneCoinon\SendGridActivity\Responses;

class Message extends Response
{
    protected $key = 'msg_id';

    protected $dataKey = 'messages';

    protected $casts =[
        'last_event_time' => 'datetime',
    ];
}
