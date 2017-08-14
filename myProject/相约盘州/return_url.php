<?php
require_once("alipay_function.php");
//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {//验证成功
	if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS'){
		header("Location:{$root}user/user.php");
	}else{
		$warn = "验证成功，但支付失败，trade_status=".$_GET['trade_status'];
	}
}else{
	$warn = "验证失败";
}
echo $warn;
?>