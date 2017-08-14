<?php 
require_once("alipay_function.php");
echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";//不能删除，否则提交的中文会出现乱码
//赋值
$type = $_POST['type'];//支付的类型
if(empty($type)){
	$_SESSION['warn'] = "支付的类型为空";
	header("Location:".getenv("HTTP_REFERER"));
	exit(0);
}
//核算需要支付的金额
if($type == "会员升级"){
    $TypeId = $_POST['GradeNum'];//支付的名称
	if($TypeId == 2){
		$money = website("DDf52623284iE");
	}elseif($TypeId == 3){
		$money = website("zQl52623335uv");
	}elseif($TypeId == 4){
		$money = website("GCD52623356LP");
	}elseif($TypeId == 5){
		$money = website("Sqc52623372XS");
	}else{
		$money = 0;	
	}
}elseif($type == "赠送礼物"){
	$GiftId = $_POST['GiftId'];//礼物的ID号
	$TypeId = $_POST['TypeId'];//被送礼物客户的ID号
	$gift = mysql_fetch_array(mysql_query("select * from Gift where id = '$GiftId' "));
	$money = $gift['price'];	
}elseif($type == "本地通"){
	$TypeId = $_POST['tourId'];//旅游的ID号
	$tour = mysql_fetch_array(mysql_query("select * from content where id = '$TypeId' "));
	$money = $tour['money'];
}
$ordid = rand(10000,99999).time();
$parameter = array(
	"service" => "create_direct_pay_by_user",
	"partner" => $alipay_config['partner'],
	"_input_charset"	=> trim(strtolower($alipay_config['input_charset'])),
	"seller_email" => trim($alipay_config['seller_email']),
	"payment_type"	=> "1",//支付类型,必填，不能修改
	"notify_url"	=> "{$this_url}notify_url.php",//服务器异步通知页面路径,需http://格式的完整路径，不能加?id=123这类自定义参数
	"return_url"	=> "{$this_url}return_url.php",//页面跳转同步通知页面路径,需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhos
	"out_trade_no"	=> $ordid,//商户订单号,商户网站订单系统中唯一订单号，必填
	"subject"	=> $type,//订单名称
	"total_fee"	=> $money,//付款金额,必填
	"body"	=> "",//订单描述
	"show_url"	=> "",//商品展示地址,需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html
	"anti_phishing_key"	=> "",//防钓鱼时间戳,若要使用请调用类文件submit中的query_timestamp函数
	"exter_invoke_ip"	=> "", //客户端的IP地址,非局域网的外网IP地址，如：221.0.0.1
	//如果要使用纯网关支付，则以下两个为必填选项，paymethod的值必须为bankPay，如果是支付宝即时到账，则以下两个接口为空
	"defaultbank"	=> "",//默认网银，必填，银行简码请参考接口技术文档
	"paymethod"	=> ""//默认支付方式，必填
);
//建立预支付记录
mysql_query(" insert into recharge (id,Target,TargetId,type,TypeId,GiftId,money,text,WorkFlow,UpdateTime,time) 
values ('$ordid','客户支付宝支付','$kehu[khid]','$type','$TypeId','$GiftId','$money','$type','未支付','$time','$time')");
//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
echo $html_text;
?>