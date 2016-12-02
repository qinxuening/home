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

	function list_to_tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
		// 创建Tree
		$tree = array();
		if(is_array($list)) {
			// 创建基于主键的数组引用
			$refer = array();
			foreach ($list as $key => $data) {
				$refer[$data[$pk]] =& $list[$key];
			}
			foreach ($list as $key => $data) {
				// 判断是否存在parent
				$parentId =  $data[$pid];
				if ($root == $parentId) {
					$tree[] =& $list[$key];
				}else{
					if (isset($refer[$parentId])) {
						$parent =& $refer[$parentId];
						$parent[$child][] =& $list[$key];
					}
				}
			}
		}
		return $tree;
	}

	function CheckwType($wType){
		$arr = array(0,1);
		return  in_array($wType, $arr);
}
?>