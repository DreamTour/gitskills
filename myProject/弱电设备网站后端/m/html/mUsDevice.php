<?php
include "../../library/mFunction.php";
//判断显示不同系统的设备
if ($_GET['id']) {
    $where .= "and type = '$_GET[id]' ";
} else {
    $where .= "";
}
//循环设备列表
$client = query("kehu", "khid = '$kehu[khid]' ");
$deviceSql = mysql_query("SELECT * FROM device WHERE contactNumber = '$client[accountNumber]' ".$where);
$device = "";
if (mysql_num_rows($deviceSql) == 0) {
    $device = "一台设备信息都没有";
} else {
    while ($array = mysql_fetch_assoc($deviceSql)) {
        if (empty($array['ico'])) {
            $ico = img('ZEg70828834DN');
        }
        else {
            $ico = $root.$array['ico'];
        }
        $system = query("system", "id = '$array[type]' ");
        $device .= "
            <li class='deviceList-item clearfix'>
                <a href='{$root}m/mUser/mUsDeviceDetails.php?id={$array['id']}'>
						<span>{$array['identifyId']}</span>
                        <span>{$array['name']}</span>
                        <span>{$array['model']}</span>
                        <span>{$array['brand']}</span>
                        <span>{$system['name']}</span>
                        <span>{$array['num']}</span>
                        <span>{$array['unit']}</span>
					</a>
                <!--<p class='device-bespeak'>
                    <img class=\"fr qr-code\" src='{$root}pay/wxpay/wxScanPng.php?url={$root}m/mUser/mUsDeviceDetails.php?id={$array['id']}' />
                </p>-->
            </li>
        ";
    }
}
echo head("m").mHeader();
;?>
<!-- 搜索表单 -->
<form name="searchForm">
    <div class="search">
        <div class="select-date">
            <?php echo year('StartYear','select TextPrice','',"").moon('StartMoon','select TextPrice',"").day('StartDay','select TextPrice',"");?>
            <span>-</span>
            <?php echo year('EndYear','select TextPrice','',"").moon('EndMoon','select TextPrice',"").day('EndDay','select TextPrice',"");?>
        </div>
        <input name="identifyId" type="text" placeholder="请输入设备查询ID" />
        <input name="name" type="text" placeholder="请输入设备品名" />
        <input name="model" type="text" placeholder="请输入设备型号" />
        <input name="brand" type="text" placeholder="请输入设备品牌" />
        <a href="javascript:;" id="searchDeviceButton">搜索</a>
    </div>
</form>
<!-- 设备列表 -->
<div class="device">
    <ul id="deviceList-box">
        <li class="deviceList-head clearfix">
            <span>查询ID</span>
            <span>名称</span>
            <span>型号</span>
            <span>品牌</span>
            <span>系统类别</span>
            <span>数量</span>
            <span>单位</span>
        </li>
        <?php echo $device;?>
    </ul>
</div>
<!-- 二维码弹出层 -->
<div class="qr-code-shade hide">
    <img class="shade-img" src="" />
</div>
<!-- 页脚 -->
<?php echo mFooter().mNav();?>
</body>
<script>
    window.onload = function() {
        //点击二维码弹出对应的图纸
        entrust('deviceList-box', '.qr-code-shade', 'click', 'IMG', 'qr-code', '.shade-img');
        //搜索表单提交
        $('#searchDeviceButton').click(function(){
            $.post("<?php echo root."library/usData.php";?>",$("[name=searchForm]").serialize(),function(data){
                $('#deviceList-box').html(data.html);
            },"json");
        });
    }
</script>
</html>