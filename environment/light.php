<?php
include("../include/mysql_connect.inc.php");
if($_POST['livingroom']!=""){
$sql = "UPDATE `oldmantest`.`light` SET `livingroom` = '". $_POST['livingroom'] ."' WHERE `light`.`sn` = 1;";
}elseif($_POST["bedroom"]!=""){
$sql = "UPDATE `oldmantest`.`light` SET `bedroom` = '". $_POST['bedroom'] ."' WHERE `light`.`sn` = 1;";
}elseif($_POST["bathroom"]!=""){
$sql = "UPDATE `oldmantest`.`light` SET `bathroom` = '". $_POST['bathroom'] ."' WHERE `light`.`sn` = 1;";
}elseif($_POST['kitchen']!=""){
$sql = "UPDATE `oldmantest`.`light` SET `kitchen` = '". $_POST['kitchen'] ."' WHERE `light`.`sn` = 1;";
}elseif($_POST['balcony']!=""){
$sql = "UPDATE `oldmantest`.`light` SET `balcony` = '". $_POST['balcony'] ."' WHERE `light`.`sn` = 1;";
}else{}
$result2 = mysql_query($sql);

$sql = 'SELECT * FROM `light` WHERE `sn` = 1';	
$result = mysql_query($sql);
while($var = mysql_fetch_array($result)){
	 $data_array[] = array
	 (
		"livingroom" =>  $var['livingroom'],
		"bedroom" => $var['bedroom'],
		"bathroom" =>  $var['bathroom'],
		"kitchen" =>  $var['kitchen'],
		"balcony" =>  $var['balcony'],
	 );   
}
$json=json_encode($data_array);
//轉json格式，但傳過去變字串，用$.parseJSON()變json物件格式
echo $json; 
sleep(1); // 等1s
?>