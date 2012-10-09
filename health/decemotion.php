<?php session_start(); ?>
<?php
date_default_timezone_set('Asia/Taipei');

include("../include/mysql_connect.inc.php");

if($_POST['mood']!=null){
	$mood=$_POST['mood'];

	$sql = "INSERT INTO `oldmantest`.`detect` (`sn`,`idcard`, `highblood`, `lowblood`, `beat`, `oxygen`, `asugar`, `bsugar`, `temperature`, `emotion`, `time`) VALUES (NULL, '". $_SESSION['idcard'] ."', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '".$mood ."', CURRENT_TIMESTAMP);";

	if (mysql_query($sql)){
		echo '<p>新增成功</p>';

	}else{
		echo '<p>新增失敗</p>';
	}
	$result = mysql_query("SELECT ". $_POST[mood] ."
						FROM `oldmantest`.`detect`
						WHERE idcard = '". $_SESSION['idcard'] ."'");

}
?>
<style>
video { width:90%; }
canvas { width:90%; }
input[type="button"],


</style>
<p class="alert alert-info">影像辨識拍照:	</p>
<div  class="container-fluid">
	<section id="app" hidden class="span4">
		<section id="splash" >
			<p id="errorMessage"  class="alert alert-error"></p>
		</section>
		<video id="monitor" autoplay style="display: block;"></video>
		<input value="辨識按鈕" type=button  id="snapshotbutton"  class="btn">
		<input value="送出辨識結果" type=summit id="sendresult"  class="btn">
		<canvas id="photo" style="display: block;"></canvas>
	</section>

	<div id="result" class="span2"><p class="alert alert-info">情緒量測結果:</p>
	<div id="sendsucc" class="alert alert-success" style="display:none">資料傳送成功</div></div>
</div> <!-- /container -->

<script>
$(document).ready(function(){

	init();

	var faceKey = "273820b2f569465fd7f27cdb574b16da";
	var faceSecret = "8c9c67d954993f7cfdf5fe3c18e5bae9";
	//credit http://stackoverflow.com/a/8782422/52160

	function dataURItoBlob(dataURI, callback) {
			// convert base64 to raw binary data held in a string
			// doesn't handle URLEncoded DataURIs
			//把base64圖片還原,分開"data:image/png;base64,xxxxx"逗號
			var byteString;
			if (dataURI.split(',')[0].indexOf('base64') >= 0) {
				byteString = atob(dataURI.split(',')[1]);
			} else {
				byteString = unescape(dataURI.split(',')[1]);
			}
			// separate out the mime component,取得image/png
			var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
			// write the bytes of the string to an ArrayBuffer
			var ab = new ArrayBuffer(byteString.length);
			var ia = new Uint8Array(ab);
			for (var i = 0; i < byteString.length; i++) {
				ia[i] = byteString.charCodeAt(i);
			}
			// write the ArrayBuffer to a blob, and you're done
			window.URL = window.URL || window.webkitURL;
			return bb = new Blob([ab],{'type':mimeString});
	}

	function errorHandler(e) {
		console.log("Error");
		console.dir(e);
	}
//console.log(document.getElementById('splash'));
	function init() {
		if (navigator.webkitGetUserMedia) {
		$("#splash").hide();
			navigator.webkitGetUserMedia({video:true}, gotStream, noStream);
			var video = document.getElementById("monitor");//video
			var canvas = document.getElementById('photo');
			function gotStream(stream) {
				video.src = webkitURL.createObjectURL(stream);
				video.onerror = function () {
					stream.stop();
					streamError();
				};
				document.getElementById('app').hidden = false;
				
				$("#snapshotbutton").click(snapshot);					
			}

			function noStream() {

				$("#splash").show(1000,function(){
					$("#errorMessage").text('無法取得攝影機');
				});
			}
			
			function streamError() {
				$("#splash").show(1000,function(){
					$("#errorMessage").text('攝影機錯誤');
				});
			}

			function snapshot() {
				$("#result").html("<p><i>分析中請稍後...</i></p>");
				$("#fileToUpload").attr("value","已選定");
				canvas.width = video.videoWidth;
				canvas.height = video.videoHeight;
				canvas.getContext('2d').drawImage(video, 0, 0);
				var data = canvas.toDataURL('image/jpeg', 1.0);
				$("#a6").attr("value",data);
				newblob = dataURItoBlob(data);
				var formdata = new FormData();
				formdata.append("api_key", faceKey);
				formdata.append("api_secret", faceSecret);
				formdata.append("filename","temp.jpg");
				formdata.append("file",newblob); 
				 $.ajax({
					 url: 'http://api.face.com/faces/detect.json?attributes=all',
					 data: formdata,
					 cache: false,
					 contentType: false,
					 processData: false,
					 dataType:"json",
					 type: 'POST',
					 success: function (data) {
						 handleResult(data.photos[0]);
					 }
				 });    
			}

			function handleResult(photo) {
				console.dir(photo );
				//console.dir(%a);
				  
				var s = "<h3>結果</h3>";
				if(photo.tags.length) {
					var tag = photo.tags[0];
					if(tag.tid){
						$("#tid").attr("value",tag.tid);
					}
					s += "<p>";
					if(tag.attributes.gender){
						if(tag.attributes.gender.value=='male'){
							var sex="男";
						}else if(tag.attributes.gender.value=='female'){
							var sex="女";							        
						}else{}
						s += "<b>性別:</b> " + sex + "<br/>";
						$("#a4").attr("value",sex);
					}
					if(tag.attributes.glasses){
						if(tag.attributes.glasses.value=='true'){
							var glass="有";
						}else if(tag.attributes.glasses.value=='false'){
							var glass='無';                                    
						}else{}
						s += "<b>眼鏡:</b> " + glass + "<br/>";
					}
					if(tag.attributes.smiling){
						if(tag.attributes.smiling.value=='true'){
							var smile="有";
						}else if(tag.attributes.smiling.value=="false"){
							var smile='無';                                    
						}else{}							    
						s += "<b>笑容:</b> " + smile + "<br/>";
					 }
					if(tag.attributes.age_est){	    
						s += "<b>年齡:</b> " + tag.attributes.age_min.value +"-"+tag.attributes.age_max.value + "<br/>";
						$("#a5").attr("value",tag.attributes.age_est.value);
					}
					if(tag.attributes.mood){
						if(tag.attributes.mood.value=='happy'){
							var mood='歡喜';
							var moodvalue='pl'+tag.attributes.mood.confidence;
						}else if(tag.attributes.mood.value=='sad'){
							var mood='悲傷'; 
							var moodvalue='so'+tag.attributes.mood.confidence;
						}else if(tag.attributes.mood.value=='surprised'){
							var mood='快樂'; 
							var moodvalue='jo'+tag.attributes.mood.confidence;
						}else if(tag.attributes.mood.value=='neutral'){
							var mood='平靜';
							var moodvalue='co'+tag.attributes.mood.confidence;
						}else if(tag.attributes.mood.value=='angry'){
							var mood='生氣';  
							var moodvalue='an'+tag.attributes.mood.confidence;
						}else{} 
						
						if(moodvalue!=null){
							$("#sendresult").click(function(){
									console.log(moodvalue);
								var aa=sentemo(moodvalue);	
							}
							);
						}
						 s += "<b>情緒:</b> " + mood + "<br/>";
					 }
					if(tag.attributes.length == 0) s += "圖片不夠清楚";
					
					s += "</p>";
				} else {
					s += "<p>找不到人臉</p>";
				}
				$("#result").html(s);
			}
		} else {
			$("#splash").show(1000,function(){
				$("#errorMessage").text('沒有可用的攝影機');
			});
		}
	}
	
	function sentemo(abc){
		$.ajax({
			type: "POST",
			url: './health/decemotion.php',
			cache: false,
			data: {'mood':abc},
			success: onSuccess,
			error: onError 
		});
		function onSuccess(data){
		$('#sendsucc').show();
		console.log('OK');
		}	
		function onError(data){
		console.log('有錯誤');
		}	
	}
});
</script>	

