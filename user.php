<?php
$data['list'] = [
    [
        'nick'=>'张三',
        'avatar'=> './images/user2.jpg',
        'from'=> 'right',
        'timestamp'=>  time(),
        'user_id'=> 1,
    ],
    [
        'nick'=>'李四',
        'avatar'=> './images/user1.jpg',
        'from'=> 'right',
        'timestamp'=>  time(),
        'user_id'=> 2,
    ],

];
echo json_encode($data['list']);