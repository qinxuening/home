<?php 
class EmptyAction extends Action{ 
	public function _initialize(){
		$this->assign('langue',L('langue'));
	}
    function _empty(){ 
          header("HTTP/1.0 404 Not Found");//使HTTP返回404状态码 
          $this->display("Public:404"); 
     } 
    } 
?>