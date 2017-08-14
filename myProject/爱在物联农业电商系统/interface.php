<?php
include "configure.php";
$where = "";
//身份验证
$adtel = $post['adtel'];//管理员手机号
$adpas = $post['adpas'];//管理员密码 传MD5加密的过来
$num = mysql_num_rows(mysql_query(" SELECT * FROM admin WHERE adtel = '$adtel' AND adpas = '$adpas' "));
if($num == 0){
	$warn = "身份验证未通过";
}
//订单
elseif ($get['type'] == 'order') {
	$form = "buycar";
	if(!empty($get['khid'])){
		$where .= " and khid = '$get[khid]' ";
	}
	if(!empty($get['goodsId'])){
		$where .= " and goodsId = '$get[goodsId]' ";
	}
	$finger = 1;
}
//客户
else if ($get['type'] == 'client') {
	$form = "kehu";	
	$finger = 1;
}
//商品一级分类查询
else if ($get['type'] == 'searchGoodsTypeOne') {
	$form = "goodsTypeOne";
	$finger = 1;
}
//商品二级分类查询
else if ($get['type'] == 'searchGoodsTypeTwo') {
	$form = "goodsTypeTwo";
	$finger = 1;
}
//商品查询
else if ($get['type'] == 'searchGoods') {
	$form = "goods";
	$finger = 1;
}
//商品规格查询
else if ($get['type'] == 'searchGoodsSku') {
	$form = "goodsSku";
	$finger = 1;
}
//商品轮播图查询
else if ($get['type'] == 'searchGoodsWin') {
	$form = "goodsWin";
	$finger = 1;
}
//商品一级分类
else if ($get['type'] == 'newGoodsTypeOne') {
	//赋值
	$id = $post['goodsTypeOneNameId']; //id
	$name = $post['goodsTypeOneName'];  //分类名称
	$list = $post['goodsTypeOneNameList'];  //排序号
	$xian = $post['goodsTypeOneNameShow']; //显示状态
	//判断
	if(empty($id)){
		$repeatName = mysql_num_rows(mysql_query(" SELECT * FROM goodsTypeOne WHERE name = '$name' "));
		if ($repeatName > 0){
			$warn = '商品一级分类“'.$name."”已经存在";
		} else {
			$id = suiji();
			$bool = mysql_query(" INSERT INTO goodsTypeOne (id, name, list, xian, updateTime, time)
			VALUES ('$id','$name','$list','$xian','$time','$time') ");
			if($bool){
				$warn = '商品一级分类添加成功';
			}else{
				$warn = '商品一级分类添加失败';
			}
		}
	}else{
		$bool = mysql_query(" UPDATE goodsTypeOne SET
		name = '$name',
		list = '$list',
		xian = '$xian',
	    updateTime = '$time' WHERE id = '$id' ");
        if($bool){
            $warn = "商品一级分类更新成功";
        }else{
            $warn = "商品一级分类更新失败";
        }	
	}
}
//商品二级分类
else if ($get['type'] == 'newGoodsTypeTwo') {
	//赋值
	$oneName = $post['oneName'];
	$oneSql = query("goodsTypeOne", "name = '$oneName' ");
	$oneId = $post['goodsTypeOne']; //一级id
	$name = $post['goodsTypeTwoName']; //分类名称
	$list = $post['goodsTypeTwoList']; //排序号
	$xian = $post['goodsTypeTwoShow']; //显示状态
	$id = $post['goodsTypeTwoId']; //id
	//判断
	if(empty($id)){
		$repeatName = mysql_num_rows(mysql_query(" SELECT * FROM goodsTypeTwo WHERE name = '$name' "));
		if ($repeatName > 0){
			$warn = '商品二级分类“'.$name."”已经存在";
		} else {
			$id = suiji();
			$bool = mysql_query(" INSERT INTO goodsTypeTwo (id, goodsTypeOneId, name, list, xian, updateTime, time)
			VALUES ('$id','$oneSql[id]','$name','$list','$xian','$time','$time') ");
			if($bool){
				$warn = '商品二级分类添加成功';
			}else{
				$warn = '商品二级分类添加失败';
			}
		}
	}else{
		$bool = mysql_query(" UPDATE goodsTypeTwo SET
		name = '$name',
		list = '$list',
		xian = '$xian',
	    updateTime = '$time' WHERE id = '$id' ");
        if($bool){
            $warn = "商品二级分类更新成功";
        }else{
            $warn = "商品二级分类更新失败";
        }	
	}
}
//商品
else if ($get['type'] == 'newGoods') {
	//赋值
	$oneName = $post['oneName'];//一级分类
	$oneSql = query("goodsTypeOne", "name = '$oneName' ");
	$twoName = $post['twoName'];//二级分类
	$twoSql = query("goodsTypeTwo", "name = '$twoName' ");
	$goodsName = $post['goodsName']; //商品名称
	$goodsTypeOneId = $post['goodsTypeOneId'];//一级分类
	$goodsTypeTwoId = $post['goodsTypeTwoId'];//二级分类
	$summary = $post['summary'];//摘要
	$promotion = $post['promotion'];//商品促销信息
	$parameter = $post['parameter'];//商品参数详情
	$price = $post['price'];//价格
	$priceMarket = $post['priceMarket'];//市场价格
	$salesVolume = $post['salesVolume'];//销量
	$publicGood = $post['publicGood'];  //是否为免费商品
	$number = $post['number'];  //领取次数
	$ico = $post['ico'];  //商品列表图片
	$list = $post['GoodsList'];//排序号
	$xian = $post['GoodsShow'];//状态
	$id = $post['goodsid'];//id
	//判断
	if(empty($id)){
		$repeatName = mysql_num_rows(mysql_query(" SELECT * FROM goods WHERE name = '$goodsName' "));
		if ($repeatName > 0){
			$warn = '商品“'.$goodsName."”已经存在";
		} else {
			$id = suiji();
			$bool = mysql_query(" INSERT INTO goods
			(id, goodsTypeOneId, goodsTypeTwoId, name, summary, promotion, agio, parameter, scareBuying, price, priceMarket, salesVolume, sellingToday, publicGood, number, ico, list, xian, updateTime, time)
			VALUES
			('$id','$oneSql[id]','$twoSql[id]','$goodsName','$summary','$promotion','$agio','$parameter','$scareBuying','$price','$priceMarket','$salesVolume','$sellingToday','$publicGood','$number','$ico','$list','$xian','$time','$time') ");
			if($bool){
				$warn = '商品添加成功';
			}else{
				$warn = '商品添加失败';
			}
		}
	}else{
		$bool = mysql_query(" UPDATE goods SET
		name = '$goodsName',
		summary = '$summary',
		promotion = '$promotion',
		parameter = '$parameter',
		scareBuying ='$scareBuying',
		price = '$price',
		priceMarket = '$priceMarket',
		salesVolume = '$salesVolume',
		sellingToday = '$sellingToday',
		publicGood = '$publicGood',
		number = '$number',
		list = '$list',
		xian = '$xian',
	    updateTime = '$time' WHERE id = '$id' ");
		if($bool){
			$warn = "商品更新成功";
		}else{
			$warn = "商品更新失败";
		}
	}
}
//商品规格
else if ($get['type'] == 'newGoodsSku') {
	//赋值
	$goodsName = $post['goodsName'];//商品名称
	$goodsNameSql = query("goods", "name = '$goodsName' ");
	$GoodsId = $post['GoodsId'];//商品id
	$goods = query("goods"," id = '$goodsNameSql[id]' ");
	$specName = $post['specName'];//规格名称
	$specPrice = $post['specPrice'];//规格单价
	$priceMarket = $post['priceMarket'];//规格市场价
	$specNumber = $post['specNumber'];//库存
	$skuNum = $post['skuNumber'];//货号
	$skuSeat = $post['skuSeat'];//货位信息
	$factory = $post['factory'];//货位信息
	$specId = $post['specId'];//规格id
	if(empty($specId)){
		//判断
		$repeatName = mysql_num_rows(mysql_query(" SELECT * FROM goodsSku WHERE goodsId = '$goodsNameSql[id]' "));
		if ($repeatName > 0){
			$warn = "已经存在此商品规格";
		} else {
			$specId = suiji();
			$bool = mysql_query(" INSERT INTO goodsSku
 			(id,skuNum,goodsId,name,number,salesVolume,price,priceMarket,skuSeat,factory,updateTime,time)
		    values
		    ('$specId','$skuNum','$goodsNameSql[id]','$specName','$specNumber','$goods[salesVolume]','$specPrice','$priceMarket','$skuSeat','$factory','$time','$time')
		    ");
			if($bool){
				$warn = '商品规格添加成功';
			}else{
				$warn = '商品规格添加失败';
			}
		}
	}else{
		$bool = mysql_query(" UPDATE goodsSku SET
		skuNum = '$skuNum',
		name = '$specName',
		number = '$specNumber',
		price = '$specPrice',
		priceMarket = '$priceMarket',
		skuSeat = '$skuSeat',
		factory = '$factory',
	    updateTime = '$time' WHERE id = '$specId' ");
		if($bool){
			$warn = "商品规格更新成功";
		}else{
			$warn = "商品规格更新失败";
		}
	}
}
//商品轮播图
else if ($get['type'] == 'newGoodsWin') {
	//赋值
	$id = $post['imgId'];//商品轮播图id
	$goodsName = $post['goodsName'];//商品名称
	$goodsNameSql = query("goods", "name = '$goodsName' ");
	$GoodsId = $post['GoodsId'];//商品id
	$src = $post['src'];//商品轮播图
	//判断
	if(empty($id)){
		$id = suiji();
		$bool = mysql_query(" INSERT INTO goodsWin
 		(id,goodsId,src,time)
		  values
		  ('$id','$goodsNameSql[id]','$src','$time')
		  ");
		if($bool){
			$warn = '商品轮播图添加成功';
		}else{
			$warn = '商品轮播图添加失败';
		}
	}else{
		$bool = mysql_query(" UPDATE goodsWin SET
		src = '$src',
	    WHERE id = '$id' ");
		if($bool){
			$warn = "商品轮播图更新成功";
		}else{
			$warn = "商品轮播图更新失败";
		}
	}
}
//订单管理
else if ($get['type'] == 'newBuyCar') {
	//赋值
	$khid = $post['khid'];//客户id
	$goodsName = $post['goodsName'];//商品名称
	$goodsNameSql = query("goods", "name = '$goodsName' ");
	$goodsId = $post['goodsId'];//商品表id
	$goodsSkuName = $post['goodsSkuName'];//商品规格名称
	$goodsSkuNameSql = query("goodsSku", "name = '$goodsSkuName' ");
	$goodsSkuId = $post['goodsSkuId'];//商品规格id
	$province = $post['province'];//省份
	$city = $post['city'];//城市
	$area = $post['area'];//区域
	$areaSql = query("region", "province = '$province' AND city = '$city' AND area = '$area' ");
	$regionId = $post['regionId'];//region表id
	$goodsName = $post['goodsName'];//商品名称
	$goodsSkuName = $post['goodsSkuName'];//商品规格名称
	$addressName = $post['addressName'];//收件人姓名
	$addressTel = $post['addressTel'];//收件人电话
	$addressMx = $post['addressMx'];//详细地址
	$buyNumber = $post['buyNumber'];//购买数量
	$buyPrice = $post['buyPrice'];//商品单价
	$WorkFlow = $post['WorkFlow'];//订单流（未选定/已选定/已付款/已发货/已收货/已评价/已退货）
	$shipmentNum = $post['shipmentNum'];//物流单号
	$logisticsName = $post['logisticsName'];//物流公司
	$payTime = $post['payTime'];//付款时间
	//添加
	$id = suiji();
	$bool = mysql_query(" INSERT INTO buycar
	(id, khid, goodsId, goodsSkuId, regionId, goodsName, goodsSkuName, addressName, addressTel, addressMx, buyNumber, buyPrice, WorkFlow, shipmentNum, logisticsName, payTime, updateTime, time)
	  values
	  ('$id', '$khid', '$goodsNameSql[id]', '$goodsSkuNameSql[id]', '$areaSql[id]', '$goodsName', '$goodsSkuName', '$addressName', '$addressTel', '$addressMx', '$buyNumber', '$buyPrice', '$WorkFlow', '$shipmentNum', '$logisticsName', '$payTime', '$time', '$time' )
	  ");
	if($bool){
		$warn = '订单添加成功';
	}else{
		$warn = '订单添加失败';
	}
}
else{
	$finger = 2;	
}
//排序
if(empty($get['orderBy'])) {
	$orderBy = ' order by time DESC';	
}	
else {
	if($get['orderDirection'] == "desc"){
		$orderDirection = " desc ";
	}else{
		$orderDirection = "";
	}
	$orderBy = " order by {$get['orderBy']} {$orderDirection} ";
}
if($finger == 2){
	$warn = "未知数据表";
}else if($finger == 1){
	if(!empty($get['limitStart']) and !empty($get['limitEnd'])){
		$limit = " limit {$get['limitStart']},{$get['limitEnd']} ";
	}
	$sql = mysql_query("SELECT * FROM {$form} WHERE 1=1 {$where} {$orderBy} {$limit} ");
	$json = array();
	$num = mysql_num_rows($sql);
	if($num == 0){
		$warn = "一条数据都没有";
	}else{
		while ($array = mysql_fetch_assoc($sql)) {
			$json[] = $array;
		}
		$warn = json_encode($json);
	}
}
echo $warn;
?>