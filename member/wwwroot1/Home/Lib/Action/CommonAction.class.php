<?php
class CommonAction extends Action{
	public function __initialize() {
		 $this->assign('langue',L('langue'));
	}
}