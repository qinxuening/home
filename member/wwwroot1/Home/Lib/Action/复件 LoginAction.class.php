<?php
class LoginAction extends Action{

	public function index(){
		if(!session('?wUseID')){
			$this->display();
		}else{
			header("Location:".__APP__."/User/");
		}
	}
	
	public function regcheck(){
		
		if($_POST['code']!=''){
		$mob=rsa_decrypt(convert($_POST['wMB']), C('private'), C('modulus'), C('keylength'));
		$Passcode=M("mobilevercode");
	   $map2['mb']=array('eq',$mob);
	   $map2['vercode']=array('eq',$_POST['code']);
	   $mdata=$Passcode->where($map2)->find();
	   if($mdata){
		$User=D("Users");
		//$encrypt = new encrypt();
		$uname=rsa_decrypt(convert($_POST['wUseID']), C('private'), C('modulus'), C('keylength'));
		$map['wUseID']=array('eq',$uname);
		$datas=$User->where($map)->find();
		if(!$datas){
		$mapmob['wMB']=array('eq',$mob);
		$datamob=$User->where($mapmob)->find();
		if (!$datamob){
		if($User->create()){
		    //import('ORG.Util.Rsa');
            $User->wUseID = $uname;
			$User->wName = rsa_decrypt(convert($_POST['wName']), C('private'), C('modulus'), C('keylength'));
			$User->wMB= $mob;
            $User->add();
			
			session('wUseID',$uname);
			//更新session_id
			$map['wUseID']=array('eq',$uname);
			$data=$User->where($map)->find();
			session('pid',$data['pid']);
			
			header("Location:".__APP__."/User/");
		}else{
			$this->error($User->getError());
		}
		}
		else
		{
		$this->error('手机已经被注册了');
		}
		}
		else
		{
		$this->error('用户被注册了');
		}
		}else{
	    $this->error('验证码错误');
	   }
	}else
	{
	$this->error('验证码不能为空');
	}
}
	
	public function mob(){
        if ($_POST['mobile']!=''){
		$Passcode=M("mobilevercode");
	    $map['mb']=array('eq',$_POST['mobile']);
	    $mdata=$Passcode->where($map)->find();
		if(!$mdata){
		$data["mb"]=$_POST['mobile'];
		$data["vercode"]=mt_rand(100000,999999);
		$data["cdatetime"]=date('Y-m-d H:i:s',time()+10);
		$Passcode->data($data)->add();
		$SendMSG='尊敬的用户，您正在注册o-home管理系统，【请勿向任何人提供收到的短信验证码】，验证码'.$data["vercode"];
		$smsok=smsto($_POST['mobile'],$SendMSG); 
		$msg='ok';
		$this->assign('msg',$msg);
		$this->display();
		}else{
		if(strtotime($mdata["cdatetime"])+50<time()){
		$data["vercode"]=mt_rand(100000,999999);
		$data["cdatetime"]=date('Y-m-d H:i:s',time()+10);
		$data["mb"]=$mdata["mb"];
		$Passcode->where($map)->save($data);
		$SendMSG='尊敬的用户，您正在注册o-home管理系统，【请勿向任何人提供收到的短信验证码】，验证码'.$data["vercode"];
		$smsok=smsto($_POST['mobile'],$SendMSG); 
		$msg='ok';
		$this->assign('msg',$msg);
		$this->display();
		}
		
		
		}
		
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
				
				//更新用户登录时间
				//$User=M("User");
				//$User->logintime=time();
				
				//实例化ip.class.php
				//$gifo = new get_gust_info();
				//$User->loginip=$gifo->Getip();
				//$User->where('uid='.$user['uid'])->save();
				
				header("Location:".__APP__."/User/");
				
			}else{
				$this->error("用户名或密码错误");
			}
		}else{
			$this->error('用户名或密码不能为空');
		}
	}
	
	public function out(){
		session(null);
		header("Location:".__APP__."/Index/");
	}
	
}


?>