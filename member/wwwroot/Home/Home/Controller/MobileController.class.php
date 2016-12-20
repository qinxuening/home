<?php
namespace Home\Controller;
class MobileController extends CommonController{
	protected $mobilemanager;
	protected $modeltype;
	protected $linklist;
	protected $timeaction;
	protected $linklist_s;
	protected $linklist_child;
	protected $modeltype_child;
	protected $linklist_temp;
	protected $linklist_temp_child;
	
	public function _initialize(){
		parent::_initialize();
		$this->mobilemanager = D("Mobilemanager");
		$this->modeltype = D("Modeltype");
		$this->modeltype_child = D("modeltype_child");
		$this->linklist = D("Linklist");
		$this->timeaction = D("Timeaction");
		$this->linklist_s = D("linklist_s");
		$this->linklist_child = D("linklist_child");
		$this->linklist_temp = D("linklist_temp");
		$this->linklist_temp_child = D("linklist_temp_child");
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
			$this->modeltype_child->where(array('McID' => $McID , 'wUseID' => session('wUseID')))->delete();
			
			
			$this->timeaction->where(array('McID' => $McID , 'wUseID' => session('wUseID')))->delete();
			M('timeaction_child')->where(array('McID' => $McID , 'wUseID' => session('wUseID')))->delete();
			
			$this->linklist->where(array("Pid" => $Pid))->delete();
			$this->linklist->where(array("McID" => $Pid))->delete();
			
			$this->linklist_s->where(array("Pid" => $Pid))->delete();
			$this->linklist_s->where(array("McID" => $Pid))->delete();
			
			$this->linklist_child->where(array(array("McID" => $Pid)))->delete();
			
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
			$list = $this->mobilemanager->where($where)->field('Pid , McName, left(`McID`,2) as McID3')->order('Item ASC')->select();
			$find = $this->mobilemanager->where(array("Pid" => $Pid))->field('Pid , McName , IsMsg , left(`McID`,2) as McID1 , left(`McID`,2) as McID2 , McID, shake')->find();
			if($find){
				if('14' == $find['McID1']){
					$touchlist = $this->linklist_s->join("LEFT JOIN `linklist_child` c on `linklist_s`.wID = c.wID and c.mark = 2")->where(array("`linklist_s`".".Pid" =>$find['Pid']))->field('Key01 , Key02 , Key03 , Key1, Key2, Key3, `linklist_s`.McID , wModeltype')->select();
					$touchlist_temp = $this->linklist_s->join("JOIN `linklist_temp_child` c on `linklist_s`.wID = c.wID and c.mark = 2")->where(array("`linklist_s`".".Pid" =>$find['Pid']))->field('Key01 , Key02 , Key03 , Th, Tl, Hh, Hl, Tf, `linklist_s`.McID , wModeltype')->select();
					foreach ($touchlist as $key => $value){
						if(1 == $value['wModeltype']){$touchon[] = $touchlist[$key];}
						if(2 == $value['wModeltype']){$touchoff[] = $touchlist[$key];}
						if(3 == $value['wModeltype']){$touchon_off[] = $touchlist[$key];}
						if(4 == $value['wModeltype']){$touchoff_on[] = $touchlist[$key];}
					}
					if($touchon){
						foreach ($touchon as $key =>$value){
							if($value['Key01']) {$Key01[] = $value['McID'];$Key_mLinkOn01[] = $touchon[$key];}
							if($value['Key02']) {$Key02[] = $value['McID'];$Key_mLinkOn02[] = $touchon[$key];}
							if($value['Key03']) {$Key03[] = $value['McID'];$Key_mLinkOn03[] = $touchon[$key];}
						}
						$this->assign("mLinkOn01",$Key01);
						$this->assign("mLinkOn02",$Key02);
						$this->assign("mLinkOn03",$Key03);
						$this->assign("Key_mLinkOn01", key_Pid_value_Key($Key_mLinkOn01, 'McID'));$this->assign("temp_mLinkOn01", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Key01', 1));
						$this->assign("Key_mLinkOn02", key_Pid_value_Key($Key_mLinkOn02, 'McID'));$this->assign("temp_mLinkOn02", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Key02', 1));
						$this->assign("Key_mLinkOn03", key_Pid_value_Key($Key_mLinkOn03, 'McID'));$this->assign("temp_mLinkOn03", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Key03', 1));
					}
					if($touchoff){
						foreach ($touchoff as $k => $v){
							if($v['Key01']) {$KeyOff01[] = $v['McID'];$Key_mLinkOff01[] = $touchoff[$k];}
							if($v['Key02']) {$KeyOff02[] = $v['McID'];$Key_mLinkOff02[] = $touchoff[$k];}
							if($v['Key03']) {$KeyOff03[] = $v['McID'];$Key_mLinkOff03[] = $touchoff[$k];}
						}
						$this->assign("mLinkOff01",$KeyOff01);
						$this->assign("mLinkOff02",$KeyOff02);
						$this->assign("mLinkOff03",$KeyOff03);
						
						$this->assign("Key_mLinkOff01", key_Pid_value_Key($Key_mLinkOff01, 'McID'));$this->assign("temp_mLinkOff01", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Key01', 2));
						$this->assign("Key_mLinkOff02", key_Pid_value_Key($Key_mLinkOff02, 'McID'));$this->assign("temp_mLinkOff02", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Key02', 2));
						$this->assign("Key_mLinkOff03", key_Pid_value_Key($Key_mLinkOff03, 'McID'));$this->assign("temp_mLinkOff03", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Key03', 2));																		
					}
					if($touchon_off){
						foreach ($touchon_off as $k => $v){
							if($v['Key01']) {$KeyOn_Off01[] = $v['McID'];$Key_mLink_On_Off01[] = $touchon_off[$k];}
							if($v['Key02']) {$KeyOn_Off02[] = $v['McID'];$Key_mLink_On_Off02[] = $touchon_off[$k];}
							if($v['Key03']) {$KeyOn_Off03[] = $v['McID'];$Key_mLink_On_Off03[] = $touchon_off[$k];}
						}
						$this->assign("mLinkon_off01",$KeyOn_Off01);
						$this->assign("mLinkon_off02",$KeyOn_Off02);
						$this->assign("mLinkon_off03",$KeyOn_Off03);
						
						$this->assign("Key_mLink_On_Off01", key_Pid_value_Key($Key_mLink_On_Off01, 'McID'));$this->assign("temp_mLink_On_Off01", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Key01', 3));
						$this->assign("Key_mLink_On_Off02", key_Pid_value_Key($Key_mLink_On_Off02, 'McID'));$this->assign("temp_mLink_On_Off02", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Key02', 3));
						$this->assign("Key_mLink_On_Off03", key_Pid_value_Key($Key_mLink_On_Off03, 'McID'));$this->assign("temp_mLink_On_Off03", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Key03', 3));					
					}
					if($touchoff_on){
						foreach ($touchoff_on as $k => $v){
							if($v['Key01']) {$KeyOff_On01[] = $v['McID'];$Key_mLink_Off_On01[] = $touchoff_on[$k];}
							if($v['Key02']) {$KeyOff_On02[] = $v['McID'];$Key_mLink_Off_On02[] = $touchoff_on[$k];}
							if($v['Key03']) {$KeyOff_On03[] = $v['McID'];$Key_mLink_Off_On03[] = $touchoff_on[$k];}
						}
						$this->assign("mLinkoff_on01",$KeyOff_On01);
						$this->assign("mLinkoff_on02",$KeyOff_On02);
						$this->assign("mLinkoff_on03",$KeyOff_On03);
										
						$this->assign("Key_mLink_Off_On01", key_Pid_value_Key($Key_mLink_Off_On01, 'McID'));$this->assign("temp_mLink_Off_On01", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Key01', 4));
						$this->assign("Key_mLink_Off_On02", key_Pid_value_Key($Key_mLink_Off_On02, 'McID'));$this->assign("temp_mLink_Off_On02", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Key02', 4));
						$this->assign("Key_mLink_Off_On03", key_Pid_value_Key($Key_mLink_Off_On03, 'McID'));$this->assign("temp_mLink_Off_On03", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Key03', 4));							
					}
				}else if ('19' == $find['McID1']){
					$touchlist = $this->linklist_temp->join("LEFT JOIN `linklist_child` c on `linklist_temp`.wID = c.wID and c.mark = 3")->where(array("`linklist_temp`".".Pid" =>$find['Pid']))->field('Th0 , Tl0 , Hh0 , Hl0, Tf0, Key1, Key2, Key3, `linklist_temp`.McID , wModeltype')->select();
					$touchlist_temp = $this->linklist_temp->join("JOIN `linklist_temp_child` c on `linklist_temp`.wID = c.wID and c.mark = 1")->where(array("`linklist_temp`".".Pid" =>$find['Pid']))->field('Th0 , Tl0 , Hh0 , Hl0, Tf0 , Th, Tl, Hh, Hl, Tf, `linklist_temp`.McID , wModeltype')->select();
					foreach ($touchlist as $key => $value){
						if(1 == $value['wModeltype']){$touchon[] = $touchlist[$key];}
						if(2 == $value['wModeltype']){$touchoff[] = $touchlist[$key];}
						if(3 == $value['wModeltype']){$touchon_off[] = $touchlist[$key];}
						if(4 == $value['wModeltype']){$touchoff_on[] = $touchlist[$key];}
					}
					if($touchon){
						foreach ($touchon as $key =>$value){
							if($value['Th0']) {$Key01[] = $value['McID'];$Key_mLinkOn01[] = $touchon[$key];}
							if($value['Tl0']) {$Key02[] = $value['McID'];$Key_mLinkOn02[] = $touchon[$key];}
							if($value['Hh0']) {$Key03[] = $value['McID'];$Key_mLinkOn03[] = $touchon[$key];}
							if($value['Hl0']) {$Key04[] = $value['McID'];$Key_mLinkOn04[] = $touchon[$key];}
							if($value['Tf0']) {$Key05[] = $value['McID'];$Key_mLinkOn05[] = $touchon[$key];}
						}
						$this->assign("mLinkOn01",$Key01);
						$this->assign("mLinkOn02",$Key02);
						$this->assign("mLinkOn03",$Key03);
						$this->assign("mLinkOn04",$Key04);
						$this->assign("mLinkOn05",$Key05);
						$this->assign("Key_mLinkOn01", key_Pid_value_Key($Key_mLinkOn01, 'McID'));$this->assign("temp_mLinkOn01", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Th0', 1));
						$this->assign("Key_mLinkOn02", key_Pid_value_Key($Key_mLinkOn02, 'McID'));$this->assign("temp_mLinkOn02", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Tl0', 1));
						$this->assign("Key_mLinkOn03", key_Pid_value_Key($Key_mLinkOn03, 'McID'));$this->assign("temp_mLinkOn03", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Hh0', 1));
						$this->assign("Key_mLinkOn04", key_Pid_value_Key($Key_mLinkOn04, 'McID'));$this->assign("temp_mLinkOn04", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Hl0', 1));
						$this->assign("Key_mLinkOn05", key_Pid_value_Key($Key_mLinkOn05, 'McID'));$this->assign("temp_mLinkOn05", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Tf0', 1));
					}
					if($touchoff){
						foreach ($touchoff as $k => $v){
							if($v['Th0']) {$KeyOff01[] = $v['McID'];$Key_mLinkOff01[] = $touchoff[$k];}
							if($v['Tl0']) {$KeyOff02[] = $v['McID'];$Key_mLinkOff02[] = $touchoff[$k];}
							if($v['Hh0']) {$KeyOff03[] = $v['McID'];$Key_mLinkOff03[] = $touchoff[$k];}
							if($v['Hl0']) {$KeyOff04[] = $v['McID'];$Key_mLinkOff04[] = $touchoff[$k];}
							if($v['Tf0']) {$KeyOff05[] = $v['McID'];$Key_mLinkOff05[] = $touchoff[$k];}
						}
						$this->assign("mLinkOff01",$KeyOff01);
						$this->assign("mLinkOff02",$KeyOff02);
						$this->assign("mLinkOff03",$KeyOff03);
						$this->assign("mLinkOff04",$KeyOff04);
						$this->assign("mLinkOff05",$KeyOff05);
					
						$this->assign("Key_mLinkOff01", key_Pid_value_Key($Key_mLinkOff01, 'McID'));$this->assign("temp_mLinkOff01", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Th0', 2));
						$this->assign("Key_mLinkOff02", key_Pid_value_Key($Key_mLinkOff02, 'McID'));$this->assign("temp_mLinkOff02", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Tl0', 2));
						$this->assign("Key_mLinkOff03", key_Pid_value_Key($Key_mLinkOff03, 'McID'));$this->assign("temp_mLinkOff03", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Hh0', 2));
						$this->assign("Key_mLinkOff04", key_Pid_value_Key($Key_mLinkOff04, 'McID'));$this->assign("temp_mLinkOff04", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Hl0', 2));
						$this->assign("Key_mLinkOff05", key_Pid_value_Key($Key_mLinkOff05, 'McID'));$this->assign("temp_mLinkOff05", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Tf0', 2));
					}
					if($touchon_off){
						foreach ($touchon_off as $k => $v){
							if($v['Th0']) {$KeyOn_Off01[] = $v['McID'];$Key_mLink_On_Off01[] = $touchon_off[$k];}
							if($v['Tl0']) {$KeyOn_Off02[] = $v['McID'];$Key_mLink_On_Off02[] = $touchon_off[$k];}
							if($v['Hh0']) {$KeyOn_Off03[] = $v['McID'];$Key_mLink_On_Off03[] = $touchon_off[$k];}
							if($v['Hl0']) {$KeyOn_Off04[] = $v['McID'];$Key_mLink_On_Off04[] = $touchon_off[$k];}
							if($v['Tf0']) {$KeyOn_Off05[] = $v['McID'];$Key_mLink_On_Off05[] = $touchon_off[$k];}
						}
						$this->assign("mLinkon_off01",$KeyOn_Off01);
						$this->assign("mLinkon_off02",$KeyOn_Off02);
						$this->assign("mLinkon_off03",$KeyOn_Off03);
						$this->assign("mLinkon_off04",$KeyOn_Off04);
						$this->assign("mLinkon_off05",$KeyOn_Off05);
					
						$this->assign("Key_mLink_On_Off01", key_Pid_value_Key($Key_mLink_On_Off01, 'McID'));$this->assign("temp_mLink_On_Off01", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Th0', 3));
						$this->assign("Key_mLink_On_Off02", key_Pid_value_Key($Key_mLink_On_Off02, 'McID'));$this->assign("temp_mLink_On_Off02", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Tl0', 3));
						$this->assign("Key_mLink_On_Off03", key_Pid_value_Key($Key_mLink_On_Off03, 'McID'));$this->assign("temp_mLink_On_Off03", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Hh0', 3));
						$this->assign("Key_mLink_On_Off04", key_Pid_value_Key($Key_mLink_On_Off04, 'McID'));$this->assign("temp_mLink_On_Off04", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Hl0', 3));
						$this->assign("Key_mLink_On_Off05", key_Pid_value_Key($Key_mLink_On_Off05, 'McID'));$this->assign("temp_mLink_On_Off05", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Tf0', 3));
					}
					if($touchoff_on){
						foreach ($touchoff_on as $k => $v){
							if($v['Th0']) {$KeyOff_On01[] = $v['McID'];$Key_mLink_Off_On01[] = $touchoff_on[$k];}
							if($v['Tl0']) {$KeyOff_On02[] = $v['McID'];$Key_mLink_Off_On02[] = $touchoff_on[$k];}
							if($v['Hh0']) {$KeyOff_On03[] = $v['McID'];$Key_mLink_Off_On03[] = $touchoff_on[$k];}
							if($v['Hl0']) {$KeyOff_On04[] = $v['McID'];$Key_mLink_Off_On04[] = $touchoff_on[$k];}
							if($v['Tf0']) {$KeyOff_On05[] = $v['McID'];$Key_mLink_Off_On05[] = $touchoff_on[$k];}
						}
						$this->assign("mLinkoff_on01",$KeyOff_On01);
						$this->assign("mLinkoff_on02",$KeyOff_On02);
						$this->assign("mLinkoff_on03",$KeyOff_On03);
						$this->assign("mLinkoff_on04",$KeyOff_On04);
						$this->assign("mLinkoff_on05",$KeyOff_On05);
					
						$this->assign("Key_mLink_Off_On01", key_Pid_value_Key($Key_mLink_Off_On01, 'McID'));$this->assign("temp_mLink_Off_On01", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Th0', 4));
						$this->assign("Key_mLink_Off_On02", key_Pid_value_Key($Key_mLink_Off_On02, 'McID'));$this->assign("temp_mLink_Off_On02", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Tl0', 4));
						$this->assign("Key_mLink_Off_On03", key_Pid_value_Key($Key_mLink_Off_On03, 'McID'));$this->assign("temp_mLink_Off_On03", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Hh0', 4));
						$this->assign("Key_mLink_Off_On04", key_Pid_value_Key($Key_mLink_Off_On04, 'McID'));$this->assign("temp_mLink_Off_On04", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Hl0', 4));
						$this->assign("Key_mLink_Off_On05", key_Pid_value_Key($Key_mLink_Off_On05, 'McID'));$this->assign("temp_mLink_Off_On05", key_Pid_value_Key_temp($touchlist_temp, 'McID', 'Tf0', 4));
					}
				}else{
					$findLinkOn = $this->linklist->join("LEFT JOIN `linklist_child` c on `linklist`.wID = c.wID and c.mark = 1")->where(array("`linklist`".".McID" =>$find['Pid'],wModeltype=>1))->field('linklist.Pid, Key1, Key2, Key3')->select();//联动开
					$findLinkOff = $this->linklist->join("LEFT JOIN `linklist_child` c on `linklist`.wID = c.wID and c.mark = 1")->where(array("`linklist`".".McID" =>$find['Pid'],wModeltype=>2))->field('linklist.Pid, Key1, Key2, Key3')->select();//联动关
					$findLinkOn_Off = $this->linklist->join("LEFT JOIN `linklist_child` c on `linklist`.wID = c.wID and c.mark = 1")->where(array("`linklist`".".McID" =>$find['Pid'],wModeltype=>3))->field('linklist.Pid, Key1, Key2, Key3')->select();//反联动开
					$findLinkOff_On = $this->linklist->join("LEFT JOIN `linklist_child` c on `linklist`.wID = c.wID and c.mark = 1")->where(array("`linklist`".".McID" =>$find['Pid'],wModeltype=>4))->field('linklist.Pid, Key1, Key2, Key3')->select();//反联动关
					$touchlist_temp = $this->linklist->join("JOIN `linklist_temp_child` c on `linklist`.wID = c.wID and c.mark = 3")->where(array("`linklist`".".McID" =>$find['Pid']))->field('Th, Tl, Hh, Hl, Tf, `linklist`.Pid , wModeltype')->select();

					$mLinkOn = TarrayToOarray($findLinkOn, 'Pid');
					$mLinkOff = TarrayToOarray($findLinkOff, 'Pid');
					$mLinkOn_Off = TarrayToOarray($findLinkOn_Off, 'Pid');
					$mLinkOff_On = TarrayToOarray($findLinkOff_On, 'Pid');
					
					$this->assign("mLinkOn",$mLinkOn);
					$this->assign("mLinkOff",$mLinkOff);
					$this->assign("mLinkOn_Off",$mLinkOn_Off);
					$this->assign("mLinkOff_On",$mLinkOff_On);
					$this->assign("Key_mLinkOn",key_Pid_value_Key($findLinkOn, 'Pid'));$this->assign("temp_mLinkOn", key_other_temp($touchlist_temp, 'Pid', 1));
					$this->assign("Key_mLinkOff",key_Pid_value_Key($findLinkOff, 'Pid'));$this->assign("temp_mLinkOff", key_other_temp($touchlist_temp, 'Pid', 2));
					$this->assign("Key_mLinkOn_Off",key_Pid_value_Key($findLinkOn_Off, 'Pid'));$this->assign("temp_mLinkOn_Off", key_other_temp($touchlist_temp, 'Pid', 3));
					$this->assign("Key_mLinkOff_On",key_Pid_value_Key($findLinkOff_On, 'Pid'));$this->assign("temp_mLinkOff_On", key_other_temp($touchlist_temp, 'Pid', 4));
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
			    
			    $this->assign('shakelist',array('1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5,'6'=>6,'7'=>7,'8'=>8,'9'=>9));
				$this->assign('mobile',$find);
				$this->assign('McID1' , $find['McID1']);
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
		//print_r(I('post.'));die();
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
				$this->linklist_child->where(array('McID' => $Pid))->delete();
				$this->linklist_temp_child->where(array('McID' => $Pid))->delete();
				add_linklist_linklist_child($this->linklist_s,$this->linklist_child, $this->linklist_temp_child, I('post.LinkOn01', null), $Pid, 1, 1, 0, 0);
				add_linklist_linklist_child($this->linklist_s,$this->linklist_child, $this->linklist_temp_child, I('post.LinkOn02', null), $Pid, 1, 0, 1, 0);
				add_linklist_linklist_child($this->linklist_s,$this->linklist_child, $this->linklist_temp_child, I('post.LinkOn03', null), $Pid, 1, 0, 0, 1);
				
				add_linklist_linklist_child($this->linklist_s,$this->linklist_child, $this->linklist_temp_child, I('post.LinkOff01', null), $Pid, 2, 1, 0, 0);
				add_linklist_linklist_child($this->linklist_s,$this->linklist_child, $this->linklist_temp_child, I('post.LinkOff02', null), $Pid, 2, 0, 1, 0);
				add_linklist_linklist_child($this->linklist_s,$this->linklist_child, $this->linklist_temp_child, I('post.LinkOff03', null), $Pid, 2, 0, 0, 1);

				add_linklist_linklist_child($this->linklist_s,$this->linklist_child, $this->linklist_temp_child, I('post.Linkon_off01', null), $Pid, 3, 1, 0, 0);
				add_linklist_linklist_child($this->linklist_s,$this->linklist_child, $this->linklist_temp_child, I('post.Linkon_off02', null), $Pid, 3, 0, 1, 0);
				add_linklist_linklist_child($this->linklist_s,$this->linklist_child, $this->linklist_temp_child, I('post.Linkon_off03', null), $Pid, 3, 0, 0, 1);
				
				add_linklist_linklist_child($this->linklist_s,$this->linklist_child, $this->linklist_temp_child, I('post.Linkoff_on01', null), $Pid, 4, 1, 0, 0);
				add_linklist_linklist_child($this->linklist_s,$this->linklist_child, $this->linklist_temp_child, I('post.Linkoff_on02', null), $Pid, 4, 0, 1, 0);
				add_linklist_linklist_child($this->linklist_s,$this->linklist_child, $this->linklist_temp_child, I('post.Linkoff_on03', null), $Pid, 4, 0, 0, 1);
				
			}else if(19 == $McID['McID']){
				$this->linklist_temp->where(array('Pid' =>$Pid ))->delete();
				$this->linklist_child->where(array('McID' => $Pid))->delete();
				$this->linklist_temp_child->where(array('McID' => $Pid))->delete();
				add_linklist_temp($this->linklist_temp, $this->linklist_child, $this->linklist_temp_child, I('post.LinkOn01', null), $Pid, 1, 1, 0, 0, 0, 0);
				add_linklist_temp($this->linklist_temp, $this->linklist_child, $this->linklist_temp_child, I('post.LinkOn02', null), $Pid, 1, 0, 1, 0, 0, 0);
				add_linklist_temp($this->linklist_temp, $this->linklist_child, $this->linklist_temp_child, I('post.LinkOn03', null), $Pid, 1, 0, 0, 1, 0, 0);
				add_linklist_temp($this->linklist_temp, $this->linklist_child, $this->linklist_temp_child, I('post.LinkOn04', null), $Pid, 1, 0, 0, 0, 1, 0);
				add_linklist_temp($this->linklist_temp, $this->linklist_child, $this->linklist_temp_child, I('post.LinkOn05', null), $Pid, 1, 0, 0, 0, 0, 1);
				
				add_linklist_temp($this->linklist_temp, $this->linklist_child, $this->linklist_temp_child, I('post.LinkOff01', null), $Pid, 2, 1, 0, 0, 0, 0);
				add_linklist_temp($this->linklist_temp, $this->linklist_child, $this->linklist_temp_child, I('post.LinkOff02', null), $Pid, 2, 0, 1, 0, 0, 0);
				add_linklist_temp($this->linklist_temp, $this->linklist_child, $this->linklist_temp_child, I('post.LinkOff03', null), $Pid, 2, 0, 0, 1, 0, 0);
				add_linklist_temp($this->linklist_temp, $this->linklist_child, $this->linklist_temp_child, I('post.LinkOff04', null), $Pid, 2, 0, 0, 0, 1, 0);
				add_linklist_temp($this->linklist_temp, $this->linklist_child, $this->linklist_temp_child, I('post.LinkOff05', null), $Pid, 2, 0, 0, 0, 0, 1);	

				add_linklist_temp($this->linklist_temp, $this->linklist_child, $this->linklist_temp_child, I('post.Linkon_off01', null), $Pid, 3, 1, 0, 0, 0, 0);
				add_linklist_temp($this->linklist_temp, $this->linklist_child, $this->linklist_temp_child, I('post.Linkon_off02', null), $Pid, 3, 0, 1, 0, 0, 0);
				add_linklist_temp($this->linklist_temp, $this->linklist_child, $this->linklist_temp_child, I('post.Linkon_off03', null), $Pid, 3, 0, 0, 1, 0, 0);
				add_linklist_temp($this->linklist_temp, $this->linklist_child, $this->linklist_temp_child, I('post.Linkon_off04', null), $Pid, 3, 0, 0, 0, 1, 0);
				add_linklist_temp($this->linklist_temp, $this->linklist_child, $this->linklist_temp_child, I('post.Linkon_off05', null), $Pid, 3, 0, 0, 0, 0, 1);
				
				add_linklist_temp($this->linklist_temp, $this->linklist_child, $this->linklist_temp_child, I('post.Linkoff_on01', null), $Pid, 4, 1, 0, 0, 0, 0);
				add_linklist_temp($this->linklist_temp, $this->linklist_child, $this->linklist_temp_child, I('post.Linkoff_on02', null), $Pid, 4, 0, 1, 0, 0, 0);
				add_linklist_temp($this->linklist_temp, $this->linklist_child, $this->linklist_temp_child, I('post.Linkoff_on03', null), $Pid, 4, 0, 0, 1, 0, 0);
				add_linklist_temp($this->linklist_temp, $this->linklist_child, $this->linklist_temp_child, I('post.Linkoff_on04', null), $Pid, 4, 0, 0, 0, 1, 0);
				add_linklist_temp($this->linklist_temp, $this->linklist_child, $this->linklist_temp_child, I('post.Linkoff_on05', null), $Pid, 4, 0, 0, 0, 0, 1);
			}else{
				 $this->linklist->where(array('McID' => $Pid))->delete();
				 $this->linklist_child->where(array('McID' => $Pid))->delete();
				 $this->linklist_temp_child->where(array('McID' => $Pid))->delete();
				 
				 add_linklist2_linklist_child($this->linklist, $this->linklist_child, $this->linklist_temp_child, I('post.LinkOn', null), $Pid, 1);
				 add_linklist2_linklist_child($this->linklist, $this->linklist_child, $this->linklist_temp_child, I('post.LinkOff', null), $Pid, 2);
				 add_linklist2_linklist_child($this->linklist, $this->linklist_child, $this->linklist_temp_child, I('post.LinkOn_Off', null), $Pid, 3);
				 add_linklist2_linklist_child($this->linklist, $this->linklist_child, $this->linklist_temp_child, I('post.LinkOff_On', null), $Pid, 4);
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