<?php
// 本类由系统自动生成，仅供测试用途
class LostpasswordAction extends Action {

  public function index(){	
		$this->display();
	}	
	//手机验证码
	public function mobile(){

	if(!isset($_GET['l'])){
		$wUseID=$this->_param('wUseID');
		if($wUseID){
			session('passID',$wUseID);
			if(session('passID')!=''){
				//$this->assign('wMB',session('passID'));
				$User=M("Users");
				$map['wUseID']=array('eq',session('passID'));
				$mdata=$User->where($map)->find();
				if($mdata){
					//echo mobile($mdata['wMB']);exit;
					$this->assign('wMB',mobile($mdata['wMB']));//手机号码星号处理
					session('passwMB',$mdata['wMB']);
					session('intl',$mdata['intl']); //存储区号
					//header("Location:".__APP__."/Lostpassword/mobile/wUseID/laicheng/");
					$this->display();
				}else{
					$this->error(L('S_member_n'));                      //'会员不存在'               
				}
			
			}else{
				//header("Location:".__APP__."/Lostpassword/");
				$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Lostpassword/';
				header("Location:$url");
			}
		}else{
			$this->error(L('S_parameter_e'));                          ////////////////'参数错误'
		}	
	}else{
		$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/mobile/';
		header("Location:$url");
		//header("Location:".__APP__."/Lostpassword/mobile/");
	}
	}
  
	//发送验证码
  public function mob(){
        if ($_POST['mobile']!=''&&session('passwMB')!=''){
		$intl=session('intl');//获取区号
		$Passcode=M("mobilevercode");
	    $map['mb']=array('eq',session('passwMB'));//手机号
	    $mdata=$Passcode->where($map)->find();
		if(!$mdata){
			$data["vercode"]=mt_rand(100000,999999);
			$data["cdatetime"]=date('Y-m-d H:i:s',time()+10);
			$data["mb"] = session('passwMB');
			$Passcode->data($data)->add();
			if ($intl == '86'){
				//$SendMSG = L('FindSMS').$data["vercode"].L('NotReveal2');
				//$SendMSG = iconv("UTF-8","",$SendMSG);
				$SendMSG='尊敬的用户，您正在进行找回密码操作， 验证码：'.$data["vercode"].'， 请勿向任何人提供收到的验证码。';
				$smsok=smsto(session('passwMB'),$SendMSG);		
			}else{
				$SendMSG="Dear user,you're now  in the process of retrieving your password,verification code: ".$data["vercode"].",please don't provide the code to anyone else!";
				$smsok=intlsmsto($_POST['intl'].session('passwMB'),$SendMSG,$data["vercode"]);
			}
			
		}else{
			if(strtotime($mdata["cdatetime"])+50<time()){
			//限制时间
			$data["vercode"]=mt_rand(100000,999999);
			$data["cdatetime"]=date('Y-m-d H:i:s',time()+10);
			$data["mb"]=session('passwMB');
			$mapt['mb']=array('eq',$mdata['mb']);//手机号
			$Passcode->where($mapt)->save($data);
			if ($intl == '86'){
				//$SendMSG = L('FindSMS').$data["vercode"].L('NotReveal2');
				//$SendMSG = iconv("UTF-8","",$SendMSG);
				$SendMSG='尊敬的用户，您正在进行找回密码操作， 验证码：'.$data["vercode"].'， 请勿向任何人提供收到的验证码。';
				$smsok=smsto(session('passwMB'),$SendMSG);
			
			}else{
				$SendMSG="Dear user,you're now  in the process of retrieving your password,verification code: ".$data["vercode"].",please don't provide the code to anyone else!";
				$smsok=intlsmsto($_POST['intl'].session('passwMB'),$SendMSG,$data["vercode"]);
			}		
			}	
		}
		$msg='ok';
		$this->assign('msg',$msg);
		$this->display();
		}else{
			//header("Location:".__APP__."/Lostpassword/");
			$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Lostpassword/';
			header("Location:$url");
		} 
}
	
	//判断验证码
	public function Password(){
	   if ($_POST['authCode']!=''&&session('passwMB')!=''&&session('passID')!=''){
		   $Passcode=M("mobilevercode");
		   $map['mb']=array('eq',session('passwMB'));
		   $map['vercode']=array('eq',$_POST['authCode']);
		   $mdata=$Passcode->where($map)->find();
	   if($mdata){
			$this->display();
	   }else{
			$this->error(L('S_code_e'));                     //'验证码错误'
	   }
	   }else{
			$this->error(L('S_parameter_e'), '__APP__/');          //'参数错误'
	  } 
	}
 	
	public function Complete(){
		if ($_POST['wPassWord']!='' && $_POST['pwd']!='' && session('passID')!=''){
			if($_POST['wPassWord']!=$_POST['pwd']){
					$this->error(L('S_pass_c'));              //'两次密码输入不一致'
			}else{
				$Users=M("Users");
				$map['wUseID']=array('eq',session('passID'));
				
				$save=$Users->where($map)->setField('wPassWord',md5($_POST['wPassWord']));
				
				if($save){
					$Passcode=M("mobilevercode");
					$data["mb"]=session('passwMB');
					$data["vercode"]=mt_rand(100000,999999);
					$Passcode->where($map)->save($data);
					session(null);
					$this->display();
				}else{
					//输入相同的密码也提示成功
					//$this->display();
					$url = 'http://'.$_SERVER['HTTP_HOST'];
					header("Location:$url");
				}
			}
		}else{
			$this->error(L('S_parameter_e'), '__APP__/');         //'参数错误'
		}
	
	} 
 
	//ajaxurl name
	public function CheckMobile() {
		$User=M("Users");
		$map['wUseID']=array('eq',$_POST["param"]);
		$mdata=$User->where($map)->find();
		if($mdata){
			echo '{"status":"y"}';
		} else {
			echo L('Y_user_ex');
		}
	}
 	
}
?>