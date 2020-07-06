<?php

use Offspring\Responder\Contracts\Responder;
use Illuminate\Support\Facades\Log;

if (!function_exists('responder')) {

    function responder(): Responder
    {
        return app(Responder::class);
    }
}
if (!function_exists('capture_error_log')) {

    function capture_error_log($exception, $traceId = null, $data_extra = [], $tag = 'exception', $sensitiveData = ['password', 'card_number', 'cvv'])
    {
        $bt = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $request = app('request')->all() ?? [];
        if (!empty($sensitiveData)) {
            foreach ($sensitiveData as $k => $v) {
                if (isset($request[$v])) {
                    $request[$v] = '***';
                }
            }
        }
        if ($exception instanceof Exception) {
            Log::error(
                json_encode([
                    'tag' => $tag ?? 'exception',
                    'error_trace_id' => $traceId ?? '',
                    'function' => $bt[1]['function'] ?? '',
                    'class' => $bt[1]['class'] ?? '',
                    'file' => $exception->getFile() ?? '',
                    'line' => $exception->getLine() ?? '',
                    'message' => $exception->getMessage() ?? '',
                    'request' => $request,
                    'data_extra' => $data_extra
                ]));
        } else {
            Log::error(
                json_encode([
                    'tag' => $tag ?? 'exception',
                    'error_trace_id' => $traceId ?? '',
                    'function' => $bt[1]['function'] ?? '',
                    'class' => $bt[1]['class'] ?? '',
                    'file' => $bt[0]['file'] ?? '',
                    'line' => $bt[0]['line'] ?? '',
                    'message' => $exception,
                    'request' => $request,
                    'data_extra' => $data_extra
                ]));
        }
        return true;
    }
}
