<div class="main demo"> 
	<div id="wijbubblechart" class="ui-widget ui-widget-content ui-corner-all" style="width: 756px; 
		height: 475px;"> 
	</div> 
</div> 

<script type="text/javascript">
//喜
var pl="./health/satisfied.png";
//怒
var an="./health/nervous-1.png";
//哀
var so="./health/cry-6.png";
//樂
var jo="./health/happy-4.png";
//平靜
var co="./health/glad.png";

var	emoy1=[];
var dateemo=[];
var emofinindex=[];
$.ajax({
	url:'./health/emotion.tsv', 
	async:0,
	success:a1
});


var emodata= { x:dateemo, y: emoy1, y1: emoy1 };
//console.log(new Date('10/27/2010 11:48:00'));

$("#wijbubblechart").wijbubblechart({ 
	minimumSize: 1, 
	MaximumSize: 100, 
	axis: { 
		y: { 
			autoMin: 0, 
			autoMax:0, 
			min: 1, 
			max: 150 ,
			text: "情緒大小",
			visible:1,
			//數值消失
			textVisible:0
		}, 
		x: { 
			autoMin: 1, 
			text: "日期"
		} 
	}, 
	hint: { 
	//滑鼠指到泡泡的文字
		content: function () { 
			return this.data.y1 + "%"; 
		} 
	}, 
	header: { 
		text: "情緒指數"
	}, 
	seriesStyles: [ 
		{ 
			opacity: 0.5 
		} 
	], 
	chartLabel: { 
	//泡泡裡或外的文字
		position: "inside",
		visible: 0,
	}, 
	seriesList: [{ 
		label: "Market Share", 
		legendEntry: 0, 
		data:emodata, 
		markers: { 
			symbol:emofinindex
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
	var emovalue;
	var emoindex;
	var eindex={};
		// inconsistency
		if (typeof tsv !== 'string') {
			tsv = xhr.responseText;
		}
			
	// split the data return into lines and parse them
	tsv = tsv.split(/\n/g);
	jQuery.each(tsv, function(i, line){

		// listen for data lines between the Graph and Table headers
		if (tsv[i - 3] == '# Graph'){
			listen = true;
		} else if (line == '' || line.charAt(0) == '#') {
			listen = false;
		}
		
		// all data lines start with a double quote
		if (listen) {
			line = line.split(/\t/);
			dateemo.push(
			new Date(line[0])
			);

				emovalue=line[2].match(/[0-9]{2}/);
				emoindex=line[2].match(/[a-zA-Z]{2}/);	
				emovalue=parseInt(emovalue[0]);
				if(emovalue==01){
					emovalue=50;					
				}else{
					emovalue=100;
				}
				emoy1.push(
					emovalue
				);
				eindex={"index": 1};
				eindex.url=eval(emoindex[0]);
				emofinindex.push(
					eindex
				);		
				//console.log(emofinindex);										
		}
	});
}	
			//console.log(dateemo);	
</script>