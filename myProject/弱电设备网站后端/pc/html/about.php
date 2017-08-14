<?php
include "library/PcFunction.php";
$article = query("content", "id = 'xKr65750880Zs' ");
echo head("pc").headerPC().navOne();
;?>
<!-- 大图 -->
<div class="about-banner banner"></div>
<!--位置-->
<div class="location container">
    <a href="<?php echo $root;?>index.php">首页</a><span>&gt;</span>
    <a href="javascript:;">关于我们</a>
</div>
<div class="case-box container">
    <div class="case-title"><h1>关于我们</h1><p>news center</p></div>
    <ul class="newsList">
    </ul>
</div>
<!-- 信息 -->
<div class="about-main">
    <!--<h3><?php /*echo $article['title'];*/?></h3>-->
    <?php echo ArticleMx("hBO65751498kf");?>
</div>
<!-- 页脚 -->
<?php echo footerPC().warn();?>
</body>
<script>
    //导航移动
    $(".nav").movebg({
        width:134,  /*滑块的大小*/
        extra:0,    /*额外反弹的距离*/
        speed:400,  /*滑块移动的速度*/
        rebound_speed:400   /*滑块反弹的速度*/
    });
</script>
</html>