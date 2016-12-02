<?php
class MobileAction extends Action {
	public function _initialize(){
		header("Content-Type:text/html;charset=utf-8");
		$this->assign('langue',L('langue'));
		if(!session('?wUseID')){
			header("Location:".__APP__."/");
		}else{
			$User=M('Users');
			$where['pid']=session('pid');
			$user=$User->where($where)->find();	
			if($user){
				$this->assign("User",$user);
			}
		}
	}
	
  public function index(){	
	  	$Mobilemanager=D("mobilemanager");
	  	import('ORG.Util.Page');
	  	$where['wMB']=session('wMB');
	  	$where['wUseID']=session('wUseID');
	  	$count      = $Mobilemanager->where($where)->count();
		$Page       = new Page($count,10);
		$Page->setConfig('header',L('Records'));
		$Page->setConfig('prev',L('Prev'));
		$Page->setConfig('next',L('Next'));
		$Page->setConfig('first',L('First'));
		$Page->setConfig('last',L('Last'));
		$Page->setConfig("theme","%totalRow% %header% %nowPage%/%totalPage% ".L('Page')."%upPage% %downPage% %first% %prePage% %linkPage% %nextPage% %end%");
		$show       = $Page->show();	  
	  	$list = $Mobilemanager->where($where)->order(array('Pid'=>'desc'))->limit($Page->firstRow.','.$Page->listRows)->select();
	  	$this->assign('my3','btn0_a');
	  	$this->assign("myMobile",$list);
	  	$this->assign('page',$show);
	  	$this->display(); 
	}	
	
   //删除设备
	public function del(){
		$Pid=$this->_param('id');
		$Data=D("mobilemanager");
		$map['Pid']=array('eq',$Pid);
		$maplink['McID']=array('eq',$Pid);
		$find=$Data->where($map)->find();
		$maps['McID']=array('eq',$find['McID']);
		$maps['wUseID']=session('wUseID');
		
		//删除模式
		$Datamodeltype=D("modeltype");
		$Datamodeltype->where($maps)->delete();
		
		//删除联动关联
		$linkdata=D("linklist");
		$linkdata->where($map)->delete();//Pid
		$linkdata->where($maplink)->delete();//McID
		
		//删除我的时间
		$Datatimeaction=D("timeaction");
		$Datatimeaction->where($maps)->delete();

		if($Data->where($map)->delete()){
			$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Mobile/';
			header("Location:$url");
		}else{
			$this->error(L('S_del_e'),U('Mobile/index'));
		}
	}
	
  //编辑设备
  public function edit(){
		$Pid=$this->_param('id');
		$Mobilemanager=D("mobilemanager");
		$where['wMB']=session('wMB');
		$where['wUseID']=session('wUseID');
		$where['Pid'] = array('neq',$Pid);
		$list=$Mobilemanager->where($where)->order('Item ASC')->select();
		$map['Pid']=array('eq',$Pid);
		$find=$Mobilemanager->where($map)->find();//查找主设备
		if($find){
		   //读取联动
		   $Model=D("linklist");
		   $findLinkOn=$Model->where(array(McID=>$find['Pid'],wModeltype=>1))->select();//联动关
		   $findLinkOff=$Model->where(array(McID=>$find['Pid'],wModeltype=>2))->select();//联动关
		   $findLinkOn_Off=$Model->where(array(McID=>$find['Pid'],wModeltype=>3))->select();//反联动开
		   $findLinkOff_On=$Model->where(array(McID=>$find['Pid'],wModeltype=>4))->select();//反联动关
		   $mLinkOn=array();
		   $mLinkOff=array();
		   $mLinkOn_Off=array();
		   $mLinkOff_On=array();
		   foreach($findLinkOn as $k=>$v){
           $mLinkOn[$k]=$v['Pid'];//联动开pid(副设备Pid,主设备McID)
           }
		   foreach($findLinkOff as $k=>$v){
           $mLinkOff[$k]=$v['Pid'];
           }
		   foreach($findLinkOn_Off as $k=>$v){
           $mLinkOn_Off[$k]=$v['Pid'];
           }
		   foreach($findLinkOff_On as $k=>$v){
           $mLinkOff_On[$k]=$v['Pid'];
           }
		    $this->assign("mLinkOn",$mLinkOn);
			$this->assign("mLinkOff",$mLinkOff);
			$this->assign("mLinkOn_Off",$mLinkOn_Off);
			$this->assign("mLinkOff_On",$mLinkOff_On);
			$this->assign('mobile',$find);
			$this->assign("myMobile",$list);
			$this->display();
		}else{
			$this->error(L('S_parameter_e'));
		}
	}
	//更新设备
	public function update(){		
		$Pid=$this->_get('id');
		$Data=M("mobilemanager");
		$map['Pid']=array('eq',$Pid);
		$where['wMB']=session('wMB');
		$where['wUseID']=session('wUseID');
		$list=$Data->where($where)->order('Item ASC')->select();//查找属于$where['wUseID']用户的设备
		$map['Pid']=array('eq',$Pid);
		$find=$Data->where($map)->find();//查找主设备	
		$arr = array();
		foreach ($list as $key=>$value) {
			$arr[$key] = $value['McName'];
		}
		if(!mb_strlen($_POST['McName'])) {
			$this->error(L('Equipment_position_n'),U('/Type/edit/id/'.$Pid));
		}
		if(($_POST['McName'] != $find['McName'])&&in_array($_POST['McName'], $arr)) {
			$this->error(L('Equipment_position_z'));
		}
		$data=$Data->create();
		$Data->where($map)->save($data);
		$Model=D("linklist");
		$Model->where(array(McID=>$Pid))->delete();
			$wModelLinkOn=$_POST['LinkOn'];
			$wModelLinkOff=$_POST['LinkOff'];
			$wModelLinkOn_Off=$_POST['LinkOn_Off'];
			$wModelLinkOff_On=$_POST['LinkOff_On'];
	    for($i=0;$i<count($wModelLinkOn);$i++){
	    $data['McID']=$Pid;
		$data['Pid']=$wModelLinkOn[$i];
	    $data['wModeltype']=1;
		$Model->create();
		$Model->add($data);
		}
		for($i=0;$i<count($wModelLinkOff);$i++){
	    $data['McID']=$Pid;
		$data['Pid']=$wModelLinkOff[$i];
	    $data['wModeltype']=2;
		$Model->create();
		$Model->add($data);
		}
		for($i=0;$i<count($wModelLinkOn_Off);$i++){
	    $data['McID']=$Pid;
		$data['Pid']=$wModelLinkOn_Off[$i];
	    $data['wModeltype']=3;
		$Model->create();
		$Model->add($data);
		}
		for($i=0;$i<count($wModelLinkOff_On);$i++){
	    $data['McID']=$Pid;
		$data['Pid']=$wModelLinkOff_On[$i];
	    $data['wModeltype']=4;
		$Model->create();
		$Model->add($data);
		}
		$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Mobile/';
	    header("Location:$url");
		
	}
	//添加设备
	public function add(){
		$Mobilemanager=D("mobilemanager");
		$where['wMB']=session('wMB');
		$where['wUseID']=session('wUseID');
		$list=$Mobilemanager->where($where)->order('Item ASC')->select();
		$this->assign("myMobile",$list);
         $this->display();
	}
	
	public function mobileadd(){
		$User=D("mobilemanager");
		if($User->create()){
			$id=$User->add();
			$wModelLinkOn=$_POST['LinkOn'];
			$wModelLinkOff=$_POST['LinkOff'];
			$wModelLinkOn_Off=$_POST['LinkOn_Off'];
			$wModelLinkOff_On=$_POST['LinkOff_On'];
		$Model=D("linklist");
	    for($i=0;$i<count($wModelLinkOn);$i++){
	    $data['McID']=$id;
		$data['Pid']=$wModelLinkOn[$i];
	    $data['wModeltype']=1;
		$Model->create();
		$Model->add($data);
		}
		for($i=0;$i<count($wModelLinkOff);$i++){
	    $data['McID']=$id;
		$data['Pid']=$wModelLinkOff[$i];
	    $data['wModeltype']=2;
		$Model->create();
		$Model->add($data);
		}
		for($i=0;$i<count($wModelLinkOn_Off);$i++){
	    $data['McID']=$id;
		$data['Pid']=$wModelLinkOn_Off[$i];
	    $data['wModeltype']=3;
		$Model->create();
		$Model->add($data);
		}
		for($i=0;$i<count($wModelLinkOff_On);$i++){
	    $data['McID']=$id;
		$data['Pid']=$wModelLinkOff_On[$i];
	    $data['wModeltype']=4;
		$Model->create();
		$Model->add($data);
		}
			
		$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/Mobile/';
	    header("Location:$url");
		}else{
			$this->error($User->getError());
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
?>