<?php
include "../../library/mFunction.php";
$ThisUrl = "{$root}m/mCommonweal.php";
$sql = "SELECT * FROM goods WHERE publicGood='是' AND xian='显示'  ";
paging($sql,"order by list desc",15);
$liStr = "";
if($num > 0){
    while($goods = mysql_fetch_array($query)){
        if (empty($goods['ico'])) {
            $ico = img('vLl67366152My'); //默认图片
        }else{
            $ico = root.$goods['ico'];
        }
        $liStr .= "
				<li>
					<a href='{$root}m/mUser/mUsReceiveMx.php?gid={$goods['id']}'>
					<img src='{$ico}'/>
					<p class='nameSpc'>{$goods['name']}</p>
					<p class='textSale'> <!--<em class='text-price'>￥{$goods['price']}</em>--> <em class='text-price'>免费领取</em> </p>
					</a>
				</li>";
    }
}else{
    $liStr = "<li class='nodata'>暂无此分类商品</li>";
}
echo head("m");
?>
<!--头部-->
<div class="header header-fixed">
    <div class="nesting"> <a href="<?php echo $root;?>m/mUser/mUser.php" class="header-btn header-return"><span class="return-ico">&#xe600;</span></a>
        <div class="align-content">
            <p class="align-text">免费商品</p>
        </div>
        <a href="#" class="header-btn header-login"></a>
    </div>
</div>
<!--//-->
<div class="container">
    <div class="activity-con mui-ptop45">
        <h2>免费商品说明</h2>
        <p><?php echo website('lhl71540295cj');?></p>
        <div class="receive-number">我的领取次数: <span><?php echo $kehu['receiveNumber'];?></span> 次</div>
    </div>
    <!--产品列表-->
    <div class="product">
        <h2>免费商品</h2>
        <ul class="product-lists mui-dis-flex">
            <?php echo $liStr; ?>
        </ul>
    </div>
</div>
<!--底部-->
<?php echo  Footer(); ?>
<!--//-->
<script>
    $(function(){
        /***********************导航栏变色****************************/
        changeNav();
    });
</script>
</body>
</html>