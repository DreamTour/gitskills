<?php
include "../library/mFunction.php";
//首页文章
$article = query("content", "id = 'xKr65750880Zs' ");
//循环弱电365售后设备
$deviceSql = mysql_query("SELECT * FROM device limit 8");
$device = "";
if (mysql_num_rows($deviceSql) > 0 ) {
    while ($array = mysql_fetch_assoc($deviceSql)) {
        if (empty($array['ico'])) {
            $ico = img('ZEg70828834DN');
        }
        else {
            $ico = $root.$array['ico'];
        }
        $device .= "
            <li>
                <a href='{$root}m/mUser/mUsDeviceDetails.php?id={$array['id']}'>
                    <img src='{$ico}'>
                    <h5>{$array['name']}</h5>
                </a>
            </li>
        ";
    }
}
else {
    $device = '一台售后设备都没有';
}
//循环业界动态列表
$dynamicSql = mysql_query("SELECT * FROM content WHERE type = '业界动态' ORDER BY UpdateTime DESC LIMIT 2");
$dynamic = "";
if (mysql_num_rows($dynamicSql) == 0) {
    $dynamic = "一条业界动态都没有";
} else {
    while ($array = mysql_fetch_assoc($dynamicSql)) {
        $dynamic .= "
            <li>
                <a class=\"clearfix\" href='{$root}/m/mDynamicDetails.php?id={$array['id']}'>
                    <img src=\"{$root}{$array['ico']}\" alt=\"图片\" width='400' height='200' />
                    <h4>{$array['title']}</h4>
                    <p>{$array['summary']}</p>
                </a>
            </li>
        ";
    }
}
//循环产品评测列表
$productAssessSql = mysql_query("SELECT * FROM content WHERE type = '产品评测' ORDER BY UpdateTime DESC LIMIT 2 ");
$productAssess = "";
if (mysql_num_rows($productAssessSql) == 0) {
    $productAssess = "一条产品评测都没有";
} else {
    while ($array = mysql_fetch_assoc($productAssessSql)) {
        $productAssess .= "
        <li>
            <a class=\"clearfix\" href='{$root}/m/mDynamicDetails.php?id={$array['id']}'>
                <img src=\"{$root}{$array['ico']}\" alt=\"图片\" width='400' height='200' />
                <h4>{$array['title']}</h4>
                <p>{$array['summary']}</p>
            </a>
        </li>
        ";
    }
}
echo head("m").mHeader();
;?>
<!-- 轮播图 -->
<div id="index_banner" class="index_banner">
    <ul class="banner_img">
        <li><img src="<?php echo img("dBQ66865802zq") ;?>" alt="图片" /></li>
        <li><img src="<?php echo img("JNq66865846eC") ;?>" alt="图片" /></li>
        <li><img src="<?php echo img("GgC66865860vC") ;?>" alt="图片" /></li>
    </ul>
    <div class="banner_wrap">
        <ul class="banner_count"></ul>
    </div>
</div>
<!-- 导航 -->
<div class="mIndex-boxes">
    <a href="<?php echo $root?>m/mAbout.php">
        <div class="box box1">
            <div class="trapezoid"></div>
            <span>关于我们</span>
        </div>
    </a>
    <a href="<?php echo $root?>m/mDynamic.php">
        <div class="box box2">
            <div class="trapezoid"></div>
            <span>业界动态</span>
        </div>
    </a>
    <a href="<?php echo $root?>m/mProductAssess.php">
        <div class="box box3">
            <div class="trapezoid"></div>
            <span>产品评测</span>
        </div>
    </a>
    <a href="<?php echo $root?>m/mContact.php">
        <div class="box box4">
            <div class="trapezoid"></div>
            <span>联系我们</span>
        </div>
    </a>
</div>

<!-- 服务 -->
<div class="pursuit-quality">
    <div class="pic"><img src="<?php echo img("Ier66869686Ke");?>" alt=""></div>
    <p class="chinese">用热心、细心、诚心、恒心沟通，在平凡、平淡、真诚、真切中服务。</p>
    <p>With enthusiasm, attentive, sincere, perseverance communication, in the ordinary, plain, sincere, real service.</p>
</div>

<!-- 售后团队 -->
<div class="aftermarket">
    <h3>售后团队</h3>
    <ul>
        <li>
            <img src="<?php echo img("ZdS65747817Mg");?>" alt="图片" />
        </li>
        <li>
            <img src="<?php echo img("dWD65747870lK");?>" alt="图片" />
        </li>
        <li>
            <img src="<?php echo img("TXk65747892ls");?>" alt="图片" />
        </li>
        <li>
            <img src="<?php echo img("oiG65747918Uq");?>" alt="图片" />
        </li>
    </ul>
</div>

<!-- 售后设备 -->
<div class="mIndex-device">
    <h3>售后设备</h3>
    <ul>
        <?php echo $device;?>
    </ul>
</div>

<!-- 动态与评测 -->
<div class="mIndex-dynamic">
    <h3>动态与评测</h3>
    <ul class="clearfix">
        <?php echo $dynamic;?>
        <?php echo $productAssess;?>
    </ul>
</div>

<!-- 关于我们 -->
<div class="mIndex-about">
    <div class="pic">
        <img src="<?php echo img("yu3548d");?>" alt="图片" />
    </div>
    <h3><?php echo $article['title'];?></h3>
    <p><?php echo $article['summary'];?></p>
</div>
<?php echo mFooter().mNav().warn();?>
</body>
<script>
    $(function(){
        //轮播图
        TouchSlide({
            slideCell:"#index_banner",
            titCell:"#index_banner .banner_count",
            mainCell:"#index_banner .banner_img",
            effect:"leftLoop",
            autoPage:true,
            autoPlay:true
        });
    })
</script>
</html>