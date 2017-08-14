<?php
include "ku/adfunction.php";
ControlRoot("客户投诉");
$complain = query("complain"," id = '$_GET[id]' ");
if(empty($complain['id']) and $complain['id'] != $_GET['id']){
    $_SESSION['warn'] = "未找到这个投诉的信息";
    header("location:{$adroot}adComplain.php");
    exit(0);
}
//设备信息
$device = query("device", "id = '$complain[deviceId]' ");
//系统类别
$system = query("system", "id = '$device[type]' ");
//客户信息
$client = query("kehu", "khid = '$complain[khid]' ");
$onion = array(
    "客户投诉" => "{$root}control/adComplain.php",
    kong($device['name']) => $ThisUrl
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
            <form name="Form">
                <table class="TableRight">
                    <tr>
                        <td style="width:200px;">客户ID号：</td>
                        <td><?php echo kong($complain['khid']);?></td>
                    </tr>
                    <tr>
                        <td>联系人姓名：</td>
                        <td><?php echo $client['contactName'];?></td>
                    </tr>
                    <tr>
                        <td>联系人电话：</td>
                        <td><?php echo $client['contactTel'];?></td>
                    </tr>
                    <tr>
                        <td>投诉说明：</td>
                        <td><?php echo $complain['complainText'];?></td>
                    </tr>
                    <tr>
                        <td>投诉时间：</td>
                        <td><?php echo kong($device['time']);?></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;反馈：</td>
                        <td><textarea name="feedbackText" class="textarea"><?php echo $complain['feedbackText'];?></textarea></td>
                    </tr>
                    <tr>
                        <td><input name="adComplainId" type="hidden" value="<?php echo $complain['id'];?>"></td>
                        <td><input onclick="Sub('Form','<?php echo root."control/ku/addata.php?type=adComplainMx";?>')" type="button" class="button" value="提交"></td>
                    </tr>
                </table>
            </form>
        </div>
        <!--基本资料结束-->
    </div>
<?php echo warn().adfooter();?>