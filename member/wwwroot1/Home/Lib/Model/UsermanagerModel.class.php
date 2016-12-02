<?php
class UsermanagerModel extends Model{
	
	//自动验证
	protected $_validate=array(
		array('familyname','require','成员不能为空',0,self::MODEL_INSERT),
		//array('familyid','require','识别ID不能为空'),
		array('familyid', '/[a-zA-Z0-9]+/i','识别ID不能为空或含特殊字符',0,self::MODEL_INSERT),
	);
	
}
?>