<?php

namespace Offspring\Responder\Contracts;


interface ErrorSerializer
{
    /**
     * Format the error data.
     *
     * @param  mixed|null  $errorCode
     * @param  string|null $message
     * @param  array|null  $data
     * @return array
     */
    public function format($errorCode = null, string $message = null, array $data = null): array;
}