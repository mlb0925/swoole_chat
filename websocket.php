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
$_SESSION['id'] = 20;
$serv->on('Message', function($server, $frame) {
    echo "message: " . $frame->data . "\r\n";
    $message = json_decode($frame->data,true);
    if($message['send_user']==2) {
        $nick = "李四";
        $avatar = './images/user1.jpg';
        $from = 'rigth';
    }
    elseif($message['send_user']==1) {
        $nick = "张三";
        $avatar = './images/user2.jpg';
        $from = 'left';
    } else {
        $nick = "系统提示";
        $avatar = './images/userd.jpg';
        $from = 'right';
        $message['content'] = $frame->data;
    }
    if($message['send_to_user']==1) {
        $from = 'left';
    }
    foreach ($server->connections as $fd) {
        echo "message: " . $frame->data . "\r\n";
        $data['msg'] = [
          'body'=>$message['content'],
          'nick'=>$nick,
          'avatar'=> $avatar,
          'from'=> $from,
          'timestamp'=>  time(),
          'unique'=> $_SESSION['id'],
        ];
        $server->push($fd, json_encode($data,JSON_UNESCAPED_UNICODE));
    }
});

$serv->on('Close', function($server, $fd) {
    echo "connection close: " . $fd."\r\n";
    echo "connection counts: " . count($server->connections)."\r\n";
});
/*
@param $file string 文件名
@param $array array 数组
*/
function BG($file,$array) {
    file_put_contents($file, "<?php\nreturn " . var_export($array, true) . ";");
}
$serv->start();
