<?php
include "ku/adfunction.php";
ControlRoot("客户管理");
$repair = query("repair"," id = '$_GET[id]' ");
if(empty($repair['id']) and $repair['id'] != $_GET['id']){
    $_SESSION['warn'] = "未找到这个设备的信息";
    header("location:{$adroot}adClient.php");
    exit(0);
}
//设备数量默认为一台
if (empty($repair['num'])) {
    $repair['num'] = 1;
}
//设备单位默认为台
if (empty($repair['unit'])) {
    $repair['unit'] = '台';
}
$client = query("kehu", "khid = '$_GET[clientId]' ");
$onion = array(
    "客户管理" => "{$root}control/adClient.php",
    kong($client['companyName']) => "{$root}control/adClientMx.php?id={$client['khid']}",
    "设备报修" => "{$root}control/adClientRepair.php?clientId={$client['khid']}",
    kong($repair['id']) => $ThisUrl,
);
echo head("ad").adheader($onion);
?>
    <div class="column MinHeight">
        <!--基本资料开始-->
        <div class="kuang">
            <p>
                <img src="<?php echo root."img/images/text.png";?>">
                设备基本资料
            </p>
            <form name="repairForm">
                <table class="TableRight">
                    <tr>
                        <td style="width:200px;">设备ID号：</td>
                        <td><?php echo kong($repair['id']);?></td>
                    </tr>
                   <!-- <tr>
                        <td><span class="must">*</span>&nbsp;报修时间：</td>
                        <td><?php /*echo year('repairYear','select TextPrice','',$repair['repairTime']).moon('repairMoon','select TextPrice',$repair['repairTime']).day('repairDay','select TextPrice',$repair['repairTime']);*/?></td>
                    </tr>-->
                    <tr>
                        <td><span class="must">*</span>&nbsp;系统名称：</td>
                        <td><?php echo IDSelect("system", "type", "select", "id", "name", "--系统类别--", $repair['type']);?></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;状态：</td>
                        <td><?php echo select("status","select","--选择--",array("进行中","完成"),$repair['status']);?></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;故障描述：</td>
                        <td><textarea name="repairText" class="textarea"><?php echo $repair['repairText']?></textarea></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;报案人：</td>
                        <td><input name="contactName" type="text" class="text" value="<?php echo $repair['contactName'];?>"></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;联系方式：</td>
                        <td><input name="contactTel" type="text" class="text" value="<?php echo $repair['contactTel'];?>"></td>
                    </tr>
                    <!--<tr>
                        <td><span class="must">*</span>&nbsp;客户帐号：</td>
                        <td>
                            <select name="contactNumberSelect" class="select">
                                <?php /*echo RepeatOption("kehu","accountNumber","--选择--",$repair['contactNumber']);*/?>
                            </select>
                            <input name="contactNumber" type="text" class="text short" value="<?php /*echo $repair['contactNumber'];*/?>">
                        </td>
                    </tr>-->
                    <tr>
                        <td>更新时间：</td>
                        <td><?php echo kong($repair['updateTime']);?></td>
                    </tr>
                    <tr>
                        <td>创建时间：</td>
                        <td><?php echo kong($repair['time']);?></td>
                    </tr>
                    <tr>
                        <td>
                            <input name="adDeviceId" type="hidden" value="<?php echo $repair['id'];?>">
                            <input name="clientId" type="hidden" value="<?php echo $client['khid'];?>">
                        </td>
                        <td><input onclick="Sub('repairForm','<?php echo root."control/ku/addata.php?type=adRepairMx";?>')" type="button" class="button" value="提交"></td>
                    </tr>
                </table>
            </form>
        </div>
        <!--基本资料结束-->
    </div>
    <script>
        $(document).ready(function(){
            var Form = document.repairForm;
            //将年款下拉菜单的值赋值到text
            /*Form.contactNumberSelect.onchange = function(){
                Form.contactNumber.value = this.value;
            }*/
        });
    </script>
<?php echo warn().adfooter();?>