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
		return $result;
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
		return $result;
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
	
	/**
	 * 
	 * @author qxn
	 * @param unknown $Array
	 * @param unknown $Field
	 * @return Ambigous <multitype:, unknown>
	 */
	function key_Pid_value_Key($Array , $Field){
		$arr = array();
		foreach ($Array as $key=>$value) {
			$arr["$value[$Field]"][]= $value["Key1"];
			$arr["$value[$Field]"][] = $value["Key2"];
			$arr["$value[$Field]"][] = $value["Key3"];
		}
		return $arr;
	}
	
	/**
	 * @author qxn
	 * @param unknown $linklist_s 开关设备主表
	 * @param unknown $linklist_child  副表
	 * @param unknown $arr 提交联动数据
	 * @param unknown $Pid 主设备id
	 * @param unknown $wModeltype 联动类型
	 * @param unknown $Key01
	 * @param unknown $Key02
	 * @param unknown $Key03
	 */
	function add_linklist_linklist_child($linklist_s, $linklist_child ,$arr, $Pid, $wModeltype, $Key01, $Key02, $Key03){
		foreach ($arr as $key_on => $value_on){
			if(is_array($value_on)){
				$idon = $linklist_s->add(array('Pid' => $Pid , 'McID' => $key_on , 'wModeltype' => $wModeltype , 'Key01'=>$Key01,'Key02'=>$Key02,'Key03'=>$Key03));
				$linklist_child_on['wID'] = $idon;
				$linklist_child_on['McID'] = $Pid;
				$linklist_child_on['Key1'] = in_array('Key1', $value_on)? 1:0;
				$linklist_child_on['Key2'] = in_array('Key2', $value_on)? 1:0;
				$linklist_child_on['Key3'] = in_array('Key3', $value_on)? 1:0;
				$linklist_child_on['mark'] = 2;
				$linklist_child->add($linklist_child_on);
			}else{
				$linklist_s->add(array('Pid' => $Pid , 'McID' => $value_on , 'wModeltype' => $wModeltype , 'Key01'=>$Key01,'Key02'=>$Key02,'Key03'=>$Key03));
			}
		}
	}
	
	/**
	 * @author qxn 
	 * @param unknown $linklist 非开关类主设备
	 * @param unknown $linklist_child  副表
	 * @param unknown $arr 提交联动数据
	 * @param unknown $Pid 主设备id
	 * @param unknown $wModeltype 联动类型
	 */
	function  add_linklist2_linklist_child($linklist, $linklist_child ,$arr, $Pid, $wModeltype){
		foreach ($arr as $key_on => $value_on){
			if(is_array($value_on)){
				$idon = $linklist->add(array('McID' => $Pid , 'Pid' => $key_on , 'wModeltype' => $wModeltype));
				$linklist_child_on['wID'] = $idon;
				$linklist_child_on['McID'] = $Pid;
				$linklist_child_on['Key1'] = in_array('Key1', $value_on)? 1:0;
				$linklist_child_on['Key2'] = in_array('Key2', $value_on)? 1:0;
				$linklist_child_on['Key3'] = in_array('Key3', $value_on)? 1:0;
				$linklist_child_on['mark'] = 1;
				$linklist_child->add($linklist_child_on);
			}else{
				$linklist->add(array('McID' => $Pid , 'Pid' => $value_on , 'wModeltype' => $wModeltype));
			}
		}
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