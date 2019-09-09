<?php

namespace Offspring\Responder\Serializers;

use Offspring\Responder\Contracts\ErrorSerializer as ErrorSerializerContract;


class ErrorSerializer implements ErrorSerializerContract
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

    public function format($errorSlug = null, $errorCode = null, $message = null, array $data = null, $traceId = null): array
    {
        $response = [
            'data' => [
                'error_code' => $errorCode,
                'message' => $message,
                'error_trace_id' => $traceId,
//                'error_subcode' => null,
//                'slug' => $errorSlug,
            ],

        ];
        if (is_array($data)) {
            $response['data'] = array_merge($response['data'], $data);
        }

        return $response;
    }
}
