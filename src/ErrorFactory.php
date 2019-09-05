<?php

namespace Offspring\Responder;

use Offspring\Responder\Contracts\ErrorFactory as ErrorFactoryContract;
use Offspring\Responder\Contracts\ErrorMessageResolver as ErrorMessageResolverContract;
use Offspring\Responder\Contracts\ErrorSerializer;


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
     * @return array
     */
    public function make(ErrorSerializer $serializer, $errorSlug = null, $errorCode = null, string $message = null, array $data = null): array
    {

        if (isset($errorSlug) && (!isset($errorCode) || !isset($message))) {
            $data = $this->messageResolver->resolve($errorSlug);
            if (!isset($message) && isset($data['message'])) {
                $message = $data['message'];
            }
            if (!isset($errorCode) && isset($data['code'])) {
                $errorCode = $data['code'];
            }
        }
        return $serializer->format($errorSlug, $errorCode, $message, $data);
    }
}