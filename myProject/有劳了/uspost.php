<?php
include "../library/OpenFunction.php";
UserRoot("pc");
/*------------------新增或更新个人中心我的头像-------------------------------------------------*/
if(isset($_FILES['headPortraitUpload'])){
	$FileName = "headPortraitUpload";//上传图片的表单文件域名称
	$cut['type'] = "需要裁剪";//"需要裁剪"或"需要缩放"或空
	$cut['width'] = "480";//裁剪宽度
	$cut['height'] = "600";//裁剪高度
	$cut['NewWidth'] = "";//缩放的宽度
	$cut['MaxHeight'] = "";//缩放后图片的最大高度
	$type['name'] = "更新图像";//"更新图像"or"新增图像"
	$type['num'] = 1;//新增图像时限定的图像总数
	$sql = " select * from kehu where khid = '$kehu[khid]' ";//查询图片的数据库代码
	$column = "ico";//保存图片的数据库列的名称
	$suiji = suiji();
	$Url['root'] = "../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
	$Url['NewImgUrl'] = "img/usHead/{$suiji}.jpg";//新图片保存的网站根目录位置
	$NewImgSql = "update kehu set {$column} = '$Url[NewImgUrl]',UpdateTime = '$time' where khid = '$kehu[khid]' ";
	$ImgWarn = "我的头像更新成功";//图片保存成功后返回的文字内容
	UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);	
/*------------------新增或更新企业/工商用户logo-------------------------------------------------*/
}else if(isset($_FILES['logoPortraitUpload'])){
	$FileName = "logoPortraitUpload";//上传图片的表单文件域名称
	$cut['type'] = "需要裁剪";//"需要裁剪"或"需要缩放"或空
	$cut['width'] = "480";//裁剪宽度
	$cut['height'] = "600";//裁剪高度
	$cut['NewWidth'] = "";//缩放的宽度
	$cut['MaxHeight'] = "";//缩放后图片的最大高度
	$type['name'] = "更新图像";//"更新图像"or"新增图像"
	$type['num'] = 1;//新增图像时限定的图像总数
	$sql = " select * from kehu where khid = '$kehu[khid]' ";//查询图片的数据库代码
	$column = "ico";//保存图片的数据库列的名称
	$suiji = suiji();
	$Url['root'] = "../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
	$Url['NewImgUrl'] = "img/seLogo/{$suiji}.jpg";//新图片保存的网站根目录位置
	$NewImgSql = "update kehu set {$column} = '$Url[NewImgUrl]',UpdateTime = '$time' where khid = '$kehu[khid]' ";
	$ImgWarn = "我的头像更新成功";//图片保存成功后返回的文字内容
	UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);	
/*-----------------个人更新手持身份证----------------------------------------------------------------------------------------------*/
}elseif(isset($_FILES['IDCardHandUpload'])){
    $FileName = "IDCardHandUpload";//上传图片的表单文件域名称
    $cut['type'] = "需要缩放";//"需要裁剪"或"需要缩放"或空
    $cut['width'] = "";//裁剪宽度
    $cut['height'] = "";//裁剪高度
    $cut['NewWidth'] = 1000;//缩放的宽度
    $cut['MaxHeight'] = 2000;//缩放后图片的最大高度
    $type['name'] = "更新图像";//"更新图像"or"新增图像"
    $type['num'] = 1;//新增图像时限定的图像总数
    $sql = " select * from kehu where khid = '$kehu[khid]' ";//查询图片的数据库代码
    $column = "IDCardHand";//保存图片的数据库列的名称
    $suiji = suiji();
    $Url['root'] = "../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
	$Url['NewImgUrl'] = "img/IDCardHand/{$suiji}.jpg";//新图片保存的网站根目录位置
    $NewImgSql = "update kehu set {$column} = '$Url[NewImgUrl]',UpdateTime = '$time' where khid = '$kehu[khid]' ";//保存图片的数据库代码
    $ImgWarn = "手持身份证更新成功";//图片保存成功后返回的文字内容
    UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);
/*-----------------企业/工商用户更新手持身份证----------------------------------------------------------------------------------------------*/
}elseif(isset($_FILES['seIDCardHandUpload'])){
    $FileName = "seIDCardHandUpload";//上传图片的表单文件域名称
    $cut['type'] = "需要缩放";//"需要裁剪"或"需要缩放"或空
    $cut['width'] = "";//裁剪宽度
    $cut['height'] = "";//裁剪高度
    $cut['NewWidth'] = 1000;//缩放的宽度
    $cut['MaxHeight'] = 2000;//缩放后图片的最大高度
    $type['name'] = "更新图像";//"更新图像"or"新增图像"
    $type['num'] = 1;//新增图像时限定的图像总数
    $sql = " select * from kehu where khid = '$kehu[khid]' ";//查询图片的数据库代码
    $column = "IDCardHand";//保存图片的数据库列的名称
    $suiji = suiji();
    $Url['root'] = "../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
	$Url['NewImgUrl'] = "img/seIDCardHand/{$suiji}.jpg";//新图片保存的网站根目录位置
    $NewImgSql = "update kehu set {$column} = '$Url[NewImgUrl]',UpdateTime = '$time' where khid = '$kehu[khid]' ";//保存图片的数据库代码
    $ImgWarn = "手持身份证更新成功";//图片保存成功后返回的文字内容
    UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);
	
/*-----------------企业/工商用户更新营业执照扫描件----------------------------------------------------------------------------------------------*/
}elseif(isset($_FILES['BusinessLicenseUpload'])){
    $FileName = "BusinessLicenseUpload";//上传图片的表单文件域名称
    $cut['type'] = "需要缩放";//"需要裁剪"或"需要缩放"或空
    $cut['width'] = "";//裁剪宽度
    $cut['height'] = "";//裁剪高度
    $cut['NewWidth'] = 1000;//缩放的宽度
    $cut['MaxHeight'] = 2000;//缩放后图片的最大高度
    $type['name'] = "更新图像";//"更新图像"or"新增图像"
    $type['num'] = 1;//新增图像时限定的图像总数
    $sql = " select * from company where khid = '$kehu[khid]' ";//查询图片的数据库代码
    $column = "BusinessLicenseImg";//保存图片的数据库列的名称
    $suiji = suiji();
    $Url['root'] = "../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
	$Url['NewImgUrl'] = "img/BusinessLicenseImg/{$suiji}.jpg";//新图片保存的网站根目录位置
    $NewImgSql = "update company set {$column} = '$Url[NewImgUrl]',UpdateTime = '$time' where khid = '$kehu[khid]' ";//保存图片的数据库代码
    $ImgWarn = "营业执照扫描件更新成功";//图片保存成功后返回的文字内容
    UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);
	
/*------------------新增客户供给图片-------------------------------------------------*/
}else if(isset($_FILES['kehuSupplyImgUpload'])){
	$SupplyId = $_POST['SupplyId'];
	$SupplyIdSql = query("supply","id = '$SupplyId'");
	if(empty($SupplyId)){
		$_SESSION['warn'] = "请发布过后再上传图片";	
	}else if($SupplyId != $SupplyIdSql['id']){
		$_SESSION['warn'] = "供给ID未找到";	
	}else{
		$FileName = "kehuSupplyImgUpload";//上传图片的表单文件域名称
		$cut['type'] = "需要缩放";//"需要裁剪"或"需要缩放"或空
		$cut['width'] = "";//裁剪宽度
		$cut['height'] = "";//裁剪高度
		$cut['NewWidth'] = 1000;//缩放的宽度
		$cut['MaxHeight'] = 2000;//缩放后图片的最大高度
		$type['name'] = "新增图像";//"更新图像"or"新增图像"
		$type['num'] = 2;//新增图像时限定的图像总数
		$sql = " select * from SupplyImg where SupplyId = '$SupplyId' ";//查询图片的数据库代码
		$column = "src";//保存图片的数据库列的名称
		$suiji = suiji();
		$Url['root'] = "../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
		$Url['NewImgUrl'] = "img/SupplyImg/{$suiji}.jpg";//新图片保存的网站根目录位置
		$NewImgSql = " insert into SupplyImg (id,SupplyId,src,time) values ('$suiji','$SupplyId','$Url[NewImgUrl]','$time') ";//保存图片的数据库代码
		$ImgWarn = "图片新增成功";//图片保存成功后返回的文字内容
		UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);		
		//返回
		$u = getenv("HTTP_REFERER");
		if (isMobile()) {
			$g = "?supply_id=";
		}
		else {
			$g = "&supply_id=";
		}
		$sign = "#supplyAnchor";
		if(strstr($u,$g) == false){
			$u .= $g.$SupplyId;
		}
		header("location:{$u}{$sign}");
		exit(0);
	}
/*------------------删除客户供给图片-------------------------------------------------*/
}else if(isset($_GET['deletePhotoImg'])){
	//赋值
	$id = $_GET['deletePhotoImg'];//客户供给图片ID号
	$SupplyImg = mysql_fetch_array(mysql_query("select * from SupplyImg where id = '$id' "));
	//判断
	if(empty($id)){
		$_SESSION['warn'] = '图片的id号不能为空';
	}else if($SupplyImg['id'] != $id){
		$_SESSION['warn'] = '图片不存在';
	}else{
		$bool = mysql_query("delete from SupplyImg where id = '$id' ");
		//删除图片函数
		unlink(ServerRoot.$SupplyImg['src']);
		if($bool){
			$_SESSION['warn'] = "图片删除成功";
			$json['warn'] = 2;
		}else{
			$_SESSION['warn'] = "图片删除失败";
		}
	}
/*------------------同城搜索-多条件模糊查询-------------------------------------------------*/
}else if(isset($_POST['searchSex']) and isset($_POST['searchMinAge']) and isset($_POST['searchMaxAge'])){
	//赋值
	$searchSex = $_POST['searchSex'];//性别
	$searchMinAge = $_POST['searchMinAge'];//最小年龄
	$searchMaxAge = $_POST['searchMaxAge'];//最大年龄
	$area = $_POST['area'];//所属区县ID号
	if(empty($kehu['Occupation'])){
		$_SESSION['warn'] = "请完善你的个人资料";	
	}else if(empty($kehu['LoveOccupation'])){
		$_SESSION['warn'] = "请完善你的择偶意向";	
	}else{
		//串联查询语句
		if(!empty($searchSex)){
			$x .= " and sex = '$searchSex' ";
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
		//返回
		$_SESSION['userSearch'] = array(
		"sex" => $searchSex,"minAge" => $searchMinAge,"maxAge" => $searchMaxAge,"city" => $city,"area" => $area,"Sql" => $x);
	}
	//判断
	if(isMobile()){
		header("Location:{$root}m/mSearch.php");
		exit(0);
	}
}
/*-----------------跳转回刚才的页面---------------------------------------------------------*/
header("Location:".getenv("HTTP_REFERER"));
?>