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
    
    function _empty(){
    	header("HTTP/1.0 404 Not Found");
    	$this->display("Public:404");
    }
}