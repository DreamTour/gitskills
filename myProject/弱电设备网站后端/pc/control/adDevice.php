<?php
include "ku/adfunction.php";
ControlRoot("客户管理");
$ThisUrl = $adroot."adDevice.php";
$sql="SELECT * FROM device WHERE khid = '$_GET[clientId]' ".$_SESSION['adDevice']['Sql'];
paging($sql," order by time desc ",100);
$client = query("kehu", "khid = '$_GET[clientId]' ");
$onion = array(
    "客户管理" => "{$root}control/adClient.php",
    kong($client['companyName']) => "{$root}control/adClientMx.php?id={$client['khid']}",
    "设备管理" => $ThisUrl
);
echo head("ad").adheader($onion);
?>
    <style>
        .adimgList{ height:38px;}
        .TableMany td{height:38px;}
        .adimgList:hover{ position:absolute; left:-20px; top:-20px; height:200px; z-index:100;}
    </style>
    <div class="column minheight">
        <div class="kuang">
            <form name="Search" action="<?php echo "{$adroot}ku/adpost.php";?>" method="post">
                <?php /*echo IDSelect("kehu","adDeviceAccountNumber","select","accountNumber","companyName","--选择公司名称--",$_SESSION['adDevice']['accountNumber']);*/?>
                设备查询ID：<input name="adDeviceIdentifyId" type="text" class="text TextPrice" value="<?php echo $_SESSION['adDevice']['identifyId'];?>">
                名称：<input name="adDeviceName" type="text" class="text TextPrice" value="<?php echo $_SESSION['adDevice']['name'];?>">
                型号：<input name="adDeviceModel" type="text" class="text TextPrice" value="<?php echo $_SESSION['adDevice']['model'];?>">
                品牌：<input name="adDeviceBrand" type="text" class="text TextPrice" value="<?php echo $_SESSION['adDevice']['brand'];?>">
                <input type="submit" value="模糊查询">
                <a href="<?php echo "{$adroot}ku/adpost.php?type=deleteSearch&searchName=adDevice";?>"><span class="SpanButton">返回列表</span></a>
            </form>
        </div>
        <div class="kuang">
		<span class="SpanButton">
			共找到<b class="must"><?php echo $num;?></b>条信息&nbsp;&nbsp;
			当前显示第<b class="must"><?php echo $page;?></b>页的信息
		</span>
            <span class="SpanButton FloatRight"><a href="<?php echo "{$root}control/adDeviceMx.php?clientId={$client['khid']}"?>">新增设备</a></span>
            <span onclick="EditList('DeviceForm','DeviceDelete')" class="SpanButton FloatRight">删除所选</span>
            <span onclick="$('[name=DeviceForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
            <span onclick="$('[name=DeviceForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
        </div>
        <!--查询结束-->
        <!--列表开始-->
        <form name="DeviceForm">
            <table class="TableMany">
                <tr>
                    <td></td>
                    <td>设备查询ID</td>
                    <td>名称</td>
                    <td>型号</td>
                    <td>品牌</td>
                    <td>设备参数</td>
                    <td>创建时间</td>
                    <td></td>
                </tr>
                <?php
                if($num > 0){
                    while($device = mysql_fetch_array($query)){
                        //查询系统
                        $system = query("system", "id = '$device[type]' ");
                        echo "
				<tr>
					<td><input name='DeviceList[]' type='checkbox' value='{$device['id']}'/></td>
					<td>".kong($device['identifyId'])."</td>
					<td>".kong($device['name'])."</td>
					<td>".kong($device['model'])."</td>
					<td>".kong($device['brand'])."</td>
					<td>".kong($device['parameter'])."</td>
					<td>{$device['time']}</td>
					<td><a href='{$adroot}adDeviceMx.php?id={$device['id']}&clientId={$_GET['clientId']}'><span class='SpanButton'>详情</span></a></td>
				</tr>
				";
                    }
                }else{
                    echo "<tr><td colspan='8'>一个设备都没有</td></tr>";
                }
                ?>
            </table>
        </form>
        <div style="padding:10px;"><?php echo fenye($ThisUrl,7);?></div>
        <!--列表结束-->
    </div>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>