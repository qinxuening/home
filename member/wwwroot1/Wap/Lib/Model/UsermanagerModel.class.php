<?php
class UsersModel extends Model{
	
	//自动验证
	protected $_validate=array(
		array('familyname','require','成员不能为空'),
		array('w_id','require','非法提交数据')
	);
	
}
?>