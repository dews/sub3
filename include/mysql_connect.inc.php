<?php
//�s���Ʈw
$dbServer = "localhost";
$dbName = "oldmantest";
$dbUser = "root";
$dbPass = "E428-2";

//�s�u��Ʈw���A��
if ( ! @mysql_connect($dbServer, $dbUser, $dbPass) )
die("�L�k�s�u��Ʈw���A��");
mysql_query("SET NAMES 'utf8'");
//��ܸ�Ʈw
if ( ! @mysql_select_db($dbName) )
die("�L�k�ϥθ�Ʈw");
?>