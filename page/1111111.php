<?php
include "adfunction.php";
if($ControlFinger == 2){
    $json['warn'] = $ControlWarn;1111111
/*-----------------客户管理-新建或更新客户基本资料-------------------------------------------------------------*/
}elseif(isset($_POST['khname']) and isset($_POST['khtel']) and isset($_POST['khAddressMx'])){
    //赋值
	$khid = $_POST['adClientId'];//客户ID
	$khname = FormSub($_POST['khname']);//客户姓名
	$khtel = $_POST['khtel'];//客户手机号码
	$province = $_POST['province'];//省份
	$city = $_POST['city'];//城市
	$RegionId = $_POST['area'];//区域ID
	$AddressMx = FormSub($_POST['khAddressMx']);//详细地址
	$IDCard = $_POST['IDCard'];//身份证号
	$KhEmail = $_POST['KhEmail'];//电子邮箱
	$SpouseName = FormSub($_POST['SpouseName']);//配偶姓名
	$SpouseTel = $_POST['SpouseTel'];//配偶手机号码
	$WeddingYear = $_POST['WeddingYear'];//结婚日期-年
	$WeddingMoon = $_POST['WeddingMoon'];//结婚日期-月
	$WeddingDay = $_POST['WeddingDay'];//结婚日期-日
	$WeddingDate = $WeddingYear."-".$WeddingMoon."-".$WeddingDay;//结婚日期（年-月-日）
	//组合客户想了解的内容 
	$WishKnow = "";
	foreach($_POST['WishKnow'] as $v){
		$WishKnow .= ",{$v}";
	}
	$WeddingPhotoBudget = $_POST['WeddingPhotoBudget'];//婚纱照预算
	$TheWeddingBudget = $_POST['TheWeddingBudget'];//婚庆预算
	$WeddingBreakfastBudget = $_POST['WeddingBreakfastBudget'];//喜宴预算
	$HoneymoonSpot = $_POST['HoneymoonSpot'];//蜜月地点
	$InformedSources = $_POST['InformedSources'];//获知渠道
	$message = $_POST['ClientMessage'];//短信发送状态
	$Activity = $_POST['Activity'];//活动类型
	$RefereeTel = $_POST['khRefereeTel'];//推荐人手机号码
	$ClientPiaoStatus = $_POST['ClientPiaoStatus'];//门票邮寄状态
	$adText = FormSub($_POST['adText']);//管理员备注
	$Called = $_POST['Called'];//回访（是/否）
	$Stage = website("b54qd");//届数
	//判断
	if(strstr($adDuty['Power'],"客户管理") == false){
		$json['warn'] = "权限不足";
	}elseif(empty($khname)){
		$json['warn'] = "请填写客户姓名";
	}elseif(empty($khtel)){
		$json['warn'] = "请填写客户手机号码";
	}elseif(preg_match($CheckTel,$khtel) == 0){
		$json['warn'] = "客户手机号码填写错误";
	}elseif(Repeat(" kehu where khtel = '$khtel' ","khid",$khid)){
		$json['warn'] = "本手机号码已被其他客户使用";
	}elseif(!empty($SpouseTel) and preg_match($CheckTel,$SpouseTel) == 0){
		$json['warn'] = "配偶手机号码格式有误";
	}elseif(!empty($RefereeTel) and preg_match($CheckTel,$RefereeTel) == 0){
		$json['warn'] = "推荐人手机号码填写错误";
	}elseif($khtel == $RefereeTel){
	    $json['warn'] = "推荐人手机号码不能和客户手机号码一样，即不能推荐自己";
	}elseif(empty($khid)){
	    $khid = suiji();
		$bool = mysql_query(" insert into kehu (khid,khname,khtel,RegionId,AddressMx,IDCard,KhEmail,SpouseName,SpouseTel,WeddingDate,WishKnow,
		WeddingPhotoBudget,TheWeddingBudget,WeddingBreakfastBudget,HoneymoonSpot,InformedSources,Called,TicketSend,message,Activity,Source,RefereeTel,RefereeCash,Stage,adText,UpdateTime,time) 
		values ('$khid','$khname','$khtel','$RegionId','$AddressMx','$IDCard','$KhEmail','$SpouseName','$SpouseTel','$WeddingDate','$WishKnow',
		'$WeddingPhotoBudget','$TheWeddingBudget','$WeddingBreakfastBudget','$HoneymoonSpot','$InformedSources','$Called','$ClientPiaoStatus','$message','$Activity','后台创建','$RefereeTel','否','$Stage','$adText','$time','$time') ");
		if($bool){
		    $_SESSION['warn'] = "客户基本资料新增成功";
			LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}新增了客户（姓名：{$khname}，手机号码：{$khtel}，客户ID：{$khid}）");
			$json['warn'] = 2;
		}else{
			$json['warn'] = "客户基本资料新增失败";
		}
	}else{
	    $kehu = query("kehu"," khid = '$khid' ");
		if($kehu['khid'] != $khid){
			$json['warn'] = "本客户未找到";
		}else{
			$bool = mysql_query(" update kehu set 
			khname = '$khname',
			khtel = '$khtel',
			RegionId = '$RegionId',
			AddressMx = '$AddressMx',
			IDCard = '$IDCard',
			KhEmail = '$KhEmail',
			SpouseName = '$SpouseName',
			SpouseTel = '$SpouseTel',
			WeddingDate = '$WeddingDate',
			WishKnow = '$WishKnow',
			WeddingPhotoBudget = '$WeddingPhotoBudget',
			TheWeddingBudget = '$TheWeddingBudget',
			WeddingBreakfastBudget = '$WeddingBreakfastBudget',
			HoneymoonSpot = '$HoneymoonSpot',
			InformedSources = '$InformedSources',
			Called = '$Called',
			TicketSend = '$ClientPiaoStatus',
			message = '$message',
			Activity = '$Activity',
			RefereeTel = '$RefereeTel',
			adText = '$adText',
			UpdateTime = '$time' where khid = '$khid' ");
			if($bool){
				$_SESSION['warn'] = "客户基本资料更新成功";
			    LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}更新了客户基本信息（姓名：{$khname}，手机号码：{$khtel}，客户ID：{$khid}）");
				$json['warn'] = 2;
			}else{
				$json['warn'] = "客户基本资料更新失败";
			}
		}
	}
	$json['href'] = $adroot."adClientMx.php?id=".$khid;
/*-----------------批量处理列表记录（需要管理员登录密码）--------------------------------*/
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
				//删除本客户
				mysql_query("delete from kehu where khid = '$id'");
				//添加日志
				LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}删除了客户（姓名：{$kehu['khname']}，手机号码：{$kehu['khtel']}，客户ID：{$kehu['khid']}）");
				$x++;
			}
			$_SESSION['warn'] = "删除了{$x}个客户";
			$json['warn'] = 2;
		}
	}else{
	    $json['warn'] = "未知执行指令";
	}
}
/*-----------------返回-------------------------------------------------------------*/
echo json_encode($json);
?>