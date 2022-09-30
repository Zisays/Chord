<?php

require __DIR__ . '/vendor/autoload.php';

use Zisay\Chord\Mysql;

//Mysql
$config = [
    'host' => '127.0.0.1',      //数据库地址
    'port' => '3306',           //数据库端口
    'dbname' => 'chord',        //数据库名称
    'username' => 'root',       //数据库用户名
    'password' => 'root',       //数据库密码
    'charset' => 'utf8',        //字符集
    'driver_options' => []      //pdo扩展属性
];

$dsn = 'mysql:host=' . $config['host'] . ';port=' . $config['port'] . ';dbname=' . $config['dbname'] . ';charset=' . $config['charset'];
$username = 'root';
$password = 'root';
$driver_options = $config['driver_options'];

$mysql = new Mysql($dsn, $username, $password, $driver_options);
$data = $mysql->select()->from('user')->run();
o_o($data);