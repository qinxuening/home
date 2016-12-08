<?php
namespace Home\Controller;
class TimeController extends CommonController{
	protected $timeaction_head;
	protected $mobilemanager;
	protected $timeaction;
	protected $timeaction_child;
	
	public function _initialize(){
		parent::_initialize();
		$this->timeaction_head = D("TimeactionHead");
		$this->mobilemanager = D('Mobilemanager');
		$this->timeaction = D('Timeaction');
		$this->timeaction_child = D('timeaction_child');
	}
	
	public function index(){
		$count      = $this->timeaction_head->where(array('wUseID' => session('wUseID')))->count();
	  	$Page       = new \Think\Page($count,10);
	  	$Page->setConfig('header',L('All').'<b>%TOTAL_ROW%</b>'.L('Records').'&nbsp;&nbsp;'.L('The').'<b>%NOW_PAGE%</b>/<b>%TOTAL_PAGE%</b>'.L('Page'));
	  	$Page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
	  	$show       = $Page->show();
		$list = $this->timeaction_head->where(array('wUseID' => session('wUseID')))->field('wName, Pid')->order(array('Pid'=>'desc'))->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign("mytype",$list);
		$this->assign('page',$show);
		$this->display();
	}

	public function del(){
		$Pid=intval(I('get.id'));
		if($this->timeaction_head->CheckPid($Pid)){
			$this->timeaction_child->where(array('wModel'=>$Pid))->delete();
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
				$m = TarrayToOarray($findmodel, 'McID');
				$this->assign("checklist",$m);
				$this->assign("myMobile",$list);
				$this->assign("Key_mLinkOn", key_timeaction_value_Key($findmodel, 'McID'));
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
		if($this->timeaction_head->CheckPid($Pid)){
			$HeadInfo = I('post.');
			$HeadInfo['wUseID'] = session('wUseID');
			if($this->timeaction_head->create($HeadInfo)){
				$this->timeaction_head->where(array('Pid' => $Pid))->save();
			}
			$this->timeaction_child->where(array('wModel' => $Pid))->delete();
			$this->timeaction->where(array('wModel' => $Pid))->delete();
			$wModeldata=I('post.wModel',null);
			Do_Timeaction_child($this->timeaction, $this->timeaction_child, $wModeldata, $Pid);
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
		$this->display();
	}
	
	public function typeadd(){
		$HeadInfo = I('post.');
		$HeadInfo['wUseID'] = session('wUseID');
		if($this->timeaction_head->create($HeadInfo)){
			$id=$this->timeaction_head->add();
			$wModeldata=I('post.wModel',null);
			Do_Timeaction_child($this->timeaction, $this->timeaction_child, $wModeldata, $id);
			$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Time/';
			header("Location:$url");
		}else{
			$this->error($this->timeaction_head->getError());
		}
	}
}