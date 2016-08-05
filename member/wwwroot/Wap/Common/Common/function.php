<?php
	require('./Include/function.php');
	require('./Include/ip.class.php');
	require('./Include/rsa.php');
	require('./Include/encrypt.class.php');
	//rsa支持中文
	function convert($hexString) 
	{ 
		$hexLenght = strlen($hexString); 
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

	//国内
	function smsto($telphone,$message)
	{
		$uid = '';
		$pwd = '';
		$message=urlencode($message);
		$sendurl="http://sms.106jiekou.com/utf8/sms.aspx?account=".$uid."&password=".$pwd."&mobile=".$telphone."&content=".$message."";
		$result = file_get_contents($sendurl);
		return $result;
	}

	//国际
	function intlsmsto($telphone,$message,$vercode)
	{
	
		$username = '';
		$password = '';
		$apikey = '';
		$mobile	 = $telphone;
		$content = $message;
		$result = sendSMS($username,$password,$telphone,$content,$apikey);
		return $result;
	}
	
	function sendSMS($username,$password,$mobile,$content,$apikey)
	{
		$url = 'http://m.5c.com.cn/api/send/?';
		$data = array
		(
				'username'=>$username,				
				'password'=>$password,			
				'mobile'=>$mobile,	
				'content'=>$content,	
				'apikey'=>$apikey,	
		);
		$result= curlSMS($url,$data);
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

	function CheckwType($wType){
		$arr = array(0,1);
		return  in_array($wType, $arr);
	}
	
	/**
	 * 返回二维数组某个值
	 * @author qxn
	 * @param unknown $Array
	 * @param unknown $Field
	 * @return multitype:unknown
	 */
	function TarrayToOarray($Array , $Field){
		$arr = array();
		foreach ($Array as $key=>$value) {
			$arr[$key] = $value["$Field"];
		}
		return $arr;
	}
	
	function CheckLength($data, $Min, $Max){
		if(mb_strlen($data)< $Min || mb_strlen($data)> $Max){
			return true;
		}else{
			return false;
		}
	}
	
	function CheckNumber($number){
		$preg = '/^[1-9]\d{4,15}$/';
		if(!preg_match($preg, $number)){
			return true;
		}
	}	
	
	/**
	 * 查找二维数组某个键值
	 * @author qxn
	 * @param unknown $Arr
	 * @param unknown $Value
	 * @param unknown $pid
	 * @return mixed
	 */
	function FindArrKey($Arr, $Value, $pid){
		foreach ($Arr as $k=> $v){
			$arr[$k] = $v[$Value];
		}
		return array_search($pid, $arr);
	}
	
	/**
	 * 加密
	 * @author qxn
	 * @param string $string
	 * @param string $skey
	 * @return mixed
	 */
	 function encode($string = '', $skey = 'OUBAO') {
	    $strArr = str_split(base64_encode($string));
	    $strCount = count($strArr);
	    foreach (str_split($skey) as $key => $value)
	        $key < $strCount && $strArr[$key].=$value;
	    return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr)).substr(md5($string) , -10);//join将数组合并为字符串
	 }
	 
	 /**
	  * 解密
	  * @author qxn
	  * @param string $string
	  * @param string $skey
	  * @return string
	  */
	 function decode($string = '', $skey = 'OUBAO') {
	 	$strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), substr($string , 0 , -10)), 2);//str_split() 函数把字符串分割到数组中
	 	$strCount = count($strArr);
	 	foreach (str_split($skey) as $key => $value){
	 		$key <= $strCount  && isset($strArr[$key]) && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];}
	 	return base64_decode(join('', $strArr));
	 }
?>