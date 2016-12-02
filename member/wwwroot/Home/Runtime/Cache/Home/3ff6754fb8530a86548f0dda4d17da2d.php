<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo (L("Edit_equipment")); ?></title>
<link rel="stylesheet" href="/Public/resource/common/css/base.css" >
<link rel="stylesheet" href="/Public/resource/common/css/user.css">
<link rel="stylesheet" href="/Public/resource/common/js/validform/style.css" >
<link rel="shortcut icon" href="/Public/resource/common/images/favicon.ico" type="image/x-icon" />
<script src="/Public/resource/common/js/jquery.js"></script>
<script src="/Public/resource/js/My97Date/WdatePicker.js"></script>
<script language="javascript">
$(document).ready(function(){
$("#IsAllOpens").click(function(){ 
     $("#IsAllCloses").attr('checked',false);
     $(this).attr('checked',true);
});
$("#IsAllCloses").click(function(){ 
     $("#IsAllOpens").attr('checked',false);
     $(this).attr('checked',true);
});
});
function aa(){
    var r=document.getElementById("IsMsgs");
         if(r.checked){
        // r.value=1;
		document.getElementById("IsMsg").value=1;
		 //alert(r.value);
       }else{
	  document.getElementById("IsMsg").value=0;
	  // alert(r.value);
	   }
   var m=document.getElementById("IsAllOpens");
         if(m.checked){
        // r.value=1;
		document.getElementById("IsAllOpen").value=1;
		document.getElementById("IsAllClose").value=0;
		 //alert(m.value);
       }else{
	  document.getElementById("IsAllOpen").value=0;
	  document.getElementById("IsAllClose").value=1;
	  // alert(r.value);
	   }
	var k=document.getElementById("IsAllCloses");
         if(k.checked){
        // r.value=1;
		document.getElementById("IsAllClose").value=1;
		document.getElementById("IsAllOpen").value=0;
		 //alert(r.value);
       }else{
	  document.getElementById("IsAllClose").value=0;
	  document.getElementById("IsAllOpen").value=1;
	  // alert(r.value);
	   }
}
</script>
<style>
	.s_1 {
	    float: right;
	    text-align: right;
	    /* color: #6eb805; */
	    padding-right: 50px;
	}
</style>
</head>

<body>
<!--header-->
<link rel="stylesheet" href="/Public/resource/common/css/bootstrap.min.css"><link rel="stylesheet" href="css/non-responsive.css">
<link rel="stylesheet" href="/Public/resource/common/css/non-responsive.css">
<link rel="stylesheet" href="/Public/resource/common/css/style.css">
<script src="/Public/resource/common/js/jquery.js"></script>
<nav class="navbar-fixed-top">
<nav class="top-header">
	<div class="container">
        <div class="row">
            <div class="col-xs-5  left_top" >
                <a href="http://www.ob-hom.com/"><img src="/Public/user/images/logo.png" alt=""></a>
                <h3><?php echo (L("SHLB")); ?></h3>
            </div>
            <div class="col-xs-7 top-header-right">
	                  <span class="Welcome"><img src="/Public/resource/common/images/Welcome.png"></span>
					<?php if(($langue) == "cn"): if(empty($_SESSION['wUseID'])): ?><a href="http://member.ob-hom.com/?l=zh-cn"><?php echo (L("Login")); ?></a>
			                  <span>|</span>
			                  <a href="http://member.ob-hom.com/index.php/Login/?l=zh-cn"><?php echo (L("Register")); ?></a>
						<?php else: ?> 
							<a href="/index.php/User/" class="username"><?php echo $_SESSION['wUseID']; ?></a>
						    <a href="/index.php/User/out/" class="logout"><?php echo (L("Logout")); ?></a><?php endif; ?> 
	                  <a class="btn-sm langw" href="./?l=zh-cn">中 文</a>
	                  <a class="btn-sm" href="./?l=en-us">E N</a>
					<?php else: ?>
						 <?php if(empty($_SESSION['wUseID'])): ?><a href="http://member.ob-hom.com/?l=en-us"><?php echo (L("Login")); ?></a>
				                  <span>|</span>
				                  <a href="http://member.ob-hom.com/index.php/Login/?l=en-us"><?php echo (L("Register")); ?></a>
							<?php else: ?> 
								<a href="/index.php/User/" class="username"><?php echo $_SESSION['wUseID']; ?></a>
							    <a href="/index.php/User/out/" class="logout"><?php echo (L("Logout")); ?></a><?php endif; ?> 
		                  <a class="btn-sm langw" href="./?l=zh-cn">中 文</a>
		                  <a class="btn-sm" href="./?l=en-us">E N</a><?php endif; ?>
            </div>
        </div>
	</div>
</nav>

<nav class="top-header-tow">
    <div class="container" style="clear:both;">
        <div class="row" >
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
            <div class="col-xs-12"  style="padding:0;">
			<?php if(($langue) == "cn"): ?><ul>
                    <li class="dropdown">
                       <a href="http://www.ob-hom.com/?l=zh-cn" class="main-a active"><?php echo (L("Home")); ?></a>
                    </li>
                    <li class="dropdown">
                        <a href="http://www.ob-hom.com/index.php?c=article&a=type&tid=24" class="main-a "><?php echo (L("Solution")); ?></a>
                    </li>
                    <li class="dropdown">
                        <a href="http://www.ob-hom.com/index.php?c=channel&a=type&tid=33" class="main-a"><?php echo (L("Products")); ?></a>
                    </li>
                    <li class="dropdown">
                        <a href="http://www.ob-hom.com/index.php?c=product&a=type&tid=25" class="main-a"><?php echo (L("Download")); ?></a>
                    </li>
                    <li class="dropdown">
                        <a href="http://www.ob-hom.com/index.php?c=article&a=type&tid=26" class="main-a"><?php echo (L("Join_Us")); ?></a>                        
                    </li>
                    <li class="dropdown">
                       <a href="http://www.ob-hom.com/index.php?c=article&a=type&tid=29" class="main-a"><?php echo (L("Service_support")); ?></a>
                    </li>						
                    <li class="dropdown">
                       <a href="http://www.ob-hom.com/index.php?c=article&a=type&tid=27" class="main-a"><?php echo (L("About_Us")); ?></a>
                    </li>				
                </ul>
			<?php else: ?>
			      <ul>
                    <li class="dropdown">
                       <a href="http://eng.ob-hom.com/?l=en-us" class="main-a active"><?php echo (L("Home")); ?></a>
                    </li>
                    <li class="dropdown">
                        <a href="http://eng.ob-hom.com/index.php?c=article&a=type&tid=24" class="main-a "><?php echo (L("Solution")); ?></a>
                    </li>
                    <li class="dropdown">
                        <a href="http://eng.ob-hom.com/index.php?c=channel&a=type&tid=33" class="main-a"><?php echo (L("Products")); ?></a>
                    </li>
                    <li class="dropdown">
                        <a href="http://eng.ob-hom.com/index.php?c=product&a=type&tid=25" class="main-a"><?php echo (L("Download")); ?></a>
                    </li>
                    <li class="dropdown">
                        <a href="http://eng.ob-hom.com/index.php?c=article&a=type&tid=26" class="main-a"><?php echo (L("Join_Us")); ?></a>                        
                    </li>
					<li class="dropdown">
                       <a href="http://eng.ob-hom.com/index.php?c=article&a=type&tid=29" class="main-a"><?php echo (L("Service_support")); ?></a>
                    </li>					
                    <li class="dropdown">
                       <a href="http://eng.ob-hom.com/index.php?c=article&a=type&tid=27" class="main-a"><?php echo (L("About_Us")); ?></a>
                    </li>
                </ul><?php endif; ?>
            </div>
        </div>
    </div>
</nav>
</nav>
<div class="jumppage_bg" style="display:none;"></div>

<!--end header--> 
<!--main-->
<div id="wp" class="wp"><link href="/Public/user/css/style.css" rel="stylesheet" type="text/css" />
 <div class="contentmanage">
    <div class="developer">
       <div class="appTitle normalTitle" style="padding: 20px;">
        <h2><?php echo (L("Center")); ?></h2>
        <div class="accountInfo">
        
        </div>
        <div class="clr"></div>
      </div>
      <div class="tableContent">
        <!--左侧功能菜单-->
        <div class="sideBar">
          <div class="catalogList">
            <ul>
				<li class="subCatalogList" > <a href="/index.php/User/"><?php echo (L("Member")); ?></a></li>
				<li class=" subCatalogList "> <a href="/index.php/User/add/"><?php echo (L("Add_member")); ?></a> </li>
				<li class=" selected "> <a href="/index.php/Mobile/"><?php echo (L("Equipment")); ?></a> </li>
				
				<li class=" subCatalogList "> <a href="/index.php/Type/"><?php echo (L("Model")); ?></a> </li>
				<li class=" subCatalogList "> <a href="/index.php/Type/add/"><?php echo (L("Add_model")); ?></a> </li>
				<li class=" subCatalogList "> <a href="/index.php/Time/"><?php echo (L("Time")); ?></a> </li>
				<li class=" subCatalogList "> <a href="/index.php/Time/add/"><?php echo (L("Add_time")); ?></a> </li>
				<li class=" subCatalogList "> <a href="/index.php/User/useredit/"><?php echo (L("Information")); ?></a> </li>
				<li class=" subCatalogList "> <a href="/index.php/User/pwd/"><?php echo (L("Change_password")); ?></a> </li>
				<li class=" subCatalogList "> <a href="/index.php/Mobile/usermobile/"><?php echo (L("UserMobile")); ?></a> </li>
				<li class=" subCatalogList "> <a href="/index.php/User/out/"><?php echo (L("Exit")); ?></a> </li>
            </ul>
          </div>
        </div>

<div class="content">
          <div class="cLineB"><h4><?php echo (L("Edit_equipment")); ?></h4></div>
          <form method="post" action="/index.php/Mobile/update/id/<?php echo ($mobile["Pid"]); ?>" enctype="multipart/form-data" class="Machineryfrom">
          <div class="msgWrap">
            <table class="userinfoArea" border="0" cellspacing="0" cellpadding="0" width="100%">
              <thead>
                  <tr>
                  <th><span class="red">*</span><label class="m_label c_label"><?php echo (L("Equipment_position")); ?>：</label></th>
                  <td class="touch1">
                  	<input type="text" class="px" datatype="*1-30" nullmsg="<?php echo (L("Equipment_position_n")); ?>" sucmsg="<?php echo (L("Crepass")); ?>" name="McName" value="<?php echo ($mobile["McName"]); ?>" tabindex="1" size="25" maxlength="30">
                  </td>
				  <!--默认空调温度-->
				 <?php if(!empty($McID2)): ?><td class="touch"><label><?php echo (L("Default_Temperature")); ?>:</label>
				  <input type="hidden" name="McIDIrin" id="McIDIrin" value="<?php echo ($McID2); ?>">
				  <select name="KeyVar">
				  	 <?php if(is_array($IrinfoList)): $i = 0; $__LIST__ = $IrinfoList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><option value="<?php echo ($va["KeyVar"]); ?>" <?php if(($KeyVar) == $va["KeyVar"]): ?>selected<?php endif; ?>><?php echo ($va["KeyName"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?> 
				  </select>
				  </td><?php endif; ?>
				  <!--默认空调温度-->
                </tr>
              </thead>
			  <tbody>
				 <tr style="border-top:1px solid #eeeeee;background-color:#fcfcfc; padding:10px 0px">
                  <th><?php echo (L("SMS")); ?>：</th>
                  <td><input type="checkbox" name="IsMsgs" id="IsMsgs" value="" class="px" <?php if(($mobile['IsMsg']) == "1"): ?>checked<?php endif; ?>>&nbsp;<?php echo (L("Sms_notification")); ?>
				  <input type="hidden" name="IsMsg" id="IsMsg">  <div class="s_1" style="color:#6eb805"><?php echo (L("Main_opening")); ?></div></td>
                </tr>
				
				  <tr style="border-top:1px solid #eeeeee;background-color:#fcfcfc; padding:10px 0px">
                  <th><?php echo (L("Linkage_opening")); ?>：</th>
                  <td>
                  	
                  	<?php if(($McID1) == "14"): ?><!--开关联动开-->
					 <div id="tabon" class="box tab">
					 	        <ul>
							        <li class="on active"><?php echo (L("key1")); ?></li>
							        <li class="off" ><?php echo (L("key2")); ?></li>
							        <li class="off"><?php echo (L("key3")); ?></li>
						        </ul>
						  <div class="box sho" id="keyon1">
							  <?php if(is_array($myMobile)): $i = 0; $__LIST__ = $myMobile;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span class="bbox1"><label><input type="checkbox" name="LinkOn01[]" id="LinkOn01[]" <?php if(is_array($mLinkOn01)): foreach($mLinkOn01 as $key=>$vt): if(($vt) == $vo["Pid"]): ?>checked<?php endif; endforeach; endif; ?> value="<?php echo ($vo["Pid"]); ?>" class="px">&nbsp;&nbsp;<?php echo ($vo["McName"]); ?>&nbsp;&nbsp;</label></span><?php endforeach; endif; else: echo "" ;endif; ?>
						  </div>
						  <div class="box hid" id="keyon2">
							  <?php if(is_array($myMobile)): $i = 0; $__LIST__ = $myMobile;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span class="bbox1"><label><input type="checkbox" name="LinkOn02[]" id="LinkOn02[]" <?php if(is_array($mLinkOn02)): foreach($mLinkOn02 as $key=>$vt): if(($vt) == $vo["Pid"]): ?>checked<?php endif; endforeach; endif; ?> value="<?php echo ($vo["Pid"]); ?>" class="px">&nbsp;&nbsp;<?php echo ($vo["McName"]); ?>&nbsp;&nbsp;</label></span><?php endforeach; endif; else: echo "" ;endif; ?>
						  </div>
						  
						  <div class="box hid" id="keyon3">
							  <?php if(is_array($myMobile)): $i = 0; $__LIST__ = $myMobile;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span class="bbox1"><label><input type="checkbox" name="LinkOn03[]" id="LinkOn03[]" <?php if(is_array($mLinkOn03)): foreach($mLinkOn03 as $key=>$vt): if(($vt) == $vo["Pid"]): ?>checked<?php endif; endforeach; endif; ?> value="<?php echo ($vo["Pid"]); ?>" class="px">&nbsp;&nbsp;<?php echo ($vo["McName"]); ?>&nbsp;&nbsp;</label></span><?php endforeach; endif; else: echo "" ;endif; ?>
						  </div>
					  </div>
					  <!--开关联动开-->
					 <?php else: ?>
					 <!--非开关联动开-->
					 <?php if(is_array($myMobile)): $i = 0; $__LIST__ = $myMobile;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo["McID3"]) == "14"): ?><span class="bbox1"><label style="margin-bottom:0!important;">
								&nbsp;&nbsp;<?php echo ($vo["McName"]); ?>&nbsp;&nbsp;
								<label ><input class="px" name="LinkOn[<?php echo ($vo["Pid"]); ?>][]" type="checkbox" <?php if($Key_mLinkOn["$vo[Pid]"][0]){echo "checked";} ?> value="Key01">&nbsp;键1&nbsp;</label>
								<label ><input class="px" name="LinkOn[<?php echo ($vo["Pid"]); ?>][]" type="checkbox" <?php if($Key_mLinkOn["$vo[Pid]"][1]){echo "checked";} ?> value="Key02">&nbsp;键2&nbsp;</label>
								<label ><input class="px" name="LinkOn[<?php echo ($vo["Pid"]); ?>][]" type="checkbox" <?php if($Key_mLinkOn["$vo[Pid]"][2]){echo "checked";} ?> value="Key03">&nbsp;键3&nbsp;</label>
							</label></span>
						 <?php else: ?>
               	 	     <span class="bbox1"><label><input type="checkbox" name="LinkOn[]" id="LinkOn[]" <?php if(is_array($mLinkOn)): foreach($mLinkOn as $key=>$vt): if(($vt) == $vo["Pid"]): ?>checked<?php endif; endforeach; endif; ?> value="<?php echo ($vo["Pid"]); ?>" class="px">
 							&nbsp;&nbsp;<?php echo ($vo["McName"]); ?>&nbsp;&nbsp;</label>
						 </span><?php endif; endforeach; endif; else: echo "" ;endif; ?>
					<!--非开关联动开--><?php endif; ?>
				  </td>
                </tr>
				<tr><th></th><td><div class="s_1" style="color:#6eb805"><?php echo (L("Master_Guan")); ?></div></td></tr>
				<tr style="border-top:1px solid #eeeeee;background-color:#fcfcfc; padding:10px 0px">
                  <th><?php echo (L("Linkage")); ?>：</th>
                  <td>
                  	<?php if(($McID1) == "14"): ?><!--开关联动关-->
					 <div id="taboff" class="box tab">
					 	        <ul>
							        <li class="on active"><?php echo (L("key1")); ?></li>
							        <li class="off" ><?php echo (L("key2")); ?></li>
							        <li class="off"><?php echo (L("key3")); ?></li>
						        </ul>
						  <div class="box sho" id="keyon1">
							  <?php if(is_array($myMobile)): $i = 0; $__LIST__ = $myMobile;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span class="bbox1"><label><input type="checkbox" name="LinkOff01[]" id="LinkOff01[]" <?php if(is_array($mLinkOff01)): foreach($mLinkOff01 as $key=>$vt): if(($vt) == $vo["Pid"]): ?>checked<?php endif; endforeach; endif; ?> value="<?php echo ($vo["Pid"]); ?>" class="px">&nbsp;&nbsp;<?php echo ($vo["McName"]); ?>&nbsp;&nbsp;</label></span><?php endforeach; endif; else: echo "" ;endif; ?>
						  </div>
						  <div class="box hid" id="keyon2">
							  <?php if(is_array($myMobile)): $i = 0; $__LIST__ = $myMobile;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span class="bbox1"><label><input type="checkbox" name="LinkOff02[]" id="LinkOff02[]" <?php if(is_array($mLinkOff02)): foreach($mLinkOff02 as $key=>$vt): if(($vt) == $vo["Pid"]): ?>checked<?php endif; endforeach; endif; ?> value="<?php echo ($vo["Pid"]); ?>" class="px">&nbsp;&nbsp;<?php echo ($vo["McName"]); ?>&nbsp;&nbsp;</label></span><?php endforeach; endif; else: echo "" ;endif; ?>
						  </div>
						  
						  <div class="box hid" id="keyon3">
							  <?php if(is_array($myMobile)): $i = 0; $__LIST__ = $myMobile;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span class="bbox1"><label><input type="checkbox" name="LinkOff03[]" id="LinkOff03[]" <?php if(is_array($mLinkOff03)): foreach($mLinkOff03 as $key=>$vt): if(($vt) == $vo["Pid"]): ?>checked<?php endif; endforeach; endif; ?> value="<?php echo ($vo["Pid"]); ?>" class="px">&nbsp;&nbsp;<?php echo ($vo["McName"]); ?>&nbsp;&nbsp;</label></span><?php endforeach; endif; else: echo "" ;endif; ?>
						  </div>
					  </div>
					  <!--开关联动关-->
					<?php else: ?>
					 <!--非开关联动关-->
						<?php if(is_array($myMobile)): $i = 0; $__LIST__ = $myMobile;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo["McID3"]) == "14"): ?><span class="bbox1"><label style="margin-bottom:0!important;">
								&nbsp;&nbsp;<?php echo ($vo["McName"]); ?>&nbsp;&nbsp;
								<label ><input class="px" name="LinkOff[][<?php echo ($vo["Pid"]); ?>]" type="radio" <?php if($Key_mLinkOff["$vo[Pid]"][0]){echo "checked";} ?> value="Key01">&nbsp;键1&nbsp;</label>
								<label ><input class="px" name="LinkOff[][<?php echo ($vo["Pid"]); ?>]" type="radio" <?php if($Key_mLinkOff["$vo[Pid]"][1]){echo "checked";} ?> value="Key02">&nbsp;键2&nbsp;</label>
								<label ><input class="px" name="LinkOff[][<?php echo ($vo["Pid"]); ?>]" type="radio" <?php if($Key_mLinkOff["$vo[Pid]"][2]){echo "checked";} ?> value="Key03">&nbsp;键3&nbsp;</label>
							</label></span>
						 <?php else: ?>
               	 	     <span class="bbox1"><label><input type="checkbox" name="LinkOff[]" id="LinkOff[]" <?php if(is_array($mLinkOff)): foreach($mLinkOff as $key=>$vt): if(($vt) == $vo["Pid"]): ?>checked<?php endif; endforeach; endif; ?> value="<?php echo ($vo["Pid"]); ?>" class="px">
 							&nbsp;&nbsp;<?php echo ($vo["McName"]); ?>&nbsp;&nbsp;</label>
						 </span><?php endif; endforeach; endif; else: echo "" ;endif; ?>
					 <!--非开关联动关--><?php endif; ?>
				</td>
                </tr>
				<tr><th></th><td><div class="s_1" style="color:#6eb805"><?php echo (L("Main_opening2")); ?></div></td></tr>
				<tr style="border-top:1px solid #eeeeee;background-color:#fcfcfc; padding:10px 0px">
                  <th><?php echo (L("Anti_linkage")); ?>：</th>
                  <td>
                  	<?php if(($McID1) == "14"): ?><!--开关反联动关-->
					 <div id="tabon_off" class="box tab">
					 	        <ul>
							        <li class="on active"><?php echo (L("key1")); ?></li>
							        <li class="off" ><?php echo (L("key2")); ?></li>
							        <li class="off"><?php echo (L("key3")); ?></li>
						        </ul>
						  <div class="box sho" id="keyon1">
							  <?php if(is_array($myMobile)): $i = 0; $__LIST__ = $myMobile;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span class="bbox1"><label><input type="checkbox" name="Linkon_off01[]" id="Linkon_off01[]" <?php if(is_array($mLinkon_off01)): foreach($mLinkon_off01 as $key=>$vt): if(($vt) == $vo["Pid"]): ?>checked<?php endif; endforeach; endif; ?> value="<?php echo ($vo["Pid"]); ?>" class="px">&nbsp;&nbsp;<?php echo ($vo["McName"]); ?>&nbsp;&nbsp;</label></span><?php endforeach; endif; else: echo "" ;endif; ?>
						  </div>
						  <div class="box hid" id="keyon2">
							  <?php if(is_array($myMobile)): $i = 0; $__LIST__ = $myMobile;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span class="bbox1"><label><input type="checkbox" name="Linkon_off02[]" id="Linkon_off02[]" <?php if(is_array($mLinkon_off02)): foreach($mLinkon_off02 as $key=>$vt): if(($vt) == $vo["Pid"]): ?>checked<?php endif; endforeach; endif; ?> value="<?php echo ($vo["Pid"]); ?>" class="px">&nbsp;&nbsp;<?php echo ($vo["McName"]); ?>&nbsp;&nbsp;</label></span><?php endforeach; endif; else: echo "" ;endif; ?>
						  </div>
						  
						  <div class="box hid" id="keyon3">
							  <?php if(is_array($myMobile)): $i = 0; $__LIST__ = $myMobile;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span class="bbox1"><label><input type="checkbox" name="Linkon_off03[]" id="Linkon_off03[]" <?php if(is_array($mLinkon_off03)): foreach($mLinkon_off03 as $key=>$vt): if(($vt) == $vo["Pid"]): ?>checked<?php endif; endforeach; endif; ?> value="<?php echo ($vo["Pid"]); ?>" class="px">&nbsp;&nbsp;<?php echo ($vo["McName"]); ?>&nbsp;&nbsp;</label></span><?php endforeach; endif; else: echo "" ;endif; ?>
						  </div>
					  </div>
					  <!--开关反联动开-->				
					<?php else: ?>
					<!--非开关反联动开-->
						<?php if(is_array($myMobile)): $i = 0; $__LIST__ = $myMobile;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo["McID3"]) == "14"): ?><span class="bbox1"><label style="margin-bottom:0!important;">
								&nbsp;&nbsp;<?php echo ($vo["McName"]); ?>&nbsp;&nbsp;
								<label ><input class="px" name="LinkOn_Off[][<?php echo ($vo["Pid"]); ?>]" type="radio" <?php if($Key_mLinkOn_Off["$vo[Pid]"][0]){echo "checked";} ?> value="Key01">&nbsp;键1&nbsp;</label>
								<label ><input class="px" name="LinkOn_Off[][<?php echo ($vo["Pid"]); ?>]" type="radio" <?php if($Key_mLinkOn_Off["$vo[Pid]"][1]){echo "checked";} ?> value="Key02">&nbsp;键2&nbsp;</label>
								<label ><input class="px" name="LinkOn_Off[][<?php echo ($vo["Pid"]); ?>]" type="radio" <?php if($Key_mLinkOn_Off["$vo[Pid]"][2]){echo "checked";} ?> value="Key03">&nbsp;键3&nbsp;</label>
							</label></span>
						 <?php else: ?>
               	 	     <span class="bbox1"><label><input type="checkbox" name="LinkOn_Off[]" id="LinkOn_Off[]" <?php if(is_array($mLinkOn_Off)): foreach($mLinkOn_Off as $key=>$vt): if(($vt) == $vo["Pid"]): ?>checked<?php endif; endforeach; endif; ?> value="<?php echo ($vo["Pid"]); ?>" class="px">
 							&nbsp;&nbsp;<?php echo ($vo["McName"]); ?>&nbsp;&nbsp;</label>
						 </span><?php endif; endforeach; endif; else: echo "" ;endif; ?>	
				    <!--非开反联动开--><?php endif; ?>
					</td>
                </tr>
                <tr>
                <tr><th></th><td><div class="s_1" style="color:#6eb805"><?php echo (L("Main_opening3")); ?></div></td></tr>
				<tr style="border-top:1px solid #eeeeee;background-color:#fcfcfc; padding:10px 0px">
                  <th><?php echo (L("Anti_linkage2")); ?>：</th>
                  <td>
                  	<?php if(($McID1) == "14"): ?><!--开关反联动关-->
					   <div id="taboff_on" class="box tab">
					 	        <ul>
							        <li class="on active"><?php echo (L("key1")); ?></li>
							        <li class="off" ><?php echo (L("key2")); ?></li>
							        <li class="off"><?php echo (L("key3")); ?></li>
						        </ul>
						  <div class="box sho" id="keyon1">
							  <?php if(is_array($myMobile)): $i = 0; $__LIST__ = $myMobile;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span class="bbox1"><label><input type="checkbox" name="Linkoff_on01[]" id="Linkoff_on01[]" <?php if(is_array($mLinkoff_on01)): foreach($mLinkoff_on01 as $key=>$vt): if(($vt) == $vo["Pid"]): ?>checked<?php endif; endforeach; endif; ?> value="<?php echo ($vo["Pid"]); ?>" class="px">&nbsp;&nbsp;<?php echo ($vo["McName"]); ?>&nbsp;&nbsp;</label></span><?php endforeach; endif; else: echo "" ;endif; ?>
						  </div>
						  <div class="box hid" id="keyon2">
							  <?php if(is_array($myMobile)): $i = 0; $__LIST__ = $myMobile;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span class="bbox1"><label><input type="checkbox" name="Linkoff_on02[]" id="Linkoff_on02[]" <?php if(is_array($mLinkoff_on02)): foreach($mLinkoff_on02 as $key=>$vt): if(($vt) == $vo["Pid"]): ?>checked<?php endif; endforeach; endif; ?> value="<?php echo ($vo["Pid"]); ?>" class="px">&nbsp;&nbsp;<?php echo ($vo["McName"]); ?>&nbsp;&nbsp;</label></span><?php endforeach; endif; else: echo "" ;endif; ?>
						  </div>
						  
						  <div class="box hid" id="keyon3">
							  <?php if(is_array($myMobile)): $i = 0; $__LIST__ = $myMobile;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span class="bbox1"><label><input type="checkbox" name="Linkoff_on03[]" id="Linkoff_on03[]" <?php if(is_array($mLinkoff_on03)): foreach($mLinkoff_on03 as $key=>$vt): if(($vt) == $vo["Pid"]): ?>checked<?php endif; endforeach; endif; ?> value="<?php echo ($vo["Pid"]); ?>" class="px">&nbsp;&nbsp;<?php echo ($vo["McName"]); ?>&nbsp;&nbsp;</label></span><?php endforeach; endif; else: echo "" ;endif; ?>
						  </div>
					  </div>
					  <!--开关反联动关-->
					 <?php else: ?>
                  	<?php if(is_array($myMobile)): $i = 0; $__LIST__ = $myMobile;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo["McID3"]) == "14"): ?><span class="bbox1"><label style="margin-bottom:0!important;">
								&nbsp;&nbsp;<?php echo ($vo["McName"]); ?>&nbsp;&nbsp;
								<label ><input class="px" name="LinkOff_On[][<?php echo ($vo["Pid"]); ?>]" type="radio" <?php if($Key_mLinkOff_On["$vo[Pid]"][0]){echo "checked";} ?> value="Key01">&nbsp;键1&nbsp;</label>
								<label ><input class="px" name="LinkOff_On[][<?php echo ($vo["Pid"]); ?>]" type="radio" <?php if($Key_mLinkOff_On["$vo[Pid]"][1]){echo "checked";} ?> value="Key02">&nbsp;键2&nbsp;</label>
								<label ><input class="px" name="LinkOff_On[][<?php echo ($vo["Pid"]); ?>]" type="radio" <?php if($Key_mLinkOff_On["$vo[Pid]"][2]){echo "checked";} ?> value="Key03">&nbsp;键3&nbsp;</label>
							</label></span>
						 <?php else: ?>
               	 	     <span class="bbox1"><label><input type="checkbox" name="LinkOff_On[]" id="LinkOff_On[]" <?php if(is_array($mLinkOff_On)): foreach($mLinkOff_On as $key=>$vt): if(($vt) == $vo["Pid"]): ?>checked<?php endif; endforeach; endif; ?> value="<?php echo ($vo["Pid"]); ?>" class="px">
 							&nbsp;&nbsp;<?php echo ($vo["McName"]); ?>&nbsp;&nbsp;</label>
						 </span><?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>
					 </td>
                </tr>
                <tr>
                  <th></th>
                  <td><button type="submit" class="btnGreen" id="saveSetting" onClick="aa()"><?php echo (L("Save")); ?></button></td>
                </tr>
              </tbody>
            </table>
            
          </div>
		  <!--<input type="hidden" name="wMB" value="<?php echo ($User["wMB"]); ?>">-->
          </form>
        </div>
        
        <div class="clr"></div>
      </div>
    </div>
  </div>
  <!--底部-->
  	</div>
<!--end main--> 
<!--footer-->
<script src="/Public/resource/common/js/Validform.js"></script>
<script type="text/javascript">
	window.onload = function(){
	    var myTab = document.getElementById("tabon");
	    var myUl = myTab.getElementsByTagName("ul")[0];
	    var myLi = myUl.getElementsByTagName("li");
	    var myDiv = myTab.getElementsByTagName("div");
	    for(var i = 0; i<myLi.length;i++){
	        myLi[i].index = i;
	        myLi[i].onclick = function(){
				
	            for(var j = 0; j < myLi.length; j++){
	                myLi[j].className="off";
	                myDiv[j].className = "box hid";
	            }
	            this.className = "on";
	            myDiv[this.index].className = "box sho";
	        }
	      }
		var color = new Array();
		color[0] = "keyon1";
		color[1] = "keyon2";
		color[2] = "keyon3";
		$("#tabon").find('ul').children('li').each(function(e){
			  $(this).click(function(){
   				 $(this).addClass(color[e]);
 		 	  });
		})
	 	var myTaboff = document.getElementById("taboff"); 
	    var myUloff = myTaboff.getElementsByTagName("ul")[0];
	    var myLioff = myUloff.getElementsByTagName("li"); 
	    var myDivoff = myTaboff.getElementsByTagName("div");
	    for(var i = 0; i<myLioff.length;i++){
	        myLioff[i].index = i;
	        myLioff[i].onclick = function(){
	            for(var j = 0; j < myLioff.length; j++){
	                myLioff[j].className="off";
	                myDivoff[j].className = "box hid";
	            }
	            this.className = "on";
	            myDivoff[this.index].className = "box sho";
	        }
	    }
	 	$("#taboff").find('ul').children('li').each(function(e){
			  $(this).click(function(){
   				 $(this).addClass(color[e]);
 		 	  });
		})

	    var myTabon_off = document.getElementById("tabon_off"); 
	    var myUlon_off = myTabon_off.getElementsByTagName("ul")[0];
	    var myLion_off = myUlon_off.getElementsByTagName("li"); 
	    var myDivon_off = myTabon_off.getElementsByTagName("div");
	    for(var i = 0; i<myLion_off.length;i++){
	        myLion_off[i].index = i;
	        myLion_off[i].onclick = function(){
	            for(var j = 0; j < myLion_off.length; j++){
	                myLion_off[j].className="off";
	                myDivon_off[j].className = "box hid";
	            }
	            this.className = "on";
	            myDivon_off[this.index].className = "box sho";
	        }
	    }
	 	$("#tabon_off").find('ul').children('li').each(function(e){
			  $(this).click(function(){
   				 $(this).addClass(color[e]);
 		 	  });
		})
	 
	 	var myTaboff_on = document.getElementById("taboff_on"); 
	    var myUloff_on = myTaboff_on.getElementsByTagName("ul")[0];
	    var myLioff_on = myUloff_on.getElementsByTagName("li"); 
	    var myDivoff_on = myTaboff_on.getElementsByTagName("div");
	    for(var i = 0; i<myLioff_on.length;i++){
	        myLioff_on[i].index = i;
	        myLioff_on[i].onclick = function(){
	            for(var j = 0; j < myLioff_on.length; j++){
	                myLioff_on[j].className="off";
	                myDivoff_on[j].className = "box hid";
	            }
	            this.className = "on";
	            myDivoff_on[this.index].className = "box sho";
	        }
	    }
		
	    $("#taboff_on").find('ul').children('li').each(function(e){
			  $(this).click(function(){
   				 $(this).addClass(color[e]);
 		 	  });
		})
	 }
	 
	//实现radio点击取消
	$("input[type=radio]").bind("click",function(){  
	    var $radio = $(this);  
	    // if this was previously checked  
	    if ($radio.data('waschecked') == true)  
	    {  
	        $radio.prop('checked', false);  
	        $radio.data('waschecked', false);  
	    }  
	    else  
	    {  
	         $radio.prop('checked', true);  
	         $radio.data('waschecked', true);  
	    }  
	    // remove was checked from other radios  
	    $radio.siblings('input[type="radio"]').data('waschecked', false);  
	});  
$(function(){
	var demo=$(".Machineryfrom").Validform({
			tiptype:3,
			label:".m_label",
			showAllError:false,
			datatype:{
				"zh1-6":/^[\u4E00-\u9FA5\uf900-\ufa2d]{1,6}$/,
				"ip":/^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/
			},
			ajaxPost:false
		});
})
</script>
<div style="clear:both"></div>
<div class="footer-top">
	<div class="container"  style="border-bottom:1px dashed #e1e1e1;padding:30px 0;">
        <div class="col-xs-8" >
        	<?php if(($langue) == "cn"): ?><ul>
                <li><a class="main-a" href="http://www.ob-hom.com/index.php?c=article&a=type&tid=24"><?php echo (L("Solution")); ?></a>
                    <ul class="child-ul">
                        <li><a href="#"><?php echo (L("Smart_Home")); ?></a></li>
                        <li><a href="#"><?php echo (L("Smart_Hotel")); ?></a></li>
                        <li><a href="#"><?php echo (L("Smart_Office")); ?></a></li>
                        <li><a href="#"><?php echo (L("Smart_Community")); ?></a></li>
                    </ul>
                </li>
                <li><a class="main-a" href="http://www.ob-hom.com/index.php?c=product&a=type&tid=25"><?php echo (L("Download")); ?></a>
                    <ul class="child-ul">
                        <li><a href="#">IOS</a></li>
                        <li><a href="#"><?php echo (L("ANDROID")); ?></a></li>
                    </ul>
                </li>
                <li><a class="main-a" href="http://www.ob-hom.com/index.php?c=article&a=type&tid=26"><?php echo (L("Join_Us")); ?></a>
                    <ul class="child-ul">
                        <li><a href="#"><?php echo (L("Requirements")); ?></a></li>
                        <li><a href="#"><?php echo (L("Message")); ?></a></li>
                    </ul>
                </li>
                <li><a class="main-a" href="http://www.ob-hom.com/index.php?c=article&a=type&tid=27"><?php echo (L("About_Us")); ?></a>
                    <ul class="child-ul">
                        <li><a href="javascript:void(0);"><?php echo (L("Company_Profile")); ?></a></li>
                        <li class="top" style="display:block;"><a href="javascript:void(0)" ><?php echo (L("SERVICE")); ?></a></li>
                    </ul>
                </li>
            </ul>
			<?php else: ?>
				  <ul>
	                <li><a class="main-a" href="http://eng.ob-hom.com/index.php?c=article&a=type&tid=24"><?php echo (L("Solution")); ?></a>
	                    <ul class="child-ul">
	                        <li><a href="#"><?php echo (L("Smart_Home")); ?></a></li>
	                        <li><a href="#"><?php echo (L("Smart_Hotel")); ?></a></li>
	                        <li><a href="#"><?php echo (L("Smart_Office")); ?></a></li>
	                        <li><a href="#"><?php echo (L("Smart_Community")); ?></a></li>
	                    </ul>
	                </li>
	                <li><a class="main-a" href="http://eng.ob-hom.com/index.php?c=product&a=type&tid=25"><?php echo (L("Download")); ?></a>
	                    <ul class="child-ul">
	                        <li><a href="#">IOS</a></li>
	                        <li><a href="#"><?php echo (L("ANDROID")); ?></a></li>
	                    </ul>
	                </li>
	                <li><a class="main-a" href="http://eng.ob-hom.com/index.php?c=article&a=type&tid=26"><?php echo (L("Join_Us")); ?></a>
	                    <ul class="child-ul">
	                        <li><a href="#"><?php echo (L("Requirements")); ?></a></li>
	                        <li><a href="#"><?php echo (L("Message")); ?></a></li>
	                    </ul>
	                </li>
	                <li><a class="main-a" href="http://eng.ob-hom.com/index.php?c=article&a=type&tid=27"><?php echo (L("About_Us")); ?></a>
	                    <ul class="child-ul">
	                        <li><a href="javascript:void(0);"><?php echo (L("Company_Profile")); ?></a></li>
	                        <li class="top" style="display:block;"><a href="javascript:void(0)" ><?php echo (L("SERVICE")); ?></a></li>
	                    </ul>
	                </li>
	            </ul><?php endif; ?>
        </div>
        <div class="col-xs-4 tonline">
            <button type="button" class="btn btn-danger">
                <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span><?php echo (L("service_hotline")); ?>
            </button>
            <h1 style="color:#060001;">0578-2199999</h1>
            <p><?php echo (L("WORK_TIME")); ?></p>
        </div>
    </div>
</div>
<footer id="footer">
	<div class="container">
		<p style="color:#343434;"><?php echo (L("Company")); ?></p>
		<p><?php echo (L("Company_S")); ?> © <?php echo (L("All_Reserved")); ?> <?php echo (L("Copy")); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo (L("Adress")); ?></p>
	</div>
</footer>



<script src="js/bootstrap.min.js"></script>
<script type="text/javascript">
	// //设置垂直居中
	// $('.carousel-control').css('line-height', $('.carousel-inner img').height() + 'px');
	// $(window).resize(function () {
	// 	var $height = $('.carousel-inner img').eq(0).height() || 
	// 				  $('.carousel-inner img').eq(1).height() || 
	// 				  $('.carousel-inner img').eq(2).height();
	// 	$('.carousel-control').css('line-height', $height + 'px');
	// });

	//设置文字垂直居中，谷歌浏览器加载图片的顺序问题，导致高度无法获取
	$(window).load(function () {
		$('.text').eq(0).css('margin-top', ($('.auto').eq(0).height() - $('.text').eq(0).height()) / 2 + 'px');
	});
	

	$(window).resize(function () {
		$('.text').eq(0).css('margin-top', ($('.auto').eq(0).height() - $('.text').eq(0).height()) / 2 + 'px');
	});

	$(window).load(function () {
		$('.text').eq(1).css('margin-top', ($('.auto').eq(1).height() - $('.text').eq(1).height()) / 2 + 'px');
	});

	$(window).resize(function () {
		$('.text').eq(1).css('margin-top', ($('.auto').eq(1).height() - $('.text').eq(1).height()) / 2 + 'px');
	});

</script>
<!--end footer--> 
</body>
</html>