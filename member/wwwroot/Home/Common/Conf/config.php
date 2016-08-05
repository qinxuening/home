<?php
$dataconfig=include './config.php';
$configs= array(
	//'配置项'=>'配置值'
    'LANG_SWITCH_ON' => true,   // 开启语言包功能
    'LANG_AUTO_DETECT' => true, // 自动侦测语言 开启多语言功能后有效
    'DEFAULT_LANG' => 'zh-cn', // 默认语言
    'LANG_LIST'        => 'zh-cn,en-us', // 允许切换的语言列表 用逗号分隔
    'VAR_LANGUAGE'     => 'l', // 默认语言切换变量
	'SESSION_AUTO_START' => true, //是否开启session
	'MODULE_ALLOW_LIST'  => array('Home'),
		
	// 设置禁止访问的模块列表
	'MODULE_DENY_LIST'      =>  array('Common','Runtime'),
		
	'TMPL_TEMPLATE_SUFFIX'  => '.html',     // 默认模板文件后缀
	'DEFAULT_MODULE'        =>  'Home',  // 默认模块
	'DEFAULT_CONTROLLER'    =>  'Index', // 默认控制器名称
	'DEFAULT_ACTION'        =>  'index', // 默认操作名称
	'DEFAULT_M_LAYER'       =>  'Model', // 默认的模型层名称
	'DEFAULT_C_LAYER'       =>  'Controller', // 默认的控制器层名称
	
	'LANG_AUTO_DETECT'		=>  false,
	'URL_MODEL'             => 0,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
	
	'DB_PARAMS' => array(\PDO::ATTR_CASE => \PDO::CASE_NATURAL), //原数据库默认小写转换为跟数据库本身一样
	
		
);
return  array_merge($configs,$dataconfig);