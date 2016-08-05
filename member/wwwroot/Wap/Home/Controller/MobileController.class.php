<?php
namespace Home\Controller;
class MobileController extends CommonController{
	protected $mobilemanager;
	protected $modeltype;
	protected $linklist;
	protected $timeaction;
	
	public function _initialize(){
		parent::_initialize();
		$this->mobilemanager = D("Mobilemanager");
		$this->modeltype = D("Modeltype");
		$this->linklist = D("Linklist");
		$this->timeaction = D("Timeaction");
	}
	
	public function index(){	
	  	$list = $this->mobilemanager->where(array('wUseID' => session('wUseID')))->field('Pid, McName')->order(array('Pid'=>'desc'))->select();
	  	$this->assign('my3','btn0_a');
	  	$this->assign("myMobile",$list);
	  	$this->display();
	}	

	public function del(){
		$Pid = intval(I("get.id"));
		$ListPid =  $this->mobilemanager->where(array('wUseID' => session('wUseID')))->field('Pid')->select();
		$ListPidO = TarrayToOarray($ListPid, 'Pid');
		if(in_array($Pid, $ListPidO)){
			$McID = $this->mobilemanager->where(array("Pid" => $Pid , "wUseID"=>session('wUseID')))->getField('McID');
			
			$this->modeltype->where(array('McID' => $McID , 'wUseID' => session('wUseID')))->delete();
			
			$this->timeaction->where(array('McID' => $McID , 'wUseID' => session('wUseID')))->delete();
			
			$this->linklist->where(array("Pid" => $Pid))->delete();
			$this->linklist->where(array("McID" => $Pid))->delete();
			
			if($this->mobilemanager->where(array("Pid" => $Pid , 'wUseID' => session('wUseID')))->delete()){
				$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Mobile/';
				header("Location:$url");
			}else{
				$this->error(L('S_del_e'),U('Mobile/index'));
			}		
		}else{
			$this->error(L('S_parameter_e'));
		}

	}

	public function edit(){
 		$Pid = intval(I('get.id'));
 		if($this->mobilemanager->CheckPid($Pid)){
	 		$where['Pid'] = array('neq', $Pid);
	 		$where['wUseID'] = array('eq', session("wUseID"));
			$list = $this->mobilemanager->where($where)->field('Pid , McName')->order('Item ASC')->select();
			$find = $this->mobilemanager->where(array("Pid" => $Pid))->field('Pid , McName , IsMsg')->find();
			if($find){
			   $findLinkOn = $this->linklist->where(array(McID=>$find['Pid'],wModeltype=>1))->field('Pid')->select();//联动开
			   $findLinkOff = $this->linklist->where(array(McID=>$find['Pid'],wModeltype=>2))->field('Pid')->select();//联动关
			   $findLinkOn_Off = $this->linklist->where(array(McID=>$find['Pid'],wModeltype=>3))->field('Pid')->select();//反联动开
			   $findLinkOff_On = $this->linklist->where(array(McID=>$find['Pid'],wModeltype=>4))->field('Pid')->select();//反联动关
			   
			   $mLinkOn = TarrayToOarray($findLinkOn, 'Pid');
			   $mLinkOff = TarrayToOarray($findLinkOff, 'Pid');
			   $mLinkOn_Off = TarrayToOarray($findLinkOn_Off, 'Pid');
			   $mLinkOff_On = TarrayToOarray($findLinkOff_On, 'Pid');
			   
			   $this->assign("mLinkOn",$mLinkOn);
			   $this->assign("mLinkOff",$mLinkOff);
			   $this->assign("mLinkOn_Off",$mLinkOn_Off);
			   $this->assign("mLinkOff_On",$mLinkOff_On);
			   $this->assign('mobile',$find);
			   $this->assign("myMobile",$list);
			   $this->assign('my3','btn0_a');
			   $this->display();
			}else{
				$this->error(L('S_parameter_e'));
			}
 		}else{
 			$this->error(L('S_parameter_e'));
 		}
	}

	public function update(){		
		$Pid = intval(I('get.id'));
		if($this->mobilemanager->CheckPid($Pid)){
			$data = I('post.');
			$data['wMB'] = session('wMB');
			if($this->mobilemanager->create($data)){
				$this->mobilemanager->where(array("Pid" => $Pid, 'wUseID' => session('wUseID')))->save($data);
			}
			$this->linklist->where(array('McID' => $Pid))->delete();
			$wModelLinkOn = I('post.LinkOn', null);
			$wModelLinkOff = I('post.LinkOff', null);
			$wModelLinkOn_Off = I('post.LinkOn_Off', null);
			$wModelLinkOff_On = I('post.LinkOff_On', null);
		    for($i=0;$i<count($wModelLinkOn);$i++){
			    $data['McID']=$Pid;
				$data['Pid']=$wModelLinkOn[$i];
			    $data['wModeltype']=1;
				$this->linklist->create();
				$this->linklist->add($data);
			}
			for($i=0;$i<count($wModelLinkOff);$i++){
			    $data['McID']=$Pid;
				$data['Pid']=$wModelLinkOff[$i];
			    $data['wModeltype']=2;
				$this->linklist->create();
				$this->linklist->add($data);
			}
			for($i=0;$i<count($wModelLinkOn_Off);$i++){
			    $data['McID']=$Pid;
				$data['Pid']=$wModelLinkOn_Off[$i];
			    $data['wModeltype']=3;
				$this->linklist->create();
				$this->linklist->add($data);
			}
			for($i=0;$i<count($wModelLinkOff_On);$i++){
			    $data['McID']=$Pid;
				$data['Pid']=$wModelLinkOff_On[$i];
			    $data['wModeltype']=4;
				$this->linklist->create();
				$this->linklist->add($data);
			}
			$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Mobile/';
		    header("Location:$url");
			
		}else{
			$this->error(L('S_parameter_e'));
		}
	}
	
	public function usermobile(){
		$wUseID=session('wUseID');
		$Model = M();
		$UserMobile = $Model->query("
			select a.`Pid`, b.`wName` , a.`McName` , `McNumID` , a.`wUseID` ".#13
			"from `mobilemanager` a
			left join `users` b
			on a.`wUseID` = b.`wUseID`".#13
			"where  (a.`McNumID` in ( select `McNumID` from `mobilemanager` where `wUseID` = '$wUseID')
			and a.`wUseID` <>'$wUseID')
			order by  a.`wUseID` ,a.`Item`");
		foreach ($UserMobile as $k => $v){
			if(empty($v['wName'])) { $UserMobile[$k]['wName']= 'null';}
		}
		error_log($UserMobile);
		$this->assign('my11','btn0_a');
		$this->assign('UserMobile' , $UserMobile);
		$this->display();
	}
	
	public function delusermobile(){
		$Pid = I("get.Pid");
		$Model = M();
			if($Model->execute("delete from `mobilemanager` where `Pid` = '$Pid'")){
					$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Mobile/usermobile';
			header("Location:$url");
		}
	}
	
	public function delall(){
		$wUseID = I("get.wUseID");
		$own = session('wUseID');
		$Model = M();
		if($Model->execute("
			DELETE
			from  `mobilemanager`
			where  `McNumID` in (select McNumID from (select McNumID  from mobilemanager where wUseID='$own')a)
			AND wUseID='$wUseID'")){
				$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Mobile/usermobile';
				header("Location:$url");
			}
	}
}