<?php
include "library/PcFunction.php";
//循环业界动态列表
$sql = "SELECT * FROM content WHERE type = '业界动态' ";
paging($sql," order by UpdateTime desc ",10);
$dynamic = "";
if ($num == 0) {
    $dynamic = "一条业界动态都没有";
} else {
    while ($array = mysql_fetch_assoc($query)) {
        $dynamic .= "
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
<!-- 大图 -->
<div class="dynamic-banner banner"></div>
<!-- 动态主体 -->
<!--<div class="dynamic-main clearfix">
    <ul>
       <?php /*echo $dynamic;*/?>
    </ul>
    <div class='caseItems-btn'>
        <?php /*echo fenye($ThisUrl, 7);*/?>
    </div>
</div>-->
<!--<li>
    <a class='clearfix' href=\"{$root}dynamicDetails.php?id={$array['id']}\">
        <div class=\"pic fl\"><img src='{$array['ico']}' width=\"200\" height=\"100\" alt=\"\" /></div>
        <div class=\"text fr\">
        <strong>{$array['title']}</strong>
        <span>{$array['UpdateTime']}</span>
        <p>{$array['summary']}</p>
        </div>
    </a>
</li>-->
<!--位置-->
<div class="location container">
    <a href="<?php echo $root;?>index.php">首页</a><span>&gt;</span>
    <a href="javascript:;">业界动态</a>
</div>
<!--新闻中心-->
<div class="case-box container">
    <div class="case-title"><h1>业界动态</h1><p>Industry News</p></div>
    <ul class="newsList">
        <?php echo $dynamic;?>
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