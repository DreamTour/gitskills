<?php
include "ku/adfunction.php";
ControlRoot("任务管理");
if ($admin['name'] == "超级管理员") {
	$where = "";	
}
else {
	$where = "and adid='$Control[adid]' ";		
}
//传过来的任务ID
$taskID = FormSub($_GET['taskId']);
//传过来的被分配者ID
$adID = FormSub($_GET['adid']);
$sql="SELECT * FROM taskAllotFile WHERE adid = '$adID' and taskId = '$taskID' ";//.$where.$_SESSION['adTaskAllotFiler']['Sql'];
paging($sql," order by time desc ",100);

$onion = array(
	"任务管理" => "{$root}control/adTask.php",
    "查看被分配者文件上传情况" => $ThisUrl
);
echo head("ad").adheader($onion);
?>
<div class="column minheight">
    <!--查询开始 每个被分配者上传的附件很少，暂时先注释了，功能还没有做
	<div class="search">
		<form name="Search" action="<?php echo root."control/ku/adpost.php?type=adTaskTaskAllotFiler";?>" method="post">
            <?php echo $searchAdId; ?>
            被分配者：<input name="TaskAllotFilerName" type="text" class="select TextPrice" value="<?php echo $_SESSION['adTaskAllotFiler']['name'];?>">
            任务名称：<input name="TaskAllotFilerName" type="text" class="select TextPrice" value="<?php echo $_SESSION['adTaskAllotFiler']['name'];?>">
            任务说明：<input name="TaskAllotFilerName" type="text" class="select TextPrice" value="<?php echo $_SESSION['adTaskAllotFiler']['name'];?>">
			<input type="submit" value="模糊查询">
		</form>
	</div>-->
	<div class="search">
		<span class="smallWord">
			共找到<b class="must"><?php echo $num;?></b>条信息&nbsp;&nbsp;
			当前显示第<b class="must"><?php echo $page;?></b>页的信息
		</span>
        <!--<span onclick="EditList('TaskAllotFilerForm','DeleteTaskAllotFiler')" class="SpanButton FloatRight">删除被分配者上传的文件</span>-->
        <!--<span onclick="$('[name=TaskAllotFilerForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
		<span onclick="$('[name=TaskAllotFilerForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>-->
	</div>
	<!--查询结束-->
	<!--列表开始-->
	<form name="TaskAllotFilerForm">
	<table class="TableMany">
		<tr>
			<!--<td></td>-->
            <td>被分配者</td>
			<td>任务名称</td>
            <td>任务说明</td>
            <!--<td>附件的ID号</td>-->
            <td>下载附件</td>
		</tr>
		<?php
		if($num == 0){
			echo "<tr><td colspan='7'>一条信息都没有</td></tr>";
		}else{
			while($taskAllotFiler = mysql_fetch_array($query)){
				$admin = query("admin", "adid = '$taskAllotFiler[adid]' ");
				$task = query("task", "id = '$taskAllotFiler[taskId]'");
				echo "
				<tr>
					<!--<td><input name='TaskAllotFilerList[]' type='checkbox' value='{$taskAllotFiler['id']}'/></td>-->
					<td>{$admin['adname']}</td>
					<td>{$task['name']}</td>
					<td>{$task['text']}</td>
					<!--<td>{$taskAllotFiler['mouldFileId']}</td>-->
					<td><a target='_blank' href='{$root}{$taskAllotFiler['src']}'><span class='SpanButton'>下载</span></a></td>
				</tr>
				";
			}
		}
		?>
	</table>
	</form>
	<?php echo fenye($ThisUrl,7);?>
	<!--列表结束-->
</div>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>