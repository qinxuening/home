<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {

//调用验证码
    Public function verify(){
        import('ORG.Util.Image');
        Image::buildImageVerify();
    }
   public function index(){
		if(!session('?wUseID')){
			//echo L('LOGIN');exit;
			$this->display();
		}else{
			$url = 'http://'.$_SERVER['HTTP_HOST'].__APP__.'/User/';
			header("Location:$url");
		}
    }
}