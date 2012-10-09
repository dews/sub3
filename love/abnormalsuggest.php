<?php session_start(); ?>
<div class="container" style="position:relative;">
	<div class="abnormalsuggestleft" style="float:left;margin:10px">
	<caption>過去慢性病史處置建議<br>
		訂出關鍵字給子計畫4</caption>
		<table class="table table-bordered table-hover">
		<tr class='info'><td colspan="2">子計畫4已收到:</td></tr>
	<?php
	//連到子計畫4資料庫
	$dbServer = "sub4\SQLEXPRESS";
	$dbName = "D";
	$dbUser = "test1";
	$dbPass = "test";
	$connectionInfo =array( "UID"=>$dbUser,"PWD"=>$dbPass,"Database"=>$dbName,"CharacterSet" => "UTF-8");
	$conn=sqlsrv_connect($dbServer,$connectionInfo );
	//連線資料庫伺服器
	if( $conn ){
	//     echo "連線成功\n";
	}
	else{
		 echo "連線失敗\n";
		 die( print_r( sqlsrv_errors(), true));
	}

	if( $result === false ){
		echo "Error in executing query.&lt;/br&gt;";
		die( print_r( sqlsrv_errors(), true));
	}
	//清空子4資料庫
	$del="DELETE FROM [Sub4]";
	$del=sqlsrv_query($conn,$del);
	//子3傳子4
	include("../include/mysql_connect.inc.php");	
	$mysql=mysql_query("SELECT * FROM `tosub4`where time>(select max(date(`time`)) from `tosub4`)");	
	while($row = mysql_fetch_array($mysql)){
	//$row[1]=id,$row[2]=數值強度,$row[3]=病症
	 $params1 = array(
					  $row[1],
					  $row[2],
					  $row[3],
					);
	//print_r($params1);
	//echo '<br>';
	$tsql="INSERT INTO [Sub4] ([Sub4_id], [number],[Problem]) VALUES (?,?,?)";
	$stmt1=sqlsrv_query($conn,$tsql,$params1);					
	}

	
	//將mssql資料庫裡的最近一天所有資料顯示在畫面上
	$sql = "SELECT [number],[Problem] FROM [Sub4] WHERE [Sub4_id]='". $_SESSION['idcard'] ."' ";
	$result = sqlsrv_query($conn,$sql);
	//print_r($result);
	if($_SESSION['username']!=null){
		echo '<tr><td>使用者:'. $_SESSION['username'] .'</td></tr>';
	}else{
		echo '<tr><td>使用者:'. $_SESSION['idcard'] .'</td></tr>';
	}
	$checkloop=0;
	while($row = sqlsrv_fetch_array($result)){
		echo '<tr><td>建議：</td><td>'. $row[1] .'</td></tr>';
		$checkloop=1;
	}
	
	if( $checkloop==0){
		echo '<tr><td>無資料</td></tr>';
	}
	
	if( $stmt1 === false ){
		 echo "<tr class='success'><td colspan='2' >=上傳至子計畫四失敗=</td></tr></table>";
		 die( print_r( sqlsrv_errors(), true));
	}else{
		 echo "<tr class='success'><td colspan='2' >=成功上傳至子計畫四=</td></tr></table>";
	} 
	sqlsrv_free_stmt( $result);
	sqlsrv_close( $conn);
	?>
	</div>

	<div class="abnormalsuggestright" style="float:left;margin:10px;">
	<caption>最近量測結果處置建議<br>
	訂出關鍵字給子計畫2</caption>
	<table class="table table-bordered table-hover">
	<tr class='info'><td colspan="2">子計畫2已收到:</td></tr>
	<?php
	//設定時區,避免時間函數出問題。
	date_default_timezone_set('Asia/Taipei');
	
	if($_SESSION['username']!=null){
		echo '<tr><td>使用者:'. $_SESSION['username'] .'</td></tr>';
	}else{
		echo '<tr><td>使用者:'. $_SESSION['idcard'] .'</td></tr>';
	}
	
	include("../include/mysql_connect.inc.php");	
	$checkloop=0;
	$rs=mysql_query("SELECT `idcard`,`emotion` ,`time` FROM `detect` where `idcard`='". $_SESSION['idcard'] ."' and time>(select max(date(`time`)) from `detect` where `idcard`='". $_SESSION['idcard'] ."' )");	
	while($row = mysql_fetch_array($rs)){
		//int_r($row);
		//echo '使用者:'. $row[0] ;
		//echo '<tr><td>情緒指數：</td><td>'.$row[1] .'</td><tr>';
		//echo '<tr><td>時間：</td><td>'. $row[2] .'</td><tr>';
		$userid=$row[0];
		$emotion=$row[1];
		$time=$row[2];
		//$checkloop=1;
	}


	//連到子計畫2資料庫
	$dbServer = "sub4\SQLEXPRESS";
	$dbName = "sub2";
	$dbUser = "splash";
	$dbPass = "12345";
	$link=mssql_connect($dbServer, $dbUser, $dbPass);
	//連線資料庫伺服器
	if ( !$link)
	die("無法連線資料庫伺服器");

	//選擇資料庫
	if ( ! @mssql_select_db($dbName) )
	die("無法使用資料庫");
	
	$del="DELETE FROM [dbo].[sub2]";
	$del=mssql_query($del);

	$rs=mssql_query("INSERT INTO  [sub2] ([userid], [emotion],[time]) VALUES ('". $userid ."', '". $emotion ."','". $time ."')");	
	
	//將資料庫裡的所有資料顯示在畫面上
	$sql = "SELECT * FROM Sub2 where userid='". $_SESSION['idcard'] ."' ";
	$result = mssql_query($sql);
	$checkloop=0;
	while($row = mssql_fetch_array($result)){
		//收到日期格式"09 25 2012 1:24PM"，strtotime接受格式為"09/25/2012 1:24PM"
		//http://php.net/manual/en/datetime.formats.date.php
		$arrtime=explode(' ', $row[4]); 
		$temptime=$arrtime[0] ."/".$arrtime[1] ."/". $arrtime[2] ." ". $arrtime[4];
		$temptime=strtotime($temptime);
		echo '<tr><td>情緒指數：</td><td>'.$row[2] .'</td><tr>';
		echo '<tr><td>時間：</td><td>'. date("Y-m-d",$temptime) .'</td><tr>';
		$checkloop=1;		
	}
		
	if( $checkloop==0){
		echo '<tr><td>無資料</td></tr>';
	}	
	
	if( $rs === false ){
		 echo "<tr class='success'><td colspan='2' >=上傳至子計畫二失敗=</td></tr></table>";
		 die( print_r( sqlsrv_errors(), true));
	}else{
		 echo "<tr class='success'><td colspan='2' >=成功上傳至子計畫二=</td></tr></table>";
	} 

	?>
	</div>
</div>
<script type="text/javascript">
    
$(document).ready(function() {
/* 	$("#demo3").wijgrid({ 
		pageSize: 20, 
		pagerSettings: { mode:"numericFirstLast",position: "top" }, 
		data:oringdata , 
		columns: [ 
			{ headerText: "過去慢性病史處置建議<br>訂出關鍵字給子計畫4" }, 
			{ headerText: "   " }, 
			{ headerText: "最近量測結果處置建議訂出關鍵字給子計畫2" }, 
		] 
	}); 
	
	function onSuccess(data, status){
				data = $.trim(data);
				$("#a").html(data);
	 }
	function onError(data, status){
				// handle an error
		}     */
});
</script>