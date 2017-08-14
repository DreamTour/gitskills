<?php
include "../library/PcFunction.php";
UserRoot("pc");
//打印预约记录对应的信息
if ($_GET['bespeakId'] ) {
    $bespeak = query("bespeak", "id = '$_GET[bespeakId]' ");
    $system = query("system", "id = '$bespeak[type]' ");
    $title = "服务预约反馈";
    $identifyId = $bespeak['identifyId'];
    $name = $bespeak['name'];
    $model = $bespeak['model'];
    $brand = $bespeak['brand'];
    $type = $system['name'];
    $num = $bespeak['num'];
    $unit = $bespeak['unit'];
    $installSeat= $bespeak['installSeat'];
    $installTime = $bespeak['installTime'];
    $LastServiceTime = $bespeak['LastServiceTime'];
    $serviceNum = $bespeak['serviceNum'];
    $inSecurity = $bespeak['inSecurity'];
    $contactName = $bespeak['contactName'];
    $contactTel = $bespeak['contactTel'];
    $explainTitle = "预约说明";
    $explainText = $bespeak['bespeakText'];
    if (empty($bespeak['feedbackText'])) {
        $feedbackText = "还没有反馈";
    }else {
        $feedbackText = $bespeak['feedbackText'];
    }
    //打印投诉记录对应的信息
}elseif ($_GET['complainId']) {
    $complain = query("complain", "id = '$_GET[complainId]'");
    $device = query("device", "id = '$complain[deviceId]' ");
    $system = query("system", "id = '$device[type]'");
    $title = "投诉反馈";
    $identifyId = $device['identifyId'];
    $name = $device['name'];
    $model = $device['model'];
    $brand = $device['brand'];
    $type = $system['name'];
    $num = $device['num'];
    $unit = $device['unit'];
    $installSeat= $device['installSeat'];
    $installTime = $device['installTime'];
    $LastServiceTime = $device['LastServiceTime'];
    $serviceNum = $device['serviceNum'];
    $inSecurity = $device['inSecurity'];
    $contactName = $device['contactName'];
    $contactTel = $device['contactTel'];
    $explainTitle = "投诉说明";
    $explainText = $complain['complainText'];
    if (empty($complain['feedbackText'])) {
        $feedbackText = "还没有反馈";
    }else {
        $feedbackText = $complain['feedbackText'];
    }
    //打印维修记录对应的信息
}elseif ($_GET['serviceId']) {
    $service = query("service", "id = '$_GET[serviceId]'");
    $system = query("system", "id = '$service[type]'");
    $title = "我的维修记录";
    $identifyId = $service['identifyId'];
    $name = $service['name'];
    $model = $service['model'];
    $brand = $service['brand'];
    $type = $service['name'];
    $num = $service['num'];
    $unit = $service['unit'];
    $installSeat= $service['installSeat'];
    $installTime = $service['installTime'];
    $LastServiceTime = $service['LastServiceTime'];
    $serviceNum = $service['serviceNum'];
    $inSecurity = $service['inSecurity'];
    $contactName = $service['serviceName'];
    $contactTel = $service['serviceTel'];
    $explainTitle = "维修说明";
    $explainText = $service['serviceText'];
    $feedbackText = "无";
}
echo head("pc").headerPC().navTwo();
;?>
<!-- 内容 -->
<div class="mine-box clearfix container">
    <!--右边-->
    <div class="mine-right">
        <!--服务预约-->
        <div class="pe-info">
            <div class="pe-info-title"><i class="icon2 mine-icon5"></i><span><?php echo $title;?></span><a href="javascript:;" class="fr new-add"></a></div>
            <div class="pe-info-content clearfix">
                <form name="bespeakForm">
                    <ul class="labour-info">
                        <li>
                            <span class="pe-black01">设备识别ID：</span>
                            <span><?php echo $identifyId;?></span>
                        </li>
                        <li>
                            <span class="pe-black01">设备名称：</span>
                            <span><?php echo $name;?></span>
                        </li>
                        </li>
                        <li>
                            <span class="pe-black01">设备型号：</span>
                            <span><?php echo $model;?></span>
                        </li>
                        </li>
                        <li>
                            <span class="pe-black01">设备品牌：</span>
                            <span><?php echo $brand;?></span>
                        </li>
                        <li>
                            <span class="pe-black01">系统类别：</span>
                            <span><?php echo $type;?></span>
                        </li>
                        <li>
                            <span class="pe-black01">数量：</span>
                            <span><?php echo $num;?></span>
                        </li>
                        <li>
                            <span class="pe-black01">单位：</span>
                            <span><?php echo $unit;?></span>
                        </li>
                        <li>
                            <span class="pe-black01">安装位置：</span>
                            <span><?php echo $installSeat;?></span>
                        </li>
                        <li>
                            <span class="pe-black01">安装时间：</span>
                            <span><?php echo substr($installTime, 0, 10);?></span>
                        </li>
                        <li>
                            <span class="pe-black01">上次维修时间：</span>
                            <span><?php echo substr($LastServiceTime, 0 , 10);?></span>
                        </li>
                        <li>
                            <span class="pe-black01">维修次数：</span>
                            <span><?php echo $serviceNum;?></span>
                        </li>
                        <li>
                            <span class="pe-black01">在保：</span>
                            <span><?php echo $inSecurity;?></span>
                        </li>
                        <li>
                            <span class="pe-black01">联系人：</span>
                            <span><?php echo $contactName;?></span>
                        </li>
                        <li>
                            <span class="pe-black01">联系人电话：</span>
                            <span><?php echo $contactTel;?></span>
                        </li>
                        <li>
                            <span class="pe-black01"><?php echo $explainTitle;?>：</span>
                            <span><?php echo $explainText;?></span>
                        </li>
                        <li>
                            <span class="pe-black01">反馈说明：</span>
                            <span><?php echo $feedbackText;?></span>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- 页脚 -->
<?php echo footerPC().warn();?>
</body>
</html>