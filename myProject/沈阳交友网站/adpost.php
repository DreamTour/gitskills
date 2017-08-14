<?php
include "adfunction.php";
ControlRoot();
/*-----------------礼物管理-多条件模糊查询-------------------------------------------------------------------------------------------*/
if(isset($_POST['adGiftName']) and isset($_POST['adGiftPrice'])){
	//赋值
	$name = $_POST['adGiftName'];//礼物名称
	$price = $_POST['adGiftPrice'];//礼物单价
	$x = " where 1=1 ";
	//串联查询语句
	if(!empty($name)){
	    $x .= " and name like '%$name%' ";
	}
	if(!empty($price)){
	    $x .= " and price like '%$price%' ";
	}
	//返回
	$_SESSION['adGift'] = array(
	"name" => $name,"price" => $price,"Sql" => $x);
/*------------------礼物管理-上传礼物图像---------------------------------------------------------------------------------------------*/
}elseif(isset($_FILES['adGiftIcoUpload']) and isset($_POST['adGiftId'])){
	//赋值
	$id = $_POST['adGiftId'];
	$Gift = query("Gift"," id = '$id' ");
	//判断并执行
	if(empty($id)){
	    $_SESSION['warn'] = "请先提交礼物基本参数";
	}elseif($Gift['id'] != $id){
	    $_SESSION['warn'] = "未找到本礼物";
	}else{
		$FileName = "adGiftIcoUpload";//上传图片的表单文件域input名称
		$cut['type'] = "需要裁剪";//"需要裁剪"或"需要缩放"或空
		$cut['width'] = 200;//裁剪宽度
		$cut['height'] = 200;//裁剪高度
		$cut['NewWidth'] = "";//缩放的宽度
		$cut['MaxHeight'] = "";//缩放后图片的最大高度
		$type['name'] = "更新图像";//"更新图像"or"新增图像"
		$type['num'] = "";//新增图像时限定的图像总数
		$sql = "select * from Gift where id = '$id' ";//查询图片的数据库代码
		$column = "ico";//保存图片的数据库列的名称
		$suiji = suiji();
		$Url['root'] = "../../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
		$Url['NewImgUrl'] = "img/GiftIco/{$suiji}.jpg";//新图片保存的网站根目录位置
		$NewImgSql = "update Gift set {$column} = '$Url[NewImgUrl]',UpdateTime = '$time' where id = '$id' ";//保存图片的数据库代码
		$ImgWarn = "礼物图像更新成功";//图片保存成功后返回的文字内容
		UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);
	}
/*-----------------客户管理-多条件模糊查询-------------------------------------------------------------------------------------------*/
}elseif(isset($_POST['adClientNickName']) and isset($_POST['adClientTel'])){
	//赋值
	$NickName = $_POST['adClientNickName'];//客户昵称
	$sex = $_POST['adClientSex'];//客户性别
	$searchMinAge = $_POST['searchMinAge'];//最小年龄
	$searchMaxAge = $_POST['searchMaxAge'];//最大年龄
	$area = $_POST['area'];//区县
	$khtel = $_POST['adClientTel'];//手机号码
	$Auditing = $_POST['adClientAuditing'];//审核状态
	$x = " where 1=1 ";
	//串联查询语句
	if(!empty($NickName)){
	    $x .= " and NickName like '%$NickName%' ";
	}
	if(!empty($sex)){
	    $x .= " and sex = '$sex' ";
	}
	if(empty($searchMinAge) or empty($searchMaxAge)){
		$searchMinAge =  $searchMaxAge = "";
	}else{
	    $d = date("Y");
		$MaxYear = ($d - $searchMinAge)."-01-01";//最大出生日期
		$MinYear = ($d - $searchMaxAge)."-01-01";//最小出生日期
		$x .= " and Birthday > '$MinYear' and Birthday < '$MaxYear' ";
	}
	if(!empty($area)){
		$x .= " and RegionId = '$area' ";
	}
	if(!empty($khtel)){
	    $x .= " and khtel like '%$khtel%' ";
	}
	if(!empty($Auditing)){
	    $x .= " and Auditing like '%$Auditing%' ";
	}
	//返回
	$_SESSION['adClient'] = array(
	"NickName" => $NickName,"sex" => $sex,"minAge" => $searchMinAge,"maxAge" => $searchMaxAge,"area" => $area,"khtel" => $khtel,"Auditing" => $Auditing,"Sql" => $x);
/*-----------------消息管理-多条件模糊查询-------------------------------------------------------------------------------------------*/
}elseif(isset($_POST['adMessageType']) and isset($_POST['adMessageTitle'])){
	//赋值
	$type = $_POST['adMessageType'];//消息类型
	$title = $_POST['adMessageTitle'];//消息标题
	$text = $_POST['adMessageText'];//消息内容
	$Auditing = $_POST['adMessageAuditing'];//审核状态
	$x = " where 1=1 ";
	//串联查询语句
	if(!empty($type)){
	    $x .= " and type like '%$type%' ";
	}
	if(!empty($title)){
	    $x .= " and title like '%$title%' ";
	}
	if(!empty($text)){
	    $x .= " and text like '%$text%' ";
	}
	if(!empty($Auditing)){
	    $x .= " and Auditing like '%$Auditing%' ";
	}
	//返回
	$_SESSION['adMessage'] = array(
	"type" => $type,"title" => $title,"text" => $text,"Auditing" => $Auditing,"Sql" => $x);	
/*-----------------活动报名-多条件模糊查询-------------------------------------------------------------------------------------------*/
}elseif(isset($_POST['SearchEnrollType'])){
	//赋值
	$type = $_POST['SearchEnrollType'];//活动类型
	$ContentId = $_POST['SearchEnrollContentId'];//活动ID号
	$khid = $_POST['SearchEnrollKhid'];//客户ID号
	$x = " where 1=1 ";
	//串联查询语句
	if(!empty($type)){
	    $x .= " and type = '$type' ";
	}
	if(!empty($ContentId)){
	    $x .= " and ContentId = '$ContentId' ";
	}
	if(!empty($khid)){
	    $x .= " and khid = '$khid' ";
	}
	//返回
	$_SESSION['adEnroll'] = array("type" => $type,"ContentId" => $ContentId,"khid" => $khid,"Sql" => $x);
}
/*-----------------跳转回刚才的页面---------------------------------------------------------------------*/
header("Location:".getenv("HTTP_REFERER"));
?>