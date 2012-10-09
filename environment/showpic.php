<?
//用來存取存在資料庫的圖片，因為是編碼過後才存入的，所以要解碼才能讀。注意編碼，ansi。
include("../include/mysql_connect.inc.php");

//$SQLSTR="select filepic,filetype from test where filename='". $_REQUEST["filename"] . "'";
//test資料庫用
$SQLSTR="select photo, phototype from identity where photoname='". $_REQUEST["photoname"] . "'";
$cur=mysql_query($SQLSTR);
//取出資料
$data=mysql_fetch_array( $cur );
//echo $data[1];
//測試資料格式
header("Content-Type: $data[1]");
//設定網頁資料格式
// 輸出圖片資料
echo base64_decode($data[0]);
?>