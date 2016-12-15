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
	 * @author
	 * 整合模式开关按键
	 * @param unknown $Array
	 * @param unknown $Field
	 * @param unknown $Type
	 * @return Ambigous <multitype:, unknown>
	 */
	function key_wModel_value_Key($Array , $Field, $Type){
		$arr = array();
		foreach ($Array as $key=>$value) {
			if($value['wType'] == $Type && substr($value['McID'], 0,2) == '14'){
				$arr["$value[$Field]"][]= $value["Key1"];
				$arr["$value[$Field]"][] = $value["Key2"];
				$arr["$value[$Field]"][] = $value["Key3"];
			}
		}
		return $arr;
	}	

	/**
	 * @author 整合时间开关按键
	 * @param unknown $Array
	 * @param unknown $Field
	 * @return Ambigous <multitype:, unknown>
	 */
	function key_timeaction_value_Key($Array , $Field){
		$arr = array();
		foreach ($Array as $key=>$value) {
			if(substr($value['McID'], 0,2) == '14'){
				$arr["$value[$Field]"][]= $value["Key1"];
				$arr["$value[$Field]"][] = $value["Key2"];
				$arr["$value[$Field]"][] = $value["Key3"];
			}
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
	
	/**
	 * @author qxn
	 * 处理模式开关按键
	 * @param unknown $modeltype
	 * @param unknown $modeltype_child
	 * @param unknown $arr
	 * @param unknown $Pid
	 * @param unknown $Type
	 */
	function Do_modeltype_child($modeltype, $modeltype_child, $arr, $Pid, $Type){
		foreach ($arr as $key => $value){
			if(is_array($value)){
				$idon = $modeltype->add(array('wUseID' => session('wUseID'), 'wModel'=>$Pid, 'McID' => $key, 'wType' => $Type));
				$modeltype_child_list['Pid'] = $idon;
				$modeltype_child_list['wUseID'] = session('wUseID');
				$modeltype_child_list['wModel'] = $Pid;
				$modeltype_child_list['McID'] = $key;
				$modeltype_child_list['Key1'] = in_array('Key1', $value)? 1:0;
				$modeltype_child_list['Key2'] = in_array('Key2', $value)? 1:0;
				$modeltype_child_list['Key3'] = in_array('Key3', $value)? 1:0;
				$modeltype_child->add($modeltype_child_list);
			}else{
				$modeltype->add(array('wUseID' => session('wUseID'), 'wModel'=>$Pid, 'McID' => $value, 'wType' => $Type));
			}
		}
	}

	/**
	 * @author qx
	 * 处理时间开关按键
	 * @param unknown $timeaction
	 * @param unknown $timeacion_child
	 * @param unknown $arr
	 * @param unknown $Pid
	 */
	function Do_Timeaction_child($timeaction, $timeacion_child, $arr, $Pid){
		foreach ($arr as $key => $value){
			if(is_array($value)){
				$id = $timeaction->add(array('wUseID' => session('wUseID'), 'wModel' => $Pid, 'McID' => $key));
				$timeaction_child_list['Pid'] = $id;
				$timeaction_child_list['wUseID'] = session('wUseID');
				$timeaction_child_list['wModel'] = $Pid;
				$timeaction_child_list['McID'] = $key;
				$timeaction_child_list['Key1'] = in_array('Key1', $value)? 1:0;
				$timeaction_child_list['Key2'] = in_array('Key2', $value)? 1:0;
				$timeaction_child_list['Key3'] = in_array('Key3', $value)? 1:0;
				$timeacion_child->add($timeaction_child_list);
			}else{
				$timeaction->add(array('wUseID' => session('wUseID'), 'wModel' => $Pid, 'McID' => $value));
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