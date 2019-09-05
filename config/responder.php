<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Serializer Class Paths
    |--------------------------------------------------------------------------
    |
    | The full class path to the serializer classes you want to use for both
    | success- and error responses. The success serializer must implement
    | Fractal's serializer. You can override these for every response.
    |
    */

    'serializers' => [
        'success' => \Offspring\Responder\Serializers\SuccessSerializer::class,
        'error' => \Offspring\Responder\Serializers\ErrorSerializer::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Response Decorators
    |--------------------------------------------------------------------------
    |
    | Response decorators are used to decorate both your success- and error
    | responses. A decorator can be disabled by removing it from the list
    | below. You may additionally add your own decorators to the list.
    |
    */

    'decorators' => [
        \Offspring\Responder\Http\Responses\Decorators\PrettyPrintDecorator::class
    ],

    /*
    |--------------------------------------------------------------------------
    | Error Message Translation Files
    |--------------------------------------------------------------------------
    |
    | You can declare error messages in a language file, which allows for
    | returning messages in different languages. The array below lists
    | the language files that will be searched in to find messages.
    |
    */

    'error_message_files' => ['errors'],

];