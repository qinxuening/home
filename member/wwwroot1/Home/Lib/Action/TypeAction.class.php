<?php
class TypeAction extends Action {
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
		$Modeltype=D("modeltype_head");
		import('ORG.Util.Page');
		$where['wUseID']=session('wUseID');
		$count      = $Modeltype->where($where)->count();
		$Page       = new Page($count,10);
		$Page->setConfig('header',L('Records'));
		$Page->setConfig('prev',L('Prev'));
		$Page->setConfig('next',L('Next'));
		$Page->setConfig('first',L('First'));
		$Page->setConfig('last',L('Last'));
		$Page->setConfig("theme","%totalRow% %header% %nowPage%/%totalPage% ".L('Page')."%upPage% %downPage% %first% %prePage% %linkPage% %nextPage% %end%");
		$show       = $Page->show();
		$list = $Modeltype->where($where)->order(array('Pid'=>'desc'))->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign("mytype",$list);
		$this->assign('list',$list);
		$this->assign('page',$show);
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
		}else{
			$this->error(L('S_del_e'),U('Type/index'));
		}
	}
 //编辑模式
  public function edit(){
		$Pid=$this->_param('id');
		$Mobilemanager=D("mobilemanager");
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
		   $m=array();
		   foreach($findmodel as $k=>$v){
     	      $m[$k]=$v['McID'];
           }
		    $this->assign("checklist",$m);
		    $this->assign("myMobile",$list);
			$this->assign('type',$find);
			$this->display();
		}else{
			$this->error(L('S_parameter_e'));
		}
	}
	//更新模式
   public function update(){
		$Pid=$this->_get('id');
		$Model=D("modeltype");

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
		$maps['wModel']=array('eq',$Pid);
		$Model->where($maps)->delete();
		
		$Users->create();
		$map['Pid']=array('eq',$Pid);
		$Users->where($map)->save();//更新模式
		
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
		$this->assign("myMobile",$list);
        $this->display();
	}
	public function typeadd(){	
		if(!mb_strlen($_POST['wName'])) {
			$this->error(L('Model_n'),U('Type/add'));
		}
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
		if($User->create()){
			$id=$User->add();
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