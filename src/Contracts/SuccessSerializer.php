<?php

namespace Offspring\Responder\Contracts;


interface SuccessSerializer
{
    /**
     * Format the error data.
     *
     * @param   $data
     * @return array
     */
    public function format($data = null): array;
}