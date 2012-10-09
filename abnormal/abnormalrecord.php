<?php session_start(); ?>
<style type="text/css">	
.customtab .ui-tabs .ui-tabs-nav {
min-height: 0px;
width:99%;
margin:auto;
}
.customtab .ui-tabs .ui-tabs-nav li {
width: auto;
}
</style>
<div class="customtab">
	<div id="innertabs2">
		<ul>
			<li><a href="#tabs-1">血壓異常</a></li>
			<li><a href="#tabs-2">心跳異常</a></li>
			<li><a href="#tabs-3">血氧異常</a></li>
			<li><a href="#tabs-4">血糖異常</a></li>
			<li><a href="#tabs-5">體溫異常</a></li>
			<li><a href="#tabs-6">情緒異常</a></li>
		</ul>

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
			echo '<div id="tabs-1">';
			echo '<div id="pager1"></div>';
			echo '<table class="table  table-hover" id="pagedTable1">';
			echo '<thead class="ui-widget-header" class="ui-widget-header"><tr><th>縮收壓</th><th>舒張壓</th><th>時間</th></tr></thead><tbody>';
			while($areas = mysql_fetch_row($rs)){
				echo '<tr>';
				foreach ($areas as $abs) {
					echo '<td>' . $abs . '</td>';
				}
				echo '</tr>'; 
				 // 获取数据表列中最后那个值，若为空则表明上次查询并非该列
					$area_prev = $areas["count_area"];
					if(!empty($areas["count_area"]))
						$area_query = $areas["count_area"];
			}
			echo '</tbody></table>';
			echo '</div>';

			$rs = mysql_query("SELECT beat, time 
				FROM detect 
				WHERE idcard = '". $_SESSION['idcard'] ."' 
				AND ( beat>100 OR beat<55)
				ORDER BY time");
			echo '<div id="tabs-2">';
			echo ' <div id="pager2"></div> ';
			echo '<table class="table  table-hover" id="pagedTable2">';
			echo '<thead class="ui-widget-header" class="ui-widget-header"><tr><th>心跳</th><th>時間</th></tr></thead >';
			while($areas = mysql_fetch_row($rs)){
				echo '<tr>';
				foreach ($areas as $abs) {
				echo '<td>' . $abs . '</td>';
				}
				echo '</tr>'; 
					// 获取数据表列中最后那个值，若为空则表明上次查询并非该列
					$area_prev = $areas["count_area"];
					if(!empty($areas["count_area"]))
						$area_query = $areas["count_area"];
			}	
			echo '</table>';	
			echo '</div>';
				
			$rs = mysql_query("SELECT oxygen, time 
				FROM detect 
				WHERE idcard = '". $_SESSION['idcard'] ."' 
				AND ( oxygen>100 OR oxygen<90)
				ORDER BY time");
			echo '<div id="tabs-3">';
			echo ' <div id="pager3"></div> ';
			echo '<table class="table  table-hover" id="pagedTable3">';
			echo '<thead class="ui-widget-header" ><tr><th>血氧</th><th>時間</th></tr></thead >';
			while($areas = mysql_fetch_row($rs))
				{
				echo '<tr>';
				foreach ($areas as $abs) {
				echo '<td>' . $abs . '</td>';
				}
				echo '</tr>'; 
					// 获取数据表列中最后那个值，若为空则表明上次查询并非该列
					$area_prev = $areas["count_area"];
					if(!empty($areas["count_area"]))
						$area_query = $areas["count_area"];
				}
			echo '</table>';	
			echo '</div>';

			$rs = mysql_query("SELECT bsugar, time 
				FROM detect 
				WHERE idcard = '". $_SESSION['idcard'] ."' 
				AND ( bsugar>110 OR bsugar<70)
				ORDER BY time");
			echo '<div id="tabs-4">';
			echo ' <div id="pager4"></div> ';
			echo '<table class="table  table-hover" id="pagedTable4">';
			echo '<thead class="ui-widget-header" ><tr ><th>飯前血糖</th><th>時間</th></tr></thead >';
			while($areas = mysql_fetch_row($rs))
				{	
				echo '<tr>';
				foreach ($areas as $abs) {
					if($abs==null){
						echo '<td>正常</td>';
					}else{
						echo '<td>' . $abs . '</td>';
					}
				}
				echo '</tr>'; 
					// 获取数据表列中最后那个值，若为空则表明上次查询并非该列
					$area_prev = $areas["count_area"];
					if(!empty($areas["count_area"]))
						$area_query = $areas["count_area"];
				}	
			echo '</table>';	


			$rs = mysql_query("SELECT asugar, time 
				FROM detect 
				WHERE idcard = '". $_SESSION['idcard'] ."' 
				AND ( asugar>200 OR asugar<80)
				ORDER BY time");
			echo ' <div class="pager4-2"></div> ';
			echo '<table class="table  table-hover" id="pagedTable4-2">';
			echo '<thead class="ui-widget-header" ><tr ><th>飯後血糖</th><th>時間</th></tr></thead >';
			while($areas = mysql_fetch_row($rs))
				{	
				echo '<tr>';
				foreach ($areas as $abs) {
					if($abs==null||$abs==0){
						echo '<td>正常</td>';
					}else{
						echo '<td>' . $abs . '</td>';
					}
				}
				echo '</tr>'; 
					// 获取数据表列中最后那个值，若为空则表明上次查询并非该列
					$area_prev = $areas["count_area"];
					if(!empty($areas["count_area"]))
						$area_query = $areas["count_area"];
				}	
			echo '</table>';	
			echo '</div>';

				$rs = mysql_query("SELECT temperature, time 
				FROM detect 
				WHERE idcard = '". $_SESSION['idcard'] ."' 
				AND ( temperature>38 OR temperature<35)
				ORDER BY time");
			echo '<div id="tabs-5">';
			echo ' <div id="pager5"></div> ';
			echo '<table class="table  table-hover" id="pagedTable5">';
			echo '<thead class="ui-widget-header" ><tr class="info"><th>體溫</th><th>時間</th></tr></thead >';
			while($areas = mysql_fetch_row($rs)){
				echo '<tr>';
				foreach ($areas as $abs) {
					if($areas==null||$abs==null){
						echo '正常';
					}else{
						echo '<td>' . $abs . '</td>';
					}
				}
				echo '</tr>'; 
					// 获取数据表列中最后那个值，若为空则表明上次查询并非该列
				$area_prev = $areas["count_area"];
				if(!empty($areas["count_area"]))
				$area_query = $areas["count_area"];
			}
			echo '</table>';	
			echo '</div>';	

				$rs = mysql_query("SELECT  emotion, time 
				FROM detect 
				WHERE idcard = '". $_SESSION['idcard'] ."' 
				AND ( emotion>8 OR emotion<2)
				ORDER BY time");
			echo '<div id="tabs-6">';
			echo ' <div id="pager6"></div> ';
			echo '<table class="table  table-hover" id="pagedTable6">';
			echo '<thead class="ui-widget-header" ><tr ><th>情緒</th><th>時間</th></tr></thead ><tbody>';
			while($areas = mysql_fetch_row($rs)){
				echo '<tr>';
				foreach ($areas as $abs) {
					if($areas==null||$abs==null){
						echo '正常';
					}else{
						echo '<td>' . $abs . '</td>';
					}
				}
				echo '</tr>'; 
					// 获取数据表列中最后那个值，若为空则表明上次查询并非该列
				$area_prev = $areas["count_area"];
				if(!empty($areas["count_area"]))
				$area_query = $areas["count_area"];
			}
			echo '</tbody></table>';	
			echo '</div>';	
			?>
		</div>
	</div>
	
<script>
$(document).ready(function() {
	$( "#innertabs2" ).tabs({
		ajaxOptions: {
			error: function( xhr, status, index, anchor ) {
				$( anchor.hash ).html(
					"Couldn't load this tab. We'll try to fix this as soon as possible. " +
					"If this wouldn't be a demo." );
			}
		},
		show:function( xhr, status, index, anchor ) {

		}
	});	
    var $rows1; 
    var pageSize = 10; 
  
    $rows1 = $("#pagedTable1 >tbody >tr"); 
  
    $("#pager1").wijpager({ pageCount: Math.ceil($rows1.length / pageSize) || 1, 
        mode: "numericFirstLast", pageIndexChanged: onPageIndexChanged1
    }); 
  
    onPageIndexChanged1(); 

	function onPageIndexChanged1() { 
		var pageIndex = $("#pager1").wijpager("option", "pageIndex"); 
		var showFrom = pageIndex * pageSize; 
		var showTo = showFrom + pageSize; 

		$.each($rows1, function (index, tr) { 
				//console.log(index);
			if (index >= showFrom && index < showTo) { 
	
				$(tr).show(); 
											//console.log('a');
			} else { 
				$(tr).hide(); 
											//console.log('b');
			} 
		}); 
	}; 	

	});	
</script>	
<script>	

		tabepage();	
		var $rows2; 
		var pageSize = 10; 
		function tabepage(){

		$rows2 = $("#pagedTable2 >tbody >tr"); 
	  
		$("#pager2").wijpager({ pageCount: Math.ceil($rows2.length / pageSize) || 1, 
			mode: "numericFirstLast", pageIndexChanged: onPageIndexChanged 
		}); 
		
		onPageIndexChanged();   
	}

    function onPageIndexChanged() { 
	
		var pageIndex = $("#pager2").wijpager("option", "pageIndex"); 
		//目前頁面數
		var showFrom = pageIndex * pageSize; 
		//目前頁面數*總頁數
		var showTo = showFrom + pageSize; 
			//console.log(showTo);
		$.each($rows2, function (index, tr) { 
			if (index >= showFrom && index < showTo) { 
				$(tr).show(); 
			} else { 
				$(tr).hide(); 
			} 
		}); 
	}; 
</script>	
<script>	

		tabepage();	
		var $rows3; 
		var pageSize = 10; 
		function tabepage(){

		$rows3 = $("#pagedTable3 >tbody >tr"); 
	  
		$("#pager3").wijpager({ pageCount: Math.ceil($rows3.length / pageSize) || 1, 
			mode: "numericFirstLast", pageIndexChanged: onPageIndexChanged 
		}); 
		
		onPageIndexChanged();   
	}

    function onPageIndexChanged() { 
	
		var pageIndex = $("#pager3").wijpager("option", "pageIndex"); 
		//目前頁面數
		var showFrom = pageIndex * pageSize; 
		//目前頁面數*總頁數
		var showTo = showFrom + pageSize; 
		//	console.log(showTo);
		$.each($rows3, function (index, tr) { 
			if (index >= showFrom && index < showTo) { 
				$(tr).show(); 
			} else { 
				$(tr).hide(); 
			} 
		}); 
	}; 
</script>
<script>	

		tabepage();	
		var $rows4; 
		var pageSize = 10; 
		function tabepage(){

		$rows4 = $("#pagedTable4 >tbody >tr"); 
	  
		$("#pager4").wijpager({ pageCount: Math.ceil($rows4.length / pageSize) || 1, 
			mode: "numericFirstLast", pageIndexChanged: onPageIndexChanged4 
		}); 
		
		onPageIndexChanged4();   
	}

    function onPageIndexChanged4() { 
	
		var pageIndex = $("#pager4").wijpager("option", "pageIndex"); 
		//目前頁面數
		var showFrom = pageIndex * pageSize; 
		//目前頁面數*總頁數
		var showTo = showFrom + pageSize; 

		$.each($rows4, function (index, tr) { 		
		console.log(index);
			if (index >= showFrom && index < showTo) { 
				$(tr).show(); 
							console.log('a');
			} else { 
				$(tr).hide(); 
							console.log('b');
			} 
		}); 
	}; 
</script>
<script>	

		tabepage();	
		var $rows42; 
		var pageSize = 10; 
		function tabepage(){

		$rows42 = $("#pagedTable4-2 >tbody >tr"); 
	  
		$("#pager4-2").wijpager({ pageCount: Math.ceil($rows42.length / pageSize) || 1, 
			mode: "numericFirstLast", pageIndexChanged: onPageIndexChanged 
		}); 
		
		onPageIndexChanged();   
	}

    function onPageIndexChanged() { 
	
		var pageIndex = $("#pager4-2").wijpager("option", "pageIndex"); 
		//目前頁面數
		var showFrom = pageIndex * pageSize; 
		//目前頁面數*總頁數
		var showTo = showFrom + pageSize; 
		//	console.log(showTo);
		$.each($rows42, function (index, tr) { 
			if (index >= showFrom && index < showTo) { 
				$(tr).show(); 
			} else { 
				$(tr).hide(); 
			} 
		}); 
	}; 
</script>
<script>	

		tabepage();	
		var $rows5; 
		var pageSize = 10; 
		function tabepage(){

		$rows5 = $("#pagedTable5 >tbody >tr"); 
	  
		$("#pager5").wijpager({ pageCount: Math.ceil($rows5.length / pageSize) || 1, 
			mode: "numericFirstLast", pageIndexChanged: onPageIndexChanged 
		}); 
		
		onPageIndexChanged();   
	}

    function onPageIndexChanged() { 
	
		var pageIndex = $("#pager5").wijpager("option", "pageIndex"); 
		//目前頁面數
		var showFrom = pageIndex * pageSize; 
		//目前頁面數*總頁數
		var showTo = showFrom + pageSize; 
		//	console.log(showTo);
		$.each($rows5, function (index, tr) { 
			if (index >= showFrom && index < showTo) { 
				$(tr).show(); 
			} else { 
				$(tr).hide(); 
			} 
		}); 
	}; 
</script>
<script>	

		tabepage();	
		var $rows6; 
		var pageSize = 10; 
		function tabepage(){

		$rows6 = $("#pagedTable6 >tbody >tr"); 
	  
		$("#pager6").wijpager({ pageCount: Math.ceil($rows6.length / pageSize) || 1, 
			mode: "numericFirstLast", pageIndexChanged: onPageIndexChanged 
		}); 
		
		onPageIndexChanged();   
	}

    function onPageIndexChanged() { 
	
		var pageIndex = $("#pager6").wijpager("option", "pageIndex"); 
		//目前頁面數
		var showFrom = pageIndex * pageSize; 
		//目前頁面數*總頁數
		var showTo = showFrom + pageSize; 
		//	console.log(showTo);
		$.each($rows6, function (index, tr) { 
			if (index >= showFrom && index < showTo) { 
				$(tr).show(); 
			} else { 
				$(tr).hide(); 
			} 
		}); 
	}; 
</script>
