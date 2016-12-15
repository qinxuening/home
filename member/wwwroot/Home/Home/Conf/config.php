<?php
return array(		
	//'配置项'=>'配置值'
	'LANG_SWITCH_ON' => true,   // 开启语言包功能
	'LANG_AUTO_DETECT' => true, // 自动侦测语言 开启多语言功能后有效
	'DEFAULT_LANG' => 'zh-cn', // 默认语言
	'LANG_LIST' => 'zh-cn,en-us', // 允许切换的语言列表 用逗号分隔
	'VAR_LANGUAGE' => 'l', // 默认语言切换变量  {$Think.config.VAR_LANGUAGE}
	
	//默认错误跳转对应的模板文件
	'TMPL_ACTION_ERROR' => 'Public:error',
	//默认成功跳转对应的模板文件
	'TMPL_ACTION_SUCCESS' => 'Public:success',
	'SESSION_AUTO_START' =>true,
	'SESSION_OPTIONS'       =>  array(
			'SESSION_EXPIRE'=>20
	),
);