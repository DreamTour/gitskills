<?php
include dirname(dirname(__FILE__))."/control/ku/configure.php";
/********创建支付订单********************************************************/
function payForm($type,$kehu){
    //赋值
    $time = date("Y-m-d H:i:s");
    $orderType = $_POST['orderType'];//订单类型，一般从支付表单提交过来
    // $orderIdGroup = json_encode($_POST['orderId']);//需要支付的订单ID号集合
    $orderIdGroup = json_encode(explode(",",$_POST['orderId']));//需要支付的订单ID号集合
    $result['money'] = round($_POST['money'],2);//本次需要支付的总金额
    //判断
    if(empty($orderType)){
        $result['warn'] = "订单类型为空";
    }elseif(empty($orderIdGroup)){
        $result['warn'] = "订单ID号为空";
    }elseif(empty($result['money'])){
        $result['warn'] = "支付金额为空";
    }elseif(empty($kehu)){
        $result['warn'] = "您未登录";
    }elseif($result['money'] == 0){
        $result['warn'] = "支付金额为零";
    }else{
        //建立预支付记录
        $result['orderId'] = rand(10,99).time().rand(10,99);
        $bool = mysql_query(" insert into pay (id,type,target,targetId,orderType,orderIdGroup,money,workFlow,updateTime,time)
        values ('$result[orderId]','$type','客户','$kehu[khid]','$orderType','$orderIdGroup','$result[money]','未支付','$time','$time')");
        if(!$bool){
            $result['warn'] = "建立预支付记录失败";
        }
    }
    //返回
    return $result;
}
/********支付回调处理函数********************************************************/
//$PayId为返回的订单号，$money返回的是本次支付的金额（单位为元）
function pay($orderId,$PayId,$money){
    //赋值
    $time = date("Y-m-d H:i:s");
    $pay = query("pay"," id = '$orderId' ");//订单支付记录表
    //判断
    if(empty($orderId)){
        test("充值订单号为空，金额{$money}，交易号：{$PayId}");
    }elseif($pay['id'] != $orderId){
        test("未找到与订单号匹配的支付记录，订单号：{$orderId}，交易号：{$PayId}");
    }elseif($pay['money'] != $money){
        test("返回的交易总金额（{$money}）与订单支付记录表里面的金额（{$pay['money']}）不匹配，订单号：{$orderId}，交易号：{$PayId}");
    }elseif($pay['workFlow'] != "未支付"){
        test("异步返回时，订单不处于“未支付”状态，订单号：{$orderId}，交易号：{$PayId}");
    }else{
        if($pay['orderType'] == "购物车"){
            $bool = mysql_query(" update pay set
            payId = '$PayId',
            workFlow = '已支付',
            updateTime = '$time' where id = '$orderId' ");
            if($bool){
                buycarPay($pay['orderIdGroup']);
            }else{
                test("订单表更新失败，订单号：{$orderId}，交易号：{$PayId}");
            }
        }else{
            test("未知执行指令，订单号：{$orderId}，交易号：{$PayId}");
        }
    }
}
/*
 * 订单表处理函数
 * $orderIdGroup 订单集合
 */
function buycarPay($orderIdGroup){
    $time = date("Y-m-d H:i:s");
    if (empty($orderIdGroup)) {
        return false;
    }
    // 转换成数组
    $orderIdArr = json_decode($orderIdGroup);
    foreach ($orderIdArr as $id) {
        $buycarSql = query("buycar", "id = '$id' ");
        $paySql = query("pay", "targetId = '$buycarSql[khid]' ");
        mysql_query("UPDATE buycar SET WorkFlow='已付款',payTime='$time',updateTime='$time' WHERE id = '$id'");
        $payMoney = $paySql['money'];
        if ($payMoney >= 5000) {
            $integral = $payMoney * 0.25;
           mysql_query("UPDATE kehu SET integral = integral + '$integral',updateTime='$time' WHERE khid = '$buycarSql[khid]'");
        }
    }
    return true;
}
/*
 * 检测用户是否带有经销商ID
 */
function checkDealer($did){
    if (!empty($did) && $did != $kehu['khid'] ) {
        $kehu = query("kehu","khid = '$_SESSION[khid]' ");
        $dealer = query("kehu","khid = '{$did}' and type = '经销商' ");
        if (empty($kehu['dealerID']) && !empty($dealer['khid'])) {
            mysql_query("UPDATE kehu SET dealerID ='{$did}' WHERE khid = '$_SESSION[khid]' ");
        }
    }
}
?>