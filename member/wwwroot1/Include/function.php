<?php

//核对验证码
function chkVerify(){
	if($_SESSION['verify']!=md5($_POST['verify'])){
		return false;
	}
}


//中文分词
function get_tags_arr($title)
{
	require('./Include/pscws4.class.php');
	$pscws = new PSCWS4();
	$pscws->set_dict('./Include/scws/dict.utf8.xdb');
	$pscws->set_rule('./Include/scws/rules.utf8.ini');
	$pscws->set_ignore(true);
	$pscws->send_text($title);
	$words = $pscws->get_tops(6);
	$tags = array();
	foreach ($words as $val) {
		$tags[] = $val['word'];
	}
	$pscws->close();
	return $tags;
}

//字符截取
function cn_substr_utf8($str, $from, $len)

{

	return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.

			'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',

			'$1',$str);

}

//中文字符截取
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true)
{
	if(function_exists("mb_substr"))
		return mb_substr($str, $start, $length, $charset);
	elseif(function_exists('iconv_substr')) {
		return iconv_substr($str,$start,$length,$charset);
	}
	$re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
	$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
	$re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
	$re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
	preg_match_all($re[$charset], $str, $match);
	$slice = join("",array_slice($match[0], $start, $length));
	if($suffix) return $slice."…";
	return $slice;
}

?>