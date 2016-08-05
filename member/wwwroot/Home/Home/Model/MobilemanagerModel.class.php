<?php
namespace Home\Model;
use Think\Model;
class MobilemanagerModel extends Model{
	protected $_validate = array(
			array('wMB','require','{%Cmobile_n}'),
			array('wMB','/^[1-9]\d{4,15}$/','{%S_mobile_g}'),
			array('wName','require','{%Cname_n}'),
	);
	
	public function CheckPid($Pid){
		$ListPid = $this->where(array('wUseID' => session('wUseID')))->field('Pid')->select();
		$ListPidO = TarrayToOarray($ListPid, 'Pid');
		if(in_array($Pid, $ListPidO)){
			return true;
		}else{
			return false;
		}
	}
	
	public function Pid_TouchID_merge_array($arr){
		$list = $this->field('Pid')->where(array('left(`McID`,2)' => 14 ,wUseID => session('wUseID')))->select();
		$list = TarrayToOarray($list , 'Pid');
		foreach ($arr as $k => $v){
			if(in_array($v['Pid'], $list)){
				$arra[$v['Pid']] = $v['StouchID'];
			}
		}
		if(empty($arra)){
			foreach ($list as $key => $value){
				$array[$value] = array('0');
			}
			return $array;
		}
		foreach ($list as $key => $value){
			foreach ($arra as $ke => $va){
				if(!$arra[$value]){
					$array[$value] = array('0');
				}else{
					if($ke == $value) $array[$value] = explode(',' , $va);
				}
			}
		}
		return $array;

	}
}