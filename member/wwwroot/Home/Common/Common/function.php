<?php
	require('./Include/function.php');
	require('./Include/ip.class.php');
	require('./Include/rsa.php');
	require('./Include/encrypt.class.php');
	
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
		$ch = curl_init();//初始化
		curl_setopt($ch, CURLOPT_URL,$url);//设置你所需要抓取的URL
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);////设置获取的信息以文件流的形式返回，而不是直接输出。
		curl_setopt($ch, CURLOPT_TIMEOUT, 3600); //60秒
		curl_setopt($ch, CURLOPT_HEADER,1);////设置头文件的信息作为数据流输出
		curl_setopt($ch, CURLOPT_REFERER,'http://www.yourdomain.com');
		curl_setopt($ch,CURLOPT_POST,1);// //设置post方式提交
		curl_setopt($ch, CURLOPT_POSTFIELDS,$post_fields);////设置post数据
		$data = curl_exec($ch);//执行命令
		curl_close($ch);
		$res = explode("\r\n\r\n",$data);
		return $res[2];	
	}

	function CheckwType($wType){
		$arr = array(0,1);
		return  in_array($wType, $arr);
	}
	
	function TarrayToOarray($Array , $Field){
		$arr = array();
		foreach ($Array as $key=>$value) {
			$arr[$key] = $value["$Field"];
		}
		return $arr;
	}
	
	function key_Pid_value_Key($Array , $Field){
		$arr = array();
		foreach ($Array as $key=>$value) {
			$arr["$value[Pid]"][]= $value["Key01"];
			$arr["$value[Pid]"][] = $value["Key02"];
			$arr["$value[Pid]"][] = $value["Key03"];
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
	 * 合并数组
	 * @author qxn
	 * @param unknown $post_arr
	 * @param unknown $merge_array
	 * @return multitype:|unknown
	 */
	function Check_array_merge($post_arr , $merge_array){
		if($post_arr && $merge_array) {
			return  array_merge($post_arr , $merge_array);
		}elseif ($post_arr && !$merge_array){
			return $post_arr;
		}elseif (!$post_arr && $merge_array){
			return $merge_array;
		}
	}
	
	/**
	 * 把某一二维数组中的某个键值当做另一个数组的键名
	 * @author
	 * @param unknown $arr
	 * @return multitype:
	 */
	function Pid_TouchID_merge($arr){
		foreach ($arr as $k => $v){
				$arra[$v['Pid']] = explode(',' , $v['StouchID']);
		}
		return $arra;
	}
	/**
	 * 日志记录
	 * @author qxn
	 * @param string $type 日志类型，对应logs目录下的子文件夹名
	 * @param string $content
	 * @return boolean	 日志内容
	 */
	function writelog($type="",$content=""){
		if(!$content || !$type){
			return FALSE;
		}
		$dir=getcwd().DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR.$type;
		if(!is_dir($dir)){
			if(!mkdir($dir)){
				return false;
			}
		}
		$filename=$dir.DIRECTORY_SEPARATOR.date("Ymd",time()).'.log.php';
		$logs=include $filename;
		if($logs && !is_array($logs)){
			unlink($filename);
			return false;
		}
		$logs[]=array("time"=>date("Y-m-d H:i:s"),"content"=>$content);
		$str="<?php \r\n return ".var_export($logs, true).";";
		if(!$fp=@fopen($filename,"wb")){
			return false;
		}
		if(!fwrite($fp, $str))return false;
		fclose($fp);
		return true;
	}
	
	/**
	 *
	 * @param unknown $array
	 */
	function p($array){
		//return 'function 自动调用';
		dump($array,1,'<pre>',0);
	}	
	
?>