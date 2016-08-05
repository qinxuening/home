var clip = new ZeroClipboard(document.getElementById("copy-button"), {
	moviePath : "/resource/common/js/zeroclipboard/ZeroClipboard.swf" //resource/common/js/zeroclipboard
});

clip.on('complete', function(client, args) {
	if(args.text!=''){
		alert("复制成功\n您可以在QQ、微博、论坛或其他网站中直接粘贴使用。 ");
	}else{
		alert("请先生成链接")
	}
});

$(document).ready(function() {
	var account =  GetCookie("U_NAME_JSESSIONID_KEEPC");
	if (account != null) {
		$("#sclj_input").val(account);
	}
	$("#sclj_input").focus(function() {
		var value = $(this).val();		
	});
});

function on_make(bshow) {
	var account = $("#sclj_input").val();
	var host=document.domain;
	if((isNum(account) && account.length>=5 && account.length<=13)||isEmail(account)||isMobile(account)) {
		$('#invite_url').val(host+"/wap/laxin.c?s=web-url&a=" + account);
	}else{
		alert("您填写的帐号错误，请重新填写\n您可以填写绑定手机号或邮箱");
		return false;
	}
	
}

 

 
 