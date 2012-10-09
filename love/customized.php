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


$rd=mysql_query("CREATE TEMPORARY TABLE tmp_table SELECT analysis.`diseasename` , `碳水化合物` , `蛋白質` , `脂肪` , `礦物質` , `維生素` , `水` , `熱量` , `納` , `膽固醇` , `鈣` , `控制體重` , `定期檢查` , `運動` , `定期吃藥` , `輻射` , `吸菸` , `喝酒` , `喝咖啡` , `吃檳榔` , `飯後刷牙` , `配眼鏡` , `配助聽器` , `參與社交活動` , `曬太陽補充維它命D` , `固定性伴侶`
				FROM analysis inner join pasthospital 
				ON analysis.diseasename =  pasthospital.disease
				where pasthospital.idcard = '". $_SESSION['idcard'] ."'
				");
$rs=mysql_query("SELECT COUNT(*) FROM tmp_table ");//計算疾病數

while($areas = mysql_fetch_row($rs))
	{	
	foreach ($areas as $rrs) {
		echo '依據您最近'. $rrs . '種病症分析:';
	}
	echo '<BR>';
	    // 获取数据表列中最后那个值，若为空则表明上次查询并非该列
	    $area_prev = $areas["count_area"];
	    if(!empty($areas["count_area"]))
	        $area_query = $areas["count_area"];	
	}
$sql = 'show COLUMNS from analysis;';
$sqlshow=mysql_query($sql);

while($sqlshow2=mysql_fetch_row($sqlshow))
{
	$sug[]=$sqlshow2[0];
	//print_r($sug);
}
//$sug[0]=sn;$sug[1]=diseasename;$sug[2]=碳水化合物
$code=array(1,1,1,1);
for($aa=2;$aa<=26;$aa++)
{

	$tt=$sug[$aa];
	$rs=mysql_query("SELECT SUM(`". $tt ."`) FROM tmp_table ");
	$rs2 = mysql_fetch_row($rs);
	if($rs2[0]!=0)
	{
		$rd2=mysql_query("INSERT INTO  `oldmantest`.`tosub4`   (`userid`,`number`,`suggest`) VALUES ( '". $_SESSION['idcard'] ."','". $rs2[0] ."','". $tt ."' )");
		//分飲食方面，習慣方面..用
		if($aa<=12)
		{
			$code[0] = 0;
		}elseif($aa>12&$aa<=17)
		{
			$code[1]=0;
		}elseif($aa>17&$aa<=22)
		{
			$code[2]=0;
		}else
		{
			$code[3]=0;
		}
	}
	//echo $rs2[0];

} 

$debug='0';	
$code = '1';		
$c='碳水化合物';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '0':
			echo '';
			break;
		case '1':
			$code = '0';
			$a1 = '增加碳水化合物攝取　';
			break;
		case '2':
			$code = '0';
			$a1  ='需要大量碳水化合物攝取　';
			break;
		default:
			$debug++;
			break;
	}
}
$c='蛋白質';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '0':
		echo '';
		break;
		case '1':
		$code = '0';
		$b1= '增加蛋白質攝取　';
		break;
		case '2':
		$code = '0';
		$b1= '需要大量蛋白質攝取　';
		break;
		default:
		$debug++;
		break;
	}
}
$c='脂肪';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '0':
		echo '';
		break;
		case '1':
		$code = '0';
		$c1 ='減少脂肪攝取　';
		break;
		case '2':
		$code = '0';
		$c1 ='特別減少脂肪攝取　';
		break;
		default:
		$debug++;
		break;
	}
}
$c='礦物質';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '0':
		echo '';
		break;
		case '1':
		$code = '0';
		$d1 ='增加礦物質攝取　';
		break;
		case '2':
		$code = '0';
		$d1 ='需要大量礦物質攝取　';
		break;
		default:
		$debug++;
		break;
	}
}
$c='維生素';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '0':
		echo '';
		break;
		case '1':
		$code = '0';
		$e1 ='增加維生素攝取　';
		break;
		case '2':
		$code = '0';
		$e1 ='需要大量維生素攝取　';
		break;
		default:
		$debug++;
		break;
	}
}
$c='水';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '0':
		echo '';
		break;
		case '1':
		$code = '0';
		$f1 ='增加水分攝取　';
		break;
		case '2':
		$code = '0';
		$f1 ='需要大量水分攝取　';
		break;
		default:
		$debug++;
		break;
	}
}
$c='熱量';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '-2':
		$g1 = '特別減少熱量攝取　';
		break;
		case '-1':
		$code = '0';
		$g1 = '減少熱量攝取　';
		break;
		case '0':
		echo '';
		break;
		case '1':
		$code = '0';
		$g1 ='增加熱量攝取　';
		break;
		case '2':
		$code = '0';
		$g1 ='需要大量熱量攝取　';
		break;
		default:
		$debug++;
		break;
	}
}
$c='納';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '-2':
		$code = '0';
		$h1 = '特別注意減少納的攝取量　';
		break;
		case '-1':
		$code = '0';
		$h1 = '減少納的攝取量　';
		break;
		case '0':
		echo '';
		break;
		case '1':
		$code = '0';
		$h1 = '減少納攝取　';
		break;
		case '2':
		$code = '0';
		$h1 = '特別減少納攝取　';
		break;
		default:
		$debug++;
		break;
	}
}
$c='膽固醇';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '-2':
		$code = '0';
		$i1 = '特別注意減少膽固醇的攝取量　';
		break;
		case '-1':
		$code = '0';
		$i1 = '減少膽固醇的攝取量　';
		break;
		case '0':
		echo '';
		break;
		default:
		$debug++;
		break;
	}
}
$c='鈣';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '0':
		echo '';
		break;
		case '1':
		$code = '0';
		$j1 ='增加鈣攝取　';
		break;
		case '2':
		$code = '0';
		$j1 ='需要大量鈣攝取　';
		break;
		default:
		$debug++;
		break;
	}
}

		
$code2 = '1';
$c='控制體重';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '-2':
		$code2 = '0';
		$a2 = '特別注意控制體重　';
		break;
		case '-1':
		$code2 = '0';
		$a2 ='控制體重　';
		break;
		case '0':
		echo '';
		break;
		case '1':
		$code2 = '0';
		$a2 = '控制體重　';
		break;
		case '2':
		$code2 = '0';
		$a2 = '特別注意控制體重　';
		break;
		default:
		$debug++;
		break;
	}
}
$c='定期檢查';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '0':
		echo '';
		break;
		case '1':
		$code2 = '0';
		$b2 ='注意定期檢查　';
		break;
		case '2':
		$code2 = '0';
		$b2 ='特別注意定期檢查　';
		break;
		default:
		$debug++;
		break;
	}
}
$c='運動';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '0':
		echo '';
		break;
		case '1':
		$code2 = '0';
		$c2 = '適當運動　';
		break;
		case '2':
		$code2 = '0';
		$c2 = '增加運動量　';
		break;
		default:
		$debug++;
		break;
	}
}
$c='定期吃藥';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '0':
		echo '';
		break;
		case '1':
		$code2 = '0';
		$d2 = '定期吃藥　';
		break;
		case '2':
		$code2 = '0';
		$d2 = '記得定期吃藥　';
		break;
		default:
		$debug++;
		break;
	}
}
$c='輻射';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '0':
		echo '';
		break;
		case '-1':
		$code2 = '0';
		$e2 = '避免輻射　';
		break;
		case '-2':
		$code2 = '0';
		$e2 = '避免輻射，遠離高壓電塔、基地台，少用電磁爐　';
		break;
		case '-3':
		$code2 = '0';
		$e2 = '避免輻射，遠離高壓電塔、基地台，少用電磁爐　';
		break;
		case '-4':
		$code2 = '0';
		$e2 = '避免輻射，遠離高壓電塔、基地台，少用電磁爐　';
		break;
		case '-5':
		$code2 = '0';
		$e2 ='避免輻射，遠離高壓電塔、基地台，少用電磁爐　';
		break;
		case '-6':
		$code2 = '0';
		$e2 = '避免輻射，遠離高壓電塔、基地台，少用電磁爐、微波爐，少照X光　';
		break;
		case '-7':
		$code2 = '0';
		$e2 ='避免輻射，遠離高壓電塔、基地台，少用電磁爐、微波爐，少照X光　';
		break;
		default:
		$debug++;
		break;
	}
}
$c='飯後刷牙';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '0':
		echo '';
		break;
		case '1':
		$code2 = '0';
		$f2 = '記得飯後刷牙　';
		break;
		default:
		$debug++;
		break;
	}
}
$c='曬太陽補充維它命D';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '0':
		echo '';
		break;
		case '1':
		$code2 = '0';
		$g2 = '多曬太陽補充維它命D　';
		break;
		case '-1':
		$code2 = '0';
		$g2 = '少曬太陽避免皮膚炎惡化　';
		break;
		default:
		$debug++;
		break;
	}
}


$code3 = '1';
$c='吸菸';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '0':
		echo '';
		break;
		case '-1':
		$code3 = '0';
		$a3 = '請少吸菸　';
		break;
		case '-2':
		$code3 = '0';
		$a3 = '請少吸菸　';
		break;
		case '-3':
		$code3 = '0';
		$a3 = '請戒菸　';
		break;
		case '-4':
		$code3 = '0';
		$a3 = '請戒菸　';
		break;
		case '-5':
		$code3 = '0';
		$a3 = '請戒菸，並遠提二手菸　';
		break;
		case '-6':
		$code3 = '0';
		$a3 = '請戒菸，並遠提二手菸　';
		break;
		case '-7':
		$code3 = '0';
		$a3 = '請戒菸，並遠提二手菸，注意空氣品質良好　';
		break;
		default:
		$debug++;
		break;
	}
}

$c='喝酒';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '0':
		echo '';
		break;
		case '-1':
		$code3 = '0';
		$i3 = '飲酒適量　';
		break;
		case '-2':
		$code3 = '0';
		$i3 = '請少喝酒　';
		break;
		case '-3':
		$code3 = '0';
		$i3 = '為了您健康請少喝酒　';
		break;
		case '-4':
		$code3 = '0';
		$i3 = '目前身體狀況不好，請務必不要喝酒　';
		break;
		case '-5':
		$code3 = '0';
		$i3 = '目前身體狀況不好，請務必不要喝酒　';
		break;
		case '-6':
		$code3 = '0';
		$i3 = '目前身體狀況不好，請務必不要喝酒　';
		break;
		case '-7':
		$code3 = '0';
		$i3 = '目前身體狀況不好，請務必不要喝酒　';
		break;
		case '-8':
		$code3 = '0';
		$i3 = '目前身體狀況不好，請務必不要喝酒　';
		break;
		case '-9':
		$code3 = '0';
		$i3 = '目前身體狀況不好，請務必不要喝酒　';
		break;		
		default:
		$debug++;
		break;
	}
}

$c='喝咖啡';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '0':
		echo '';
		break;
		case '-1':
		$code3 = '0';
		$j2 = '請少喝咖啡　';
		break;
		case '-2':
		$code3 = '0';
		$j2 = '請戒咖啡　';
		break;
		default:
		$debug++;
		break;
	}
}

$c='吃檳榔';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '0':
		echo '';
		break;
		case '1':
		$code3 = '0';
		$k2 = '請少吃檳榔　';
		break;
		case '2':
		$code3 = '0';
		$k2 = '請戒吃檳榔　';
		break;
		default:
		$debug++;
		break;
	}
}

$code4 = '1';
$c='配眼鏡';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '0':
		echo '';
		break;
		case '1':
		$code4 = '0';
		$a4 = '需要配戴眼鏡　';
		break;
		default:
		$debug++;
		break;
	}
}

$c='配助聽器';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '0':
		echo '';
		break;
		case '1':
		$code4 = '0';
		$b4 = '需要配戴助聽器　';
		break;
		default:
		$debug++;
		break;
	}
}

$c='參與社交活動';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '0':
		echo '';
		break;
		case '1':
		$code4 = '0';
		$c4 = '多參與社交活動　';
		break;
		case '2':
		$code4 = '0';
		$c4 = '多多參與社交活動　';
		break;
		default:
		$debug++;
		break;
	}
}
$c='固定性伴侶';
$rs=mysql_query("SELECT SUM(`". $c ."`) FROM tmp_table ");
$rs2 = mysql_fetch_row($rs);
foreach ($rs2 as $rs3){
	switch($rs3){
		case '0':
		echo '';
		break;
		case '1':
		$code4 = '0';
		$d4 = '固定性伴侶　';
		break;
		case '2':
		$code4 = '0';
		$d4 = '固定性伴侶　';
		break;
		default:
		$debug++;
		break;
	}
}
//查詢使用者是否存在，若否，新增一個
$ras=mysql_query("SELECT COUNT(userid) FROM suggest where userid = '". $_SESSION['idcard'] ."' ");

while($areas = mysql_fetch_row($ras)){	
	foreach ($areas as $rrs) {
		if($rrs<1){
			$rs=mysql_query("INSERT INTO  `oldmantest`.`suggest` (`userid` ,`food` ,`life` ,`habit` ,`other` ,`time`)VALUES ('". $_SESSION['idcard'] ."', NULL , NULL , NULL , NULL , CURRENT_TIMESTAMP)");
		}
	}
}

//若$code等於0，表示飲食方面有需要注意的，若等於1，毋需注意，所以就不顯示
if($code == '0'){	
	//global $a1;
	$die = $a1 . $b1 . $c1 . $d1 . $e1 . $f1 . $g1 . $h1 . $i1 . $j1;
	echo '1.飲食方面您須注意: '. $die;
	$rd=mysql_query("UPDATE  `oldmantest`.`suggest` SET  `food` =  '". $die ."' where userid = '". $_SESSION['idcard'] ."'");

}
if($code2 == '0'){	
	//global $a1;
	$life = $a2 . $b2 . $c2 . $d2 . $e2 . $f2 . $g2;
	echo '<BR>2.生活習慣方面您須注意: '. $life;
	$rd=mysql_query("UPDATE  `oldmantest`.`suggest` SET  `life` =  '". $life ."' where userid = '". $_SESSION['idcard'] ."'");
}
if($code3 == '0'){	
	//global $a1;
	$habit = $a3 . $b3 . $c3 . $d3 . $e3 . $f3 . $g3;
	echo '<BR>3.嗜好方面您須注意: '. $habit ;
	$rd=mysql_query("UPDATE  `oldmantest`.`suggest` SET  `habit` =  '". $habit ."' where userid = '". $_SESSION['idcard'] ."'");
}
if($code4 == '0'){	
	//global $a1;
	$other = $a4 . $b4 . $c4 . $d4;
	echo '<BR>4.其他: '. $other ;
	$rd=mysql_query("UPDATE  `oldmantest`.`suggest` SET  `other` =  '". $other ."' where userid = '". $_SESSION['idcard'] ."'");
}

/* if($debug>1){
	if($debug==25){
		echo '!無慢性病資料';
	}else{
		echo $debug .'資料庫有誤';
	}
} */
?>

