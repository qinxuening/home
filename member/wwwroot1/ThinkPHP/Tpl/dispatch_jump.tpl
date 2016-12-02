<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$Think.lang.S_t_jl}</title>

<style type="text/css">
*{ padding: 0; margin: 0; }
body{ background: #fff; font-family: '微软雅黑'; color: #333; font-size: 16px;TEXT-ALIGN: center; }
.system-message{ margin-left:auto; margin-right:auto; width:100%; margin-top:100px;}
.system-message h1{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
.system-message .jump{ padding-top: 10px}
.system-message .jump a{ color: #333;}
.system-message .success,.system-message .error{ line-height: 1.8em; font-size: 36px ; color:#F00;}
.system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display:none}
</style>
</head>
<body>
<div class="system-message">
<present name="message">
<h1><img src="http://member.ob-home.com/Public/wap/images/success.jpg" /></h1>
<p class="success"><?php echo($message); ?></p>
<else/>
<h1><img src="http://member.ob-home.com/Public/wap/images/cwxx_tu1.jpg" /></h1>
<p class="error"><?php echo($error); ?></p>
</present>
<p class="detail"></p>
<p class="jump">
{$Think.lang.S_t_a} <a id="href" href="<?php echo($jumpUrl); ?>">{$Think.lang.S_t_j}</a> {$Think.lang.S_t_w}： <b id="wait"><?php echo($waitSecond); ?></b>
</p>
</div>
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>
</body>
</html>