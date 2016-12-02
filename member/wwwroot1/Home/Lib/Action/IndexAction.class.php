<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
	public function _initialize(){
		$this->assign('langue',L('langue'));
	}
//调用验证码
    Public function verify(){
        import('ORG.Util.Image');
        Image::buildImageVerify();
    }
   public function index(){
		if(!session('?wUseID')){
			$this->display();
		}else{
			$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
			header("Location:$url");
		}
    }
}