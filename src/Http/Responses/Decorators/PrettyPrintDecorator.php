<?php

namespace Offspring\Responder\Http\Responses\Decorators;

use Illuminate\Http\JsonResponse;


class PrettyPrintDecorator extends ResponseDecorator
{
    /**
     * Generate a JSON response.
     *
     * @param array $data
     * @param int $status
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function make(array $data, int $status, array $headers = []): JsonResponse
    {

        $response = $this->factory->make(
            array_merge([
                    'success' => $status >= 100 && $status < 400,
                    'status' => $status,
                ]
                , $data), $status, $headers);

        $response->setEncodingOptions( JSON_PRETTY_PRINT);

        return $response;
    }
}
