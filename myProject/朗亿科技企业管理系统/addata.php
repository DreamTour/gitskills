<?php
include "adfunction.php";
foreach($_POST as $key => $value){
	$post[$key] = FormSubArray($value);
}
if($ControlFinger == 2){
    $json['warn'] = $ControlWarn;
}
/********任务管理-模板管理-新建或更新模板**************************************/
elseif($_GET['type'] == "adTaskMouldMx"){
	$id = $post['adMouldId'];
	$name = $post['mouldName'];
	if ($adDuty['sharer'] != "是") {
		$json['warn'] = "你没有权限新建或更新模板";	
	}
	else if(empty($name)){
		$json['warn'] = "请填写模板名称";
	}elseif(empty($id)){
		$id = suiji();
		$bool = mysql_query("insert into mould (id,name,updateTime,time) values ('$id','$name','$time','$time') ");
		if($bool) {
			$_SESSION['warn'] = "模板基本资料新增成功";
			LogText("任务管理",$Control['adid'],"管理员{$Control['adname']}新增了模板（模板名称：{$name}，模板ID：{$id}）");
			$json['warn'] = 2;	
		}else{
			$json['warn'] = "模板基本资料新增失败";
		}
	}else{
		$mould = query("mould"," id = '$id' ");
		if($mould['id'] != $id){
			$json['warn'] = "本模板未找到";
		}else{
			$bool = mysql_query(" update mould set
			name = '$name',
			UpdateTime = '$time' where id = '$id' ");
			if($bool){
				$_SESSION['warn'] = "模板基本资料更新成功";
			    LogText("任务管理",$Control['adid'],"管理员{$Control['adname']}更新了模板基本信息（模板名称：{$name}，模板ID：{$id}）");
				$json['warn'] = 2;
			}else{
				$json['warn'] = "模板基本资料更新失败";
			}
		}
	}
	$json['href'] = root."control/adTaskMouldMx.php?id=".$id;
}
/********任务管理-模板管理-批量处理列表记录（需要管理员登录密码）-**************************************/
elseif(isset($post['PadWarnType'])){
    //赋值
	$type = $_POST['PadWarnType'];//执行指令
	$pas = $_POST['Password'];//密码
	$x = 0;
	//判断
	if (empty($type)) {
	    $json['warn'] = "执行指令为空";
	}
	elseif (empty($pas)) {
	    $json['warn'] = "请输入管理员登录密码";
	}
	elseif ($pas != $Control['adpas']) {
	    $json['warn'] = "管理员登录密码输入错误";		
	}
	//删除模板
	elseif ($type == "DeleteMould") {
		$Array = $_POST['MouldList'];
		if($adDuty['sharer'] != "是"){
			$json['warn'] = "你没有权限删除模板";
		}elseif(empty($Array)){
			$json['warn'] = "您一个模板都没有选择呢";
		}else{
			foreach($Array as $id){
				//查询本模板基本信息
				$mould = query("mould"," id = '$id' ");	
				//删除模板附件
				$mouldFileSql = mysql_query(" select * from mouldFile where mouldId = '$id' ");
				while($mouldFile = mysql_fetch_assoc($mouldFileSql)){
					FileDelete(ServerRoot.$mouldFile['src']);
				}
				mysql_query("delete from mouldFile where mouldId = '$id'");	
				//删除本模板
				mysql_query("delete from mould where id = '$id'");
				//添加日志
				LogText("任务管理",$Control['adid'],"管理员{$Control['adname']}删除了模板（模板名称：{$mould['name']}，模板ID：{$mould['id']}）");
				$x++;
			}
			$_SESSION['warn'] = "删除了{$x}个模板";
			$json['warn'] = 2;
		}
	} 
	//删除任务
	elseif($type == "DeleteTask") {
		$Array = $_POST['taskList'];
		if($adDuty['sharer'] != "是"){
			$json['warn'] = "你没有权限删除任务";
		}elseif(empty($Array)){
			$json['warn'] = "您一个任务都没有选择呢";
		}else{
			foreach($Array as $id){
				//查询本任务基本信息
				$task = query("task"," id = '$id' ");
				//查询本任务下面的模板
				$mould = query("mould", "id = '$task[mouldId]' ");
				//删除本任务模板下面的附件
				$taskAllotFileSql = mysql_query(" select * from taskAllotFile where taskId = '$id' ");
				while($taskAllotFile = mysql_fetch_assoc($taskAllotFileSql)){
					FileDelete(ServerRoot.$taskAllotFile['src']);
				}
				mysql_query("delete from taskAllotFile where taskId = '$id'");	
				//删除本任务
				mysql_query("delete from task where id = '$id'");
				//添加日志
				LogText("任务管理",$Control['adid'],"管理员{$Control['adname']}删除了任务（任务名称：{$task['name']}，任务ID：{$task['id']}）");
				$x++;
			}
			$_SESSION['warn'] = "删除了{$x}个任务";
			$json['warn'] = 2;
		}			
	}else{
	    $json['warn'] = "未知执行指令";
	}
}
/********任务管理-模板管理-模板上传附件**************************************/
elseif($_GET['type'] == "mouldUploadFile"){
	//赋值
	$mouldId = $_POST['mouldUploadMouldId'];//图片ID号
	$mould = query("mould"," id = '$mouldId' ");
	$fileName = "mouldUploadFile";//附件集合
	//判断
	if ($adDuty['sharer'] != "是") {
		$json['warn'] = "你没有权限上传附件";	
	}else if(empty($mouldId)){
		$json['warn'] = "模板ID号为空";
	}else if($mould['id'] != $mouldId){
		$json['warn'] = "未找到此模板";	
	}else{
		$tmp_name = $_FILES[$fileName]['tmp_name'];//临时文件名数组
		$name = $_FILES[$fileName]['name'];//附件名称数组
		$type = $_FILES[$fileName]['type'];//附件类型数组
		$n = count($name);
		$x = 0;
		$maxNum = 10;//最大附件数
		if($n > $maxNum){
			$json['warn'] = "模板最多只能上传{$maxNum}个附件";
		}else{
			//如果对应文件夹不存在，则创建文件夹
			$url = "img/mouldFile/".date("Ym");
			if(!file_exists(ServerRoot.$url)){
				mkdir(ServerRoot.$url);
			}
			//循环处理附件
			$x = 0;
			$y = 0;
			for($i=0;$i<$n;$i++){
				if(
					$type[$i] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" or //xlsx后缀
					$type[$i] == "application/vnd.ms-excel" or//xls后缀
					$type[$i] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" or//docx后缀
					$type[$i] == "application/octet-stream" or//docx,xlsx后缀
					$type[$i] == "application/msword" or//doc后缀
					$type[$i] == "image/jpeg" or//jpg后缀
					$type[$i] == "image/png" or//png后缀
					$type[$i] == "image/gif" //gif后缀
				){
					$x++;
					$id = suiji();
					//附件后缀
					$suffix = explode('.',$name[$i]);
					$src = $url."/".$id.".".$suffix[1];
					mysql_query("insert into mouldFile (id,mouldId,fileName,src,time) 
					values ('$id','$mouldId','".$name[$i]."','$src','$time') ");
					LogText("任务管理",$Control['adid'],"{$Control['adname']}上传了附件，名称：".$name[$i]."，类型：".$type[$i]."，状态：上传成功");
				}else{
					LogText("任务管理",$Control['adid'],"{$Control['adname']}上传了附件，名称：".$name[$i]."，类型：".$type[$i]."，状态：上传失败");
					$y++;
				}
				move_uploaded_file($tmp_name[$i],ServerRoot.$src);
			}
			$_SESSION['warn'] = "成功上传".$x."个附件，失败".$y."个附件，<a class=\"BtnColor\" target=\"_blank\" href=\"{$root}control/info/adlog.php\">查看日志</a>";
			$json['warn'] = 2;
		}	
	}
}
/********任务管理-新建或更新任务**************************************/
elseif($_GET['type'] == "adTaskMx"){
	$id = $post['adTaskId'];//任务ID
	$name = $post['taskName'];//任务名称
	$text = $post['taskText'];//任务说明
	$mouldId = $post['taskChoice'];//选择模板ID
	$assign = $post['assign'];//所有被分配者
	$assignJson = json_encode($assign);//重新转为json数据
	$endYear = $post['EndYear'];//任务截止时间年份
	$endMoon = $post['EndMoon'];//任务截止时间月份
	$endDay = $post['EndDay'];//任务截止时间日期
	$endTime = $endYear.$endMoon.$endDay;//任务截止时间
	if ($adDuty['sharer'] != "是") {
		$json['warn'] = "你没有权限新建或更新任务";	
	}
	else if (empty($name)) {
		$json['warn'] = "请填写任务名称";
	}
	elseif (empty($text)) {
		$json['warn'] = "请填写任务说明";	
	}
	elseif (empty($mouldId)) {
		$json['warn'] = "请填写模板";	
	}
	elseif (empty($endYear)) {
		$json['warn'] = "请选择任务截至时间年份";
	}
	elseif (empty($endMoon)) {
		$json['warn'] = "请选择任务截至时间月份";
	}
	elseif (empty($endDay)) {
		$json['warn'] = "请选择任务截至时间日期";
	}
	elseif (empty($id)) {
		$id = suiji();
		$bool = mysql_query("insert into task (id,name,text,mouldId,allot,endTime,updateTime,time)
		values ('$id','$name','$text','$mouldId','$assignJson','$endTime','$time','$time') ");
		if($bool) {
			$_SESSION['warn'] = "任务基本资料新增成功";
			LogText("任务管理",$Control['adid'],"管理员{$Control['adname']}新增了任务（任务名称：{$name}，任务ID：{$id}）");
			$json['warn'] = 2;	
		}else{
			$json['warn'] = "任务基本资料新增失败";
		}
	}
	else {
		$task = query("task"," id = '$id' ");
		if($task['id'] != $id){
			$json['warn'] = "本任务未找到";
		}else{
			$bool = mysql_query(" update task set
			name = '$name',
			text = '$text',
			mouldId = '$mouldId',
			allot = '$assignJson',
			endTime = '$endTime',
			UpdateTime = '$time' where id = '$id' ");
			if($bool){
				$_SESSION['warn'] = "任务基本资料更新成功";
			    LogText("任务管理",$Control['adid'],"管理员{$Control['adname']}更新了任务基本信息（任务名称：{$name}，任务ID：{$id}）");
				$json['warn'] = 2;
			}else{
				$json['warn'] = "任务基本资料更新失败";
			}
		}
	}
	$json['href'] = root."control/adTaskMx.php?id=".$id;
}
/********任务管理-分配任务**************************************/
elseif($_GET['type'] == "allotShadeForm"){
	$taskIdArray = $post['taskList']; //任务的ID号数组
	$adid = $post['taskAllot'];//分配给谁的ID号
	$admin = query("admin", "adid = '$adid' ");//被分配者的基本信息
	$pas = $post['taskPassword'];//管理员登录密码
	$direction = $post['direction'];//执行方向
	if ($adDuty['sharer'] != "是") {
		$json['warn'] = "你没有权限分配任务";	
	}
	else if (empty($taskIdArray)) {
		$json['warn'] = "一条任务都没有选择";	
	}
	else if (empty($adid)) {
		$json['warn'] = "请选择分配给谁";	
	}
	else if ($adid != $admin['adid']) {
		$json['warn'] = "未找到被分配者";	
	}
	else if (empty($pas)) {
		$json['warn'] = "请输入登录密码";	
	}
	else if ($pas != $Control['adpas']) {
		$json['warn'] = "登录密码错误";
	}
	else if ($direction == "批量分配") {
		$x = 0;
		foreach ($taskIdArray as $id) {
			$task = query("task", "id = '$id' ");
			$allot = json_decode($task['allot'],true);//将所有拥有此任务的ID号的json数据改为数组
			if (!is_array($allot)) {
				$allot = array();
			}
			if (!in_array($adid,$allot)) {//如果被分配者之前没有此任务
				array_push($allot,$adid);//那么将被分配者添加次任务
				$allotJson = json_encode($allot);//重新转为json数据
				mysql_query("update task set 
				allot = '$allotJson',
				updateTime = '$time' where id = '$id' ");
				LogText("任务管理",$Control['adid'],"管理员{$Control['adname']}分配了任务（任务名称：{$task['name']}，任务ID：{$task['id']}），被分配者：{$admin['adname']}");
				$x++;
			}
		}
		$_SESSION['warn'] = "分配了".$x."个任务";
		$json['warn'] = 2;	
	}
	else if ($direction == "撤销分配") {
		$x = 0;
		foreach ($taskIdArray as $id) {
			$task = query("task", "id = '$id' ");
			$allot = json_decode($task['allot'],true);//将所有拥有此任务的ID号的json数据改为数组
			if (in_array($adid,$allot)) {//如果被分配者之前有此任务
				//删除这个被分配者
				foreach ($allot as $k => $v) {
					if ($v == $adid) {
						unset($allot[$k]);
					}	
				}
				$allotJson = json_encode($allot);//重新转为json数据
				mysql_query("update task set 
				allot = '$allotJson',
				updateTime = '$time' where id = '$id' ");
				LogText("任务管理",$Control['adid'],"管理员{$Control['adname']}撤销了任务（任务名称：{$task['name']}，任务ID：{$task['id']}），被撤销者：{$admin['adname']}");
				$x++;
			}
		}
		$_SESSION['warn'] = "撤销了".$x."个任务";
		$json['warn'] = 2;	
	}
	else {
		$json['warn'] = "未知执行指令";	
	}
}
/********返回**************************************/
echo json_encode($json);
?>
