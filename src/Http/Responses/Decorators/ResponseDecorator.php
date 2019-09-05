<?php

namespace Offspring\Responder\Http\Responses\Decorators;

use Offspring\Responder\Contracts\ResponseFactory;
use Illuminate\Http\JsonResponse;


abstract class ResponseDecorator implements ResponseFactory
{
    /**
     * The factory being decorated.
     *
     * @var \Offspring\Responder\Contracts\ResponseFactory
     */
    protected $factory;

    /**
     * Construct the decorator class.
     *
     * @param \Offspring\Responder\Contracts\ResponseFactory $factory
     */
    public function __construct(ResponseFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Generate a JSON response.
     *
     * @param  array $data
     * @param  int   $status
     * @param  array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    abstract public function make(array $data, int $status, array $headers = []): JsonResponse;
}
