<?php
namespace Home\Controller;
class TypeController extends CommonController{
	protected $modeltype_head;
	protected $mobilemanager;
	protected $modeltype;
	protected $modeltype_child;
	
	public function _initialize(){
		parent::_initialize();
		$this->modeltype_head = D("Modeltype_head");
		$this->mobilemanager = D("Mobilemanager");
		$this->modeltype = D("Modeltype");
		$this->modeltype_child = D("Modeltype_child");
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
			$this->modeltype_child->where(array('wModel'=>$Pid))->delete();
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
					"select `McID`, `McName`, left(`McID`,2) as McID3 from `mobilemanager`
					 where `wUseID` ='$wUseID' 
					 AND `wMB`='$wMB' 
					 AND left(`McID`,2) not in ('12')");
			$find=$this->modeltype_head->where(array("Pid" => $Pid))->field("wUseID",true)->find();
			if($find){
				$findmodel=$this->modeltype->join("LEFT JOIN `modeltype_child` m on `modeltype`.Pid = m.Pid")->where(array("`modeltype`".".wModel" => $find['Pid']))->field("`modeltype`.`McID` ,Type, Key1, Key2, Key3")->select();
				foreach ($findmodel as $k => $v){
					if(1 == $v['Type']){
						$dataOn[] = $v['McID'];
					}else{
						$dataOff[] = $v['McID'];
					}
				}
				$this->assign("checklistOn" , $dataOn);
				$this->assign("checklistOff" , $dataOff);
				
				$this->assign("Key_mLinkOn",key_wModel_value_Key($findmodel, 'McID', 1));
				$this->assign("Key_mLinkOff",key_wModel_value_Key($findmodel, 'McID', 0));				
				
				$this->assign("myMobile",$list);
				$this->assign('my4','btn0_a');
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
			$this->modeltype_child->where(array("wModel" => $Pid))->delete();
			$this->modeltype->where(array("wModel" => $Pid))->delete();
			$wModelOndata=I('post.wModelOn',null);
			$wModelOffdata=I('post.wModelOff',null);

			Do_modeltype_child($this->modeltype, $this->modeltype_child, $wModelOndata, $Pid, 1);
			Do_modeltype_child($this->modeltype, $this->modeltype_child, $wModelOffdata, $Pid, 0);			
			
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
				"select `McID`, `McName`, left(`McID`,2) as McID3 from `mobilemanager`
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
			
			Do_modeltype_child($this->modeltype, $this->modeltype_child, $wModelOndata, $id, 1);
			Do_modeltype_child($this->modeltype, $this->modeltype_child, $wModelOffdata, $id, 0);
			
			$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Type/';
			header("Location:$url");
		}else{
			$this->error($this->modeltype_head->getError());
		}
	}
}