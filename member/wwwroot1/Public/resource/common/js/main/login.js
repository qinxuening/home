
function authLogin() {
	var account = $("#account").val();
	var password = $("#password").val();
	var authCode = $("#authCode").val();
	var param = "account=" + account + "&password=" + password + "&authCode="
			+ authCode;
	$.ajax({
		url : 'loginsubmit.act',
		type : 'POST',
		dataType : 'json',
		// timeout: 1000,
		data : param,
		error : function() {

		},
		success : function(txt) {
			if (txt.flag) {
				window.location.href = "/ucenter/index.c";
			} else {
				if ('10' == txt.code)
					alert("请输入正确的密码");
				else if ('2' == txt.code)
					alert("请输入正确的账号");
				else
					alert("系统内部错误,请稍后再试");
			}
		}
	});
}


//登录
$("#login").Validform({
	btnSubmit:"#u_btn_blue",
	ajaxPost:true,
	callback:function(data){
		if(data.flag){
			window.location.href = "/ucenter/toindex.act";
		}else{
			if(showMsg(data.code,$(".valid_tip"))){ 
			if(10==data.code)
			showErrorMsg($(".valid_tip"),"密码不正确");  
			if(2==data.code)
			showErrorMsg($(".valid_tip"),"用户不存在");
			if(-1==data.code)
				showErrorMsg($(".valid_tip"),"登录超时,请稍后再试");
	       }
		}
	}
});

//qq登陆
$("#qq_login").click(function(){
	window.open('../qqlogin.html?opflag=web_login','window',"height=400,width=700,top=300,left=400,toolbar=1,menubar=1,scrollbars=no,resizable=yes,location=yes,status=1");
});

//sina登陆
$("#sina_login").click(function(){
	window.open('../sinawblogin.html?opflag=web_login','window',"height=400,width=700,top=300,left=400,toolbar=1,menubar=1,scrollbars=no,resizable=yes,location=yes,status=1");
});




