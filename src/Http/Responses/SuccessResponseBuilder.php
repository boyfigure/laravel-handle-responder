<?php

namespace Offspring\Responder\Http\Responses;

use BadMethodCallException;
use Offspring\Responder\Contracts\ResponseFactory;
use InvalidArgumentException;


class SuccessResponseBuilder extends ResponseBuilder
{
    /**
     * A HTTP status code for the response.
     *
     * @var int
     */
    protected $status = 200;

    /**
     * Construct the builder class.
     *
     * @param \Offspring\Responder\Contracts\ResponseFactory $responseFactory
     */
    public function __construct(ResponseFactory $responseFactory)
    {
        parent::__construct($responseFactory);
    }

    /**
     * Get the serialized response output.
     *
     * @return mixed
     */
    protected function getOutput(): array
    {

        return $this->collection();
    }

    /**
     * Validate the HTTP status code for the response.
     *
     * @param  int $status
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function validateStatusCode(int $status)
    {
        if ($status < 100 || $status >= 400) {
            throw new InvalidArgumentException("{$status} is not a valid success HTTP status code.");
        }
    }
}
