<?php
return array(
    'TOKEN_ON'=>false,  // 是否开启令牌验证   
    'TOKEN_NAME'=>'__hash__',    // 令牌验证的表单隐藏字段名称   
    'TOKEN_TYPE'=>'md5',  //令牌哈希验证规则 默认为MD5
	'VAR_FILTERS'=>'htmlspecialchars,stripslashes,strip_tags', //开启过滤规则
	'DB_FIELDTYPE_CHECK'=>true,  // 开启字段类型验证
	'VAR_FILTERS'=>'filter_default,filter_exp',
	'DB_TYPE' => 'mysql', //数据库类型
	'DB_HOST' => '127.0.0.1',//数据库服务器
	'DB_NAME' => 'ob_home',  //数据库名称
	'DB_USER' => 'root',   //数据库用户
	'DB_PWD' => '314233',  //数据库密码
	'DB_PORT' => '3306',   //端口
	'DB_PREFIX' => '',     //表前缀
	'private' => '43124832334296327942263261112564833800004258950540125802523034086164725101713',          //密匙
	'modulus' => '73096395621176217363302918493059912395494282297835649469281396561710779772441',
	'keylength' => '128',
    'public_key' => '00a19b18024fbd1a06f7eb076e1525fad83d62387077fa021cecc068b81770ae19',                //js公匙
	'public_length' => '10001',
		
	'SHOW_PAGE_TRACE' =>true,
		//模板替换变量
	'TMPL_PARSE_STRING' => array(
		'HOST_URL' =>'www.ob-hom.com',
		'HOST_ENURL' =>'eng.ob-hom.com',
		'REG_URL' => 'member.ob-hom.com',
	),
);
//定义过滤函数，过滤htm php 反斜杠
function filter_default(&$value){
        $value = htmlspecialchars(strip_tags(stripslashes($value)));
}
?>