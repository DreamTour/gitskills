<?php
include "PcFunction.php";
/*-----------------同城搜索-多条件模糊查询-------------------------------------------------------------------------------------------*/
if(isset($_POST['searchSex']) and isset($_POST['searchMinAge']) and isset($_POST['searchMaxAge'])){
	//赋值
	$searchSex = $_POST['searchSex'];//性别
	$searchMinAge = $_POST['searchMinAge'];//最小年龄
	$searchMaxAge = $_POST['searchMaxAge'];//最大年龄
	$province = $_POST['province'];//省份
	$city = $_POST['city'];//城市
	$x = " where 1=1 ";
	//串联查询语句
	if(!empty($searchSex)){
	    $x .= " and sex like '%$searchSex%' ";
	}
	if(empty($searchMinAge) or empty($searchMaxAge)){
		$searchMinAge =  $searchMaxAge = "";
	}else{
	    $d = date("Y");
		$MaxYear = ($d - $searchMinAge)."-01-01";//最大出生日期
		$MinYear = ($d - $searchMaxAge)."-01-01";//最小出生日期
		$x .= " and Birthday > '$MinYear' and Birthday < '$MaxYear' ";
	}
	if(!empty($province)){
	    if(empty($city)){
		    $x .= " and RegionId in ( select id from region where province = '$province' ) ";
		}else{
		    $x .= " and RegionId in ( select id from region where province = '$province' and city = '$city' ) ";
		}
	}
	//返回
	$_SESSION['userSearch'] = array(
	"sex" => $searchSex,"minAge" => $searchMinAge,"maxAge" => $searchMaxAge,"province" => $province,"city" => $city,"Sql" => $x);
}
/*-----------商品列表页分类及模糊查询-------------------------------------------------------------------------------------------*/
if(isset($_POST['SearchGoodsMenu']) or isset($_GET['TypeThreeId']) or isset($_GET['TypeTwoId']) or isset($_GET['TypeOneId'])){
    //赋值
	$name = $_POST['SearchGoodsMenu'];
	$three = $_GET['TypeThreeId'];
	$two = $_GET['TypeTwoId'];
	$one = $_GET['TypeOneId'];
	$x = "";
	//串接查询语句
	if(!empty($three)){
		$x .= " and TypeThreeId = '$three' ";
		$_SESSION['goods'] = array("name" => "","type" => "three","Sql" => $x);
	}elseif(!empty($two)){
		$x .= " and TypeThreeId in ( select id from TypeThree where TypeTwoId = '$two' ) ";
		$_SESSION['goods'] = array("name" => "","type" => "two","Sql" => $x);
	}elseif(!empty($one)){
		$x .= " and TypeThreeId in ( select id from TypeThree where TypeTwoId in ( select id from TypeTwo where TypeOneId = '$one' ) ) ";
		$_SESSION['goods'] = array("name" => "","type" => "one","Sql" => $x);
	}elseif(isset($_POST['SearchGoodsMenu'])){
		if(!empty($name)){
			$x .= " and name like '%$name%' ";
		}
		$_SESSION['goods'] = array("name" => $name,"type" => "search","Sql" => $x);
	}
	//跳转
	header("location:{$root}Goods.php");
	exit(0);
}
/*-----------上传用户头像--------------------------------------------------------------------------------------------*/
if(isset($_FILES['uploadUsIconBtn'])) {
    $FileName = "uploadUsIconBtn";//上传图片的表单文件域名称
    $cut['type'] = "需要裁剪";//"需要裁剪"或"需要缩放"或空
    $cut['width'] = 200;//裁剪宽度
    $cut['height'] = 200;//裁剪高度
    $cut['NewWidth'] = "";//缩放的宽度
    $cut['MaxHeight'] = "";//缩放后图片的最大高度
    $type['name'] = "更新图像";//"更新图像"or"新增图像"
    $type['num'] = "";//新增图像时限定的图像总数
    $sql = " select * from kehu where khid = '$kehu[khid]' ";//查询图片的数据库代码
    $column = "ico";//保存图片的数据库列的名称
    $suiji = suiji();
    $Url['root'] = "../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
	$Url['NewImgUrl'] = "img/UserIco/{$suiji}.jpg";//新图片保存的网站根目录位置
    $NewImgSql = "update kehu set ico = '$Url[NewImgUrl]' where  khid = '$kehu[khid]' ";//保存图片的数据库代码
    $ImgWarn = "用户头像更新成功";//图片保存成功后返回的文字内容
    UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);
}
/*--------------用户删除关注的商品----------------------*/
if(isset($_POST['delGoodFocus'])) {
    $delGoodsWatched = $_POST['delGoodFocus'];
    $length = count($delGoodsWatched);
    for($x=0;$x < $length;$x++) {
        $id = $delGoodsWatched[$x];
        mysql_query("delete from collect where id = '$id' ");
    }
}
/*--------------用户删除关注的店铺----------------------*/
if(isset($_POST['delStoreFocus'])) {
    $delStoreWatched = $_POST['delStoreFocus'];
    $length = count($delStoreWatched);
    for($x=0;$x < $length;$x++) {
        $id = $delStoreWatched[$x];
        mysql_query("delete from collect where id = '$id' ");
    }
}
/*-----------------用户删除购物车商品--------------------------------------------------------------------------------*/
if(isset($_POST['DeleteBuyCar'])){
	$x = 0;
	foreach($_POST['DeleteBuyCar'] as $id){
        $buycar = query("buycar"," id = '$id' ");
		if($buycar['khid'] == $kehu['khid']){
			mysql_query("delete from buycar where id = '$id' ");
			$x++;
		}
	}
	$_SESSION['warn'] = "删除了{$x}个订单";
}
if(isset($_GET['DeleteBuyCar'])){
	$buycar = query("buycar"," id = '$_GET[DeleteBuyCar]' ");
	if($buycar['khid'] == $kehu['khid']){
		mysql_query("delete from buycar where id = '$buycar[id]' ");
		$_SESSION['warn'] = "删除成功";
	}else{
		$_SESSION['warn'] = "订单号有误";
	}
}
/*-----------------跳转回刚才的页面----------------------------------------------------------------------------------*/
header("Location:".getenv("HTTP_REFERER"));
?>