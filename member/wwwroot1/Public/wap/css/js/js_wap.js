


$(document).ready(function(){	
	setViewport();

	
});

//设置页面高度
function setViewport(){
	var w = $(window).width();
	var maxw = 640;
	var p = Math.floor(w/maxw*100)/100;
	document.body.style.zoom = p;
}

























