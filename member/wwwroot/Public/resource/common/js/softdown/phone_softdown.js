var SoftDown = {};
$(function(){
	SoftDown.brandSel = $("#brand_sel");
	SoftDown.modelSel = $("#model_sel");
});
//初始化数据
$(function(){
		SoftDown.jsonData = product_mqq.brands;
		var options_arr = [];
		$.each(SoftDown.jsonData,function(idx,entry){
			options_arr.push("<option value=\""+ entry.name +"\" >"+ entry.namech + "</option>");
		});
		SoftDown.brandSel.html(options_arr.join(""));
		SoftDown.changeBrand();
});
//品牌的改变
SoftDown.changeBrand = function(){
	var options_arr = [];
	var brand_name = SoftDown.brandSel.val();
    $.each(SoftDown.jsonData,function(idx,entry){
		if(brand_name == entry.name){
			var arr_models = entry.models;
			var n = arr_models.length;
			for(var i=0;i<n;i++){
				var model_name = arr_models[i].name;
				options_arr.push("<option value=\""+ model_name +"\" >"+ model_name + "</option>");
			}			
			return false;
		}
	});
	SoftDown.modelSel.html(options_arr.join(""));
	SoftDown.changeModel();
	$("select").sSelect();//select模拟
}
//机型的改变
SoftDown.changeModel = function(){
	var brand_name = SoftDown.brandSel.val();
	var model_name = SoftDown.modelSel.val();
    $.each(SoftDown.jsonData,function(idx,entry){
		if(brand_name == entry.name){
			var arr_models = entry.models;
			var n = arr_models.length;
			for(var i=0;i<n;i++){
				if(model_name == arr_models[i].name){
					var img = new Image();
					img.src = arr_models[i].logourl;
					img.onload = function(){
						$("#model_img").attr("src",arr_models[i].logourl);
						img = img.onload = img.onerror = null;
					};
					img.onerror = function(){
						$("#model_img").attr("src",'resource/common/images/d_phone.png');
					};
					if(arr_models[i].softName==1){
						$("#soft_version").html('<a href="javascript:down(\'android\');">Android</a>');
					}else if(arr_models[i].softName==2){
						$("#soft_version").html('<a href="javascript:down(\'iphone\');">IPhone</a>');
					}else if(arr_models[i].softName==3){
						$("#soft_version").html('<a href="javascript:down(\'s603\');">塞班V3</a>');
					}else if(arr_models[i].softName==4){
						$("#soft_version").html('<a href="javascript:down(\'s605\');">塞班V5</a>');
					}else if(arr_models[i].softName==5){
						$("#soft_version").html('<a href="javascript:down(\'java\');">JAVA</a>');
					}else{
						//$("#soft_version").html(arr_models[i].softName);
						$("#soft_version").html('暂未匹配到合适版本，请使用其他方式下载');
					}
					return false;
				}
			}
		}
	});
}
//初始化事件绑定
$(function(){
	SoftDown.brandSel.bind("change", function(){
		var _brand = SoftDown.brandSel.val();
		SoftDown.changeBrand();
	});
	SoftDown.modelSel.bind("change", function(){
		var _model = SoftDown.modelSel.val();
		SoftDown.changeModel();
	});
});