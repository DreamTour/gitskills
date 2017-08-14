<?php
include "ku/adfunction.php";
ControlRoot("客户预约");
$bespeak = query("bespeak"," id = '$_GET[id]' ");
if(empty($bespeak['id']) and $bespeak['id'] != $_GET['id']){
    $_SESSION['warn'] = "未找到这个设备的信息";
    header("location:{$adroot}adClient.php");
    exit(0);
}
//系统类别
$system = query("system", "id = '$bespeak[type]' ");
$onion = array(
    "客户预约" => "{$root}control/adBespeak.php",
    kong($bespeak['name']) => $ThisUrl
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
            <form name="bespeakForm">
                <table class="TableRight">
                    <tr>
                        <td style="width:200px;">客户ID号：</td>
                        <td><?php echo kong($bespeak['id']);?></td>
                    </tr>
                    <tr>
                        <td>系统类别：</td>
                        <td><?php echo $system['name'];?></td>
                    </tr>
                    <tr>
                        <td>故障现象描述：</td>
                        <td><?php echo $bespeak['bespeakText'];?></td>
                    </tr>
                    <tr>
                        <td>预约维护时间：</td>
                        <td><?php echo kong($bespeak['bespeakTime']);?></td>
                    </tr>
                    <tr>
                        <td>联系人：</td>
                        <td><?php echo $bespeak['contactName'];?></td>
                    </tr><tr>
                        <td>联系电话：</td>
                        <td><?php echo $bespeak['contactTel'];?></td>
                    </tr>
                    <tr>
                        <td>备注：</td>
                        <td><?php echo $bespeak['remark'];?></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;反馈：</td>
                        <td><textarea name="feedbackText" class="textarea"><?php echo $bespeak['feedbackText'];?></textarea></td>
                    </tr>
                    <tr>
                        <td><input name="adBespeakId" type="hidden" value="<?php echo $bespeak['id'];?>"></td>
                        <td><input onclick="Sub('bespeakForm','<?php echo root."control/ku/addata.php?type=adBespeakMx";?>')" type="button" class="button" value="提交"></td>
                    </tr>
                </table>
            </form>
        </div>
        <!--基本资料结束-->
    </div>
<?php echo warn().adfooter();?>