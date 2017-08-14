<?php
include "library/PcFunction.php";
UserRoot("pc");
//判断显示不同系统的设备
if ($_GET['id']) {
    $where .= "and type = '$_GET[id]' ";
} else {
    $where .= "";
}
//导航设备搜索
if (!empty ($_GET['search_text']) ) {
    $key = FormSub($_GET['search_text']);
    $where .= "and name like '%$key%' or model like '%$key%' ";
}
//循环设备列表
$client = query("kehu", "khid = '$kehu[khid]' ");
$deviceSql = mysql_query("SELECT * FROM device WHERE contactNumber = '$client[accountNumber]' ".$where);
$device = "";
if (mysql_num_rows($deviceSql) == 0) {
    $device = "<li class='deviceList-item clearfix'>一台设备信息都没有</li>";
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
                 <a href='{$root}deviceDetails.php?id={$array['id']}'>
                     <span>{$array['identifyId']}</span>
                     <span>{$array['name']}</span>
                     <span>{$array['model']}</span>
                     <span>{$array['brand']}</span>
                     <span>{$system['name']}</span>
                     <span>{$array['num']}</span>
                     <span>{$array['unit']}</span>
                </a>
            </li>
        ";
    }
}
echo head("pc").headerPC().navTwo();
;?>
<!--filter-->
<div class="device-bg">
    <div class="filter container" id="filter">
        <form name="searchForm">
            <dl class="filter-item clearflx">
                <dt class="filter-name">采购日期</dt>
                <dd class="filter-list">
                    <?php echo year('StartYear','select TextPrice','',"").moon('StartMoon','select TextPrice',"").day('StartDay','select TextPrice',"");?> 至
                    <?php echo year('EndYear','select TextPrice','',"").moon('EndMoon','select TextPrice',"").day('EndDay','select TextPrice',"");?>
                </dd>
            </dl>
            <dl class="filter-item clearflx">
                <dt class="filter-name">设备查询ID</dt>
                <dd class="filter-list">
                    <input name="identifyId" type="text" value="" placeholder="请输入设备查询ID" />
                </dd>
            </dl>
            <dl class="filter-item clearflx">
                <dt class="filter-name">设备名称</dt>
                <dd class="filter-list">
                    <input name="name" type="text" placeholder="请输入设备名称" />
                </dd>
            </dl>
            <dl class="filter-item clearflx">
                <dt class="filter-name">设备型号</dt>
                <dd class="filter-list">
                    <input name="model" type="text" placeholder="请输入设备型号" />
                </dd>
            </dl>
            <dl class="filter-item clearflx">
                <dt class="filter-name">设备品牌</dt>
                <dd class="filter-list">
                    <input name="brand" type="text" placeholder="请输入设备品牌" />
                </dd>
            </dl>
            <dl class="filter-item clearflx">
                <dt class="filter-name">点击搜索</dt>
                <dd class="filter-list">
                    <div class="searchDeviceButton" id="searchDeviceButton">搜索</div>
                </dd>
            </dl>
        </form>
    </div>
    <!-- 内容 -->
    <div class="deviceList clearfix container">
        <ul class="deviceList-box clearflx" id="deviceList-box">
            <li class='deviceList-head clearfix'>
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
</div>
<!-- 二维码弹出层 -->
<div class="qr-code-shade hide">
        <img class="shade-img" src="" />
</div>
<!-- 页脚 -->
<?php echo footerPC().warn();?>
</body>
<script>
    window.onload = function() {
        //点击出现弹出层显示对应的设备二维码
        entrust('deviceList-box', '.qr-code-shade', 'click', 'IMG', 'qr-code', '.shade-img');
        //搜索表单提交
        $('#searchDeviceButton').click(function(){
            $.post("<?php echo root."library/usData.php";?>",$("[name=searchForm]").serialize(),function(data){
                $('#deviceList-box').html(data.html);
            },"json");
        });
        //搜索表单placeholder
        jQuery('input[placeholder]').placeholder();
    }
</script>
</html>