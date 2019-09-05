<?php

namespace Offspring\Responder\Exceptions;

use RuntimeException;
use Offspring\Responder\Contracts\SuccessSerializer;

class InvalidSuccessSerializerException extends RuntimeException
{
    /**
     * Construct the exception class.
     */
    public function __construct()
    {
        parent::__construct('Serializer must be an instance of [' . SuccessSerializer::class . '].');
    }
}