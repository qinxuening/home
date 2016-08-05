<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller{
	protected $users;
	protected $modeltypehead;
	
	public function _initialize(){
		$this->users = D('Users');
		$this->modeltypehead = M('Modeltype_head');
		$this->assign('langue',L('langue'));
	}
	public function index(){
		if(!session('?wUseID')){
			$serverlist = M('serverlist')->where("istrue='1'")->order('pid ASC')->select();
			$intllist = M('intl')->order('pid ASC')->select();
			$this->assign('serverlist',$serverlist);
			$this->assign('intllist',$intllist);
			$this->display();
		}else{
			$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
			header("Location:$url");
		}
	}
	
	function _empty(){
		header("HTTP/1.0 404 Not Found");
		$this->display("Public:404");
	}
	
	public function tk(){
		$this->display();
	}
	
	public function regcheck(){
		$mob=rsa_decrypt(convert(I('post.wMB')), C('private'), C('modulus'), C('keylength'));
		$uname=rsa_decrypt(convert(I('post.wUseID')), C('private'), C('modulus'), C('keylength'));
		if(CheckLength($uname, 3, 20)) {$this->error(L('Cuser_e'));}
		if(CheckNumber($mob)) {$this->error(L('S_mobile_g'));}
		if(I('post.code') !=''){
			if(session('vercode') == I('post.code')){
				$datas=$this->users->where(array('wUseID' => $uname))->field('wUseID')->find();
				if(!$datas){
					$datamob=$this->users->where(array('wMB' => $mob))->find();
					if (!$datamob){
						if($this->users->create()){
							$this->users->serverID = 1;
							$this->users->wUseID = $uname;
							$wName = rsa_decrypt(convert(I('post.wName')), C('private'), C('modulus'), C('keylength'));
							$this->users->wName = $wName;
							$this->users->wMB= $mob;
							$Pid = $this->users->add();

							$DefaultModel[] = array('wUseID'=>$uname,'wName'=>L('Security_Mode'), 'wType'=>1);
							$DefaultModel[] = array('wUseID'=>$uname,'wName'=>L('Sleeping_Mode'), 'wType'=>0);
							$DefaultModel[] = array('wUseID'=>$uname,'wName'=>L('Entertainment'), 'wType'=>1);
							$DefaultModel[] = array('wUseID'=>$uname,'wName'=>L('Home_Mode'), 'wType'=>1);
							$DefaultModel[] = array('wUseID'=>$uname,'wName'=>L('Napping_Mode'), 'wType'=>0);
							$DefaultModel[] = array('wUseID'=>$uname,'wName'=>L('Away_Home'), 'wType'=>0);
							$DefaultModel[] = array('wUseID'=>$uname,'wName'=>L('Awake_Mode'), 'wType'=>1);
							$this->modeltypehead->addAll($DefaultModel);
	
							session('wUseID',$uname);
							session('pid', $Pid);
							session('wMB', $mob);
							session('vercode', null);
							$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
							header("Location:$url");
						}else{
							$this->error($this->users->getError());
						}
					}else{
						$this->error(L('S_mobile_r'));
					}
				}else{
					$this->error(L('S_user_r'));
				}
			}else{
				$this->error(L('S_code_e'));
			}
		}else{
			$this->error(L('S_code_n'));
		}
	}
	
	public function mob(){
		if (I('mobile') !=''){
			session('vercode',null);
			$vercode = mt_rand(100000,999999);
			session('vercode',$vercode);
			if (I('intl') == 86){	
				$SendMSG='尊敬的用户，您正在注册o-home管理系统，验证码为：'.$vercode.'，请勿向任何人提供收到的验证码。';
				$smsok=smsto(I('mobile'),$SendMSG);
			}else{
				$SendMSG="Dear user,you're now registering the O-home Management System,the verification code is ".$vercode.",please don't provide the code to anyone else!";
				$smsok=intlsmsto(I('intl').I('mobile'),$SendMSG,$vercode);
			}	
			$this->assign('msg',$smsok);
			$this->display();
		}else{
			$msg = 'error';
			$this->assign('msg',$msg);
			$this->display();
		}
	}
	
	public function logincheck(){
		if(I('post.wUseID') !='' && I('post.wPassWord') !=''){
			$uname = rsa_decrypt(convert(I('post.wUseID')), C('private'), C('modulus'), C('keylength'));
			$users = $this->users->where(array('wUseID' => $uname, 'wPassWord' => md5(I('wPassWord'))))->field('wMB, pid')->find();
			if($users){
				session('wMB',$users['wMB']);
				session('wUseID',$uname);
				session('pid',$users['pid']);
				$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
				header("Location:$url");
			}else{
				$this->error(L('S_user_pw_e'));;
			}
		}else{
			$this->error(L('S_user_pw_n'));
		}
	}
	
	public function ckuser(){
		$data = $this->users->where(array('wUseID' => I('param')))->field('wUseID')->find();
		if(!$data){
			echo '{"status":"y"}';
		}else{
			echo L('S_user_r');
		}
	}
	
	public function ckmob(){
		$data = M("Users")->where(array('wMB' => I('param')))->field('wMB')->find();
		if(!$data){
			echo '{"status":"y"}';
		}else{
			echo L('S_mobile_r');
		}
	}

	public function out(){
		session(null);
		header("Location:".__APP__."/Index/");
	}	
}
