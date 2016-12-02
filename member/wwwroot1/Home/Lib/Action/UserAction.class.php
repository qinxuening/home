<?php
class UserAction extends Action{
	public function _initialize(){
		header("Content-Type:text/html;charset=utf-8");
		$this->assign('langue',L('langue'));
		if(!session('?wUseID')){
			header("Location:".__APP__."/");
		}else{
			$User=M('Users');
			$where['pid']=session('pid');
			$user=$User->where($where)->find();	
			if($user){
				$this->assign("User",$user);
			}
		}
	}	
	
	public function index(){		
		$Usermanager=D("usermanager");
		import('ORG.Util.Page');
		$where['wUseID']=session('wUseID');
		$count      = $Usermanager->where($where)->count();
		$Page       = new Page($count,10);
		$Page->setConfig('header',L('Records'));
		$Page->setConfig('prev',L('Prev'));
		$Page->setConfig('next',L('Next'));
		$Page->setConfig('first',L('First'));
		$Page->setConfig('last',L('Last'));
		$Page->setConfig("theme","%totalRow% %header% %nowPage%/%totalPage% ".L('Page')."%upPage% %downPage% %first% %prePage% %linkPage% %nextPage% %end%");
		$show       = $Page->show();
		$list = $Usermanager->where($where)->order('Pid desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign("myfamily",$list);
		$this->assign('page',$show);
		$this->display();
	}	
	
	public function del(){
		$id=$this->_param('id');
		$Data=D("Usermanager");
		$map['pid']=array('eq',$id);
		if($Data->where($map)->delete()){
			$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
			header("Location:$url");
		}else{
			$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
			header("Location:$url");
		}
	}

  //编辑成员
  public function edit(){
		$id=$this->_param('id');
		$Data=D("Usermanager");
		$map['pid']=array('eq',$id);
		$find=$Data->where($map)->find();
		if($find){
			$this->assign('family',$find);
			$this->display();
		}else{
			$this->error(L('S_parameter_e'));
		}
	}
	
  //更新成员
  public function update(){
		$pid=$this->_get('id');
		$Data=M("Usermanager");
		if (!mb_strlen($_POST['familyname'])) {
			$this->error(L('Member_name_n'),U('/User/edit/id/'.$pid.'/').'/');
		}
		if (!mb_strlen($_POST['familyid'])) {
			$this->error(L('Identification_id_n'),U('/User/edit/id/'.$pid.'/').'/');
		}
		if ((int)($_POST['familyid'])<1||(int)($_POST['familyid'])>99) {
			$this->error(L('Member_id_n'),U('/User/edit/id/'.$pid.'/').'/');
		}
		$reg1 = '/^0?[1-99]{1,2}$/';
		if(!preg_match($reg1, $_POST['familyid'])) {
			$this->error(L('Member_id_e'),U('/User/edit/id/'.$pid.'/').'/');
		}		
		$data=$Data->create();
		$map['pid']=array('eq',$pid);
		$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
		if ($Data->where($map)->save($data)){
			header("Location:$url");
		}else{
			header("Location:$url");
		}
	}

	//添加成员
	public function familyadd(){
		if (!mb_strlen($_POST['familyname'])) {
			$this->error(L('Member_name_n'),U('/User/add/').'/');
		}
		if (!mb_strlen($_POST['familyid'])) {
			$this->error(L('Identification_id_n'),U('/User/add/').'/');
		}
		if ((int)($_POST['familyid'])<1||(int)($_POST['familyid'])>99) {
			$this->error(L('Member_id_n'),U('/User/add/'));
		}
		$reg1 = '/^0?[1-99]{1,2}$/';
		if(!preg_match($reg1, $_POST['familyid'])) {
			$this->error(L('Member_id_e'),U('/User/edit/id/').'/');
		}	
		$User=D("Usermanager");
		if($User->create()){
			$User->add();
			$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
			header("Location:$url");
		}else{
			$this->error($User->getError());
		}
	}
	
	//更新个人资料
	public function useredit(){
	$User=M("users");
	$data=$User->where('pid='.session('pid'))->find();
	print_r($data);
	if($data){
			$this->assign('wUseID',$data['wUseID']);
			$this->assign('wName',$data['wName']);
			$this->assign('wMB',$data['wMB']);
			$this->display();
		}else{
			$this->error(L('S_parameter_e'));
		}
	}
	
	//更新个人资料
	public function accountsave(){
		$User=M("Users");
		$mobile = $_POST['wMB'];
		$name = $_POST['wName'];
		if (!$name) {
			$this->error(L('Cname_n'),U('/User/useredit/').'/');
		}
		$pattern = '/^[1-9]\d{4,15}$/';//
		if (!mb_strlen($mobile)) {
			$this->error(L('Cmobile_n'),U('/User/useredit/').'/');
		}
		if(!preg_match($pattern, $mobile)) {
			$this->error(L('S_mobile_g'),U('/User/useredit/').'/');
		}
		$mapmob['wMB']=array('eq',$_POST['wMB']);
		$datamob=$User->where($mapmob)->find();
		$wUseID1 = session('wUseID');
		$wUseID2 = $_POST['wUseID'];
		if(!empty($wUseID2) && ($wUseID1 != $wUseID2)) {
			$this->error(L('Username_n'));
		}
		if($datamob['pid'] == session('pid') || empty($datamob) ){
			$mdata=$User->where('pid='.session('pid'))->find();
			$Mobilemanager=M("mobilemanager");
			$Mobile=$Mobilemanager->create();
			$Mobile['wMB']= $_POST['wMB'];
			$where['wMB']=$mdata['wMB'];
			$Mobilesave=$Mobilemanager->where($where)->save($Mobile);//更新手机号码
			session('wMB',$_POST['wMB']);
			$data=$User->create();
			$data['wMB'] = $_POST['wMB'];
			$data['wName'] = $_POST['wName'];
			$save=$User->where('pid='.session('pid'))->save($data);//更新姓名
			if($save){
				$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
				header("Location:$url");
			}else{
				$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
				header("Location:$url");
			}
		}else{
			$this->error(L('S_binding'), '__APP__/User/useredit/');
		}
	}

	//更新密码
	public function pwdsave(){
		if($_POST['oldpwd']!=''&&$_POST['pwd']!=''&&$_POST['repwd']!=''){
			if($_POST['pwd']!=$_POST['repwd']){
				$this->error(L('S_pass_c'));
			}else{
				$User=M("Users");
				$data=$User->where('pid='.session('pid'))->find();
				if($data['wPassWord']!=md5(md5($_POST['oldpwd']))){
					$this->error(L('S_pass_e')); 
				}else{
					$User->where('pid='.session('pid'))->setField('wPassWord',md5(md5($_POST['pwd'])));
					$this->success(L('S_edit'), '__APP__/User/out/'); 
				}
			}
		}else{
			$this->error(L('S_pass_n'));
		}
	}
	
	//退出管理
	public function out(){
		session(null);
		$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/';
		header("Location:$url");
	}
}
?>