var phone;
var uid;
var email;

// 提交手机找回密码
$("#pw_step1_form").Validform({
	btnSubmit:"#pw_btn_1",
	ajaxPost:true,
	callback:function(data){
		if(data.flag){
			phone = $("#account").val();
			$(".pw_step1").hide();
			$(".pw_step2").show();
			document.getElementById("pw_nav_1_a").className = "pw_nav_1";
			document.getElementById("pw_nav_2_a").className = "pw_nav_2_a";
			uid = data.msg;
			$("#pw_form_row_1").children("strong").first().html(uid);
			$("#phone_span").html(phone);
			$("#pw_form_row_2").children("strong").first().html(phone);
			var totleTime = 60;
			totleTimer = setInterval("timefun()", 1000);
		}else{
			if(showMsg(data.code,$(".valid_tip"))){ 
			  if(1==data.code)
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


// 提交手机验证码找回密码
$("#pw_step2_form").Validform({
	btnSubmit:"#pw_btn_2",
	ajaxPost:true,
	callback:function(data){
		if(data.flag){
			$(".pw_step2").hide();
			$(".pw_step3").show();
			document.getElementById("pw_nav_2_a").className = "pw_nav_2";
			document.getElementById("pw_nav_3_a").className = "pw_nav_3_a";
			$("#pw_form_uid").children("strong").first().html(uid);
			$("#pw_form_phone").children("strong").first().html(phone);
		}else{
			if(showMsg(data.code,$(".valid_tip"))){ 
			if(1==data.code)
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

// 提交手机验证码找回密码
$("#pw_step3_form").Validform({
	btnSubmit:"#pw_btn_3",
	ajaxPost:true,
	callback:function(data){
		if(data.flag){
			$(".pw_step3").hide();
			$(".pw_step4").show();
			document.getElementById("pw_nav_3_a").className = "pw_nav_3";
			document.getElementById("pw_nav_4_a").className = "pw_nav_4_a";
			$("#span_uid").html(uid);
			$("#span_phone").html(phone);
		}else{
			if(showMsg(data.code,$(".valid_tip"))){ 
			  if(1==data.code)
			showErrorMsg($(".valid_tip"),"短信验证码错误");
			else if(-1==data.code)
				showErrorMsg($(".valid_tip"),"短信发送失败");
			else if(14==data.code)
				showErrorMsg($(".valid_tip"),"请求参数错误");
			else if(14==data.code)
				showErrorMsg($(".valid_tip"),"请求参数错误");
			}
	 }
	}
});


 


function resetPwd(){
		var pwd = $.trim($("#new_password").val());
		$.ajax({
		    url: 'resetPassword.act',
		    type: 'POST',
		    dataType: 'json',
		    data: 'password='+pwd,
		    error: function(){
		    	// alert("提交失败，请稍候重试！");
		    },
		    success: function(txt){
		    	if(txt.flag){
		    		$(".pw_step2").hide();
					$(".pw_step3").show();
					document.getElementById("pw_nav_2_a").className = "pw_nav_2";
					document.getElementById("pw_nav_3_a").className = "pw_nav_3_a";
					$("#pw_form_uid").children("strong").first().html(uid);
					$("#pw_form_phone").children("strong").first().html(phone);
		    	}else{
		    		$(".pw_step3").hide();
					$(".pw_step4").show();
					document.getElementById("pw_nav_3_a").className = "pw_nav_3";
					document.getElementById("pw_nav_4_a").className = "pw_nav_4_a";
					$("#span_uid").html(uid);
					$("#span_phone").html(phone);
		    	}
		    }
		});
}


// 提交邮箱
$("#submitEmail").Validform({
	btnSubmit:"#pw_btn_1",
	ajaxPost:true,
	callback:function(data){
		if(data.flag){
			$(".pw_step1").hide();
			$(".pw_step2").show();
			document.getElementById("pw_nav_1").className = "pw_nav_1";
			document.getElementById("pw_nav_2").className = "pw_nav_2_a";
			email=$('#email').val();
			uid=data.msg;
			$("#email_t").html(email);
		}else{
			if(-1==data.code)
			$(".valid_tip").html("邮件发送失败");
			else if(-3==data.code)
			$(".valid_tip").html("该用户不存在，请先注册");
			else if(-2==data.code)
			$(".valid_tip").html("操作太频繁，请稍后再试");
			else if(14==data.code)
			$(".valid_tip").html("参数错误");
			else
			$(".valid_tip").html("系统内部错误,请稍后再试");	
	 }
	}
});


var uid=getQueryParam("uid");
var emailCode=getQueryParam("emailcode");
var sign=getQueryParam("m");
var email=getQueryParam("email");
var lastpay=' <div class="pw_form_row"><label class="pw_label"><em>*</em> 充值方式：</label> <select onchange="billNoTitleChange();" id="lastPayType" name="appeal.lastPayType"  datatype="n" sucmsg=" "  errormsg="请选择充值方式"  nullmsg="请选择充值方式"><option>请选择充值方式</option> <option value="1">支付宝</option><option value="2">网上银行</option><option value="3">财付通</option><option value="4">移动充值卡</option><option value="5">联通充值卡</option><option value="6">电信充值卡</option><option value="7">其他</option></select></div><div class="pw_form_row"><label class="pw_label"><em>*</em> 充值金额(元)：</label>  <input type="text" id="lastPayMoney" name="appeal.lastPayMoney" class="pw_text" datatype="n" sucmsg=" "  errormsg="请输入正确的充值金额" nullmsg="请输入充值金额"></div><div class="pw_form_row"><div><label class="pw_label"><em>*</em> 最近充值时间：</label> <input type="text"  id="lastPayTime" name="appeal.lastPayTime" class="pw_text" datatype="*6-16" sucmsg=" "  errormsg="请输入正确的充值时间,如：2013年11月11日"  nullmsg="请输入最近充值时间"></div><p class="pw_tips">如记不清具体时间，可填写大致时间，如：2013年11月</p></div><div class="pw_form_row"><label class="pw_label"><em>*</em> 充值来源：</label> <select id="payFrom" name="appeal.payFrom" datatype="n" sucmsg=" "  errormsg="请选择充值来源"  nullmsg="请选择充值来源"><option >请选择充值来源</option> <option value="1">手机端充值</option><option value="2">手机访问网站充值</option><option value="3">电脑端充值</option> <option value="4">电脑访问网站充值</option><option value="5">其他</option></select></div><div class="pw_form_row"> <label class="pw_label"> 交易号/订单号：</label> <input type="text" id="payBillNo" name="appeal.payBillNo" class="pw_text"> </div>';
// 邮箱验证code
$(function(){
	if(window.location.href.indexOf('yx2')!=-1){ 
	$("#pw_form_row_1").children("strong").first().html(uid);
	$("#pw_form_row_2").children("strong").first().html(email);
	$("#email_div").html(email);
	 $.ajax({
		    url: 'findPassword4Email.act',
		    type: 'POST',
		    dataType: 'json',
		    data: 'uid='+uid+'&emailCode='+emailCode+'&sign='+sign,
		    error: function(){
		    	$(".valid_tip").html('系统出错，稍后重试!');
		    },
		    success: function(data){
		    	if(data.flag){
				}else{
					$(".valid_tip").html('找回密码参数错误!');
			 }
		    }
		});
	}else{
		 $("#lastpay_div").html(lastpay);
	}
});
	
// 邮箱验证code
$("#resetPasswdEmail").Validform({
	btnSubmit:"#pw_btn_1",
	ajaxPost:true,
	callback:function(data){
		if(data.flag){
			$("#pw_step3").hide();
			$("#pw_step4").show();
			document.getElementById("pw_nav_3_a").className = "pw_nav_3";
			document.getElementById("pw_nav_4_a").className = "pw_nav_4_a";
			$("#email_v").html(email);
			$("#uid_v").html(uid);
		}else{
			if(-2==data.code)
			$(".valid_tip").html("重置密码错误");
			else if(2==data.code)
			$(".valid_tip").html("用户不存在");
			else if(25==data.code)
			$(".valid_tip").html("长度不符");
			else
			$(".valid_tip").html("系统内部错误,请稍后再试");	
	 }
	}
});


function toLoginEmail(){
	if(email){
		var url = email.substring(email.indexOf("@")+1);
		if(hash[url]){
			window.open(hash[url]); 
		}else{
			window.open('http://mail.'+url); 
		}
	}
}

function resendEmail(){
	 $.ajax({
		    url: 'resendEmail.act',
		    type: 'POST',
		    dataType: 'json',
		    data: 'uid='+uid,
		    error: function(){
		    	// alert("提交失败，请稍候重试！");
		    },
		    success: function(txt){
		    	if(txt.flag){
		    		alert("重发成功！");
		    	}else{
					alert("重发失败！");
		    	}
		    }
		});
}


// 是否已充值
function showlast(flag){
	var lastpay_div = document.getElementById("lastpay_div");
	var childs = lastpay_div.childNodes;
	if(flag==1) 
		 $("#lastpay_div").html(lastpay);
	 else{
		 if (null != childs) {
				while (childs.length>0) {
					lastpay_div.removeChild(childs[0]);
				}
			}
	 } 
}

//
function billNoTitleChange(){
	 lastPayType= $("#lastPayType").val();
	 if(lastPayType>0&&lastPayType<4){
		 $("#billNoTitle").html("<span class='f_r'>交易号/订单号：</span><span class='zl-red'>*</span>")
	 }else{
		 $("#billNoTitle").html("交易号/订单号：")
	 }
}

// 在线密码申诉1
$(".pw_online_step1").Validform({
	btnSubmit:"#pw_btn",
	callback:function(data){
		$(".pw_online_step1").hide();
		$(".pw_online_step2").show();
		document.getElementById("pw_nav_1").className = "pw_nav_1";
		document.getElementById("pw_nav_2").className = "pw_nav_2_a";
	 }
});

// 在线密码申诉2
$(".pw_online_form").Validform({
	btnSubmit:"#pw_btn_1",
	ajaxPost:true,
	callback:function(data){
		 if(data.flag){
			 if(data.code==1){ 
			 $(".pw_online_step2").hide();
			 $(".pw_online_step3").show();
			 document.getElementById("pw_nav_2").className = "pw_nav_2";
			 document.getElementById("pw_nav_4").className = "pw_nav_4_a";
			 }
			 }else{
				 if(data.code==-105){ 
		             $(".valid_tip").html("验证码错误");
					 }
	   }
	}
});


function openNext(tmp){
	if(tmp==1){
			$(".pw_online_step1").hide();
			$(".pw_online_step2").show();
			document.getElementById("pw_nav_1").className = "pw_nav_1";
			document.getElementById("pw_nav_2").className = "pw_nav_2_a";
	}else{
		document.getElementById("pw_nav_2").className = "pw_nav_2";
		document.getElementById("pw_nav_4").className = "pw_nav_4_a";
		appealSub();
	}
	return false;
}	



