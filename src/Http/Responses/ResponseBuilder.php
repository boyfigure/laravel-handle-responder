<?php

namespace Offspring\Responder\Http\Responses;

use Offspring\Responder\Contracts\ResponseFactory;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;


abstract class ResponseBuilder implements Arrayable, Jsonable
{
    /**
     * A factory for making responses.
     *
     * @var \Flugg\Responder\Contracts\ResponseFactory
     */
    protected $responseFactory;

    /**
     * A HTTP status code for the response.
     *
     * @var int
     */
    protected $status;

    /**
     * Construct the builder class.
     *
     * @param \Flugg\Responder\Contracts\ResponseFactory $responseFactory
     */
    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }


    /**
     * Respond with a successful response.
     *
     * @param  int|null $status
     * @param  array    $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond(int $status = null, array $headers = []): JsonResponse
    {
        if (! is_null($status)) {
            $this->setStatusCode($status);
        }

        return $this->responseFactory->make($this->getOutput(), $this->status, $headers);
    }

    /**
     * Convert the response to an array.
     *
     * @return array
     */
    public function toArray(int $status = null): array
    {
        return $this->respond($status)->getData(true);
    }

    /**
     * Convert the response to an Illuminate collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function toCollection(): Collection
    {
        return new Collection($this->toArray());
    }

    /**
     * Convert the response to JSON.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Set the HTTP status code for the response.
     *
     * @param  int $status
     * @return void
     */
    protected function setStatusCode(int $status)
    {
        $this->validateStatusCode($this->status = $status);
    }

    /**
     * Get the serialized response output.
     *
     * @return array
     */
    abstract protected function getOutput(): array;

    /**
     * Convert the response to an array.
     *
     * @param  int $status
     * @return void
     */
    abstract protected function validateStatusCode(int $status);
}
