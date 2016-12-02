<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo (L("Equipment")); ?></title>
<link rel="stylesheet" href="/Public/resource/common/css/base.css" >
<link rel="stylesheet" href="/Public/resource/common/css/page.css">
<link rel="stylesheet" href="/Public/resource/common/css/user.css">
<link rel="shortcut icon" href="/Public/resource/common/images/favicon.ico" type="image/x-icon" />
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
<div class="jumppage" style="display:none;">
	<div class="t_1"><?php echo (L("Box_name")); ?></div>
	<div class="tx1"></div>
	<input type="button" class="btn2" id="Jq_sure" value="<?php echo (L("Sure")); ?>">
	<input type="button" class="btn3" id="Jq_no" value="<?php echo (L("Cancel")); ?>">
</div>
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

          <div class="msgWrap">
            <TABLE class="ListProduct" border="0" cellSpacing="0" cellPadding="0" width="100%">
              <THEAD>
                <TR>
                  <TH><?php echo (L("Equipment")); ?></TH>
				 
                  <TH width="30%"><?php echo (L("Operation")); ?></TH>
                </TR>
              </THEAD>
              <TBODY>
                <TR></TR>
                <?php if(is_array($myMobile)): $i = 0; $__LIST__ = $myMobile;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><TR>
                  <TD><p><?php echo ($vo["McName"]); ?></p></TD>
				  
                  <TD class="norightborder" id="data_<?php echo ($vo["Pid"]); ?>" dataName="<?php echo ($vo["McName"]); ?>">
				  <a href="/index.php/Home/Mobile/edit/id/<?php echo ($vo["Pid"]); ?>/" class="btnGreens" ><?php echo (L("Edit")); ?></a>
				  <a href="javascript:Jq_del(<?php echo ($vo["Pid"]); ?>,this)" class="btnGreens btndel" ><?php echo (L("Delete")); ?></a>
				  </TD>
                </TR><?php endforeach; endif; else: echo "" ;endif; ?>
				
              </TBODY>
            </TABLE>

            <?php if(!empty($page)): ?><div style="float:right;margin:20px 186px 0 0;" class="badoo"><?php echo ($page); ?></div><?php endif; ?>
        
          </div>
          
          <div class="cLine">
            <div class="pageNavigator right">
              <div class="pages"></div>
            </div>
            <div class="clr"></div>
          </div>
        </div>
        
        <div class="clr"></div>
      </div>
    </div>
  </div>
  <!--底部-->
  	</div>
<!--end main--> 
<!--footer-->
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
<script type="text/javascript">
	function Jq_del(id){
		//var name = name;
		var name = $('#data_'+id).attr("dataName");
		$('.jumppage > .tx1').html('<?php echo (L("Confirm_delete")); ?>  '+'['+name+']');
		$('.jumppage_bg, .jumppage').show();
		//ajax_del(id);
		$('#Jq_sure').click(function(){
			var url = "/index.php/Home/Mobile/del/id/"+id;
			//$('.jumppage_bg, .jumppage').hide();
			//$('#data_'+id).remove();
			window.location.href = url;			
			$(this).attr("disabled","disabled");
		});
	};
	$('#Jq_no').click(function(){
		$('.jumppage_bg, .jumppage').hide();	
	});
</script>
<!--end footer--> 
</body>
</html>