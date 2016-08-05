
var mobile;
var email;
//注册
$("#register").Validform({
	btnSubmit:"#u_btn_blue_1",
	ajaxPost:true,
	callback:function(data){
		if(data.flag){
			$(".valid_tip").html("");
			  mobile=$("#account").val();
			 $("#reg_step1").hide();
    		 $("#reg_step_21").children("span").html(mobile);
    		 $("#reg_step2").show();
    		 $("#mobile_no").val(mobile);
		}else{
			if(showMsg(data.code,$(".valid_tip"))){ 
			if(10==data.code){
			showErrorMsg($(".valid_tip"),"密码不正确");  
			return;
			}
			if(2==data.code){
			showErrorMsg($(".valid_tip"),"用户不存在");
			return;
			}
			if(-1==data.code){
				showErrorMsg($(".valid_tip"),"登录超时,请稍后再试");
				return;
			}
			else showErrorMsg($(".valid_tip"),"系统内部错误,请稍后再试");
			}
	 }
	}
});

//服务条款
$("#serviceProtocol").Validform({
	btnSubmit:"#u_btn_blue_1",
	ajaxPost:false,
	callback:function(data){
		var userProtocol=$("#m_userProtocol").attr("checked");
		if(!userProtocol){
		       alert("请阅读并同意KC 服务条款！");
			   return false;
		   }
	}
});

//服务条款
$("#serviceProtocol3").Validform({
	btnSubmit:"#u_btn_blue_3",
	ajaxPost:false,
	callback:function(data){
		var userProtocol=$("#m_userProtocol").attr("checked");
		if(!userProtocol){
		       alert("请阅读并同意KC 服务条款！");
			   return false;
		   }
	}
});


//提交手机注册
$("#submitRegister").Validform({
	btnSubmit:"#u_btn_blue_2",
	ajaxPost:true,
	callback:function(data){
		if(data.flag){
			 $("#register_main").hide();
    		 $("#u_tips_info_mobile").children("span").first().html(mobile);
    		 $("#u_tips_info_mobile").children("span").last().html(data.msg);
    		 $("#mobile_success").show();
		}else{
			if(showMsg(data.code,$(".valid_tip"))){ 
			if(5==data.code)
			showErrorMsg($(".valid_tip"),"此号码已经注册，请更换手机号注册");  
			else if(1==data.code)
			showErrorMsg($(".valid_tip"),"短信验证码错误");
			else if(-1==data.code)
				showErrorMsg($(".valid_tip"),"注册超时,请稍后再试");
			else if(14==data.code)
				showErrorMsg($(".valid_tip"),"请求参数错误");
			else if(14==data.code)
				showErrorMsg($(".valid_tip"),"请求参数错误");
			}
	 }
	}
});



//提交邮箱注册
$("#submitEmailRegister").Validform({
	btnSubmit:"#u_btn_blue_3",
	ajaxPost:true,
	callback:function(data){
		if(data.flag){
			email=$(".m_input_email").val();
			 $("#register_main").hide();
    		 $("#u_tips_info_email").children("span").first().html(email);
    		 $("#u_tips_info_email").children("span").last().html(data.msg);
    		 $("#u_tips_info_email_1").children("p").first().children("span").first().html(email);
    		 $("#email_success").show();
		}else{
			if(showMsg(data.code,$(".valid_tip"))){ 
			if(18==data.code)
			showErrorMsg($(".valid_tip"),"此邮箱已经注册，请更换邮箱注册");  
			else if(1==data.code)
			showErrorMsg($(".valid_tip"),"短信验证码错误");
			else if(-1==data.code)
				showErrorMsg($(".valid_tip"),"注册超时,请稍后再试");
			else if(14==data.code)
				showErrorMsg($(".valid_tip"),"请求参数错误");
			}
	   }
	}
});

 

function authMobile(){
	var account=$("#account").val();
	var authCode=$("#authCode1").val();
	var param="account="+account+"&password="+password+"&authCode="+authCode;
	 $.ajax({
		    url: 'loginsubmit.act',
		    type: 'POST',
		    dataType: 'json',
		  //  timeout: 1000,
		    data : param,
		    error: function(){
		    	alert("提交失败，请稍候重试！");
		    },
		    success: function(txt){
		    	if(txt.flag){
		    		 
		    	}else{
		    		alert(txt.msg);
		    	}
		    }
		});
	
}


