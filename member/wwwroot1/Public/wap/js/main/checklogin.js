//判断是否已经是登陆状态，是的话，则直接进入账号账户中心
if(checkLoginStatus()){
	window.location.href="ucenter/toindex.act";
}


//判断是否已经是登陆状态
function checkLoginStatus(){
	var account = GetCookie("U_NAME_JSESSIONID_KEEPC");
	if (account&&'""'!=account&&""!=account&&"null"!=account)
		return true;
	return false;
}



