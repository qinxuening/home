<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller{
	public function _initialize(){
		header("Content-Type:text/html;charset=utf-8");
		if(!session('?wUseID')){
			header("Location:".__APP__."/");
			$this->assign('langue',L('langue'));
		}
	}
	
	function _empty(){
		header("HTTP/1.0 404 Not Found");
		$this->display("Public:404");
	}
}