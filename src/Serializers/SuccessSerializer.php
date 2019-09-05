<?php

namespace Offspring\Responder\Serializers;

use Offspring\Responder\Contracts\SuccessSerializer as SuccessSerializerContract;

class SuccessSerializer implements SuccessSerializerContract
{
    public function format($data = null): array
    {
        $response = [
            'data' => $data,
        ];

//        if (is_array($data)) {
//            $response['error'] = array_merge($response['error'], $data);
//        }

        return $response;
    }
}
