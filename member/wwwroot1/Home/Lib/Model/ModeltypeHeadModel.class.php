<?php
class ModeltypeHeadModel extends RelationModel{
	
	//自动验证
	protected $_validate=array(
		array('wName','require','模式名称不能为空'),
		array('wType', 'require','请选择加入模式！'),
	);
	
	//一对多关联模型
	protected $_link = array(
			'modeltype'=>array(
					'mapping_type'=>HAS_MANY,//一对一
					'class_name'=>'modeltype',
					'foreign_key'=>'wModel',
			),
	);
	public function modelete($pid) {
		$map['Pid'] = $pid;
		return $result = $this->where($map)->delete();
	}
	
	function CheckwType($wType){
		$arr = array(0,1);
		return in_array($wType, $arr);
	}
}
?>