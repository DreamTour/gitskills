<?php
include "../library/mFunction.php";
$result = mysql_query("SELECT DISTINCT classify FROM content WHERE type = '信息展示' AND xian='显示' ORDER BY list");
while ($article = mysql_fetch_array($result)) {
    $content .= queryClassify($article['classify'],6); //循环分类文章
}
/*
 * 查询分类文章函数
 * $classify 二级分类名称
 * $nums 显示条数
 */
function queryClassify($classify,$nums){
    global $root;
    if (empty($classify)) {
        return false;
    }
    $result = mysql_query("SELECT * FROM content WHERE classify = '{$classify}' AND xian='显示' ORDER BY list LIMIT {$nums}");
    $num = mysql_num_rows($result);
    if ($num > 0) {
        $tourism = "";
        $liStr = "";
        while ($array = mysql_fetch_array($result)) {
            if (empty($array['ico'])) {
                $ico = img('vLl67366152My'); //默认图片
            }else{
                $ico = root.$array['ico'];
            }
            $liStr .= "<li>
				           <a href='{$root}m/mTourMx.php?id={$array['id']}'>
				                <div>
				                    <img src='{$ico}' />
				                    <p>{$array['title']}</p>
				                </div>
				            </a>
				        </li>";
        }
        if ($classify == "千年古韵") {
            $classifyStr = "千年古韵";
        }else{
            $classifyStr = $classify;
        }
        $tourism = "
		<div class='tourism-cd'>
		    <div class='tourism-title'>
		        <a href='{$root}m/mTour.php?classify={$classify}'>
		            <div class='mui-dis-flex'>
		                <label><em>{$classifyStr}</em><i class='class-more'>&#xe61d;</i>
		                    <br/><span>了解更多{$classify}</span></label>
		            </div>
		        </a>
		    </div>
		    <ul class='mui-dis-flex'>
		        {$liStr}
		    </ul>
		</div>";
    }else{
        $tourism = "
		<div class='tourism-cd'>
		    <p class='nodata'>暂无此类文章</p>
		</div>
		";
    }
    return $tourism;

}
echo head("m");
?>
<!--头部-->
<div class="header header-fixed">
    <div class="nesting"> <a href="<?php echo root;?>m/mindex.php" class="header-btn header-return"><span class="return-ico">&#xe600;</span></a>
        <div class="align-content">
            <p class="align-text">信息展示</p>
        </div>
        <a href="#" class="header-btn"></a>
    </div>
</div>
<!--//-->
<div class="container mui-ptop45 mui-mbottom60">
    <div class="tourism">
        <!--//循环豆腐块-->
        <?php echo $content; ?>
        <!--//-->
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