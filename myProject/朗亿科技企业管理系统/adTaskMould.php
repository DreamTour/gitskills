<?php
include "ku/adfunction.php";
ControlRoot("任务管理");
$sql="select * from mould ".$_SESSION['adMould']['Sql'];
paging($sql," order by time desc ",100);
$onion = array(
	"任务管理" => "{$root}control/adTask.php",
    "模板管理" => $ThisUrl
);
echo head("ad").adheader($onion);
?>
<div class="column minheight">
    <!--查询开始-->
	<div class="search">
		<form name="Search" action="<?php echo root."control/ku/adpost.php?type=adTaskMould";?>" method="post">
            <?php echo $searchAdId; ?>
            模板名称：<input name="MouldName" type="text" class="select TextPrice" value="<?php echo $_SESSION['adMould']['name'];?>">         
			<input type="submit" value="模糊查询">
		</form>
	</div>
	<div class="search">
		<span class="smallWord">
			共找到<b class="must"><?php echo $num;?></b>条信息&nbsp;&nbsp;
			当前显示第<b class="must"><?php echo $page;?></b>页的信息
		</span>
        <a href="<?php echo root."control/adTaskMouldMx.php";?>"><span class="SpanButton FloatRight">新建模板</span></a>
        <span onclick="EditList('MouldForm','DeleteMould')" class="SpanButton FloatRight">删除模板</span>
        <span onclick="$('[name=MouldForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
		<span onclick="$('[name=MouldForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
	</div>
	<!--查询结束-->
	<!--列表开始-->
	<form name="MouldForm">
	<table class="TableMany">
		<tr>
			<td></td>
            <td>模板名称</td>
			<td>创建时间</td>
            <td></td>
		</tr>
		<?php
		if($num == 0){
			echo "<tr><td colspan='4'>一条信息都没有</td></tr>";
		}else{
			while($mould = mysql_fetch_array($query)){
				echo "
				<tr>
					<td><input name='MouldList[]' type='checkbox' value='{$mould['id']}'/></td>
					<td>{$mould['name']}</td>
					<td>{$mould['time']}</td>
					<td><a href='{$root}control/adTaskMouldMx.php?id={$mould['id']}'><span class='SpanButton'>详情</span></a></td>
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