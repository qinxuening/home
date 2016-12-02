<?php
    //判断是否属手机
	//error_reporting(E_ALL^E_NOTICE);
	ini_set('max_execution_time', 0);//设置不限制时间运行
	ini_set('session.cookie_domain', '.ob-hom.com');
	define('APP_DEBUG', true);
    function is_mobile(){
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $mobile_agents = Array("240x320","acer","acoon","acs-","abacho","ahong","airness","alcatel","amoi","android","anywhereyougo.com","applewebkit/525","applewebkit/532","asus","audio","au-mic","avantogo","becker","benq","bilbo","bird","blackberry","blazer","bleu","cdm-","compal","coolpad","danger","dbtel","dopod","elaine","eric","etouch","fly ","fly_","fly-","go.web","goodaccess","gradiente","grundig","haier","hedy","hitachi","htc","huawei","hutchison","inno","ipad","ipaq","ipod","jbrowser","kddi","kgt","kwc","lenovo","lg ","lg2","lg3","lg4","lg5","lg7","lg8","lg9","lg-","lge-","lge9","longcos","maemo","mercator","meridian","micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-","moto","nec-","netfront","newgen","nexian","nf-browser","nintendo","nitro","nokia","nook","novarra","obigo","palm","panasonic","pantech","philips","phone","pg-","playstation","pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo","samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens","sie-","softbank","sony","spice","sprint","spv","symbian","tablet","talkabout","tcl-","teleca","telit","tianyu","tim-","toshiba","tsm","up.browser","utec","utstar","verykool","virgin","vk-","voda","voxtel","vx","wap","wellco","wig browser","wii","windows ce","wireless","xda","xde","zte");
        
		$is_mobile = false;
		
        foreach ($mobile_agents as $device) {
            if (stristr($user_agent, $device)) {
                $is_mobile = true;
                break;
            }
        }
		
        return $is_mobile;
   }
    if(is_mobile()){ //跳转至wap分组
        define('APP_NAME','Wap');
        define('APP_PATH','./Wap/');
    }else{
        define('APP_NAME','Home');
        define('APP_PATH','./Home/');           
   }
   define('DIR_SECURE_FILENAME', 'index.html,index.htm');
   define('DIR_SECURE_CONTENT', 'deny Access!');//目录安全
//加载入口文件
require './ThinkPHP/ThinkPHP.php';

?>