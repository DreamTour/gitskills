<?php
include "library/PcFunction.php";
//循环产品评测列表
$sql = "SELECT * FROM content WHERE type = '产品评测' ";
paging($sql," order by UpdateTime desc ",10);
$productAssess = "";
if ($num == 0) {
    $productAssess = "一条产品评测都没有";
} else {
    while ($array = mysql_fetch_assoc($query)) {
        $productAssess .= "
        <li class='newsItems'>
            <a class=\"clearfix\" href='{$root}dynamicDetails.php?id={$array['id']}'>
            <div class='newsPhoto'><img src='{$array['ico']}'></div>
            <div class='newsText'>
                <h2>{$array['title']}</h2>
                <p>{$array['summary']}</p>
                <span>{$array['UpdateTime']}</span>
            </div>
            </a>
        </li>
        ";
    }
}
echo head("pc").headerPC().navOne();
;?>
<!--广告图-->
<div class="productAssess-banner banner"></div>
<!--位置-->
<div class="location container">
    <a href="<?php echo $root;?>">首页</a><span>&gt;</span>
    <a href="javascript:;">产品评测</a>
</div>
<!--新闻中心-->
<div class="case-box container">
    <div class="case-title"><h1>产品评测</h1><p>product assess</p></div>
    <ul class="newsList">
        <?php echo $productAssess;?>
    </ul>

    <div class='caseItems-btn'>
        <?php echo fenye($ThisUrl, 7);?>
    </div>
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