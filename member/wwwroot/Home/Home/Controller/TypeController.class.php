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
		$where['wUseID']=session('wUseID');
		$count      = $this->modeltype_head->where(array("wUseID" => session('wUseID')))->count();
	  	$Page       = new \Think\Page($count,10);
	  	$Page->setConfig('header',L('All').'<b>%TOTAL_ROW%</b>'.L('Records').'&nbsp;&nbsp;'.L('The').'<b>%NOW_PAGE%</b>/<b>%TOTAL_PAGE%</b>'.L('Page'));
	  	$Page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
	  	$show       = $Page->show();
		$list = $this->modeltype_head->where(array("wUseID" => session('wUseID')))->order(array('Pid'=>'desc'))->field('wName, Pid')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign("mytype",$list);
		$this->assign('page',$show);
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
			$list = $this->mobilemanager->query("select `McID`, `McName` from `mobilemanager` where `wUseID` ='$wUseID' AND `wMB`='$wMB' AND left(`McID`,2) not in ('12')");
			//$list = $this->mobilemanager->where(array('wUseID' => session('wUseID')))->field('McID, McName')->select();
			$find=$this->modeltype_head->where(array("Pid" => $Pid))->field("wUseID",true)->find();
			if($find){
				$findmodel=$this->modeltype->where(array("wModel" => $find['Pid']))->field('McID')->select();
				$m = TarrayToOarray($findmodel, 'McID');
				$this->assign("checklist",$m);
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
			$wModeldata=I('post.wModel',null);
			for($i=0;$i<count($wModeldata);$i++){
				$data['wModel']=$Pid;
				$data['McID']=$wModeldata[$i];
				$data['wUseID']=session('wUseID');
				$this->modeltype->create();
				$this->modeltype->add($data);
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
		$list = $this->mobilemanager->query("select `McID`, `McName` from `mobilemanager` where `wUseID` ='$wUseID' AND `wMB`='$wMB' AND left(`McID`,2) not in ('12')");
		//$list = $this->mobilemanager->where(array('wUseID' => session('wUseID')))->field('McID, McName')->select();
		$this->assign("myMobile",$list);
		$this->display();
	}
	
	public function typeadd(){
		$HeadInfo = I('post.');
		$HeadInfo['wUseID'] = session('wUseID');
		if($this->modeltype_head->create($HeadInfo)){
			$id=$this->modeltype_head->add();
			$wModeldata=I('post.wModel',null);
			$Model=D("modeltype");
			for($i=0;$i<count($wModeldata);$i++){
				$data['wModel']=$id;
				$data['McID']=$wModeldata[$i];
				$data['wUseID']=session('wUseID');
				$this->modeltype->create();
				$this->modeltype->add($data);
			}
			$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Type/';
			header("Location:$url");
		}else{
			$this->error($this->modeltype_head->getError());
		}
	}
}