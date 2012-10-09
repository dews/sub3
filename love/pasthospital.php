<?php session_start(); ?>
<style type="text/css">	
.ui-datepicker-trigger {
	vertical-align: text-top;
	margin:2px;
}
</style>
<div id="inner" style="width:600px" > 
	<!-- Begin demo markup -->
	<table id="demo2" style="min-width: 600px!important;"> 
	</table> 
	<br>
</div> 
<?php
if($_SESSION['idcard']==null){
	echo '<p>請先登入...</p>';
	echo '<script type="text/javascript">';
	echo '$("#temp").load("../system/presetinfo.php");';
	echo '</script>';
	echo "<div id='temp'></div>";
	exit;
}else{}

include("../include/mysql_connect.inc.php");

date_default_timezone_set('Asia/Taipei');

if($_POST[hospital]!=null){
$_POST[idcard]=$_SESSION['idcard'];
	//$time=$_POST[select_year] .'-'. $_POST[select_month] . '-' . $_POST[select_day];
if (mysql_query("insert into pasthospital(idcard, hospital, time, disease)
				values('$_POST[idcard]','$_POST[hospital]','$_POST[time]','$_POST[disease]')")){
	echo '<p>新增成功</p>';
}else{
	echo '<p>新增失敗</p>';
	echo '<script type="text/javascript">';
	echo '$("#ui-tabs-8").load("./love/pasthospital.php");';
	echo '</script>';

}}else{
	$result = mysql_query("SELECT hospital, time, disease 
					FROM pasthospital 
					WHERE idcard = '". $_SESSION['idcard'] ."'");

	echo '<script id="scriptInit" >';	
	echo 'var oringdata=[];'	;
	echo 'var temp=[];'	;
	$i=0;	
	while($row = mysql_fetch_row($result)){

		echo 'temp=[\''. $row[0] .'\',';
		echo '\''. $row[1] .'\',';
		echo '\''. $row[2] .'\'];';		
		echo 'oringdata.push(temp);';	

	}	
	//當陣列無資料，顯示無,無,無
	echo 'if(oringdata.length <1){';
	echo "oringdata=[['無','無','無']];}";
	echo 'console.log( oringdata);';
	echo '</script>';
}
?>

<p>新增就醫紀錄</p>
<div id="new"></div>
<form id="past">
	就醫醫院:<input type="text" name="hospital" x-webkit-speech ><br>
	時間:	<input type="text" id="datepicker2" name="time">
	<label>疾病:
		<select name="disease">
		<?php
		$str="SELECT diseasename FROM analysis ";
		$list =mysql_query($str);
		while(list($disName) = mysql_fetch_row($list)){
			echo "<option value=".$disName.">".$disName."</option>\n";
		}
		?>
		</select>
	<input type="submit" name="b1" value="輸入">
</form>

<script type="text/javascript">
function onSuccess(data, status) {
	$("#ui-tabs-8").load("./love/pasthospital.php");
	$("#new").html('新增成功');
}

function onError(data, status){
            console.log("error");
}
        
$(document).ready(function() {
	$('#past').submit(function(e){
		//e.preventDefault();
		//var href = $(this).attr('href');
		 var formData = $("#past").serialize();
 
		$.ajax({
			type: "POST",
			url: './love/pasthospital.php',
			cache: false,
			data: formData,
			success: onSuccess,
			error: onError 
		});
		return false;			
    });
	
	$("#demo2").wijgrid({ 
		pageSize: 20, 
		pagerSettings: { mode:"numericFirstLast",position: "top" }, 
		data:oringdata , 
		columns: [ 
			{ headerText: "醫院" }, { headerText: "時間" }, { headerText: "病因" }, 
		] 
	}); 
	
	$("#datepicker2").datepicker({
		showOn: "button",
		buttonImage: "./css/custom-theme/images/calendar.gif",
		buttonImageOnly: true,
		dateFormat: "yy-mm-dd"
		});
});
</script>
