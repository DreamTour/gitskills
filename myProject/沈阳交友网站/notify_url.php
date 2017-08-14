<?php
require_once("alipay_function.php");
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();
if($verify_result){//验证成功
	if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS'){//如果订单已经完成
		$PayId = $_POST['out_trade_no'];//支付宝返回的订单号，与recharge表的id号保持一致
		$money = $_POST['total_fee'];//客户刚刚在支付宝已经支付的金额
		pay($PayId,$money);
    }
	echo "success";
}else{
    echo "fail";
	test("支付宝异步返回验证失败");
}
?>