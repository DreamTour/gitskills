<?php
include "library/PcFunction.php";
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
            <li class='product-items'>
                <a href='{$root}deviceDetails.php?id={$array['id']}'>
                    <img src='{$ico}'>
                    <div class='product-text'>
                        <h5>{$array['name']}</h5>
                    </div>
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
                <a class=\"clearfix\" href='{$root}dynamicDetails.php?id={$array['id']}'>
                    <img src=\"{$array['ico']}\" alt=\"图片\" width='400' height='200' />
                    <h3>{$array['title']}</h3>
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
            <a class=\"clearfix\" href='{$root}dynamicDetails.php?id={$array['id']}'>
                <img src=\"{$array['ico']}\" alt=\"图片\" width='400' height='200' />
                <h3>{$array['title']}</h3>
                <p>{$array['summary']}</p>
            </a>
        </li>
        ";
    }
}
echo head("pc").headerPC().navOne();
;?>
<!--轮播图-->
<div id="slider">
    <div id="slider-list">
        <div class='slider-items'><img src='<?php echo img("cVB63009335DO");?>'></div>
        <div class='slider-items hide'><img src='<?php echo img("gnh63009406BO");?>'></div>
        <div class='slider-items hide'><img src='<?php echo img("tYx63009445rp");?>'></div>
    </div>
    <ul id="sort-items"></ul>
    <div id="slider-prev" class="slider-btn"></div>
    <div id="slider-next" class="slider-btn"></div>
</div>
<!-- 信息 -->
<div class="enterprise-msg">
    <ul>
        <li>
            <img src="<?php echo img("Cdx63940523lo");?>" alt="" />
            <strong>企业精神</strong>
            <p>团结 严谨 创新 永创第一</p>
        </li>
        <li>
            <img src="<?php echo img("euo63940629Bs");?>" alt="" />
            <strong>企业作风</strong>
            <p>以勤立业 以诚兴业</p>
        </li>
        <li>
            <img src="<?php echo img("rDE63940650Xe");?>" alt="" />
            <strong>经营理念</strong>
            <p>质量第一 诚信为本 用户至上</p>
        </li>
        <li>
            <img src="<?php echo img("SJx63940671hZ");?>" alt="" />
            <strong>经营方针</strong>
            <p>以质取胜　以新求进</p>
        </li>
        <li>
            <img src="<?php echo img("YTP63940694HJ");?>" alt="" />
            <strong>人才理念</strong>
            <p>以人为本 以能为先</p>
        </li>
    </ul>
</div>
<!--弱电365售后团队-->
<div class="index-case" >
    <div class="container">
        <div class="index-column-title"><h5>售后团队</h5><p>RUIDIAN 365 Aftermarket team</p></div>
        <div class="case-pic-container">
            <div class="case-pic-box clearfix">
                <ul class="case-picWrap case-picWrap-one clearfix">

                    <li class='case-list'>
                        <div class='photoShow'>
                            <a href='javascript:;' target='_blank'><img src='<?php echo img("ZdS65747817Mg");?>'></a>
                        </div>
                    </li>

                    <li class='case-list'>
                        <div class='photoShow'>
                            <a href='javascript:;' target='_blank'><img src='<?php echo img("dWD65747870lK");?>'></a>
                        </div>
                    </li>

                    <li class='case-list'>
                        <div class='photoShow'>
                            <a href='javascript:;' target='_blank'><img src='<?php echo img("TXk65747892ls");?>'></a>
                        </div>
                    </li>

                    <li class='case-list'>
                        <div class='photoShow'>
                            <a href='javascript:;' target='_blank'><img src='<?php echo img("oiG65747918Uq");?>'></a>
                        </div>
                    </li>
                </ul>
                <ul class="case-picWrap case-picWrap-two clearfix"></ul>
            </div>
        </div>
    </div>
</div>
<!--弱电365售后设备-->
<div class="index-product">
    <div class="container">
        <div class="index-column-title"><h5>售后设备</h5><p>RUIDIAN 365 Aftermarket device</p></div>
        <div class="product-picWrap">
            <ul class="product-list clearfix">
                <?php echo $device;?>
            </ul>
        </div>
    </div>
</div>

<!-- 动态和评测 -->
<div class="index-article container">
    <div class="index-column-title"><h5>动态与评测</h5><p>dynamic and evaluation</p></div>
    <ul class="clearfix">
        <?php echo $dynamic;?>
        <?php echo $productAssess;?>
    </ul>
</div>

<!--弱电365售后分店-->
<!--<div class="index-case" >
    <div class="container">
        <div class="index-column-title"><h5>弱电365售后分店</h5><p>RUIDIAN 365 service</p></div>
        <div class="case-pic-container case-pic-container2">
            <div class="case-pic-box clearfix">
                <ul class="case-picWrap case-picWrap-one case-picWrap-one2 clearfix">

                    <li class='case-list'>
                        <div class='photoShow'>
                            <a href='http://www.yumukeji.com/project//caseMx.php?type=&id=yLF61856809rk' target='_blank'><img src='<?php /*echo img("Dud65749949rC");*/?>'></a>
                        </div>
                    </li>

                    <li class='case-list'>
                        <div class='photoShow'>
                            <a href='http://www.yumukeji.com/project//caseMx.php?type=&id=fuO61258812Yk' target='_blank'><img src='<?php /*echo img("Tje65750210aU");*/?>'></a>
                        </div>
                    </li>

                    <li class='case-list'>
                        <div class='photoShow'>
                            <a href='http://www.yumukeji.com/project//caseMx.php?type=&id=zCI61259382ty' target='_blank'><img src='<?php /*echo img("snu65750232Qi");*/?>'></a>
                        </div>
                    </li>

                    <li class='case-list'>
                        <div class='photoShow'>
                            <a href='http://www.yumukeji.com/project//caseMx.php?type=&id=yXI61259520BY' target='_blank'><img src='<?php /*echo img("Wyh65750274kQ");*/?>'></a>
                        </div>
                    </li>

                </ul>
                <ul class="case-picWrap case-picWrap-two case-picWrap-two2 clearfix"></ul>
            </div>
        </div>
    </div>
</div>-->

<!--文章-->
<div class="index-news">
    <div class="container">
        <div class="news-title">
            <img src="<?php echo img("yu3548d");?>">
            <p class="overflow"><?php echo $article['title'];?></p>
        </div>
    </div>
    <div>
        <div class="news-content clearfix">
            <div class="news-box container">
                <div class="news-box-one">
                    <?php echo $article['summary'];?>
                </div>
                <div class="news-box-two">
                    <?php echo $article['summary'];?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 页脚 -->
<?php echo footerPC().warn();?>
</body>
<script>
    $(function(){
        //导航移动
        $(".nav").movebg({
            width:134,  /*滑块的大小*/
            extra:0,    /*额外反弹的距离*/
            speed:400,  /*滑块移动的速度*/
            rebound_speed:400   /*滑块反弹的速度*/
        });
    })
    window.onload= function() {
        //轮播图切换
        sliderWrap({
            slideCell:"slider",
            mainCell:"slider-list",
            titCell:"sort-items",
            prev:"slider-prev",
            next:"slider-next"
        });
        //弱电365售后团队无缝滚动
        seamlessScroll({
            containerID : ".case-pic-container",
            picWrapOneID : ".case-picWrap-one",
            picWrapTwoID : ".case-picWrap-two",
            direction : "left",
            speed : 10
        });
        //弱电365售后分店无缝滚动
        /*seamlessScroll({
            containerID : ".case-pic-container2",
            picWrapOneID : ".case-picWrap-one2",
            picWrapTwoID : ".case-picWrap-two2",
            direction : "left",
            speed : 10
        });*/
        //底部无缝滚动
        seamlessScroll({
            containerID : ".news-content",
            picWrapOneID : ".news-box-one",
            picWrapTwoID : ".news-box-two",
            direction : "top",
            speed : 20
        });
    }
</script>

</html>