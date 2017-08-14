<?php
$_SESSION['khid'] = "QmK62021709Mj";
include "library/mFunction.php";
$_SESSION['khid'] = "QmK62021709Mj";
//查询分类套餐
$result = mysql_query("SELECT * FROM payGroup WHERE 1=1 ORDER BY money ASC LIMIT 0,6");
$x=0;
while ($arr = mysql_fetch_assoc($result)) {
    $x++;
    $giftMoney = round($arr['money'] * $arr['percent'] / 100,2); //赠送金额
    $total = round($arr['money'] + $giftMoney,2); //总到账金额
    if ($x == 1) {
        $liStr = "<li data-money='{$arr['money']}' data-id='{$arr['id']}' data-total='{$total}' class='checked'>
                    <strong>{$arr['money']} 元</strong>
                    <span>赠送：<em>{$giftMoney}</em>元</span>
                 </li>";
    }else{
        $liStr = "<li data-money='{$arr['money']}' data-id='{$arr['id']}' data-total='{$total}'>
                    <strong>{$arr['money']} 元</strong>
                    <span>赠送：<em>{$giftMoney}</em>元</span>
                 </li>";
    }
    $payGroup .= $liStr; //串接输出
}
echo head("m");
?>
<div class="ploading">
    <div class="load-container load">
        <div class="loader">Loading...</div>
    </div>
</div>
<div class="wrap">
    <!-- 充值金额 -->
    <div class="kwsydiv2 wrap-box">
        <div class="title">
            <h3><i class='icon'>&#xe603;</i> 充值金额</h3>
        </div>
        <div class="content">
            <div class="minute-template" id="minuteTemplate">
                <div class="shade-box">
                    <div class="pay">
                        <ul class="clearfix" id="moneyList">
                            <!-- 套餐 -->
                            <?php echo $payGroup; ?>
                        </ul>
                        <div class="line"></div>
                        <!-- 充值 -->
                        <form id='userPay' action='<?php echo $root.'pay/wxpay/wxpay.php'?>' method='post'>
                            <input type="hidden" name="orderType" value="余额充值">
                            <input type="hidden" name="money" id="money" value="20">
                            <input type="hidden" name="orderId" id="orderId" value="OnZ71538718kG">
                        </form>
                        <div class="pay-box clearfix">
                            <a class="pay-confirm-btn" onclick="$('#userPay').submit();">立即充值</a>
                            <!--<a class="pay-close-btn" href="javascript:void(0);" id="minute-shade-close">取消</a>-->
                        </div>
                        <p id="payText">可到账￥<span id="actual-money">0</span> <?php echo $unit;?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="kwsydiv3 wrap-box">
        <div class="title">
            <h3><i class='icon'>&#xe62a;</i> 说明</h3>
        </div>
        <div class="content" id="content"><?php echo website("PVS56581187NW");?></div>
    </div>
    <!-- 专项通道 -->
    <div class="wrap-box box">
        <div class="title">
            <h3><i class="icon">&#xe640;</i> 激活充值</h3>
        </div>
        <div class="content">
            <form name="verificationCodeForm" class="verificationCodeForm">
                <span>激活码：</span>
                <input name="verificationCode" type="text" id="pid" />
                <div class="morediv">
                    <a id="activation" href="javascript:;">激活&gt;&gt;</a>
                </div>
            </form>
        </div>
    </div>
    <!-- 专项通道 end -->
    <!-- 充值金额 end -->
    <div class="kwsydiv3 wrap-box">
        <div class="title">
            <h3><i class='icon'>&#xe62a;</i> 有奖问答</h3>
            <!--<i class='exclamation-icon'>&#xe628;</i>-->
        </div>
        <div class="content"><a href="<?php echo root."m/mUser/mUsActivity.php";?>">
                <p>点击查看当前活动，有好礼相赠>></p>
            </a></div>
    </div>
</div>
<script>
    $(document).ready(function() {
        //激活提交
        $("#activation").on('click', function() {
            var pid = $("#pid").val();
            $.post(root + 'library/mData.php?type=uCode', { pid: pid }, function(data) {
                if (data.warn == 2) {
                    if (data.href) {
                        window.location.href = data.href;
                    } else {
                        window.location.reload();
                    }
                } else {
                    mwarn(data.warn);
                }
            }, 'json');
        });
    });
    window.onload = function() {
        /**
         * 计算金额
         * @author He Hui
         * */
        //找元素
        var minuteTemplate = document.getElementById('minuteTemplate');
        var liSet = minuteTemplate.querySelectorAll('li');
        var rechargeBtn = document.getElementById('rechargeBtn');
        var moneyList = document.getElementById('moneyList');
        var money = document.getElementById('money');
        var orderId = document.getElementById('orderId');

        //计算
        var dataTotal = liSet[0].getAttribute('data-total');
        var actualMoneyElement = document.getElementById('actual-money');

        //初始化
        var dataMoney = liSet[0].getAttribute('data-money');
        var dataId = liSet[0].getAttribute('data-id');
        actualMoneyElement.innerHTML =  dataTotal;
        money.value = dataMoney;
        orderId.value = dataId;

        //切换金额
        for (var i=0;i<liSet.length;i++) {
            liSet[i].onclick = function() {
                for (var i=0;i<liSet.length;i++) {
                    liSet[i].className = '';
                }
                this.className = 'checked';
                var dataMoney = this.getAttribute('data-money');
                var dataId = this.getAttribute('data-id');
                var strongDataTotal = this.getAttribute('data-total');
                money.value = dataMoney;
                orderId.value = dataId;
                actualMoneyElement.innerHTML = strongDataTotal;
            }

        }
    }
</script>
<?php echo mWarn().footer();?>
</body></html>