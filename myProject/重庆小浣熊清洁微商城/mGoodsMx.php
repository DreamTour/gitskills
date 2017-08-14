<?php
include "../library/mFunction.php";
$id = $get['gid'];
$goods = query("goods","id = '$id'");
if (empty($goods['id'])) {
    header("Location:{$root}m/mindex.php");
    $_SESSION['warn'] = "商品参数错误";
}else{
    //商品橱窗图片
    $result = mysql_query("SELECT * FROM goodsWin WHERE goodsId='{$goods['id']}' limit 5");
    $nums = mysql_num_rows($result);
    if ($nums > 0) {
        while ($array = mysql_fetch_array($result)) {
            $goodsWin .= "<div class='swiper-slide'>
							<img src='{$root}{$array['src']}'>
						 </div>" ;
        }
    }else{
        $goodsWin = "<div class='swiper-slide'>
						<img src='".img('WrX67366054bs')."'>
					 </div>" ;
    }
    // 商品库存
    $result2 = mysql_query("SELECT * FROM goodsSku WHERE goodsId='{$goods['id']}' ");
    $knums = mysql_num_rows($result2);
    $x = 0;
    if ($knums > 0) {
        while ($kuArr = mysql_fetch_array($result2)) {
            $x = $x + 1;
            if ($x == 1) {
                $fristLi = "<li class='on-type' data-id='{$kuArr['id']}'>{$kuArr['name']}</li>";
            }else{
                $liStr .= "<li data-id='{$kuArr['id']}'>{$kuArr['name']}</li>";
            }
        }
        $goodsKu = $fristLi.$liStr;
    }else{
        $goodsKu = "<li>暂无商品规格</li>" ;
    }


}
echo head("m");
?>
<!--头部-->
<div class="header header-fixed">
    <div class="nesting"> <a href="<?php echo root?>m/mGoods.php" class="header-btn header-return"><span class="return-ico">&#xe600;</span>
        </a>
    </div>
</div>
<!--//-->
<div class="container">
    <div class="content">
        <!--轮播-->
        <div id="slideBox" class="slideBox">
            <div class="swiper-wrapper">
                <?php echo $goodsWin; ?>
            </div>
            <div class="swiper-pagination"> </div>
        </div>
        <!--//-->
    </div>
    <!--产品详情-->
    <div class="goodsMx mui-mbottom60">
        <p class="goodMx-title"><?php echo $goods['name']; ?></p>
        <dl class="goodMx-price">
            <dd><span>单价:</span><label>￥<em id="price"></em>/件</label>
                <small> 市场价：<em id="priceMarket">￥/件</em></small></dd>
            <dd><span>销量 :</span><label><em id="salesVolume"></em></label></dd>
            <dt><span>类型 :</span>
            <ul class="goods-type">
                <?php echo $goodsKu; ?>
            </ul>
            </dt>
            <dd><span>数量 :</span>
                <p class="mui-dis-flex">
                    <button type="button" class="minus amount-btn amount-push">-</button>
                    <input type="text" class="am-num-text amount-value" value="1" />
                    <button type="button" class="plus amount-btn amount-reduce">+</button>
                </p>
                <i class="inventory">库存： <em id="number"></em> </i>
            </dd>
        </dl>
        <form name="usBuy" method="post">
            <input type="hidden" name="gid" id="gid" value="<?php echo $goods['id'];?>">
            <input type="hidden" name="kid" id="kid">
            <input type="hidden" name="buynum" id="buynum" value="1">
        </form>
        <p class="buy-btn">
            <a href="javascript:void(0)" onclick="Sub('usBuy',root+'library/mData.php?type=usBuy')">加入购物车</a>
            <a href="javascript:void(0)" onclick="Sub('usBuy',root+'library/mData.php?type=usBuy&t=mUsPay')">立即购买</a></p>
        <div class="goods-con">
            <h2>产品详情</h2>
            <p><?php echo ArticleMx($goods['id']) ?></p>
        </div>
    </div>
    <!--//-->
</div>
<!--底部-->
<?php echo mWarn().Footer(); ?>
<!--//-->
<script>
    $(document).ready(function() {
        kid = $(".on-type").attr("data-id");
        $("#kid").attr('value', kid);
        queryKu(kid);
    });
    $(function(){
        /***********************导航栏变色****************************/
        changeNav();
        /**************************首页轮播******************************/
        window.addEventListener("load", function(e) {
            // 首页轮播图
            var swiperObj = new Swiper('#slideBox', {
                autoplay: 2500,
                autoplayDisableOnInteraction: false,
                loop: true,
                pagination: '.swiper-pagination',
            });
            //
        }, false);
        // 选择商品类型
        $(".goods-type li").click(function(){
            $(this).addClass("on-type").siblings().removeClass("on-type");
            kid = $(this).attr("data-id");
            queryKu(kid);
        });
        // 数量减
        $(".minus").click(function() {
            var t = $(this).parent().find('.am-num-text');
            t.val(parseInt(t.val()) - 1);
            if(t.val() <= 1) {
                t.val(1);
            }
            $("#buynum").attr("value",t.val());
        });
        // 数量加
        $(".plus").click(function() {
            var t = $(this).parent().find('.am-num-text');
            var nums = parseInt($("#number").html()); //数量
            t.val(parseInt(t.val()) + 1);
            if(t.val() <= 1 || t.val() > nums) {
                t.val(1);
            }
            $("#buynum").attr("value",t.val());
        });

    });
    // 查询规格
    function queryKu(kid){
        $("#kid").attr('value', kid);
        $.post(root+'library/mData.php?type=queryKu', {kid: kid}, function(data) {
            $("#price").html(data.price); //单价
            $("#priceMarket").html(data.priceMarket); //市场价格
            $("#number").html(data.number); //库存
            $("#salesVolume").html(data.salesVolume);//销量
        },'json');
    }
</script>
</body>
</html>