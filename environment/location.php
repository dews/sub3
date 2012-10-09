<?php
include("../include/mysql_connect.inc.php");
$mysql = 'SELECT * FROM `location` WHERE `location` != 0 ';	
$myresult = mysql_query($mysql);
#########################################
//連到子計畫7資料庫
$dbServer = "SMARTLIFE\SQLEXPRESS";
$dbName = "NKUTDB";
$dbUser = "sa";
$dbPass = "Zxcv1234";
$connectionInfo =array( "UID"=>$dbUser,"PWD"=>$dbPass,"Database"=>$dbName,"CharacterSet" => "UTF-8");
$conn=sqlsrv_connect($dbServer,$connectionInfo );
//連線資料庫伺服器
if( $conn ){
//     echo "連線成功\n";
}else{
     echo "連線失敗\n";
     die( print_r( sqlsrv_errors(), true));
}

$mssql = "SELECT * FROM [LBS] ";
$msresult = sqlsrv_query($conn,$mssql);
$arr = array();
while( $var = mysql_fetch_array($myresult)){
	array_push($arr,$var);
 }
//print_r($arr[0][0]);

$arr2 = array();
while($row = sqlsrv_fetch_array($msresult) ){
	$splitword= $row[1];
	// explode()=split()但split()不贊成使用,56MR01,取0當分隔,取1
	$splitword= explode('0',$splitword);
	array_push($arr2,$splitword[1]);
	
}
//print_r($arr2);
//有兩張rfid感測卡
for($i=0; $i<2; $i++){
//位置代碼轉換:客廳:1;臥室:2;浴室:3;廚房:4;陽台:5
	switch ($arr2[$i]){
		case 1:
			$arr2[$i]=1;
			break;  
		case 2:
		$arr2[$i]=4;
		break;
		case 3:
			$arr2[$i]=2;
			break;  
		case 4:
			$arr2[$i]=3;
			break;  
		case 5:
			$arr2[$i]=5;
			break; 
		case 6:
			$arr2[$i]=4;
			break;  		
		default:
	} 
	$mysql = 'UPDATE `oldmantest`.`location` SET `location` = "'. $arr2[0] .'" WHERE `location`.`id` = "A123456789";';  
	$myresult = mysql_query($mysql);
	//echo $arr2[$i] ;
}	

if( $msresult === false )
{
	//echo "Error in executing query.&lt;/br&gt;";
	die( print_r( sqlsrv_errors(), true));
}

sqlsrv_free_stmt( $msresult);
sqlsrv_close( $conn);
##########################################

$sql = 'SELECT * FROM `location` WHERE `location` != 0 LIMIT 0, 30 ';	
$result = mysql_query($sql);
while($var = mysql_fetch_array($result)){
	$sql2 = "SELECT `photoname` FROM `identity` WHERE `idcard` ='". $var['id'] ."' LIMIT 0, 30";
	$photo = mysql_query($sql2);
	while($row = mysql_fetch_array($photo)){
	//echo $row[0];
		 $data_array[] = array
		 (
			"id" => "<img id='photo' src='./environment/showpic.php?photoname=". $row[0] ."'>",
			"location" => $var['location'],
		 );   
	}
}
//轉json格式，但傳過去變字串，用 eval變json物件格式
echo json_encode($data_array); 
sleep(1 ); // 等1s
?>