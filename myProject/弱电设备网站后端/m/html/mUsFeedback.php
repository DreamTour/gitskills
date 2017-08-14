<?php
include "../../library/mFunction.php";
UserRoot("m");
//打印预约记录对应的信息
if ($_GET['bespeakId'] ) {
    $bespeak = query("bespeak", "id = '$_GET[bespeakId]' ");
    $system = query("system", "id = '$bespeak[type]' ");
    $title = "服务预约详情";
    $serviceText = '';
    $identifyId = '';
    $manner = '';
    $serviceName = '';
    $time = '';
    $status = '';
    $type = "<li>
                <strong>系统类型：</strong>
                <span>{$system['name']}</span>
            </li>";
    $bespeakText = "<li>
                        <strong>故障现象描述：</strong>
                        <span>{$bespeak['bespeakText']}</span>
                    </li>";
    $bespeakTime = "<li>
                <strong>预约维护时间：</strong>
                <span>{$bespeak['bespeakTime']}</span>
            </li>";
    $contactName = "<li>
                        <strong>联系人：</strong>
                        <span>{$bespeak['contactName']}</span>
                    </li>";
    $contactTel = "<li>
                <strong>联系电话：</strong>
                <span>{$bespeak['contactTel']}</span>
            </li>";
    $remark = "<li>
                    <strong>备注：</strong>
                    <span>{$bespeak['remark']}</span>
                </li>";
    if (empty($bespeak['feedbackText'])) {
        $bespeak['feedbackText'] = "未反馈";
    }
    $feedbackText = "<li>
                    <strong>反馈：</strong>
                    <span>{$bespeak['feedbackText']}</span>
                </li>";
    $complainText = '';
    $feedbackTextComplain = '';
    $timeComplain = '';
    //打印投诉记录对应的信息
}elseif ($_GET['complainId']) {
    $complain = query("complain", "id = '$_GET[complainId]'");
    $device = query("device", "id = '$complain[deviceId]' ");
    $system = query("system", "id = '$device[type]'");
    $title = "投诉详情";
    $serviceText = '';
    $identifyId = '';
    $manner = '';
    $serviceName = '';
    $time = '';
    $status = '';
    $type = '';
    $bespeakText = '';
    $bespeakTime = '';
    $contactName = '';
    $contactTel = '';
    $remark = '';
    $complainText = "<li>
                        <strong>投诉说明：</strong>
                        <span>{$complain['complainText']}</span>
                    </li>";
    if (empty($complain['feedbackText'])) {
        $complain['feedbackText'] = "未反馈";
    }
    $feedbackTextComplain = "<li>
                        <strong>反馈：</strong>
                        <span>{$complain['feedbackText']}</span>
                    </li>";
    $timeComplain = "<li>
                        <strong>投诉时间：</strong>
                        <span>{$complain['time']}</span>
                    </li>";
    //打印维修记录对应的信息
}elseif ($_GET['serviceId']) {
    $service = query("service", "id = '$_GET[serviceId]'");
    $system = query("system", "id = '$service[type]'");
    $title = "我的维修记录详情";
    $serviceText = "<li>
                        <strong>维修说明：</strong>
                        <span>{$service['serviceText']}</span>
                    </li>";
    $identifyId = "<li>
                        <strong>设备查询id：</strong>
                        <span>{$service['identifyId']}</span>
                    </li>";
    $manner = "<li>
                        <strong>选择方式：</strong>
                        <span>{$service['manner']}</span>
                    </li>";
    $serviceName = "<li>
                        <strong>维修人：</strong>
                        <span>{$service['serviceName']}</span>
                    </li>";
    $time = "<li>
                        <strong>完成时间：</strong>
                        <span>{$service['time']}</span>
                    </li>";
    $status = "<li>
                        <strong>状态：</strong>
                        <span>{$service['status']}</span>
                    </li>";
    $type = '';
    $bespeakText = '';
    $bespeakTime = '';
    $contactName = '';
    $contactTel = '';
    $remark = '';
    $complainText = '';
    $feedbackTextComplain = '';
    $timeComplain = '';
}
echo head("m");
;?>
<body>
<div class="m-page">
    <h2 class="clearfix"><a class="fl" href="<?php echo getenv("HTTP_REFERER")?>"><</a><?php echo $title;?></h2>
    <form name="bespeakForm">
        <div class="wrap">
            <ul class="device-list mcdiv mcdiv11">
                <?php echo $serviceText.$identifyId.$manner.$serviceName.$time.$status.$type.$bespeakText.$bespeakTime.$contactName.$contactTel.$remark.$feedbackText.$complainText.$feedbackTextComplain.$timeComplain;?>
            </ul>
        </div>
    </form>
</div>
</body>
<?php echo warn();?>
</html>




