<?php

namespace Offspring\Responder;

use Offspring\Responder\Contracts\ErrorMessageResolver as ErrorMessageResolverContract;
use Illuminate\Translation\Translator;


class ErrorMessageResolver implements ErrorMessageResolverContract
{
    /**
     * A serivce for resolving messages from language files.
     *
     * @var \Illuminate\Translation\Translator
     */
    protected $translator;

    /**
     * A list of registered messages mapped to error codes.
     *
     * @var array
     */
    protected $messages = [];

    /**
     * Construct the resolver class.
     *
     * @param \Illuminate\Translation\Translator $translator
     */
    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Register a message mapped to an error code.
     *
     * @param  mixed  $errorSlug
     * @param  string $message
     * @return void
     */
    public function register($errorSlug, $message)
    {
        $this->messages = array_merge($this->messages, is_array($errorSlug) ? $errorSlug : [
            $errorSlug => $message,
        ]);
    }

    /**
     * Resolve a message from the given error code.
     *
     * @param  mixed $errorCode
     * @return string|null
     */
    public function resolve($errorSlug)
    {
        if (key_exists($errorSlug, $this->messages)) {
            return $this->messages[$errorSlug];
        }

        if ($this->translator->has($errorSlug = "errors.$errorSlug")) {
            return $this->translator->trans($errorSlug);
        }

        return null;
    }
}