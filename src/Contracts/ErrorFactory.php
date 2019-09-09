<?php

namespace Offspring\Responder\Contracts;


interface ErrorFactory
{
    /**
     * Make an error array from the given error code, message and error data.
     *
     * @param \Offspring\Responder\Contracts\ErrorSerializer $serializer
     * @param mixed|null $errorSlug
     * @param mixed|null $errorCode
     * @param string|null $message
     * @param array|null $data
     * @param mixed|null $traceId
     * @return array
     */
    public function make(ErrorSerializer $serializer, $errorSlug = null, $errorCode = null, $message = null, array $data = null, $traceId = null): array;
}