<?php

namespace Offspring\Responder\Contracts;


interface Responder
{

    public function success($data = null);


    public function error($errorSlug = null, $errorCode = null, $message = null);
}