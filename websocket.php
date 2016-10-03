<?php

/**
 * Encoding     :   UTF-8
 */
$serv = new swoole_websocket_server("0.0.0.0", 9503);
//$serv->set(array('daemonize' => true));   //以守护进程运行
$serv->on('Open', function($server, $req) {
    echo "connection open: " . $req->fd;
    echo "connection counts: " . count($server->connections)."\r\n";
});
$_SESSION['id'] =20;
$serv->on('Message', function($server, $frame) {
    echo "message: " . $frame->data . "\r\n";
    foreach ($server->connections as $fd) {
        file_put_contents('1.txt',$fd);
        $data['msg'] = [
          'body'=>$frame->data,  
          'nick'=>'张三',  
          'avatar'=> $fd%2?'./images/user1.jpg':'./images/user2.jpg',
          'from'=> $fd%2?'left':'right',
          'timestamp'=>  time(),
          'unique'=> $_SESSION['id'],
        ];
        print_r($data);
        $server->push($fd, json_encode($data,JSON_UNESCAPED_UNICODE));
    }
});

$serv->on('Close', function($server, $fd) {
    echo "connection close: " . $fd."\r\n";
    echo "connection counts: " . count($server->connections)."\r\n";
});

$serv->start();
