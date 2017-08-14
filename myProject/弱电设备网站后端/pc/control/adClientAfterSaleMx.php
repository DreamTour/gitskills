<?php
include "ku/adfunction.php";
ControlRoot("客户管理");
$service = query("service"," id = '$_GET[id]' ");
if(empty($service['id']) and $service['id'] != $_GET['id']){
    $_SESSION['warn'] = "未找到这个维修设备的信息";
    header("location:{$adroot}adAfterSale.php");
    exit(0);
}
$client = query("kehu", "khid = '$_GET[clientId]' ");
$onion = array(
    "客户管理" => "{$root}control/adClient.php",
    kong($client['companyName']) => "{$root}control/adClientMx.php?id={$client['khid']}",
    "维修反馈" => "{$root}control/adClientAfterSale.php?clientId={$client['khid']}",
    kong($service['id']) => $ThisUrl,
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
            <form name="serviceForm">
                <table class="TableRight">
                    <tr>
                        <td style="width:200px;">设备ID号：</td>
                        <td><?php echo kong($service['id']);?></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;维修说明：</td>
                        <td><textarea name="serviceText" class="textarea"><?php echo $service['serviceText']?></textarea></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;设备识别ID号：</td>
                        <td><input name="identifyId" type="text" class="text" value="<?php echo $service['identifyId'];?>"></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;选择方式：</td>
                        <td>
                            <?php echo select("manner","select","--选择--",array("维修设备","新增设备","更换设备"),$service['manner']);?>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;维修人：</td>
                        <td><input name="serviceName" type="text" class="text" value="<?php echo $service['serviceName'];?>"></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;状态：</td>
                        <td><?php echo select("status","select","--选择--",array("完成","进行中"),$service['status']);?></td>
                    </tr>
                    <!--<tr>
                        <td><span class="must">*</span>&nbsp;客户帐号：</td>
                        <td>
                            <select name="contactNumberSelect" class="select">
                                <?php /*echo RepeatOption("kehu","accountNumber","--选择--",$service['contactNumber']);*/?>
                            </select>
                            <input name="contactNumber" type="text" class="text short" value="<?php /*echo $service['contactNumber'];*/?>">
                        </td>
                    </tr>-->
                    <tr>
                        <td>更新时间：</td>
                        <td><?php echo kong($service['updateTime']);?></td>
                    </tr>
                    <tr>
                        <td>创建时间：</td>
                        <td><?php echo kong($service['time']);?></td>
                    </tr>
                    <tr>
                        <td>
                            <input name="adServiceId" type="hidden" value="<?php echo $service['id'];?>">
                            <input name="clientId" type="hidden" value="<?php echo $client['khid'];?>">
                        </td>
                        <td><input onclick="Sub('serviceForm','<?php echo root."control/ku/addata.php?type=adAfterSaleMx";?>')" type="button" class="button" value="提交"></td>
                    </tr>
                </table>
            </form>
        </div>
        <!--基本资料结束-->
    </div>
    <script>
        $(document).ready(function(){
            var Form = document.serviceForm;
            //将客户帐号下拉菜单的值赋值到text
            /*Form.contactNumberSelect.onchange = function(){
                Form.contactNumber.value = this.value;
            }*/
        });
    </script>
<?php echo warn().adfooter();?>