<?php
class PublicAction extends Action{
	public function verify(){
	    import('ORG.Util.Image');
	    Image::buildImageVerify();
	}
	
	public function alipaynotify(){
		header("Content-Type:text/html;charset=utf-8");
	
		//配置文件
		/************************************************************/
		//合作身份者id，以2088开头的16位纯数字
		$alipay_config['partner']		= C('alipay_partner');
	
		//安全检验码，以数字和字母组成的32位字符
		$alipay_config['key']			= C('alipay_key');
	
		//签名方式 不需修改
		$alipay_config['sign_type']    = C('alipay_sign_type');
	
		//字符编码格式 目前支持 gbk 或 utf-8
		$alipay_config['input_charset']= C('alipay_input_charset');
	
		//ca证书路径地址，用于curl中ssl校验
		//请保证cacert.pem文件在当前文件夹目录中
		$alipay_config['cacert']    = C('alipay_cacert');
	
		//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
		$alipay_config['transport']    = C('alipay_transport');
	
		Vendor('Alipay.lib.Alipaynotify');
	
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();
	
		if($verify_result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代
	
	
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
	
			//获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
	
			//商户订单号
	
			$out_trade_no = $_POST['out_trade_no'];
	
			//支付宝交易号
	
			$trade_no = $_POST['trade_no'];
	
			//交易状态
			$trade_status = $_POST['trade_status'];
	
			$total_fee = $_POST['total_fee']; //支付金额
			$buyer_email = $_POST['buyer_email']; //买家账号
	
	
			if($_POST['trade_status'] == 'WAIT_BUYER_PAY') {
				//该判断表示买家已在支付宝交易管理中产生了交易记录，但没有付款
	
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序
					
				echo "success";		//请不要修改或删除
	
				//调试用，写文本函数记录程序运行情况是否正常
				//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
			}
			else if($_POST['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {
				//该判断表示买家已在支付宝交易管理中产生了交易记录且付款成功，但卖家没有发货
	
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序
					
				echo "success";		//请不要修改或删除
	
				//调试用，写文本函数记录程序运行情况是否正常
				//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
			}
			else if($_POST['trade_status'] == 'WAIT_BUYER_CONFIRM_GOODS') {
				//该判断表示卖家已经发了货，但买家还没有做确认收货的操作
	
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序
					
				echo "success";		//请不要修改或删除
	
				//调试用，写文本函数记录程序运行情况是否正常
				//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
			}
			else if($_POST['trade_status'] == 'TRADE_FINISHED') {
	
	
	
				$Pay=M('Pay');
				$where['out_trade_no']=$out_trade_no;
				$pay=$Pay->where($where)->find();
				$status=$pay['status'];
	
				if($status==0){
					$data['status']=1;
					$data['trade_no']=$trade_no;
					$data['total_fee']=$total_fee;
					$data['buyer_email']=$buyer_email;
					$data['pay_time']=time();
					$paysave = $Pay->where($where)->save($data);
	
					//更新用户余额
					$User=M('User');
					$map['uid']=$pay['userid'];
					$userdata=$User->where($map)->find();
					$money=$userdata['money']+$total_fee;
					$moneysave=$User->where($map)->setField('money',$money);
	
					/*
					 if(!$paysave){
					$this->error('在线支付出错',U('Payment/pay'));
					}elseif(!$moneysave){
					$this->error('金额入账出错',U('Payment/pay'));
					}
	
					$this->success('支付成功',U('Payment/pay'));
					*/
				}
	
					
				echo "success";		//请不要修改或删除
	
				//调试用，写文本函数记录程序运行情况是否正常
				//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
			}
			else {
				//其他状态判断
				echo "success";
	
				//调试用，写文本函数记录程序运行情况是否正常
				//logResult ("这里写入想要调试的代码变量值，或其他运行的结果记录");
			}
	
			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
		else {
			//验证失败
			echo "fail";
	
			//调试用，写文本函数记录程序运行情况是否正常
			//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		}
	}
}
?>