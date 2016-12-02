<?php
class UserAction extends Action{
	
	public function _initialize(){
		
		header("Content-Type:text/html;charset=utf-8");
		if(!session('?wUseID')){
			header("Location:".__APP__."/");
		}else{
			$User=M('Users');
			$where['pid']=session('pid');
			$user=$User->where($where)->find();		
			if($user){
				session('pid',$user['pid']);
				session('wUseID',$user['wUseID']);
				$this->assign("User",$user);
			}
		}
		
	}
	
	public function index(){
		//$User=D("Users");
		//获取成员列表
		$Usermanager=D("usermanager");
		$where['wUseID']=session('wUseID');
		$list=$Usermanager->where($where)->order('Pid desc')->select();
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
	
  	//删除成员
	public function del(){
		$id=$this->_param('id');
		$Data=D("Usermanager");
		$map['pid']=array('eq',$id);
		if($Data->where($map)->delete()){
			$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
			header("Location:$url");
		}else{
			$this->error(L('S_del_e'));        //'删除失败'
		}
	}
	
	public function del2(){
		$id=$this->_param('id');
		$Data=D("Usermanager");
		$map['pid']=array('eq',$id);
		if($Data->where($map)->delete())
			echo 1; 
		else 
			echo 0;
	}
	
	//编辑成员
	public function edit(){
		$id=$this->_param('id');
		$Data=D("Usermanager");
		$map['pid']=array('eq',$id);
		$find=$Data->where($map)->find();
		if($find){
			$this->assign('family',$find);
			$this->assign('my1','btn0_a');
			$this->display();
		}else{
			$this->error(L('S_parameter_e'));         //'参数错误'
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
		if ($Data->where($map)->save($data)) {
			header("Location:$url");
		}else{
			header("Location:$url");      //'无更新数据'
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
			$this->error(L('Member_id_e'),U('/User/edit/id/'.$pid).'/');
		}
		$User=D("Usermanager");
		$familyname = I('post.familyname');
		$familyid = I('post.familyid');
		if($familyname && $familyid){
			if($User->create()){
				$User->add();
				//header("Location:".__APP__."/User/");
				$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
				header("Location:$url");
			}else{
				$this->error($User->getError());
			}
		}else{
			$this->error(L('S_parameter_e'));          //'参数错误'
		}
		
	}
	
	//更新个人资料
	public function useredit(){
		
		$User=M("users");
		$data=$User->where('pid='.session('pid'))->find();
		if($data){
			//$decrypt = new encrypt(); //调用解密
			$this->assign('wUseID',$data['wUseID']);
			$this->assign('wName',$data['wName']);
			$this->assign('wMB',$data['wMB']);
			$this->assign('my8','btn0_a');
			$this->display();
		}else{
			$this->error(L('S_parameter_e'));      //'参数错误'
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
			//return '手机号码不能为空';
			$this->error(L('Cmobile_n'),U('/User/useredit/').'/');
		}
		if(!preg_match($pattern, $mobile)) {
			//return '手机号码格式不正确';
			$this->error(L('S_mobile_g'),U('/User/useredit/').'/');
		}		
		
		$mapmob['wMB']=array('eq',$_POST['wMB']);
		$datamob=$User->where($mapmob)->find();
		$wUseID1 = session('wUseID');
		$wUseID2 = $_POST['wUseID'];
		//对前端认为解禁disable进行验证
		if(!empty($wUseID2) && ($wUseID1 != $wUseID2)) {
			$this->error(L('Username_n'));
		}		
		if($datamob['pid'] == session('pid') || empty($datamob)){
					
			$mdata=$User->where('pid='.session('pid'))->find();     //通过PID获取其数据
			$Mobilemanager=M("mobilemanager");    //调整手机号码
			$Mobile=$Mobilemanager->create();
			$Mobile['wMB']= $_POST['wMB'];
			$where['wMB']=$mdata['wMB'];
			$Mobilesave=$Mobilemanager->where($where)->save($Mobile);        //更新手机号
			
			$data=$User->create();
			//$encrypt = new encrypt(); //调用加密
			//$data->wUseID = $encrypt->encrypt($_POST['wUseID']);
			$data['wMB'] = $_POST['wMB'];
			$data['wName'] = $_POST['wName'];
			//$map['pid']=array('eq',session('pid'));
			$save=$User->where('pid='.session('pid'))->save($data);      //更新姓名
			if($save){
				//$this->success(L('S_update'));                     //"更新成功"
				$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
				header("Location:$url");
			}else{
				//header("Location:".__APP__."/User/useredit/");
				//$this->error(L('No_updates'));
				$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
				header("Location:$url");
			}
			
		}else{
			$this->error(L('S_binding'), '__APP__/User/useredit/');	    //手机已经绑定到其他用户上
		} 
	
	}
	
	//更新密码
	public function pwdsave(){
		if($_POST['oldpwd']!=''&&$_POST['pwd']!=''&&$_POST['repwd']!=''){
			if($_POST['pwd']!=$_POST['repwd']){
				$this->error(L('S_pass_c'));    //'两次密码输入不一致'
			}else{
				$User=M("Users");
				$data=$User->where('pid='.session('pid'))->find();
				if($data['wPassWord']!=md5(md5($_POST['oldpwd']))){
					$this->error(L('S_pass_e'));        //'原始密码错误'
				}else{
					$User->where('pid='.session('pid'))->setField('wPassWord',md5(md5($_POST['pwd'])));
					$this->success(L('S_edit'), '__APP__/User/out/');     //修改成功！
				}
			}
		}else{
			$this->error(L('S_pass_n'));    //'密码不能为空'
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