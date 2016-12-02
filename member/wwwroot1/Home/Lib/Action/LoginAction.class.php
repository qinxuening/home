<?php
class LoginAction extends Action{
	public function _initialize(){
		$this->assign('langue',L('langue'));
	}
	public function index(){
		if(!session('?wUseID')){
			 $serverlist = M('serverlist')->where("istrue='1'")->order('pid ASC')->select();
			 $this->assign('serverlist',$serverlist);
			 $intllist = M('intl')->order('pid ASC')->select();
			 $this->assign('intllist',$intllist); 
			 $this->assign('langue',L('langue'));
			 $this->display();
		}else{
			 $url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
			 header("Location:$url");
		}
	}
	
	public function regcheck(){
		$mob=rsa_decrypt(convert($_POST['wMB']), C('private'), C('modulus'), C('keylength'));//手机号码
		$uname=rsa_decrypt(convert($_POST['wUseID']), C('private'), C('modulus'), C('keylength'));//获取用户名
		if(!$uname) {
			$this->error(L('Cuser_n'));
		}
		if(mb_strlen($uname)<3||mb_strlen($uname)>20){
			$this->error(L('Cuser_e'));
		}
		if($_POST['code']!=''){
	    if(session('vercode')==$_POST['code']){
			$User=D("Users");
			$map['wUseID']=array('eq',$uname);
			$datas=$User->where($map)->find();
			if(!$datas){
				$mapmob['wMB']=array('eq',$mob);
				$datamob=$User->where($mapmob)->find();
			if (!$datamob){
				if($User->create()){
					//自动识别提交字段与数据库对比
					$User->serverID = 1;
		            $User->wUseID = $uname;
		            $wName = rsa_decrypt(convert($_POST['wName']), C('private'), C('modulus'), C('keylength'));
					$User->wName = $wName;
					$User->wMB= $mob;
		            $User->add();
		            
					$DefaultModel[] = array('wUseID'=>$uname,'wName'=>L('Security_Mode'), 'wType'=>1);
					$DefaultModel[] = array('wUseID'=>$uname,'wName'=>L('Sleeping_Mode'), 'wType'=>0);
					$DefaultModel[] = array('wUseID'=>$uname,'wName'=>L('Entertainment'), 'wType'=>1);
					$DefaultModel[] = array('wUseID'=>$uname,'wName'=>L('Home_Mode'), 'wType'=>1);
					$DefaultModel[] = array('wUseID'=>$uname,'wName'=>L('Napping_Mode'), 'wType'=>0);
					$DefaultModel[] = array('wUseID'=>$uname,'wName'=>L('Away_Home'), 'wType'=>0);
					$DefaultModel[] = array('wUseID'=>$uname,'wName'=>L('Awake_Mode'), 'wType'=>1);
					D('modeltype_head')->addAll($DefaultModel);
								
					session('wUseID',$uname);
					//更新session_id
					$map['wUseID']=array('eq',$uname);
					$data=$User->where($map)->find();
					session('pid',$data['pid']);
					session('wMB',$data['wMB']);
					session('vercode',null);
					//header("Location:".__APP__."/User/");
					$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
					header("Location:$url");
				}else{
					$this->error($User->getError());
				}
			}else
				{
				$this->error(L('S_mobile_r'));////'手机已经被注册了'
				}
			}else
				{
				$this->error(L('S_user_r'));  //'验证码错误'
				}
		}else{
	  		  $this->error(L('S_code_n'));////'验证码错误'
	   }
	}else
	{
		$this->error(L('S_code_n'));   //'验证码不能为空'
	}
}
	
	public function mob(){
        if ($_POST['mobile']!=''){
		session('vercode',null);
		$vercode=mt_rand(100000,999999);
		session('vercode',$vercode);	
		if ($_POST['intl'] == '86'){
			//$SendMSG=L('RedSMS').$vercode.L('NotReveal');
			$SendMSG='尊敬的用户，您正在注册o-home管理系统，验证码为：'.$vercode.'，请勿向任何人提供收到的验证码。';
			$smsok=smsto($_POST['mobile'],$SendMSG);	
		}else{
			//$SendMSG="Dear user, thank you for using Loyalty Intelligent system, the verification code is:".$vercode.",please do not disclose to others【Loyalty Technology】.";
			$SendMSG="Dear user,you're now registering the O-home Management System,the verification code is ".$vercode.",please don't provide the code to anyone else!";
			$smsok=intlsmsto($_POST['intl'].$_POST['mobile'],$SendMSG,$vercode); 
		}
			
		$msg='ok';
		$this->assign('msg',$msg);
		$this->display();
		}else{
			$msg='error';
			$this->assign('msg',$msg);
		    $this->display();
		} 
	}
	
	
	
	public function logincheck(){
		if($_POST['wUseID']!=''&&$_POST['wPassWord']!=''){
		    //$encrypt = new encrypt();
			$uname=rsa_decrypt(convert($_POST['wUseID']), C('private'), C('modulus'), C('keylength'));
			$pwd=md5($_POST['wPassWord']);
			$Data=D('users');
			$condition['wUseID']=$uname;
			$condition['wPassWord']=$pwd;
			$users=$Data->where($condition)->find();
			if($users){
				//创建session
				session('wUseID',$uname);
				session('pid',$users['pid']);
				session('wMB',$users['wMB']);
				$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
				header("Location:$url");
				//$this->ajaxReturn(json_decode('{"info":"登录成功","status":"y","url":"'.$url.'"}'));
				//echo ;			
			}else{
				$this->error(L('S_user_pw_e'));
				//$RongMsg = L("S_user_pw_e");
				//$this->ajaxReturn(json_decode('{"info":"'.$RongMsg.'","status":"n"}'));
			}
		}else{
			$this->error(L('S_user_pw_n'));
			//$RongMsg = L("S_user_pw_n");
			//$this ->ajaxReturn(json_decode('{"info":"'.$RongMsg.'","status":"n"}'));
			}
		
	}
	
	public function out(){
		session(null);
		header("Location:".__APP__."/Index/");
	}
	
	//ajax验证用户是否已经注册过
	public function ckuser(){
		$User=D("Users");
		$map['wUseID']=array('eq',$_POST["param"]);
		$data=$User->where($map)->find();
		if(!$data){
			echo '{"status":"y"}';
		}else{
			echo L('S_user_r');
		}
	}
	
	//ajax mobile 验证手机号码是否被注册
	public function ckmob(){
		$User=M("Users");
		$mapmob['wMB']=array('eq',$_POST["param"]);
		$data=$User->where($mapmob)->find();
		if(!$data){
			echo '{"status":"y"}';
		}else{
			echo L('S_mobile_r');//'S_mobile_r' => '手机号码已注册',
		}
	}
	
}


?>