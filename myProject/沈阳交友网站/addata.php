<?php
include "adfunction.php";
if($ControlFinger == 2){
    $json['warn'] = $ControlWarn;
/*-----------------礼物管理-新建或更新礼物基本资料-------------------------------------------------------------*/
}elseif(isset($_POST['adGiftId']) and isset($_POST['giftName']) and isset($_POST['giftPrice'])){
    //赋值
	$id = $_POST['adGiftId'];//礼物ID
	$name = FormSub($_POST['giftName']);//礼物名称
	$price = $_POST['giftPrice'];//礼物单价
	//判断
	if(strstr($adDuty['Power'],"礼物管理") == false){
		$json['warn'] = "权限不足";
	}elseif(empty($name)){
		$json['warn'] = "请填写礼物名称";
	}elseif(empty($price)){
		$json['warn'] = "请填写礼物单价";
	}elseif(preg_match($CheckPrice,$price) == 0){
		$json['warn'] = "请填写正确的单价";
	}elseif(empty($id)){
	    $id = suiji();
		$bool = mysql_query(" insert into Gift 
		(id,name,price,UpdateTime,time) 
		values 
		('$id','$name','$price','$time','$time') ");
		if($bool){
		    $_SESSION['warn'] = "礼物基本资料新增成功";
			LogText("礼物管理",$Control['adid'],"管理员{$Control['adname']}新增了礼物（礼物名称：{$name}，礼物ID：{$id}）");
			$json['warn'] = 2;
		}else{
			$json['warn'] = "礼物基本资料新增失败";
		}
	}else{
	    $Gift = query("Gift"," id = '$id' ");
		if($Gift['id'] != $id){
			$json['warn'] = "本礼物未找到";
		}else{
			$bool = mysql_query(" update Gift set 
			name = '$name',
			price = '$price',
			UpdateTime = '$time' where id = '$id' ");
			if($bool){
				$_SESSION['warn'] = "礼物基本资料更新成功";
			    LogText("礼物管理",$Control['adid'],"管理员{$Control['adname']}更新了礼物基本信息（礼物名称：{$name}，礼物ID：{$id}）");
				$json['warn'] = 2;
			}else{
				$json['warn'] = "礼物基本资料更新失败";
			}
		}
	}
	$json['href'] = root."control/adGiftMx.php?id=".$id;
/*-----------------客户管理-更新消息基本资料（资料审核）-------------------------------------------------------------*/
}elseif(isset($_POST['adClientId']) and isset($_POST['ClientAuditing'])){
    //赋值
	$id = $_POST['adClientId'];//客户ID
	$Auditing = $_POST['ClientAuditing'];//审核状态
	//判断
	if(strstr($adDuty['Power'],"消息管理") == false){
		$json['warn'] = "权限不足";
	}elseif(empty($Auditing)){
		$json['warn'] = "请选择审核状态";
	}else{
	    $kehu = query("kehu"," khid = '$id' ");
		if($kehu['khid'] != $id){
			$json['warn'] = "本客户未找到";
		}else{
			$bool = mysql_query(" update kehu set 
			Auditing = '$Auditing',
			UpdateTime = '$time' where khid = '$id' ");
			if($bool){
				$_SESSION['warn'] = "消息基本资料更新成功";
			    LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}更新了客户基本信息（消息ID：{$id}）");
				$json['warn'] = 2;
			}else{
				$json['warn'] = "消息基本资料更新失败";
			}
		}
	}		
/*-----------------客户管理-更新客户基本资料----------------------------------------------------
}elseif(isset($_POST['adGiftId']) and isset($_POST['giftName']) and isset($_POST['giftPrice'])){
    //赋值
	$id = $_POST['adClientId'];//客户ID
	$NickName = $_POST['NickName'];//客户昵称
	$khtel = $_POST['khtel'];//客户电话
	$khqq = $_POST['khqq'];//客户QQ
	$Grade = $_POST['Grade'];//会员等级
	$summary = $_POST['summary'];//自我介绍
	$RegionId = $_POST['RegionId'];//所在地区
	$children = $_POST['children'];//子女情况
	$Zodiac = $_POST['Zodiac'];//属相
	$marry = $_POST['marry'];//婚姻状况
	$height = $_POST['height'];//身高
	$degree = $_POST['degree'];//学历
	$Hometown = $_POST['Hometown'];//家乡
	$constellation = $_POST['constellation'];//星座
	$salary = $_POST['salary'];//月薪
	$Birthday = $_POST['Birthday'];//生日
	$BuyHouse = $_POST['BuyHouse'];//购房情况
	$BuyCar = $_POST['BuyCar'];//购车情况
	$Occupation = $_POST['Occupation'];//职业
	$wxNum = $_POST['wxNum'];//微信号
	//判断
	if(strstr($adDuty['Power'],"客户管理") == false){
		$json['warn'] = "权限不足";
	}elseif(empty($id)){
	    $id = suiji();
		$bool = mysql_query(" insert into Gift 
		(id,NickName,khtel,khqq,Grade,summary,RegionId,children,Zodiac,marry,height,degree,Hometown,constellation,salary,Birthday,BuyHouse,BuyCar,Occupation,wxNum,UpdateTime,time) 
		values 
		('$id','$NickName','$khtel','$khqq','$Grade','$summary','$RegionId','$children','$Zodiac','$marry','$height','$degree','$Hometown','$constellation','$salary','$Birthday','$BuyHouse','$BuyCar','$Occupation','$wxNum','$time','$time') ");
	}else{
	    $kehu = query("kehu"," id = '$id' ");
		if($kehu['id'] != $id){
			$json['warn'] = "本客户未找到";
		}else{
			$bool = mysql_query(" update Gift set 
			NickName = '$NickName',
			khtel = '$khtel',
			khqq = '$khqq',
			Grade = '$Grade',
			summary = '$summary',
			RegionId = '$RegionId',
			children = '$children',
			Zodiac = '$Zodiac',
			marry = '$marry',
			height = '$height',
			degree = '$degree',
			Hometown = '$Hometown',
			constellation = '$constellation',
			salary = '$salary',
			Birthday = '$Birthday',
			BuyHouse = '$BuyHouse',
			BuyCar = '$BuyCar',
			Occupation = '$Occupation',
			wxNum = '$wxNum',
			UpdateTime = '$time' where id = '$id' ");
			if($bool){
				$_SESSION['warn'] = "客户基本资料更新成功";
			    LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}更新了客户基本信息（客户名称：{$NickName}，客户ID：{$id}）");
				$json['warn'] = 2;
			}else{
				$json['warn'] = "客户基本资料更新失败";
			}
		}
	}---------*/
/*-----------------批量处理列表记录（需要管理员登录密码）客户，消息，礼物管理--------------------------------*/
}elseif(isset($_POST['EditPas']) and isset($_POST['EditListType'])){
    //赋值
	$type = $_POST['EditListType'];//执行指令
	$pas = $_POST['EditPas'];//密码
	$x = 0;
	//判断
	if(empty($type)){
	    $json['warn'] = "执行指令为空";
	}elseif(empty($pas)){
	    $json['warn'] = "请输入管理员登录密码";
	}elseif($pas != $Control['adpas']){
	    $json['warn'] = "管理员登录密码输入错误";
	}elseif($type == "ClientDelete"){
		$Array = $_POST['ClientList'];
		if($adDuty['name'] != "超级管理员"){
			$json['warn'] = "只有超级管理员才能删除客户";
		}elseif(empty($Array)){
			$json['warn'] = "您一个客户都没有选择呢";
		}else{
			foreach($Array as $id){
				//查询本客户基本信息
				$kehu = query("kehu"," khid = '$id' ");
				//删除客户活动报名
				mysql_query("delete from Enroll where khid = '$id'");
				//删除客户谁看过我或者谁关注我
				mysql_query("delete from follow where khid = '$id'");
				//删除客户送礼物
				mysql_query("delete from GiftGive where khid = '$id'");
				//删除客户我的相册
				$kehuImgSql = mysql_query(" select * from kehuImg where khid = '$id' ");
				while($kehuImg = mysql_fetch_assoc($kehuImgSql)){
					unlink(ServerRoot.$kehuImg['src']);
				}
				mysql_query("delete from kehuImg where khid = '$id'");
				//删除客户私信
				mysql_query("delete from message where khid = '$id'");
				//删除客户预支付记录
				mysql_query("delete from pay where khid = '$id'");
				//删除客户头像
				unlink(ServerRoot.$kehu['ico']);
				//最后删除本客户基本资料
				mysql_query("delete from kehu where khid = '$id'");
				//添加日志
				LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}删除了客户（客户微信名：{$kehu['NickName']}，客户ID：{$kehu['khid']}）");
				$x++;
			}
			$_SESSION['warn'] = "删除了{$x}个客户";
			$json['warn'] = 2;
		}
	}elseif($type == "DeleteMessage"){
		$Array = $_POST['messageList'];
		if($adDuty['name'] != "超级管理员"){
			$json['warn'] = "只有超级管理员才能删除消息";
		}elseif(empty($Array)){
			$json['warn'] = "您一条消息都没有选择呢";
		}else{
			foreach($Array as $id){
				//查询本条消息基本信息
				$talk = query("talk"," id = '$id' ");
				//删除本信息的新感悟点赞
				mysql_query("delete from TalkLaud where TalkId = '$id'");
				//删除本信息的新感悟回复
				mysql_query("delete from TalkReply where TalkId = '$id'");
				//删除本消息
				mysql_query("delete from talk where id = '$id'");
				//添加日志
				LogText("消息管理",$Control['adid'],"管理员{$Control['adname']}删除了消息（消息类型：{$talk['type']}，消息ID：{$talk['id']}）");
				$x++;
			}
			$_SESSION['warn'] = "删除了{$x}个消息";
			$json['warn'] = 2;
		}
	}elseif($type == "DeleteGift"){
		$Array = $_POST['GiftList'];
		if($adDuty['name'] != "超级管理员"){
			$json['warn'] = "只有超级管理员才能删除礼物";
		}elseif(empty($Array)){
			$json['warn'] = "您一个礼物都没有选择呢";
		}else{
			foreach($Array as $id){
				//查询本礼物基本信息
				$Gift = query("Gift"," id = '$id' ");
				//删除本礼物的赠送记录
				mysql_query("delete from GiftGive where GiftId = '$id'");
				//删除礼物图像
				unlink(ServerRoot.$Gift['ico']);
				//删除本礼物
				mysql_query("delete from Gift where id = '$id'");
				//添加日志
				LogText("礼物管理",$Control['adid'],"管理员{$Control['adname']}删除了礼物（礼物名称：{$Gift['name']}，礼物ID：{$Gift['id']}）");
				$x++;
			}
			$_SESSION['warn'] = "删除了{$x}个礼物";
			$json['warn'] = 2;
		}
	//删除活动报名	
	}elseif($type == "EnrollDelete"){
		$Array = $_POST['EnrollList'];
		if($adDuty['name'] != "超级管理员"){
			$json['warn'] = "只有超级管理员才能删除活动报名";
		}elseif(empty($Array)){
			$json['warn'] = "您一个活动报名都没有选择呢";
		}else{
			foreach($Array as $id){
				//查询活动报名基本信息
				$Enroll = query("Enroll"," id = '$id' ");
				//删除本活动报名
				mysql_query("delete from Enroll where id = '$id'");
				//添加日志
				LogText("活动报名",$Control['adid'],"管理员{$Control['adname']}删除了活动报名（活动报名类型：{$Enroll['type']}，活动报名ID：{$Enroll['id']}）");
				$x++;
			}
			$_SESSION['warn'] = "删除了{$x}个活动报名";
			$json['warn'] = 2;
		}	
	}else{
	    $json['warn'] = "未知执行指令";
	}
/*-----------------消息管理-更新消息基本资料-------------------------------------------------------------*/
}elseif(isset($_POST['adMessageId']) and isset($_POST['messageAuditing'])){
    //赋值
	$id = $_POST['adMessageId'];//消息ID
	$Auditing = $_POST['messageAuditing'];//审核状态
	//判断
	if(strstr($adDuty['Power'],"消息管理") == false){
		$json['warn'] = "权限不足";
	}elseif(empty($Auditing)){
		$json['warn'] = "请选择审核状态";
	}else{
	    $talk = query("talk"," id = '$id' ");
		if($talk['id'] != $id){
			$json['warn'] = "本消息未找到";
		}else{
			$bool = mysql_query(" update talk set 
			Auditing = '$Auditing',
			UpdateTime = '$time' where id = '$id' ");
			if($bool){
				$_SESSION['warn'] = "消息基本资料更新成功";
			    LogText("消息管理",$Control['adid'],"管理员{$Control['adname']}更新了消息基本信息（消息ID：{$id}）");
				$json['warn'] = 2;
			}else{
				$json['warn'] = "消息基本资料更新失败";
			}
		}
	}
}
/*-----------------返回-------------------------------------------------------------*/
echo json_encode($json);
?>
