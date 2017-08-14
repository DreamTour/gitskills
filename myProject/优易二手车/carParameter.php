<?php
include "../library/mFunction.php";
$carParameterSql = mysql_query("select * from carParameter where BrandId = '$_GET[Brand_id]'");
$carParameterNum = mysql_num_rows($carParameterSql);
$carParameter = "";
if ($carParameterNum == 0) {
    $carParameter = "一张图片都没有";
}
else{
    while ($array = mysql_fetch_assoc($carParameterSql)) {
        $carParameter .= "<img src='{$root}{$array['src']}' />";
    }
}
echo head("m");
?>
    <style type="text/css">
        .canshu{width: 95%; margin: 2.5%; background: #fff; line-height: 2; padding: 2.5% 2.5% 10%; font-size: 1.9em; }
        .canshu img{max-width:100%;text-align:center;}
        .goback{display: block; width: 5em;text-align:center;background: #f37200; line-height: 2em; font-size: 1em; color: #fff; border-radius: 0.3em;margin-bottom:2.5%;}
    </style>
<div class="wrap">
    <!-- 返回按钮 -->
    <div class="canshu">
        <a class="goback" href="javascript:history.back(-1)"><返回</a>
        <?php echo $carParameter;?>
    </div>
</div>
</body>
</html>