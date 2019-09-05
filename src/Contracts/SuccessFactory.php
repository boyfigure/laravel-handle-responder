<?php

namespace Offspring\Responder\Contracts;


interface SuccessFactory
{
    public function make(SuccessSerializer $serializer, $data = null): array;
}