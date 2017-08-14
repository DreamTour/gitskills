<?php
include "adfunction.php";
ControlRoot();
/*-----------------分类管理-多条件模糊查询-------------------------------------------------------------------------------------------*/
if(isset($_POST['adClassifyClassifyType']) and isset($_POST['adClassifyClassifyName'])){
	//赋值
	$type = $_POST['adClassifyClassifyType'];//一级分类
	$name = $_POST['adClassifyClassifyName'];//二级分类
	$list = $_POST['adClassifyList'];//排序号
	$x = " where 1=1 ";
	//串联查询语句

	if(!empty($type)){
		if(empty($name)){
			$x .= " and type = '$type' ";
		}else{
			$x .= " and name = '$name' ";
		}
	}
	if(!empty($list)){
	    $x .= " and list like '%$list%' ";
	}
	//返回
	$_SESSION['adClassify'] = array(
	"type" => $type,"name" => $name,"list" => $list,"Sql" => $x);
/*------------------删除供给信息-------------------------------------------------*/
}else if(isset($_GET['supply_delete_id'])){
	//赋值
	$id = $_GET['supply_delete_id'];//删除供给信息ID号
	$supply = mysql_fetch_array(mysql_query("select * from supply where id = '$id' "));
	//判断
	if(empty($id)){
		$_SESSION['warn'] = '供给信息的id号不能为空';
	}else if($supply['id'] != $id){
		$_SESSION['warn'] = '供给信息不存在';
	}else{
		//删除供给信息
		mysql_query("delete from supply where id = '$id' ");
		//删除供给信息图片
		$SupplyImgSql = mysql_query("select * from SupplyImg where SupplyId = '$id' ");
		while ($SupplyImgArray = mysql_fetch_assoc($SupplyImgSql)) {
			unlink(ServerRoot.$SupplyImgArray['src']);
		}
		//删除收藏的供给信息
		mysql_query("delete from collect where TargetId = '$id'");
		$_SESSION['warn'] = "供给信息删除成功";
	}
	header("Location:{$root}control/adSupply.php");
	exit(0);
/*------------------删除需求信息-------------------------------------------------*/
}else if(isset($_GET['demand_delete_id'])){
	//赋值
	$id = $_GET['demand_delete_id'];//删除需求信息ID号
	$demand = mysql_fetch_array(mysql_query("select * from demand where id = '$id' "));
	//判断
	if(empty($id)){
		$_SESSION['warn'] = '需求信息的id号不能为空';
	}else if($demand['id'] != $id){
		$_SESSION['warn'] = '需求信息不存在';
	}else{
		//删除需求信息
		mysql_query("delete from demand where id = '$id' ");
		//删除收藏的需求信息
		mysql_query("delete from collect where TargetId = '$id'");
		$_SESSION['warn'] = "需求信息删除成功";
	}
	header("Location:{$root}control/adDemand.php");
	exit(0);
/*------------------删除客户-------------------------------------------------*/
}else if(isset($_GET['client_delete_id'])){
	//赋值
	$id = $_GET['client_delete_id'];//删除客户ID号
	$client = mysql_fetch_array(mysql_query("select * from kehu where khid = '$id' "));
	//判断
	if(empty($id)){
		$_SESSION['warn'] = '客户的id号不能为空';
	}else if($client['khid'] != $id){
		$_SESSION['warn'] = '客户不存在';
	}else{
		//查询本客户基本信息
		$kehu = query("kehu"," khid = '$id' ");
		//删除客户收藏
		mysql_query("delete from collect where khid = '$id'");
		//删除客户企业资料
		mysql_query("delete from company where khid = '$id'");
		//删除客户需求
		mysql_query("delete from demand where khid = '$id'");
		//删除客户个人资料
		mysql_query("delete from personal where khid = '$id'");
		//删除举报
		mysql_query("delete from report where khid = '$id'");
		//删除客户供给
		$supplySql = mysql_query("select * from supply where khid = '$kehu[khid]' ");
		while ($supplyArray = mysql_fetch_assoc($supplySql)) {
			$SupplyImgSql = mysql_query("select * from SupplyImg where SupplyId = '$supplyArray[id]' ");
			while ($SupplyImgArray = mysql_fetch_assoc($SupplyImgSql)) {
				unlink(ServerRoot.$SupplyImgArray['src']);
			}
			mysql_query("delete from SupplyImg where SupplyId = '$supplyArray[id]' ");
		}
		mysql_query("delete from supply where khid = '$id'");
		//删除客户头像
		unlink(ServerRoot.$kehu['ico']);
		//删除客户手持身份证照片
		unlink(ServerRoot.$kehu['IDCardHand']);
		//最后删除本客户基本资料
		mysql_query("delete from kehu where khid = '$id'");
		$_SESSION['warn'] = "客户删除成功";
	}
	header("Location:{$root}control/adClient.php");
	exit(0);
/*-----------------客户管理-多条件模糊查询-------------------------------------------------------------------------------------------*/
}elseif(isset($_POST['adClientContactName']) and isset($_POST['adClientContactTel'])){
	//赋值
	$type = $_POST['adClientType'];//类型
	$ContactName = $_POST['adClientContactName'];//联系人姓名
	$ContactTel = $_POST['adClientContactTel'];//联系人手机号码
	$IDCard = $_POST['adClientIDCard'];//身份证号
	$email = $_POST['adClientEmail'];//联系邮箱
	$id = $_POST['adClientID'];//客户ID号
	$x = " where 1=1 ";
	//串联查询语句
	if(!empty($type)){
	    $x .= " and type = '$type' ";
	}
	if(!empty($ContactName)){
	    $x .= " and ContactName like '%$ContactName%' ";
	}
	if(!empty($ContactTel)){
	    $x .= " and ContactTel like '%$ContactTel%' ";
	}
	if(!empty($IDCard)){
		$x .= " and IDCard like '%$IDCard%' ";
	}
	if(!empty($email)){
	    $x .= " and email like '%$email%' ";
	}
	if(!empty($id)){
		$x .= " and khid like '%$id%' ";
	}
	//返回
	$_SESSION['adClient'] = array(
	"type" => $type,"ContactName" => $ContactName,"ContactTel" => $ContactTel,"IDCard" => $IDCard,"email" => $email,"id" => $id,"Sql" => $x);
/*-----------------需求管理-多条件模糊查询-------------------------------------------------------------------------------------------*/
}elseif(isset($_POST['adDemandMode']) and isset($_POST['adDemandFace'])){
	//赋值
	$ClassifyType = $_POST['adDemandClassifyType'];//一级分类
	$ClassifyName = $_POST['adDemandClassifyName'];//二级分类
	$mode = $_POST['adDemandMode'];//方式
	$face = $_POST['adDemandFace'];//面向
	$pay = $_POST['adDemandPay'];//薪资
	$type = $_POST['adDemandType'];//类型
	$title = $_POST['adDemandTitle'];//标题	
	$x = " where 1=1 ";
	//串联查询语句
	if(!empty($ClassifyType)){
		if(empty($ClassifyName)){
			$x .= " and ClassifyId in ( select id from classify where type = '$ClassifyType' ) ";
		}else{
			$x .= " and ClassifyId = '$ClassifyName' ";
		}
	}
	if(!empty($mode)){
	    $x .= " and mode like '%$mode%' ";
	}
	if(!empty($face)){
	    $x .= " and face like '%$face%' ";
	}
	if(!empty($pay)){
	    $x .= " and pay like '%$pay%' ";
	}
	if(!empty($type)){
	    $x .= " and type like '%$type%' ";
	}
	if(!empty($title)){
	    $x .= " and title like '%$title%' ";
	}
	//返回
	$_SESSION['adDemand'] = array(
	"ClassifyType" => $ClassifyType,"ClassifyName" => $ClassifyName,"mode" => $mode,"face" => $face,"pay" => $pay,"type" => $type,"title" => $title,"Sql" => $x);	
/*-----------------供给管理-多条件模糊查询-------------------------------------------------------------------------------------------*/
}elseif(isset($_POST['adSupplyMode']) and isset($_POST['adSupplyFace'])){
	//赋值
	$ClassifyType = $_POST['adSupplyClassifyType'];//一级分类
	$ClassifyName = $_POST['adSupplyClassifyName'];//二级分类
	$mode = $_POST['adSupplyMode'];//方式
	$face = $_POST['adSupplyFace'];//面向
	$pay = $_POST['adSupplyPay'];//薪资
	$PayCycle = $_POST['adSupplyPayCycle'];//收费周期
	$title = $_POST['adSupplyTitle'];//类型	
	$x = " where 1=1 ";
	//串联查询语句
	if(!empty($ClassifyType)){
		if(empty($ClassifyName)){
			$x .= " and ClassifyId in ( select id from classify where type = '$ClassifyType' ) ";
		}else{
			$x .= " and ClassifyId = '$ClassifyName' ";
		}
	}
	if(!empty($mode)){
	    $x .= " and mode like '%$mode%' ";
	}
	if(!empty($face)){
	    $x .= " and face like '%$face%' ";
	}
	if(!empty($pay)){
	    $x .= " and pay like '%$pay%' ";
	}
	if(!empty($PayCycle)){
	    $x .= " and PayCycle like '%$PayCycle%' ";
	}
	if(!empty($title)){
	    $x .= " and title like '%$title%' ";
	}
	//返回
	$_SESSION['adSupply'] = array(
	"ClassifyType" => $ClassifyType,"ClassifyName" => $ClassifyName,"mode" => $mode,"face" => $face,"pay" => $pay,"PayCycle" => $PayCycle,"title" => $title,"Sql" => $x);
/*-----------------举报管理-多条件模糊查询-------------------------------------------------------------------------------------------*/
}elseif( isset($_POST['SearchReportType']) ){
	//赋值
	$type = $_POST['SearchReportType'];//劳务类型
	$x = " where 1=1 ";
	//串联查询语句
	if(!empty($type)){
	    $x .= " and type like '%$type%' ";
	}
	//返回
	$_SESSION['adReport'] = array(
	"type" => $type,"Sql" => $x);			
}
/*-----------------跳转回刚才的页面---------------------------------------------------------------------*/
header("Location:".getenv("HTTP_REFERER"));
?>