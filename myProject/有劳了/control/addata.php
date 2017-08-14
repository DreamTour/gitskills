<?php
include "adfunction.php";
if($ControlFinger == 2){
    $json['warn'] = $ControlWarn;
/*-----------------分类管理-新建或更新分类基本资料-------------------------------------------------------------*/
}elseif(isset($_POST['adClassifyId']) and isset($_POST['ClassifyType'])){
    //赋值
	$id = $_POST['adClassifyId'];//分类ID
	$type = $_POST['ClassifyType'];//一级分类
	$name = $_POST['ClassifyName'];//二级分类
	$list = $_POST['ClassifySort'];//排序号
	//判断
	if(strstr($adDuty['Power'],"分类管理") == false){
		$json['warn'] = "权限不足";
	}elseif(empty($type)){
		$json['warn'] = "请选择一级分类";
	}elseif(empty($name)){
		$json['warn'] = "请选择二级分类";
	}elseif(empty($list)){
		$json['warn'] = "请填写排序号";
	}elseif(empty($id)){
	    $id = suiji();
		$bool = mysql_query(" insert into classify 
		(id,type,name,list,UpdateTime,time) 
		values 
		('$id','$type','$name','$list','$time','$time') ");
		if($bool){
		    $_SESSION['warn'] = "分类基本资料新增成功";
			LogText("分类管理",$Control['adid'],"管理员{$Control['adname']}新增了分类（分类一级标题：{$type}，品牌ID：{$id}）");
			$json['warn'] = 2;
		}else{
			$json['warn'] = "分类基本资料新增失败";
		}
	}else{
	    $classify = query("classify"," id = '$id' ");
		if($classify['id'] != $id){
			$json['warn'] = "本分类未找到";
		}else{
			$bool = mysql_query(" update classify set
			type = '$type', 
			name = '$name',
			list = '$list',
			UpdateTime = '$time' where id = '$id' ");
			if($bool){
				$_SESSION['warn'] = "分类基本资料更新成功";
			    LogText("分类管理",$Control['adid'],"管理员{$Control['adname']}更新了分类基本信息（分类一级标题：{$type}，分类ID：{$id}）");
				$json['warn'] = 2;
			}else{
				$json['warn'] = "分类基本资料更新失败";
			}
		}
	}
	$json['href'] = root."control/adClassifyMx.php?id=".$id;
/*-----------------客户管理-更新客户基本资料-------------------------------------------------------------*/
}elseif(isset($_POST['authentication']) and isset($_POST['adClientId'])){
    //赋值
	$id = $_POST['adClientId'];//客户ID
	$authentication = $_POST['authentication'];//身份认证
	//判断
	if(strstr($adDuty['Power'],"客户管理") == false){
		$json['warn'] = "权限不足";
	}else{
	    $kehu = query("kehu"," khid = '$id' ");
		if($kehu['khid'] != $id){
			$json['warn'] = "本客户未找到";
		}else{
			$bool = mysql_query(" update kehu set 
			authentication = '$authentication',
			UpdateTime = '$time' where khid = '$id' ");
			if($bool){
				$_SESSION['warn'] = "客户基本资料更新成功";
			    LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}更新了客户基本信息（客户名称：{$NickName}，客户ID：{$id}）");
				$json['warn'] = 2;
			}else{
				$json['warn'] = "客户基本资料更新失败";
			}
		}
	}
/*-----------------批量处理列表记录（需要管理员登录密码）客户，需求，供给管理--------------------------------*/
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
				//添加日志
				LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}删除了客户（客户姓名：{$kehu['ContactName']}，客户ID：{$kehu['khid']}）");
				$x++;
			}
			$_SESSION['warn'] = "删除了{$x}个客户";
			$json['warn'] = 2;
		}
	}elseif($type == "DemandDelete"){
		$Array = $_POST['DemandList'];
		if($adDuty['name'] != "超级管理员"){
			$json['warn'] = "只有超级管理员才能删除需求";
		}elseif(empty($Array)){
			$json['warn'] = "您一条需求都没有选择呢";
		}else{
			foreach($Array as $id){
				//查询本条需求基本信息
				$demand = query("demand"," id = '$id' ");
				//删除本需求
				mysql_query("delete from demand where id = '$id'");
				//删除需求收藏
				mysql_query("delete from collect where TargetId = '$id'");
				//添加日志
				LogText("需求管理",$Control['adid'],"管理员{$Control['adname']}删除了需求（需求方式：{$demand['mode']}，需求ID：{$demand['id']}）");
				$x++;
			}
			$_SESSION['warn'] = "删除了{$x}个需求";
			$json['warn'] = 2;
		}
	}elseif($type == "supplyDelete"){
		$Array = $_POST['supplyList'];
		if($adDuty['name'] != "超级管理员"){
			$json['warn'] = "只有超级管理员才能删除供给";
		}elseif(empty($Array)){
			$json['warn'] = "您一个供给都没有选择呢";
		}else{
			foreach($Array as $id){
				//查询本供给基本信息
				$supply = query("supply"," id = '$id' ");
				//删除本供给
				mysql_query("delete from supply where id = '$id'");
				//删除供给图片
				$SupplyImgSql = mysql_query("select * from SupplyImg where SupplyId = '$id' ");
				while ($SupplyImgArray = mysql_fetch_assoc($SupplyImgSql)) {
					unlink(ServerRoot.$SupplyImgArray['src']);
				}
				//删除供给收藏
				mysql_query("delete from collect where TargetId = '$id'");
				//添加日志
				LogText("供给管理",$Control['adid'],"管理员{$Control['adname']}删除了供给（供给方式：{$supply['mode']}，供给ID：{$supply['id']}）");
				$x++;
			}
			$_SESSION['warn'] = "删除了{$x}个供给";
			$json['warn'] = 2;
		}
	//删除分类	
	}elseif($type == "DeleteClassify"){
		$Array = $_POST['ClassifyList'];
		if($adDuty['name'] != "超级管理员"){
			$json['warn'] = "只有超级管理员才能删除供给";
		}elseif(empty($Array)){
			$json['warn'] = "您一个分类都没有选择呢";
		}else{
			foreach($Array as $id){
				//查询本分类基本信息
				$classify = query("classify"," id = '$id' ");
				//删除本分类
				mysql_query("delete from classify where id = '$id'");
				//添加日志
				LogText("分类管理",$Control['adid'],"管理员{$Control['adname']}删除了分类（一级分类：{$classify['type']}，分类ID：{$classify['id']}）");
				$x++;
			}
			$_SESSION['warn'] = "删除了{$x}个分类";
			$json['warn'] = 2;
		}
	//删除举报信息	
	}elseif($type == "ReportDelete"){
		$Array = $_POST['ReportList'];
		if($adDuty['name'] != "超级管理员"){
			$json['warn'] = "只有超级管理员才能删除举报信息";
		}elseif(empty($Array)){
			$json['warn'] = "您一个举报信息都没有选择呢";
		}else{
			foreach($Array as $id){
				//查询本举报信息基本信息
				$report = query("report"," id = '$id' ");
				//删除本举报信息
				mysql_query("delete from report where id = '$id'");
				//添加日志
				LogText("举报管理",$Control['adid'],"管理员{$Control['adname']}删除了举报信息（举报信息类型：{$report['type']}，举报信息ID：{$report['id']}）");
				$x++;
			}
			$_SESSION['warn'] = "删除了{$x}个举报信息";
			$json['warn'] = 2;
		}	
	}else{
	    $json['warn'] = "未知执行指令";
	}
/*-----------------分类管理-根据二级分类返回一级分类-------------------------------------------------------------*/
}else if(isset($_POST['adClassifyClassifyType'])){
	$type = $_POST['adClassifyClassifyType'];//一级分类
	$json['html'] = IdOption("classify where type = '$type' ","id","name","二级分类","");	
/*-----------------需求根据二级分类返回一级分类-------------------------------------------------------------*/
}elseif(isset($_POST['adDemandClassifyType'])){
	$type = $_POST['adDemandClassifyType'];//一级分类
	$json['html'] = IdOption("classify where type = '$type' ","id","name","二级分类","");	
/*-----------------供给根据二级分类返回一级分类-------------------------------------------------------------*/
}elseif(isset($_POST['adSupplyClassifyType'])){
	$type = $_POST['adSupplyClassifyType'];//一级分类
	$json['html'] = IdOption("classify where type = '$type' ","id","name","二级分类","");	
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
