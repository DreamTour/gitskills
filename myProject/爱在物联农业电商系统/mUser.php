<?php
include "../../library/mFunction.php";
$client = query("kehu", "khid = '$kehu[khid]' and staff = '是' ");
if ($client['khid']) {
    $mUsQRCode = "
            <li>
                <a href='{$root}m/mUser/mUsQRCode.php' class='mui-dis-flex'>
                    <span class='flex1'>推荐二维码</span>
                    <span class='more'>&#xe683;</span>
                </a>
            </li>
    ";
    $myClient = "
        <li>
                <a href='{$root}m/mUser/mUsShare.php?type=ordinary' class='mui-dis-flex'>
                    <span class='flex1'>普通客户</span>
                    <span class='more'>&#xe683;</span>
                </a>
            </li>
            <li>
                <a href='{$root}m/mUser/mUsShare.php?type=vip' class='mui-dis-flex'>
                    <span class='flex1'>vip客户</span>
                    <span class='more'>&#xe683;</span>
                </a>
            </li>
    ";
}
else {
    $mUsQRCode = "";
    $myClient = '';
}
//是否显示VIP
$clientV = query("kehu", "khid = '$kehu[khid]' AND type = 'vip会员' ");
if ($clientV['khid']) {
    $level = "
            <i class='level'>VIP</i>
    ";
}
echo head("m");
?>
<!--头部-->
<div class="header header-fixed">
    <div class="nesting"> <a href="#" class="header-btn header-return"><span class="return-ico">&#xe600;</span></a>
        <div class="align-content">
            <p class="align-text">个人中心</p>
        </div>
        <a href="#" class="header-btn"></a>
    </div>
</div>
<!--//-->
<!--会员中心-->
<div class="container">
    <div class="user mui-ptop45 ">
        <a href="<?php echo root;?>m/mUser/mUsInfo.php">
            <img src="<?php echo img('VEt67369162dy');?>" />
            <div class=" user-info mui-dis-flex">
                <div class="head-img"><img src="<?php echo $kehu['wxIco'];?>"/></div>
                <div class="flex1 mui-dis-flex">
                    <label class="flex1"><?php echo $kehu['wxNickName'];?><?php echo $level;?><br/><?php echo $kehu['tel'];?></label>
                    <span class="more">&#xe683;</span>
                </div>
            </div>
        </a>
        <!--我的订单状态-->
        <ul class="order-state mui-dis-flex">
            <li><a href="<?php echo $root.'m/mUser/mUsOrder.php?status=已选定';?>"><span class="order-state1">&#xe655;</span><p>待付款</p></a></li>
            <li><a href="<?php echo $root.'m/mUser/mUsOrder.php?status=已付款';?>"><span class="order-state2">&#xe661;</span><p>待发货</p></a></li>
            <li><a href="<?php echo $root.'m/mUser/mUsOrder.php?status=已发货';?>"><span class="order-state3">&#xe656;</span><p>待收货</p></a></li>
            <li><a href="<?php echo root;?>m/mUser/mUsAddress.php"><span class="order-state4">&#xe60b;</span><p>地址管理</p></a></li>
        </ul>
        <!--//-->
        <ul class="mui-mtop10 user-wrap-style1">
            <li>
                <a href="javascript:;" class="mui-dis-flex">
                    <span class="flex1">我的积分</span>
                    <span class="more"><?php echo $kehu['integral'];?></span>
                </a>
            </li>
            <li>
                <a href="<?php echo root;?>m/mUser/mUsOrder.php" class="mui-dis-flex">
                    <span class="flex1">我的订单</span>
                    <span class="more">&#xe683;</span>
                </a>
            </li>
        </ul>
        <ul class="mui-mtop10 user-wrap-style1">
            <li>
                <a href="<?php echo root;?>m/mUser/mUsBuyCar.php" class="mui-dis-flex">
                    <span class="flex1">购物车</span>
                    <span class="more">&#xe683;</span>
                </a>
            </li>
            <li>
                <a href="<?php echo root;?>m/mUser/mUsReceive.php" class="mui-dis-flex">
                    <span class="flex1">领取中心</span>
                    <span class="more">&#xe683;</span>
                </a>
            </li>
            <?php echo $mUsQRCode.$myClient;?>
        </ul>
    </div>
</div>
<!--//-->
<!--底部-->
<?php echo  mWarn().Footer(); ?>
<!--//-->
<script>
    $(function(){
        changeNav();
    })
</script>
</body>
</html>