<div class="main demo"> 
	<div id="wijbubblechart" class="ui-widget ui-widget-content ui-corner-all" style="width: 756px; 
		height: 475px;"> 
	</div> 
</div> 

<script type="text/javascript">
//喜
var happy="./health/happy-4.png";
//怒
var nervous="./health/nervous-1.png";
//哀
var  cry="./health/cry-6.png";
//樂
var  glad="./health/glad.png";

var	emoy1=[];
var	dateemo=[];
$.ajax({
	url:'./health/emotion.tsv', 
	async:0,
	success:a1
});


var emodata= { x:dateemo, y: emoy1, y1: emoy1 };
console.log(new Date('10/27/2010 11:48:00'));
var symbol1=[ 
					{ 
						"index": 1, 
						"url": happy
					}, 
					{ 
						"index": 2, 
						"url":  cry
					}		
				] ;
				
$("#wijbubblechart").wijbubblechart({ 
	minimumSize: 12, 
	MaximumSize: 64, 
	axis: { 
		y: { 
			autoMin: false, 
			text: "Percent"
		}, 
		x: { 
			autoMin: 1, 
			text: "日期"
		} 
	}, 
	hint: { 
		content: function () { 
			return this.data.y1 + "%"; 
		} 
	}, 
	header: { 
		text: "Browser Wars"
	}, 
	seriesStyles: [ 
		{ 
			opacity: 0.5 
		} 
	], 
	chartLabel: { 
		position: "outside"
	}, 
	seriesList: [{ 
		label: "Market Share", 
		legendEntry: true, 
		data:emodata, 
		markers: { 
			symbol:symbol1
		} 
	}] 
}); 

function a1(tsv, state, xhr) {
		var	 lines = [];
		var	listen = false;
		var	date;
			// set up the two data series
		var	highblood = [];
		var	lowblood = [];
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
					//date = Date.parse(line[0] +' UTC');
					dateemo.push(
					new Date(line[0])
					);
					highblood.push(
						parseInt(line[1].replace(',', ''), 10)
					);
					 emoy1.push(
						parseInt(line[2].replace(',', ''), 10)
					);
							
				}

			});
}	
		console.log(dateemo);	
		
</script>