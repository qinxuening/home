<?php
namespace Home\Controller;
class UserController extends CommonController{
	protected $usermanager;
	protected $users;
	protected $mobilemanager;
	
	public function _initialize(){
		parent::_initialize();
		$this->usermanager = D("Usermanager");	
		$this->users = D("Users");
		$this->mobilemanager = D("Mobilemanager");
		$this->assign('langue',L('langue'));
	}
	
	public function index(){
		$list = $this->usermanager->where(array('wUseID' => session('wUseID')))->field("wUseID",true)->order('Pid desc')->select();
		$this->assign('my1','btn0_a');
		$this->assign("myfamily",$list);
		$this->display();
	}

	public function add(){
		$this->assign('my2','btn0_a');
		$this->display();
	}
	
	public function pwd(){
		$this->assign('my9','btn0_a');
		$this->display();
	}
	
	public function del(){
		$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
		if($this->usermanager->where(array("pid"=>intval(I("get.id")), "wUseID"=>session('wUseID')))->delete()){
			header("Location:$url");
		}else{
			$this->error(L('S_parameter_e'));
		}
	}
	
	public function edit(){
		$find=$this->usermanager->where(array("pid"=>intval(I("get.id")), "wUseID"=>session('wUseID')))->field('wUseID', true)->find();
		if($find){
			$this->assign('family',$find);
			$this->assign('my1','btn0_a');
			$this->display();
		}else{
			$this->error(L('S_parameter_e'));
		}
	}
	
	public function update(){
		$pid = intval(I("get.id"));
		if($this->usermanager->CheckPid($pid)){
			$data  = I("post.");
			$data["wUseID"] = session('wUseID');
			$url = 'http://'.$_SERVER['HTTP_HOST']. __APP__.'/User/';
			if ($this->usermanager->create($data)){
				$this->usermanager->where(array("pid" => $pid, "wUseID"=>session('wUseID')))->save();
				header("Location:$url");
			}
			header("Location:$url");			
		}else{
			$this->error(L('S_parameter_e'));
		}
	}
	
	public function familyadd(){
		if(IS_POST){
			$data  = I("post.");
			$data["wUseID"] = session('wUseID');
			if($this->usermanager->create($data)){
				$this->usermanager->add();
				$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
				header("Location:$url");
			}else{
				$this->error($this->usermanager->getError());
			}
		}
	}
	
	public function useredit(){
		$UserList=$this->users->where(array("pid"=>session("pid")))->field('wMB,wName')->find();
		if($UserList){
			$this->assign('wUseID',session('wUseID'));
			$this->assign('wName',$UserList['wName']);
			$this->assign('wMB',$UserList['wMB']);
			$this->assign('my8','btn0_a');
			$this->display();
		}else{
			$this->error(L('S_parameter_e'));
		}
	}
	
	public function accountsave(){
		$postwUseID = trim(I("post.wUseID"));
		if(!empty($postwUseID) && (session('wUseID') != $postwUseID)) {
			$this->error(L('Username_n'));
		}
		$datamob = $this->users->where(array("wMB" => I("post.wMB")))->field('pid')->find();
		if($datamob['pid'] == session('pid') || empty($datamob) ){
			$data['wMB'] = trim(I('post.wMB'));
			$Mobilesave = $this->mobilemanager->where(array("wUseID" => session('wUseID')))->save($data);
		    if($this->users->create()){
				$datauser['wMB'] = trim(I('post.wMB'));
				$datauser['wName'] = trim(I('post.wName'));
				$save=$this->users->where(array("wUseID" => session('wUseID')))->save($datauser);//更新姓名
				session('wMB',I("post.wMB"));
			}
			$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
			header("Location:$url");
		}else{
			$this->error(L('S_binding'), __APP__.'/User/useredit/');
		}
	}
	
	public function pwdsave(){
		if(I("post.oldpwd") != '' && I("post.pwd") != '' && I('post.repwd') != ''){
			if(I("post.pwd") != I("post.repwd")){
				$this->error(L('S_pass_c'));
			}else{
				$data=$this->users->where(array("pid" => session('pid')))->field('wPassWord')->find();
				if($data['wPassWord'] != md5(md5(I("post.oldpwd")))){
					$this->error(L('S_pass_e'));
				}else{
					$this->users->where(array("pid" => session('pid')))->setField('wPassWord',md5(md5(I('post.pwd'))));
					$this->success(L('S_edit'), __APP__.'/User/out/');
				}
			}
		}else{
			$this->error(L('S_pass_n'));
		}
	}
	
	public function out(){
		session(null);
		$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/';
		header("Location:$url");
	}
}