<?php
class MobilemanagerModel extends RelationModel{
	protected $_validate = array(
			array('McName','require','{%Equipment_position_n}'),
	);	
	
	//一对多关联模型
	protected $_link = array(
			'Modeltype'=>array(
					'mapping_type'=>HAS_MANY,//一对一
					'class_name'=>'Modeltype',
					//'foreign_key'=>'McID',
					//'relation_foreign_key'=>'McID',
					//'is_key' => true ,
					'condition' =>'1',
			),
	);
}