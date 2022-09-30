# Chord

> ## 基于 PDO 实现的 PHP 多数据库扩展

## 一、安装

通过 `composer` 安装

```php
composer require zisay/chord
```

## 二、Database

> 所有数据库通用的方法

### 1、事务（ trans ）

```php
//开启一个事务 {关闭自动提交模式，启用手动 commit 提交}
$db->begin();
//修改一条数据
$db->update('user')->set(['name' => '张三'])->where('sex', '1');
//判断事务是否存在
if ($db->inTrans()) {
    //提交事务 {提交一个事务，并恢复自动提交模式}
    $db->commit();
} else {
    //回滚事务 {回滚一个事务，并恢复自动提交模式}
    $db->rollback();
}
```

### 2、查询（ query ）

> 直接执行一个 `SQL`  查询语句，并返回一个数组

```php
//直接执行一条查询语句 { select }
$db->query("select * from user");
```

### 3、执行（ exec ）

> 直接执行一个 `SQL` 语句，并返回受影响的条数

```php
//直接执行一条插入语句 { insert }
$db->exec("insert into user(name,sex,age) values('张三',1,18)");
//直接执行一条更新语句 { update }
$db->exec("update user set sex = 0 where name = '张三'");
//直接执行一条删除语句 { delete }
$db->exec("delete from user where name = '张三'");
```

### 4、获取 `PDO` 当前连接属性的值

```php
//PDO::ATTR_AUTOCOMMIT { 是否自动提交每个单独的语句 }
//	1 = 自动提交 { 默认值 }
//	0 = 手动提交
$db->getAttr(PDO::ATTR_AUTOCOMMIT);

//PDO::ATTR_CASE	{ 强制列名为指定的大小写 }
//	0 = PDO::CASE_NATURAL 	{ 保留数据库驱动返回的列名 } { 默认值 }
//	1 = PDO::CASE_UPPER 	{ 强制列名大写 }
//  2 = PDO::CASE_LOWER		{ 强制列名小写 }
$db->getAttr(PDO::ATTR_CASE);

//PDO::ATTR_CLIENT_VERSION { 返回当前 PDO 驱动所用客户端库的版本信息 } { 只读属性 }
$db->getAttr(PDO::ATTR_CLIENT_VERSION);

//PDO::ATTR_CONNECTION_STATUS { 返回当前 PDO 连接状态 } { 只读属性 }
$db->getAttr(PDO::ATTR_CONNECTION_STATUS);

//PDO::ATTR_DRIVER_NAME { 返回当前 PDO 驱动名称 }
$db->getAttr(PDO::ATTR_DRIVER_NAME);

//PDO::ATTR_ERRMODE { 错误模式 }
//	0 = PDO::ERRMODE_SILENT { 仅设置错误代码 }
//	1 = PDO::ERRMODE_WARNING { 引发 E_WARNING 错误 }
//	2 = PDO::ERRMODE_EXCEPTION { 抛出 exceptions 异常 } { 默认值 }
$db->getAttr(PDO::ATTR_ERRMODE);

//PDO::ATTR_ORACLE_NULLS { 是否转换 NULL 和 空字符串 }
//	0 = PDO::NULL_NATURAL { 不转换 } { 默认值 }
//	1 = PDO::NULL_EMPTY_STRING { 强制将 空字符串 转换成 null }
//	2 = PDO::NULL_TO_STRING { 强制将 NULL 转换成 空字符串 }
$db->getAttr(PDO::ATTR_ORACLE_NULLS);

//PDO::ATTR_PERSISTENT {请求持久连接，而不是创建新连接}
// 	0 = false 	{ 关闭 } {默认值}
//	1 = true 	{ 开启 }
$db->getAttr(PDO::ATTR_PERSISTENT);

//PDO::ATTR_PREFETCH
//设置预取大小来为你的应用平衡速度和内存使用。
//较大的预取大小导致性能提高的同时也会占用更多的内存。
//注：并非所有的数据库/驱动组合都支持
$db->getAttr(PDO::ATTR_PREFETCH);

//PDO::ATTR_SERVER_INFO { 返回有关 PDO 连接到的数据库服务器的一些元信息 } { 只读属性 }
$db->getAttr(PDO::ATTR_SERVER_INFO);

//PDO::ATTR_SERVER_VERSION { 返回有关 PDO 连接到的数据库服务器版本的信息 } { 只读属性 }
$db->getAttr(PDO::ATTR_SERVER_VERSION);

//PDO::ATTR_TIMEOUT { 设置连接数据库的超时秒数 }
//注：并非所有的数据库/驱动组合都支持
$db->getAttr(PDO::ATTR_TIMEOUT);
```

### 5、设置  `PDO`  当前连接属性的值

```php
//PDO::ATTR_AUTOCOMMIT { 是否自动提交每个单独的语句 }
//	1 = 自动提交 { 默认值 }
//	0 = 手动提交
$db->setAttr(PDO::ATTR_AUTOCOMMIT,0);
$db->setAttr(PDO::ATTR_AUTOCOMMIT,false);

//PDO::ATTR_CASE	{ 强制列名为指定的大小写 }
//	0 = PDO::CASE_NATURAL 	{ 保留数据库驱动返回的列名 } { 默认值 }
//	1 = PDO::CASE_UPPER 	{ 强制列名大写 }
//  2 = PDO::CASE_LOWER		{ 强制列名小写 }
$db->setAttr(PDO::ATTR_CASE,1);
$db->setAttr(PDO::ATTR_CASE,PDO::CASE_UPPER);

//PDO::ATTR_ERRMODE { 错误模式 }
//	0 = PDO::ERRMODE_SILENT { 仅设置错误代码 }
//	1 = PDO::ERRMODE_WARNING { 引发 E_WARNING 错误 }
//	2 = PDO::ERRMODE_EXCEPTION { 抛出 exceptions 异常 } { 默认值 }
$db->setAttr(PDO::ATTR_ERRMODE,1);
$db->setAttr(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);

//PDO::ATTR_ORACLE_NULLS { 是否转换 NULL 和 空字符串 }
//	0 = PDO::NULL_NATURAL { 不转换 } { 默认值 }
//	1 = PDO::NULL_EMPTY_STRING { 强制将 空字符串 转换成 null }
//	2 = PDO::NULL_TO_STRING { 强制将 NULL 转换成 空字符串 }
$db->setAttr(PDO::ATTR_ORACLE_NULLS,1);
$db->setAttr(PDO::ATTR_ORACLE_NULLS,PDO::NULL_EMPTY_STRING);

//PDO::ATTR_STRINGIFY_FETCHES { 强制将提取的所有值视为字符串 }
// 	0 = false 	{ 关闭 } {默认值}
//	1 = true 	{ 开启 }
$db->setAttr(PDO::ATTR_STRINGIFY_FETCHES,1);
$db->setAttr(PDO::ATTR_STRINGIFY_FETCHES,true);

//PDO::ATTR_TIMEOUT { 设置连接数据库的超时秒数 }
//注：并非所有的数据库/驱动组合都支持
$db->setAttr(PDO::ATTR_TIMEOUT,30);

//PDO::ATTR_EMULATE_PREPARES { 启用或禁用预处理语句的模拟 }
//有些驱动不支持或有限度地支持本地预处理。
//使用此设置强制PDO总是模拟预处理语句（如果为 true ），或试着使用本地预处理语句（如果为 false）。
//如果驱动不能成功预处理当前查询，它将总是回到模拟预处理语句上。需要 bool 类型。
$db->setAttr(PDO::ATTR_EMULATE_PREPARES, true);

//PDO::MYSQL_ATTR_USE_BUFFERED_QUERY { 使用缓冲查询 } { 在MySQL中可用 }
// 	0 = false 	{ 关闭 } {默认值}
//	1 = true 	{ 开启 }
$db->setAttr(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, 1);

//PDO::ATTR_DEFAULT_FETCH_MODE { 设置默认的提取模式 }
//	1 = PDO::FETCH_LAZY：结合使用 PDO::FETCH_BOTH 和 PDO::FETCH_OBJ，创建供用来访问的对象变量名 
//	2 = PDO::FETCH_ASSOC { 返回一个索引为结果集列名的数组 } 
//	3 = PDO::FETCH_NUM：返回一个索引为以0开始的结果集列号的数组 
//	4 = PDO::FETCH_BOTH { 返回一个索引为结果集列名和以0开始的列号的数组 } { 默认值 }
//	5 = PDO::FETCH_OBJ：返回一个属性名对应结果集列名的匿名对象 
//	6 = PDO::FETCH_BOUND { 返回 true ，并分配结果集中的列值给 PDOStatement::bindColumn() 方法绑定的 PHP 变量 } 
//	8 = PDO::FETCH_CLASS { 返回一个请求类的新实例，映射结果集中的列名到类中对应的属性名 }
//	{ 如果 fetch_style 包含 PDO::FETCH_CLASSTYPE（例如：PDO::FETCH_CLASS |PDO::FETCH_CLASSTYPE），则类名由第一列的值决定 }
//	9 = PDO::FETCH_INTO：更新一个被请求类已存在的实例，映射结果集中的列到类中命名的属性 
$db->setAttr(PDO::ATTR_DEFAULT_FETCH_MODE, 1);
$db->setAttr(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_LAZY);
```

### 6、返回当前可用的 `PDO` 驱动

```php
$db->getDrivers();
```

### 7、返回受影响的行数

```php
$db->rowCount()
```

### 8、返回结果集中的总列数

```php
$db->columnCount();
```

### 9、返回最后插入行的ID或序列值

```php
$db->lastInsertId();
```

### 10、返回预处理的 `SQL`语句信息

```php
$db->sql();
```

## 三、MySQL

### 1、实例化

```php
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
```

### 2、查询数据

#### （1）、语法

```php
$mysql->select()->form()->where()->and()->or()->groupBy()->having()->and()->or()->orderBy()->limit()->run();
```

#### （2）、select

[1]、查询 `user` 表所有数据

```php
$mysql->select()->from('user')->run();
```

[2]、查询 `user` 表中字段为 `account` 和 `password` 的所有数据

```php
$mysql->select('account,password')->from('user')->run();
```

#### （3）、where

[1]、查询 `user` 表中 `id = 1` 的数据

```php
$mysql->select()->from('user')->where('id',1)->run();
```

[2]、查询 `user` 表中 `sex = 1` 并且 `age > 18` 的数据

```php
$mysql->select()->from('user')->where('sex','=',1)->and('age','>',18)->run();
```

[3]、查询 `user` 表中 `account = 123` 或者 `account = 456` 的数据

```php
$mysql->select()->from('user')->where('account',123)->or('account',456)->run();
```

#### （4）、in

```php
$mysql->select()->from('user')->where('id', 'in', [24,25])->run();
```

#### （5）、like

> 模糊查询

[1]、查询 `name` 字段以 `google` 开头的数据

```php
$mysql->select()->from('user')->where('name','like','google%')->run();
```

[2]、查询  `name` 字段以 `google` 结尾的数据

```php
$mysql->select()->from('user')->where('name','like','%google')->run();
```

[3]、查询 `name` 字段中包含 `google` 的数据

```php
$mysql->select()->from('user')->where('name','like','%google%')->run();
```

[4]、查询 `name` 字段中 `5` 位数，开头是 `g` 最后一位为 `e` 的数据

```php
$mysql->select()->from('user')->where('name','like','%g____e%')->run();
```

#### （6）、regexp

> 正则表达式查询

[1]、查询 `name` 字段以 `goo` 开头的数据

```php
$mysql->select()->from('user')->where('name','regexp','^[goo]')->run();
```

[2]、查询 `name` 字段不以 `goo` 开头的数据

```php
$mysql->select()->from('user')->where('name','regexp','^[^goo]')->run();
```

[3]、查询 `name` 字段不以 `a-z` 开头的数据

```php
$mysql->select()->from('user')->where('name','regexp','^[^a-z]')->run();
```

### 3、插入数据

```php
$data = ['name'=>'子曰'];
$mysql->insertInto('user')->values($data)->run();
```

### 4、修改数据

```php
$data = ['name' => 'zisay'];
$mysql->update('user')->set($data)->where('sex', '1')->and('id','1')->run();
```

### 5、删除数据

```php
$mysql->deleteFrom('user')->where('id','1')->run();
```

