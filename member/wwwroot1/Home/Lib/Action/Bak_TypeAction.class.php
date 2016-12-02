<?php
// 本类由系统自动生成，仅供测试用途
class TypeAction extends Action {

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
				session('wMB',$user['wMB']);
				$this->assign("User",$user);
			}
		}
	}
  public function index(){		
		//获取模式表
		$Modeltype=D("modeltype_head");
		$where['wUseID']=session('wUseID');
		$list=$Modeltype->where($where)->select();
		
		$this->assign("mytype",$list);
		$this->display();
	}	
  //删除模式
	public function del(){
		$Pid=$this->_param('id');
		$Data=D("modeltype_head");
		$map['Pid']=array('eq',$Pid);
		if($Data->where($map)->delete()){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}
 //编辑模式
 public function edit(){
		$Pid=$this->_param('id');
		$Mobilemanager=D("mobilemanager");
		$where['wMB']=session('wMB');
		$where['wUseID']=session('wUseID');
		//$usermanagercount=$Usermanager->where('w_id='.session('w_id'))->count();
		$list=$Mobilemanager->where($where)->order('Item ASC')->select();
		
		 
		$Data=D("modeltype_head");
		$map['Pid']=array('eq',$Pid);
		$find=$Data->where($map)->find();
		if($find){
		 $finds=$find['wModel'];
		 $finds=explode(",",$finds);//分割成数组
		// print_r($finds);
		 //exit;
			$this->assign("checklist",$finds);
		    $this->assign("myMobile",$list);
			$this->assign('type',$find);
			$this->display();
		}else{
			$this->error('参数错误');
		}
	}
	//更新设备
public function update(){
		$Pid=$this->_get('id');
		$Users=D("modeltype_head");
		$wModel=implode(",",$_POST['wModel']);
		$data=$Users->create();
		$map['Pid']=array('eq',$Pid);
	    $data['wModel'] = $wModel;
		$data['wType'] = $_POST['wType'];
		$data['wName'] = $_POST['wName'];
		if($Users->where($map)->save($data)){
			header("Location:".__APP__."/Type/");
		}else{
			$this->error('更新失败');
		}
	}
	//添加设备
	public function add(){
	$Mobilemanager=D("mobilemanager");
		$where['wMB']=session('wMB');
		$where['wUseID']=session('wUseID');
		//$usermanagercount=$Usermanager->where('w_id='.session('w_id'))->count();
		$list=$Mobilemanager->where($where)->order('Item ASC')->select();
		$this->assign("myMobile",$list);
         $this->display();
	}
	public function typeadd(){
		$User=D("modeltype_head");
		$wModel=implode(",",$_POST['wModel']);
		if($User->create()){
		   $User->wModel = $wModel;
			$User->add();
			header("Location:".__APP__."/Type/");
		}else{
			$this->error($User->getError());
		}
	}
}
?>