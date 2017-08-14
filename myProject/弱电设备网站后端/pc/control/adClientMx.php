<?php
include "ku/adfunction.php";
ControlRoot("客户管理");
$client = query("kehu"," khid = '$_GET[id]' ");
if(empty($client['khid']) and $client['khid'] != $_GET['id']){
    $_SESSION['warn'] = "未找到这个客户的信息";
    header("location:{$adroot}adClient.php");
    exit(0);
}
$Region = query("region", "id = '$client[regionId]' ");
//判断是否显示新增设备按钮
if ($_GET['id']) {
    $deviceBtn = "<span class=\"SpanButton FloatRight\"><a href=\"{$root}control/adDevice.php?clientId={$client['khid']}\">设备管理</a></span>";
    $repairBtn = "<span class=\"SpanButton FloatRight\"><a href=\"{$root}control/adClientRepair.php?clientId={$client['khid']}\">设备报修</a></span>";
    $afterSaleBtn = "<span class=\"SpanButton FloatRight\"><a href=\"{$root}control/adClientAfterSale.php?clientId={$client['khid']}\">维修反馈</a></span>";
}
else {
    $deviceBtn = '';
    $repairBtn = '';
    $afterSaleBtn = '';
}
$onion = array(
    "客户管理" => "{$root}control/adClient.php",
    kong($client['companyName']) => $ThisUrl
);
echo head("ad").adheader($onion);
?>
    <div class="column MinHeight">
        <!--基本资料开始-->
        <div class="kuang">
            <p>
                <img src="<?php echo root."img/images/text.png";?>">
                客户基本资料
                <?php echo $deviceBtn.$repairBtn.$afterSaleBtn;?>
            </p>
            <form name="ClientForm">
                <table class="TableRight">
                    <tr>
                        <td style="width:200px;">客户ID号：</td>
                        <td><?php echo kong($client['khid']);?></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;登录帐号：</td>
                        <td><input name="accountNumber" type="text" class="text" value="<?php echo $client['accountNumber'];?>"></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;公司名称：</td>
                        <td><input name="companyName" type="text" class="text" value="<?php echo $client['companyName'];?>"></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;所属区域：</td>
                        <td>
                            <select name="province" class="select"><?php echo RepeatOption("region","province","--省份--",$Region['province']);?></select>
                            <select name="city" class="select"><?php echo RepeatOption("region where province = '$Region[province]' ","city","--城市--",$Region['city']);?></select>
                            <select name="area" class="select"><?php echo IdOption("region where province = '$Region[province]' and city = '$Region[city]'","id","area","--区县--",$client['regionId']);?></select>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;详细地址：</td>
                        <td><input name="addressMx" type="text" class="text" value="<?php echo $client['addressMx'];?>"></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;联系人姓名：</td>
                        <td><input name="contactName" type="text" class="text" value="<?php echo $client['contactName'];?>"></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;联系人手机号码：</td>
                        <td><input name="contactTel" type="text" class="text" value="<?php echo $client['contactTel'];?>"></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;登录密码：</td>
                        <td><input name="khpas" type="text" class="text" value="<?php echo $client['khpas'];?>"></td>
                    <tr>
                        <td>更新时间：</td>
                        <td><?php echo kong($client['updateTime']);?></td>
                    </tr>
                    <tr>
                        <td>创建时间：</td>
                        <td><?php echo kong($client['time']);?></td>
                    </tr>
                    <tr>
                        <td><input name="adClientId" type="hidden" value="<?php echo $client['khid'];?>"></td>
                        <td><input onclick="Sub('ClientForm','<?php echo root."control/ku/addata.php?type=adClientMx";?>')" type="button" class="button" value="提交"></td>
                    </tr>
                </table>
            </form>
        </div>
        <!--基本资料结束-->
    </div>
<script>
    window.onload = function() {
        var Form = document.ClientForm;
        //根据省份获取下属城市下拉菜单
        Form.province.onchange = function(){
            Form.area.innerHTML = "<option value=''>--区县--</option>";
            $.post("<?php echo root."library/OpenData.php";?>",{ProvincePostCity:this.value},function(data){
                Form.city.innerHTML = data.city;
            },"json");
        };
        //根据省份和城市获取下属区域下拉菜单
        Form.city.onchange = function(){
            $.post("<?php echo root."library/OpenData.php";?>",{ProvincePostArea:Form.province.value,CityPostArea:this.value},function(data){
                Form.area.innerHTML = data.area;
            },"json");
        };
    }
</script>
<?php echo warn().adfooter();?>