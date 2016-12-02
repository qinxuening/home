<?php
$dataconfig=include './config.php';

$config = array(
	//'配置项'=>'配置值'
	//'URL_MODEL'             => 2,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
	//'URL_HTML_SUFFIX'       => 'html',  // URL伪静态后缀设置
	'LANG_SWITCH_ON' => true,   // 开启语言包功能
	'LANG_AUTO_DETECT' => false, // 自动侦测语言 开启多语言功能后有效
	
	'DEFAULT_LANG' => 'zh-cn', // 默认语言
	 
	'LANG_LIST' => 'zh-cn,en-us', // 允许切换的语言列表 用逗号分隔
	'VAR_LANGUAGE' => 'l', // 默认语言切换变量  {$Think.config.VAR_LANGUAGE}
);
return array_merge($config,$dataconfig);
?>