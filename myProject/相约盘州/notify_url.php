<?php
require_once("alipay_function.php");
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();
if($verify_result){//验证成功
	if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS'){//如果订单已经完成
		$RechargeId = $_POST['out_trade_no'];//支付宝返回的订单号，与recharge表的id号保持一致
		$pay = $_POST['total_fee'];//客户刚刚在支付宝已经支付的金额
		$Recharge = query("recharge"," id = '$RechargeId' ");//订单支付记录表
		$kehu = query("kehu"," khid = '$Recharge[TargetId]' ");//此客户的基本资料
		if(empty($RechargeId)){//如果支付宝返回的订单号为空
			test("支付宝返回的充值订单号为空，金额{$pay}");
		}elseif($Recharge['id'] != $RechargeId){//如果支付宝返回的订单号在我们的数据库的订单记录表中找不到对应的记录
			test("未找到与支付宝返回的充值订单号匹配的预支付记录，订单号：{$RechargeId}");
		}elseif($Recharge['money'] != $pay){//如果客户实际支付的金额和订单记录表中的金额不匹配
			test("支付宝返回的交易总金额与预支付记录里面的金额不匹配，订单号：{$RechargeId}");
		}elseif($Recharge['WorkFlow'] != "未支付"){
			test("支付宝异步返回时，订单不处于“未支付”状态，订单号：{$RechargeId}");
		}elseif(empty($Recharge['TargetId'])){//如果此订单记录表中客户的ID号为空
			test("预支付记录里面的目标对象id号为空，订单号：{$RechargeId}");
		}elseif($Recharge['TargetId'] != $kehu['khid']){
			test("未找到预支付记录里面的目标对象，订单号：{$RechargeId}");
		}else{
			if($Recharge['type'] == "会员升级"){
			    if($Recharge['TypeId'] == 2){
				    $Grade = "银牌会员";	
				}elseif($Recharge['TypeId'] == 3){
				    $Grade = "金牌会员";	
				}elseif($Recharge['TypeId'] == 4){
				    $Grade = "钻石会员";	
				}elseif($Recharge['TypeId'] == 5){
				    $Grade = "红娘会员";	
				}else{
					$Grade = "铜牌会员";
				}
				mysql_query(" update kehu set Grade = '$Grade',UpdateTime = '$time' where khid = '$kehu[khid]' ");
				mysql_query(" update recharge set WorkFlow = '已支付',UpdateTime = '$time' where id = '$RechargeId' ");
				test("一切正常，会员升级，订单号：{$RechargeId}");	
			}elseif($Recharge['type'] == "赠送礼物"){
				$id = suiji();
				mysql_query("insert into GiftGive (id,khid,TargetId,GiftId,time) 
				values ('$id','$kehu[khid]','$Recharge[TypeId]','$Recharge[GiftId]','$time') ");
				mysql_query(" update recharge set WorkFlow = '已支付',UpdateTime = '$time' where id = '$RechargeId' ");
				test("一切正常，送礼物，订单号：{$RechargeId}");
			}elseif($Recharge['type'] == "本地通"){
				$id = suiji();
				mysql_query("insert into Enroll (id,type,khid,ContentId,time)
				values ('$id','本地通','$kehu[khid]','$Recharge[TypeId]','$time')");
				mysql_query(" update recharge set WorkFlow = '已支付',UpdateTime = '$time' where id = '$RechargeId' ");
				test("一切正常，送礼物，订单号：{$RechargeId}");
			}else{
			    test("未知执行指令，订单号：{$RechargeId}");	
			}
		}
    }
	echo "success";
}else{
    echo "fail";
	test("支付宝异步返回验证失败");
}
?>