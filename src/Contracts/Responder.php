<?php

namespace Offspring\Responder\Contracts;


interface Responder
{

    public function success($data = null);


    public function error($errorCode = null, string $message = null);
}