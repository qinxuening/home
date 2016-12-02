<?php
class UsersModel extends Model{
	
	//自动验证
	protected $_validate=array(
		array('wUseID','require','用户名不能为空'),
		array('wUseID','','用户名已经存在！',0,'unique',1),
		array('wPassWord','require','密码不能为空'),
		array('pwd','wPassWord','两次输入密码不一致',0,'confirm'),
		//array('wMB','require','手机不能为空',self::MODEL_UPDATE),
		array('wMB','','用户名已经存在！',0,'unique',1),
	);
	
	//自动完成
	protected $_auto=array(
		array('wPassWord','md5',1,'function'),
		//array('regtime','time',1,'function'),
		//array('referid','getReferID',1,'callback'),
		//array('logintime','time',1,'function'),
	);
	
	public function CheckwMB($mobile){
		$pattern = '/^1\d{4,14}$/';
		if (!mb_strlen($mobile)) {
			return '手机号码不能为空';
		}
		if(!preg_match($pattern, $mobile)) {
			return '手机号码格式不正确';
		}
	}
	
	
}


?>