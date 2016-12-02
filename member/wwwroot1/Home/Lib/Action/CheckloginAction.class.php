<?php
class CheckloginAction extends Action{
public function index(){
		 $wUseID = $_POST['wUseID'];
		 $wPassWord = $_POST['wPassWord'];
		if($wUseID!=''&&$wPassWord!=''){
		    //$encrypt = new encrypt();
			$uname=$wUseID;
			$pwd=md5($wPassWord);
			$Data=D('users');
			$condition['wUseID']=$uname;
			$condition['wPassWord']=$pwd;
			$users=$Data->where($condition)->find();
			if($users){
			//$sdata='{"users":[{"wUseID":"'.$users['wUseID'].'","wName":"'.$users['wName'].'","wMB":"'.$users['wMB'].'"}]}';
			//$sdata='{"ret": 0,"errcode": 0,"msg": "登陆成功","data": {"wUseID": "'.$users['wUseID'].'","wName": "'.$users['wName'].'","wMB": "'.$users['wMB'].'","serverID": '.$users['serverID'].'}}';
		     $sdata = '{"ret": 0,"errcode": 0,"msg": "登陆成功","data": {"wUseID": "'.$users['wUseID'].'","wName": "'.$users['wName'].'","wMB": "'.$users['wMB'].'","serverID": '.$users['serverID'].'}}';
				$sdata = trim($sdata);
				$this->assign("sdata",$sdata);
				$this->display();
				
			}else{
				//$sdata='{"ret": 1,"errcode": 0,"msg": "用户密码错误","data":""}';
				$sdata = '{"ret": 1,"errcode": 0,"msg": "用户名密码错误","data": {"wUseID": "","wName": "","wMB": "","serverID": 0}}';
				$sdata = trim($sdata);
				$this->assign("sdata",$sdata);
				$this->display();
			}
		}else{
			//$sdata='{"ret": 1,"errcode": 0,"msg": "用户密码不能为空","data":""}';
			$sdata = '{"ret": 2,"errcode": 0,"msg": "用户密码不能为空","data": {"wUseID": "","wName": "","wMB": "","serverID": 0}}';
			$sdata = trim($sdata);
				$this->assign("sdata",$sdata);
				$this->display();
		}
	}
	
	
}


?>