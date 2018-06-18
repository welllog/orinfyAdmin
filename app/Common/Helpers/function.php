<?php

function ajaxSuccess($data = [], $meta = '', string $msg = 'success', int $httpCode = 200)
{
    $return = [
        'code' => 0,
        'msg' => $msg,
        'data' => $data,
        'meta' => $meta
    ];
    return response()->json($return, $httpCode);
}

function ajaxError(string $errMsg = '服务异常', int $code = 1, int $httpCode = 200)
{
    $return = [
        'code' => $code,
        'exception' => $errMsg
    ];
    return response()->json($return, $httpCode);
}

function arrayToObject($e)
{
    if (gettype($e) != 'array') return;
    foreach ($e as $k => $v) {
        if (gettype($v) == 'array' || getType($v) == 'object')
            $e[$k] = (object)arrayToObject($v);
    }
    return (object)$e;
}

function objectToArray($e)
{
    $e = (array)$e;
    foreach ($e as $k => $v) {
        if (gettype($v) == 'resource') return;
        if (gettype($v) == 'object' || gettype($v) == 'array')
            $e[$k] = (array)objectToArray($v);
    }
    return $e;
}
