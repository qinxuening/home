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
}