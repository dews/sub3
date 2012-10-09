<?php session_start(); ?>
<?php
if($_SESSION['idcard']!=null){
	echo '<script type="text/javascript">';
	echo '$(document).ready(function(){';	
	echo ' $("#pic").show();';
	echo'$("form.navbar-form.pull-right").hide();});';
	echo '</script>';
	echo "<img src=\"./system/showpic.php?photoname=". $_SESSION["userphoto"] . "\" style='margin:0px auto 10px auto;'>";
	
	echo '<br><p>目前使用者:'; 
	if($_SESSION['username']!=''){
		echo $_SESSION['username'] .'</p><br>';
	}else{
		echo $_SESSION['idcard'] .'</p><br>';
	}
	//echo $_SESSION['userphoto'];
}else{
	echo '<script type="text/javascript">';
	echo '$(document).ready(function(){';	
	echo ' $("#pic").hide();});';
	echo '</script>';
}
?>