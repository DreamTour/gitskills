<?php
include "ku/adfunction.php";
ControlRoot("客户管理");
$device = query("device"," id = '$_GET[id]' ");
if(empty($device['id']) and $device['id'] != $_GET['id']){
    $_SESSION['warn'] = "未找到这个设备的信息";
    header("location:{$adroot}adClient.php");
    exit(0);
}
//设备列表图像
$listIco = "&nbsp;<span onclick='document.adListIcoForm.adListIcoUpload.click();' class='SpanButton'>更新</span> 请按照1:1的比例上传图片";
//设备详情图片
$deviceImg = "
	<tr>
	   <td>设备详情图片：</td>
	   <td>
	";
$deviceImgSql = mysql_query(" select * from deviceImg where deviceId = '$device[id]' order by time desc ");
$num = mysql_num_rows($deviceImgSql);
if($num > 0){
    while($array = mysql_fetch_array($deviceImgSql)){
        $deviceImg .= "
			<a class='GoodsWin' target='_blank' href='{$root}{$array['src']}'><img src='{$root}{$array['src']}'></a>
			<a href='{$root}control/ku/adpost.php?deviceImgDelete={$array['id']}'><div>X</div></a>
			";
    }
}else{
    $deviceImg .= "一张图片都没有";
}
if($num < 4){
    $deviceImg .= "&nbsp;<span onclick='document.adDeviceMxIcoForm.adDeviceMxIcoUpload.click();' class='SpanButton'>新增</span> 请按照1:1的比例上传图片";
}
$deviceImg .= "
       </td>
    </tr>
	";
//设备数量默认为一台
if (empty($device['num'])) {
    $device['num'] = 1;
}
//设备单位默认为台
if (empty($device['unit'])) {
    $device['unit'] = '台';
}
$clientId = $_GET['clientId'];
//如果get到客户ID就默认选择该客户账号
if (empty($clientId)) {
    $client = query("kehu", "accountNumber = '$device[contactNumber]' ");
    $clientId = $client['khid'];
}
if ($_GET['clientId']) {
    $contactNumberSql = query("kehu", "khid = '$_GET[clientId]' ");
    $contactNumber = $contactNumberSql['accountNumber'];
}
else {
    $contactNumber = $device['contactNumber'];
}
//查询系统
$system = query("system", "id = '$device[type]' ");
//查询坐标热点图纸
$systemImgSeat = query("systemImgSeat", "deviceId = '$_GET[id]' ");
if (empty($systemImgSeat['systemImgId']) or empty($systemImgSeat['systemId'])) {
    $imgUrlBtn = "该设备还没有设置排位图";
}
else {
    $imgUrlBtn = "<a href='{$root}control/adSystemImg.php?imgId={$systemImgSeat['systemImgId']}&systemId={$systemImgSeat['systemId']}'>
                    <span class='SpanButton'>{$root}control/adSystemImg.php?imgId={$systemImgSeat['systemImgId']}&systemId={$systemImgSeat['systemId']}</span>
                 </a>";
}
$client = query("kehu", "khid = '$_GET[clientId]' ");
$onion = array(
    "客户管理" => "{$root}control/adClient.php",
    kong($client['companyName']) => "{$root}control/adClientMx.php?id={$client['khid']}",
    "设备管理" => "{$root}control/adDevice.php?clientId={$client['khid']}",
    kong($device['id']) => $ThisUrl,
);
echo head("ad").adheader($onion);
?>
    <div class="column MinHeight">
        <!--基本资料开始-->
        <div class="kuang">
            <p>
                <img src="<?php echo root."img/images/text.png";?>">
                设备基本资料
                <a href="<?php echo "{$root}control/adDeviceMx.php?clientId={$clientId}"?>"><span class="SpanButton FloatRight">再次添加</span></a>
            </p>
            <form name="deviceForm">
                <table class="TableRight">
                    <tr>
                        <td style="width:200px;">设备ID号：</td>
                        <td><?php echo kong($device['id']);?></td>
                    </tr>
                    <tr>
                        <td>设备查询ID号：</td>
                        <td><?php echo kong($device['identifyId']);?></td>
                    </tr>
                    <tr>
                        <td>排位图地址：</td>
                        <td><?php echo $imgUrlBtn;?></td>
                    </tr>
                    <tr>
                        <td>设备列表图片：</td>
                        <td><?php echo ProveImgShow($device['ico']).$listIco;?></td>
                    </tr>
                    <?php echo $deviceImg;?>
                    <tr>
                        <td><span class="must">*</span>&nbsp;名称：</td>
                        <td><input name="name" type="text" class="text" value="<?php echo $device['name'];?>"></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;型号：</td>
                        <td><input name="model" type="text" class="text" value="<?php echo $device['model'];?>"></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;品牌：</td>
                        <td><input name="brand" type="text" class="text" value="<?php echo $device['brand'];?>"></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;系统类别：</td>
                        <td><?php echo IDSelect("system", "type", "select", "id", "name", "--系统类别--", $device['type']);?></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;数量：</td>
                        <td><input name="num" type="text" class="text" value="<?php echo $device['num'];?>"></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;单位：</td>
                        <td><input name="unit" type="text" class="text" value="<?php echo $device['unit'];?>"></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;安装位置：</td>
                        <td><input name="installSeat" type="text" class="text" value="<?php echo $device['installSeat'];?>"></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;安装时间：</td>
                        <td><?php echo year('installYear','select TextPrice','',$device['installTime']).moon('installMoon','select TextPrice',$device['installTime']).day('installDay','select TextPrice',$device['installTime']);?></td>
                    </tr>
                    <tr>
                        <td>上次维修时间：</td>
                        <td><?php echo year('LastServiceYear','select TextPrice','',$device['LastServiceTime']).moon('LastServiceMoon','select TextPrice',$device['LastServiceTime']).day('LastServiceDay','select TextPrice',$device['LastServiceTime']);?></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;维修次数：</td>
                        <td><input name="serviceNum" type="text" class="text" value="<?php echo $device['serviceNum'];?>"></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;在保：</td>
                        <td><?php echo radio("inSecurity",array("是","否"),$device['inSecurity']);?></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;设备参数：</td>
                        <td><textarea name="parameter" class="textarea"><?php echo $device['parameter']?></textarea></td>
                    </tr>
                    <!--<tr>
                        <td><span class="must">*</span>&nbsp;客户账号：</td>
                        <td>
                            <select name="contactNumberSelect" class="select">
                                <?php /*echo RepeatOption("kehu","accountNumber","--选择--",$contactNumber);*/?>
                            </select>
                            <input name="contactNumber" type="text" class="text short" value="<?php /*echo $contactNumber;*/?>">
                        </td>
                    </tr>-->
                    <tr>
                        <td>更新时间：</td>
                        <td><?php echo kong($device['updateTime']);?></td>
                    </tr>
                    <tr>
                        <td>创建时间：</td>
                        <td><?php echo kong($device['time']);?></td>
                    </tr>
                    <tr>
                        <td>
                            <input name="adDeviceId" type="hidden" value="<?php echo $device['id'];?>">
                            <input name="clientId" type="hidden" value="<?php echo $client['khid'];?>">
                        </td>
                        <td><input onclick="Sub('deviceForm','<?php echo root."control/ku/addata.php?type=adDeviceMx";?>')" type="button" class="button" value="提交"></td>
                    </tr>
                </table>
            </form>
        </div>
        <!--基本资料结束-->
    </div>
    <div class="hide">
        <!--设备列表图片-->
        <form name="adListIcoForm" action="<?php echo root."control/ku/adpost.php";?>" method="post" enctype="multipart/form-data">
            <input name="adListIcoUpload" type="file" onchange="document.adListIcoForm.submit();">
            <input name="adListId" type="hidden" value="<?php echo $device['id'];?>">
        </form>
        <!--设备详情图片-->
        <form name="adDeviceMxIcoForm" action="<?php echo root."control/ku/adpost.php";?>" method="post" enctype="multipart/form-data">
            <input name="adDeviceMxIcoUpload" type="file" onchange="document.adDeviceMxIcoForm.submit();">
            <input name="adDeviceMxId" type="hidden" value="<?php echo $device['id'];?>">
        </form>
    </div>
    <script>
        $(document).ready(function(){
            var Form = document.deviceForm;
            //将年款下拉菜单的值赋值到text
            /*Form.contactNumberSelect.onchange = function(){
                Form.contactNumber.value = this.value;
            }*/
        });
    </script>
<?php echo warn().adfooter();?>