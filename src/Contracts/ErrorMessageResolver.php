<?php

namespace Offspring\Responder\Contracts;


interface ErrorMessageResolver
{
    /**
     * Resolve a message from the given error code.
     *
     * @param  mixed $errorCode
     * @return string|null
     */
    public function resolve($errorCode);
}