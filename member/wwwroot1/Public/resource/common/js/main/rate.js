

//按照首字母查询
function showfee(word){
	  var str=ajaxrequestforrate("firstName="+word,true);
	}
//showfee('A');
function ajaxrequestforrate(da,byfirst){
		 //da=encodeURI(da);
		 //url: "http://59.36.98.114:8080/rateweb/rateStat.act",
		 var  str ="<table class='rate_table'><tr><th width='165'>国家（或区域）代码</th><th class='rate_country' width='230'>国家地区</th><th>KC标准资费</th></tr>";
		 $.ajax({
				url: "/getRatesList.act",
				async:false,
				type: "post",
				dataType:"json",  
		        json:"callback",  
		        data:da,
		        success:function(result){  
		        	var data=result.data;
		     	 	for(i =0; i< data.length; i++){
		     	 		var rate = data[i];
			  	         str=str+"<tr><td>"+rate.countryCode+"</td><td class='rate_country'>"+rate.countryName+"</td><td>￥"+rate.kcrate+"元/分钟</td></tr>";
		  	       	}
		     	 	str =str +"</table>";
		     	 	$('#default_rate').hide();
		     	 	if(byfirst){
		     	 		removeLitag("showfee");
		     	 		var tag="rate_"+da.split("=")[1];
		     	 		tag=tag.toLocaleLowerCase();
		     	 		$('#'+tag).addClass('active');
		     	 		//document.getElementById(tag).style.className = "active";
		     	 		$('#fname').val('');
		     	 		$("#rateValue").html(str);
		     	 		$("#rateWord").show();
		     	 		$("#results").hide();
		     	 	}else{
		     	 		$("#rateWord").hide();
		     	 		$("#results").show();
		     	 		$("#resultsValue").html(str);
		     	 	}
		        },
		        error: function(xhr){ 
		            //alert("请求出错(请检查相关度网络状况.)"); 
		        } 
		});
		 return str;
	 }

//按照名字查询
function queryrate(){
	var key = document.getElementById('fname').value.trim();
	if( document.getElementById('fname').value.trim() == ""){
		document.getElementById("fname").focus();
		return false;
	}
	 var reg=new RegExp("^[0-9]*$");
	 //判断是code还是地区
	if(reg.exec(key)==null)
	var str=ajaxrequestforrate("name="+key,false);
	else
	var str=ajaxrequestforrate("code="+key,false);
 	return false;
}	



