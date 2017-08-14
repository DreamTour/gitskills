<?php
include "ku/adfunction.php";
ControlRoot("摆位图");
$ThisUrl = $adroot."adSystem.php";
$sql="select * from system ".$_SESSION['adSystem']['Sql'];
paging($sql," order by time desc ",100);
$onion = array(
    "摆位图" => $ThisUrl
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
                系统名称：<input name="adSystemName" type="text" class="text TextPrice" value="<?php echo $_SESSION['adSystem']['name'];?>">
                <input type="submit" value="模糊查询">
            </form>
        </div>
        <div class="kuang">
		<span class="SpanButton">
			共找到<b class="must"><?php echo $num;?></b>条信息&nbsp;&nbsp;
			当前显示第<b class="must"><?php echo $page;?></b>页的信息
		</span>
            <span class="SpanButton FloatRight"><a href="<?php echo $root?>control/adSystemMx.php">新增系统</a></span>
            <span onclick="EditList('SystemForm','SystemDelete')" class="SpanButton FloatRight">删除所选</span>
            <span onclick="$('[name=SystemForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
            <span onclick="$('[name=SystemForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
        </div>
        <!--查询结束-->
        <!--列表开始-->
        <form name="SystemForm">
            <table class="TableMany">
                <tr>
                    <td></td>
                    <td>系统名称</td>
                    <td>系统简称</td>
                    <td>创建时间</td>
                    <td></td>
                </tr>
                <?php
                if($num > 0){
                    while($system = mysql_fetch_array($query)){
                        echo "
				<tr>
					<td><input name='SystemList[]' type='checkbox' value='{$system['id']}'/></td>
					<td>".kong($system['name'])."</td>
					<td>".kong($system['abbreviation'])."</td>
					<td>{$system['time']}</td>
					<td><a href='{$adroot}adSystemMx.php?id={$system['id']}'><span class='SpanButton'>详情</span></a></td>
				</tr>
				";
                    }
                }else{
                    echo "<tr><td colspan='6'>一个系统都没有</td></tr>";
                }
                ?>
            </table>
        </form>
        <div style="padding:10px;"><?php echo fenye($ThisUrl,7);?></div>
        <!--列表结束-->
    </div>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>