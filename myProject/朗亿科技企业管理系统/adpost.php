<?php
include "adfunction.php";
ControlRoot();
foreach($_POST as $key => $value){
	$post[$key] = FormSubArray($value);
}
/****************任务管理-模板管理-多条件模糊查询*****************************/
if($_GET['type'] == "adTaskMould"){
	$name = $post['MouldName'];
	$x = " where 1=1 ";
	if(!empty($name)){
	    $x .= " and name like '%$name%' ";
	}
	//返回
	$_SESSION['adMould'] = array(
	"name" => $name,"Sql" => $x);
}	
/****************任务管理-模板管理-模板附件删除*****************************/
elseif($_GET['type'] == "accessoryDelete"){
	if ($adDuty['sharer'] != "是") {
		$_SESSION['warn'] = "你没有权限删除模板附件";	
	}
	else {
		$id = $_GET['accessoryDelete'];
		$mouldFile = query("mouldFile"," id = '$id' ");
		FileDelete(ServerRoot.$mouldFile['src']);
		mysql_query("delete from mouldFile where id = '$id'");
		$_SESSION['warn'] = "模板附件删除成功";
	}
}
/****************任务管理-模板管理-多条件模糊查询*****************************/
elseif($_GET['type'] == "adTask"){
	$name = $post['taskName'];
	if(!empty($name)){
	    $x .= " and name like '%$name%' ";
	}
	//返回
	$_SESSION['adTask'] = array(
	"name" => $name,"Sql" => $x);
}
/****************任务管理-模板管理-任务分配删除*****************************/
elseif($_GET['type'] == "taskAllotDelete"){
	if ($adDuty['sharer'] != "是") {
		$_SESSION['warn'] = "你没有权限删除任务";	
	}
	else {
		$id = $_GET['taskAllotDelete'];
		mysql_query("delete from taskAllot where id = '$id'");
		$_SESSION['warn'] = "模板附件删除成功";
	}
}
/****************任务管理-被分配者上传文件*****************************/
elseif ($_GET['type'] == "accessoryUploadFile") {
	//赋值
	$adid = $Control['adid'];//被分配者
	$taskId = $post['taskID'];//任务ID
	$mouldFileId = $post['mouldFileID'];//管理员上传的附件的ID号
	$fileName = "accessoryUploadFile";//附件上传域名称
	$tmp_name = $_FILES[$fileName]['tmp_name'];//临时文件名数组
	$task = query("task", " id = '$taskId' ");	//任务表
	$endTime = $task['endTime'];	//任务截止时间
	//判断并执行
	if (empty($adid)) {
		$_SESSION['warn'] = "未找到未分配者";
	} 
	elseif (empty($taskId)) {
		$_SESSION['warn'] = "未找到本任务";
	} 
	elseif (empty($mouldFileId)) {
		$_SESSION['warn'] = "未找到本模板";	
	}
	elseif ($endTime < $time ) {
		$_SESSION['warn'] = "任务已经截止了";
	}
	else {
		$type = $_FILES[$fileName]['type'];//附件类型数组
		if(
			$type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" or //xlsx后缀
			$type == "application/vnd.ms-excel" or//xls后缀
			$type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" or//docx后缀
			$type == "application/octet-stream" or//docx,xlsx后缀
			$type == "application/msword" or//doc后缀
			$type == "image/jpeg" or//jpg后缀
			$type == "image/png" or//png后缀
			$type == "image/gif" //gif后缀
		) {
			$id = suiji();
			$url = "img/taskAllotFile/".date("Ym");
			$name = $_FILES[$fileName]['name'];//附件名称数组
			if(!file_exists(ServerRoot.$url)){
				mkdir(ServerRoot.$url);
			}
			//附件后缀
			$suffix = explode('.',$name);
			$src = $url."/".$id.".".$suffix[1];
			$bool = mysql_query("insert into taskAllotFile (id, adid, taskId, mouldFileId, src, updateTime, time) 
			values ('$id', '$adid', '$taskId', '$mouldFileId', '$src', '$time', '$time')");
			if ($bool) {
				move_uploaded_file($tmp_name,ServerRoot.$src);
				$_SESSION['warn'] = "附件上传成功";
				$json['warn'] = 2;	
			}
			else {
				$_SESSION['warn'] = "附件上传失败";
			}	
		}
		else {
			$_SESSION['warn'] = "上传格式有误";	
		}
	}
}
/****************跳转回刚才的页面*****************************/
header("Location:".getenv("HTTP_REFERER"));
?>