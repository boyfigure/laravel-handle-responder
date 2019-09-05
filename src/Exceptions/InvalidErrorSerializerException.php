<?php

namespace Offspring\Responder\Exceptions;

use Offspring\Responder\Contracts\ErrorSerializer;
use RuntimeException;


class InvalidErrorSerializerException extends RuntimeException
{
    /**
     * Construct the exception class.
     */
    public function __construct()
    {
        parent::__construct('Serializer must be an instance of [' . ErrorSerializer::class . '].');
    }
}