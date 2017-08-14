<?php
include "ku/adfunction.php";
ControlRoot("任务管理");
//权限判断
if ($adDuty['sharer'] == "是") {
	$where = "";
	//专属于超级管理员的操作按钮
	$operate = "
		<span class='SpanButton FloatRight' id='allot'>分配任务</span>
        <a href='{$root}control/adTaskMx.php'><span class='SpanButton FloatRight'>新建任务</span></a>
        <a href='{$root}control/adTaskMould.php'><span class='SpanButton FloatRight'>模板管理</span></a>
        <span onclick=\"EditList('taskForm','DeleteTask')\" class='SpanButton FloatRight'>删除任务</span>
	";	
}else {
	$where = "and allot like '%$Control[adid]%' ";	
}
$sql="select * from task where 1=1 ".$where.$_SESSION['adTask']['Sql'];
paging($sql," order by time desc ",100);
$onion = array(
    "任务管理" => $ThisUrl
);
echo head("ad").adheader($onion);
?>
<div class="column minheight">
    <!--查询开始-->
	<div class="search">
		<form name="Search" action="<?php echo root."control/ku/adpost.php?type=adTask";?>" method="post">
            任务名称：<input name="taskName" type="text" class="select TextPrice" value="<?php echo $_SESSION['adTask']['name'];?>">
			<input type="submit" value="模糊查询">
		</form>
	</div>
	<div class="search">
		<span class="smallWord">
			共找到<b class="must"><?php echo $num;?></b>条信息&nbsp;&nbsp;
			当前显示第<b class="must"><?php echo $page;?></b>页的信息
		</span>
        <?php echo $operate;?>
        <span onclick="$('[name=taskForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
		<span onclick="$('[name=taskForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
	</div>
	<!--查询结束-->
	<!--列表开始-->
	<form name="taskForm">
	<table class="TableMany">
		<tr>
			<td></td>
            <td>任务名称</td>
            <td>任务说明</td>
            <td>任务截止时间</td>
			<td>创建时间</td>
            <td></td>
		</tr>
		<?php
		if($num == 0){
			echo "<tr><td colspan='5'>一条信息都没有</td></tr>";
		}else{
			while($task = mysql_fetch_array($query)){
				echo "
				<tr>
					<td><input name='taskList[]' type='checkbox' value='{$task['id']}'/></td>
					<td>{$task['name']}</td>
					<td>{$task['text']}</td>
					<td>{$task['endTime']}</td>
					<td>{$task['time']}</td>
					<td><a href='{$root}control/adTaskMx.php?id={$task['id']}'><span class='SpanButton'>详情</span></a></td>
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
<!--分配弹出层-->
<div class='hide' id='allotShade'>
    <div class='dibian'></div>
    <div class='win' style='width:500px; height:230px; margin:-115px 0 0 -250px;'>
        <p class='winTitle'>分配任务<span class='winClose' onclick="$('#allotShade').hide()">×</span></p>
        <form name='allotShadeForm'>
        <table class='TableRight'>
            <tr>
                <td style='width:100px;'>分配信息：</td>
                <td>将任务分配给指定的人</td>
            </tr>
            <tr>
                <td>被分配者：</td>
                <td>
                	<?php echo IDSelect("admin where duty in (select id from adDuty where task = '是') ","taskAllot","select","adid","adname","--分配--","");?>
                </td>
            </tr>
             <tr>
                <td>执行方向：</td>
                <td><?php echo radio("direction", array("批量分配", "撤销分配"), "");?></td>
            </tr>
            <tr>
                <td>登录密码：</td>
                <td><input name="taskPassword" type="password" class="text short"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="button" class="button" value="确认提交" onclick="Sub('taskForm,allotShadeForm','<?php echo "{$root}control/ku/addata.php?type=allotShadeForm";?>')"></td>
            </tr>
        </table>
        </form>
    </div>
</div>
<!--分配弹出层-->
<script>
	window.onload = function() {
		document.getElementById('allot').onclick = function() {
			$('#allotShade').fadeIn();	
		}	
	}
</script>   
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>