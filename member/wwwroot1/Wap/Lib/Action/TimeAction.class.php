<?php
// 本类由系统自动生成，仅供测试用途
class TimeAction extends Action {

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
		$Modeltype=D("timeaction_head");
		$where['wUseID']=session('wUseID');
		$list=$Modeltype->where($where)->order(array('Pid'=>'desc'))->select();
		
		$this->assign('my6','btn0_a');
		$this->assign("mytype",$list);
		$this->display();
	}
		
  	//删除模式
	public function del(){
		$Pid=$this->_param('id');
		$Data=D("TimeactionHead");
				
		$map['Pid']=array('eq',$Pid);
		$result = $Data->relation(true)->where($map)->delete();//关联删除
		
		if($result){
			$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Time/';
			header("Location:$url");
			//$this->success('删除成功');
		}else{
			$this->error(L('S_del_e'));               //////////////'删除失败'
		}
	}
	
	 //编辑时间
 	public function edit(){
		$Pid=$this->_param('id');
		$Mobilemanager=D("mobilemanager");
		$wMB=session('wMB');
		$wUseID=session('wUseID');
		$list = $Mobilemanager->query("select * from `mobilemanager` where `wUseID` ='$wUseID' AND `wMB`='$wMB' AND left(`McID`,2) not in ('12')");
		//$list = $Mobilemanager->where(array('wUseID' => session('wUseID')))->select();
		$Data=D("timeaction_head");
		$map['Pid']=array('eq',$Pid);
		$find=$Data->where($map)->find();
		if($find){
		   $Model=D("timeaction");
		   $maps['wModel']=array('eq',$find['Pid']);
		   $findmodel=$Model->where($maps)->select();
		   //print_r($findmodel);
		   $m=array();
		   foreach($findmodel as $k=>$v){
           $m[$k]=$v['McID'];
           }
			$this->assign("checklist",$m);
		    $this->assign("myMobile",$list);
			//print_r($find);exit;
			$this->assign('type',$find);
			$this->assign('my6','btn0_a');
			$this->display();
		}else{
			$this->error(L('S_parameter_e'));                          ////////////////'参数错误'
		}
	}
	
	//更新时间
	public function update(){	
		$Pid=$this->_get('id');
		$Model=D("timeaction");
		
				//*********
		if(!mb_strlen($_POST['wName'])) {
			$this->error(L('Times_n'),U('/Time/edit/id/'.$Pid).'/');
		}
		
		$Users=D("timeaction_head");
		$where['wMB']=session('wMB');
		$where['wUseID']=session('wUseID');
		$mapd['Pid']=array('eq',$Pid);
		$select = $Users->where($where)->select();
		$find=$Users->where($mapd)->find();//查找模式
		
		$arr = array();
		foreach ($select as $key=>$value) {
			$arr[$key] = $value['wName'];
		}
		
		if(($_POST['wName'] != $find['wName'])&&in_array($_POST['wName'], $arr)) {
			$this->error(L('Times_z'));
		}
		//**********
		
		
		$maps['wModel']=array('eq',$Pid);
		$Model->where($maps)->delete();
		
		$data=$Users->create();
		$map['Pid']=array('eq',$Pid);
		$Users->where($map)->save($data);
		$wModeldata= $_POST['wModel'];
		
		for($i=0;$i<count($wModeldata);$i++){
			$data['wModel']= $Pid;
			$data['McID']= $wModeldata[$i];
			$data['wUseID']= $_POST['wUseID'];
			$Model->create();
			$Model->add($data);
		}
		$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Time/';
		header("Location:$url");
	}
	
	//添加时间
	public function add(){
		$Mobilemanager=D("mobilemanager");
		$wMB=session('wMB');
		$wUseID=session('wUseID');
		$list = $Mobilemanager->query("select * from `mobilemanager` where `wUseID` ='$wUseID' AND `wMB`='$wMB' AND left(`McID`,2) not in ('12')");	
		//$list = $Mobilemanager->where(array('wUseID' => session('wUseID')))->select();
		$this->assign("myMobile",$list);
		$this->assign('my7','btn0_a');
        $this->display();
	}
	
	public function typeadd(){
	   		//**
		if(!mb_strlen($_POST['wName'])) {
			$this->error(L('Times_n'),U('Time/add'));
		}
		$User=D("timeaction_head");
		$where['wMB']=session('wMB');
		$where['wUseID']=session('wUseID');
		$select = $User->where($where)->select();
		$arr = array();
		foreach ($select as $key=>$value) {
			$arr[$key] = $value['wName'];
		}
		if(in_array($_POST['wName'], $arr)) {
			$this->error(L('Times_z'));
		}
		//***
		if($User->create()){
		$id=$User->add();
		//循环存入数组
		$wModeldata=$_POST['wModel'];
		$Model=D("timeaction");
	    for($i=0;$i<count($wModeldata);$i++){
	    $data['wModel']=$id;
		$data['McID']=$wModeldata[$i];
	    $data['wUseID']=$_POST['wUseID'];
		$Model->create();
		$Model->add($data);
	   }	
		$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Time/';
		header("Location:$url");
		}else{
			$this->error($User->getError());
		}
	}
}
?>