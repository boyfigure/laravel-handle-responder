<?php

namespace Offspring\Responder\Contracts;


interface SuccessSerializer
{
    /**
     * Format the error data.
     *
     * @param  array|null  $data
     * @return array
     */
    public function format(array $data = null): array;
}