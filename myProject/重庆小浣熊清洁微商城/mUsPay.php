<?php
include "../../library/mFunction.php";
$id = $get['order'];
$buycar = query("buycar","id = '$id' and khid='$kehu[khid]' ");
if (empty($buycar['id'])) {
    $_SESSION['warn'] = "对不起，订单信息错误";
    header("Location:{$root}m/mUser/mUser.php");
    exit();
}else{
    $Region = query("region", "id = '$buycar[regionId]' ");
    if (empty($goods['ico'])) {
        $ico = img("Ymu67366525YP");
    }else{
        $ico = root.$goods['ico'];
    }
    $totalPrice = $buycar['buyNumber'] *  $buycar['buyPrice'];

    $groupBuy = para("groupBuy"); //团购（满几件打折）
    $discountMoney = para("discountMoney"); //折扣价（满多少元打折）
    if ($buycar['buyNumber'] >= $groupBuy || $totalPrice >= $discountMoney) { //购买数量大于等于团购数量打折或者商品价格大于等于折扣价
        $totalPrice = round($totalPrice * 0.9,2); //9折
    }
    //判断商品总价，是否包邮
    if ($totalPrice >= para("freeShip")) {
        $freight = 0;
    }else{
        $freight = para("freight");
    }
    $total = round($totalPrice + $freight,2);
}
//查询收货地址
$addressSql = inquiry("address", "khid = '$kehu[khid]' ");
if (empty($addressSql)) {
    $isAddress = 'have';
}
echo head("m");
?>
<!-- 头部 -->
<div class="header header-fixed">
    <div class="nesting"> <a href="<?php echo $root."m/mUser/mUsBuyCar.php";?>" class="header-btn header-return"><span class="return-ico">&#xe600;</span></a>
        <div class="align-content">
            <p class="align-text">确认订单</p>
        </div>
        <form name="payForm" method="post" action="<?php echo root."pay/wxpay/wxpay.php";?>">
            <input name="orderType" type="hidden" value="购物车">
            <input name="orderId" type="hidden" value="<?php echo $buycar['id'];?>">
            <input type="hidden" name="money" value="<?php echo $total;?>">
            <input id="clientTel" type="hidden" value="<?php echo $kehu['tel'];?>" />
            <input id="isAddress" type="hidden" value="<?php echo $isAddress;?>" />
            <a href="<?php echo root;?>m/mUser/mUser.php" class="header-btn">
                <span class="musercenter user-ico">&#xe60f;</span>
                <input type="submit" class="bind-phone_btn2" id="bind-phone_btn" value="立即支付">
            </a>
        </form>
    </div>
</div>
<!--//-->
<style>
    .order-address label:first-of-type em{float: right;}
    .order-address{margin-right: 20px;}
    .order-address-btn{font-size: 20px !important;}
    .fee p{display: flex;}
    .fee span {flex: 1;}
</style>
<div class="container  mui-ptop45">
    <dl class="add-address-list">
        <dd>
            <span class="order-state4 order-address-btn">&#xe60b;</span>
            <p class="order-address">
                <label><span>收货人：<?php echo kong($buycar['addressName']);?></span><em><?php echo kong($buycar['addressTel']);?></em></label>
                <br /><label>收货地址：<?php echo kong(Region($buycar['regionId']).' '.$buycar['addressMx']);?></label>
            </p>
            <span class="more">&#xe683;</span>
        </dd>
    </dl>
    <div class="order-goods classly">
        <div class="order-goods-mx">
            <a href="{$root}m/mGoodsMx.php?gid={$buycar['goodsId']}">
                <img src="<?php echo $ico; ?>">
                <p><?php echo $buycar['goodsName']; ?>
                    <br><span>规格：<?php echo $buycar['goodsSkuName']; ?></span></p>
                <label><span>￥ <?php echo $buycar['buyPrice']; ?></span>
                    <p>x <?php echo $buycar['buyNumber']; ?></p>
                </label>
            </a>
        </div>
        <div class="order-goods-price fee">
            <p><span>运费</span>
                <label>￥<?php echo $freight; ?></label>
            </p>
            <p><span>商品价格</span>
                <label>￥<?php echo $buycar['buyPrice'] * $buycar['buyNumber']; ?></label>
            </p>
            <p><span>实付款（含运费）</span>
                <label class="total-price">￥<?php echo $total; ?></label>
            </p>
        </div>
    </div>
</div>
<!--弹出层-->
<div class="cover">
    <div class="cover-con">
        <h2>设置收货人信息<i id="close">X</i></h2>
        <ul class="wrap">
            <form name="usAddress">
                <li><span>收货人：</span><p><input type="text" name="adName" value="<?php echo kong($buycar['addressName']); ?>" placeholder="请输入收货人姓名"></p></li>
                <li><span>联系电话：</span><p><input type="tel" name="adTel" value="<?php echo kong($buycar['addressTel']); ?>" placeholder="请输入手机号码"></p> </li>
                <li><span>选择地区</span>
                    <select name="province">
                        <?php echo RepeatOption("region","province","--省份--",$Region['province']);?></select>
                    <select name="city">
                        <?php echo RepeatOption("region where province = '$Region[province]' ","city","--城市--",$Region['city']);?></select>
                    <select name="area">
                        <?php echo IdOption("region where province = '$Region[province]' and city = '$Region[city]'","id","area","--区县--",$buycar['regionId']);?>
                    </select>
                </li>
                <li><span>详细地址</span>
                    <textarea name="adMx" rows="5" cols="40" placeholder="详细到街道门牌信息"><?php echo $buycar['addressMx']; ?></textarea>
                </li>
                <li class="payNow">
                    <input type="hidden" name="order" value="<?php echo $buycar['id'];?>">
                    <a class="confrim" onclick="Sub('usAddress',root+'library/mData.php?type=upAddress')">确认信息</a>
                </li>
            </form>
        </ul>
    </div>
</div>
<script>
    $(document).ready(function(){
        //如果没有手机号码,收货人信息不能支付
        var payBtn = document.getElementById('bind-phone_btn');
        var isAddress = document.getElementById('isAddress').value;
        var clientTel = document.getElementById('clientTel').value;
        payBtn.onclick = function() {
            if (clientTel == '') {
                alert('请在个人中心的个人资料添加手机号码，然后才能支付');
                return false;
            }
            else if (isAddress == 'have') {
                alert('请添加收货人信息');
                return false;
            }
        }
        //根据省份获取下属城市下拉菜单
        document.usAddress.province.onchange = function(){
            document.usAddress.area.innerHTML = "<option value=''>--区县--</option>";
            $.post("<?php echo root."library/OpenData.php";?>",{ProvincePostCity:this.value},function(data){
                document.usAddress.city.innerHTML = data.city;
            },"json");
        };
        //根据省份和城市获取下属区域下拉菜单
        document.usAddress.city.onchange = function(){
            $.post("<?php echo root."library/OpenData.php";?>",{ProvincePostArea:document.usAddress.province.value,CityPostArea:this.value},function(data){
                document.usAddress.area.innerHTML = data.area;
            },"json");
        }
    });
    $(".more").click(function(){
        $(".cover").show();
    });
    $("#close").on("click",function(){
        $(".cover").hide();
    });
</script>
<?php echo mWarn();?>
</body>
</html>