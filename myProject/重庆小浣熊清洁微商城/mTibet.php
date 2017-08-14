<?php
include "../library/mFunction.php";
$classify = $get['classify'];
if (!empty($classify)) {
    $ThisUrl = "{$root}m/mTour.php?classify={$classify}";
    $sql = "SELECT * FROM content WHERE type = '重庆天地' AND classify = '$classify' AND xian='显示'";
}else{
    $ThisUrl = "{$root}m/mTour.php";
    $sql="SELECT * FROM content WHERE type = '重庆天地' AND xian='显示'";
}
paging($sql," order by list desc",15);
if($num > 0){
    while($array = mysql_fetch_array($query)){
        $liStr = "";
        if (empty($array['ico'])) {
            $ico = img('vLl67366152My'); //默认图片
        }else{
            $ico = root.$array['ico'];
        }
        $tibet .= "
				<div class='tibet-list'>
				    <dl>
				        <dd>
				            <a href='{$root}m/mTibetMX.php?tid={$array['id']}'>
				                <div>
				                    <h2>{$array['title']}</h2>
				                    <p> {$array['summary']}</p>
				                </div>
				                <img src='{$ico}' width='80' height='80'>
				            </a>
				        </dd>
				    </dl>
				</div>";
    }
}else{
    $tibet = "
		<div class='tourism-list'>
		    <p class='nodata'>暂无此类文章</p>
		</div>
		";
}
//查询分类
$result = mysql_query("SELECT DISTINCT classify FROM content WHERE type = '援藏天地' AND xian='显示' ORDER BY list");
$aStr = "";
while ($mTibet = mysql_fetch_array($result)) {
    $aStr .= "<a href='{$root}m/mTibet.php?classify={$mTibet['classify']}'>{$mTibet['classify']}</a>"; //循环分类
}
echo head("m");
?>
<!--头部-->
<div class="header header-fixed">
    <div class="nesting"> <a href="<?php echo root;?>	m/mindex.php" class="header-btn header-return"><span class="return-ico">&#xe600;</span></a>
        <div class="align-content">
            <p class="align-text">重庆天地</p>
        </div>
        <a href="#" class="header-btn header-login"></a>
    </div>
</div>
<!--//-->
<div class="container  mui-mbottom60">
    <div class="activity-con mui-ptop45">
        <!--轮播-->
        <div id="slideBox" class="slideBox">
            <div class="swiper-wrapper">
                <div class='swiper-slide'>
                    <a href=''><img src='<?php echo img('WrX67366054bs');?>'></a>
                </div>
                <div class='swiper-slide'>
                    <a href=''><img src='<?php echo img('vLl67366152My');?>'></a>
                </div>
                <div class='swiper-slide'>
                    <a href=''><img src='<?php echo img('pdV67366189DS');?>'></a>
                </div>
                <div class='swiper-slide'>
                    <a href=''><img src='<?php echo img('xwD67366219PR');?>'></a>
                </div>
            </div>
            <div class="swiper-pagination"> </div>
        </div>
        <!--//-->
        <div class="newtop-title">
            <section class="list-category-1">
                <div class="backend"></div>
                <div class="content">
                    <!-- 分类 -->
                    <?php echo $aStr; ?>
                </div>
            </section>
        </div>
    </div>
    <?php echo $tibet; ?>
    <!--产品列表-->
    <!-- 分页 -->
    <div class="panel_pager ">
        <?php echo fenye($ThisUrl); ?>
    </div>
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