<?php
$user_id = isset($_GET['user_id'])?$_GET['user_id']:'';
$data['list'] = [
    [
        'nick'=>'张三',
        'avatar'=> './images/user2.jpg',
        'from'=> 'right',
        'timestamp'=>  '10:10:12',
        'user_id'=> 1,
    ],
    [
        'nick'=>'李四',
        'avatar'=> './images/user1.jpg',
        'from'=> 'right',
        'timestamp'=>  '16:21:21',
        'user_id'=> 2,
    ],

];
$user = [];
foreach ($data['list'] as $key=>$value) {
    if(!in_array($user_id,$value)) {
        $user = $value;
    }
}
$test['list'] = $user;
echo json_encode($test);