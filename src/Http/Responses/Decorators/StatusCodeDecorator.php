<?php

namespace Offspring\Responder\Http\Responses\Decorators;

use Illuminate\Http\JsonResponse;


class StatusCodeDecorator extends ResponseDecorator
{
    /**
     * Generate a JSON response.
     *
     * @param  array $data
     * @param  int   $status
     * @param  array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function make(array $data, int $status, array $headers = []): JsonResponse
    {
        return $this->factory->make(array_merge([
            'status' => $status,
        ], $data), $status, $headers);
    }
}
