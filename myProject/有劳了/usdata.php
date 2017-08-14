<?php
include "OpenFunction.php";
if($KehuFinger == 2){
    $json['warn'] = "您未登录";
/*----------------------------收藏优职/取消收藏------------------------------------*/
}else if(isset($_POST['collectiondemandId'])){	
	$demandId = $_POST['collectiondemandId'];//需求表的id号/优职的ID号
	$demandType = $_POST['demandType'];//收藏的类型
	$demand = mysql_fetch_array(mysql_query("select * from demand where id = '$demandId' "));//优职需求表
	$collect = mysql_fetch_assoc(mysql_query("select * from collect where khid = '$kehu[khid]' and TargetId = '$demandId' "));//优职收藏
	//判断
	if(empty($demandId)){
		$json['warn'] = "优职ID号为空";	
	}else if($demand['id'] != $demandId){
		$json['warn'] = "没找到这个优职的记录";	
	}else if(!empty($collect['id'])){
		if(mysql_query("delete from collect where id = '$collect[id]' ")){
			$json['warn'] = "取消成功";
		}else{
			$json['warn'] = "取消失败";
		}
	}else{
		$id = suiji();
		$bool = mysql_query("insert into collect (id,khid,Target,TargetId,time) values ('$id','$kehu[khid]','$demandType','$demandId','$time') ");
		if($bool){
			$json['warn'] = '收藏成功';
		}else{
			$json['warn'] = '收藏失败';	
		}	
	}
/*----------------------------收藏优才/取消收藏------------------------------------*/
}else if(isset($_POST['collectionsupplyId'])){	
	$supplyId = $_POST['collectionsupplyId'];//需求表的id号/优职的ID号
	$demandType = $_POST['demandType'];//收藏的类型
	$demand = mysql_fetch_array(mysql_query("select * from supply where id = '$supplyId' "));//优职需求表
	$collect = mysql_fetch_assoc(mysql_query("select * from collect where khid = '$kehu[khid]' and TargetId = '$supplyId' "));//优职收藏
	//判断
	if(empty($supplyId)){
		$json['warn'] = "优职ID号为空";	
	}else if($demand['id'] != $supplyId){
		$json['warn'] = "没找到这个优职的记录";	
	}else if(!empty($collect['id'])){
		if(mysql_query("delete from collect where id = '$collect[id]' ")){
			$json['warn'] = "取消成功";
		}else{
			$json['warn'] = "取消失败";
		}
	}else{
		$id = suiji();
		$bool = mysql_query("insert into collect (id,khid,Target,TargetId,time) values ('$id','$kehu[khid]','$demandType','$supplyId','$time') ");
		if($bool){
			$json['warn'] = '收藏成功';
		}else{
			$json['warn'] = '收藏失败';	
		}	
	}	
/*----------------------------个人中心基本资料更新------------------------------------*/		
}else if(isset($_POST['userContactName']) and isset($_POST['year'])){
	//赋值 
	$ContactName = htmlentities($_POST['userContactName'],ENT_QUOTES,'utf-8');//联系人姓名/全名
	$sex = $_POST['userSex'];//性别
	$IDCard = $_POST['userIDCard'];//身份证号
	$Birthday = $_POST['year']."-".$_POST['moon']."-".$_POST['day'];//出生年月
	$EducationLevel = htmlentities($_POST['userEducationLevel'],ENT_QUOTES,'utf-8');//教育程度
	$EducationLevelOpen = $_POST['userEducationLevelOpen'];//是否公开教育程度
	$RegionId = $_POST['area'];//所在区县ID号
	$email = $_POST['userEmail'];//邮箱
	$ContactTel = $_POST['userContactTel'];//手机号码
	$reg_chinese = "/^[\x{4e00}-\x{9fa5}]+$/u";
	//判断
	if(empty($ContactName)){
		$json['warn'] = "全名不能为空";
	}else if(preg_match($reg_chinese,$ContactName) == 0){
		$json['warn'] = "全名请填写汉字";
	}else if(mb_strlen($ContactName,"GB2312") < 4 or mb_strlen($ContactName,"GB2312") > 12){
		$json['warn'] = "全名不能小于4个字符且不能大于12个字符";	
	}else if(empty($sex)){
		$json['warn'] = "性别不能为空";
	}else if(empty($Birthday)){
		$json['warn'] = "出生年月不能为空";
	}else if((preg_match($reg_chinese,$EducationLevel) == 0) and !empty($EducationLevel)){
		$json['warn'] = "教育程度请填写汉字";
	}else if(empty($RegionId)){
		$json['warn'] = "常驻地点不能为空";
	}else if(empty($email)){
		$json['warn'] = "邮箱不能为空";
	}else if(preg_match($CheckEmail,$email) == 0){
		$json['warn'] = "邮箱格式不正确";
	}else if(empty($ContactTel)){
		$json['warn'] = "请输入手机号码";	
	}else if(preg_match($CheckTel,$ContactTel) == 0){
		$json['warn'] = "手机号码格式有误";	
	}else if(!empty($IDCard) and preg_match("/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}(\d|x|X)$/",$IDCard) == 0){
		$json['warn'] = "您的身份证号格式不正确";
	}else{
		$bool1 = mysql_query("update kehu set
		ContactName = '$ContactName',
		IDCard = '$IDCard',
		RegionId = '$RegionId',
		email = '$email',
		ContactTel = '$ContactTel',
		UpdateTime = '$time' where khid = '$kehu[khid]' ");
		if($bool1){
			$bool2 = mysql_query("update personal set
			sex = '$sex',
			Birthday = '$Birthday',
			EducationLevel = '$EducationLevel',
			EducationLevelOpen = '$EducationLevelOpen',
			UpdateTime = '$time' where khid = '$kehu[khid]' ");
			if($bool2){
				$_SESSION['warn'] = "基本资料更新成功";	
				$json['warn'] = 2;
			}else{
				$json['warn'] = "基本资料更新失败~~";	
			}
		}else{
			$json['warn'] = "基本资料更新失败~";	
		}
	}
/*----------------------------企业/工商用户中心基本资料更新------------------------------------*/		
}else if(isset($_POST['sellerContactName']) and isset($_POST['sellerCompanyName'])){
	//赋值 
	$ContactName = htmlentities($_POST['sellerContactName'],ENT_QUOTES,'utf-8');//联系人姓名/全名
	$ContactNameOpen = $_POST['sellerContactNameOpen'];//是否公开联系人姓名
	$CompanyName = htmlentities($_POST['sellerCompanyName'],ENT_QUOTES,'utf-8');//单位全称
	$LegalName = htmlentities($_POST['sellerLegalName'],ENT_QUOTES,'utf-8');//法人/负责人全名
	$RegionId = $_POST['area'];//单位地址所在区县ID号
	$IDCard = $_POST['sellerIDCard'];//法人/负责人身份证号
	$BusinessLicense = $_POST['sellerBusinessLicense'];//营业执照/社会统一信用代码
	$email = $_POST['sellerEmail'];//邮箱
	$emailOpen = $_POST['sellerEmailOpen'];//是否公开邮箱
	$ContactTel = $_POST['sellerContactTel'];//联系手机
	$reg_chinese = "/^[\x{4e00}-\x{9fa5}]+$/u";
	//判断
	if(empty($ContactName)){
		$json['warn'] = "联系人全名不能为空";
	}else if(preg_match($reg_chinese,$ContactName) == 0){
		$json['warn'] = "全名请填写汉字";
	}else if(mb_strlen($ContactName,"GB2312") < 4 or mb_strlen($ContactName,"GB2312") > 12){
		$json['warn'] = "全名不能小于4个字符且不能大于12个字符";
	}else if(empty($CompanyName)){
		$json['warn'] = "单位全称不能为空";
	}else if(preg_match($reg_chinese,$CompanyName) == 0){
		$json['warn'] = "单位全称请填写汉字";
	}else if(empty($LegalName)){
		$json['warn'] = "法人/负责人全名不能为空";
	}else if(preg_match($reg_chinese,$LegalName) == 0){
		$json['warn'] = "法人/负责人全名请填写汉字";
	}else if(mb_strlen($LegalName,"GB2312") < 4 or mb_strlen($LegalName,"GB2312") > 12){
		$json['warn'] = "全名不能小于4个字符且不能大于12个字符";
	}else if(empty($RegionId)){
		$json['warn'] = "单位地址不能为空";
	}else if(empty($IDCard)){
		$json['warn'] = "法人/负责人身份证号不能为空";
	}else if(empty($BusinessLicense)){
		$json['warn'] = "营业执照/社会统一信用代码不能为空";
	}else if(empty($email)){
		$json['warn'] = "邮箱不能为空";
	}else if(preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/",$email) == 0){
		$json['warn'] = "邮箱格式不正确";
	}else if(empty($ContactTel)){
		$json['warn'] = "请输入联系手机";	
	}else if(preg_match($CheckTel,$ContactTel) == 0){
		$json['warn'] = "联系手机格式有误";	
	}else if(preg_match("/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}(\d|x|X)$/",$IDCard) == 0){
		$json['warn'] = "您的身份证号格式不正确";
	}else{
		$bool1 = mysql_query("update kehu set
		ContactName = '$ContactName',
		ContactNameOpen = '$ContactNameOpen',
		IDCard = '$IDCard',
		RegionId = '$RegionId',
		email = '$email',
		emailOpen = '$emailOpen',
		ContactTel = '$ContactTel',
		UpdateTime = '$time' where khid = '$kehu[khid]' ");
		if($bool1){
			$bool2 = mysql_query("update company set
			CompanyName = '$CompanyName',
			LegalName = '$LegalName',
			BusinessLicense = '$BusinessLicense',
			UpdateTime = '$time' where khid = '$kehu[khid]' ");
			if($bool2){
				$_SESSION['warn'] = "基本资料更新成功";	
				$json['warn'] = 2;
			}else{
				$json['warn'] = "基本资料更新失败~~";	
			}
		}else{
			$json['warn'] = "基本资料更新失败~";	
		}
	}	
/*----------------------------发布劳务供给------------------------------------*/		
}else if(isset($_POST['supplyMode']) and isset($_POST['SupplyId'])){
	//赋值 
	$ClassifyId = $_POST['supplyColumnChild'];//劳务项目分类Id号
	$ClassifyOther = $_POST['supplyOther'];//其他
	$IdentityType = $_POST['supplyMy'];//个人/商家
	$CompanyName = $_POST['supplyName'];//商家名称
	$mode = $_POST['supplyMode'];//方式
	$face = $_POST['supplyFace'];//面向
	$payType = $_POST['supplyPayType'];//收费类型
	$pay = $_POST['supplyPay'];//收费
	$PayCycle = $_POST['supplyPayCycle'];//收费周期/结算方式
	$type = $_POST['supplyType'];//类型
	$WorkingHours = $_POST['supplyWorkingHours'];//工作时间
	$title = htmlentities($_POST['supplyTitle'],ENT_QUOTES,'utf-8');//标题
	$KeyWord = $_POST['supplyKeyWord'];//关键词
	$text = htmlentities($_POST['supplyText'],ENT_QUOTES,'utf-8');//资历展示/供给说明
	$agree = $_POST['supplyAgree'];//同意
	//整合时间表
	$TimeTable = "";
	foreach($_POST['TimeTable'] as $i){
		if(empty($TimeTable)){
			$tag = "";
		}else{
			$tag = ",";
		}
		$TimeTable .= $tag.$i;
	}
	$id = $_POST['SupplyId'];
	//判断
	if(empty($ClassifyId)) {+
		$json['warn'] = "请选择劳务项目";
	}else if($ClassifyId == "其他" and empty($ClassifyOther)){
		$json['warn'] = "若你选择其他劳务项目请填写";
	}else if(empty($IdentityType) and $kehu['type'] == "个人"){
		$json['warn'] = "请选择个人或者商家";
	}else if($IdentityType == "商家" and empty($CompanyName)){
		$json['warn'] = "请填写商家名称";
	}else if(empty($mode)){
		$json['warn'] = "请选择劳务提供方式";
	}else if(empty($face)){
		$json['warn'] = "请选择劳务面向";
	}else if(empty($payType)){
		$json['warn'] = "请选择劳务收费";
	}else if($payType == "薪酬" and empty($pay)){
		$json['warn'] = "请填写劳务收费";
	}else if($payType == "薪酬" and empty($PayCycle)){
		$json['warn'] = "请选择劳务结算方式";
	}else if(empty($type)){
		$json['warn'] = "请选择劳务类型";
	}else if(empty($WorkingHours)) {
		$json['warn'] = "请选择劳务工作时间";
	}else if ($WorkingHours == "时间表" and empty($TimeTable)) {
		$json['warn'] = "请勾选劳务工作时间";
	}else if(empty($title)){
		$json['warn'] = "请填写标题";
	}else if(empty($KeyWord)){
		$json['warn'] = "请填写关键词";
	}else if(empty($text)){
		$json['warn'] = "请填写供给说明";
	}elseif(Repeat(" supply where title = '$title' ","id",$id)){
		$json['warn'] = "标题已经存在了";
	}else if(empty($agree)){
		$json['warn'] = "请同意“有劳了网”《法律申明》";
	}else if(empty($kehu['ContactTel'])){
		$json['warn'] = "请完善资料后再发布";
	}elseif(empty($id)){
		//限制只能发布信息条数
		$supplyNum = mysql_num_rows(mysql_query("select * from supply where khid = '$kehu[khid]' and clientType = '$kehu[type]' "));
		$demandNum = mysql_num_rows(mysql_query("select * from demand where khid = '$kehu[khid]' and clientType = '$kehu[type]' "));
		if(($supplyNum + $demandNum >= 4 and $kehu['type'] == "个人") or ( $supplyNum + $demandNum >= 8 and $kehu['type'] == "企业" )){
			$json['warn'] = "个人用户最多可发布4条信息，企业用户最多可以发布8条信息，如果您要发布新的信息：1，编辑修改已经发布的信息。2删除不需要的信息，重新发布。";
		}else{
			$id = suiji();
			$bool = mysql_query(" insert into supply 
			(id,khid,ClassifyId,ClassifyOther,IdentityType,clientType,CompanyName,mode,face,payType,pay,PayCycle,
			type,WorkingHours,TimeTable,title,KeyWord,text,agree,UpdateTime,time)
			values
			('$id','$kehu[khid]','$ClassifyId','$ClassifyOther','$IdentityType','$kehu[type]','$CompanyName','$mode','$face','$payType','$pay','$PayCycle',
			'$type','$WorkingHours','$TimeTable','$title','$KeyWord','$text','$agree','$time','$time')
			");
			if($bool){
				$_SESSION['warn'] = "劳务供给新增成功";
				$json['warn'] = 2;
				$json['title'] = $title;
			}else{
				$json['warn'] = "劳务供给新增失败";
			}
		}		
	}else{
		$supply = query("supply"," id = '$id' ");
		if($supply['id'] != $id){
			$json['warn'] = "未找到记录";
		}else{
			$bool = mysql_query("update supply set
			ClassifyId = '$ClassifyId',
			ClassifyOther = '$ClassifyOther',
			IdentityType = '$IdentityType',
			CompanyName = '$CompanyName',
			mode = '$mode',
			face = '$face',
			payType = '$payType',
			pay = '$pay',
			PayCycle = '$PayCycle',
			type = '$type',
			WorkingHours = '$WorkingHours',
			TimeTable = '$TimeTable',
			title = '$title',
			KeyWord = '$KeyWord',
			text = '$text',
			agree = '$agree',
			UpdateTime = '$time' where id = '$id' ");
			if($bool){
				$_SESSION['warn'] = "劳务供给更新成功";	
				$json['warn'] = 2;
			}else{
				$json['warn'] = "劳务供给更新失败";	
			}	
		}
	}
	if (isMobile()) {
		$json['href'] = root."m/mUser/mUsSupply.php?supply_id=".$id;
	}else{
		if ($kehu['type'] == "个人") {
			$json['href'] = root."user/user.php?type=supply&supply_id=".$id;
		}else{
			$json['href'] = root."seller/seller.php?type=supply&supply_id=".$id;
		}
	}
	$json['id'] = $id;
/*----------------------------删除劳务供给列表------------------------------------*/		
}else if(isset($_GET['DeleteId'])){
	$id  = $_GET['DeleteId'];
	$SupplyImgSql = mysql_query("SELECT * FROM SupplyImg WHERE SupplyId = '$id' ");
	while ($SupplyImgArray = mysql_fetch_assoc($SupplyImgSql)) {
		unlink(ServerRoot.$SupplyImgArray['src']);	
	}	
	if(mysql_query("delete from supply where id = '$id' ")){
		$json['warn'] = 2;
	}else{
		$json['warn'] = "删除成功";
	}
/*-----------------供给根据主项目返回子项目-------------------------------------------------------------*/
}elseif(isset($_POST['supplyColumn'])){
	$type = $_POST['supplyColumn'];//主项目
	$json['ColumnChild'] = IdOption("classify where type = '$type' ","id","name","请选择劳务子项目","");
/*----------------------------发布劳务需求------------------------------------*/		
}else if(isset($_POST['demandMode']) and isset($_POST['demandId'])){
	//赋值 
	$id = $_POST['demandId'];
	$ClassifyId = $_POST['demandColumnChild'];//劳务项目分类Id号
	$ClassifyOther = $_POST['demandOther'];//其他
	$mode = $_POST['demandMode'];//方式
	$face = $_POST['demandFace'];//面向
	$payType = $_POST['demandPayType'];//收费类型
	$pay = $_POST['demandPay'];//收费
	$PayCycle = $_POST['demandPayCycle'];//收费周期/结算方式
	$StartTime = $_POST['StartYear']."-".$_POST['StartMoon']."-".$_POST['StartDay'];//开始时间
	$EndTime = $_POST['EndYear']."-".$_POST['EndMoon']."-".$_POST['EndDay'];//结束时间
	$type = $_POST['demandType'];//类型
	$title = htmlentities($_POST['demandTitle'],ENT_QUOTES,'utf-8');//标题
	$KeyWord = $_POST['demandKeyWord'];//关键词
	$text = htmlentities($_POST['demandText'],ENT_QUOTES,'utf-8');//资历展示/需求说明
	$agree = $_POST['demandAgree'];//同意
	//判断
	if(empty($ClassifyId)){
		$json['warn'] = "请选择劳务项目";
	}else if($ClassifyId == "其他" and empty($ClassifyOther)){
		$json['warn'] = "若你选择其他劳务项目请填写";
	}else if(empty($mode)){
		$json['warn'] = "请选择劳务提供方式";
	}else if(empty($face)){
		$json['warn'] = "请选择劳务面向";
	}else if(empty($payType)){
		$json['warn'] = "请选择劳务收费";
	}else if($payType == "薪酬" and empty($pay)){
		$json['warn'] = "请填写劳务收费";
	}else if($payType == "薪酬" and empty($PayCycle)){
		$json['warn'] = "请选择劳务结算方式";
	}else if(empty($StartTime)){
		$json['warn'] = "请选择劳务开始时间";
	}else if(empty($EndTime)){
		$json['warn'] = "请选择劳务结束时间";
	}else if(empty($type)){
		$json['warn'] = "请选择劳务类型";
	}else if(empty($title)){
		$json['warn'] = "请填写标题";
	}else if(empty($KeyWord)){
		$json['warn'] = "请填写关键词";
	}else if(empty($text)){
		$json['warn'] = "请填写需求说明";
	}elseif(Repeat(" demand where title = '$title' ","id",$id)){
		$json['warn'] = "标题已经存在了";
	}else if(empty($agree)){
		$json['warn'] = "请同意“有劳了网”《法律申明》";
	}else if(empty($kehu['ContactTel'])){
		$json['warn'] = "请完善资料后再发布";	
	}elseif(empty($id)){
		//限制只能发布信息条数
		$supplyNum = mysql_num_rows(mysql_query("select * from supply where khid = '$kehu[khid]' and clientType = '$kehu[type]' "));
		$demandNum = mysql_num_rows(mysql_query("select * from demand where khid = '$kehu[khid]' and clientType = '$kehu[type]' "));
		if(($supplyNum + $demandNum >= 4 and $kehu['type'] == "个人") or ($supplyNum + $demandNum >= 8 and $kehu['type'] == "企业" )){
			$json['warn'] = "个人用户最多可发布4条信息，企业用户最多可以发布8条信息，如果您要发布新的信息：1，编辑修改已经发布的信息。2删除不需要的信息，重新发布。";
		}else{
			$id = suiji();
			$bool = mysql_query(" insert into 
			demand 
	(id,khid,ClassifyId,ClassifyOther,clientType,mode,face,payType,pay,PayCycle,type,StartTime,EndTime,title,KeyWord,text,agree,UpdateTime,time)
			values 
	('$id','$kehu[khid]','$ClassifyId','$ClassifyOther','$kehu[type]','$mode','$face','$payType','$pay','$PayCycle','$type','$StartTime','$EndTime','$title','$KeyWord','$text','$agree','$time','$time')
			");
			if($bool){
				$_SESSION['warn'] = "劳务需求新增成功";
				$json['warn'] = 2;
				$json['title'] = $title;
				$json['id'] = $id;
			}else{
				$json['warn'] = "劳务需求新增失败";
			}
		}
	}else{
		$demand = query("demand"," id = '$id' ");
		if($demand['id'] != $id){
			$json['warn'] = "未找到记录";
		}else{
			$bool = mysql_query("update demand set
			ClassifyId = '$ClassifyId',
			ClassifyOther = '$ClassifyOther',
			mode = '$mode',
			face = '$face',
			payType = '$payType',
			pay = '$pay',
			PayCycle = '$PayCycle',
			type = '$type',
			StartTime = '$StartTime',
			EndTime = '$EndTime',
			title = '$title',
			KeyWord = '$KeyWord',
			text = '$text',
			agree = '$agree',
			UpdateTime = '$time' where id = '$id' ");
			if($bool){
				$_SESSION['warn'] = "劳务需求更新成功";	
				$json['warn'] = 2;
			}else{
				$json['warn'] = "劳务需求更新失败";	
			}	
		}
	}
	if (isMobile()) {
		$json['href'] = root."m/mUser/mUsDemand.php?demand_id=".$id;
	}else{
		if ($kehu['type'] == "个人") {
			$json['href'] = root."user/user.php?type=demand&demand_id=".$id;
		}else{
			$json['href'] = root."seller/seller.php?type=demand&demand_id=".$id;
		}
	}
/*----------------------------删除劳务需求列表------------------------------------*/		
}else if(isset($_GET['DeleteDemandId'])){
	$id  = $_GET['DeleteDemandId'];
	if(mysql_query("delete from demand where id = '$id' ")){
		$json['warn'] = 2;
	}else{
		$json['warn'] = "删除成功";
	}
/*-----------------需求根据主项目返回子项目-------------------------------------------------------------*/
}elseif(isset($_POST['demandColumn'])){
	$type = $_POST['demandColumn'];//主项目
	$json['ColumnChild'] = IdOption("classify where type = '$type' ","id","name","请选择劳务子项目","");							
/*------------------删除个人中心我的相册图片-------------------------------------------------*/
}else if(isset($_GET['deletePhotoImg'])){
	//赋值
	$id = $_GET['deletePhotoImg'];//我的相册的图片ID号
	$kehuImg = mysql_fetch_array(mysql_query("select * from kehuImg where id = '$id' "));
	//判断
	if(empty($id)){
		$_SESSION['warn'] = '图片的id号不能为空';	
	}else if($kehuImg['id'] != $id){
		$_SESSION['warn'] = '图片不存在';	
	}else{
		$bool = mysql_query("delete from kehuImg where id = '$id' ");
		//删除图片函数
		unlink(ServerRoot.$kehuImg['src']);	
		if($bool){
			$_SESSION['warn'] = "我的相册图片删除成功";
			$json['warn'] = 2;
		}else{
			$json['warn'] = "我的相册图片删除失败";	
		}
	}
/*------------------举报不良信息-------------------------------------------------*/
}else if (isset($_GET['reportMessage']) ) {
	//赋值
	$array = $_POST['Report'];//4条举报信息
	$targetId = $_POST['targetId'];//被举报的人ID号
	$ReportType = $_POST['ReportType'];//被举报类型
	if(empty($array)){
		$json['warn'] = "请选择一条举报信息";
	}else{
		$m = "";//串联的结果
	    foreach($array as $mes){//遍历数组
			if(empty($m)){//第一次
				$n = "";
			}else{
			    $n = "，";//如果不为第一条，则打印逗号
			}
			$m .= $n.$mes;//串联结果
		}
		if(empty($m)){
			$json['warn'] = "value值为空";
		}else{
			$id = suiji();
			$bool = mysql_query(" insert into report 
			(id,type,khid,targetId,content,time) values 
			('$id','$ReportType','$kehu[khid]','$targetId','$m','$time') ");
			if($bool){
				$json['warn'] = "举报提交成功";
			}else{
			    $json['warn'] = "举报提交失败";	
			}
		}
	}
}
echo json_encode($json);
?>