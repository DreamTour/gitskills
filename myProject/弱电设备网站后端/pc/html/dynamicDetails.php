<?php
include "library/PcFunction.php";
//获取id显示不同的文章
$dynamic = query("content", "id = '$_GET[id]' ");
echo head("pc").headerPC().navOne();
;?>
<!--轮播图-->
<div id="slider">
    <div id="slider-list">
        <div class='slider-items'><img src='<?php echo img("cVB63009335DO");?>'></div>
        <div class='slider-items'><img src='<?php echo img("gnh63009406BO");?>'></div>
        <div class='slider-items'><img src='<?php echo img("tYx63009445rp");?>'></div>
    </div>
    <ul id="sort-items"></ul>
    <div id="slider-prev" class="slider-btn"></div>
    <div id="slider-next" class="slider-btn"></div>
</div>
<!-- 信息 -->
<div class="dynamic_details-box">
    <h3><?php echo $dynamic['title'];?></h3>
    <p>
        <?php echo ArticleMx($dynamic['id']);?>
    </p>
</div>
<!-- 页脚 -->
<?php echo footerPC().warn();?>
</body>
<script>

    window.onload= function() {
        //轮播图切换
        sliderWrap({
            slideCell:"slider",
            mainCell:"slider-list",
            titCell:"sort-items",
            prev:"slider-prev",
            next:"slider-next"
        });

    }
</script>
</html>