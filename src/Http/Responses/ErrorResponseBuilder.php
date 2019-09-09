<?php

namespace Offspring\Responder\Http\Responses;

use Offspring\Responder\Contracts\ErrorFactory;
use Offspring\Responder\Contracts\ErrorSerializer;
use Offspring\Responder\Contracts\ResponseFactory;
use Offspring\Responder\Exceptions\InvalidErrorSerializerException;
use InvalidArgumentException;
use Illuminate\Support\Facades\Log;


class ErrorResponseBuilder extends ResponseBuilder
{
    /**
     * A factory for building error data output.
     *
     * @var \Offspring\Responder\Contracts\ErrorFactory
     */
    private $errorFactory;

    /**
     * A serializer for formatting error data.
     *
     * @var \Offspring\Responder\Contracts\ErrorSerializer
     */
    protected $serializer;

    /**
     * A code representing the error.
     *
     * @var string|null
     */
    protected $errorCode = null;

    /**
     * A slug representing the error.
     *
     * @var string|null
     */
    protected $errorSlug = null;

    /**
     * A message descibing the error.
     *
     * @var mixed|null
     */
    protected $message = null;

    /**
     * Additional data included with the error.
     *
     * @var array|null
     */
    protected $data = null;

    /**
     * Additional $traceId included with the error.
     *
     * @var mixed | null
     */
    protected $traceId = null;

    /**
     * A HTTP status code for the response.
     *
     * @var int
     */
    protected $status = 400;

    /**
     * Construct the builder class.
     *
     * @param \Offspring\Responder\Contracts\ResponseFactory $responseFactory
     * @param \Offspring\Responder\Contracts\ErrorFactory $errorFactory
     */
    public function __construct(ResponseFactory $responseFactory, ErrorFactory $errorFactory)
    {
        $this->errorFactory = $errorFactory;

        parent::__construct($responseFactory);
    }

    /**
     * Set the error code and message.
     *
     * @param mixed|null $errorSlug
     * @param mixed|null $errorCode
     * @param string|null $message
     * @return $this
     */
    public function error($errorSlug = null, $errorCode = null, $message = null)
    {
        $this->errorSlug = $errorSlug;
        $this->errorCode = $errorCode;
        $this->message = $message;

        return $this;
    }

    /**
     * Add additional data to the error.
     *
     * @param array|null $data
     * @return $this
     */
    public function data(array $data = null)
    {
        $this->data = array_merge((array)$this->data, (array)$data);

        return $this;
    }

    public function log($exception)
    {
        $this->traceId = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, config('responder.length_error_tracking_id'));
        if ($exception instanceof \Exception) {
            $exception = [
                'error_trace_id' => $this->traceId,
                'data' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'system_error_code' => $exception->getCode(),
                'trace' => $exception->getTraceAsString(),
            ];
        } elseif (is_object($exception)) {
            $exception->error_trace_id = $this->traceId;

        } elseif (is_array($exception)) {
            $exception['error_trace_id'] = $this->traceId;

        } else {
            $exception = [
                'error_trace_id' => $this->traceId,
                'data' => $exception
            ];
        }
        Log::debug($exception);

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

        if (!$serializer instanceof ErrorSerializer) {
            throw new InvalidErrorSerializerException;
        }

        $this->serializer = $serializer;

        return $this;
    }

    /**
     * Get the serialized response output.
     *
     * @return array
     */
    protected function getOutput(): array
    {
        return $this->errorFactory->make($this->serializer, $this->errorSlug, $this->errorCode, $this->message, $this->data, $this->traceId);
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
        if ($status < 400 || $status >= 600) {
            throw new InvalidArgumentException("{$status} is not a valid error HTTP status code.");
        }
    }
}
