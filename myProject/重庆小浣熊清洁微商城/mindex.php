<?php
include "../library/mFunction.php";

//检测用户是否带有经销商ID
checkDealer($get['did']);

//查询全部分类商品
$result = mysql_query("SELECT id,name FROM goodsTypeOne ORDER by list LIMIT 5");
while ($oneArray = mysql_fetch_array($result)) {
    $allShop .= shopList($oneArray['name'],6,$oneArray['id']);
}
/*
 * 商品展示函数
 * $type 类型
 * $num 数量
 */
function shopList($type,$num=5,$other=NULL){
    global $root;
    switch ($type) {
        case "今日热销":
            $sql = "SELECT * FROM goods WHERE sellingToday='是' AND xian='显示' ";
            break;
        case "抢购商品":
            $sql = "SELECT * FROM goods WHERE scareBuying='是' AND xian='显示' ";
            break;
        default:
            $sql = "SELECT * FROM goods WHERE goodsTypeOneId='{$other}' AND xian='显示'  ";
            break;
    }
    $result = mysql_query($sql."limit {$num}");
    $nums = mysql_num_rows($result);
    if ($nums > 0) {
        while ($goods = mysql_fetch_array($result)) {
            if (empty($goods['ico'])) {
                $ico = img("Ymu67366525YP");
            }else{
                $ico = $root.$goods['ico'];
            }
            $shopStr .= "<li>
					        <a href='{$root}m/mGoodsMx.php?gid={$goods['id']}'>
					        	<img src='{$ico}'/>
					        	<p class='nameSpc'>{$goods['name']}</p>
					        	<p class='textSale'> <em class='text-price'>￥{$goods['price']}</em> <em class='text-sale'>销量:{$goods['salesVolume']}</em> </p>
					        </a>
					    </li>";
        }
        $content = "
	    <div class='product mui-mbottom60'>
		    <h2>{$type}</h2>
		    <ul class='product-lists mui-dis-flex'>
		        {$shopStr}
		    </ul>
		</div>
	    ";
    }else{
        $content = "
		<div class='product mui-mbottom60'>
		    <h2>{$type}</h2>
		    <ul class='product-lists mui-dis-flex'>
		        暂无此类型商品
		    </ul>
		</div>";
    }
    return $content;

}
echo head("m");
?>
<!--头部-->
<div class="header header-fixed">
    <div class="nesting"> <a href="#" class="header-btn header-return"><span class="return-ico">&#xe600;</span></a>
        <div class="align-content">
            <p class="align-text"><?php echo website("lje67556712NV"); ?></p>
        </div>
        <a href="#" class="header-btn header-login"></a>
    </div>
</div>
<!--//-->
<div class="container">
    <div class="content mui-ptop45">
        <!--轮播-->
        <div id="slideBox" class="slideBox">
            <div class="swiper-wrapper">
                <div class='swiper-slide'>
                    <a href='<?php echo imgurl("WrX67366054bs"); ?>'><img src='<?php echo img('WrX67366054bs');?>'></a>
                </div>
                <div class='swiper-slide'>
                    <a href="<?php echo imgurl('vLl67366152My'); ?>"><img src='<?php echo img('vLl67366152My');?>'></a>
                </div>
                <div class='swiper-slide'>
                    <a href="<?php echo imgurl('pdV67366189DS'); ?>"><img src='<?php echo img('pdV67366189DS');?>'></a>
                </div>
                <div class='swiper-slide'>
                    <a href="<?php echo imgurl('xwD67366219PR'); ?>"><img src='<?php echo img('xwD67366219PR');?>'></a>
                </div>
            </div>
            <div class="swiper-pagination"> </div>
        </div>
        <!--//-->
    </div>
    <!--产品导航-->
    <div class="classly">
        <ul class="classly1 mui-dis-flex">
            <li><a href="<?php echo $root.'m/mClassify.php?oid=sHt67545963Ni'; ?>"><span class="specialty"><i>&#xe623;</i></span><p>家电清洗</p></a></li>
            <li><a href="<?php echo $root.'m/mClassify.php?oid=nwF67545991BD'; ?>"><span class="decorations"><i>&#xe620;</i></span><p>家电维修</p></a></li>
            <li><a href="<?php echo $root.'m/mClassify.php?oid=ISl67546001lk'?>"><span class="classly-more"><i>&#xe7f4;</i></span><p>上门保洁</p></a></li>
            <li><a href="<?php echo $root.'m/mClassify.php?oid=cWB67546011lC'?>"><span class="tutor"><i>&#xe634;</i></span><p>兼职家教</p></a></li>
        </ul>
        <ul class="classly2 mui-dis-flex">
            <!--<li><a href="<?php /*echo $root.'m/mBusiness.php'*/?>"><span class="join"><i>&#xe61b;</i></span><p>招商加盟</p></a></li>-->
            <li><a href="<?php echo $root.'m/mClassify.php?oid=SVj67546021fi'?>"><span class="join"><i>&#xe75d;</i></span><p>上门美容美甲</p></a></li>
            <li><a href="<?php echo $root.'m/mTourRecommend.php'?>"><span class="strategy"><i>&#xe64f;</i></span><p>绿色重庆</p></a></li>
            <li><a href="<?php echo $root.'m/mTibet.php';?>"><span class="culture"><i>&#xe601;</i></span><p>重庆天地</p></a></li>
            <li><a href="<?php echo $root.'m/mCommonweal.php';?>"><span class="activity"><i>&#xe602;</i></span><p>公益活动</p></a></li>
        </ul>
    </div>
    <!---->
    <!--今日热销商品-->
    <?php echo shopList("今日热销",6);?>
    <!-- 抢购商品 -->
    <?php echo shopList("抢购商品",6);?>
    <!-- 全部分类商品 -->
    <?php echo $allShop; ?>
</div>
<!--底部-->
<?php echo mWarn().Footer(); ?>
<!--//-->
<script>
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
    });
</script>
</body>
</html>