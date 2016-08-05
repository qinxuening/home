<?php
namespace Home\Model;
use Think\Model\RelationModel;
class TimeactionHeadModel extends RelationModel{
	//自动验证
	protected $_validate=array(
			array('wName','require','时间名称不能为空!'),
			array('wTime', 'require','时间不能为空！'),
	);
	
	//关联模型
	protected $_link = array(
			'timeaction'=>array(
					'mapping_type'=>self::HAS_MANY,//一对一
					'class_name'=>'timeaction',
					'foreign_key'=>'wModel',
			),
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