$(function(){

function operateParam() {
	showTag();
	//showFooter()
	var data = getQueryParam("c");
	var type = getQueryParam("t");
	if (data != null && trim(data) != '' && trim(data) != 'null' && type != null && trim(type) != '' && trim(type) != 'null') {
		// add cookie
		var map = new Map();
		if (type == 1)
			map.put("U_CHANNEL_JSESSIONID", trim(data));
		else if (type == 2)
			map.put("U_INVITED_JSESSIONID", trim(data));
		else if (type == 3)
			map.put("U_INVITEDFLAG_JSESSIONID", trim(data));
		setCookie(map);
	}
};

operateParam();

function showTag(){
	var uid = GetCookie("U_UID_JSESSIONID_KEEPC");
	var account = GetCookie("U_NAME_JSESSIONID_KEEPC");
	var bc = GetCookie("U_BC_JSESSIONID_KEEPC");
	//var nick="";
	if (account&&'""'!=account&&""!=account&&"null"!=account){
		$('#logcon').show();
		$('#nologcon').hide();
		$('#h_nickname').html(account);
		$('#balance').html(bc);
		$('#balance_2').html(bc)		
	}else{
		$('#logcon').hide();
		$('#nologcon').show();
		
	}
	
	var h_leave = document.getElementById('h_leave');
	var h_leave_a = document.getElementById('h_leave_a');
	if (h_leave&&h_leave_a&&account&&'""'!=account&&""!=account&&"null"!=account) {
		h_leave.onmouseover = function() {
			h_leave_a.style.display = 'block';
		}
		h_leave_a.onmouseover = function() {
			h_leave_a.style.display = 'block';
		}
		h_leave_a.onmouseout = function() {
			h_leave_a.style.display = 'none';
		}
	}
}
})


function logout() {
	href = "/logout.act";
	if (href.charAt(0) != '/') {
		href = '/' + href;
	}
	$.ajax({
		url : '/logout.act',
		type : 'POST',
		dataType : 'json',
		// timeout: 1000,
		error : function() {
		},
		success : function(txt) {
			if (txt.flag) {
				window.location.reload();
			} else {
			}
		}
	});
}

