<?php

namespace Offspring\Responder\Contracts;


interface Responder
{
    /**
     * Build a successful response.
     *
     * @param  mixed                                                          $data
     * @return \Offspring\Responder\Http\Responses\SuccessResponseBuilder
     */
    public function success($data = null, string $resourceKey = null);

    /**
     * Build an error response.
     *
     * @param  mixed|null  $errorCode
     * @param  string|null $message
     * @return \Offspring\Responder\Http\Responses\ErrorResponseBuilder
     */
    public function error($errorCode = null, string $message = null);
}