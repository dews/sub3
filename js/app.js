$(document).ready(function () {
	$("#menu1").wijmenu( ); 	

	$("#tabs").wijtabs({
		alignment: "left",
		//ajaxOptions: { async: false } ,
		//ajaxOptions: { cache:true} ,
		 //cache:true,
		spinner: '連線中…',
	 //disabled: [0, 3,6],

	  });
	//先選別的分頁，才能disable第0個分頁  
	//jqueryui是用disable
	$("#tabs").wijtabs('select', 8); 
	$("#tabs").wijtabs( "option",'disabledIndexes',[0,3,6]);

	$('#switcher').themeswitcher({
		imgpath: "css/images/",
		width:"250px",
		jqueryuiversion: "1.8.23",
		initialText:"選擇佈景主題",
		buttonPreText:"佈景主題",
		buttonHeight:20,
	});
});