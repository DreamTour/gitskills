<?php
include "ku/adfunction.php";
ControlRoot("客户管理");
$ThisUrl = $adroot."adService.php";
$sql="SELECT * FROM service WHERE khid = '$_GET[clientId]' ".$_SESSION['adService']['Sql'];
paging($sql," order by time desc ",100);
$client = query("kehu", "khid = '$_GET[clientId]' ");
$onion = array(
    "客户管理" => "{$root}control/adClient.php",
    kong($client['companyName']) => "{$root}control/adClientMx.php?id={$client['khid']}",
    "维修反馈" => $ThisUrl
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
                维修说明：<input name="adServiceText" type="text" class="text TextPrice" value="<?php echo $_SESSION['adService']['serviceText'];?>">
                设备识别ID：<input name="adServiceIdentifyId" type="text" class="text TextPrice" value="<?php echo $_SESSION['adService']['identifyId'];?>">
                <?php echo select("searchManner", "select TextPrice", "--选择方式--", array("维修设备", "更换设备", "新增设备"), $_SESSION['adService']['manner']);?>
                维修人：<input name="adServiceName" type="text" class="text TextPrice" value="<?php echo $_SESSION['adService']['serviceName'];?>">
                <?php echo select("searchStatus", "select TextPrice", "--状态--", array("进行中", "完成"), $_SESSION['adService']['status']);?>
                <input type="submit" value="模糊查询">
            </form>
        </div>
        <div class="kuang">
		<span class="SpanButton">
			共找到<b class="must"><?php echo $num;?></b>条信息&nbsp;&nbsp;
			当前显示第<b class="must"><?php echo $page;?></b>页的信息
		</span>
            <span class="SpanButton FloatRight"><a href="<?php echo "{$root}control/adClientAfterSaleMx.php?clientId={$client['khid']}"?>">添加维修反馈</a></span>
            <span onclick="EditList('serviceForm','serviceDelete')" class="SpanButton FloatRight">删除所选</span>
            <span onclick="$('[name=ServiceForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
            <span onclick="$('[name=ServiceForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
        </div>
        <!--查询结束-->
        <!--列表开始-->
        <form name="serviceForm">
            <table class="TableMany">
                <tr>
                    <td></td>
                    <td>维修说明</td>
                    <td>设备识别ID</td>
                    <td>选择方式</td>
                    <td>维修人</td>
                    <td>完成时间</td>
                    <td>状态</td>
                    <td></td>
                </tr>
                <?php
                if($num > 0){
                    while($service = mysql_fetch_array($query)){
                        echo "
				<tr>
					<td><input name='serviceList[]' type='checkbox' value='{$service['id']}'/></td>
					<td>".kong($service['serviceText'])."</td>
					<td>".kong($service['identifyId'])."</td>
					<td>".kong($service['manner'])."</td>
					<td>".kong($service['serviceName'])."</td>
					<td>{$service['time']}</td>
					<td>".kong($service['status'])."</td>
					<td><a href='{$adroot}adClientAfterSaleMx.php?id={$service['id']}&clientId={$_GET['clientId']}'><span class='SpanButton'>详情</span></a></td>
				</tr>
				";
                    }
                }else{
                    echo "<tr><td colspan='8'>一条维修设备记录都没有</td></tr>";
                }
                ?>
            </table>
        </form>
        <div style="padding:10px;"><?php echo fenye($ThisUrl,7);?></div>
        <!--列表结束-->
    </div>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>