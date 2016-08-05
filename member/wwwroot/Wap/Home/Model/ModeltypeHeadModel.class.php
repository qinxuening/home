<?php
namespace Home\Model;
use Think\Model\RelationModel;
class ModeltypeHeadModel extends RelationModel{
	//自动验证
	protected $_validate=array(
			array('wName','require','{%Model_n}'),
	);
	
	//一对多关联模型
	protected $_link = array(
			'modeltype'=>array(
					'mapping_type'=>self::HAS_MANY,//一对多
					'class_name'=>'modeltype',
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
