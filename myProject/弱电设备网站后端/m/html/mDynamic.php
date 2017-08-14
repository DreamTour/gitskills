<?php
include "../library/mFunction.php";
//循环业界动态列表
$dynamicSql = mysql_query("SELECT * FROM content WHERE type = '业界动态' ");
$dynamic = "";
if (mysql_num_rows($dynamicSql) == 0) {
    $dynamic = "一条业界动态都没有";
} else {
    while ($array = mysql_fetch_assoc($dynamicSql)) {
        $dynamic .= "
        <li>
            <a href=\"{$root}m/mDynamicDetails.php?id={$array['id']}\">
                <div class=\"picture\">
                    <img src=\"{$root}{$array['ico']}\" />
                </div>
                <div class=\"message clearfix\">
                    <h3>{$array['title']}</h3>
                    <span class=\"fr\">{$array['UpdateTime']}</span>
                </div>
            </a>
        </li>
        ";
    }
}
echo head("m").mHeader();
;?>
<!-- 业界动态列表 -->
<h2 class="clearfix public-title">
    <div class="fl">业界动态</div>
    <a href="news-information.html" class="fr">></a>
</h2>
<div class="mDynamic">
    <ul>
        <?php echo $dynamic;?>
    </ul>
</div>
<!-- 页脚 -->
<?php echo mFooter().mNav().warn();?>
</body>
</html>