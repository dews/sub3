<?php session_start(); ?>
<style>	
.ui-datepicker-trigger {
	vertical-align: text-top;
	margin:2px;
}
label{
	display: inline;
}
.customtab .ui-tabs .ui-tabs-nav {
	min-height: 0px;
	width:98%;
	margin:auto;
}
.customtab .ui-tabs .ui-tabs-nav li {
	width: auto;
}
</style>
<div   class="customtab">
	<form id="barcodeForm"  method="post">
		<label for="from">從</label>
		<input type="text" id="from" name="from" type="text" value="" />
		<label for="to">到</label>
		<input type="text" id="to" name="to" type="text" value=""  />
		  <button type="submit" class="ui-datepicker-close ui-state-default ui-corner-all" value="改變日期">改變日期</button>
	</form>

	<div id="innertabs">
		<ul>
			<li><a href="./health/pressure.php">血壓</a></li>
			<li><a href="./health/beat.php">心跳</a></li>
			<li><a href="./health/oxygen.php">血氧</a></li>
			<li><a href="./health/sugar.php">血糖</a></li>
			<li><a href="./health/temperature.php">體溫</a></li>
			<li><a href="./health/emotest.php">情緒</a></li>
		</ul>
	</div>
</div>
<script src="./js/highcharts.js"></script>
<script src="./js/exporting.js"></script>

<?php
if($_SESSION['idcard']==null){
	echo '<p>請先登入...</p>';
	echo '<script type="text/javascript">';
	//回登入畫面
	echo  "window.location.href='../homepage/#ui-tabs-2'";;
	echo '</script>';
	exit;
}
//連到資料庫
$dbServer = "163.22.249.66";
$dbName = "oldmantest";
$dbUser = "root";
$dbPass = "E428-2";
$link=mysql_connect($dbServer, $dbUser, $dbPass);
//連線資料庫伺服器
if ( !$link)
die("無法連線資料庫伺服器");

//選擇資料庫
if ( ! @mysql_select_db($dbName))
die("無法使用資料庫");

    //將資料庫裡的所有會員資料顯示在畫面上
    $sql = "SELECT * FROM sub6detect where `checked` = false";
    $result = mysql_query($sql);
	$sql = "UPDATE `oldmantest`.`sub6detect` SET `checked` = true WHERE `sub6detect`.`checked` = false;";
	mysql_query($sql);
include("../include/mysql_connect.inc.php");

//設定時區,避免時間函數出問題。
date_default_timezone_set('Asia/Taipei');

if($_POST[to]==null){
	$pastweek = mktime(0,0,0,date("m"),date("d")-7,date("Y"));
	$addoneday= mktime(0,0,0,date("m"),date("d")+1,date("Y"));
	$today=date("Y/m/d");
	//預設從上週到今天
	$_POST[from]=date("Y/m/d",$pastweek);
	$_POST[to]=date("Y/m/d",$addoneday);
//echo  $_POST[to];
}else{
	$fromtimestamp=strtotime($_POST[from]);
	$totimestamp=strtotime($_POST[to]);
	
	$_POST[from]=date("Y/m/d",mktime(0,0,0,date("m",$fromtimestamp),date("d",$fromtimestamp)-1,date("Y",$fromtimestamp)));	
	$_POST[to]=date("Y/m/d",mktime(0,0,0,date("m",$totimestamp),date("d",$totimestamp)+1,date("Y",$totimestamp)));
}

	
    while($row = mysql_fetch_array($result)){
	/* echo 'print_r($row);
 	echo '使用者:'. $row[1] .'<br>';
	echo '時間:'. $row[2] .'<br>';	
	echo '<BR>收收壓：'. $row[3] .'<br>';
	echo '<BR>舒張壓：'. $row[4] .'<br>';
	echo '<BR>心跳：'.$row[5] .'<br>';
	echo '<BR>血氧：'.$row[6] .'<br>';
	echo '<BR>體溫：'.$row[7] .'<br>';
	echo '<BR>飯前血糖：'.$row[8] .'<br>';	
	echo '<BR>飯後血糖：'.$row[9] .'<br>';	  */

	$a1=$row[1];
	$a2=$row[2];
	$a3=$row[3];
	$a4=$row[4];		
	$a5=$row[5];	
	$a6=$row[6];	
	$a7=$row[7];	
	$a8=$row[8];	
	$a9=$row[9];
	//轉存在detect
	$sql = "INSERT INTO `oldmantest`.`detect` (`sn`, `idcard`, `highblood`, `lowblood`, `beat`, `oxygen`, `asugar`, `bsugar`, `temperature`, `emotion`, `time`) VALUES (NULL,'". $a1 ."','". $a3 ."', '". $a4 ."', '". $a5 ."','". $a6 ."','". $a8 ."','". $a9 ."','". $a7 ."',NULL,'". $a2 ."');";
	$insert = mysql_query($sql); 
    }

//$rs = mysql_query("SELECT * FROM detect WHERE idcard = '" .$_POST[idcard] . "'");
//讀血壓數據
$timers = mysql_query("SELECT time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' AND `highblood` IS NOT NULL  AND `lowblood` IS NOT NULL AND time >= '". $_POST[from] ." ' AND time <= '". $_POST[to] ."' ORDER BY `time` ASC");
$rs = mysql_query("SELECT highblood,lowblood FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' AND time >= '". $_POST[from] ." ' AND time <= '". $_POST[to] ."' ORDER BY `time` ASC");
$blolast=mysql_query("SELECT highblood,lowblood,time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' ORDER BY `sn` DESC limit 1");
$blo=mysql_fetch_row($blolast);
$file = fopen('./pressure.tsv' , 'w');
fwrite($file,"# ----\n");
fwrite($file,"# Graph\n");
fwrite($file,"# -----\n");
//$artimes =mysql_fetch_row($timers);

while($areas = mysql_fetch_row($rs) and $artimes =mysql_fetch_row($timers)){	
	//echo "tt<br>";
	//print_r($areas);
	foreach ($artimes as $datee) {
		//print_r($datee);
		$t = strtotime($datee);
		$d = date("l, F d, Y",$t);
		//echo $d;
		fwrite($file ,$d . chr(9));
		}
		fputcsv($file ,$areas,'	');
	}
	fclose($file);
//讀心跳數據	
$timers = mysql_query("SELECT time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."'  AND `beat` IS NOT NULL AND time >= '". $_POST[from] ."' AND time <= '". $_POST[to] ."' ORDER BY `time` ASC");
$rs = mysql_query("SELECT beat FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' AND time >= '". $_POST[from] ." ' AND time <= '". $_POST[to] ."' ORDER BY `time` ASC");
$betlast=mysql_query("SELECT beat,time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' ORDER BY `sn` DESC limit 1");
$bet=mysql_fetch_row($betlast);
$file = fopen('./beat.tsv' , 'w');
fwrite($file,"# ----\n");
fwrite($file,"# Graph\n");
fwrite($file,"# -----\n");
//$artimes =mysql_fetch_row($timers);

while($areas = mysql_fetch_row($rs) and $artimes =mysql_fetch_row($timers)){	
		foreach ($artimes as $datee) {
	$t = strtotime($datee);
	$d = date("l, F d, Y", $t);
//	echo $datee;
	fwrite($file ,$d . chr(9));
	}
		fwrite($file,'0' . chr(9));
		fputcsv($file ,$areas,'	');

	    // 获取数据表列中最后那个值，若为空则表明上次查询并非该列
	    $area_prev = $areas["count_area"];
	    if(!empty($areas["count_area"]))
	        $area_query = $areas["count_area"];	
	}
	fclose($file);
//讀血氧數據	
$timers = mysql_query("SELECT time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."'  AND `oxygen` IS NOT NULL AND time >= '". $_POST[from] ." ' AND time <= '". $_POST[to] ."' ORDER BY `time` ASC");
$rs = mysql_query("SELECT oxygen FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' AND time >= '". $_POST[from] ." ' AND time <= '". $_POST[to] ."' ORDER BY `time` ASC");
$oxlast=mysql_query("SELECT oxygen,time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' ORDER BY `sn` DESC limit 1");
$ox=mysql_fetch_row($oxlast);
$file = fopen('./oxygen.tsv' , 'w');
fwrite($file,"# ----\n");
fwrite($file,"# Graph\n");
fwrite($file,"# -----\n");
//$artimes =mysql_fetch_row($timers);

while($areas = mysql_fetch_row($rs) and $artimes =mysql_fetch_row($timers)){	
		foreach ($artimes as $datee) {
	$t = strtotime($datee);
	$d = date("l, F d, Y",$t);
//	echo $datee;
	fwrite($file ,$d . chr(9));
	}
		fwrite($file,'0' . chr(9));
		fputcsv($file ,$areas ,'	');
	    // 获取数据表列中最后那个值，若为空则表明上次查询并非该列
	    $area_prev = $areas["count_area"];
	    if(!empty($areas["count_area"]))
	        $area_query = $areas["count_area"];	
	}
	fclose($file);
//讀血糖數據
//	 AND `asugar` IS NOT NULL OR AND `bsugar` IS NOT NULL 尚未測試
$timers = mysql_query("SELECT time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."'  AND `asugar` IS NOT NULL AND time >= '". $_POST[from] ." ' AND time <= '". $_POST[to] ."' ORDER BY `time` ASC");
$rs = mysql_query("SELECT asugar, bsugar FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' AND time >= '". $_POST[from] ." ' AND time <= '". $_POST[to] ."' ORDER BY `time` ASC");
$suglast=mysql_query("SELECT asugar, bsugar,time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' ORDER BY `sn` DESC limit 1");
$sug=mysql_fetch_row($suglast);
$file = fopen('./sugar.tsv' , 'w');
fwrite($file,"# ----\n");
fwrite($file,"# Graph\n");
fwrite($file,"# -----\n");
//$artimes =mysql_fetch_row($timers);

while($areas = mysql_fetch_row($rs) and $artimes =mysql_fetch_row($timers)){	
		foreach ($artimes as $datee) {
	$t = strtotime($datee);
	$d = date("l, F d, Y",$t);
//	echo $datee;
	fwrite($file ,$d . chr(9));
	}
		//fwrite($file,'0' . chr(9));
		//取飯前飯後把寫入檔案的0去掉
		fputcsv($file ,$areas ,'	');
	    // 获取数据表列中最后那个值，若为空则表明上次查询并非该列
	    $area_prev = $areas["count_area"];
	    if(!empty($areas["count_area"]))
	        $area_query = $areas["count_area"];	
	}
	fclose($file);
//讀體溫數據	
$timers = mysql_query("SELECT time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."'  AND `temperature` IS NOT NULL AND time >= '". $_POST[from] ." ' AND time <= '". $_POST[to] ."' ORDER BY `time` ASC");
$rs = mysql_query("SELECT temperature FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' AND time >= '". $_POST[from] ." ' AND time <= '". $_POST[to] ."' ORDER BY `time` ASC");
$temlast=mysql_query("SELECT temperature,time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' ORDER BY `sn` DESC limit 1");
$temp=mysql_fetch_row($temlast);
$file = fopen('./temperature.tsv' , 'w');
fwrite($file,"# ----\n");
fwrite($file,"# Graph\n");
fwrite($file,"# -----\n");
//$artimes =mysql_fetch_row($timers);

while($areas = mysql_fetch_row($rs) and $artimes =mysql_fetch_row($timers)){	
		foreach ($artimes as $datee) {
	$t = strtotime($datee);
	$d = date("l, F d, Y",$t);
//	echo $datee;
	fwrite($file ,$d . chr(9));
	}
		fwrite($file,'0' . chr(9));
		fputcsv($file ,$areas ,'	');
	    // 获取数据表列中最后那个值，若为空则表明上次查询并非该列
	    $area_prev = $areas["count_area"];
	    if(!empty($areas["count_area"]))
	        $area_query = $areas["count_area"];	
	}
	fclose($file);
//讀情緒數據	
$timers = mysql_query("SELECT time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."'  AND `emotion` IS NOT NULL AND time >= '". $_POST[from] ." ' AND time <='". $_POST[to] ."' ORDER BY `time` ASC");
$rs = mysql_query("SELECT emotion FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' AND time >= '". $_POST[from] ." ' AND time <='". $_POST[to] ."' ORDER BY `time` ASC");
$qlast=mysql_query("SELECT emotion,time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' ORDER BY `sn` DESC limit 1");
$tlast=mysql_fetch_row($qlast);
//讀取最後一筆數據
$file = fopen('./emotion.tsv' , 'w');
fwrite($file,"# ----\n");
fwrite($file,"# Graph\n");
fwrite($file,"# -----\n");
//$artimes =mysql_fetch_row($timers);

while($areas = mysql_fetch_row($rs) and $artimes =mysql_fetch_row($timers)){	
		foreach ($artimes as $datee) {
	$t = strtotime($datee);
	$d = date("l, F d, Y",$t);
//echo $datee;
	fwrite($file ,$datee . chr(9));
	}
		fwrite($file,'0' . chr(9));
		fputcsv($file ,$areas ,'	');
	    // 获取数据表列中最后那个值，若为空则表明上次查询并非该列
	    $area_prev = $areas["count_area"];
	    if(!empty($areas["count_area"]))
	        $area_query = $areas["count_area"];	
	}
	fclose($file);

//	$fp = fopen("./report-daily.".date("Ymd").'.csv', 'w'); //原始範例

//	foreach ($list as $line) {
//	    fputcsv($file, split(',', $line));
//	}
	//http://php.net/manual/en/function.fputcsv.php
?>

<script>
$(document).ready(function() {
//#innertabs1用於異常提示紀錄
		$( "#innertabs" ).tabs({
			ajaxOptions: {
				error: function( xhr, status, index, anchor ) {
					$( anchor.hash ).html(
						"Couldn't load this tab. We'll try to fix this as soon as possible. " +
						"If this wouldn't be a demo." );
				}
			},

		});

	//日期選擇		
	$(function() {
		var dates = $( "#from, #to" ).datepicker({
			showOn: "button",
			buttonImage: "./css/custom-theme/images/calendar.gif" ,
			buttonImageOnly: true,
			buttonText:"選擇日期",
			defaultDate: "-1m",
			changeMonth: true,
			numberOfMonths: 2,
			maxDate: '+0d',
			dateFormat: "yy/mm/dd",
			onSelect: function( selectedDate ) {
				var option = this.id == "from" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
	});

	//失去焦點時，input內會出現提示文字 
	$(function checkForm(){
		var barcodeDefault = "<?php
		echo $_POST[from];
		?>";
		var barcodeDefault2 = "<?php
		echo $today;
		?>";
		var f=document.forms.barcodeForm;
		if( f.from.value == '' || f.from.value == barcodeDefault ){
			f.from.value = barcodeDefault;
		}else{
		}
		//console.log(typeof(f.from.value));
		if( f.to.value == '' || f.to.value == barcodeDefault2 ){
			f.to.value =barcodeDefault2;
			return false;
		}else{
			return true;
		}
	});

	$('#barcodeForm').submit(function(e){
            //e.preventDefault();
            //var href = $(this).attr('href');
			 var formData = $("#barcodeForm").serialize();
			function onSuccess(){};
			function onError(){};
			$.ajax({
				type: "POST",
				url: './health/health.php',
				cache: false,
				data: formData,
				success: onSuccess,
				error: onError 
			});
			return false;			
    });
});
</script>


