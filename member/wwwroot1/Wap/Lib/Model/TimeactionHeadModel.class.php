<?php
class TimeactionHeadModel extends RelationModel{
	
	//自动验证
	protected $_validate=array(
			array('wName','require','时间名称不能为空!'),
			array('wTime', 'require','时间不能为空！'),
	);
	
	protected $_link = array(
			'timeaction'=>array(
					'mapping_type'=>HAS_MANY,//一对一
					'class_name'=>'timeaction',
					'foreign_key'=>'wModel',
			),
	);
	//Array ( [wName] => 地方 [wTues] => 1 [wTime] => 10:00 [wType] => 1 [wUseID] => qinxuening )
}