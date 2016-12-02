<?php
class LoginAction extends Action{

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
		$uname=rsa_decrypt(convert($_POST['wUseID']), C('private'), C('modulus'), C('keylength'));
		$mob = rsa_decrypt(convert($_POST['wMB']), C('private'), C('modulus'), C('keylength'));
		if(!$uname) {
			$this->error(L('Cuser_n'));
		}
		if(mb_strlen($uname)<3||mb_strlen($uname)>20){
			$this->error(L('Cuser_e'));
		}
		if($_POST['code']!=''){	
			if(session('vercode')==$_POST['code']){		
				$User=D("Users");
				//$encrypt = new encrypt();
				$map['wUseID']=array('eq',$uname);
				$datas=$User->where($map)->find();
				
				if(!$datas){
					$mapmob['wMB']=array('eq',$mob);
					$datamob=$User->where($mapmob)->find();
					if(!$datamob){
						
						if($User->create()){
							
							//import('ORG.Util.Rsa');
							$User->serverID =1;                     //服务器ID  $_POST['serverID']
							$User->wUseID = $uname;                                   //用户名
							$User->wName = rsa_decrypt(convert($_POST['wName']), C('private'), C('modulus'), C('keylength')); //真实姓名
							$User->wMB= $mob;          //手机号				
							$User->add();	
							
							$DefaultModel[] = array('wUseID'=>$uname,'wName'=>L('Security_Mode'), 'wType'=>1);
							$DefaultModel[] = array('wUseID'=>$uname,'wName'=>L('Sleeping_Mode'), 'wType'=>0);
							$DefaultModel[] = array('wUseID'=>$uname,'wName'=>L('Entertainment'), 'wType'=>1);
							$DefaultModel[] = array('wUseID'=>$uname,'wName'=>L('Home_Mode'), 'wType'=>1);
							$DefaultModel[] = array('wUseID'=>$uname,'wName'=>L('Napping_Mode'), 'wType'=>0);
							$DefaultModel[] = array('wUseID'=>$uname,'wName'=>L('Away_Home'), 'wType'=>0);
							$DefaultModel[] = array('wUseID'=>$uname,'wName'=>L('Awake_Mode'), 'wType'=>1);
							D('modeltype_head')->addAll($DefaultModel);
							
							session('wUseID',$uname);           //存入session用户名
							//更新session_id
							$map['wUseID']=array('eq',$uname);
							$data=$User->where($map)->find();
							session('pid',$data['pid']);
							session('vercode',null);
							header("Location:".__APP__."/User/");
						
						}else{
							$this->error($User->getError());
						}
					
					}else{
						$this->error(L('S_mobile_r'));  //'手机已经被注册了'
					}
				}else{
					$this->error(L('S_user_r'));   //'用户被注册了'
				}
				
			}else{
				$this->error(L('S_code_e'));  //'验证码错误'
			}
			
		
		}else{
			$this->error(L('S_code_n'));   //'验证码不能为空'
		}
	}	
	public function applogin(){
		$wUseID = remove_xss(I('wUseID'));
		$wPassWord = remove_xss(I('wPassWord'));
		if(session('wUseID') != $wUseID){
			session(null);
			if($wUseID != '' && $wPassWord != ''){
				$uname = $wUseID;
				$pwd = md5($wPassWord);			
				$Data = D('users');
				$condition['wUseID'] = $uname;
				$condition['wPassWord'] = $pwd;
				$users = $Data->field('pid,wUseID')->where($condition)->find();
				if($users){
					session('wUseID',$uname);
					session('pid',$users['pid']);
					$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
					header("Location:$url");
				}else{
					$this->error(L('S_user_pw_e'));   //"用户名或密码错误"
					header("Location:".__APP__."/Index/");
				}
			}else{
				$this->error(L('S_user_pw_n'));      //'用户名或密码不能为空'
				header("Location:".__APP__."/Index/");
			}
		}else{
			$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
			header("Location:$url");
		}
		
	}
	
	//ajax yhm
	public function ckuser(){
		$User=D("Users");
		//$encrypt = new encrypt();
		//$uname=rsa_decrypt(convert($_POST['wUseID']), C('private'), C('modulus'), C('keylength'));
		$map['wUseID']=array('eq',$_POST["param"]);
		$data=$User->where($map)->find();
		
		if(!$data){
			echo 'y';
		}else{
			echo L('S_user_r');
		}
	}
	
	//ajax yzm
	public function ckvercode(){
		if(session('vercode') == $_POST["param"]){
			echo 'y';
		}else{
			echo L('S_code_e');
		}	
	}
	
	//ajax mobile
	public function ckmob(){
		
		$User=D("Users");
		$mapmob['wMB']=array('eq',$_POST["param"]);
		$data=$User->where($mapmob)->find();	
		if(!$data){
			echo 'y';
		}else{
			echo L('S_mobile_r');//'S_mobile_r' => '手机号码已注册',
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
				$smsok=smsto($_POST['mobile'],$SendMSG,$vercode);
				
			}else{
				$SendMSG="Dear user,you're now registering the O-home Management System,the verification code is ".$vercode.",please don't provide the code to anyone else!";
			    $smsok=intlsmsto($_POST['intl'].$_POST['mobile'],$SendMSG,$vercode); 
			}
		}else{
			$msg='error';
			$this->assign('msg',$msg);
		    $this->display();
		} 
	}
	
	
	public function tk(){
		$this->display();
	}
	
	
	public function logincheck(){
		
		if($_POST['wUseID']!='' && $_POST['wPassWord']!=''){
						
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
				$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
				header("Location:$url");
				//$this->ajaxReturn(json_decode('{"info":"登录成功","status":"y","url":"'.$url.'"}'));
				
			}else{
				$this->error(L('S_user_pw_e'));      //"用户名或密码错误"
				//$RongMsg = L("S_user_pw_e");
				//$this->ajaxReturn(json_decode('{"info":"'.$RongMsg.'","status":"n"}'));
			}
			
		}else{
			$this->error(L('S_user_pw_n'));         //'用户名或密码不能为空'
		}
	}
	
	
	public function login(){
		
		if($_POST['wUseID']!='' && $_POST['wPassWord']!=''){
			if(!isset($_COOKIE['user_id'])){
				
				 setcookie('user_id',$row['user_id']);
                 setcookie('username',$row['username']);				
			}else{

			}
			
		}else{
			$this->error(L('S_user_pw_n'));	   //'用户名或密码不能为空'
		}	
	}
	
	public function out(){
		session(null);
		$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/';
		header("Location:$url");
	}
	
}
?>