<?php
include "../../library/mFunction.php";
//打印设备详情
$device = query("device", "id = '$_GET[id]' ");
$system = query("system", "id = '$device[type]' ");
//打印设备详情图片
$deviceImgSql = mysql_query("select * from deviceImg where deviceId = '$device[id]' ");
$deviceImg = "";
if (mysql_num_rows($deviceImgSql) > 0) {
    while($array = mysql_fetch_assoc($deviceImgSql)){
        $deviceImg .= "
		<li><img src=\"{$root}{$array['src']}\" alt=\"图片\" /></li>
	";
    }
}
else {
    $deviceImg .= '<li><span><img src='.img('ZEg70828834DN').'></span> </li>';
}
echo head("m");
;?>
<body>
<!-- 设备详情图片 -->
<div id="index_banner" class="index_banner">
    <ul class="banner_img">
        <?php echo $deviceImg;?>
    </ul>
    <div class="banner_wrap">
        <ul class="banner_count"></ul>
    </div>
</div>
<!-- 设备详情 -->
<h2 class="deviceDetails-h2"><?php echo $device['name'];?></h2>
<ul class="courseList">
    <!--<li>
        <div class="courseList_title">二维码</div>
        <div class="courseList_content"><img class="qr-code" src="<?php /*echo "{$root}pay/wxpay/wxScanPng.php?url={$root}m/mUser/mUsDeviceDetails.php?id={$device['id']}";*/?>" /></div>
    </li>-->
    <li>
        <div class="courseList_title">设备查询ID：</div>
        <div class="courseList_content"><?php echo $device['identifyId'];?></div>
    </li>
    <li>
        <div class="courseList_title">名称：</div>
        <div class="courseList_content"><?php echo $device['name'];?></div>
    </li>
    <li>
        <div class="courseList_title">型号：</div>
        <div class="courseList_content"><?php echo $device['model'];?></div>
    </li>
    <li>
        <div class="courseList_title">品牌：</div>
        <div class="courseList_content"><?php echo $device['brand'];?></div>
    </li>
    <li>
        <div class="courseList_title">系统类别：</div>
        <div class="courseList_content"><?php echo $system['name'];?></div>
    </li>
    <li>
        <div class="courseList_title">数量：</div>
        <div class="courseList_content"><?php echo $device['num'];?></div>
    </li>
    <li>
        <div class="courseList_title">单位：</div>
        <div class="courseList_content"><?php echo $device['unit'];?></div>
    </li>
    <li>
        <div class="courseList_title">安装位置：</div>
        <div class="courseList_content"><?php echo $device['installSeat'];?></div>
    </li>
    <li>
        <div class="courseList_title">安装时间：</div>
        <div class="courseList_content"><?php echo substr($device['installTime'], 0 , 10);?></div>
    </li>
    <li>
        <div class="courseList_title">上次维修时间：</div>
        <div class="courseList_content"><?php echo substr($device['LastServiceTime'], 0, 10);?></div>
    </li>
    <li>
        <div class="courseList_title">维修次数：</div>
        <div class="courseList_content"><?php echo $device['serviceNum'];?></div>
    </li>
    <li>
        <div class="courseList_title">在保：</div>
        <div class="courseList_content"><?php echo $device['inSecurity'];?></div>
    </li>
    <li>
        <div class="courseList_title">设备参数：</div>
        <div class="courseList_content"><?php echo $device['parameter'];?></div>
    </li>
    <!--<li>
        <div class="courseList_title">客户账号：</div>
        <div class="courseList_content"><?php /*echo $device['contactNumber'];*/?></div>
    </li>
    <li>
        <div class="courseList_title">客户单位联系人：</div>
        <div class="courseList_content"><?php /*echo $device['contactName'];*/?></div>
    </li>
    <li>
        <div class="courseList_title">客户单位联系人电话：</div>
        <div class="courseList_content"><?php /*echo $device['contactTel'];*/?></div>
    </li>
    <li>
        <div class="courseList_title">弱电365服务人员：</div>
        <div class="courseList_content"><?php /*echo $device['serviceName'];*/?></div>
    </li>
    <li>
        <div class="courseList_title">弱电365电话：</div>
        <div class="courseList_content"><?php /*echo $device['serviceTel'];*/?></div>
    </li>
    <li>
        <div class="courseList_title">合同生效服务期限：</div>
        <div class="courseList_content"><?php /*echo $device['startTime'];*/?> 到 <?php /*echo $device['endTime'];*/?></div>
    </li>-->
</ul>
<div class="deviceDetails-btn">
    <a class="btn-reservation" href="<?php echo $root;?>m/mUser/mUsBespeak.php">预约</a>
    <a class="btn-Complaints" href="<?php echo "{$root}m/mUser/mUsComplain.php?deviceId={$device['id']}";?>">投诉</a>
    <a class="btn-back" href="<?php echo getenv("HTTP_REFERER")?>">返回</a>
</div>
<!-- 二维码弹出层 -->
<div class="qr-code-shade hide">
    <img class="shade-img" src="" />
</div>
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
        //点击二维码弹出对应的图纸
        Drawing('.qr-code', '.shade-img', '.qr-code-shade');
    })
</script>
</html>
