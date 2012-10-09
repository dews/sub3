<?php
//連到資料庫
$dbServer = "localhost";
$dbName = "oldmantest";
$dbUser = "root";
$dbPass = "E428-2";

//連線資料庫伺服器
if ( ! @mysql_connect($dbServer, $dbUser, $dbPass) )
die("無法連線資料庫伺服器");
mysql_query("SET NAMES 'utf8'");
//選擇資料庫
if ( ! @mysql_select_db($dbName) )
die("無法使用資料庫");
?>