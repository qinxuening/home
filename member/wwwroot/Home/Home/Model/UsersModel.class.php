<?php
namespace Home\Model;
use Think\Model;
class UsersModel extends Model{
	protected $_validate = array(
			array('wMB','require','{%Cmobile_n}'),
			//array('wMB','/^[1-9]\d{4,15}$/','{%S_mobile_g}'),
			array('wName','require','{%Cname_n}'),
			array('wUseID','require','{%Cuser_n}'),
			array('wPassWord','require','{%S_pass_n}'),
			array('pwd','wPassWord','{%S_pass_c}', 0,'confirm'),
	);	
	
	//自动完成
	protected $_auto=array(
			array('wPassWord','md5',1,'function'),
	);
	
}