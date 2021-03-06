<?php

namespace Offspring\Responder\Contracts;


interface ErrorSerializer
{
    /**
     * Format the error data.
     *
     * @param mixed|null $errorSlug
     * @param mixed|null $errorCode
     * @param string|null $message
     * @param array|null $data
     * @param mixed|null $traceId
     * @return array
     */
    public function format($errorSlug = null, $errorCode = null, $message = null, array $data = null, $traceId = null): array;
}