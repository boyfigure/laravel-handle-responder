<?php

namespace Offspring\Responder\Http\Responses\Decorators;

use Illuminate\Http\JsonResponse;


class PrettyPrintDecorator extends ResponseDecorator
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
        $response = $this->factory->make($data, $status, $headers);

        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);

        return $response;
    }
}
