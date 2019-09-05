<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Error Message Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the Laravel Responder package.
    | When it generates error responses, it will search the messages array
    | below for any key matching the given error code for the response.
    |
    */

    'unauthenticated' => ['code'=>10001,'message'=>'You are not authenticated for this request.'],
    'unauthorized' => ['code'=>10002,'message'=>'You are not authorized for this request.'],
    'page_not_found' => ['code'=>10003,'message'=>'The requested page does not exist.'],
    'relation_not_found' => ['code'=>10004,'message'=>'The requested relation does not exist.'],
    'validation_failed' => ['code'=>10005,'message'=>'The given data failed to pass validation.'],

];