<?php
class LoginAction extends Action{

	public function index(){
		
		if(!session('?wUseID')){
			$serverlist = M('serverlist')->where("istrue='1'")->order('pid ASC')->select();
		 	$this->assign('serverlist',$serverlist); 
		 	$intllist = M('intl')->order('pid ASC')->select();
			//L('langue');
			//echo C('LANG_SWITCH_ON');
			//print_r($intllist);//exit;
			$this->assign('intllist',$intllist);
			$this->assign('langue',L('langue'));
			$this->display();
		}else{
			header("Location:".__APP__."/User/");
		}
	}
	
	public function regcheck(){
		
		//echo $_POST['intl'];exit;
		
		if($_POST['code']!=''){
			
			
			$mob = rsa_decrypt(convert($_POST['wMB']), C('private'), C('modulus'), C('keylength'));
			//$Passcode=M("mobilevercode");
			//$map2['mb']=array('eq',$mob);
			//$map2['vercode']=array('eq',$_POST['code']);
			//$mdata=$Passcode->where($map2)->find();
			if(session('vercode')==$_POST['code']){
					
				$User=D("Users");
				//$encrypt = new encrypt();
				$uname=rsa_decrypt(convert($_POST['wUseID']), C('private'), C('modulus'), C('keylength'));
				$map['wUseID']=array('eq',$uname);
				$datas=$User->where($map)->find();
				
				if(!$datas){
					$mapmob['wMB']=array('eq',$mob);
					$datamob=$User->where($mapmob)->find();
					if(!$datamob){
						
						if($User->create()){
							
							//import('ORG.Util.Rsa');
							$User->serverID = $_POST['serverID'];                     //服务器ID
							$User->wUseID = $uname;                                   //用户名
							$User->wName = rsa_decrypt(convert($_POST['wName']), C('private'), C('modulus'), C('keylength')); //真实姓名
							$User->wMB= $mob;          //手机号
							
							$User->add();
							
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
		if(!session('?wUseID')){
			if($_GET['wUseID']!='' && $_GET['wPassWord']!=''){
			
				$uname= $_GET['wUseID'];
				//$pwd= $_GET['wPassWord'];
				$pwd= md5($_GET['wPassWord']);
				
				$Data=D('users');
				$condition['wUseID']=$uname;
				$condition['wPassWord']=$pwd;
				$users=$Data->where($condition)->find();
				
				if($users){
					//创建session
					session('wUseID',$uname);
					session('pid',$users['pid']);
					header("Location:".__APP__."/User/");
				}else{
					//print_r($_POST);exit;
					$this->error(L('S_user_pw_e'));   //"用户名或密码错误"
					//header("Location:".__APP__."/User/");
					header("Location:".__APP__."/Index/");
				}
			}else{
				$this->error(L('S_user_pw_n'));      //'用户名或密码不能为空'
				header("Location:".__APP__."/Index/");
			}
		}else{
			header("Location:".__APP__."/User/");
		}
		
	}
	
	
	//ajax yhm
	public function ckuser(){
		//echo 111111111;exit;
		//echo $_POST["param"]; exit;
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
		
		//echo $_POST['code'];exit;
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
			echo L('S_mobile_r');
		}
	}
	
	
	
	
	
	public function mob(){
		
		if ($_POST['mobile']!=''){
			session('vercode',null);
			$vercode=mt_rand(100000,999999);
			session('vercode',$vercode);
			
			if ($_POST['intl'] == '86'){
				$SendMSG='尊敬的用户，您正在注册o-home管理系统，验证码为：'.$vercode.'，请勿向任何人提供收到的验证码。';
				$smsok=smsto($_POST['mobile'],$SendMSG,$vercode); 
			}else{
				
				//echo $_POST['intl'];exit;
				$SendMSG= "Dear user, you're now registering the O-home Management System,the verification code is ".$vercode.",please don't provide the code to anyone else!";
				
				$smsok = intlsmsto($_POST['intl'].$_POST['mobile'],$SendMSG,$vercode);
			}
			
			//$msg='ok';
			//$this->assign('msg',$msg);
			//$this->display();
		}else{
			$msg='error';
			$this->assign('msg',$msg);
			$this->display();
		} 
	
	}
	
	
	public function tk(){
		//echo 111111111;exit;
		$this->display();
	}
	
	
	public function logincheck(){
		
		if($_POST['wUseID']!='' && $_POST['wPassWord']!=''){
			
			
		    //$encrypt = new encrypt();
			
			$uname=rsa_decrypt(convert($_POST['wUseID']), C('private'), C('modulus'), C('keylength'));
			//print_r($uname);exit;
			//ca3cd50421c24f9e8985bc73ee3a5a30
			//echo $_POST['wPassWord'];exit;
			$pwd=md5($_POST['wPassWord']);
			
			$Data=D('users');
			$condition['wUseID']=$uname;
			$condition['wPassWord']=$pwd;
			$users=$Data->where($condition)->find();
			
			//print_r($users);exit;
			if($users){
				//创建session
				session('wUseID',$uname);
				session('pid',$users['pid']);
				
				//更新用户登录时间
				//$User=M("User");
				//$User->logintime=time();
				
				//实例化ip.class.php
				//$gifo = new get_gust_info();
				//$User->loginip=$gifo->Getip();
				//$User->where('uid='.$user['uid'])->save();	
				echo 11111111111111111;
				echo error_reporting(E_ALL);
				
				header("Location:".__APP__."/User/");

				
			}else{
				//print_r($_POST);exit;
				$this->error(L('S_user_pw_e'));      //"用户名或密码错误"
				//header("Location:".__APP__."/User/");
			}
		
		
		}else{
			$this->error(L('S_user_pw_n'));         //'用户名或密码不能为空'
		}
	}
	
	
	public function login(){
		
		if($_POST['wUseID']!='' && $_POST['wPassWord']!=''){
			//print_r($_POST);exit;
			//判断用户是否已经设置cookie，如果未设置$_COOKIE['user_id']时，执行以下代码
			if(!isset($_COOKIE['user_id'])){
				
				 setcookie('user_id',$row['user_id']);
                 setcookie('username',$row['username']);
				
			}else{//如果用户已经登录，则直接跳转到已经登录页面
				//$home_url = 'loged.php';
				//header('Location: '.$home_url);
			}
			
		}else{
			$this->error(L('S_user_pw_n'));	   //'用户名或密码不能为空'
		}
		
	}
	
	
	public function out(){
		session(null);
		header("Location:".__APP__."/Index/");
	}
	
}
?>