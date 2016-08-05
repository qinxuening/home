function buyIpPhone(id) {
	var url = "/phone/ip_order.html?id=" + id;
	window.open(url);
};

var id = getQueryParam("id");
$(document)
		.ready(
				function() {
					var html;
					if (id == '1') {
						html = ' <p class="ip_order_detail"><em>价格:258元</em></p><p>包含一部IP话机</p><p>含国内运费</p';
					} else if (id == '2') {
						$('#MoneyGroup').val('80500');
						html = ' <p class="ip_order_detail"><em>价格:399元</em></p><p>包含一部IP话机，送399元KC话费</p><p>含国内运费</p>';
					} else {
						$('#MoneyGroup').val('80600');
						html = ' <p class="ip_order_detail"><em>价格:688元</em></p><p>包含二部IP话机，每部送344元KC话费</p><p>含国内运费</p>';
					}
					$('#ip_phone_desc').html(html);
				});


//提交邮箱注册
$("#ipmain").Validform({
	btnSubmit:"#btn_charge",
	ajaxPost:false,
	callback:function(data){
		on_submit();
	}
});



function setPayTypeValue(v) {
	if (v == "cmcc") {// 神州行充值卡充值
		$("#paytype").val("210");
	}else if (v == "alipay") {// 支付宝充值
		$("#paytype").val("16");
	}else if (v == "tenpay") {// 财付通充值
		$("#paytype").val("26");
	}else if (v == "unicom") {// 中国联通充值卡充值
		$("#paytype").val("212");
	}else if (v == "cha") {// 中国电信
		$("#paytype").val("214");
	}else if (v == "jwykt") {// 骏网一卡通
		$("#paytype").val("30");
	}else if (v == "kccard") {// KC卡
		$("#paytype").val("98");
	}else if (v == "sft") {// 盛付通
		$("#paytype").val("220");
	}else{
		$("#paytype").val("216");
	}
}


function on_submit(){
	var obj = $("input[name='subbank']:checked").val();
	setPayTypeValue(obj);
	document.ipform.submit();
}


