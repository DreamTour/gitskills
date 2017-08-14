<?php
include "../mLibrary/mFunction.php";
$repStr = para("rechargePackage"); //充值套餐
$regArr = explode("，",$repStr);
foreach ($regArr as $key => $value) {
    if ($key == 0) {
        $liStr = "<li class='checked' data-money='{$value}'>{$value} 元</li>";
    }else{
        $liStr = "<li data-money='{$value}'>{$value} 元</li>";
    }
    $rechargePackage .= $liStr;
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
                            <?php echo $rechargePackage; ?>
                        </ul>
                        <div class="line"></div>
                        <!-- 充值 -->
                        <form id='userPay' action='<?php echo $root.'pay/wxpay/wxpay.php'?>' method='post'>
                            <input name="orderType" type="hidden" value="余额充值">
                            <input name="money" id="money" type="hidden" value="100">
                        </form>
                        <div class="pay-box clearfix">
                            <a class="pay-confirm-btn" onclick="$('#userPay').submit();">充&nbsp;&nbsp;值</a>
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
                <input name="verificationCode" type="text" id="verificationCode" />
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
    window.onload = function() {

        //激活提交
        var activation = document.getElementById('activation');
        var value = document.getElementById('verificationCode').value;
        activation.onclick = function() {
            $.ajax({
                url: '<?php echo $root;?>m/mLibrary/mData.php',
                data: {value: value},
                type: 'POST',
                dataType: 'json',
                success: function() {
                    mwarn(data.warn);
                },
                error: function() {
                    alert("错误");
                }
            })
        }

        /**
         * 计算金额
         * @author He Hui
         * */
        //找元素
        var minuteTemplate = document.getElementById('minuteTemplate');
        var liSet = minuteTemplate.querySelectorAll('li');
        var rechargeBtn = document.getElementById('rechargeBtn');
        var moneyList = document.getElementById('moneyList');
        var moneyLi = moneyList.getElementsByTagName('li')[0];
        var dataMoney = moneyLi.getAttribute('data-money');
        var money = document.getElementById('money');

        //金额
        money.value = dataMoney;
        var actualRecharge = "<?php echo para("actualRecharge");?>" ;//到账比例

        //乘法函数
        function accMul(arg1,arg2) {
            var m=0,s1=arg1.toString(),s2=arg2.toString();
            try{m+=s1.split(".")[1].length}catch(e){}
            try{m+=s2.split(".")[1].length}catch(e){}
            return  Number(s1.replace(".",""))*Number(s2.replace(".",""))/Math.pow(10,m)
        }

        //计算
        var actualMoney = accMul(money.value,actualRecharge);
        var actualMoneyElement = document.getElementById('actual-money');

        //到账金额
        actualMoneyElement.innerHTML =  actualMoney;

        //切换金额
        for (var i=0;i<liSet.length;i++) {
            liSet[i].onclick = function() {
                for (var i=0;i<liSet.length;i++) {
                    liSet[i].className = '';
                }
                this.className = 'checked';
                var dataMoney = this.getAttribute('data-money');
                money.value = dataMoney;
                var actualMoney = accMul(money.value,actualRecharge);
                actualMoneyElement.innerHTML =  actualMoney;
            }
        }
    }
</script>
<?php echo mWarn().footer();?>
</body></html>