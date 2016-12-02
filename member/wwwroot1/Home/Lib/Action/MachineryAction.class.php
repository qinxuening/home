<?php
class MachineryAction extends Action{
	public function _initialize(){
		header("Content-Type:text/html;charset=utf-8");
		$this->assign('langue',L('langue'));
		if(!session('?wUseID')){
			header("Location:".__APP__."/");
		}else{
			$User=M('Users');
			$where['wUseID']=session('wUseID');
			$user=$User->where($where)->find();
			
			if($user){
				session('w_id',$user['w_id']);
				$this->assign("User",$user);
			}
		}
	}
	
	public function index(){		
		//获取设备表
		$Usermanager=D("machinerylist");
		$where['w_id']=session('w_id');
		$usermanagercount=$Usermanager->where('w_id='.session('w_id'))->count();
		$list=$Usermanager->where('w_id='.session('w_id'))->order('m_id desc')->select();
		
		$this->assign("mymachinery",$list);
		$this->display();
	}	
  //删除设备
	public function del(){
		$id=$this->_param('id');
		$Data=D("machinerylist");
		$map['m_id']=array('eq',$id);
		if($Data->where($map)->delete()){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}
 //编辑设备
 public function edit(){
		$id=$this->_param('id');
		$Data=D("machinerylist");
		$map['m_id']=array('eq',$id);
		$find=$Data->where($map)->find();
		if($find){
			$this->assign('machinery',$find);
			$this->display();
		}else{
			$this->error('参数错误');
		}
	}
	//更新设备
public function update(){
		$id=$this->_get('id');
		$Data=M("machinerylist");
		$data=$Data->create();
		$map['m_id']=array('eq',$id);
	
		if($Data->where($map)->save($data)){
			header("Location:".__APP__."/Machinery/");
		}else{
			$this->error('更新失败');
		}
	}
	//添加设备
	
	public function machineryadd(){
		$User=D("machinerylist");
		if($User->create()){
			$User->add();
			header("Location:".__APP__."/Machinery/");
		}else{
			$this->error($User->getError());
		}
	}
}
?>