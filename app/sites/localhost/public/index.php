<?php
$action = '';
if(isset($_GET['action'])){
	$action = $_GET['action'];
}
header('Content-Type: text/html; charset=utf-8');
if($action == 'phpinfo'){
	phpinfo();
}else{
	echo '<!doctype html>
<html lang="zh-CN">
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>default page</title>
<style type="text/css">
body{
	margin:0;
	padding: 15px 0 0 0;
	font-size: 14px;
    line-height: 1.5;
}
.main-page{
	width:60%;
	margin:0 auto;
}
pre {
    background-color: #f6f8fa;
    border-radius: 3px;
    font-size: 85%;
    line-height: 1.45;
    overflow: auto;
    padding: 16px;
	white-space: pre-wrap;
	word-wrap: break-word;
}
.error{
	color:red;
}
.success{
	color: green;
}
</style>
</head>
<body>
<div class="main-page">';
	echo '<pre>';
	echo 'PHP版本 :<a target="_blank" href="?action=phpinfo">', PHP_VERSION, '</a>';
	echo '</pre>';
	//mysql
	$dbname = 'mysql';
	$host = getenv('DB_HOST');
	$dbuser = 'root';
	$dbpass = 'p123456';
	try {
		$dbh = new PDO("mysql:dbname=$dbname;host=$host", $dbuser, $dbpass);
		//获取MySQL版本
		$res = $dbh->query('SELECT VERSION() AS v');
		$result = $res->fetch();
		echo '<h3 class="success">connect to db success !</h3>';
		echo '<pre>';
		echo 'MySQL版本 :',$result['v'];
		echo '</pre>';
	} catch (PDOException $e) {
		echo '<h3 class="error">connect to db error !</h3>';
		echo '<pre class="error">', $e->getMessage(), '</pre>';
	}
	//redis
	$redis = new Redis();
	try{
		$redisHost = getenv('REDIS_HOST');
		@$redis->connect($redisHost, 6379);
		$info = $redis->info();
		echo '<h3 class="success">connect to redis success !</h3>';
		echo '<pre>';
		echo 'Redis信息',PHP_EOL;
		print_r($info);
		echo '</pre>';
	} catch (RedisException $e) {
		echo '<h3 class="error">connect to redis error !</h3>';
		echo '<pre class="error">', $e->getMessage(), '</pre>';
	}
	echo '</div></body></html>';
}