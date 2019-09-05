<?php

namespace Offspring\Responder\Http\Responses;

use BadMethodCallException;
use Offspring\Responder\Contracts\ResponseFactory;
use InvalidArgumentException;

use Offspring\Responder\Contracts\SuccessFactory;
use Offspring\Responder\Contracts\SuccessSerializer;
use Offspring\Responder\Exceptions\InvalidSuccessSerializerException;

class SuccessResponseBuilder extends ResponseBuilder
{
    /**
     * A HTTP status code for the response.
     *
     * @var int
     */
    protected $status = 200;

    /**
     * A factory for building error data output.
     *
     * @var \Offspring\Responder\Contracts\SuccessFactory
     */
    private $successFactory;

    /**
     * A serializer for formatting error data.
     *
     * @var \Offspring\Responder\Contracts\ErrorSerializer
     */
    protected $serializer;


    /**
     * Additional data included with the error.
     *
     * @var array|null
     */
    protected $data = null;

    /**
     * Construct the builder class.
     *
     * @param \Offspring\Responder\Contracts\ResponseFactory $responseFactory
     * @param \Offspring\Responder\Contracts\SuccessFactory $successFactory
     */
    public function __construct(ResponseFactory $responseFactory, SuccessFactory $successFactory)
    {
        $this->successFactory = $successFactory;
        parent::__construct($responseFactory);
    }

    public function success($data=null)
    {
        $this->data = $data;
        return $this;
    }
    /**
     * Add additional data to the error.
     *
     * @return $this
     */
    public function data($data = null)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Set the error serializer.
     *
     * @param \Offspring\Responder\Contracts\ErrorSerializer|string $serializer
     * @return $this
     * @throws \Offspring\Responder\Exceptions\InvalidErrorSerializerException
     */
    public function serializer($serializer)
    {
        if (is_string($serializer)) {
            $serializer = new $serializer;
        }
        if (!$serializer instanceof SuccessSerializer) {
            throw new InvalidSuccessSerializerException;
        }

        $this->serializer = $serializer;

        return $this;
    }

    /**
     * Get the serialized response output.
     *
     * @return mixed
     */
    protected function getOutput(): array
    {
        return $this->successFactory->make($this->serializer, $this->data);
    }

    /**
     * Validate the HTTP status code for the response.
     *
     * @param int $status
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
