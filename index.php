<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<head lang="zh-TW">	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>子計畫一</title>
	<!--Theme-->
	<link href="http://cdn.wijmo.com/themes/rocket/jquery-wijmo.css" rel="stylesheet"/>
	<link href="./css/customtab/jquery-ui-1.8.23.custom.css" rel="stylesheet"  />
	<link href="./bootstrap/bootstrap.min.css" rel="stylesheet">
	<link href="./bootstrap/bootstrap-responsive.min.css" rel="stylesheet">
	<!--Wijmo Widgets CSS-->
	<link href="http://cdn.wijmo.com/jquery.wijmo-complete.all.2.2.0.min.css" rel="stylesheet"  />

	<style>	
	img{
		vertical-align:bottom; /* 原因http://www.wheattime.com/images-tables-and-mysterious-gaps.html */
	}

	body,html{ 
		height: 100%; 
	}
	.wrap{
		 min-height: 100%;
	}
	.wijmo-wijtabs-content {
		float: left!important;
		/*width: 80%!important;要讓1024*768放得下*/
	}
	#footer {
		position: relative;
		font-size: 12px;
		margin-top: -100px
	}

	.customtab{
		float:left;
	}
	ui-tabs .ui-tabs-hide { 
		display:block!important;
		position: absolute!important; 
		left: -10000px!important;
	}
	#pic{
		width:auto;
		height:150px;
		position: absolute;
		right:10px;
		padding:5px;
		padding-bottom: 20px;
		text-align : center;
		 /*圓角 */
		-webkit-border-radius: 10px;
		-moz-border-radius: 10px;
		border-radius: 10px;
	}
	.ui-tabs-left .ui-tabs-nav li{
		-webkit-border-top-right-radius: 4px;
		-webkit-border-bottom-right-radius: 4px;
		-moz-border-radius-topright: 4px;
		-moz-border-radius-bottomright: 4px;
		border-top-right-radius: 4px;
		border-bottom-right-radius: 4px;
	}
	.ui-tabs-left .ui-tabs-nav {
		min-height: 400px;
	}
	#tabs{
		margin-bottom:110px;
	}
	</style>
	<script  src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js" ></script>
</head>
<body>
	<div class="wrap">
		<div class="navbar-fixed-top">
			<ul id="menu1"> 
				<li><a href="../homepage/"><span class="ui-icon ui-icon-arrowthick-1-w wijmo-wijmenu-icon-left"></span><span class="wijmo-wijmenu-text">首頁</span></a></li> 
				<li><a><span class="ui-icon ui-icon-arrowrefresh-1-s wijmo-wijmenu-icon-left"></span><span class="wijmo-wijmenu-text">開心農場</span></a> 
					<ul> 
						<li><a>submenu1</a></li> 
						<li><a>submenu2</a></li> 
						<li><a>submenu3</a></li> 
						<li><a>submenu4</a></li> 
					</ul> 
				</li> 
				<li><a href="../infover3/" ><span class="ui-icon ui-icon-comment wijmo-wijmenu-icon-left"></span>
					<span class="wijmo-wijmenu-text">居家安全</span></a>
				</li> 
				<li><a href="http://163.22.249.64/sub3/" class="ui-state-hover"><span class="ui-icon ui-icon-person wijmo-wijmenu-icon-left"></span>
					<span class="wijmo-wijmenu-text">健康守護</span></a>
				</li> 
				<li><a><span class="ui-icon ui-icon-trash wijmo-wijmenu-icon-left"></span>
					<span class="wijmo-wijmenu-text">生活資訊</span></a>
				</li> 
				<li><a><span class="ui-icon ui-icon-bookmark wijmo-wijmenu-icon-left"></span>
					<span class="wijmo-wijmenu-text">愛心關懷</span></a>
				</li> 
				<?
				if($_SESSION['idcard'] != null){
				//	echo $_SESSION['username'];
					echo '<script type="text/javascript">';
					echo '$(document).ready(function(){';	
					echo ' $("#pic").show();';
					echo '$("#pic").load("./system/id.php");});';
					echo '</script>';
				}else{
					echo '<script type="text/javascript">';
					echo '$(document).ready(function(){';	
					echo ' $("#pic").hide();});';
					echo '</script>';
				}
				?>	
				<li><div id="switcher"  style="right: 180px;position: absolute!important"></div></li>
				<li><div id=pic class="ui-widget-header" style="display:none;"></div></li>
			</ul> 
		</div>
		<div class="container" style="padding-top: 55px; ">
			<div id="tabs" >
				<ul style="width: 160px;margin:10px 10px 150px;">
					<li style="opacity: .8;"><a href="" style="color:yellow; font-size: 125%;">健康管理</a></li>
					<li ><a href="./health/health.php">健康查詢管理</a></li>
					<li ><a href="./health/decemotion.php">情緒指數量測</a></li>
					<li style="opacity: .8;"><a href="" style="color:yellow; font-size: 125%;">健康異常</a></li>
					<li ><a href="./abnormal/abnormalrecord.php">異常提示紀錄</a></li>
					<li ><a href="./abnormal/setabnormalwarning.php">異常提示設定</a></li>
					<li style="opacity: .8;"><a href="" style="color:yellow; font-size: 125%;">關懷聯繫</a></li>
					<li ><a href="./love/pasthospital.php">過去就醫紀錄</a></li>
					<li><a href="./love/abnormalsuggest.php">健康問題處置</a></li>
					<li ><a href="./love/customized.php">客製衛教知識</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div id="footer" class="ui-widget-header well well-small navbar-fixed-bottom">
		<div class="container"><h3>南開科技大學</h3>
		國科會補助私立大學校院發展發展研發特色
		「銀髮族智慧生活之創新技術整合研發計畫」
		</div>
	</div>

	 <!--jQuery References-->
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"  ></script>
	<script src="./js/jquery.themeswitcher.js"></script>
	<!--backbonejs-->
	<script  src="http://documentcloud.github.com/underscore/underscore-min.js" ></script>
	<script  src="http://documentcloud.github.com/backbone/backbone-min.js"></script>
	
	<!--Knockout JS Library-->
	<script src="http://cdn.wijmo.com/external/knockout-2.0.0.js" ></script>

	<!--Wijmo Knockout Integration Library-->
	<script src="http://cdn.wijmo.com/external/knockout.wijmo.js"></script>
	
	<!--Wijmo Widgets JavaScript-->
	<script src="http://cdn.wijmo.com/jquery.wijmo-open.all.2.1.0.min.js" ></script>
	<script src="http://cdn.wijmo.com/jquery.wijmo-complete.all.2.2.0.min.js" ></script>
	
	<!--Culture-->
	<script src="http://cdn.wijmo.com/external/cultures/globalize.culture.zh-TW.js" ></script>
	
	<script src="./js/app.js"></script>
	
	<!--bootstrap-->		
	<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.1.0/js/bootstrap.min.js"></script>
	
</body>
</html>
