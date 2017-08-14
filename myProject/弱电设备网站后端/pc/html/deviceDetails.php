<?php
include "library/PcFunction.php";
UserRoot("pc");
//打印设备详情
$device = query("device", "id = '$_GET[id]' ");
$system = query("system", "id = '$device[type]' ");
//打印设备详情图片
$deviceImgSql = mysql_query("select * from deviceImg where deviceId = '$device[id]' ");
$deviceImg = "";
if (mysql_num_rows($deviceImgSql) > 0) {
    while($array = mysql_fetch_assoc($deviceImgSql)){
        $deviceImg .= "
		<li><span><img src='{$root}{$array['src']}'></span> </li>
	";
    }
}
else {
    $deviceImg .= '<li><span><img src='.img('ZEg70828834DN').'></span> </li>';
}

echo head("pc").headerPC().navTwo();
;?>
<!-- 大图 -->
<div class="deviceDetails-banner banner"></div>
<!-- 设备信息 -->
<div class="device-message container clearfix">
    <!-- 图片切换 -->
    <div class="device-imgTab">
        <div class="imgTab-bigImg-box">
            <img src="" id="imgTab-bigImg">
            <div class="imgTab-btn imgTab-prev hide" id="imgTab-prev">&lt;</div>
            <div class="imgTab-btn imgTab-next hide" id="imgTab-next">&gt;</div>
        </div>
        <div class="imgTab-smallImg-box">
            <ul class="imgTab-smallImg-list clearfix" id="imgTab-smallImg-list">
                <?php echo $deviceImg;?>
            </ul>
        </div>
    </div>
    <!-- 设备参数 -->
    <div class="device-info">
        <h1 class="info-name"><?php echo $device['name'];?></h1>
        <div class="info-param">
            <ul>
                <!--<li>
                    <strong>二维码</strong>
                    <span><img class="qr-code" src="<?php /*echo img("Nbj65293590sH");*/?>" alt=""></span>
                </li>-->
                <li>
                    <strong>设备查询ID</strong>
                    <span><?php echo $device['identifyId'];?></span>
                </li>
                <li>
                    <strong>名称</strong>
                    <span><?php echo $device['name'];?></span>
                </li>
                <li>
                    <strong>型号</strong>
                    <span><?php echo $device['model'];?></span>
                </li>
                <li>
                    <strong>品牌</strong>
                    <span><?php echo $device['brand'];?></span>
                </li>
                <li>
                    <strong>系统类别</strong>
                    <span><?php echo $system['name'];?></span>
                </li>
                <li>
                    <strong>数量</strong>
                    <span><?php echo $device['num'];?><?php echo $device['unit'];?></span>
                </li>
                <li>
                    <strong>安装位置</strong>
                    <span><?php echo $device['installSeat'];?></span>
                </li>
                <li>
                    <strong>安装时间</strong>
                    <span><?php echo substr($device['installTime'], 0, 10);?></span>
                </li>
                <li>
                    <strong>上次维修时间</strong>
                    <span><?php echo substr($device['LastServiceTime'], 0, 10);?></span>
                </li>
                <li>
                    <strong>维修次数</strong>
                    <span><?php echo $device['serviceNum'];?></span>
                </li>
                <li>
                    <strong>在保</strong>
                    <span><?php echo $device['inSecurity'];?></span>
                </li>
                <li>
                    <strong>设备参数</strong>
                    <span><?php echo $device['parameter'];?></span>
                </li>
            </ul>
        </div>
        <!--<div class="info-button">
            <a href="<?php /*echo $root;*/?>user/bespeak.php" class="saleInfo-btn-buy" fade="button" role="button">预约</a>
            <a href="<?php /*echo "{$root}user/complain.php?deviceId={$device['id']}";*/?>" class="saleInfo-btn-buycar" fade="button" role="button">投诉</a>
        </div>-->
        <ul class="info-assure">
            <li><i class="site-icon"></i>接待对方从微笑开始</li>
            <li><i class="site-icon"></i>了解对方从倾听开始</li>
        </ul>
    </div>
</div>
<!-- 二维码弹出层 -->
<div class="qr-code-shade hide">
    <img class="shade-img" src="" />
</div>
<!-- 页脚 -->
<?php echo footerPC().warn();?>
</body>
<script>
    //小图大图切换
     imgTab({
     bigImgID : 'imgTab-bigImg',
     smallImgID: 'imgTab-smallImg-list',
     nextID: 'imgTab-next',
     prevID: 'imgTab-prev',
     boxID: '.imgTab-bigImg-box'
     });
    window.onload = function() {
        //点击出现弹出层显示对应的设备二维码
        Drawing('.qr-code', '.shade-img', '.qr-code-shade');
    }
</script>
</html>