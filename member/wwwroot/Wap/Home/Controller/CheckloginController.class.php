<?php
namespace Home\Controller;
use Think\Controller;
class CheckloginController extends Controller{
	public function index(){
		$wUseID = I('wUseID');
		$wPassWord = I('wPassWord');
		if($wUseID!=''&&$wPassWord!=''){
			$Data=D('users');
			$condition['wUseID']=$wUseID;
			$condition['wPassWord']=md5($wPassWord);
			$users=$Data->where($condition)->field('wUseID, wName, wMB, serverID')->find();
			if($users){
				$sdata = '{"ret": 0,"errcode": 0,"msg": "登陆成功","data": {"wUseID": "'.$users['wUseID'].'","wName": "'.$users['wName'].'","wMB": "'.$users['wMB'].'","serverID": '.$users['serverID'].'}}';
				$sdata = trim($sdata);
				$this->assign("sdata",$sdata);
				$this->display();
	
			}else{
				$sdata = '{"ret": 1,"errcode": 0,"msg": "用户名密码错误","data": {"wUseID": "","wName": "","wMB": "","serverID": 0}}';
				$sdata = trim($sdata);
				$this->assign("sdata",$sdata);
				$this->display();
			}
		}else{
			$sdata = '{"ret": 2,"errcode": 0,"msg": "用户密码不能为空","data": {"wUseID": "","wName": "","wMB": "","serverID": 0}}';
			$sdata = trim($sdata);
			$this->assign("sdata",$sdata);
			$this->display();
		}
	}
}