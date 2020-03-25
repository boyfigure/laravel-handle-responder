<?php

namespace Offspring\Responder;

use Offspring\Responder\Contracts\ErrorFactory as ErrorFactoryContract;
use Offspring\Responder\Contracts\ErrorMessageResolver as ErrorMessageResolverContract;
use Offspring\Responder\Contracts\ErrorSerializer;
use Illuminate\Support\Facades\Log;


class ErrorFactory implements ErrorFactoryContract
{
    /**
     * A resolver for resolving messages from error codes.
     *
     * @var \Offspring\Responder\Contracts\ErrorMessageResolver
     */
    protected $messageResolver;

    /**
     * Construct the factory class.
     *
     * @param \Offspring\Responder\Contracts\ErrorMessageResolver $messageResolver
     */
    public function __construct(ErrorMessageResolverContract $messageResolver)
    {
        $this->messageResolver = $messageResolver;
    }

    /**
     * Make an error array from the given error code and message.
     *
     * @param \Offspring\Responder\Contracts\ErrorSerializer $serializer
     * @param mixed|null $errorSlug
     * @param mixed|null $errorCode
     * @param string|null $message
     * @param array|null $data
     * @param mixed|null $traceId
     * @param mixed|null $exception
     * @param mixed|null $errorParameter
     * @return array
     */
    public function make(ErrorSerializer $serializer, $errorSlug = null, $errorCode = null, $message = null, array $data = null, $traceId = null, $exception = null, $errorParameter = []): array
    {

        if (isset($errorSlug) && (!isset($errorCode) || !isset($message))) {
            $errorData = $this->messageResolver->resolve($errorSlug, $errorParameter);
            if (!isset($message) && isset($errorData['message'])) {
                $message = $errorData['message'];
            }
            if (!isset($errorCode) && isset($errorData['code'])) {
                $errorCode = $errorData['code'];
            }
        }
        if (isset($traceId)) {
            $this->saveLog($traceId, $exception, $errorSlug, $errorCode, $message, $data);
        }
        return $serializer->format($errorSlug, $errorCode, $message, $data, $traceId);
    }

    public function saveLog($traceId, $exception, $errorSlug, $errorCode, $message, $data)
    {
        $exception['error_trace_id'] = $traceId;
        $exception['error_code'] = $errorCode;
        $exception['error_message'] = $message;
        $exception['error_slug'] = $errorSlug;
        $exception['data'] = $data;

        Log::debug($exception);

        return true;
    }
}