<?php
include "adfunction.php";
ControlRoot();
/*-----------------车辆品牌管理-多条件模糊查询-------------------------------------------------------------------------------------------*/
if(isset($_POST['adBrandType']) and isset($_POST['adBrandName'])){
	//赋值
	$type = $_POST['adBrandType'];//车辆品牌
	$name = $_POST['adBrandName'];//车辆子品牌
	$ModelYear = $_POST['adBrandModelYear'];//年限
	$MotorcycleType = $_POST['adBrandMotorcycleType'];//车型
	$xian = $_POST['adBrandXian'];//显示状态
	$list = $_POST['adBrandList'];//排序号
	$x = " where 1=1 ";
	//串联查询语句
	if(!empty($type)){
	    $x .= " and type like '%$type%' ";
	}
	if(!empty($name)){
	    $x .= " and name like '%$name%' ";
	}
	if(!empty($ModelYear)){
	    $x .= " and ModelYear like '%$ModelYear%' ";
	}
	if(!empty($MotorcycleType)){
	    $x .= " and MotorcycleType like '%$MotorcycleType%' ";
	}
	if(!empty($xian)){
	    $x .= " and xian like '%$xian%' ";
	}
	if(!empty($list)){
	    $x .= " and list like '%$list%' ";
	}
	//返回
	$_SESSION['adBrand'] = array(
	"type" => $type,"name" => $name,"ModelYear" => $ModelYear,"MotorcycleType" => $MotorcycleType,"xian" => $xian,"list" => $list,"Sql" => $x);
/*-----------------车辆管理-多条件模糊查询-------------------------------------------------------------------------------------------*/
}else if(isset($_POST['adCarName']) and isset($_POST['adCarColour'])){
	//赋值
	$name = $_POST['adCarName'];//名称
	$colour = $_POST['adCarColour'];//颜色
	$mileage = $_POST['adCarMileage'];//行驶里程
	$price = $_POST['adCarPrice'];//价格
	$vin = $_POST['adCarVin'];//车架号
	$x = " where 1=1 ";
	//串联查询语句
	if(!empty($name)){
	    $x .= " and name like '%$name%' ";
	}
	if(!empty($colour)){
	    $x .= " and colour like '%$colour%' ";
	}
	if(!empty($mileage)){
	    $x .= " and mileage like '%$mileage%' ";
	}
	if(!empty($price)){
	    $x .= " and price like '%$price%' ";
	}
	if(!empty($vin)){
	    $x .= " and vin like '%$vin%' ";
	}
	//返回
	$_SESSION['adCar'] = array(
	"name" => $name,"colour" => $colour,"mileage" => $mileage,"price" => $price,"vin" => $vin,"Sql" => $x);
/*-----------------商户管理-多条件模糊查询-------------------------------------------------------------------------------------------*/
}else if(isset($_POST['adSellerName']) and isset($_POST['adSellerSetel'])){
	//赋值
	$name = $_POST['adSellerName'];//商家名称
	$setel = $_POST['adSellerSetel'];//负责人电话
	$address = $_POST['adSellerAddress'];//详细地址
	$x = " where 1=1 ";
	//串联查询语句
	if(!empty($name)){
	    $x .= " and name like '%$name%' ";
	}
	if(!empty($setel)){
	    $x .= " and setel like '%$setel%' ";
	}
	if(!empty($address)){
	    $x .= " and address like '%$address%' ";
	}
	//返回
	$_SESSION['adSeller'] = array(
	"name" => $name,"setel" => $setel,"address" => $address,"Sql" => $x);	
/*-----------------商户员工管理-多条件模糊查询-------------------------------------------------------------------------------------------*/
}else if(isset($_POST['adSellerStaffName']) and isset($_POST['adSellerStaffTel'])){
	//赋值
	$name = $_POST['adSellerStaffName'];//车辆品牌
	$tel = $_POST['adSellerStaffTel'];//车辆子品牌
	$OpenId = $_POST['adSellerStaffOpenId'];//车辆子品牌
	$x = " where 1=1 ";
	//串联查询语句
	if(!empty($name)){
	    $x .= " and name like '%$name%' ";
	}
	if(!empty($tel)){
	    $x .= " and tel like '%$tel%' ";
	}
	if(!empty($OpenId)){
	    $x .= " and OpenId like '%$OpenId%' ";
	}
	//返回
	$_SESSION['adSellerStaff'] = array(
	"name" => $name,"tel" => $tel,"OpenId" => $OpenId,"Sql" => $x);
/*------------------车辆管理-上传行驶证扫描件---------------------------------------------------------------------------------------------*/
}elseif(isset($_FILES['adCertificateIcoUpload']) and isset($_POST['adCertificateId'])){
	//赋值
	$id = $_POST['adCertificateId'];
	$Car = query("Car"," id = '$id' ");
	//判断并执行
	if(empty($id)){
	    $_SESSION['warn'] = "请先提交车辆基本参数";
	}elseif($Car['id'] != $id){
	    $_SESSION['warn'] = "未找到本车辆";
	}else{
		$FileName = "adCertificateIcoUpload";//上传图片的表单文件域input名称
		$cut['type'] = "需要缩放";//"需要裁剪"或"需要缩放"或空
		$cut['width'] = "";//裁剪宽度
		$cut['height'] = "";//裁剪高度
		$cut['NewWidth'] = 500;//缩放的宽度
		$cut['MaxHeight'] = 1000;//缩放后图片的最大高度
		$type['name'] = "更新图像";//"更新图像"or"新增图像"
		$type['num'] = "";//新增图像时限定的图像总数
		$sql = "select * from Car where id = '$id' ";//查询图片的数据库代码
		$column = "DrivingLicense";//保存图片的数据库列的名称
		$suiji = suiji();
		$Url['root'] = "../../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
		$Url['NewImgUrl'] = "img/DrivingLicense/{$suiji}.jpg";//新图片保存的网站根目录位置
		$NewImgSql = "update Car set {$column} = '$Url[NewImgUrl]',UpdateTime = '$time' where id = '$id' ";//保存图片的数据库代码
		$ImgWarn = "行驶证扫描件更新成功";//图片保存成功后返回的文字内容
		UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);
	}
/*------------------车辆管理-上传车辆列表图片---------------------------------------------------------------------------------------------*/
}elseif(isset($_FILES['adListIcoUpload']) and isset($_POST['adListId'])){
	//赋值
	$id = $_POST['adListId'];
	$Car = query("Car"," id = '$id' ");
	//判断并执行
	if(empty($id)){
	    $_SESSION['warn'] = "请先提交车辆基本参数";
	}elseif($Car['id'] != $id){
	    $_SESSION['warn'] = "未找到本车辆";
	}else{
		$FileName = "adListIcoUpload";//上传图片的表单文件域input名称
		$cut['type'] = "需要缩放";//"需要裁剪"或"需要缩放"或空
		$cut['width'] = "";//裁剪宽度
		$cut['height'] = "";//裁剪高度
		$cut['NewWidth'] = 500;//缩放的宽度
		$cut['MaxHeight'] = 1000;//缩放后图片的最大高度
		$type['name'] = "更新图像";//"更新图像"or"新增图像"
		$type['num'] = "";//新增图像时限定的图像总数
		$sql = "select * from Car where id = '$id' ";//查询图片的数据库代码
		$column = "ico";//保存图片的数据库列的名称
		$suiji = suiji();
		$Url['root'] = "../../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
		$Url['NewImgUrl'] = "img/CarIco/{$suiji}.jpg";//新图片保存的网站根目录位置
		$NewImgSql = "update Car set {$column} = '$Url[NewImgUrl]',UpdateTime = '$time' where id = '$id' ";//保存图片的数据库代码
		$ImgWarn = "车辆列表图片更新成功";//图片保存成功后返回的文字内容
		UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);
	}
/*------------------车辆管理-上传车辆详情图片---------------------------------------------------------------------------------------------*/
}elseif(isset($_FILES['adcarMxIcoUpload']) and isset($_POST['adcarMxId'])){
	//赋值
	$id = $_POST['adcarMxId'];
	$Car = query("Car"," id = '$id' ");
	//判断并执行
	if(empty($id)){
	    $_SESSION['warn'] = "请先提交车辆基本参数";
	}elseif($Car['id'] != $id){
	    $_SESSION['warn'] = "未找到本车辆";
	}else{
		$FileName = "adcarMxIcoUpload";//上传图片的表单文件域input名称
		$cut['type'] = "需要裁剪";//"需要裁剪"或"需要缩放"或空
		$cut['width'] = 1000;//裁剪宽度
		$cut['height'] = 500;//裁剪高度
		$cut['NewWidth'] = "";//缩放的宽度
		$cut['MaxHeight'] = "";//缩放后图片的最大高度
		$type['name'] = "新增图像";//"更新图像"or"新增图像"
		$type['num'] = 4;//新增图像时限定的图像总数
		$sql = " select * from CarImg where CarId = '$id' ";//查询图片的数据库代码
		$column = "src";//保存图片的数据库列的名称
		$suiji = suiji();
		$Url['root'] = "../../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
		$Url['NewImgUrl'] = "img/CarImg/{$suiji}.jpg";//新图片保存的网站根目录位置
		$NewImgSql = " insert into CarImg (id,CarId,src,time) values ('$suiji','$id','$Url[NewImgUrl]','$time') ";//保存图片的数据库代码
		$ImgWarn = "车辆详情图片更新成功";//图片保存成功后返回的文字内容
		UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);
	}
/*------------------删除车辆详情图片----------------------------------------------------------------------------------------------------------------------*/
}elseif(!empty($_GET['carImgDelete'])){
	$id = $_GET['carImgDelete'];
	$CarImg = query("CarImg"," id = '$id' ");
	unlink(ServerRoot.$CarImg['src']);
	mysql_query("delete from CarImg where id = '$id'");
	$_SESSION['warn'] = "车辆详情图片删除成功";
/*------------------车辆管理-上传车辆品牌参数图片---------------------------------------------------------------------------------------------*/
}elseif(isset($_FILES['adcarParamIcoUpload']) and isset($_POST['adcarParamId'])){
	//赋值
	$id = $_POST['adcarParamId'];
	$Brand = query("Brand"," id = '$id' ");
	//判断并执行
	if(empty($id)){
		$_SESSION['warn'] = "请先提交品牌基本参数";
	}elseif($Brand['id'] != $id){
		$_SESSION['warn'] = "未找到本品牌";
	}else{
		$FileName = "adcarParamIcoUpload";//上传图片的表单文件域input名称
		$cut['type'] = "需要裁剪";//"需要裁剪"或"需要缩放"或空
		$cut['width'] = 1000;//裁剪宽度
		$cut['height'] = 500;//裁剪高度
		$cut['NewWidth'] = "";//缩放的宽度
		$cut['MaxHeight'] = "";//缩放后图片的最大高度
		$type['name'] = "新增图像";//"更新图像"or"新增图像"
		$type['num'] = 20;//新增图像时限定的图像总数
		$sql = " select * from carParameter where BrandId = '$id' ";//查询图片的数据库代码
		$column = "src";//保存图片的数据库列的名称
		$suiji = suiji();
		$Url['root'] = "../../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
		$Url['NewImgUrl'] = "img/carParameter/{$suiji}.jpg";//新图片保存的网站根目录位置
		$NewImgSql = " insert into carParameter (id,BrandId,src,time) values ('$suiji','$id','$Url[NewImgUrl]','$time') ";//保存图片的数据库代码
		$ImgWarn = "品牌参数图片新增成功";//图片保存成功后返回的文字内容
		UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);
	}
	/*------------------删除车辆参数图片----------------------------------------------------------------------------------------------------------------------*/
}elseif(!empty($_GET['carParameterDelete'])){
	$id = $_GET['carParameterDelete'];
	$carParameter = query("carParameter"," id = '$id' ");
	unlink(ServerRoot.$carParameter['src']);
	mysql_query("delete from carParameter where id = '$id'");
	$_SESSION['warn'] = "品牌参数图片删除成功";
	/*-----------------客户管理-多条件模糊查询-------------------------------------------------------------------------------------------*/
}elseif(isset($_POST['adClientNickName']) and isset($_POST['adClientTel'])){
	//赋值
	$NickName = $_POST['adClientNickName'];//客户昵称
	$sex = $_POST['adClientSex'];//客户性别
	$searchMinAge = $_POST['searchMinAge'];//最小年龄
	$searchMaxAge = $_POST['searchMaxAge'];//最大年龄
	$area = $_POST['area'];//区县
	$khtel = $_POST['adClientTel'];//手机号码
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
	//返回
	$_SESSION['adClient'] = array(
	"NickName" => $NickName,"sex" => $sex,"minAge" => $searchMinAge,"maxAge" => $searchMaxAge,"area" => $area,"khtel" => $khtel,"Sql" => $x);
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