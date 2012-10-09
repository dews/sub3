<?php session_start(); ?>
<!--jqueryUI用-->
<script type="text/javascript" src="./js/jquery-1.7.1.min.js"></script>
<link type="text/css" href="./css/humanity/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="./js/jquery.ui.datepicker-zh-TW.js"></script>  
<script type="text/javascript" src="./js/jquery-ui-1.8.16.custom.min.js"></script>
	
		<!-- 1. Add these JavaScript inclusions in the head of your page -->
		<script type="text/javascript" src="../js/highcharts.js"></script>
		
		<!-- 1b) Optional: the exporting module -->
		<script type="text/javascript" src="../js/modules/exporting.js"></script>
		<script type="text/javascript">
		
			var chart;
			$(document).ready(function() {
				
				// define the options
				var options = {
			
					chart: {
						renderTo: 'contain'
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
							label: {
								text: '  舒張壓標準範圍',
								style: {
									color: '#606060'
								}
							}							
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
							label: {
								text: '  收縮壓壓標準範圍',
								style: {
									color: '#606060'
								}
							}
				
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
				jQuery.get('./health/pressure.tsv', null, function(tsv, state, xhr) {
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
					console.debug(tsv +'aa');
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
							label: {
								text: '標準範圍',
								style: {
									color: '#606060'
								}
							}							
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
				jQuery.get('./health/beat.tsv', null, function(tsv, state, xhr) {
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
							label: {
								text: '標準範圍',
								style: {
									color: '#606060'
								}
							}							
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
				jQuery.get('./health/oxygen.tsv', null, function(tsv, state, xhr) {
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
							to: 120,
							color: 'rgba(190, 150, 50, 0.1)',	
							label: {
								text: '  飯前標準範圍',
								style: {
									color: '#606060'
								}
							}							
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
							from: 120,
							to: 200,
							color: 'rgba(50, 200, 50, 0.1)',	
							label: {
								text: '  飯後標準範圍',
								style: {
									color: '#606060'
								}
							}							
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
						name: '飯後血糖',
						lineWidth: 2
						
					}, {
						name: '飯前血糖',
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
				jQuery.get('./health/sugar.tsv', null, function(tsv, state, xhr) {
					var lines = [],
						listen = false,
						date,
						
						// set up the two data series
						asugar = [],
						bsugar = [];
						
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
							
							asugar.push([
								date, 
								parseInt(line[1].replace(',', ''), 10)
							]);
							bsugar.push([
								date, 
								parseInt(line[2].replace(',', ''), 10)
							]);
						}
					});
					
					options.series[0].data = asugar;
					options.series[1].data = bsugar;
					
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
							label: {
								text: '標準範圍',
								style: {
									color: '#606060'
								}
							}							
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
				jQuery.get('./health/temperature.tsv', null, function(tsv, state, xhr) {
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
							label: {
								text: '標準範圍',
								style: {
									color: '#606060'
								}
							}							
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
				jQuery.get('./health/emotion.tsv', null, function(tsv, state, xhr) {
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
		<!--<script type="text/javascript" src="http://www.highcharts.com/highslide/highslide-full.min.js"></script>
			<script type="text/javascript" src="http://www.highcharts.com/highslide/highslide.config.js" charset="utf-8"></script>
			<link rel="stylesheet" type="text/css" href="http://www.highcharts.com/highslide/highslide.css" />-->
<?php
if($_SESSION['idcard']==null){
	echo '<p>請先登入...</p>';
	echo '<script type="text/javascript">';
	echo '$("#temp").load("../system/presetinfo.php");';
	echo '</script>';
	echo "<div id='temp'></div>";
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
$pastweek = mktime(0,0,0,date("m"),date("d")-10,date("Y"));
//預設從上週到今天
$_POST[from]=date("Y/m/d",$pastweek);
$_POST[to]=date("Y/m/d");
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
$timers = mysql_query("SELECT time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' AND time >= '". $_POST[from] ." ' AND time <= '". $_POST[to] ."' ORDER BY `time` ASC");
$rs = mysql_query("SELECT highblood,lowblood FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' AND time >= '". $_POST[from] ." ' AND time <= '". $_POST[to] ."' ORDER BY `time` ASC");
$blolast=mysql_query("SELECT highblood,lowblood,time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' ORDER BY `sn` DESC limit 1");
$blo=mysql_fetch_row($blolast);
$file = fopen('./pressure.tsv' , 'w');
fwrite($file,"# ----\n");
fwrite($file,"# Graph\n");
fwrite($file,"# -----\n");
//$artimes =mysql_fetch_row($timers);

while($areas = mysql_fetch_row($rs) and $artimes =mysql_fetch_row($timers))
	{	
		foreach ($artimes as $datee) {
			$t = strtotime($datee);
			$d = date("l, F d, Y",$t);
			//echo $d;
			fwrite($file ,$d . chr(9));
			}

		fputcsv($file ,$areas,'	');
	    // 获取数据表列中最后那个值，若为空则表明上次查询并非该列

	}
	fclose($file);
//讀心跳數據	
$timers = mysql_query("SELECT time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' AND time >= '". $_POST[from] ."' AND time <= '". $_POST[to] ."' ORDER BY `time` ASC");
$rs = mysql_query("SELECT beat FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' AND time >= '". $_POST[from] ." ' AND time <= '". $_POST[to] ."' ORDER BY `time` ASC");
$betlast=mysql_query("SELECT beat,time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' ORDER BY `sn` DESC limit 1");
$bet=mysql_fetch_row($betlast);
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
$timers = mysql_query("SELECT time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' AND time >= '". $_POST[from] ." ' AND time <= '". $_POST[to] ."' ORDER BY `time` ASC");
$rs = mysql_query("SELECT oxygen FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' AND time >= '". $_POST[from] ." ' AND time <= '". $_POST[to] ."' ORDER BY `time` ASC");
$oxlast=mysql_query("SELECT oxygen,time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' ORDER BY `sn` DESC limit 1");
$ox=mysql_fetch_row($oxlast);
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
$timers = mysql_query("SELECT time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' AND time >= '". $_POST[from] ." ' AND time <= '". $_POST[to] ."' ORDER BY `time` ASC");
$rs = mysql_query("SELECT asugar, bsugar FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' AND time >= '". $_POST[from] ." ' AND time <= '". $_POST[to] ."' ORDER BY `time` ASC");
$suglast=mysql_query("SELECT asugar, bsugar,time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' ORDER BY `sn` DESC limit 1");
$sug=mysql_fetch_row($suglast);
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
$timers = mysql_query("SELECT time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' AND time >= '". $_POST[from] ." ' AND time <= '". $_POST[to] ."' ORDER BY `time` ASC");
$rs = mysql_query("SELECT temperature FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' AND time >= '". $_POST[from] ." ' AND time <= '". $_POST[to] ."' ORDER BY `time` ASC");
$temlast=mysql_query("SELECT temperature,time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' ORDER BY `sn` DESC limit 1");
$temp=mysql_fetch_row($temlast);
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
$timers = mysql_query("SELECT time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' AND time >= '". $_POST[from] ." ' AND time <='". $_POST[to] ."' ORDER BY `time` ASC");
$rs = mysql_query("SELECT emotion FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' AND time >= '". $_POST[from] ." ' AND time <='". $_POST[to] ."' ORDER BY `time` ASC");
$qlast=mysql_query("SELECT emotion,time FROM detect WHERE idcard = '". $_SESSION['idcard'] ."' ORDER BY `sn` DESC limit 1");
$tlast=mysql_fetch_row($qlast);
//讀取最後一筆數據
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



	<h2>健康查詢管理</h2>
<!-- 3. Add the container -->
<!-- jqueryUI -->	
<script>
	$(function() {
		$( "#tabs" ).tabs({
			event: "mouseover"
		});
	});
//日期選擇		
	$(function() {
		var dates = $( "#from, #to" ).datepicker({
			showOn: "button",
			buttonImage: "./css/humanity/images/calendar.gif",
			buttonImageOnly: true,
			defaultDate: "-1m",
			changeMonth: true,
			numberOfMonths: 2,
			maxDate: '+1d',
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


function checkForm(){
	var barcodeDefault = "<?php
	echo $_POST[from];
	?>";
	var barcodeDefault2 = "<?php
	echo $_POST[to];
	?>";
var f=document.forms.barcodeForm;
	if( f.from.value == '' || f.from.value == barcodeDefault ){
		f.from.value = barcodeDefault;
	}else{
	}
	//console.log(f.from);
	if( f.to.value == '' || f.to.value == barcodeDefault2 ){
		f.to.value =barcodeDefault2;
		return false;
	}else{
		return true;
	}
}

//失去焦點時，input內會出現提示文字 

checkForm();
$(document).ready(function() {

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

<form id="barcodeForm"  method="post">
	<label for="from">從</label>
	<input type="text" id="from" name="from" type="text" value=""  onblur="if(checkForm(this.form))this.form.submit();"/>
	<label for="to">到</label>
	<input type="text" id="to" name="to" type="text" value=""  onblur="if(checkForm(this.form))this.form.submit();"/>
	<input type="submit" value="改變日期" />
</form>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">血壓</a></li>
		<li><a href="#tabs-2">心跳</a></li>
		<li><a href="#tabs-3">血氧</a></li>
		<li><a href="#tabs-4">血糖</a></li>
		<li><a href="#tabs-5">體溫</a></li>
		<li><a href="#tabs-6">情緒</a></li>
	</ul>
	
	<div id="tabs-1">
		<div id="contain" style="width: 700px; height: 300px; margin: 0 auto"></div>	
		最後一筆數據:
		<?php
		
			echo '收縮壓:'. $blo[0] .'舒張壓:'. $blo[1] .'</br>'. $blo[2];
		
		?>	
	</div>
		
	<div id="tabs-2">
		<div id="beat" style="width: 700px; height: 300px; margin: 0 auto"></div>
		最後一筆數據:
		<?php
		foreach ($bet as $ulast){
			echo "$ulast</br>\n";
		}	
		?>	
	</div>
		
	<div id="tabs-3">
		<div id="oxygen" style="width: 700px; height: 300px; margin: 0 auto"></div>
		最後一筆數據:
		<?php
		foreach ($ox as $ulast){
			echo "$ulast</br>\n";
		}	
		?>			
	</div>
	
	<div id="tabs-4">
		<div id="sugar" style="width: 700px; height: 300px; margin: 0 auto"></div>
		最後一筆數據:
		<?php
			echo '飯前血糖:'. $sug[0] .'飯後血糖:'. $sug[1] .'</br>'. $sug[2];
		?>			
	</div>
	
	<div id="tabs-5">
		<div id="temperature" style="width: 700px; height: 300px; margin: 0 auto"></div>
		最後一筆數據:
		<?php
		foreach ($temp as $ulast){
			echo "$ulast</br>\n";
		}	
				print_r($templast);
		?>	

	</div>
	
	<div id="tabs-6">
		<div id="emotion" style="width: 700px; height: 300px; margin: 0 auto"></div>
		最後一筆數據:
		<?php
		foreach ($tlast as $ulast){
			echo "$ulast</br>\n";
		}	
		?>			
	</div>

</div>

