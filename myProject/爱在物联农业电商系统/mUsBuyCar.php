<?php
include "../../library/mFunction.php";
$kehu = query("kehu","khid = '$kehu[khid]'");
$address = query("address","id = '$kehu[addressId]' and khid = '$kehu[khid]'"); //查询默认收货地址
$ThisUrl = "{$root}m/mUser/mUsBuyCar.php";
$sql="SELECT * FROM buycar WHERE khid ='$kehu[khid]' AND WorkFlow='未选定' ";
paging($sql," order by time desc",10);
if($num > 0){
    while($buycar = mysql_fetch_array($query)){
        $goodArr = query("goods","id = '$buycar[goodsId]'"); //查询商品信息
        if (empty($goodArr['ico'])) {
            $goodArr['ico'] = img('Ymu67366525YP');
        }else{
            $goodArr['ico'] = $root.$goodArr['ico'];
        }
        $content .= "<li class='one-goods'>
                  <div class='goods-msg'>
                      <label class='option-btn'>
                           <span>
                                  <input name='orderid[]' type='checkbox' class='goods-check GoodsCheck' value='{$buycar['id']}'>
                          </span>
                      </label>
                      <img src='{$goodArr['ico']}' />
                      <div class='goods-num'>
                          <h2><a href='{$root}m/mGoodsMx.php?gid={$buycar['goodsId']}'>{$buycar['goodsName']}</a></h2>
                          <p class='price'>￥<span class='shop-total-amount GoodsPrice'>{$buycar['buyPrice']}</span></p>
                          <p class='mui-dis-flex'>
                              <button type='button' class='minus amount-btn amount-push'>-</button>
                              <input type='text' class='am-num-text amount-value' value='{$buycar['buyNumber']}' />
                              <button type='button' class='plus amount-btn amount-reduce'>+</button>
                          </p>
                      </div>
                  </div>
                  <div class='options'><a class='delete' onclick=\"delOrder('{$buycar['id']}')\">&#xe605;</a></div>
              </li>";
    }
}else{
    $content = "<div class='order-lists'><h2>一条记录也没有</h2></div>";
}
//查询收货地址
$addressSql = query("address", "khid = '$kehu[khid]' ");
if (empty($addressSql)) {
    $isAddress = 'have';
}
echo head("m");
?>
<!-- 头部 -->
<div class="header header-fixed">
    <div class="nesting"> <a href="<?php echo root;?>m/mUser/mUser.php" class="header-btn header-return"><span class="return-ico">&#xe600;</span></a>
        <div class="align-content">
            <p class="align-text">购物车</p>
        </div>
        <a href="<?php echo root;?>m/mUser/mUser.php" class="header-btn "><span class="musercenter user-ico">&#xe60f;</span></a>
    </div>
</div>
<!--//-->
<!-- 一个店铺 -->
<div class="container mui-ptop45 mb180">
    <div class="buycart">
        <ul>
            <?php echo $content; ?>
        </ul>
        <!-- 店铺合计 -->
        <div class="buycart-ctrl  mui-wrap-style1 mui-sheet mui-fixed">
            <div class="shop-total">
                <label class="option-btn">
            <span>
                      <input type="checkbox" class="goods-check ShopCheck">
            </span>
                </label>
                <p>合计：￥<span data-money class="shop-total-amount ShopTotal">0</span><small id="money-mx"></small></p>
            </div>
            <div class="mui-btn-wrap mui-mtop10">
                <a href="<?php echo root;?>m/mGoods.php">继续购物</a>
                <a href="javascript:;" class="settlement">去结算</a>
            </div>
        </div>
    </div>
</div>
<!--弹出层-->
<div class="cover">
    <div class="cover-con">
        <h2>确认支付<i id="close">X</i></h2>
        <ul class="wrap">
            <li><span>收货人：</span><p><?php echo kong($address['AddressName']); ?></p></li>
            <li> <span>联系电话：</span><p><?php echo kong($address['AddressTel']); ?></p> </li>
            <li>
                <span class="addressTitle">详细地址：</span>
                <div class="addressInfo">
                    <p><?php echo kong(Region($address['RegionId']).$address['AddressMx']); ?></p>
                    <a href="<?php echo root.'m/mUser/mUsAddress.php'; ?>" class="keyRed">设置地址&gt;&gt;</a>
                </div>
            </li>
            <li class="payNow">
                <form name="payForm" method="post" action="<?php echo root."pay/wxpay/wxpay.php";?>">
                    <input name="orderType" type="hidden" value="购物车">
                    <input name="orderId" type="hidden">
                    <input type="hidden" name="money">
                    <input id="isAddress" type="hidden" value="<?php echo $isAddress;?>" />
                    <input type="submit" class="confrim" id="payBtn" value="立即支付">
                </form>
            </li>
        </ul>
    </div>
</div>
<?php echo mWarn();?>
<!--//-->
<script>
    window.onload = function() {
        //如果没有收货人信息不能支付
        var payBtn = document.getElementById('payBtn');
        var isAddress = document.getElementById('isAddress').value;
        payBtn.onclick = function() {
            if (isAddress == 'have') {
                mwarn('请添加收货人信息');
                return false;
            }
        }
    }
    // 数量减
    $(".minus").click(function() {
        var t = $(this).parent().find('.am-num-text');
        t.val(parseInt(t.val()) - 1);
        if(t.val() <= 1) {
            t.val(1);
        }
        TotalPrice();
    });
    // 数量加
    $(".plus").click(function() {
        var t = $(this).parent().find('.am-num-text');
        t.val(parseInt(t.val()) + 1);
        if(t.val() <= 1) {
            t.val(1);
        }
        TotalPrice();
    });
    // 点击商品按钮
    $(".GoodsCheck").click(function() {
        var goods = $(this).closest(".buycart").find(".GoodsCheck"); //获取本店铺的所有商品
        var goodsC = $(this).closest(".buycart").find(".GoodsCheck:checked"); //获取本店铺所有被选中的商品
        var Shops = $(this).closest(".buycart").find(".ShopCheck"); //获取本店铺的全选按钮
        if($(this).prop("checked")){
            $(this).parent().css("background","red");
        }else{
            $(this).parent().css("background","#fff");
        }
        if(goods.length == goodsC.length) { //如果选中的商品等于所有商品
            Shops.prop('checked', true); //店铺全选按钮被选中
            if($(".ShopCheck").length == $(".ShopCheck:checked").length) { //如果店铺被选中的数量等于所有店铺的数量
                $("#AllCheck").prop('checked', true); //全选按钮被选中
                $(".ShopCheck").parent().css("background","red");
                TotalPrice();
            } else {
                $("#AllCheck").prop('checked', false); //else全选按钮不被选中
                $(".ShopCheck").parent().css("background","#fff");
                TotalPrice();
            }
        } else { //如果选中的商品不等于所有商品
            Shops.prop('checked', false); //店铺全选按钮不被选中
            $("#AllCheck").prop('checked', false); //全选按钮也不被选中
            $(".ShopCheck").parent().css("background","#fff");
            // 计算
            TotalPrice();
            // 计算
        }
    });
    // 点击店铺按钮
    $(".ShopCheck").change(function() {
        if($(this).prop("checked") == true) { //如果店铺按钮被选中
            $(this).parents(".buycart").find(".goods-check").prop('checked', true); //店铺内的所有商品按钮也被选中
            if($(".ShopCheck").length == $(".ShopCheck:checked").length) { //如果店铺被选中的数量等于所有店铺的数量
                $("#AllCheck").prop('checked', true); //全选按钮被选中
                $(this).parent().css("background","red");
                $(".GoodsCheck").parent().css("background","red");
                TotalPrice();
            } else {
                $("#AllCheck").prop('checked', false); //else全选按钮不被选中
                $(".ShopCheck").parent().css("background","#fff");
                $(".GoodsCheck").parent().css("background","#fff");
                TotalPrice();
            }
        } else { //如果店铺按钮不被选中
            $(this).parents(".buycart").find(".goods-check").prop('checked', false); //店铺内的所有商品也不被全选
            $("#AllCheck").prop('checked', false); //全选按钮也不被选中
            $(".ShopCheck").parent().css("background","#fff");
            $(".GoodsCheck").parent().css("background","#fff");
            TotalPrice();
        }
    });
    // 点击全选按钮
    $("#AllCheck").click(function() {
        if($(this).prop("checked") == true) { //如果全选按钮被选中
            $(".goods-check").prop('checked', true); //所有按钮都被选中
            TotalPrice();
        } else {
            $(".goods-check").prop('checked', false); //else所有按钮不全选
            TotalPrice();
        }
        $(".ShopCheck").change(); //执行店铺全选的操作
    });

    function TotalPrice() {
        var allprice = 0; //总价
        $(".buycart").each(function() { //循环每个店铺
            var oprice = 0; //店铺总价
            $(this).find(".GoodsCheck").each(function() { //循环店铺里面的商品
                if($(this).is(":checked")) { //如果该商品被选中
                    var num = parseInt($(this).parents(".one-goods").find(".am-num-text").val()); //得到商品的数量
                    var price = parseFloat($(this).parents(".one-goods").find(".GoodsPrice").text()); //得到商品的单价
                    var total = price * num; //计算单个商品的总价
                    oprice += total; //计算该店铺的总价
                }
                var freeShip = <?php echo para("freeShip");?>;  // 满多少包邮
                var freight = <?php echo para("freight");?>; // 邮费
                totalPrice = oprice.toFixed(2); //商品总价
                if (totalPrice>= freeShip) {
                    freight = 0;
                }
                if (totalPrice > 0) {
                    total = parseFloat(totalPrice) + parseFloat(freight); //总价
                }else{
                    total = totalPrice;  //总价
                    $("#money-mx").html("元 （满"+ freeShip +"元包邮）");
                }
                $(this).closest(".buycart").find(".ShopTotal").text(total); //显示被选中商品的店铺总价
                $(".ShopTotal").attr('data-money', total);
            });
            var oneprice = parseFloat($(this).find(".ShopTotal").text()); //得到每个店铺的总价
            allprice += oneprice; //计算所有店铺的总价
        });
    }
    // 删除订单
    function delOrder(order){
        if ($.trim(order).length == 0 || order == '') {
            mwarn("请选择要删除的商品");
        }else{
            $.post(root+'library/mData.php?type=delOrder', {order: order}, function(data) {
                if(data.warn == "2"){
                    window.location.reload();
                }
            },'json');
        }
    }
    $(function(){
        $(".settlement").on("click",function(){
            var orderid = new Array();
            $('input[name="orderid[]"]:checked').each(function(){
                orderid.push($(this).val());
            });
            if (orderid.length==0) {
                mwarn("请选择要结算的商品");
            }else{
                orderid = orderid.join(','); //拼接数组
                money= $(".ShopTotal").data("money");
                $("input[name='orderId']").attr("value",orderid);
                $("input[name='money']").attr("value",money);
                $(".cover").show();
            }
        });
        $("#close").on("click",function(){
            $(".cover").hide();
        });
    });
</script>
</body>
</html>