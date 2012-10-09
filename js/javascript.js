window.onload = function() 
{ 
	var tf="if1"; 
	var data=[
	{m:"健康管理",
		s:[{sn:"健康查詢管理",st:"./health/health.php"}]
	},  
	
	{m:"健康異常",
		s:[{sn:"異常提示紀錄",st:"./abnormal/abnormalrecord.php"}, 
		{sn:"異常提示設定",st:"./abnormal/setabnormalwarning.php"}]
	}, 
	
	{m:"關懷聯繫",
		s:[{sn:"過去就醫紀錄",st:"./love/pasthospital.php"}, 
		{sn:"健康問題處置",st:"./love/abnormalsuggest.php"}, 
		{sn:"客製衛教知識",st:"./love/customized.php"}]
	} ,
	
	{m:"系統維護",
		s:[{sn:"基本資料維護",st:"./system/presetinfo.php"}, 
		{sn:"使用紀錄查詢",st:"./system/record.php"}, 
		{sn:"帳號權限管理",st:"./system/subadmin/root.php"}]
	} 
	]; 
	var nav=new tableNav("table1",data,tf); 
	var bautoClose=0; //打開後其它導航是否關閉 0=no,1=yes
	nav.generateNav(bautoClose); 
} 

function tableNav(tblid,data,ifname) 
{ 
	var tbl= document.getElementById(tblid); 
	//1.?除表格中存在的行 
	for (var t = 0; t < tbl.rows.length;t++){tbl.deleteRow(t);} 
	//2.添加?据 
	var idx=0; 
	for(var t=0;t<data.length;t++) 
	{ 
		var row=tbl.insertRow(idx); 
		var cell=row.insertCell(0); 
		cell.innerHTML=data[t].m; 
		row.className="oddrow"; 
		idx++; 
		var row=tbl.insertRow(idx); 
		row.className="evenrow"; 
		var cell=row.insertCell(0); 
			for (var i=0;i<data[t].s.length;i++) 
			{
				//鏈結方式	
				cell.innerHTML += "<a href='" +data[t].s[i].st+"' class='aaa'>"+ data[t].s[i].sn +"</a><br>";
			} 
		row.style.display="block"; 
		idx++; 
	} 

	//////////////////////////////////////////////////////////////
	this.generateNav=function(bautoClose){ 
		for (var i = 0; i < tbl.rows.length; i++) 
		if (i % 2==0) 
		{ 
			var obj = tbl.rows[i].getElementsByTagName("td")[0]; 
			obj.onclick = function() 
			{ 
				var o = this.parentNode.nextSibling; 
				if (o.nodeType != 1) 
				{ 
					o = o.nextSibling; 
				} 

				o.style.display = (o.style.display == "block") ? "none" : "block" 
					if (bautoClose) 
					{ 
						for (var j = 1; j < tbl.rows.length; j =j+ 2) 
						{ 
							if (tbl.rows[j] !=o) 
							{ 
								tbl.rows[j].style.display = "none"; 
							} 
						} 
					} 
			} 
		} 
	}; 
	/* 打開後其它導航是否關閉的語法*/

	$('a').click(function(e){
				e.preventDefault();
				var href = $(this).attr('href');
				$('#a').load(href);		
			return;			
	});
} 


