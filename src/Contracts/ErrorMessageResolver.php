<?php

namespace Offspring\Responder\Contracts;


interface ErrorMessageResolver
{
    /**
     * Resolve a message from the given error code.
     *
     * @param mixed $errorSlug
     * @param mixed $errorParameter
     * @return string|null
     */
    public function resolve($errorSlug, $errorParameter);
}