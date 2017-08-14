<?php
include "../library/mFunction.php";
//循环产品评测列表
$productAssessSql = mysql_query("SELECT * FROM content WHERE type = '产品评测' ");
paging($sql," order by UpdateTime desc ",10);
$productAssess = "";
if (mysql_num_rows($productAssessSql) == 0) {
    $productAssess = "一条产品评测都没有";
} else {
    while ($array = mysql_fetch_assoc($productAssessSql)) {
        $productAssess .= "
        <li>
            <a href=\"{$root}m/mDynamicDetails.php?id={$array['id']}\">
                <div class=\"message clearfix\">
                    <h3>{$array['title']}</h3>
                    <span>{$array['UpdateTime']}</span>
                </div>
                <div class=\"picture\">
                    <img src=\"{$root}{$array['ico']}\" />
                </div>
            </a>
        </li>
        ";
    }
}
echo head("m").mHeader();
;?>
<h2 class="clearfix public-title">
    <div class="fl">产品评测</div>
    <a href="news-information.html" class="fr">></a>
</h2>
<div class="mDynamic">
    <ul>
        <?php echo $productAssess;?>
    </ul>
</div>
<?php echo mFooter().mNav().warn();?>
</body>
</html>