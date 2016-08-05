<?php 

return array(     // 添加下面一行定义即可    
	//'app_init'=>array('Common\Behavior\InitHookBehavior'), 
	'app_begin' => array('Behavior\CheckLangBehavior'),
	//'view_filter' => array('Common\Behavior\TmplStripSpaceBehavior'),
	'view_filter' => array('Behavior\TokenBuildBehavior'), //开启表单令牌验证功能
);