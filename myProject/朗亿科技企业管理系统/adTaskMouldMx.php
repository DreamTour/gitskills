<?php
include "ku/adfunction.php";
ControlRoot("任务管理");
if(empty($_GET['id'])){
	$title = "新建任务";
	$button = "新增";
}
else {
	$id = $_GET['id'];
	//根据传过来的id号查询任务
    $mould = query("mould"," id = '$id' ");
	//如果未找到
	if(empty($mould['id'])){
		$_SESSION['warn'] = "未找到这个模板的信息";
		header("location:{$root}control/adTaskMould.php");
		exit(0);
	}
	$title = $mould['name'];
	$button = "更新";
	//附件列表
	if ($adDuty['sharer'] == "是") {
		$mouldUploadButton = "<td><span class='SpanButton' id='mouldUploadButton'>添加附件</span></td>";
		$count = 4;
	}
	else {
		$mouldUploadButton = "";
		$count = 3;	
	}
	$mouldFile = "
	<div class='kuang smallWord'>目前仅支持word文档，excel表格，jpg，png，gif图片格式上传</div>
	<table class='TableMany'>
    	<tr>
            <td></td>
			<td>附件名称</td>
            <td>上传时间</td>
			{$mouldUploadButton}
        </tr>	
	
	";
	$mouldFileSql = mysql_query("select * from mouldFile where mouldId = '$mould[id]' ");
	if(mysql_num_rows($mouldFileSql) == 0) {
		$mouldFile .= "<tr><td colspan='{$count}'>一个附件都没有</td></tr>";	
	}
	else {
		while ($array = mysql_fetch_assoc($mouldFileSql)) {
			//超级管理员专属的编辑框，查看信息
			if ($adDuty['sharer'] == "是") {
				$accessoryDelete = "<td><a href='{$root}control/ku/adpost.php?type=accessoryDelete&accessoryDelete={$array['id']}'><span class='SpanButton'>删除</span></a></td>
";
			}
			else {
				$accessoryDelete = "";	
			}
			//根据模板ID查询任务ID号
			$task = query("task", "mouldId = '$array[id]' ");
			$mouldFile .= "
			<tr>
				<td>
					<a target='_blank' href='{$root}{$array['src']}'><span class='SpanButton'>下载模版文档</span></a>
					<span class='SpanButton' mouldFileID='{$array['id']}'>上传已完成附件</span>
				</td>
				<td>{$array['fileName']}</td>
				<td>{$array['time']}</td>
				{$accessoryDelete}
			</tr>
			";	
		}
	}
	$mouldFile .= "</table>";	
}
//超级管理员专属的编辑框，查看信息
if ($adDuty['sharer'] == "是") {
	$mouldName = "<input name='mouldName' type='text' class='text' value='{$mould['name']}'>";
	$btn = "
		<tr>
			<td><input name='adMouldId' type='hidden' value='{$mould['id']}'></td>
			<td><input onclick=\"Sub('MouldForm',root+'control/ku/addata.php?type=adTaskMouldMx')\" type='button' class='button' value='{$button}'></td>
		</tr>
	";
}
else {
	$mouldName = $mould['name'];
	$btn = "";
}
$onion = array(
	"任务管理" => "{$root}control/adTask.php",
	"模板管理" => "{$root}control/adTaskMould.php",
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
		<form name="MouldForm">
		<table class="TableRight">
			<tr>
			    <td style="width:200px;">模板ID号：</td>
				<td> <?php echo kong($mould['id']);?> </td>
			</tr>
            <tr>
				<td><span class="must">*</span>&nbsp;模板名称：</td>
				<td><?php echo $mouldName;?></td>
			</tr>
		    <tr>
			    <td>更新时间：</td>
				<td><?php echo kong($mould['updateTime']);?></td>
			</tr>
		    <tr>
			    <td>创建时间：</td>
				<td><?php echo kong($mould['time']);?></td>
			</tr>
			<?php echo $btn;?>
		</table>
		</form>
	</div>
	<!--基本资料结束-->
     <div class="hide" id="pro" title="进度条"></div>
	<!--附件列表开始-->
    <?php echo $mouldFile;?>
	<!--附件列表结束-->
</div>
<!--隐藏域开始-->
<div class="hide">
	<!--超级管理员模板附件上传-->
<form name="mouldUploadForm" method="post" enctype="multipart/form-data">
<input name="mouldUploadFile[]" id="mouldUploadFile" type="file" multiple />
<input name="mouldUploadMouldId" type="hidden" value="<?php echo $_GET['id'];?>">
</form>
	<!--被分配者附件上传-->
<form name="accessoryUploadForm" action="<?php echo root."control/ku/adpost.php?type=accessoryUploadFile";?>" method="post" enctype="multipart/form-data">
	<input name="accessoryUploadFile" type="file" onchange="document.accessoryUploadForm.submit();" />
	<input name="taskID" type="hidden" value="<?php echo $_GET['taskID'];?>" />
    <input name="mouldFileID" type="hidden" />
</form>
</div>
<!--隐藏域结束-->
<script src="<?php echo root."library/jquery.form.js";?>" language="javascript"></script>
<script>
$(function() {
	//异步批量上传附件
	document.mouldUploadForm.onchange = function(){
		$("#pro").show();
		$("[name=mouldUploadForm]").ajaxSubmit({
			url:"<?php echo root."control/ku/addata.php?type=mouldUploadFile";?>",
			dataType:"json",
			uploadProgress: function(event, position, total, percentComplete) {
				var percentVal ='<div id="process" class="process" style="width:'+percentComplete+'%">'+percentComplete+'%</div>'; + '%';
				document.getElementById('pro').innerHTML=percentVal;
			},
			success: function(data) {
				if(data.warn == 2){
				    window.location.reload();
				}else{
					warn(data.warn);
				}
			},
			error:function(){
				warn("文件大小超过服务器允许");
			}
		});
	}
	//点击上传	
	$("#mouldUploadButton").click(function(){
		$("#mouldUploadFile").click();
	});
	$("[mouldFileID]").click(function(){
		var mouldFileID = $(this).attr('mouldFileID');
		document.accessoryUploadForm.mouldFileID.value = mouldFileID;
		document.accessoryUploadForm.accessoryUploadFile.click();
	});
})
</script>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>