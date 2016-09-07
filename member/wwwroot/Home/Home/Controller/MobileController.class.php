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
		$this->mobilemanager = D("Mobilemanager");
		$this->modeltype = D("Modeltype");
		$this->linklist = D("Linklist");
		$this->timeaction = D("Timeaction");
		$this->linklist_s = D("linklist_s");
	}
	
	public function index(){	
	  	$where['wUseID']=session('wUseID');
	  	$count      = $this->mobilemanager->where($where)->count();
	  	$Page       = new \Think\Page($count,10);
	  	$Page->setConfig('header',L('All').'<b>%TOTAL_ROW%</b>'.L('Records').'&nbsp;&nbsp;'.L('The').'<b>%NOW_PAGE%</b>/<b>%TOTAL_PAGE%</b>'.L('Page'));
	  	$Page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
	  	$show       = $Page->show(); 
	  	$list = $this->mobilemanager->where($where)->field('Pid, McName, McID')->order(array('Pid'=>'desc'))->limit($Page->firstRow.','.$Page->listRows)->select();
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
			$list = $this->mobilemanager->where($where)->field('Pid , McName')->order('Item ASC')->select();
			$find = $this->mobilemanager->where(array("Pid" => $Pid))->field('Pid , McName , IsMsg , left(`McID`,2) as McID1 , left(`McID`,2) as McID2 , McID')->find();
			if($find){
				if('14' == $find['McID1']){
					$touchlist = $this->linklist_s->where(array('Pid' => $Pid))->field('Key01 , Key02 , Key03 ,McID , wModeltype')->select();
					foreach ($touchlist as $key => $value){
						if(1 == $value['wModeltype']){$touchon[] = $touchlist[$key];}
						if(2 == $value['wModeltype']){$touchoff[] = $touchlist[$key];}
						if(3 == $value['wModeltype']){$touchon_off[] = $touchlist[$key];}
						if(4 == $value['wModeltype']){$touchoff_on[] = $touchlist[$key];}
					}
					if($touchon){
						foreach ($touchon as $key =>$value){
							if($value['Key01']) $Key01[] = $value['McID'];
							if($value['Key02']) $Key02[] = $value['McID'];
							if($value['Key03']) $Key03[] = $value['McID'];
						}
						$this->assign("mLinkOn01",$Key01);
						$this->assign("mLinkOn02",$Key02);
						$this->assign("mLinkOn03",$Key03);
					}
					if($touchoff){
						foreach ($touchoff as $k => $v){
							if($v['Key01']) $KeyOff01[] = $v['McID'];
							if($v['Key02']) $KeyOff02[] = $v['McID'];
							if($v['Key03']) $KeyOff03[] = $v['McID'];
						}
						$this->assign("mLinkOff01",$KeyOff01);
						$this->assign("mLinkOff02",$KeyOff02);
						$this->assign("mLinkOff03",$KeyOff03);
					}
					if($touchon_off){
						foreach ($touchon_off as $k => $v){
							if($v['Key01']) $KeyOn_Off01[] = $v['McID'];
							if($v['Key02']) $KeyOn_Off02[] = $v['McID'];
							if($v['Key03']) $KeyOn_Off03[] = $v['McID'];
						}
						$this->assign("mLinkon_off01",$KeyOn_Off01);
						$this->assign("mLinkon_off02",$KeyOn_Off02);
						$this->assign("mLinkon_off03",$KeyOn_Off03);
					}
					if($touchoff_on){
						foreach ($touchoff_on as $k => $v){
							if($v['Key01']) $KeyOff_On01[] = $v['McID'];
							if($v['Key02']) $KeyOff_On02[] = $v['McID'];
							if($v['Key03']) $KeyOff_On03[] = $v['McID'];
						}
						$this->assign("mLinkoff_on01",$KeyOff_On01);
						$this->assign("mLinkoff_on02",$KeyOff_On02);
						$this->assign("mLinkoff_on03",$KeyOff_On03);
					}
					$this->assign('McID1' , $find['McID1']);
				}else{
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
				$this->assign('mobile',$find);
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
			$McID = $this->mobilemanager->where(array('Pid' => $Pid , 'wUseID' => session('wUseID')))->field('left(`McID`,2) as McID')->find();
			if($this->mobilemanager->create($data)){
				$this->mobilemanager->where(array("Pid" => $Pid, 'wUseID' => session('wUseID')))->save($data);
			}
			if(I("post.McIDIrin")){
				M('irinfo')->where(array('wUserID'=>session('wUseID') , 'KeyID' => '0000001' , 'MCID' => I("post.McIDIrin")))->save(array('KeyVar' => I("post.KeyVar")));
			}
			if(14 == $McID['McID']){
				$this->linklist_s->where(array('Pid' =>$Pid ))->delete();
				$wModelLinkOn01 = I('post.LinkOn01', null);
				$wModelLinkOn02 = I('post.LinkOn02', null);
				$wModelLinkOn03 = I('post.LinkOn03', null);
				for($i=0;$i<count($wModelLinkOn01);$i++){
					$this->linklist_s->add(array('Pid' => $Pid , 'McID' => $wModelLinkOn01[$i] , 'wModeltype' => 1 , 'Key01'=>1));
				}
				for($i=0;$i<count($wModelLinkOn02);$i++){
					$this->linklist_s->add(array('Pid' => $Pid , 'McID' => $wModelLinkOn02[$i] , 'wModeltype' => 1 , 'Key02'=>1));
				}
				for($i=0;$i<count($wModelLinkOn03);$i++){
					$this->linklist_s->add(array('Pid' => $Pid , 'McID' => $wModelLinkOn03[$i] , 'wModeltype' => 1 , 'Key03'=>1));
				}
				$wModelLinkOff01 = I('post.LinkOff01', null);
				$wModelLinkOff02 = I('post.LinkOff02', null);
				$wModelLinkOff03 = I('post.LinkOff03', null);
				for($i=0;$i<count($wModelLinkOff01);$i++){
					$this->linklist_s->add(array('Pid' => $Pid , 'McID' => $wModelLinkOff01[$i] , 'wModeltype' => 2 , 'Key01'=>1));
				}
				for($i=0;$i<count($wModelLinkOff02);$i++){
					$this->linklist_s->add(array('Pid' => $Pid , 'McID' => $wModelLinkOff02[$i] , 'wModeltype' => 2 , 'Key02'=>1));
				}
				for($i=0;$i<count($wModelLinkOff03);$i++){
					$this->linklist_s->add(array('Pid' => $Pid , 'McID' => $wModelLinkOff03[$i] , 'wModeltype' => 2 , 'Key03'=>1));
				}
				$wModelLinkon_off01 = I('post.Linkon_off01', null);
				$wModelLinkon_off02 = I('post.Linkon_off02', null);
				$wModelLinkon_off03 = I('post.Linkon_off03', null);
				for($i=0;$i<count($wModelLinkon_off01);$i++){
					$this->linklist_s->add(array('Pid' => $Pid , 'McID' => $wModelLinkon_off01[$i] , 'wModeltype' => 3 , 'Key01'=>1));
				}
				for($i=0;$i<count($wModelLinkon_off02);$i++){
					$this->linklist_s->add(array('Pid' => $Pid , 'McID' => $wModelLinkon_off02[$i] , 'wModeltype' => 3 , 'Key02'=>1));
				}
				for($i=0;$i<count($wModelLinkon_off03);$i++){
					$this->linklist_s->add(array('Pid' => $Pid , 'McID' => $wModelLinkon_off03[$i] , 'wModeltype' => 3 , 'Key03'=>1));
				}
				
				$wModelLinkoff_on01 = I('post.Linkoff_on01', null);
				$wModelLinkoff_on02 = I('post.Linkoff_on02', null);
				$wModelLinkoff_on03 = I('post.Linkoff_on03', null);
				for($i=0;$i<count($wModelLinkoff_on01);$i++){
					$this->linklist_s->add(array('Pid' => $Pid , 'McID' => $wModelLinkoff_on01[$i] , 'wModeltype' => 4 , 'Key01'=>1));
				}
				for($i=0;$i<count($wModelLinkoff_on02);$i++){
					$this->linklist_s->add(array('Pid' => $Pid , 'McID' => $wModelLinkoff_on02[$i] , 'wModeltype' => 4 , 'Key02'=>1));
				}
				for($i=0;$i<count($wModelLinkoff_on03);$i++){
					$this->linklist_s->add(array('Pid' => $Pid , 'McID' => $wModelLinkoff_on03[$i] , 'wModeltype' => 4 , 'Key03'=>1));
				}
			}else{
				 $this->linklist->where(array('McID' => $Pid))->delete();
				 $wModelLinkOn = I('post.LinkOn', null);
				 $wModelLinkOff = I('post.LinkOff', null);
				 $wModelLinkOn_Off = I('post.LinkOn_Off', null);
				 $wModelLinkOff_On = I('post.LinkOff_On', null); 
				 for($i=0;$i<count($wModelLinkOn);$i++){
					$this->linklist->add(array('McID' => $Pid , 'Pid' => $wModelLinkOn[$i] , 'wModeltype' => 1));
				 }
				 for($i=0;$i<count($wModelLinkOff);$i++){
					$this->linklist->add(array('McID' => $Pid , 'Pid' => $wModelLinkOff[$i] , 'wModeltype' => 2));
				 }
				 for($i=0;$i<count($wModelLinkOn_Off);$i++){
					$this->linklist->add(array('McID' => $Pid , 'Pid' => $wModelLinkOn_Off[$i] , 'wModeltype' => 3));
				 }
				 for($i=0;$i<count($wModelLinkOff_On);$i++){
					$this->linklist->add(array('McID' => $Pid , 'Pid' => $wModelLinkOff_On[$i] , 'wModeltype' => 4));
				 }
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