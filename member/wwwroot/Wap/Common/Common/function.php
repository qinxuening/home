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
	 * 获取温湿度键值
	 * @param unknown $Array
	 * @param unknown $Field
	 * @return Ambigous <multitype:, unknown>
	 */
	function key_Pid_value_Key_temp($Array , $Field, $k, $wModeltype){
		$arr = array();
		foreach ($Array as $key=>$value) {
			if($value[$k] && $value['wModeltype'] == $wModeltype){
				$arr["$value[$Field]"][]= $value["Th"];
				$arr["$value[$Field]"][] = $value["Tl"];
				$arr["$value[$Field]"][] = $value["Hh"];
				$arr["$value[$Field]"][] = $value["Hl"];
				$arr["$value[$Field]"][] = $value["Tf"];
			}
		}
		return $arr;
	}
	
	function key_other_temp($Array , $Field, $wModeltype){
		$arr = array();
		foreach ($Array as $key=>$value) {
			if($value['wModeltype'] == $wModeltype){
				$arr["$value[$Field]"][]= $value["Th"];
				$arr["$value[$Field]"][] = $value["Tl"];
				$arr["$value[$Field]"][] = $value["Hh"];
				$arr["$value[$Field]"][] = $value["Hl"];
				$arr["$value[$Field]"][] = $value["Tf"];
			}
		}
		return $arr;
	}
	/**
	 * @author
	 * 整合模式开关按键、温湿度按键
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
	
	function key_modeltype_temp($Array , $Field, $Type){
		//print_r($Array);
		$arr = array();
		foreach ($Array as $key=>$value) {
			if($value['wType'] == $Type && substr($value['McID'], 0,2) == '19'){
				$arr["$value[$Field]"][]= $value["Th"];
				$arr["$value[$Field]"][] = $value["Tl"];
				$arr["$value[$Field]"][] = $value["Hh"];
				$arr["$value[$Field]"][] = $value["Hl"];
				$arr["$value[$Field]"][] = $value["Tf"];
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
	
	
	function key_timeaction_temp($Array , $Field){
		$arr = array();
		foreach ($Array as $key=>$value) {
			if(substr($value['McID'], 0,2) == '19'){
				$arr["$value[$Field]"][]= $value["Th"];
				$arr["$value[$Field]"][] = $value["Tl"];
				$arr["$value[$Field]"][] = $value["Hh"];
				$arr["$value[$Field]"][] = $value["Hl"];
				$arr["$value[$Field]"][] = $value["Tf"];
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
	function add_linklist_linklist_child($linklist_s, $linklist_child, $linklist_temp, $arr, $Pid, $wModeltype, $Key01, $Key02, $Key03){
		foreach ($arr as $key_on => $value_on){
			if(is_array($value_on)){
				$idon = $linklist_s->add(array('Pid' => $Pid , 'McID' => $key_on , 'wModeltype' => $wModeltype , 'Key01'=>$Key01,'Key02'=>$Key02,'Key03'=>$Key03));
				if(substr($value_on[0], 0,3) == 'Key'){
					$linklist_child_on['wID'] = $idon;
					$linklist_child_on['McID'] = $Pid;
					$linklist_child_on['Key1'] = in_array('Key1', $value_on)? 1:0;
					$linklist_child_on['Key2'] = in_array('Key2', $value_on)? 1:0;
					$linklist_child_on['Key3'] = in_array('Key3', $value_on)? 1:0;
					$linklist_child_on['mark'] = 2;
					$linklist_child->add($linklist_child_on);
				}else{
					$linklist_child_on['wID'] = $idon;
					$linklist_child_on['McID'] = $Pid;
					$linklist_child_on['Th'] = in_array('T1', $value_on)? 1:0;
					$linklist_child_on['Tl'] = in_array('T2', $value_on)? 1:0;
					$linklist_child_on['Hh'] = in_array('T3', $value_on)? 1:0;
					$linklist_child_on['Hl'] = in_array('T4', $value_on)? 1:0;
					$linklist_child_on['Tf'] = in_array('T5', $value_on)? 1:0;
					$linklist_child_on['mark'] = 2;
					$linklist_temp->add($linklist_child_on);
				}
			}else{
				$linklist_s->add(array('Pid' => $Pid , 'McID' => $value_on , 'wModeltype' => $wModeltype , 'Key01'=>$Key01,'Key02'=>$Key02,'Key03'=>$Key03));
			}
		}
	}
	
	
	/**
	 * @author qxn
	 * 添加联动数据：主设备是温湿度类
	 * @param unknown $linklist_temp 温湿度主表
	 * @param unknown $linklist_child 被联动开关的表
	 * @param unknown $linklist_temp_child 被联动温湿度表
	 * @param unknown $arr
	 * @param unknown $Pid主设备Pid
	 * @param unknown $wModeltype 联动方式
	 * @param unknown $Th0
	 * @param unknown $Tl0
	 * @param unknown $Hh0
	 * @param unknown $Hl0
	 * @param unknown $Tf0
	 */
	function add_linklist_temp($linklist_temp, $linklist_child, $linklist_temp_child, $arr, $Pid, $wModeltype,$Th0, $Tl0, $Hh0, $Hl0, $Tf0 ){
		foreach ($arr as $key_on => $value_on){
			if(is_array($value_on)){
				$idon = $linklist_temp->add(array('Pid' => $Pid , 'McID' => $key_on , 'wModeltype' => $wModeltype , 'Th0'=>$Th0,'Tl0'=>$Tl0,'Hh0'=>$Hh0, 'Hl0'=>$Hl0, 'Tf0'=>$Tf0));
				if(substr($value_on[0], 0,3) == 'Key'){
					$linklist_child_on['wID'] = $idon;
					$linklist_child_on['McID'] = $Pid;
					$linklist_child_on['Key1'] = in_array('Key1', $value_on)? 1:0;
					$linklist_child_on['Key2'] = in_array('Key2', $value_on)? 1:0;
					$linklist_child_on['Key3'] = in_array('Key3', $value_on)? 1:0;
					$linklist_child_on['mark'] = 3;
					$linklist_child->add($linklist_child_on);
				}else{
					$linklist_child_on['wID'] = $idon;
					$linklist_child_on['McID'] = $Pid;
					$linklist_child_on['Th'] = in_array('T1', $value_on)? 1:0;
					$linklist_child_on['Tl'] = in_array('T2', $value_on)? 1:0;
					$linklist_child_on['Hh'] = in_array('T3', $value_on)? 1:0;
					$linklist_child_on['Hl'] = in_array('T4', $value_on)? 1:0;
					$linklist_child_on['Tf'] = in_array('T5', $value_on)? 1:0;
					$linklist_child_on['mark'] = 1;
					$linklist_temp_child->add($linklist_child_on);
				}
			}else{
				$linklist_temp->add(array('Pid' => $Pid , 'McID' => $value_on , 'wModeltype' => $wModeltype , 'Th0'=>$Th0,'Tl0'=>$Tl0,'Hh0'=>$Hh0, 'Hl0'=>$Hl0, 'Tf0'=>$Tf0));
			}
		}
	}
	
	/**
	 * @author qxn
	 * @param unknown $linklist 其他主设备
	 * @param unknown $linklist_child  副表
	 * @param unknown $arr 提交联动数据
	 * @param unknown $Pid 主设备id
	 * @param unknown $wModeltype 联动类型
	 */
	function  add_linklist2_linklist_child($linklist, $linklist_child, $linklist_temp_child, $arr, $Pid, $wModeltype){
		foreach ($arr as $key_on => $value_on){
			if(is_array($value_on)){
				if(substr($value_on[0], 0,3) == 'Key'){
					$idon = $linklist->add(array('McID' => $Pid , 'Pid' => $key_on , 'wModeltype' => $wModeltype));
					$linklist_child_on['wID'] = $idon;
					$linklist_child_on['McID'] = $Pid;
					$linklist_child_on['Key1'] = in_array('Key1', $value_on)? 1:0;
					$linklist_child_on['Key2'] = in_array('Key2', $value_on)? 1:0;
					$linklist_child_on['Key3'] = in_array('Key3', $value_on)? 1:0;
					$linklist_child_on['mark'] = 1;
					$linklist_child->add($linklist_child_on);
				}else{
					$idon = $linklist->add(array('McID' => $Pid , 'Pid' => $key_on , 'wModeltype' => $wModeltype));
					$linklist_child_on['wID'] = $idon;
					$linklist_child_on['McID'] = $Pid;
					$linklist_child_on['Th'] = in_array('T1', $value_on)? 1:0;
					$linklist_child_on['Tl'] = in_array('T2', $value_on)? 1:0;
					$linklist_child_on['Hh'] = in_array('T3', $value_on)? 1:0;
					$linklist_child_on['Hl'] = in_array('T4', $value_on)? 1:0;
					$linklist_child_on['Tf'] = in_array('T5', $value_on)? 1:0;
					$linklist_child_on['mark'] = 3;
					$linklist_temp_child->add($linklist_child_on);
				}
			}else{
				$linklist->add(array('McID' => $Pid , 'Pid' => $value_on , 'wModeltype' => $wModeltype));
			}
		}
	}
	
	/**
	 * @author qxn
	 * 处理模式开关按键和温湿度按钮
	 * @param unknown $modeltype
	 * @param unknown $modeltype_child
	 * @param unknown $arr
	 * @param unknown $Pid
	 * @param unknown $Type
	 */
	function Do_modeltype_child($modeltype, $modeltype_child, $modeltype_temp, $arr, $Pid, $Type){
		foreach ($arr as $key => $value){
			if(is_array($value)){
				if(substr($value[0], 0,3) == 'Key'){
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
					$idon = $modeltype->add(array('wUseID' => session('wUseID'), 'wModel'=>$Pid, 'McID' => $key, 'wType' => $Type));
					$modeltype_temp_list['tid'] = $idon;
					$modeltype_temp_list['wUseID'] = session('wUseID');
					$modeltype_temp_list['wModel'] = $Pid;
					$modeltype_temp_list['McID'] = $key;
					$modeltype_temp_list['Th'] = in_array('T1', $value)? 1:0;
					$modeltype_temp_list['Tl'] = in_array('T2', $value)? 1:0;
					$modeltype_temp_list['Hh'] = in_array('T3', $value)? 1:0;
					$modeltype_temp_list['Hl'] = in_array('T4', $value)? 1:0;
					$modeltype_temp_list['Tf'] = in_array('T5', $value)? 1:0;
					$modeltype_temp->add($modeltype_temp_list);
				}
			}else{
				$modeltype->add(array('wUseID' => session('wUseID'), 'wModel'=>$Pid, 'McID' => $value, 'wType' => $Type));
			}
		}
	}
	
	/**
	 * @author qx
	 * 处理时间开关按键、温湿度
	 * @param unknown $timeaction
	 * @param unknown $timeacion_child
	 * @param unknown $arr
	 * @param unknown $Pid
	 */
	function Do_Timeaction_child($timeaction, $timeacion_child, $timeaction_temp, $arr, $Pid){
		foreach ($arr as $key => $value){
			if(is_array($value)){
				if(substr($value[0], 0,3) == 'Key'){
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
					$id = $timeaction->add(array('wUseID' => session('wUseID'), 'wModel' => $Pid, 'McID' => $key));
					$timeaction_temp_list['tid'] = $id;
					$timeaction_temp_list['wUseID'] = session('wUseID');
					$timeaction_temp_list['wModel'] = $Pid;
					$timeaction_temp_list['McID'] = $key;
					$timeaction_temp_list['Th'] = in_array('T1', $value)? 1:0;
					$timeaction_temp_list['Tl'] = in_array('T2', $value)? 1:0;
					$timeaction_temp_list['Hh'] = in_array('T3', $value)? 1:0;
					$timeaction_temp_list['Hl'] = in_array('T4', $value)? 1:0;
					$timeaction_temp_list['Tf'] = in_array('T5', $value)? 1:0;
					$timeaction_temp->add($timeaction_temp_list);
				}
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