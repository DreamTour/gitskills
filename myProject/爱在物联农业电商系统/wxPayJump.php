<?php
include "../ku/configure.php";
//利用商品ID号实现付款
if($get['type'] == "goods"){
    $type = "线下扫码支付";
}
$total = '10';
echo head("m");
?>
<form id="payForm" name="payForm" method="post" action="<?php echo root."pay/wxpay/wxpay.php";?>">
    <input name="orderType" type="hidden" value="<?php echo $type;?>">
    <input name="orderId" type="hidden" value="<?php echo $get['id'];?>">
    <input type="hidden" name="money" value="<?php echo $total;?>">
    <input type="submit" class="confrim" value="立即支付">
</form>
<script>
    window.onload = function() {
        document.getElementById('payForm').submit();
    }
</script>