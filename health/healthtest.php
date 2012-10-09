<html>
<head>
<title>子計畫三-健康查詢管理</title>
<link href=../css/style.css rel="stylesheet" type="text/css">

		<!-- 1. Add these JavaScript inclusions in the head of your page -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
		<script type="text/javascript" src="../js/highcharts.js"></script>
		
		<!-- 1b) Optional: the exporting module -->
		<script type="text/javascript" src="../js/modules/exporting.js"></script>
		<script type="text/javascript">
		
			var chart;
			$(document).ready(function() {
				
				// define the options
				var options = {
			
					chart: {
						renderTo: 'container'
					},
					
					title: {
						text: '健康查詢管理'
					},
					
					subtitle: {
						text: '血壓紀錄-折線圖'
					},
					
					xAxis: {
						type: 'datetime',
						tickInterval: 2 * 24 * 3600 * 1000, // one week
						tickWidth: 0,
						gridLineWidth: 1,
						labels: {
							align: 'left',
							x: 3,
							y: -3 
						}
					},
					
					yAxis: [{ // left y axis
						title: {
							text: null
						},
					//color
					plotBands: { // Light air
							from: 40,
							to: 90,
							color: 'rgba(190, 150, 50, 0.1)',			
						}, 

						labels: {
							align: 'left',
							x: 3,
							y: 16,
							formatter: function() {
								return Highcharts.numberFormat(this.value, 0);
							}
						},
						showFirstLabel: false
					}, 
					
					{ // right y axis
						linkedTo: 0,
						gridLineWidth: 0,				
						opposite: true,
						title: {
							text: null
						},
					plotBands: { // Light air			
							from: 80,
							to: 140,
							color: 'rgba(50, 170, 50, 0.1)',

				
						}, 	
						labels: {
							align: 'right',
							x: -3,
							y: 16,
							formatter: function() {
								return Highcharts.numberFormat(this.value, 0);
							}
						},
						showFirstLabel: false
					}],
					
					legend: {
						align: 'left',
						verticalAlign: 'top',
						y: 20,
						floating: true,
						borderWidth: 0
					},
					
					tooltip: {
						shared: true,
						crosshairs: true
					},
					
					plotOptions: {
						series: {
							cursor: 'pointer',
							point: {
								events: {
									click: function() {
										hs.htmlExpand(null, {
											pageOrigin: {
												x: this.pageX, 
												y: this.pageY
											},
											headingText: this.series.name,
											maincontentText: Highcharts.dateFormat('%A, %b %e, %Y', this.x) +':<br/> '+ 
												this.y +' visits',
											width: 200
										});
									}
								}
							},
							marker: {
								lineWidth: 1
							}
						}
					},
					
					series: [{
						name: '收縮壓',
						lineWidth: 4,
						marker: {
							radius: 4
						}
					}, {
						name: '舒張壓'
					}]
				};
				
				
				// Load data asynchronously using jQuery. On success, add the data
				// to the options and initiate the chart.
				// This data is obtained by exporting a GA custom report to TSV.
				// http://api.jquery.com/jQuery.get/
				jQuery.get('./health.tsv', null, function(tsv, state, xhr) {
					var lines = [],
						listen = false,
						date,
						
						// set up the two data series
						highblood = [],
						lowblood = [];
						
					// inconsistency
					if (typeof tsv !== 'string') {
						tsv = xhr.responseText;
					}
					
					// split the data return into lines and parse them
					tsv = tsv.split(/\n/g);
					jQuery.each(tsv, function(i, line) {
			
						// listen for data lines between the Graph and Table headers
						if (tsv[i - 3] == '# Graph') {
							listen = true;
						} else if (line == '' || line.charAt(0) == '#') {
							listen = false;
						}
						
						// all data lines start with a double quote
						if (listen) {
							line = line.split(/\t/);
							date = Date.parse(line[0] +' UTC');
							
							highblood.push([
								date, 
								parseInt(line[1].replace(',', ''), 10)
							]);
							lowblood.push([
								date, 
								parseInt(line[2].replace(',', ''), 10)
							]);
						}
					});
					
					options.series[0].data = highblood;
					options.series[1].data = lowblood;
					
					chart = new Highcharts.Chart(options);
				});
				
			});
				
		</script>
		
		<script type="text/javascript">
		
			var chart;
			$(document).ready(function() {
				
				// define the options
				var options = {
			
					chart: {
						renderTo: 'beat'
					},
					
					title: {
						text: '健康查詢管理'
					},
					
					subtitle: {
						text: '心跳紀錄-折線圖'
					},
					
					xAxis: {
						type: 'datetime',
						tickInterval: 2 * 24 * 3600 * 1000, // one week
						tickWidth: 0,
						gridLineWidth: 1,
						labels: {
							align: 'left',
							x: 3,
							y: -3 
						}
					},
					
					yAxis: [{ // left y axis
						title: {
							text: null
						},
					//color
					plotBands: { // Light air
							from: 55,
							to: 100,
							color: 'rgba(50, 200, 50, 0.1)',			
						}, 

						labels: {
							align: 'left',
							x: 3,
							y: 16,
							formatter: function() {
								return Highcharts.numberFormat(this.value, 0);
							}
						},
						showFirstLabel: false
					}, 
					
					{ // right y axis
						linkedTo: 0,
						gridLineWidth: 0,				
						opposite: true,
						title: {
							text: null
						},

						labels: {
							align: 'right',
							x: -3,
							y: 16,
							formatter: function() {
								return Highcharts.numberFormat(this.value, 0);
							}
						},
						showFirstLabel: false
					}],
					
					legend: {
						align: 'left',
						verticalAlign: 'top',
						y: 20,
						floating: true,
						borderWidth: 0
					},
					
					tooltip: {
						shared: true,
						crosshairs: true
					},
					
					plotOptions: {
						series: {
							cursor: 'pointer',
							point: {
								events: {
									click: function() {
										hs.htmlExpand(null, {
											pageOrigin: {
												x: this.pageX, 
												y: this.pageY
											},
											headingText: this.series.name,
											maincontentText: Highcharts.dateFormat('%A, %b %e, %Y', this.x) +':<br/> '+ 
												this.y +' visits',
											width: 200
										});
									}
								}
							},
							marker: {
								lineWidth: 1
							}
						}
					},
					
					series: [{name: ' ',
					lineWidth: 0
					},{
						name: '心跳',
						lineWidth: 4,
						marker: {
							radius: 4
						}
					}]
				};
				
				
				// Load data asynchronously using jQuery. On success, add the data
				// to the options and initiate the chart.
				// This data is obtained by exporting a GA custom report to TSV.
				// http://api.jquery.com/jQuery.get/
				jQuery.get('./beat.tsv', null, function(tsv, state, xhr) {
					var lines = [],
						listen = false,
						date,
						
						// set up the two data series
						highblood = [],
						lowblood = [];
						
					// inconsistency
					if (typeof tsv !== 'string') {
						tsv = xhr.responseText;
					}
					
					// split the data return into lines and parse them
					tsv = tsv.split(/\n/g);
					jQuery.each(tsv, function(i, line) {
			
						// listen for data lines between the Graph and Table headers
						if (tsv[i - 3] == '# Graph') {
							listen = true;
						} else if (line == '' || line.charAt(0) == '#') {
							listen = false;
						}
						
						// all data lines start with a double quote
						if (listen) {
							line = line.split(/\t/);
							date = Date.parse(line[0] +' UTC');
							
							highblood.push([
								date, 
								parseInt(line[1].replace(',', ''), 10)
							]);
							lowblood.push([
								date, 
								parseInt(line[2].replace(',', ''), 10)
							]);
						}
					});
					
					//options.series[0].data = highblood;
					options.series[1].data = lowblood;
					
					chart = new Highcharts.Chart(options);
				});
				
			});
				
		</script>
		
		<script type="text/javascript">
		
			var chart;
			$(document).ready(function() {
				
				// define the options
				var options = {
			
					chart: {
						renderTo: 'oxygen'
					},
					
					title: {
						text: '健康查詢管理'
					},
					
					subtitle: {
						text: '血氧紀錄-折線圖'
					},
					
					xAxis: {
						type: 'datetime',
						tickInterval: 2 * 24 * 3600 * 1000, // one week
						tickWidth: 0,
						gridLineWidth: 1,
						labels: {
							align: 'left',
							x: 3,
							y: -3 
						}
					},
					
					yAxis: [{ // left y axis
						title: {
							text: null
						},
					//color
					plotBands: { // Light air
							from: 90,
							to: 100,
							color: 'rgba(50, 200, 50, 0.1)',			
						}, 

						labels: {
							align: 'left',
							x: 3,
							y: 16,
							formatter: function() {
								return Highcharts.numberFormat(this.value, 0);
							}
						},
						showFirstLabel: false
					}, 
					
					{ // right y axis
						linkedTo: 0,
						gridLineWidth: 0,				
						opposite: true,
						title: {
							text: null
						},

						labels: {
							align: 'right',
							x: -3,
							y: 16,
							formatter: function() {
								return Highcharts.numberFormat(this.value, 0);
							}
						},
						showFirstLabel: false
					}],
					
					legend: {
						align: 'left',
						verticalAlign: 'top',
						y: 20,
						floating: true,
						borderWidth: 0
					},
					
					tooltip: {
						shared: true,
						crosshairs: true
					},
					
					plotOptions: {
						series: {
							cursor: 'pointer',
							point: {
								events: {
									click: function() {
										hs.htmlExpand(null, {
											pageOrigin: {
												x: this.pageX, 
												y: this.pageY
											},
											headingText: this.series.name,
											maincontentText: Highcharts.dateFormat('%A, %b %e, %Y', this.x) +':<br/> '+ 
												this.y +' visits',
											width: 200
										});
									}
								}
							},
							marker: {
								lineWidth: 1
							}
						}
					},
					
					series: [{name: ' ',
					lineWidth: 0
					},{
						name: '血氧',
						lineWidth: 4,
						marker: {
							radius: 4
						}
					}]
				};
				
				
				// Load data asynchronously using jQuery. On success, add the data
				// to the options and initiate the chart.
				// This data is obtained by exporting a GA custom report to TSV.
				// http://api.jquery.com/jQuery.get/
				jQuery.get('./oxygen.tsv', null, function(tsv, state, xhr) {
					var lines = [],
						listen = false,
						date,
						
						// set up the two data series
						highblood = [],
						lowblood = [];
						
					// inconsistency
					if (typeof tsv !== 'string') {
						tsv = xhr.responseText;
					}
					
					// split the data return into lines and parse them
					tsv = tsv.split(/\n/g);
					jQuery.each(tsv, function(i, line) {
			
						// listen for data lines between the Graph and Table headers
						if (tsv[i - 3] == '# Graph') {
							listen = true;
						} else if (line == '' || line.charAt(0) == '#') {
							listen = false;
						}
						
						// all data lines start with a double quote
						if (listen) {
							line = line.split(/\t/);
							date = Date.parse(line[0] +' UTC');
							
							highblood.push([
								date, 
								parseInt(line[1].replace(',', ''), 10)
							]);
							lowblood.push([
								date, 
								parseInt(line[2].replace(',', ''), 10)
							]);
						}
					});
					
					//options.series[0].data = highblood;
					options.series[1].data = lowblood;
					
					chart = new Highcharts.Chart(options);
				});
				
			});
				
		</script>
		
<script type="text/javascript">
		
			var chart;
			$(document).ready(function() {
				
				// define the options
				var options = {
			
					chart: {
						renderTo: 'sugar'
					},
					
					title: {
						text: '健康查詢管理'
					},
					
					subtitle: {
						text: '血糖紀錄-折線圖'
					},
					
					xAxis: {
						type: 'datetime',
						tickInterval: 2 * 24 * 3600 * 1000, // one week
						tickWidth: 0,
						gridLineWidth: 1,
						labels: {
							align: 'left',
							x: 3,
							y: -3 
						}
					},
					
					yAxis: [{ // left y axis
						title: {
							text: null
						},
					//color
					plotBands: { // Light air
							from: 70,
							to: 200,
							color: 'rgba(50, 200, 50, 0.1)',			
						}, 

						labels: {
							align: 'left',
							x: 3,
							y: 16,
							formatter: function() {
								return Highcharts.numberFormat(this.value, 0);
							}
						},
						showFirstLabel: false
					}, 
					
					{ // right y axis
						linkedTo: 0,
						gridLineWidth: 0,				
						opposite: true,
						title: {
							text: null
						},
					plotBands: { // Light air			
							from: 1500,
							to: 3000,
							color: 'rgba(50, 170, 50, 0.1)',

				
						}, 	
						labels: {
							align: 'right',
							x: -3,
							y: 16,
							formatter: function() {
								return Highcharts.numberFormat(this.value, 0);
							}
						},
						showFirstLabel: false
					}],
					
					legend: {
						align: 'left',
						verticalAlign: 'top',
						y: 20,
						floating: true,
						borderWidth: 0
					},
					
					tooltip: {
						shared: true,
						crosshairs: true
					},
					
					plotOptions: {
						series: {
							cursor: 'pointer',
							point: {
								events: {
									click: function() {
										hs.htmlExpand(null, {
											pageOrigin: {
												x: this.pageX, 
												y: this.pageY
											},
											headingText: this.series.name,
											maincontentText: Highcharts.dateFormat('%A, %b %e, %Y', this.x) +':<br/> '+ 
												this.y +' visits',
											width: 200
										});
									}
								}
							},
							marker: {
								lineWidth: 1
							}
						}
					},
					
					series: [{
						name: ' ',
						lineWidth: 0
						
					}, {
						name: '血糖',
						lineWidth: 4,
						marker: {
							radius: 4
						}
					}]
				};
				
				
				// Load data asynchronously using jQuery. On success, add the data
				// to the options and initiate the chart.
				// This data is obtained by exporting a GA custom report to TSV.
				// http://api.jquery.com/jQuery.get/
				jQuery.get('./sugar.tsv', null, function(tsv, state, xhr) {
					var lines = [],
						listen = false,
						date,
						
						// set up the two data series
						highblood = [],
						lowblood = [];
						
					// inconsistency
					if (typeof tsv !== 'string') {
						tsv = xhr.responseText;
					}
					
					// split the data return into lines and parse them
					tsv = tsv.split(/\n/g);
					jQuery.each(tsv, function(i, line) {
			
						// listen for data lines between the Graph and Table headers
						if (tsv[i - 3] == '# Graph') {
							listen = true;
						} else if (line == '' || line.charAt(0) == '#') {
							listen = false;
						}
						
						// all data lines start with a double quote
						if (listen) {
							line = line.split(/\t/);
							date = Date.parse(line[0] +' UTC');
							
							highblood.push([
								date, 
								parseInt(line[1].replace(',', ''), 10)
							]);
							lowblood.push([
								date, 
								parseInt(line[2].replace(',', ''), 10)
							]);
						}
					});
					
					//options.series[0].data = highblood;
					options.series[1].data = lowblood;
					
					chart = new Highcharts.Chart(options);
				});
				
			});
				
		</script>

<script type="text/javascript">
		
			var chart;
			$(document).ready(function() {
				
				// define the options
				var options = {
			
					chart: {
						renderTo: 'temperature'
					},
					
					title: {
						text: '健康查詢管理'
					},
					
					subtitle: {
						text: '體溫紀錄-折線圖'
					},
					
					xAxis: {
						type: 'datetime',
						tickInterval: 2 * 24 * 3600 * 1000, // one week
						tickWidth: 0,
						gridLineWidth: 1,
						labels: {
							align: 'left',
							x: 3,
							y: -3 
						}
					},
					
					yAxis: [{ // left y axis
						title: {
							text: null
						},
					//color
					plotBands: { // Light air
							from: 35,
							to: 37,
							color: 'rgba(50, 200, 50, 0.1)',			
						}, 

						labels: {
							align: 'left',
							x: 3,
							y: 16,
							formatter: function() {
								return Highcharts.numberFormat(this.value, 0);
							}
						},
						showFirstLabel: false
					}, 
					
					{ // right y axis
						linkedTo: 0,
						gridLineWidth: 0,				
						opposite: true,
						title: {
							text: null
						},
					plotBands: { // Light air			
							from: 1500,
							to: 3000,
							color: 'rgba(50, 170, 50, 0.1)',

				
						}, 	
						labels: {
							align: 'right',
							x: -3,
							y: 16,
							formatter: function() {
								return Highcharts.numberFormat(this.value, 0);
							}
						},
						showFirstLabel: false
					}],
					
					legend: {
						align: 'left',
						verticalAlign: 'top',
						y: 20,
						floating: true,
						borderWidth: 0
					},
					
					tooltip: {
						shared: true,
						crosshairs: true
					},
					
					plotOptions: {
						series: {
							cursor: 'pointer',
							point: {
								events: {
									click: function() {
										hs.htmlExpand(null, {
											pageOrigin: {
												x: this.pageX, 
												y: this.pageY
											},
											headingText: this.series.name,
											maincontentText: Highcharts.dateFormat('%A, %b %e, %Y', this.x) +':<br/> '+ 
												this.y +' visits',
											width: 200
										});
									}
								}
							},
							marker: {
								lineWidth: 1
							}
						}
					},
					
					series: [{
						name: ' ',
						lineWidth: 0	
					}, {
						name: '體溫',
						lineWidth: 4,
						marker: {
							radius: 4
						}	
					}]
				};
				
				
				// Load data asynchronously using jQuery. On success, add the data
				// to the options and initiate the chart.
				// This data is obtained by exporting a GA custom report to TSV.
				// http://api.jquery.com/jQuery.get/
				jQuery.get('./temperature.tsv', null, function(tsv, state, xhr) {
					var lines = [],
						listen = false,
						date,
						
						// set up the two data series
						highblood = [],
						lowblood = [];
						
					// inconsistency
					if (typeof tsv !== 'string') {
						tsv = xhr.responseText;
					}
					
					// split the data return into lines and parse them
					tsv = tsv.split(/\n/g);
					jQuery.each(tsv, function(i, line) {
			
						// listen for data lines between the Graph and Table headers
						if (tsv[i - 3] == '# Graph') {
							listen = true;
						} else if (line == '' || line.charAt(0) == '#') {
							listen = false;
						}
						
						// all data lines start with a double quote
						if (listen) {
							line = line.split(/\t/);
							date = Date.parse(line[0] +' UTC');
							
							highblood.push([
								date, 
								parseInt(line[1].replace(',', ''), 10)
							]);
							lowblood.push([
								date, 
								parseInt(line[2].replace(',', ''), 10)
							]);
						}
					});
					
					//options.series[0].data = highblood;
					options.series[1].data = lowblood;
					
					chart = new Highcharts.Chart(options);
				});
				
			});
				
		</script>	

<script type="text/javascript">
		
			var chart;
			$(document).ready(function() {
				
				// define the options
				var options = {
			
					chart: {
						renderTo: 'emotion'
					},
					
					title: {
						text: '健康查詢管理'
					},
					
					subtitle: {
						text: '情緒紀錄-折線圖'
					},
					
					xAxis: {
						type: 'datetime',
						tickInterval: 2 * 24 * 3600 * 1000, // one week
						tickWidth: 0,
						gridLineWidth: 1,
						labels: {
							align: 'left',
							x: 3,
							y: -3 
						}
					},
					
					yAxis: [{ // left y axis
						title: {
							text: null
						},
					//color
					plotBands: { // Light air
							from: 4,
							to: 7,
							color: 'rgba(50, 200, 50, 0.1)',			
						}, 

						labels: {
							align: 'left',
							x: 3,
							y: 16,
							formatter: function() {
								return Highcharts.numberFormat(this.value, 0);
							}
						},
						showFirstLabel: false
					}, 
					
					{ // right y axis
						linkedTo: 0,
						gridLineWidth: 0,				
						opposite: true,
						title: {
							text: null
						},
					plotBands: { // Light air			
							from: 1500,
							to: 3000,
							color: 'rgba(50, 170, 50, 0.1)',

				
						}, 	
						labels: {
							align: 'right',
							x: -3,
							y: 16,
							formatter: function() {
								return Highcharts.numberFormat(this.value, 0);
							}
						},
						showFirstLabel: false
					}],
					
					legend: {
						align: 'left',
						verticalAlign: 'top',
						y: 20,
						floating: true,
						borderWidth: 0
					},
					
					tooltip: {
						shared: true,
						crosshairs: true
					},
					
					plotOptions: {
						series: {
							cursor: 'pointer',
							point: {
								events: {
									click: function() {
										hs.htmlExpand(null, {
											pageOrigin: {
												x: this.pageX, 
												y: this.pageY
											},
											headingText: this.series.name,
											maincontentText: Highcharts.dateFormat('%A, %b %e, %Y', this.x) +':<br/> '+ 
												this.y +' visits',
											width: 200
										});
									}
								}
							},
							marker: {
								lineWidth: 1
							}
						}
					},
					
					series: [{
						name: ' ',
						lineWidth: 0
					}, {
						name: '情緒',
						lineWidth: 4,
						marker: {
							radius: 4
						}
					}]
				};
				
				
				// Load data asynchronously using jQuery. On success, add the data
				// to the options and initiate the chart.
				// This data is obtained by exporting a GA custom report to TSV.
				// http://api.jquery.com/jQuery.get/
				jQuery.get('./emotion.tsv', null, function(tsv, state, xhr) {
					var lines = [],
						listen = false,
						date,
						
						// set up the two data series
						highblood = [],
						lowblood = [];
						
					// inconsistency
					if (typeof tsv !== 'string') {
						tsv = xhr.responseText;
					}
					
					// split the data return into lines and parse them
					tsv = tsv.split(/\n/g);
					jQuery.each(tsv, function(i, line) {
			
						// listen for data lines between the Graph and Table headers
						if (tsv[i - 3] == '# Graph') {
							listen = true;
						} else if (line == '' || line.charAt(0) == '#') {
							listen = false;
						}
						
						// all data lines start with a double quote
						if (listen) {
							line = line.split(/\t/);
							date = Date.parse(line[0] +' UTC');
							
							highblood.push([
								date, 
								parseInt(line[1].replace(',', ''), 10)
							]);
							lowblood.push([
								date, 
								parseInt(line[2].replace(',', ''), 10)
							]);
						}
					});
					
					//options.series[0].data = highblood;
					options.series[1].data = lowblood;
					
					chart = new Highcharts.Chart(options);
				});
				
			});
				
		</script>			
		<!-- Additional files for the Highslide popup effect -->
		<script type="text/javascript" src="http://www.highcharts.com/highslide/highslide-full.min.js"></script>
		<script type="text/javascript" src="http://www.highcharts.com/highslide/highslide.config.js" charset="utf-8"></script>
		<link rel="stylesheet" type="text/css" href="http://www.highcharts.com/highslide/highslide.css" />
<?php
$dbServer = "localhost";
$dbName = "oldmantest";
$dbUser = "root";
$dbPass = "E428-2";

//連線資料庫伺服器
if ( ! @mysql_connect($dbServer, $dbUser, $dbPass) )
die("無法連線資料庫伺服器");

//選擇資料庫
if ( ! @mysql_select_db($dbName) )
die("無法使用資料庫");
date_default_timezone_set('Asia/Taipei');
//$rs = mysql_query("SELECT * FROM detect WHERE idcard = '" .$_POST[idcard] . "'");
//讀血壓數據
$timers = mysql_query("SELECT time FROM detect WHERE idcard = 'a' ORDER BY `detect`.`time` ASC");
$rs = mysql_query("SELECT highblood,lowblood FROM detect WHERE idcard = 'a' ORDER BY `detect`.`time` ASC");
$file = fopen('./health.tsv' , 'w');
fwrite($file,"# ----\n");
fwrite($file,"# Graph\n");
fwrite($file,"# -----\n");
//$artimes =mysql_fetch_row($timers);

while($areas = mysql_fetch_row($rs) and $artimes =mysql_fetch_row($timers))
	{	
		foreach ($artimes as $datee) {
	$t = strtotime($datee);
	$d = date("l, F d, Y",$t);
//	echo $datee;
	fwrite($file ,$d . chr(9));
	}

		fputcsv($file ,$areas,'	');
	    // 获取数据表列中最后那个值，若为空则表明上次查询并非该列
	    $area_prev = $areas["count_area"];
	    if(!empty($areas["count_area"]))
	        $area_query = $areas["count_area"];	
	}
	fclose($file);
//讀心跳數據	
$timers = mysql_query("SELECT time FROM detect WHERE idcard = 'a' ORDER BY `detect`.`time` ASC");
$rs = mysql_query("SELECT beat FROM detect WHERE idcard = 'a' ORDER BY `detect`.`time` ASC");
$file = fopen('./beat.tsv' , 'w');
fwrite($file,"# ----\n");
fwrite($file,"# Graph\n");
fwrite($file,"# -----\n");
//$artimes =mysql_fetch_row($timers);

while($areas = mysql_fetch_row($rs) and $artimes =mysql_fetch_row($timers))
	{	
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
$timers = mysql_query("SELECT time FROM detect WHERE idcard = 'a' ORDER BY `detect`.`time` ASC");
$rs = mysql_query("SELECT oxygen FROM detect WHERE idcard = 'a' ORDER BY `detect`.`time` ASC");
$file = fopen('./oxygen.tsv' , 'w');
fwrite($file,"# ----\n");
fwrite($file,"# Graph\n");
fwrite($file,"# -----\n");
//$artimes =mysql_fetch_row($timers);

while($areas = mysql_fetch_row($rs) and $artimes =mysql_fetch_row($timers))
	{	
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
$timers = mysql_query("SELECT time FROM detect WHERE idcard = 'a' ORDER BY `detect`.`time` ASC");
$rs = mysql_query("SELECT sugar FROM detect WHERE idcard = 'a' ORDER BY `detect`.`time` ASC");
$file = fopen('./sugar.tsv' , 'w');
fwrite($file,"# ----\n");
fwrite($file,"# Graph\n");
fwrite($file,"# -----\n");
//$artimes =mysql_fetch_row($timers);

while($areas = mysql_fetch_row($rs) and $artimes =mysql_fetch_row($timers))
	{	
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
//讀體溫數據	
$timers = mysql_query("SELECT time FROM detect WHERE idcard = 'a' ORDER BY `detect`.`time` ASC");
$rs = mysql_query("SELECT temperature FROM detect WHERE idcard = 'a' ORDER BY `detect`.`time` ASC");
$file = fopen('./temperature.tsv' , 'w');
fwrite($file,"# ----\n");
fwrite($file,"# Graph\n");
fwrite($file,"# -----\n");
//$artimes =mysql_fetch_row($timers);

while($areas = mysql_fetch_row($rs) and $artimes =mysql_fetch_row($timers))
	{	
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
$timers = mysql_query("SELECT time FROM detect WHERE idcard = 'a' ORDER BY `detect`.`time` ASC");
$rs = mysql_query("SELECT emotion FROM detect WHERE idcard = 'a' ORDER BY `detect`.`time` ASC");
$file = fopen('./emotion.tsv' , 'w');
fwrite($file,"# ----\n");
fwrite($file,"# Graph\n");
fwrite($file,"# -----\n");
//$artimes =mysql_fetch_row($timers);

while($areas = mysql_fetch_row($rs) and $artimes =mysql_fetch_row($timers))
	{	
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

//	$fp = fopen("./report-daily.".date("Ymd").'.csv', 'w'); //原始範例


//	foreach ($list as $line) {
//	    fputcsv($file, split(',', $line));
//	}
	//http://php.net/manual/en/function.fputcsv.php

?>

</head>
<body>
<?php
?>
	<h2>健康查詢管理</h2>
		<!-- 3. Add the container -->
		<div id="container" style="width: 800px; height: 400px; margin: 0 auto"></div>
		<div id="beat" style="width: 800px; height: 400px; margin: 0 auto"></div>
		<div id="oxygen" style="width: 800px; height: 400px; margin: 0 auto"></div>
		<div id="sugar" style="width: 800px; height: 400px; margin: 0 auto"></div>
		<div id="temperature" style="width: 800px; height: 400px; margin: 0 auto"></div>
		<div id="emotion" style="width: 800px; height: 400px; margin: 0 auto"></div>


</body>
</html>