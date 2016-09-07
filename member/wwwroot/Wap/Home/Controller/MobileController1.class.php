<?php
namespace Home\Controller;
class MobileController extends CommonController{
	protected $mobilemanager;
	protected $modeltype;
	protected $linklist;
	protected $timeaction;
	protected $linklist_s;
	
	public function _initialize(){
		parent::_initialize();
		$this->mobilemanager = D("Home/Mobilemanager");
		$this->modeltype = D("Home/Modeltype");
		$this->linklist = D("Home/Linklist");
		$this->timeaction = D("Home/Timeaction");
		$this->linklist_s = D("linklist_s");
	}
	
	public function index(){	
	  	$list = $this->mobilemanager->where(array('wUseID' => session('wUseID')))->field('Pid, McName ,McID')->order(array('Pid'=>'desc'))->select();
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
			$find = $this->mobilemanager->where(array("Pid" => $Pid))->field('Pid , McName , IsMsg , left(`McID`,2) as McID1 , left(`McID`,2) as McID2 , McID')->find();
			$touch = $this->mobilemanager->field('Pid , McID , McName')->where(array('left(`McID`,2)' => 13 ,wUseID => session('wUseID')))->select();
			if($find){
				$findLinkOn = $this->linklist->where(array(McID=>$find['Pid'],wModeltype=>1))->field('Pid')->select();//联动开
				if('14' == $find['McID1']){
					$touchon = $this->linklist_s->where(array('Pid' => $Pid , wModeltype=>1))->field('Key01 , Key02 , Key03 ,McID')->select();
					$touchoff = $this->linklist_s->where(array('Pid' => $Pid , wModeltype=>2))->field('Key01 , Key02 , Key03 ,McID')->select();
					if($touchon){
						foreach ($touchon as $key =>$value){
							if($value['Key01']) $Key01['Key01'] = $value['McID'];
							if($value['Key02']) $Key02['Key02'] = $value['McID'];
							if($value['Key03']) $Key03['Key03'] = $value['McID'];
						}
						$this->assign("Key01",$Key01);
						$this->assign("Key02",$Key02);
						$this->assign("Key03",$Key03);
					}
					if($touchoff){
						foreach ($touchoff as $k => $v){
							if($v['Key01']) $KeyOff01['KeyOff01'] = $v['McID'];
							if($v['Key02']) $KeyOff02['KeyOff02'] = $v['McID'];
							if($v['Key03']) $KeyOff03['KeyOff03'] = $v['McID'];
						}
						$this->assign("KeyOff01",$KeyOff01);
						$this->assign("KeyOff02",$KeyOff02);
						$this->assign("KeyOff03",$KeyOff03);
					}
					$this->assign('McID1' , $find['McID1']);
				}
			   if('01' == $find['McID2']){
			   		$username = session('wUseID');
			   		$McID = $find['McID'];
			   		$sql = "select a.wUserID,a.MCID,a.KeyID,b.KeyName,a.KeyVar 
			   			    from irinfo a left join ircodeinfo b on a.KeyID=right(b.KeyID,7) 
  							where a.wUserID='$username'  
			   				and a.MCID='$McID'  
			   				and BrandNO='RN51F/BG' 
			   				and left(b.KeyName,2)='模式' ORDER BY KeyID;";
			   		$IrinfoList = M()->query($sql);
			   		$SelectIfi = M('irinfo')->where(array('KeyID' => '0000001' , 'wUserID' => session('wUseID') , 'MCID' => $McID))->field('KeyVar')->find();
			   		$this->assign('McID2' , $find['McID']);
			   		$this->assign('KeyVar' , $SelectIfi['KeyVar']);
			   		$this->assign('IrinfoList' , $IrinfoList);
			   	
			    }
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
				$this->assign('touch' , $touch);
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
			if(I("post.McIDIrin")){
				M('irinfo')->where(array('wUserID'=>session('wUseID') , 'KeyID' => '0000001' , 'MCID' => I("post.McIDIrin")))->save(array('KeyVar' => I("post.KeyVar")));
			}
			$this->linklist_s->where(array('Pid' =>$Pid ))->delete();
			if(I("post.key01")&&I("post.hkey01")) $this->linklist_s->data(array('Pid' =>$Pid , 'wModeltype'=>1 , 'McID' => I("post.key01") , Key01 =>1))->add();
			if(I("post.key02")&&I("post.hkey02")) $this->linklist_s->data(array('Pid' =>$Pid , 'wModeltype'=>1 , 'McID' => I("post.key02") , Key02 =>1))->add();
			if(I("post.key03")&&I("post.hkey03")) $this->linklist_s->data(array('Pid' =>$Pid , 'wModeltype'=>1 , 'McID' => I("post.key03") , Key03 =>1))->add();
			
			if(I("post.keyOff01")&&I("post.hkeyOff01")) $this->linklist_s->data(array('Pid' =>$Pid , 'wModeltype'=>2 , 'McID' => I("post.keyOff01") , Key01 =>1))->add();
			if(I("post.keyOff02")&&I("post.hkeyOff02")) $this->linklist_s->data(array('Pid' =>$Pid , 'wModeltype'=>2 , 'McID' => I("post.keyOff02") , Key02 =>1))->add();
			if(I("post.keyOff03")&&I("post.hkeyOff03")) $this->linklist_s->data(array('Pid' =>$Pid , 'wModeltype'=>2 , 'McID' => I("post.keyOff03") , Key03 =>1))->add();
			
			for($i=0;$i<count($wModelLinkOn);$i++){
				$data['McID']=$Pid;
				$data['Pid']=$wModelLinkOn[$i];
				$data['wModeltype']=1;
				$this->linklist->create();
				$id = $this->linklist->add($data);
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
	
	/*
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
	}*/

	/*public function update(){		
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
	}*/
	
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