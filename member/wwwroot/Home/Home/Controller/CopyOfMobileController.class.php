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
	  	$where['wUseID']=session('wUseID');
	  	$count      = $this->mobilemanager->where($where)->count();
	  	$Page       = new \Think\Page($count,10);
	  	$Page->setConfig('header',L('All').'<b>%TOTAL_ROW%</b>'.L('Records').'&nbsp;&nbsp;'.L('The').'<b>%NOW_PAGE%</b>/<b>%TOTAL_PAGE%</b>'.L('Page'));
	  	$Page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
	  	$show       = $Page->show(); 
	  	$list = $this->mobilemanager->where($where)->field('Pid, McName')->order(array('Pid'=>'desc'))->limit($Page->firstRow.','.$Page->listRows)->select();
	  	$this->assign('my3','btn0_a');
	  	$this->assign("myMobile",$list);
	  	$this->assign('page',$show);
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
			$list = $this->mobilemanager->where($where)->field('Pid , McName, left(`McID`,2) as McID1 , McID')->order('Item ASC')->select();
			$find = $this->mobilemanager->where(array("Pid" => $Pid))->field('Pid , McName , IsMsg , left(`McID`,2) as McID1 , McID')->find();
			$touch = $this->linklist->where(array("McID" => $Pid))->field('MtouchID')->find();
			$touch = explode(',' , $touch['MtouchID']);
			if($find){
			   $findLinkOn = $this->linklist->where(array(McID=>$find['Pid'],wModeltype=>1))->field('Pid , StouchID')->select();
			   $findLinkOff = $this->linklist->where(array(McID=>$find['Pid'],wModeltype=>2))->field('Pid , StouchID')->select();
			   $findLinkOn_Off = $this->linklist->where(array(McID=>$find['Pid'],wModeltype=>3))->field('Pid , StouchID')->select();
			   $findLinkOff_On = $this->linklist->where(array(McID=>$find['Pid'],wModeltype=>4))->field('Pid , StouchID')->select();
			   $mLinkOn = TarrayToOarray($findLinkOn, 'Pid');
			   $mLinkOff = TarrayToOarray($findLinkOff, 'Pid');
			   $mLinkOn_Off = TarrayToOarray($findLinkOn_Off, 'Pid');
			   $mLinkOff_On = TarrayToOarray($findLinkOff_On, 'Pid');
			   
			   $mLinkOn_TouchID_merge = $this->mobilemanager->Pid_TouchID_merge_array($findLinkOn);
			   $findLinkOff_TouchID_merge = $this->mobilemanager->Pid_TouchID_merge_array($findLinkOff);
			   $findLinkOn_Off_TouchID_merge = $this->mobilemanager->Pid_TouchID_merge_array($findLinkOn_Off);
			   $findLinkOff_On_TouchID_merge = $this->mobilemanager->Pid_TouchID_merge_array($findLinkOff_On);
			   
			   if('14' == $find['McID1']) $this->assign('McID1' , $find['McID1']);
			   $this->assign("mLinkOn",$mLinkOn);
			   $this->assign("mLinkOff",$mLinkOff);
			   $this->assign("mLinkOn_Off",$mLinkOn_Off);
			   $this->assign("mLinkOff_On",$mLinkOff_On);
			   $this->assign("mLinkOn_TouchID_merge",$mLinkOn_TouchID_merge);
			   $this->assign("findLinkOff_TouchID_merge",$findLinkOff_TouchID_merge);
			   $this->assign("findLinkOn_Off_TouchID_merge",$findLinkOn_Off_TouchID_merge);
			   $this->assign("findLinkOff_On_TouchID_merge",$findLinkOff_On_TouchID_merge);
			   $this->assign('mobile', $find);
			   $this->assign('touch' , $touch);
			   $this->assign("myMobile",$list);
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
			foreach (I('post.') as $k => $v){
				if(strpos($k , 'LinkOn1_') !== false) {
					$SLinkOn[] = substr($k, strlen('LinkOn1_'));
					$arr1[substr($k, strlen('LinkOn1_'))] = implode($v , ',');
				}
				if(strpos($k , 'LinkOff2_') !== false) {
					$LinkOff[] = substr($k, strlen('LinkOff2_'));
					$arr2[substr($k, strlen('LinkOff2_'))] = implode($v , ',');
				}
				if(strpos($k , 'LinkOnOff3_') !== false) {
					$LinkOnOff[] = substr($k, strlen('LinkOnOff3_'));
					$arr3[substr($k, strlen('LinkOnOff3_'))] = implode($v , ',');
				}
				if(strpos($k , 'LinkOffOn4_') !== false) {
					$LinkOffOn[] = substr($k, strlen('LinkOffOn4_'));
					$arr4[substr($k, strlen('LinkOffOn4_'))] = implode($v , ',');
				}
			}
			$touch = implode($data['touch11'], ',');
			$wModelLinkOn = Check_array_merge(I('post.LinkOn', null) , $SLinkOn);
			$wModelLinkOff = Check_array_merge(I('post.LinkOff', null) , $LinkOff);
			$wModelLinkOn_Off = Check_array_merge(I('post.LinkOn_Off', null) , $LinkOnOff);
			$wModelLinkOff_On = Check_array_merge(I('post.LinkOff_On', null) , $LinkOffOn);
		    for($i=0;$i<count($wModelLinkOn);$i++){
			    $data['McID']=$Pid;
				$data['Pid'] = $wModelLinkOn[$i];
			    $data['wModeltype']=1;
			    $data['MtouchID'] = $touch ? $touch : '0';
			    $data['StouchID'] = $arr1[$wModelLinkOn[$i]] ? $arr1[$wModelLinkOn[$i]] : '0';
				$this->linklist->create();
				$this->linklist->add($data);
			}
			for($i=0;$i<count($wModelLinkOff);$i++){
			    $data['McID']=$Pid;
				$data['Pid']=$wModelLinkOff[$i];
			    $data['wModeltype']=2;
			    $data['MtouchID'] = $touch ? $touch : '0';
			    $data['StouchID'] = $arr2[$wModelLinkOff[$i]] ? $arr2[$wModelLinkOff[$i]] : '0';
				$this->linklist->create();
				$this->linklist->add($data);
			}
			for($i=0;$i<count($wModelLinkOn_Off);$i++){
			    $data['McID']=$Pid;
				$data['Pid']=$wModelLinkOn_Off[$i];
			    $data['wModeltype']=3;
			    $data['MtouchID'] = $touch ? $touch : '0';
			    $data['StouchID'] = $arr3[$wModelLinkOn_Off[$i]] ? $arr3[$wModelLinkOn_Off[$i]] : '0';
				$this->linklist->create();
				$this->linklist->add($data);
			}
			for($i=0;$i<count($wModelLinkOff_On);$i++){
			    $data['McID']=$Pid;
				$data['Pid']=$wModelLinkOff_On[$i];
			    $data['wModeltype']=4;
			    $data['MtouchID'] = $touch ? $touch : '0';
			    $data['StouchID'] = $arr4[$wModelLinkOff_On[$i]] ? $arr4[$wModelLinkOff_On[$i]] : '0';
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