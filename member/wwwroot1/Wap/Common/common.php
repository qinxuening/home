<?php

	require('./Include/function.php');
	require('./Include/ip.class.php');
	require('./Include/rsa.php');
	require('./Include/encrypt.class.php');
	//rsa支持中文
	function convert($hexString) 
	{ 
		$hexLenght = strlen($hexString); 
		// only hex numbers is allowed 
		if ($hexLenght % 2 != 0 || preg_match("/[^\da-fA-F]/",$hexString)) return FALSE; 
	
		unset($binString);
		for ($x = 1; $x <= $hexLenght/2; $x++) 
		{ 
			$binString .= chr(hexdec(substr($hexString,2 * $x - 2,2))); 
		} 
	
		return $binString;
	} 
	//手机号码星号处理
	function mobile($phone){
	$p = substr($phone,0,3)."****".substr($phone,7,4);
	return $p;
	}
	
	//发送短信函数
	function smsto($telphone,$message)
	{
		//短信接口用户名 $uid
		$uid = '';
		//短信接口密码 $passwd
		$pwd = '';
		//$message =urlencode(iconv('UTF-8', 'GB2312', $message));
		$message=urlencode($message);
		//$sendurl="http://service.winic.org/sys_port/gateway/?id=".$uid."&pwd=".$pwd."&to=".$telphone."&content=".$message."&time=";
		$sendurl="http://sms.106jiekou.com/utf8/sms.aspx?account=".$uid."&password=".$pwd."&mobile=".$telphone."&content=".$message."";
		$result = file_get_contents($sendurl);
		return $result;
	}

	//国内
	function intlsmsto1($telphone,$message,$vercode)
	{
	
		$username = '';		//用户账号
		$password = '';	//密码
		$apikey = '';	//密码
		$mobile	 = $telphone;	//号手机码
		$content = $message;//内容
		//即时发送
		$result = sendSMS($username,$password,$telphone,$content,$apikey);
	}

	//国际
	function intlsmsto($telphone,$message,$vercode)
	{
	
		$username = '';		//用户账号
		$password = '';	//密码
		$apikey = '';	//密码
		$mobile	 = $telphone;	//号手机码
		$content = $message;//内容
		//即时发送
		$result = sendSMS($username,$password,$telphone,$content,$apikey);
	}
	
	
	function sendSMS($username,$password,$mobile,$content,$apikey)
	{
		$url = 'http://m.5c.com.cn/api/send/?';
		$data = array
		(
				'username'=>$username,					//用户账号
				'password'=>$password,				//密码
				'mobile'=>$mobile,					//号码
				'content'=>$content,				//内容
				'apikey'=>$apikey,				    //apikey
		);
		$result= curlSMS($url,$data);			//POST方式提交
		return $result;
	}
	
	function curlSMS($url,$post_fields=array()){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3600); //60秒
		curl_setopt($ch, CURLOPT_HEADER,1);
		curl_setopt($ch, CURLOPT_REFERER,'http://www.yourdomain.com');
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$post_fields);
		$data = curl_exec($ch);
		curl_close($ch);
		$res = explode("\r\n\r\n",$data);
		return $res[2];
			
	}

	function remove_xss($val) {
		// remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
		// this prevents some character re-spacing such as <java\0script>
		// note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
		$val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
	
		// straight replacements, the user should never need these since they're normal characters
		// this prevents like <IMG SRC=@avascript:alert('XSS')>
		$search = 'abcdefghijklmnopqrstuvwxyz';
		$search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$search .= '1234567890!@#$%^&*()';
		$search .= '~`";:?+/={}[]-_|\'\\';
		for ($i = 0; $i < strlen($search); $i++) {
			// ;? matches the ;, which is optional
			// 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
	
			// @ @ search for the hex values
			$val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
			// @ @ 0{0,7} matches '0' zero to seven times
			$val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
		}
	
		// now the only remaining whitespace attacks are \t, \n, and \r
		$ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
		$ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
		$ra = array_merge($ra1, $ra2);
	
		$found = true; // keep replacing as long as the previous round replaced something
		while ($found == true) {
			$val_before = $val;
			for ($i = 0; $i < sizeof($ra); $i++) {
				$pattern = '/';
				for ($j = 0; $j < strlen($ra[$i]); $j++) {
					if ($j > 0) {
						$pattern .= '(';
						$pattern .= '(&#[xX]0{0,8}([9ab]);)';
						$pattern .= '|';
						$pattern .= '|(&#0{0,8}([9|10|13]);)';
						$pattern .= ')*';
					}
					$pattern .= $ra[$i][$j];
				}
				$pattern .= '/i';
				$replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
				$val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
				if ($val_before == $val) {
					// no replacements were made, so exit the loop
					$found = false;
				}
			}
		}
		return $val;
	}
	function CheckwType($wType){
		$arr = array(0,1);
		return  in_array($wType, $arr);
}
?>