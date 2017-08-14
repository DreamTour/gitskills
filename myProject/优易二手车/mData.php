<?php
include "OpenFunction.php";
if($KehuFinger == 2){
    $json['warn'] = "您未登录";
/*----------------------------收藏车辆/取消收藏------------------------------------*/
}else if(isset($_POST['collectionCarId'])){	
	$carId = $_POST['collectionCarId'];//车辆的ID号
	$carSql = mysql_fetch_array(mysql_query("select * from Car where id = '$carId' "));//车辆表
	$collect = mysql_fetch_assoc(mysql_query("select * from collect where khid = '$kehu[khid]' and CarId = '$carId' "));//车辆收藏表
	//判断
	if(empty($carId)){
		$json['warn'] = "车辆ID号为空";	
	}else if($carSql['id'] != $carId){
		$json['warn'] = "没找到这个车辆的记录".$carSql."ddafsfds".$carId;	
	}else if(!empty($collect['id'])){
		if(mysql_query("delete from collect where id = '$collect[id]' ")){
			$json['warn'] = "取消成功";
		}else{
			$json['warn'] = "取消失败";
		}
	}else{
		$id = suiji();
		$bool = mysql_query("insert into collect (id,khid,carId,time) values ('$id','$kehu[khid]','$carId','$time') ");
		if($bool){
			$json['warn'] = '收藏成功';
		}else{
			$json['warn'] = '收藏失败';	
		}	
	}
/*----------------------------签到立即/取消报名------------------------------------*/
}else if(isset($_POST['signUp'])){
	//判断
	if($kehu['SignDate'] != $date){
		$integral = $kehu['integral'] + website("as2d4f8w");
		mysql_query(" update kehu set integral = '$integral',SignDate = '$date' where khid = '$kehu[khid]' ");
		$json['warn'] = "签到成功";
		$json['num'] = $integral;
	}else{
		$json['warn'] = "你已签到";	
	}
/*----------------------------个人中心基本资料更新------------------------------------*/		
}else if(isset($_POST['userName']) and isset($_POST['userKhtel'])){
	//赋值 
	$name = htmlentities($_POST['userName'],ENT_QUOTES,'utf-8');//姓名
	$khtel = $_POST['userKhtel'];//手机号码
	$RegionId = $_POST['area'];//所在区县ID号
	$AddressMx = $_POST['usreAddressMx'];//详细地址
	$reg_chinese = "/^[\x{4e00}-\x{9fa5}]+$/u";
	//判断
	if(empty($name)){
		$json['warn'] = "姓名请填写汉字，不能小于2个汉字且不能大于4个汉字";
	}else if(preg_match($reg_chinese,$name) == 0){
		$json['warn'] = "姓名请填写汉字，不能小于2个汉字且不能大于4个汉字";
	}else if(mb_strlen($name,"GB2312") < 4 or mb_strlen($name,"GB2312") > 8){
		$json['warn'] = "姓名请填写汉字，不能小于2个汉字且不能大于4个汉字";
	}else if(empty($khtel)){
		$json['warn'] = "请输入手机号码";	
	}else if(empty($RegionId)){
		$json['warn'] = "请选择所属区域";
	}else if(preg_match($CheckTel,$khtel) == 0){
		$json['warn'] = "手机号码格式有误";	
	}else if(empty($AddressMx)){
		$json['warn'] = "请输入详细地址";	
	}else{
		$bool = mysql_query("update kehu set
		name = '$name',
		khtel = '$khtel',
		RegionId = '$RegionId',
		AddressMx = '$AddressMx',
		UpdateTime = '$time' where khid = '$kehu[khid]' ");
		if($bool){
			$_SESSION['warn'] = "基本资料更新成功";	
			$json['warn'] = 2;
		}else{
			$json['warn'] = "基本资料更新失败";	
		}
	}
/*----------------------------拍卖------------------------------------*/
}else if(isset($_POST['CountDown'])){
	$car = query("Car","auction = '是'");
	//拍卖倒计时
	if($time < $car['AuctionTimeStart']){//拍卖还没开始
		$json['time'] = strtotime($car['AuctionTimeStart']) - time();
		$json['title'] = "拍卖开始还有";
	}else if($time < $car['AuctionTimeEnd']){//拍卖中
		$json['time'] = strtotime($car['AuctionTimeEnd']) - time();	
		$json['title'] = "拍卖结束还有";
	}else{//拍卖已结束
		$json['time'] = 0;	
		$json['title'] = "拍卖已结束";
	}
/*-----------------买车页表单提交返回数据-------------------------------------------------------------*/
}else if(isset($_POST['searchMinMoney'])){
	$MinMoney = $_POST['searchMinMoney'];//最小价格
	$MaxMoney = $_POST['searchMaxMoney'];//最大价格
	$where = "1=1";
	if(!empty($MinMoney)){
		$where .= "and price > '$MinMoney'";
	}
	if(!empty($MaxMoney)){
		$where .= "and price < '$MaxMoney'";
	}
//智能排序
	if($_GET['order'] == 'default'){
		$order = 'UpdateTime desc';
	}else if($_GET['order'] == 'newTime'){
		$order = 'time desc';
	}else if($_GET['order'] == 'priceLow'){
		$order = 'price asc';
	}else if($_GET['order'] == 'priceHeight'){
		$order = 'price desc';
	}else if($_GET['order'] == 'cardTime'){
		$order = 'RegisterTime desc';
	}else if($_GET['order'] == 'distanceLess'){
		$order = 'mileage asc';
	}else{
		$order = 'UpdateTime desc';
	}
//车辆列表
	$carSql = mysql_query(" select * from Car WHERE $where  order by {$order}");
	$carNum = mysql_num_rows(mysql_query("select * from Car WHERE $where "));
	$json['html'] = "";
	if($carNum == 0){
		$json['html'] = "一条车辆信息都没有";
	}else{
		while($array = mysql_fetch_assoc($carSql)){
			$Brand = query("Brand","id = '$array[BrandId]' ");
			$json['html'] .= "
			<li><a href='{$root}m/mCar.php?carMx_id={$array['id']}'>
				<img src='{$root}{$array['ico']}' alt='汽车图片' />
				<div class='inli1-right'>
					<p class='inli1-p1'>{$array['name']}</p>
					<p class='inli1-p2'>{$Brand['ModelYear']}年/{$array['mileage']}公里/{$Brand['GearBox']}</p>
					<p class='inli1-p3 red'>{$array['price']}万</p>
				</div>
			</a></li>
		";
		}
	}
/*-----------------车辆根据品牌返回子品牌-------------------------------------------------------------*/
}elseif(isset($_POST['BrandTypeSelect'])){
	$type = $_POST['BrandTypeSelect'];//车辆品牌
	$json['ColumnChild'] = IdOption("Brand where type = '$type' ","id","name","请选择劳务子项目","");
}
echo json_encode($json);
?>