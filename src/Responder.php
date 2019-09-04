<?php

namespace Offspring\Responder;

use Offspring\Responder\Contracts\Responder as ResponderContract;
use Flugg\Responder\Http\Responses\ErrorResponseBuilder;
use Flugg\Responder\Http\Responses\SuccessResponseBuilder;


class Responder implements ResponderContract
{
    public function __construct()
    {
        
    }

    public function success($data = null)
    {
        return 'ssssss';
    }

    public function error($errorCode = null, string $message = null)
    {
        return 'eee';
    }
}