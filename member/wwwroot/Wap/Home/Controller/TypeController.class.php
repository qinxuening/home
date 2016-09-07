<?php
namespace Home\Controller;
class TypeController extends CommonController{
	protected $modeltype_head;
	protected $mobilemanager;
	protected $modeltype;
	
	public function _initialize(){
		parent::_initialize();
		$this->modeltype_head = D("Modeltype_head");
		$this->mobilemanager = D("Mobilemanager");
		$this->modeltype = D("Modeltype");
	}
	public function index(){
		$list = $this->modeltype_head->where(array("wUseID" => session('wUseID')))->order(array('Pid'=>'desc'))->field('wName, Pid')->select();
		$this->assign("mytype",$list);
		$this->assign('my4','btn0_a');
		$this->display();
	}

	public function del(){
		$Pid=intval(I('get.id'));
		if($this->modeltype_head->CheckPid($Pid)){
			$result = $this->modeltype_head->relation(true)->where(array('Pid' => $Pid))->delete();
			if($result){
				$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Type/';
				header("Location:$url");
			}else{
				$this->error(L('S_del_e'),U('Type/index'));
			}
		}else{
			$this->error(L('S_parameter_e'));
		}
	}

	public function edit(){
		$Pid=intval(I('get.id'));
		if($this->modeltype_head->CheckPid($Pid)){
			$wMB=session('wMB');
			$wUseID=session('wUseID');
			$list = $this->mobilemanager->query(
					"select `McID`, `McName` from `mobilemanager`
					 where `wUseID` ='$wUseID' 
					 AND `wMB`='$wMB' 
					 AND left(`McID`,2) not in ('12')");
			$find=$this->modeltype_head->where(array("Pid" => $Pid))->field("wUseID",true)->find();
			if($find){
				$findmodel=$this->modeltype->where(array("wModel" => $find['Pid']))->field('McID ,Type')->select();
				foreach ($findmodel as $k => $v){
					if(1 == $v['Type']){
						$dataOn[] = $v['McID'];
					}else{
						$dataOff[] = $v['McID'];
					}
				}
				$this->assign("checklistOn" , $dataOn);
				$this->assign("checklistOff" , $dataOff);
				$this->assign("myMobile",$list);
				$this->assign('type',$find);
				$this->display();
			}else{
				$this->error(L('S_parameter_e'));
			}
		}else{
			$this->error(L('S_parameter_e'));
		}
	}

	public function update(){
		$Pid=intval(I('get.id'));
		if($this->modeltype_head->CheckPid($Pid)){
			$HeadInfo = I('post.');
			$HeadInfo['wUseID'] = session('wUseID');
			if($this->modeltype_head->create($HeadInfo)){
				$this->modeltype_head->where(array("Pid" => $Pid))->save();
			}
			$this->modeltype->where(array("wModel" => $Pid))->delete();
			$wModelOndata=I('post.wModelOn',null);
			$wModelOffdata=I('post.wModelOff',null);
			for($i=0;$i<count($wModelOndata);$i++){
				$dataOn['wModel']=$Pid;
				$dataOn['McID']=$wModelOndata[$i];
				$dataOn['wUseID']=session('wUseID');
				$dataOn['Type']= 1;
				$this->modeltype->create();
				$this->modeltype->add($dataOn);
			}
			for($i=0;$i<count($wModelOffdata);$i++){
				$dataOff['wModel']=$Pid;
				$dataOff['McID']=$wModelOffdata[$i];
				$dataOff['wUseID']=session('wUseID');
				$dataOff['Type']= 0;
				$this->modeltype->create();
				$this->modeltype->add($dataOff);
			}
			$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Type/';
			header("Location:$url");
		}else{
			$this->error(L('S_parameter_e'));
		}
	}

	public function add(){
		$wMB=session('wMB');
		$wUseID=session('wUseID');
		$list = $this->mobilemanager->query(
				"select `McID`, `McName` from `mobilemanager`
				 where `wUseID` ='$wUseID' 
				 AND `wMB`='$wMB' 
				 AND left(`McID`,2) not in ('12')");
		$this->assign("myMobile",$list);
		$this->assign('my5','btn0_a');
		$this->display();
	}
	
	public function typeadd(){
		$HeadInfo = I('post.');
		$HeadInfo['wUseID'] = session('wUseID');
		if($this->modeltype_head->create($HeadInfo)){
			$id=$this->modeltype_head->add();
			$wModelOndata=I('post.wModelOn',null);
			$wModelOffdata=I('post.wModelOff',null);
			for($i=0;$i<count($wModelOndata);$i++){
				$dataOn['wModel']=$id;
				$dataOn['McID']=$wModelOndata[$i];
				$dataOn['wUseID']=session('wUseID');
				$dataOn['Type']= 1;
				$this->modeltype->create();
				$this->modeltype->add($dataOn);
			}
			for($i=0;$i<count($wModelOffdata);$i++){
				$dataOff['wModel']=$id;
				$dataOff['McID']=$wModelOffdata[$i];
				$dataOff['wUseID']=session('wUseID');
				$dataOff['Type']= 0;
				$this->modeltype->create();
				$this->modeltype->add($dataOff);
			}
			$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Type/';
			header("Location:$url");
		}else{
			$this->error($this->modeltype_head->getError());
		}
	}
}