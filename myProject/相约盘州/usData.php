<?php
include "../library/OpenFunction.php";
if($KehuFinger == 2){
    $json['warn'] = "您未登录";
/*-----------------编辑用户基本资料---------------------------------------------------------------------------------------------*/
}elseif(isset($_POST['userNickName']) and isset($_POST['userTel']) and isset($_POST['userWxNum'])){
	//赋值
	$usNickName = $_POST['userNickName'];//昵称
	$usSex = $_POST['userSex'];//性别
	$usBirthday = $_POST['year']."-".$_POST['moon']."-".$_POST['day'];//生日
	$usConstellation = $_POST['userConstellation'];//星座
	$usZodiac = $_POST['userZodiac'];//属相
	$usHeight = $_POST['userHeight'];//身高
	$usDegree = $_POST['userDegree'];//学历
	$usMarry = $_POST['userMarry'];//婚姻状况
	$usChildren = $_POST['userChildren'];//子女情况
	$usRegionId = $_POST['area'];//所在区县ID号
	$usSalary = $_POST['userSalary'];//月收入
	$usBuyHouse = $_POST['userBuyHouse'];//购房情况
	$usBuyCar = $_POST['userBuyCar'];//购车情况
	$usOccupation = $_POST['userOccupation'];//职业
	$usTel = $_POST['userTel'];//手机号码
	$usWxNum = $_POST['userWxNum'];//微信号
	$usQQ = $_POST['userQQ'];//QQ号
	//判断
	if(empty($usNickName)){
	    $json['warn'] = "昵称不能为空";
	}elseif(mb_strlen($usNickName,"GB2312") < 4 or mb_strlen($usNickName,"GB2312") > 12){  
	    $json['warn'] = mb_strlen($usNickName,"GB2312")."昵称不能小于4个字符且不能大于12个字符";
	}elseif(empty($usSex)){
	    $json['warn'] = "请选择您的性别";
	}elseif(empty($usTel)){
		$json['warn'] = "请输入手机号码";
    }elseif(preg_match($CheckTel,$usTel) == 0){
		$json['warn'] = "手机号码格式有误";
	}else{
		$bool = mysql_query(" update kehu set 
		NickName = '$usNickName',
		sex = '$usSex',
		khtel = '$usTel',
		khqq = '$usQQ',
		RegionId = '$usRegionId',
		children = '$usChildren',
		Zodiac = '$usZodiac',
		marry = '$usMarry',
		height = '$usHeight',
		degree = '$usDegree',
		constellation = '$usConstellation',
		salary = '$usSalary',
		Birthday = '$usBirthday',
		BuyHouse = '$usBuyHouse',
		BuyCar = '$usBuyCar',
		Occupation = '$usOccupation',
		wxNum = '$usWxNum',	
		UpdateTime = '$time' where khid = '$kehu[khid]' ");
		if($bool){
		    $_SESSION['warn'] = "基本资料更新成功";
			$json['warn'] = 2;
		}else{
			$json['warn'] = "基本资料更新失败";
		}
	}
/*-----------------编辑用户内心独白---------------------------------------------------------------------------------------------*/
}elseif(isset($_POST['InnerMonologueSummary'])){
	//赋值
	$summary = $_POST['InnerMonologueSummary'];//年龄
	//判断
	if(empty($summary)){
	    $json['warn'] = "内心独白不能为空";
	}else{
		$bool = mysql_query(" update kehu set 
		summary = '$summary',
		UpdateTime = '$time' where khid = '$kehu[khid]' ");
		if($bool){
		    $_SESSION['warn'] = "内心独白更新成功";
			$json['warn'] = 2;
		}else{
			$json['warn'] = "内心独白更新失败";
		}
	}	
/*-----------------编辑用户择偶意向---------------------------------------------------------------------------------------------*/
}elseif(isset($_POST['spouseAge']) and isset($_POST['area']) and isset($_POST['spouseDegree'])){
	//赋值
	$spAge = $_POST['spouseAge'];//年龄
	$spHeight = $_POST['spouseHeight'];//身高
	$spDegree = $_POST['spouseDegree'];//学历
	$spNation = $_POST['spouseNation'];//民族
	$spOccupation = $_POST['spouseOccupation'];//职业
	$spMarry = $_POST['spouseMarry'];//婚姻状况
	$spRegionId = $_POST['area'];//所在区县ID号
	$spSalary = $_POST['spouseSalary'];//月收入
	$spBuyHouse = $_POST['spouseBuyHouse'];//购房情况
	$spBuyCar = $_POST['spouseBuyCar'];//购车情况
	//判断
	if(empty($spAge)){
	    $json['warn'] = "年龄不能为空";
	}elseif(empty($spRegionId)){
	    $json['warn'] = "请选择你的所在地区";
	}elseif(empty($spOccupation)){
		$json['warn'] = "请填写你的职业";
	}else{
		$bool = mysql_query(" update kehu set 
		LoveAge = '$spAge',
		LoveMarry = '$spMarry',
		LoveHeight = '$spHeight',
		LoveRegionId = '$spRegionId',
		LoveDegree = '$spDegree',
		LoveSalary = '$spSalary',
		LoveNation = '$spNation',
		LoveHouse = '$spBuyHouse',
		LoveOccupation = '$spOccupation',
		LoveCar = '$spBuyCar',
		UpdateTime = '$time' where khid = '$kehu[khid]' ");
		if($bool){
		    $_SESSION['warn'] = "择偶意向更新成功";
			$json['warn'] = 2;
		}else{
			$json['warn'] = "择偶意向更新失败";
		}
	}
/*----------------------------活动立即报名------------------------------------*/
}elseif(isset($_POST['signUp'])){
	//赋值
	$contentId = $_POST['signUp'];//内容表的ID号
	$content = query("content"," id = '$contentId' ");
	$Repeat = mysql_num_rows(mysql_query(" select * from Enroll where khid = '$kehu[khid]' and ContentId = '$contentId' "));
	//判断
	if(empty($contentId)) {
		$json['warn'] = "报名ID号不存在";
	} elseif($content['id'] != $contentId) {
		$json['warn'] = "未找到这条记录";
	}elseif($Repeat > 0){
		$json['warn'] = "这个活动您已经报名过了";
	}  else {
		$id = suiji();
		$bool = mysql_query(" insert into Enroll (id,type,khid,ContentId,time) values ('$id','$content[type]','$kehu[khid]','$contentId','$time') ");
		if($bool){
			$num = $content['EnrollNum'] + 1;
			mysql_query(" update content set EnrollNum = '$num' where id = '$contentId' ");
			$json['warn'] = "报名成功";
			$json['num'] = $num;
		}else{
		    $json['warn'] = "报名失败";
		}
	}
/*----------------------------发布盘州信息------------------------------------*/
}elseif(isset($_POST['message'])){
	//赋值
	$title = htmlentities($_POST['messageTitle'], ENT_COMPAT,"utf-8");//发布信息标题
	$text = htmlentities($_POST['message'],ENT_COMPAT,"utf-8");//发布信息内容
	$num = mysql_num_rows(mysql_query(" select * from talk where khid = '$kehu[khid]' and type = '盘州信息' and text = '$text' and Auditing = '审核中' "));
	//判断
	if(empty($title)) {
		$json['warn'] = "亲~标题不能为空哟~";
	}elseif(empty($text)){
		$json['warn'] = "亲~发布内容不能为空哟~";	
	}elseif($num > 0){
		$json['warn'] = "亲~请勿重复提交哟~";
	}  else {
		$id = suiji();
		$bool = mysql_query(" insert into talk (id,khid,type,title,text,Auditing,time) values ('$id','$kehu[khid]','盘州信息','$title','$text','审核中','$time') ");
		if($bool){
			$json['warn'] = "发布成功";
		}else{
		    $json['warn'] = "发布失败";
		}
	}
/*----------------------------发布新感悟------------------------------------*/
}elseif(isset($_POST['feeling'])){
	//赋值
	$text =  htmlentities($_POST['feeling'], ENT_COMPAT,"utf-8");//发布新感悟内容
	$num = mysql_num_rows(mysql_query(" select * from talk where khid = '$kehu[khid]' and type = '新感悟' and text = '$text' and Auditing = '审核中' "));
	//判断
	if(empty($text)) {
		$json['warn'] = "亲~发布新感悟不能为空哟~";
	}elseif(mb_strlen($text,"utf-8") > 200){  
	    $json['warn'] = "亲~发布新感悟内容不能大于200个中文字符";
	}elseif($num > 0){
		$json['warn'] = "亲~请勿重复提交哟~";
	}  else {
		$id = suiji();
		$bool = mysql_query(" insert into talk (id,khid,type,text,Auditing,time) values ('$id','$kehu[khid]','新感悟','$text','审核中','$time') ");
		if($bool){
			$json['warn'] = "发布成功";
		}else{
		    $json['warn'] = "发布失败";
		}
	}
/*----------------------------发送信件------------------------------------*/
}elseif(isset($_POST['sendLetter'])){
	//赋值
	$text = htmlentities($_POST['sendLetter'],ENT_COMPAT,"utf-8");//发送信件内容
	$TargetId = $_POST['TargetId'];//收件客户的ID号
	$t = date("Y-m-d H:i:s",(time() + 60));//当前时间加上60秒
	$num = mysql_num_rows(mysql_query(" select * from message where khid = '$kehu[khid]' and TargetId = '$TargetId' and text = '$text' and time < '$t' "));
	//判断
	if(empty($text)) {
		$json['warn'] = "亲~发布内容不能为空哟~";
	}elseif($num > 0){
		$json['warn'] = "亲~请勿重复提交哟~";
	}  else {
		$id = suiji();
		$bool = mysql_query(" insert into message (id,khid,TargetId,text,time) values ('$id','$kehu[khid]','$TargetId','$text','$time') ");
		if($bool){
			$_SESSION['warn'] = "发布成功";
			$json['warn'] = 2;
		}else{
		    $json['warn'] = "发布失败";
		}
	}
/*----------------------------打招呼------------------------------------*/
}elseif(isset($_POST['sayHiMessageId'])){
	//赋值
	$text = $kehu['NickName']."向你打招呼了~请赶快回复吧~";//打招呼的内容
	$TargetId = $_POST['sayHiMessageId'];//收件客户的ID号
	$TargetKehu = query("kehu"," khid = '$TargetId' ");
	$t = date("Y-m-d H:i:s",(time() - 60));//当前时间加上60秒
	$num = mysql_num_rows(mysql_query(" select * from message where khid = '$kehu[khid]' and TargetId = '$TargetId' and text = '$text' and time > '$t' "));
	//判断
	if($num > 0){
		$json['warn'] = "亲~你刚刚才打过招呼呢~";
	}  else {
		$id = suiji();
		$bool = mysql_query(" insert into message (id,khid,TargetId,text,time) values ('$id','$kehu[khid]','$TargetId','$text','$time') ");
		if($bool){
			$json['warn'] = "你向".$TargetKehu['NickName']."打招呼成功";
		}else{
		    $json['warn'] = "打招呼失败";
		}
	}
/*----------------------------查看信件------------------------------------*/
}elseif(isset($_POST['sendLetterId'])){
	//赋值
	$messageId = $_POST['sendLetterId'];//信件的ID号
	$message = query("message"," id = '$messageId'");//信件
	//判断
	if(empty($messageId)) {
		$json['warn'] = "信件ID号为空";
	}elseif($message['id'] != $messageId){
		$json['warn'] = "未找到这个信件";
	}else{
		$text = "";
		if(!empty($message['ReplyTarget'])){
			$LastMessage = query("message"," id = '$message[ReplyTarget]' ");
			$text .= "您：".$LastMessage['text']."\n";
		}
		$text .= "TA：".$message['text'];
		$json['receive'] = neirong($text);
		$Reply = query("message"," ReplyTarget = '$messageId' ");
		$json['text'] = $Reply['text'];
		$json['id'] = $message['id'];
		$json['warn'] = 2;
	}	
/*----------------------------回复信件------------------------------------*/
}elseif(isset($_POST['messageReplyText'])){
	//赋值
	$ReplyText = htmlentities($_POST['messageReplyText'],ENT_COMPAT,"utf-8");//回复信件内容
	$messageId = $_POST['messageId'];//信息的ID号
	$message = query("message"," id = '$messageId' ");
	//判断
	if(empty($messageId)){
	    $json['warn'] = "信息的ID号为空";
	}elseif($message['id'] != $messageId){
		$json['warn'] = "未找到此条信息";
	}elseif(empty($ReplyText)) {
		$json['warn'] = "亲~回复内容不能为空哟~";
	}else{
		$id = suiji();
		$bool = mysql_query(" insert into message (id,khid,TargetId,text,ReplyTarget,UpdateTime,time) 
		values ('$id','$kehu[khid]','$message[khid]','$ReplyText','$messageId','$time','$time') ");
		if($bool){
			$_SESSION['warn'] = "回复成功";
			$json['warn'] = 2;
		}else{
		    $json['warn'] = "回复失败";
		}
	}
/*----------------------------新感悟点赞------------------------------------*/
}elseif(isset($_POST['talkClick'])){
	//赋值
	$talkClickId = $_POST['talkClick'];//点赞的ID号
	$talk = mysql_fetch_assoc(mysql_query("select * from talk where id = '$talkClickId' "));
	$talkClickNum = mysql_num_rows(mysql_query("select * from TalkLaud where khid = '$kehu[khid]' and talkId = '$talkClickId'"));
	//判断
	if(empty($talkClickId)) {
		$json['warn'] = "点赞ID号不存在";
	} elseif($talk['id'] != $talkClickId) {
		$json['warn'] = "未找到这条新感悟";
	}elseif($talkClickNum > 0){
		$json['warn'] = "这条感悟你已经点过赞了";
	}  else {
		$id = suiji();
		$bool = mysql_query(" insert into TalkLaud (id,khid,talkId,time) values ('$id','$kehu[khid]','$talkClickId','$time') ");
		if($bool){
			$json['num'] = mysql_num_rows(mysql_query("select * from TalkLaud where talkId = '$talkClickId'"));
			$json['warn'] = "点赞成功";
		}else{
		    $json['warn'] = "点赞失败";
		}
	}
	
/*----------------------------新感悟回复------------------------------------*/
}elseif(isset($_POST['reply'])){
	//赋值
	$text =  htmlentities($_POST['reply'], ENT_COMPAT,"utf-8");//回复内容
	$talkId = $_POST['talkId'];//发表新感悟的ID号
	$num = mysql_num_rows(mysql_query(" select * from TalkReply and text = $text "));
	//判断
	if(empty($text)) {
		$json['warn'] = "亲~回复不能为空哟~";
	}elseif(mb_strlen($text,"utf-8") > 200){  
	    $json['warn'] = "亲~回复内容不能大于200个中文字符";
	}elseif($num > 0){
		$json['warn'] = "亲~请勿重复提交哟~";
	}  else {
		
		$bool = mysql_query(" insert into TalkReply (TalkId,khid,text,time) values ('$talkId','$kehu[khid]','$text','$time') ");
		if($bool){
			$json['warn'] = "回复成功";
		}else{
		    $json['warn'] = "回复失败";
		}
	}	
/*----------------------------同城搜索送礼物------------------------------------*/
}elseif(isset($_POST['feeling'])){
	//赋值
	$text = $_POST['feeling'];//发布新感悟内容
	$num = mysql_num_rows(mysql_query(" select * from talk where khid = '$kehu[khid]' and type = '新感悟' and text = '$text' and Auditing = '审核中' "));
	//判断
	if(empty($text)) {
		$json['warn'] = "亲~发布新感悟不能为空哟~";
	}elseif($num > 0){
		$json['warn'] = "亲~请勿重复提交哟~";
	}  else {
		$id = suiji();
		$bool = mysql_query(" insert into talk (id,khid,type,text,Auditing,time) values ('$id','$kehu[khid]','新感悟','$text','审核中','$time') ");
		if($bool){
			$json['warn'] = "发布成功";
		}else{
		    $json['warn'] = "发布失败";
		}
	}	
/*----------------------------同城搜索送礼物------------------------------------*/
}elseif(isset($_POST['action']) and $_POST['action'] == 'check_login' ){
	$json['warn'] = 2;
}
echo json_encode($json);
?>
