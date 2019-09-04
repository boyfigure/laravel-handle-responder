<?php

use Offspring\Responder\Contracts\Responder;

if (! function_exists('responder')) {

    function responder(): Responder
    {
        return app(Responder::class);
    }
}
