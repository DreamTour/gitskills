<?php
include "../../library/mFunction.php";
$dealer = query("kehu","khid = '$kehu[khid]' and type = '经销商'");
if (empty($kehu['integral'])) {
    $kehu['integral'] = 0;
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
<div class="container mUser">
    <div class="user mui-ptop45 ">
        <a href="<?php echo root;?>m/mUser/mUsInfo.php">
            <img src="<?php echo img('VEt67369162dy');?>" />
            <div class=" user-info mui-dis-flex">
                <div class="head-img"><img src="<?php echo $kehu['wxIco'];?>"/></div>
                <div class="flex1 mui-dis-flex">
                    <label class="flex1"><?php echo $kehu['wxNickName'];?><!-- <i class="level">V1</i> --><br/><?php echo $kehu['tel'];?></label>
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
                <a href="<?php echo root;?>m/mAbout.php" class="mui-dis-flex">
                    <span class="flex1">关于我们</span>
                    <span class="more">&#xe683;</span>
                </a>
            </li>
        </ul>
        <?php
        if (!empty($dealer['khid'])) {
            ?>
           <!-- <ul class="mui-mtop10 user-wrap-style1">
                <li>
                    <a href="<?php /*echo root;*/?>m/mAbout.php" class="mui-dis-flex">
          <span class="flex1">经销商端口<br>
              <?php /*echo root.'m/mindex.php?did='.$dealer['khid'];*/?></span>
                        <span class="more">&#xe683;</span>
                    </a>
                </li>
            </ul>-->
        <?php }?>
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