<?php
$server = new swoole_websocket_server('0.0.0.0', 9501);
$server->on('workerStart', function ($server, $workerId) {
    $server->client = new swoole_redis;
});

$server->on('open', function ($server, $request) {
//    $client = new swoole_redis;
    $server->client->on('message', function (swoole_redis $client, $result) use ($server, $request) {
        if ($result[0] == 'message') {
            $server->push($request->fd, $result[2]);
        }
        var_dump(json_encode($result,JSON_UNESCAPED_UNICODE));
    });
    $server->client->connect('127.0.0.1', 6379, function (swoole_redis $client, $result) {
        $client->subscribe('msg');
    });
});

$server->on('message', function (swoole_websocket_server $server, $frame) {
    $server->push($frame->fd, "hello".$frame->data);
});

//$server->on('close', function ($serv, $fd) {
//
//});

$server->start();