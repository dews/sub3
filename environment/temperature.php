<?php
include("../include/mysql_connect.inc.php");
if($_POST['value'] !=""){
$sql = "UPDATE `oldmantest`.`temperature` SET `settemperature` = '". $_POST['value'] ."' WHERE `temperature`.`sn` = 1;";
$result = mysql_query($sql);
}else{

$sql = 'SELECT * FROM `temperature` WHERE `sn` = 1';	
$result = mysql_query($sql);
while($var = mysql_fetch_array($result)){
	 $data_array[] = array
	 (
		"set" =>  $var['settemperature'],
		"real" => $var['realtemperature'],
	 );   
}

	//轉json格式，但傳過去變字串，用 eval變json物件格式
	echo json_encode($data_array); 
	sleep(1); // 等1s
}		
?>