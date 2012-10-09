<?php session_start(); ?>
<?php
if($_SESSION['idcard']==null){
	echo '<p>請先登入...</p>';
	echo '<script type="text/javascript">';
	echo '$("#temp").load("../system/presetinfo.php");';
	echo '</script>';
	echo "<div id='temp'></div>";
	exit;
}
include("../include/mysql_connect.inc.php");

date_default_timezone_set('Asia/Taipei');

$rs = mysql_query("SELECT highblood, lowblood, time 
	FROM detect 
	WHERE idcard = '". $_SESSION['idcard'] ."' 
	AND ( highblood>140 OR highblood<80 OR lowblood>90 OR lowblood<40)
	ORDER BY time");


$file = fopen('./contents.htm' , 'w');
fwrite($file,"<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />"."
<body style='margin: 10px;'>"."
<div style='width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 11px;'>"."
<div align='center'><img src='./images/warning.png' style='height: 96px; width: 96px'></div><br><br>
");	
fwrite($file,"血壓異常<BR>\n");
//血壓異常
while($areas = mysql_fetch_row($rs)){	
	foreach ($areas as $abs) {
		fwrite($file,  $abs . '<BR>');	
	}
	    // 获取数据表列中最后那个值，若为空则表明上次查询并非该列
	    $area_prev = $areas["count_area"];
	    if(!empty($areas["count_area"]))
	        $area_query = $areas["count_area"];
	}
	
$rs = mysql_query("SELECT beat, time 
	FROM detect 
	WHERE idcard = '". $_SESSION['idcard'] ."' 
	AND ( beat>100 OR beat<55)
	ORDER BY time");
fwrite($file,"心跳異常<BR>\n");
//心跳異常

while($areas = mysql_fetch_row($rs))
	{	
	foreach ($areas as $abs) {
		fwrite($file,  $abs . '<BR>');
	}
	    // 获取数据表列中最后那个值，若为空则表明上次查询并非该列
	    $area_prev = $areas["count_area"];
	    if(!empty($areas["count_area"]))
	        $area_query = $areas["count_area"];
	}	
	
$rs = mysql_query("SELECT oxygen, time 
	FROM detect 
	WHERE idcard = '". $_SESSION['idcard'] ."' 
	AND ( oxygen>100 OR oxygen<90)
	ORDER BY time");
fwrite($file,"血氧異常<BR>\n");
//血氧異常

while($areas = mysql_fetch_row($rs))
	{	
	foreach ($areas as $abs) {
		fwrite($file,  $abs . '<BR>');
	}
	    // 获取数据表列中最后那个值，若为空则表明上次查询并非该列
	    $area_prev = $areas["count_area"];
	    if(!empty($areas["count_area"]))
	        $area_query = $areas["count_area"];
	}

$rs = mysql_query("SELECT asugar, time 
	FROM detect 
	WHERE idcard = '". $_SESSION['idcard'] ."' 
	AND ( asugar>110 OR asugar<70)
	ORDER BY time");
fwrite($file,"血糖異常<BR>\n");
//血糖異常

while($areas = mysql_fetch_row($rs))
	{	
	foreach ($areas as $abs) {
		fwrite($file,  $abs . '<BR>');
	}
	    // 获取数据表列中最后那个值，若为空则表明上次查询并非该列
	    $area_prev = $areas["count_area"];
	    if(!empty($areas["count_area"]))
	        $area_query = $areas["count_area"];
	}	
//	
	$rs = mysql_query("SELECT temperature, time 
	FROM detect 
	WHERE idcard = '". $_SESSION['idcard'] ."' 
	AND ( temperature>37 OR temperature<34)
	ORDER BY time");
fwrite($file,"體溫異常<BR>\n");
//體溫異常

while($areas = mysql_fetch_row($rs))
	{	
	foreach ($areas as $abs) {
		fwrite($file,  $abs . '<BR>');
	}
	    // 获取数据表列中最后那个值，若为空则表明上次查询并非该列
	    $area_prev = $areas["count_area"];
	    if(!empty($areas["count_area"]))
	        $area_query = $areas["count_area"];
	}

fwrite($file,
	"</div>\n</body>"
);
fclose($file);

?>

<h2>健康異常設定</h2>
<p>輸入手機號碼</p>未實作
<form method="post" name="login" action="./sentphone.php">
<input type="text" name="phone"><br>
<input type="submit" name="b1" value="確定">
</form>
<p>輸入E-mail</p>
<form method="post" name="login" action="./sentemail.php">
<input type="text" name="email"><br>
<input type="submit" name="b1" value="確定">
</form>
