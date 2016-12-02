// 初始化商品
var goodsList;
var pull;

$("#payform").Validform({
			tiptype  : 6,
			ajaxPost : false,
			callback : function(data) {
			}
		});

// 默认加载套餐
$(document).ready(function() {
	var uid = GetCookie("U_UID_JSESSIONID_KEEPC");
	var account = GetCookie("U_NAME_JSESSIONID_KEEPC");
	if(account&&'""'!=account&&""!=account&&"null"!=account){
		$("#account").val(account);
		$("#account").focus();
		$("#reaccount").val(account);
		$("#reaccount").focus();
	}
	payCenter(uid);
});

// 加载充值套餐信息
function payCenter(uid) {
	uid = (uid&&'""'!=uid&&""!=uid&&"null"!=uid) ?  uid:'' ;
	$.ajax({
		type : "POST",
		url : "getGoodsList.act",
		dataType : "json",
		data : "bid=kc&v=1.0.0&pv=web&uid=" + uid,
		success : function(data) {
			goodsList = data.data;
			if(goodsList.length==0)
				return;
			removeDiv();
			var pullMsg = data.obj.pay_info;
			// 最新优惠
			var new_sale = data.obj.favourable_info;
			var news = new Array();
			news = new_sale.split('\n');
			
			var p='';
			for (i = 0; i < news.length; i++) {
				if (news[i] != '')
					p+="<p>" + news[i] + "</p>";
			}
			$("#new_sale_con").html(p);
			goodslist(goodsList, pullMsg)
		},
		error : function() {
			//alert("获取充值动态商品出错,请刷新再试！");
		}

	});
}

// 清结点
function removeDiv() {
	var pay1 = document.getElementById("pay_div1");
	var childs = pay1.childNodes;
	if (null != childs) {
		for (i = 0; i < childs.length; i++) {
			pay1.removeChild(childs[0]);
		}
	}
	var pay2 = document.getElementById("pay_div2");
	childs = pay2.childNodes;
	var len = childs.length;
	if (null != childs) {
		for (i = 0; i < len; i++) {
			pay2.removeChild(childs.item(0));
		}
	}
	var pay3 = document.getElementById("pay_div3");
	childs = pay3.childNodes;
	if (null != childs) {
		for (i = 0; i < childs.length; i++) {
			pay3.removeChild(childs[0]);
		}
	}
	var new_sale = document.getElementById("new_sale_con");
	childs = new_sale.childNodes;
	if (null != childs) {
		for (i = 0; i < childs.length; i++) {
			new_sale.removeChild(childs[0]);
		}
	}
}

function goodslist(goodsList, pullMsg) {
	var length = goodsList.length;
	var re = new RegExp("送(.+)元");
	var reg = new RegExp("送([^\x00-\xff]+)");
	var isRecom = true;
	if(length==0)
		return;
	for ( var i = 0; i < length; i++) {
		var goods = goodsList[i];
		var goodId = goods["goods_id"];
		var goodName = goods["name"];
		var good;
		good=goodName;
		var recommendFlag = goods["recommend_flag"] + "";
		var url = goods["url"];
		var sum;
		var ma;
		var song;
		var flag = true;
		// 送xx元，红色
		if ((ma = re.exec(goodName)) != null) {
			ma = goodName.match(re);
			sum = ma[1];
			song = ma[0];
			var s = song;
			s = song;
			//s = s.replace(sum, '<em class="org">' + sum + '</em>');
			goodName = goodName.replace(song, s);
			flag = false;
		}
		// 送xx元，红色
		if (flag && (ma = reg.exec(goodName)) != null) {
			ma = goodName.match(reg);
			sum = ma[1];
			//goodName = goodName.replace(sum, '<em class="org">' + sum + '</em>');
		}
		var p = $("<p>");
		var inp = '<label><input type="radio" name="rechargeDto.goodsId" onClick="desc();" id="moneygrouprad_0" value="'
				+ goodId+'_'+good + '"';
		var goodsDesc;
		if (recommendFlag == "y") {
			inp += 'checked="true"';
			isRecom = false;
			goodsDesc=good;
		}
		inp += "/>";
		var aTag = "<a ";
		var inpFlag = inp + ' <span>' + goodName + '</span> </label>';
		var inps = inp + ' <span>' + goodName + '</span> </label>';
		if (recommendFlag == "y") {
			p.append($(inpFlag));
			if (url != null && url != '') {
				aTag += 'href="' + url + '"  target="_blank">查看详情>></a>';
				p.append("&#12288;");
				p.append($(aTag));
			}
			$("#pay_div1").append(p);
		} else if (recommendFlag == "n") {
			p.append($(inps));
			if (url != null && url != '') {
				aTag += 'href="' + url + '"  target="_blank">查看详情>></a>';
				p.append("&#12288;");
				p.append($(aTag));
			}
			$("#pay_div2").append(p);
		}
	}
	var msg = pullMsg;
	$("#pay_div3").append(msg);
	if (isRecom) {
		var robj = document.getElementById("moneygrouprad_0");
		robj.checked = true;
		$("#pay_recommond").hide();
	} else {
		$("#pay_recommond").show();
	}
}


 
