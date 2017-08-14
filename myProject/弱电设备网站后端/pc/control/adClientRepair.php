<?php
include "ku/adfunction.php";
ControlRoot("客户管理");
$ThisUrl = $adroot."adRepair.php";
$sql="SELECT * FROM repair WHERE khid = '$_GET[clientId]' ".$_SESSION['adRepair']['Sql'];
$clientId = $get['clientId'];
paging($sql," order by time desc ",100);
$client = query("kehu", "khid = '$_GET[clientId]' ");
$onion = array(
    "客户管理" => "{$root}control/adClient.php",
    kong($client['companyName']) => "{$root}control/adClientMx.php?id={$client['khid']}",
    "设备报修" => $ThisUrl
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
                系统名称：<input name="adRepairName" type="text" class="text TextPrice" value="<?php echo $_SESSION['adRepair']['name'];?>">
                <?php echo select("searchStatus", "select TextPrice", "--状态--", array("进行中", "完成"), $_SESSION['adRepair']['status']);?>
                <input type="submit" value="模糊查询">
            </form>
        </div>
        <div class="kuang">
		<span class="SpanButton">
			共找到<b class="must"><?php echo $num;?></b>条信息&nbsp;&nbsp;
			当前显示第<b class="must"><?php echo $page;?></b>页的信息
		</span>
            <span class="SpanButton FloatRight"><a href="<?php echo "{$root}control/adClientRepairMx.php?clientId={$client['khid']}"?>">添加报修记录</a></span>
            <!--<span onclick="EditList('RepairForm','RepairDelete')" class="SpanButton FloatRight">删除所选</span>-->
            <span onclick="$('[name=RepairForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
            <span onclick="$('[name=RepairForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
        </div>
        <!--查询结束-->
        <!--列表开始-->
        <form name="RepairForm">
            <table class="TableMany">
                <tr>
                    <td></td>
                    <td>序号</td>
                    <td>报修时间</td>
                    <td>系统名称</td>
                    <td>状态</td>
                    <td></td>
                </tr>
                <?php
                if($num > 0){
                    while($array = mysql_fetch_array($query)){
                        //系统类别
                        $system = query("system", "id = '$array[type]' ");
                        echo "
				<tr>
					<td><input name='RepairList[]' type='checkbox' value='{$array['id']}'/></td>
					<td>{$array['list']}</td>
					<td>{$array['time']}</td>
					<td>".kong($system['name'])."</td>
					<td>".kong($array['status'])."</td>
					<td><a href='{$adroot}adClientRepairMx.php?id={$array['id']}&clientId={$_GET['clientId']}'><span class='SpanButton'>详情</span></a></td>
				</tr>
				";
                    }
                }else{
                    echo "<tr><td colspan='6'>一个设备都没有</td></tr>";
                }
                ?>
            </table>
        </form>
        <div style="padding:10px;"><?php echo fenye($ThisUrl,7);?></div>
        <!--列表结束-->
    </div>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>