<?php

namespace Offspring\Responder;

use Offspring\Responder\Contracts\Responder as ResponderContract;
use Offspring\Responder\Http\Responses\ErrorResponseBuilder;
use Offspring\Responder\Http\Responses\SuccessResponseBuilder;


class Responder implements ResponderContract
{
    /**
     * A builder for building success responses.
     *
     * @var \Offspring\Responder\Http\Responses\SuccessResponseBuilder
     */
    protected $successResponseBuilder;

    /**
     * A builder for building error responses.
     *
     * @var \Offspring\Responder\Http\Responses\ErrorResponseBuilder
     */
    protected $errorResponseBuilder;

    /**
     * Construct the service class.
     *
     * @param \Offspring\Responder\Http\Responses\SuccessResponseBuilder $successResponseBuilder
     * @param \Offspring\Responder\Http\Responses\ErrorResponseBuilder $errorResponseBuilder
     */
    public function __construct(SuccessResponseBuilder $successResponseBuilder, ErrorResponseBuilder $errorResponseBuilder)
    {
        $this->successResponseBuilder = $successResponseBuilder;
        $this->errorResponseBuilder = $errorResponseBuilder;
    }

    /**
     * Build a successful response.
     *
     * @param mixed $data
     * @return \Offspring\Responder\Http\Responses\SuccessResponseBuilder
     */
    public function success($data = null): SuccessResponseBuilder
    {
        return $this->successResponseBuilder->success($data);
    }

    /**
     * Build an error response.
     * @param mixed|null $errorSlug
     * @param mixed|null $errorCode
     * @param string|null $message
     *  @param mixed|null $errorParameter
     * @return \Offspring\Responder\Http\Responses\ErrorResponseBuilder
     */
    public function error($errorSlug = null, $errorCode = null, $message = null, $errorParameter = []): ErrorResponseBuilder
    {
        //array to string
        if (is_array($message)) {
            $message = $this->implodeMessageBag($message);
        }

        return $this->errorResponseBuilder->error($errorSlug, $errorCode, $message, $errorParameter);
    }

    protected function implodeMessageBag(array $messages = [])
    {
        $new_messages = [];
        foreach ($messages as $field => $message) {
            if (is_array($message) && count($message) > 0) {
                $new_messages = $new_messages + $message;
            } elseif (is_string($message)) {
                $new_messages[] = $message;
            }
        }

        return implode(', ', $new_messages);
    }


}