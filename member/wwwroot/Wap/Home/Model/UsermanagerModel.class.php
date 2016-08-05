<?php
namespace Home\Model;
use Think\Model;
class UsermanagerModel extends Model{
	protected $_validate = array(
			array('familyname','require','{%Member_name_n}'),
			array('familyid','require','{%Identification_id_n}'),
			array('wName','/^0?[1-99]{1,2}$/','{%Member_id_e}'),
	);
	
	public function CheckPid($Pid){
		$ListPid = $this->where(array('wUseID' => session('wUseID')))->field('pid')->select();
		$ListPidO = TarrayToOarray($ListPid, 'pid');
		if(in_array($Pid, $ListPidO)){
			return true;
		}else{
			return false;
		}
	}
}