<?php
include "../library/mFunction.php";
if (empty($get['classify'])) {
    header("Location:{$root}m/mTourRecommend.php");
    exit();
}else{
    $classify = $get['classify'];
    $ThisUrl = "{$root}m/mTour.php?classify={$classify}";
    $sql="SELECT * FROM content WHERE classify = '{$classify}' AND xian='显示'";
    paging($sql," order by list desc",15);
    if($num > 0){
        while($array = mysql_fetch_array($query)){
            $liStr = "";
            if (empty($array['ico'])) {
                $ico = img('vLl67366152My'); //默认图片
            }else{
                $ico = root.$array['ico'];
            }
            $liStr = "<li>
						<a href='{$root}m/mTourMx.php?id={$array['id']}'>
						<img src='{$ico}'/>
						  <div>
						    <p>{$array['title']}</p>
						    <p>{$array['time']}</p>
						  </div>
						  <span class='more'>&#xe683;</span> </a>
					  </li>";
        }
    }else{
        echo "<li class='nodata'>暂无此分类文章</li>";
    }
}
echo head("m");
?>
<!-- 头部 -->
<div class="header header-fixed">
    <div class="nesting"> <a href="<?php echo root;?>m/mTourRecommend.php" class="header-btn header-return"><span class="return-ico">&#xe600;</span></a>
        <div class="align-content">
            <p class="align-text"><?php echo $classify;?></p>
        </div>
        <a href="#" class="header-btn"></a>
    </div>
</div>
<!--//-->
<div class="container mui-ptop45 mui-mbottom60">
    <div class="tourism-lists">
        <h2><?php echo $classify;?></h2>
        <ul>
            <?php echo $liStr; ?>
        </ul>
    </div>
    <!-- 分页 -->
    <div class="panel_pager ">
        <?php echo fenye($ThisUrl); ?>
    </div>
</div>
<!-- 底部 -->
<?php echo  Footer(); ?>
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