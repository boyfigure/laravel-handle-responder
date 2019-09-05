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
     * @param  \Offspring\Responder\Contracts\ErrorSerializer $serializer
     * @param  mixed|null                                 $errorCode
     * @param  string|null                                $message
     * @param  array|null                                 $data
     * @return array
     */
    public function make(ErrorSerializer $serializer, $errorCode = null, string $message = null, array $data = null): array
    {
        if (isset($errorCode) && ! isset($message)) {
            $message = $this->messageResolver->resolve($errorCode);
        }

        return $serializer->format($errorCode, $message, $data);
    }
}