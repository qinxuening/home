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
		$list=$Modeltype->where($where)->order(array('Pid'=>'desc'))->select();
		
		$this->assign('my4','btn0_a');
		$this->assign("mytype",$list);
		$this->display();
	}	
  	//删除模式
	public function del(){
		$Pid=$this->_param('id');
		
		$Data=D("ModeltypeHead"); 
		$map['Pid']=array('eq',$Pid);
		$result = $Data->relation(true)->where($map)->delete();		
		if($result){
			$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Type/';
      	    header("Location:$url");
			//$this->success('删除成功');
		}else{
			$this->error(L('S_sys_e'));     //'服务器繁忙，删除失败！'
		}
	}
 	//编辑模式
 	public function edit(){
		
		$Pid=$this->_param('id');
		$Mobilemanager   = D("mobilemanager");
		$where['wMB']    = session('wMB');
		$wMB=session('wMB');
		$wUseID=session('wUseID');
		$list = $Mobilemanager->query("select * from `mobilemanager` where `wUseID` ='$wUseID' AND `wMB`='$wMB' AND left(`McID`,2) not in ('12')");
		//$list = $Mobilemanager->where(array('wUseID' => session('wUseID')))->select();
		$Data=D("modeltype_head");
		$map['Pid']=array('eq',$Pid);
		$find=$Data->where($map)->find();
		
		if($find){
		   $Model=D("modeltype");
		   $maps['wModel']=array('eq',$find['Pid']);
		   $findmodel=$Model->where($maps)->select();
		   //print_r($findmodel);
		   $m=array();
		   foreach($findmodel as $k=>$v){
           $m[$k]=$v['McID'];
           }
			$this->assign("checklist",$m);
		    $this->assign("myMobile",$list);
			$this->assign('type',$find);
			$this->assign('my4','btn0_a');
			$this->display();
		}else{
			$this->error(L('S_parameter_e'));    //'参数错误'
		}
		
	}
	//更新模式
	public function update(){
		$Pid=$this->_get('id');
		$Model=D("modeltype");
		
		//***
	    if(!mb_strlen($_POST['wName'])) {
			$this->error(L('Model_n'),U('/Type/edit/id/'.$Pid).'/');
		}	
		
		$Users=D("modeltype_head");
		$where['wMB']=session('wMB');
		$where['wUseID']=session('wUseID');
		$mapd['Pid']=array('eq',$Pid);
		$select = $Users->where($where)->select();//查找该用户所有模式
		$find=$Users->where($mapd)->find();//查找模式

		$arr = array();
		foreach ($select as $key=>$value) {
			$arr[$key] = $value['wName'];
		}

		if(($_POST['wName'] != $find['wName'])&&in_array($_POST['wName'], $arr)) {
			$this->error(L('Model_z'));
		}
		//**		
		$maps['wModel']=array('eq',$Pid);
		$Model->where($maps)->delete();
		
		$Users->create();
		$map['Pid']=array('eq',$Pid);
		$Users->where($map)->save();

		//print_r($_POST);die();
		$wModeldata=$_POST['wModel'];
	        for($i=0;$i<count($wModeldata);$i++){
	         $data['wModel']=$Pid;
		     $data['McID']=$wModeldata[$i];
	         $data['wUseID']=$_POST['wUseID'];
		     $Model->create();
		     $Model->add($data);
			}
        $url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Type/';
        header("Location:$url");
	}
	//添加设备
	public function add(){
		$Mobilemanager=D("mobilemanager");
		$wMB=session('wMB');
		$wUseID=session('wUseID');
		$list = $Mobilemanager->query("select * from `mobilemanager` where `wUseID` ='$wUseID' AND `wMB`='$wMB' AND left(`McID`,2) not in ('12')");
		//$list = $Mobilemanager->where(array('wUseID' => session('wUseID')))->select();
		$this->assign('my5','btn0_a');
		$this->assign("myMobile",$list);
        $this->display();
	}
	public function typeadd(){
		//***
		if(!mb_strlen($_POST['wName'])) {
			$this->error(L('Model_n'),U('Type/add'));
		}
		//***
		$User=D("modeltype_head");
		$where['wMB']=session('wMB');
		$where['wUseID']=session('wUseID');
		$select = $User->where($where)->select();
		$arr = array();
		foreach ($select as $key=>$value) {
			$arr[$key] = $value['wName'];
		}
		if(in_array($_POST['wName'], $arr)) {
			$this->error(L('Model_z'));
		}
		//****
		if($User->create()){
			$id=$User->add();
			//循环存入数组
			$wModeldata=$_POST['wModel'];
			$Model=D("modeltype");
			
			for($i=0;$i<count($wModeldata);$i++){
				$data['wModel']=$id;
				$data['McID']=$wModeldata[$i];
				$data['wUseID']=$_POST['wUseID'];
				$Model->create();
				$Model->add($data);
			}	
			$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Type/';
       	    header("Location:$url");
		}else{
			$this->error($User->getError());
		}
	}
}
?>