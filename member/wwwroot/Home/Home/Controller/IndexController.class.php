<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	public function _initialize(){
		$this->assign('langue',L('langue'));
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