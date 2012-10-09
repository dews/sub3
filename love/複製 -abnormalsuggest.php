<?php session_start(); ?>
<div class="container" style="position:relative;">
	<div class="abnormalsuggestleft" style="float:left">
		<p>過去慢性病史處置建議<BR>
		訂出關鍵字給子計畫4<br>
		子計畫4已收到:<br>
	<?php
	include("../include/mysql_connect.inc.php");	
	$mysql=mysql_query("SELECT * FROM `tosub4`where time>(select max(date(`time`)) from `tosub4`)");	

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
	
	$del="DELETE FROM [Sub4]";
	$del=sqlsrv_query($conn,$del);
	
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

	
	//將mysql資料庫裡的最近一天所有資料顯示在畫面上
	$sql = "SELECT [number],[Problem] FROM [Sub4] WHERE [Sub4_id]='". $_SESSION['idcard'] ."' ";
	$result = sqlsrv_query($conn,$sql);
	//print_r($result);
	if($_SESSION['username']!=null){
		echo '使用者:'. $_SESSION['username'] .'<BR>';
	}else{
		echo '使用者:'. $_SESSION['idcard'] .'<BR>';
	}
	
	while($row = sqlsrv_fetch_array($result)){
		   echo '建議：'. $row[1] .'<BR>';
	}
	
	if( $stmt1 === false ){
		 echo "======上傳至子計畫四失敗======<br>";
		 die( print_r( sqlsrv_errors(), true));
	}else{
		 echo "======成功上傳至子計畫四======<br>";
	} 
	sqlsrv_free_stmt( $result);
	sqlsrv_close( $conn);
	?>
	</div>

	<div class="abnormalsuggestright" style="float:left">
		<p>最近量測結果處置建議<BR>
		訂出關鍵字給子計畫2<br>
		<?php
	include("../include/mysql_connect.inc.php");	

	$rs=mysql_query("SELECT * FROM `emotiontosub2` where userid='". $_SESSION['idcard'] ."'");	
	while($row = mysql_fetch_array($rs)){
				//int_r($row);
		echo '<p>使用者:'. $row[0] .'<br>';
		echo '<BR>情緒指數：'.$row[1] .'<br>';
		echo '<BR>時間：'. $row[2] .'<br>';
		$userid=$row[0];
		$emotion=$row[1];
		$time=$row[2];
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

		//將資料庫裡的所有資料顯示在畫面上
		$sql = "SELECT * FROM Sub2 where userid='". $_SESSION['idcard'] ."' ";
		$result = mssql_query($sql);
		while($row = mssql_fetch_array($result)){
		 //  echo '<p>使用者:'. $row[0] .'<BR>情緒指數：'. $row[1] .'<BR>時間：'. $row[3] .'</p>';				 	 
		}
	$rs=mssql_query("INSERT INTO  [sub2] ([userid], [emotion]) VALUES ('". $userid ."', '". $emotion ."')");

	?>
	</div>
</div>
<script type="text/javascript">
    
$(document).ready(function() {
	$("#demo3").wijgrid({ 
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
		}    
});
</script>