<?php
// header('refresh: 2');

header("content-type: text/html; charset=utf-8");

//连接本地的 Redis 服务
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

$result = $redis->get('todayGame');
echo $result;

print_r(json_decode($result, true));
