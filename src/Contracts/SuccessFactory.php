<?php

namespace Offspring\Responder\Contracts;


interface SuccessFactory
{
    /**
     * Make an error array from the given error code, message and error data.
     *
     * @param  \Offspring\Responder\Contracts\SuccessSerializer $serializer
     * @param  array|null                                 $data
     * @return array
     */
    public function make(SuccessSerializer $serializer, array $data = null): array;
}