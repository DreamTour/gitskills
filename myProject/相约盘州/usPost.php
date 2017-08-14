<?php
include "../library/OpenFunction.php";
UserRoot("pc");
/*-----------------更新身份证正面----------------------------------------------------------------------------------------------*/
if(isset($_FILES['IDCardFrontUpload'])){
    $FileName = "IDCardFrontUpload";//上传图片的表单文件域名称
    $cut['type'] = "需要缩放";//"需要裁剪"或"需要缩放"或空
    $cut['width'] = "";//裁剪宽度
    $cut['height'] = "";//裁剪高度
    $cut['NewWidth'] = 1000;//缩放的宽度
    $cut['MaxHeight'] = 2000;//缩放后图片的最大高度
    $type['name'] = "更新图像";//"更新图像"or"新增图像"
    $type['num'] = "";//新增图像时限定的图像总数
    $sql = " select * from kehu where khid = '$kehu[khid]' ";//查询图片的数据库代码
    $column = "IDCardFront";//保存图片的数据库列的名称
    $suiji = suiji();
    $Url['root'] = "../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
	$Url['NewImgUrl'] = "img/IDCardFront/{$suiji}.jpg";//新图片保存的网站根目录位置
    $NewImgSql = "update kehu set {$column} = '$Url[NewImgUrl]',UpdateTime = '$time' where khid = '$kehu[khid]' ";//保存图片的数据库代码
    $ImgWarn = "身份证正面更新成功";//图片保存成功后返回的文字内容
    UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);
/*-----------------更新身份证反面----------------------------------------------------------------------------------------------*/
}elseif(isset($_FILES['IDCardReverseUpload'])){
    $FileName = "IDCardReverseUpload";//上传图片的表单文件域名称
    $cut['type'] = "需要缩放";//"需要裁剪"或"需要缩放"或空
    $cut['width'] = "";//裁剪宽度
    $cut['height'] = "";//裁剪高度
    $cut['NewWidth'] = 1000;//缩放的宽度
    $cut['MaxHeight'] = 2000;//缩放后图片的最大高度
    $type['name'] = "更新图像";//"更新图像"or"新增图像"
    $type['num'] = "";//新增图像时限定的图像总数
    $sql = " select * from kehu where khid = '$kehu[khid]' ";//查询图片的数据库代码
    $column = "IDCardBack";//保存图片的数据库列的名称
    $suiji = suiji();
    $Url['root'] = "../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
	$Url['NewImgUrl'] = "img/IDCardBack/{$suiji}.jpg";//新图片保存的网站根目录位置
    $NewImgSql = "update kehu set {$column} = '$Url[NewImgUrl]',UpdateTime = '$time' where khid = '$kehu[khid]' ";//保存图片的数据库代码
    $ImgWarn = "身份证反面更新成功";//图片保存成功后返回的文字内容
    UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);
/*-----------------更新手持身份证----------------------------------------------------------------------------------------------*/
}elseif(isset($_FILES['IDCardHandUpload'])){
    $FileName = "IDCardHandUpload";//上传图片的表单文件域名称
    $cut['type'] = "需要缩放";//"需要裁剪"或"需要缩放"或空
    $cut['width'] = "";//裁剪宽度
    $cut['height'] = "";//裁剪高度
    $cut['NewWidth'] = 1000;//缩放的宽度
    $cut['MaxHeight'] = 2000;//缩放后图片的最大高度
    $type['name'] = "更新图像";//"更新图像"or"新增图像"
    $type['num'] = "";//新增图像时限定的图像总数
    $sql = " select * from kehu where khid = '$kehu[khid]' ";//查询图片的数据库代码
    $column = "IDCardHand";//保存图片的数据库列的名称
    $suiji = suiji();
    $Url['root'] = "../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
	$Url['NewImgUrl'] = "img/IDCardHand/{$suiji}.jpg";//新图片保存的网站根目录位置
    $NewImgSql = "update kehu set {$column} = '$Url[NewImgUrl]',UpdateTime = '$time' where khid = '$kehu[khid]' ";//保存图片的数据库代码
    $ImgWarn = "手持身份证更新成功";//图片保存成功后返回的文字内容
    UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);
/*------------------新增我的相册----------------------------------------------------------------------------------------------------------------------*/
}elseif(isset($_FILES['kehuAlbumUpload'])){
	$FileName = "kehuAlbumUpload";//上传图片的表单文件域名称
	$cut['type'] = "需要缩放";//"需要裁剪"或"需要缩放"或空
	$cut['width'] = "";//裁剪宽度
	$cut['height'] = "";//裁剪高度
	$cut['NewWidth'] = 1000;//缩放的宽度
	$cut['MaxHeight'] = 2000;//缩放后图片的最大高度
	$type['name'] = "新增图像";//"更新图像"or"新增图像"
	$type['num'] = 9;//新增图像时限定的图像总数
	$sql = " select * from kehuImg where khid = '$kehu[khid]' ";//查询图片的数据库代码
	$column = "src";//保存图片的数据库列的名称
	$suiji = suiji();
	$Url['root'] = "../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
	$Url['NewImgUrl'] = "img/ClientAlbum/{$suiji}.jpg";//新图片保存的网站根目录位置
	$NewImgSql = " insert into kehuImg (id,khid,src,time) values ('$suiji','$kehu[khid]','$Url[NewImgUrl]','$time') ";//保存图片的数据库代码
	$ImgWarn = "我的相册图片新增成功";//图片保存成功后返回的文字内容
	UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);
/*------------------新增我的头像----------------------------------------------------------------------------------------------------------------------*/
}elseif(isset($_FILES['headPortraitUpload'])){
    $FileName = "headPortraitUpload";//上传图片的表单文件域名称
    $cut['type'] = "需要裁剪";//"需要裁剪"或"需要缩放"或空
    $cut['width'] = 480;//裁剪宽度
    $cut['height'] = 600;//裁剪高度
    $cut['NewWidth'] = "";//缩放的宽度
    $cut['MaxHeight'] = "";//缩放后图片的最大高度
    $type['name'] = "更新图像";//"更新图像"or"新增图像"
    $type['num'] = "";//新增图像时限定的图像总数
    $sql = " select * from kehu where khid = '$kehu[khid]' ";//查询图片的数据库代码
    $column = "ico";//保存图片的数据库列的名称
    $suiji = suiji();
    $Url['root'] = "../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
	$Url['NewImgUrl'] = "img/usHead/{$suiji}.jpg";//新图片保存的网站根目录位置
    $NewImgSql = "update kehu set {$column} = '$Url[NewImgUrl]',UpdateTime = '$time' where khid = '$kehu[khid]' ";//保存图片的数据库代码
    $ImgWarn = "我的头像更新成功";//图片保存成功后返回的文字内容
    UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);
}elseif(isset($_GET['deletePhotoImg'])){
	//赋值
	$id = $_GET['deletePhotoImg'];//我的相册的图片ID号
	$kehuImg = query("kehuImg","id = '$id' ");
	//判断
	if(empty($id)){
		$_SESSION['warn'] = "图片ID号不能为空";
	}elseif($kehuImg['id'] != $id){
		$_SESSION['warn'] = "图片不存在";
	}else{
		$bool = mysql_query("delete from kehuImg where id = '$id' ");
		//删除图片函数
		unlink(ServerRoot.$kehuImg['src']);
		if($bool){
			$_SESSION['warn'] = "我的相册图片删除成功";
		}else{
			$_SESSION['warn'] = "我的相册图片删除失败";	
		}	
	}
}
/*-----------------跳转回刚才的页面-------------------------------------------------------------------------------------------*/
header("Location:".getenv("HTTP_REFERER"));
?>