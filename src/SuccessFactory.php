<?php

namespace Offspring\Responder;

use Offspring\Responder\Contracts\SuccessFactory as SuccessFactoryContract;
use Offspring\Responder\Contracts\SuccessSerializer;


class SuccessFactory implements SuccessFactoryContract
{


    /**
     * Construct the factory class.
     *
     */
    public function __construct()
    {

    }

    /**
     * Make an error array from the given error code and message.
     *
     * @param  \Offspring\Responder\Contracts\SuccessSerializer $serializer
     * @param  array|null                                 $data
     * @return array
     */
    public function make(SuccessSerializer $serializer, array $data = null): array
    {
        return $serializer->format($data);
    }
}