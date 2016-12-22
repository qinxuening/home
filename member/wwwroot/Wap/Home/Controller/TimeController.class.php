<?php
namespace Home\Controller;
class TimeController extends CommonController{
	protected $timeaction_head;
	protected $mobilemanager;
	protected $timeaction;
	protected $timeaction_child;
	protected $timeaction_temp;
	
	public function _initialize(){
		parent::_initialize();
		$this->timeaction_head = D("TimeactionHead");
		$this->mobilemanager = D('Mobilemanager');
		$this->timeaction = D('Timeaction');
		$this->timeaction_child = D('timeaction_child');
		$this->timeaction_temp = D('timeaction_temp');
	}
	
	public function index(){
		$list = $this->timeaction_head->where(array('wUseID' => session('wUseID')))->field('wName, Pid')->order(array('Pid'=>'desc'))->select();
		$this->assign("mytype",$list);
		$this->assign('my6','btn0_a');
		$this->display();
	}

	public function del(){
		$Pid=intval(I('get.id'));
		if($this->timeaction_head->CheckPid($Pid)){
			$this->timeaction_child->where(array('wModel'=>$Pid))->delete();
			$this->timeaction_temp->where(array('wModel'=>$Pid))->delete();
			$result = $this->timeaction_head->relation(true)->where(array('Pid' => $Pid))->delete();
			if($result){
				$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Time/';
				header("Location:$url");
			}else{
				$this->error(L('S_del_e'),U('Time/index'));
			}
		}else{
			$this->error(L('S_parameter_e'));
		}
	}

	public function edit(){
		$Pid=intval(I('get.id'));
		if($this->timeaction_head->CheckPid($Pid)){
			$wMB=session('wMB');
			$wUseID=session('wUseID');
			$list = $this->mobilemanager->query("select `McID`, `McName`, left(`McID`,2) as McID3  from `mobilemanager` where `wUseID` ='$wUseID' AND `wMB`='$wMB' AND left(`McID`,2) not in ('12')");
			$find = $this->timeaction_head->where(array('Pid' => $Pid))->field("wUseID",true)->find();
			if($find){
				$findmodel=$this->timeaction->join("LEFT JOIN `timeaction_child` m on `timeaction`.Pid = m.Pid")->where(array("`timeaction`".".wModel" => $find['Pid']))->field("`timeaction`.`McID` , Key1, Key2, Key3")->select();
				$timeaction_temp_list = $this->timeaction->join("JOIN `timeaction_temp` m on `timeaction`.Pid = m.tid")->where(array("`timeaction`".".wModel" => $find['Pid']))->field("`timeaction`.`McID` ,Th, Tl, Hh, Hl, Tf")->select();
				$m = TarrayToOarray($findmodel, 'McID');
				$this->assign("checklist",$m);
				$this->assign("myMobile",$list);
				$this->assign("Key_mLinkOn", key_timeaction_value_Key($findmodel, 'McID'));
				$this->assign("temp_mLinkOn", key_timeaction_temp($timeaction_temp_list, 'McID'));
				$this->assign('type',$find);
				$this->assign('my6','btn0_a');
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
		if($this->timeaction_head->CheckPid($Pid)){
			$HeadInfo['wUseID'] = session('wUseID');
			$HeadInfo['wTime'] = I('post.wTime');
			$HeadInfo['wName'] = I('post.wName');
			$HeadInfo['wType'] = I('post.wType')?I('post.wType'):0;
			$HeadInfo['wMon'] = I('post.wMon')?I('post.wMon'):0;
			$HeadInfo['wTues'] = I('post.wTues')?I('post.wTues'):0;
			$HeadInfo['wWed'] = I('post.wWed')?I('post.wWed'):0;
			$HeadInfo['wThur'] = I('post.wThur')?I('post.wThur'):0;
			$HeadInfo['wFri'] = I('post.wFri')?I('post.wFri'):0;
			$HeadInfo['wSat'] = I('post.wSat')?I('post.wSat'):0;
			$HeadInfo['wSunday'] = I('post.wSunday')?I('post.wSunday'):0;
			if($this->timeaction_head->create()){
				$this->timeaction_head->where(array('Pid' => $Pid))->save($HeadInfo);
			}
			$this->timeaction_child->where(array('wModel' => $Pid))->delete();
			$this->timeaction->where(array('wModel' => $Pid))->delete();
			$wModeldata=I('post.wModel',null);
			Do_Timeaction_child($this->timeaction, $this->timeaction_child,$this->timeaction_temp, $wModeldata, $Pid);
		}else{
			$this->error(L('S_parameter_e'));
		}
		$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Time/';
		header("Location:$url");
	}

	public function add(){
		$wMB=session('wMB');
		$wUseID=session('wUseID');
		$list = $this->mobilemanager->query("select `McID`, `McName`, left(`McID`,2) as McID3  from `mobilemanager` where `wUseID` ='$wUseID' AND `wMB`='$wMB' AND left(`McID`,2) not in ('12')");
		$this->assign("myMobile",$list);
		$this->assign('my7','btn0_a');
		$this->display();
	}
	
	public function typeadd(){
		$HeadInfo = I('post.');
		$HeadInfo['wUseID'] = session('wUseID');
		if($this->timeaction_head->create($HeadInfo)){
			$id=$this->timeaction_head->add();
			$wModeldata=I('post.wModel',null);
			Do_Timeaction_child($this->timeaction, $this->timeaction_child,$this->timeaction_temp, $wModeldata, $id);
			$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Time/';
			header("Location:$url");
		}else{
			$this->error($this->timeaction_head->getError());
		}
	}
}