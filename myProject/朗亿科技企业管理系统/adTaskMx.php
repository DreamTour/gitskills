<?php
include "ku/adfunction.php";
ControlRoot("任务管理");
if(empty($_GET['id'])){
	$title = "新建任务";
	$button = "新增";
}else{
	$id = FormSub($_GET['id']);
	//根据传过来的id号查询任务
    $task = query("task"," id = '$id' ");
	//如果未找到
	if(empty($task['id'])){
		$_SESSION['warn'] = "未找到这个任务信息";
		header("location:{$root}control/adTask.php");
		exit(0);
	}
	//底部列表
	$table = "";
	$taskAllotFile = "";
	if ($adDuty['sharer'] == "是") {
		//被分配者清单和完成情况一览
		$table .= "
		<table class='TableMany'>
			<tr>
				<td>被分配者</td>
				<td>完成任务</td>
				<td>完成时间</td>
				<td></td>
			</tr>	
		";
		$allotArray = json_decode($task['allot'],true);
		$n = count($allotArray);
		if ($n == 0) {
			$table .= "<tr><td colspan='4'>一条信息都没有</td></tr>";	
		}
		foreach($allotArray as $adid) {
			$admin = query("admin" ,"adid = '$adid' ");	
			$adminCheck[] = $admin['adid'];
			//查询是否完成任务
			$taskAllotFileSql = mysql_query("select * from taskAllotFile where adid = '$admin[adid]' and taskId = '$id' order by time desc ");
			$taskAllotFile = mysql_fetch_assoc($taskAllotFileSql);
			$number = mysql_num_rows($taskAllotFileSql);
			if ($number > 0) {
				$status = "是";	
				$t = $taskAllotFile['time'];
				$color = "";
			} else {
				$status = "否";	
				$t = "未设置";
				$color = "style='color:#f00'";
			}			
			$table .= "
			<tr>
				<td>{$admin['adname']}</td>
				<td {$color}>{$status}</td>
				<td>{$t}</td>
				<td><a target='_blank' href='{$root}control/adTaskAllot.php?taskId={$id}&adid={$admin['adid']}'><span class='SpanButton'>详情</span></a></td>
			</tr>	
		";	
			
		}
		$table .= "</table>";
	}else{
		//模板附件列表（被分配者附件可见）
		$table = "
		<div class='kuang smallWord'>
			目前仅支持word文档，excel表格，jpg，png，gif图片格式上传
		</div>
		<table class='TableMany'>
			<tr>
				<td></td>
				<td>附件名称</td>
				<td>上传状态</td>
				<td>上传时间</td>
			</tr>	
		
		";
		//查询模板信息
		$mouldFileSql = mysql_query("select * from mouldFile where mouldId = '{$task['mouldId']}' ");
		if(mysql_num_rows($mouldFileSql) == 0) {
			$table .= "<tr><td colspan='3'>一个附件都没有</td></tr>";	
		}
		else {
			while ($array = mysql_fetch_assoc($mouldFileSql)) {
				$table .= "
				<tr>
					<td>
						<a target='_blank' href='{$root}{$array['src']}'><span class='SpanButton'>下载模版文档</span></a>
						<span class='SpanButton' mouldFileID='{$array['id']}'>上传已完成附件</span>
					</td>
					<td>{$array['fileName']}</td>
					<td>上传状态</td>
					<td>{$array['time']}</td>
				</tr>
				";	
			}
		}
		$table .= "</table>";	
	}
	//其他参数
	$title = $task['name'];
	$button = "更新";
}
//超级管理员专属的编辑框，查看信息
if ($adDuty['sharer'] == "是") {
	//选择模板
	$taskChoice = "
		 <tr>
			<td><span class='must'>*</span>&nbsp;选择模板：</td>
			<td>
			".IDSelect('mould','taskChoice','select','id','name','--模板--',$task['mouldId'])."
			<a target='_blank' href='{$root}control/adTaskMouldMx.php?id={$task['mouldId']}&taskID={$task['id']}'>
				<span class='SpanButton'>解决任务</span>
			</a>
			</td>
		</tr>
	";
	//被分配者
	$adminSql = mysql_query("select * from admin where duty in (select id from adDuty where task = '是') ");
	while($adminArray = mysql_fetch_array($adminSql)){
		$adminAll[$adminArray['adid']] = $adminArray['adname'];
	}
	
	$assign = "
		<tr>
			<td><span class='must'>*</span>&nbsp;被分配者：</td>
			<td id='checkParent'>
			<span class='SpanButton' id='checkAll'>全选</span>".checkbox("assign",$adminAll,$adminCheck)."
			</td>
		</tr>
	";
	//新增，更新按钮
	$btn = "
		<tr>
			<td><input name='adTaskId' type='hidden' value='{$task['id']}'></td>
			<td><input onclick=\"Sub('taskForm',root+'control/ku/addata.php?type=adTaskMx')\" type='button' class='button' value='{$button}'></td>
		</tr>
	";
	//任务名称
	$taskName = "<input name='taskName' type='text' class='text' value='{$task['name']}'>";
	//任务说明
	$taskText = "<textarea name='taskText' class='textarea'>{$task['text']}</textarea>";
	//任务截止时间
	$endTime = year('EndYear','select','new',$task['endTime']).moon('EndMoon','select',$task['endTime']).day('EndDay','select',$task['endTime']);
} 
else {
	//选择模板
	$taskChoice = "";
	//任务名称
	$taskName = $task['name'];
	//任务说明
	$taskText = $task['text'];
	//任务截止时间
	$endTime = $task['endTime'];
}
$onion = array(
	"任务管理" => "{$root}control/adTask.php",
    $title => $ThisUrl
);
echo head("ad").adheader($onion);
?>
<div class="column MinHeight">
	<!--基本资料开始-->
	<div class="kuang">
		<p>
			<img src="<?php echo root."img/images/text.png";?>">
			任务基本资料
		</p>
		<form name="taskForm">
		<table class="TableRight">
			<tr>
			    <td style="width:200px;">任务ID号：</td>
				<td>
					<?php echo kong($task['id']);?>
                </td>
			</tr>
            <tr>
				<td><span class="must">*</span>&nbsp;任务名称：</td>
				<td><?php echo $taskName;?></td>
			</tr>
            <tr>
			    <td><span class="must">*</span>&nbsp;任务说明：</td>
				<td><?php echo $taskText;?></td>
			</tr>
            <?php echo $taskChoice.$assign;?>
			<tr>
				<td><span class="must">*</span>&nbsp;任务截至时间：</td>
				<td><?php echo $endTime;?></td>
			</tr>
		    <tr>
			    <td>更新时间：</td>
				<td><?php echo kong($task['updateTime']);?></td>
			</tr>
		    <tr>
			    <td>创建时间：</td>
				<td><?php echo kong($task['time']);?></td>
			</tr>
			<?php echo $btn;?>
		</table>
		</form>
	</div>
	<!--基本资料结束-->
    <!--附件列表开始-->
    <?php echo $table;?>
	<!--附件列表结束-->
</div>
<!--隐藏域开始-->
<div class="hide">
	<!--被分配者附件上传-->
<form name="accessoryUploadForm" action="<?php echo root."control/ku/adpost.php?type=accessoryUploadFile";?>" method="post" enctype="multipart/form-data">
	<input name="accessoryUploadFile" type="file" onchange="document.accessoryUploadForm.submit();" />
	<input name="taskID" type="hidden" value="<?php echo $task['id'];?>" />
    <input name="mouldFileID" type="hidden" />
</form>
</div>
<!--隐藏域结束-->
<script>
$(function() {
	//把模板ID传递到查看模板按钮上，点击上传按钮上传附件
	$("[mouldFileID]").click(function(){
		var mouldFileID = $(this).attr('mouldFileID');
		document.accessoryUploadForm.mouldFileID.value = mouldFileID;
		document.accessoryUploadForm.accessoryUploadFile.click();
	});
	//全选被分配者
	var checkAll = document.getElementById("checkAll");
		if (checkAll) {
			checkAll.onclick = function() {
			var checkParent = document.getElementById("checkParent");
			var assign = checkParent.getElementsByTagName("input");
			for (var i=0;i<assign.length;i++) {
				assign[i].checked = true;
			}
		}
	}
	
})
</script>
<?php echo warn().adfooter();?>