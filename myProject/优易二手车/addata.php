<?php
include "adfunction.php";
if($ControlFinger == 2){
	$json['warn'] = $ControlWarn;
	/*-----------------车辆管理-新建或更新车辆品牌基本资料-------------------------------------------------------------*/
}elseif(isset($_POST['adBrandId']) and isset($_POST['BrandType'])){
	//赋值
	$id = $_POST['adBrandId'];//车辆品牌ID
	$type = $_POST['BrandType'];//车辆品牌
	$name = $_POST['BrandName'];//车辆子品牌
	$ModelYear = $_POST['BrandModelYear'];//年款
	$MotorcycleType = $_POST['BrandMotorcycleType'];//车辆型号
	$guidancePrice = $_POST['BrandguidancePrice']; //厂商指导价
	$CarType = $_POST['BrandCarType'];//车辆类型
	$OutputVolume = $_POST['BrandOutputVolume'];//排量
	$horsepower = $_POST['Brandhorsepower'];//马力
	$Intake = $_POST['BrandIntake']; //进气形式
	$GearBox = $_POST['BrandGearBox']; //变速箱
	$bodySize = $_POST['BrandbodySize']; //车身尺寸
	$bodywork = $_POST['Brandbodywork']; //车身结构
	$seating = $_POST['Brandseating']; //座位数
	$oil = $_POST['Brandoil'];  //工信部综合油耗(L/100km)
	$engineTechnology = $_POST['BrandengineTechnology'];  //发动机特有技术
	$engineTechnology = implode('，',$engineTechnology);

	$fuel = $_POST['Brandfuel'];  //燃料形式
	$oilSupplyMode = $_POST['BrandoilSupplyMode'];  //供油方式

	$environmentalStandards = $_POST['BrandenvironmentalStandards'];  //环保标准
	$driveMode = $_POST['BranddriveMode'];  //驱动方式
	$steeringWheelAssist = $_POST['BrandsteeringWheelAssist'];  //方向盘助力

	$suspensionTypeFront = $_POST['BrandsuspensionTypeFront']; //前悬架类型
	$suspensionTypeBack = $_POST['BrandsuspensionTypeBack']; //后悬架类型

	$brakeTypeFront = $_POST['BrandbrakeTypeFront'];  //前制动器类型
	$brakeTypeBack = $_POST['BrandbrakeTypeBack'];  //后制动器类型

	$parkingBrakeType = $_POST['BrandparkingBrakeType'];  //驻车制动类型
	//多选部分
	$safetyEquipment = $_POST['BrandsafetyEquipment'];  //安全装备
	$safetyEquipment = implode('，',$safetyEquipment);

	$controlConfiguration = $_POST['BrandcontrolConfiguration'];  //操控配置
	$controlConfiguration = implode('，',$controlConfiguration);

	$externalConfiguration = $_POST['BrandexternalConfiguration'];  //外部配置
	$externalConfiguration = implode('，',$externalConfiguration);

	$internalConfiguration = $_POST['BrandinternalConfiguration'];  //内部配置
	$internalConfiguration = implode('，',$internalConfiguration);

	$seatConfiguration = $_POST['BrandseatConfiguration'];  //座椅
	$seatConfiguration = implode('，',$seatConfiguration);

	$multimediaConfiguration = $_POST['BrandmultimediaConfiguration'];  //多媒体配置
	$multimediaConfiguration = implode('，',$multimediaConfiguration);

	$lightingConfiguration = $_POST['BrandlightingConfiguration'];  //灯光
	$lightingConfiguration = implode('，',$lightingConfiguration);

	$glassAndRearviewMirror = $_POST['BrandglassAndRearviewMirror'];  //玻璃
	$glassAndRearviewMirror = implode('，',$glassAndRearviewMirror);

	$airConditioningAndRefrigerator = $_POST['BrandairConditioningAndRefrigerator'];  //空调/冰箱
	$airConditioningAndRefrigerator = implode('，',$airConditioningAndRefrigerator);

	$HighTechConfiguration = $_POST['BrandHighTechConfiguration'];  //高科技配置
	$HighTechConfiguration = implode('，',$HighTechConfiguration);

	$BrandColor = $_POST['BrandColor'];  //车色
	//$color = implode('，',$BrandColor);
	$color = $BrandColor;
	$Nation = $_POST['BrandNation'];//国别
	$xian = $_POST['BrandShow'];//显示状态
	$list = $_POST['BrandSort'];//排序号
	//判断
	if(strstr($adDuty['Power'],"车辆管理") == false){
		$json['warn'] = "权限不足";
	}elseif(empty($type)){
		$json['warn'] = "请选择品牌";
	}elseif(empty($name)){
		$json['warn'] = "请选择子品牌";
	}elseif(empty($ModelYear)){
		$json['warn'] = "请选择年款";
	}elseif(empty($MotorcycleType)){
		$json['warn'] = "请填写车辆型号";
	}elseif(empty($guidancePrice)){
		$json['warn'] = "请输入厂商指导价";
	}elseif(empty($CarType)){
		$json['warn'] = "请选择车辆类型";
	}elseif(empty($GearBox)){
		$json['warn'] = "请选择变速箱";
	}elseif(empty($OutputVolume)){
		$json['warn'] = "请选择排量";
	}elseif (empty($horsepower)) {
		$json['warn'] = "请输入马力";
	}elseif(empty($Intake)){
		$json['warn'] = "请选择进气形式";
	}elseif(empty($bodySize)){
		$json['warn'] = "请选择车身尺寸";
	}elseif(empty($seating)){
		$json['warn'] = "请选择座位数";
	}elseif(empty($bodywork)){
		$json['warn'] = "请选择车身结构";
	}// elseif(empty($oil)){
	//     $json['warn'] = "请填写工信部综合油耗(L/100km)";
	// }elseif(empty($engineTechnology)){
	//     $json['warn'] = "请选择发动机特有技术";
	// }
	elseif(empty($fuel)){
		$json['warn'] = "请选择燃料形式";
	}elseif(empty($oilSupplyMode)){
		$json['warn'] = "请选择供油方式";
	}elseif(empty($environmentalStandards)){
		$json['warn'] = "请选择环保标准";
	}elseif(empty($steeringWheelAssist)){
		$json['warn'] = "请选择方向盘助力";
	}elseif(empty($suspensionTypeFront)){
		$json['warn'] = "请选择前悬挂类型";
	}elseif(empty($suspensionTypeBack)){
		$json['warn'] = "请选择后悬挂类型";
	}elseif(empty($brakeTypeFront)){
		$json['warn'] = "请选择前制动器类型";
	}elseif(empty($brakeTypeBack)){
		$json['warn'] = "请选择后制动器类型";
	}elseif(empty($parkingBrakeType)){
		$json['warn'] = "请选择驻车制动类型";
	}//elseif(empty($safetyEquipment)){
	//     $json['warn'] = "请选择安全装备";
	// }elseif(empty($controlConfiguration)){
	//     $json['warn'] = "请选择操控配置";
	// }elseif(empty($externalConfiguration)){
	//     $json['warn'] = "请选择外部配置";
	// }elseif(empty($internalConfiguration)){
	//     $json['warn'] = "请选择内部配置";
	// }elseif(empty($seatConfiguration)){
	//     $json['warn'] = "请选择座椅";
	// }elseif(empty($multimediaConfiguration)){
	//     $json['warn'] = "请选择多媒体配置";
	// }elseif(empty($lightingConfiguration)){
	//     $json['warn'] = "请选择灯光";
	// }elseif(empty($glassAndRearviewMirror)){
	//     $json['warn'] = "请选择玻璃";
	// }elseif(empty($airConditioningAndRefrigerator)){
	//     $json['warn'] = "请选择空调/冰箱";
	// }elseif(empty($HighTechConfiguration)){
	//     $json['warn'] = "请选择高科技配置";
	// }
	// elseif(empty($color)){
	//     $json['warn'] = "请选择车色";
	// }
	elseif(empty($Nation)){
		$json['warn'] = "请选择国别";
	}elseif(empty($xian)){
		$json['warn'] = "请定义前端状态";
	}elseif(empty($list)){
		$json['warn'] = "请填写排序号";
	}elseif(empty($id)){
		$id = suiji();
		$bool = mysql_query("insert into Brand(id,type,name,ModelYear,MotorcycleType,guidancePrice,Nation,CarType,OutputVolume,horsepower,Intake,GearBox,bodySize,seating,bodywork,oil,engineTechnology,fuel,oilSupplyMode,environmentalStandards,driveMode,steeringWheelAssist,suspensionTypeFront,suspensionTypeBack,brakeTypeFront,brakeTypeBack,parkingBrakeType,safetyEquipment,controlConfiguration,externalConfiguration,internalConfiguration,seatConfiguration,multimediaConfiguration,lightingConfiguration,glassAndRearviewMirror,airConditioningAndRefrigerator,HighTechConfiguration,color,xian,list,adid,UpdateTime,time) values ('$id', '$type', '$name', '$ModelYear', '$MotorcycleType', '$guidancePrice', '$Nation', '$CarType', '$OutputVolume', '$horsepower', '$Intake', '$GearBox', '$bodySize', '$seating', '$bodywork', '$oil', '$engineTechnology', '$fuel', '$oilSupplyMode', '$environmentalStandards', '$driveMode', '$steeringWheelAssist','$suspensionTypeFront', '$suspensionTypeBack' , '$brakeTypeFront', '$brakeTypeBack', '$parkingBrakeType', '$safetyEquipment', '$controlConfiguration', '$externalConfiguration', '$internalConfiguration', '$seatConfiguration', '$multimediaConfiguration', '$lightingConfiguration', '$glassAndRearviewMirror', '$airConditioningAndRefrigerator', '$HighTechConfiguration','$color', '$xian', '$list','$Control[adid]', '$time', '$time')");
		if($bool){
			$_SESSION['warn'] = "品牌基本资料新增成功";
			LogText("车辆管理",$Control['adid'],"管理员{$Control['adname']}新增了车辆品牌（品牌名称：{$name}，品牌ID：{$id}）");
			$json['warn'] = 2;
		}else{
			$json['warn'] = "品牌基本资料新增失败";
		}
	}else if($adDuty['name'] != "超级管理员"){
		$json['warn'] = "无此权限，只有超级管理员才能修改。";
	}else{
		$Gift = query("Brand"," id = '$id' ");
		if($Gift['id'] != $id){
			$json['warn'] = "本品牌未找到";
		}else{
			$bool = mysql_query(" update Brand set
                id='$id',
                type='$type',
                name='$name',
                ModelYear='$ModelYear',
                MotorcycleType='$MotorcycleType',
                guidancePrice='$guidancePrice',
                Nation='$Nation',
                CarType='$CarType',
                OutputVolume='$OutputVolume',
                horsepower='$horsepower',
                Intake='$Intake',
                GearBox='$GearBox',
                bodySize='$bodySize',
                seating='$seating',
                bodywork='$bodywork',
                oil='$oil',
                engineTechnology='$engineTechnology',
                fuel='$fuel',
                oilSupplyMode='$oilSupplyMode',
                environmentalStandards='$environmentalStandards',
                driveMode='$driveMode',
                steeringWheelAssist='$steeringWheelAssist',
                suspensionTypeFront = '$suspensionTypeFront',
                suspensionTypeBack = '$suspensionTypeBack',
                brakeTypeFront = '$brakeTypeFront',
                brakeTypeBack = '$brakeTypeBack',
                parkingBrakeType='$parkingBrakeType',
                safetyEquipment='$safetyEquipment',
                controlConfiguration='$controlConfiguration',
                externalConfiguration='$externalConfiguration',
                internalConfiguration='$internalConfiguration',
                seatConfiguration='$seatConfiguration',
                multimediaConfiguration='$multimediaConfiguration',
                lightingConfiguration='$lightingConfiguration',
                glassAndRearviewMirror='$glassAndRearviewMirror',
                airConditioningAndRefrigerator='$airConditioningAndRefrigerator',
                HighTechConfiguration='$HighTechConfiguration',
                color = '$color',
                xian='$xian',
                list='$list',
                adid = '$Control[adid]',
                UpdateTime='$time',
                time='$time' where id = '$id' ");
			if($bool){
				$_SESSION['warn'] = "品牌基本资料更新成功";
				LogText("车辆管理",$Control['adid'],"管理员{$Control['adname']}更新了车辆品牌基本信息（品牌名称：{$name}，品牌ID：{$id}）");
				$json['warn'] = 2;
			}else{
				$json['warn'] = "品牌基本资料更新失败";
			}
		}
	}
	$json['href'] = root."control/adCarBrandMx.php?id=".$id;
	/*-----------------车辆管理-新建或更新车辆基本资料-------------------------------------------------------------*/
}elseif($_GET['act'] == "adcarmx" ){
	//赋值
	$id = $_POST['adCarId'];//车辆ID
	$BrandId = $_POST['BrandMotorcycleType'];//车型
	//$name = $_POST['CarName'];//名称
	$colour = $_POST['CarColour'];//颜色
	$mileage = $_POST['CarMileage'];//行驶里程
	$text = $_POST['CarText'];//补充说明
	$price = $_POST['CarPrice'];//价格
	$vin = $_POST['CarVin'];//车架号
	$auction = $_POST['CarAuction'];//是否拍卖
	$auctionMoney = $_POST['CarauctionMoney']; //拍卖诚意金
	$AuctionTimeStart = $_POST['StartYear']."-".$_POST['StartMoon']."-".$_POST['StartDay']." ".$_POST['StartHour'].":".$_POST['StartMinute'];//拍卖开始时间
	$AuctionTimeEnd = $_POST['EndYear']."-".$_POST['EndMoon']."-".$_POST['EndDay']." ".$_POST['EndHour'].":".$_POST['EndMinute'];//拍卖结束时间
	$RegionId = $_POST['area'];//看车地区
	$RegisterTime = $_POST['year']."-".$_POST['moon']."-".$_POST['day'];//首次上牌时间
	$roadFee = $_POST['roadfeeyear']."-".$_POST['roadfeemoon']."-".$_POST['roadfeeday'];//路桥费到期时间
	$compulsoryInsurance = $_POST['compyear']."-".$_POST['compmoon']."-".$_POST['compday'];//商业险到期时间
	$commercialInsurance = $_POST['commyear']."-".$_POST['commmoon']."-".$_POST['commday'];//交强险到期时间
	//判断
	if(strstr($adDuty['Power'],"车辆管理") == false){
		$json['warn'] = "权限不足";
	}elseif(empty($BrandId)){
		$json['warn'] = "请选择品牌";
	}elseif(empty($colour)){
		$json['warn'] = "请选择颜色";
	}elseif(empty($mileage)){
		$json['warn'] = "请填写行驶里程";
	}elseif(empty($text)){
		$json['warn'] = "请填写补充说明";
	}elseif(empty($price)){
		$json['warn'] = "请填写价格";
	}elseif(empty($vin)){
		$json['warn'] = "请填写车架号";
	}elseif(empty($auction)){
		$json['warn'] = "请选择是否拍卖";
	}elseif($auction == "是"){
		if(empty($auctionMoney)){
			$json['warn'] = "请输入拍卖诚意金";
		}elseif(empty($AuctionTimeStart) || $AuctionTimeStart == "-- :"){
			$json['warn'] = "请选择拍卖开始时间";
		}elseif(empty($AuctionTimeEnd) || $AuctionTimeEnd == "-- :"){
			$json['warn'] = "请选择拍卖结束时间";
		}
	}elseif(empty($RegionId)){
		$json['warn'] = "请选择看车地区";
	}elseif(empty($RegisterTime)){
		$json['warn'] = "请选择首次上牌时间";
	}elseif(empty($roadFee)){
		$json['warn'] = "请选择路桥费到期时间";
	}elseif(empty($compulsoryInsurance)){
		$json['warn'] = "请选择商业险到期时间";
	}elseif(empty($commercialInsurance)){
		$json['warn'] = "请选择交强险到期时间";
	}elseif(empty($id)){
		$id = suiji();
		$bool = mysql_query("insert into Car
            (id,BrandId,colour,mileage,text,price,vin,auctionMoney,AuctionTimeStart,AuctionTimeEnd,roadFee,compulsoryInsurance,commercialInsurance,auction,RegionId,RegisterTime,UpdateTime,time)
            values
            ('$id','$BrandId','$colour','$mileage','$text','$price','$vin','$auctionMoney','$AuctionTimeStart','$AuctionTimeEnd','$roadFee','$compulsoryInsurance','$commercialInsurance','$auction','$RegionId','$RegisterTime','$time','$time') ");
		if($bool){
			$_SESSION['warn'] = "车辆基本资料新增成功";
			LogText("车辆管理",$Control['adid'],"管理员{$Control['adname']}新增了车辆（车辆ID：{$id}）");
			$json['warn'] = 2;
		}else{
			$json['warn'] = "车辆基本资料新增失败";
		}
	}else{
		$Car = query("Car"," id = '$id' ");
		if($Car['id'] != $id){
			$json['warn'] = "本车辆未找到";
		}else{
			$bool = mysql_query(" update Car set
            BrandId = '$BrandId',
            colour = '$colour',
            mileage = '$mileage',
            text = '$text',
            price = '$price',
            vin = '$vin',
            roadFee = '$roadFee',
            compulsoryInsurance = '$compulsoryInsurance',
            commercialInsurance = '$commercialInsurance',
            auctionMoney = '$auctionMoney',
            AuctionTimeStart = '$AuctionTimeStart',
            AuctionTimeEnd = '$AuctionTimeEnd',
            auction = '$auction',
            RegionId = '$RegionId',
            RegisterTime = '$RegisterTime',
            UpdateTime = '$time' where id = '$id' ");
			if($bool){
				$_SESSION['warn'] = "车辆基本资料更新成功";
				LogText("车辆管理",$Control['adid'],"管理员{$Control['adname']}更新了车辆基本信息（车辆名称：{$name}，车辆ID：{$id}）");
				$json['warn'] = 2;
			}else{
				$json['warn'] = "车辆基本资料更新失败";
			}
		}
	}
	//判断是否为拍卖车辆
	if($auction == '是'){
		mysql_query("update Car set auction = '否' where id != '$id' ");
	}
	$json['href'] = root."control/adCarMx.php?id=".$id;
	/*-----------------商户管理-新建或更新商户基本资料-------------------------------------------------------------*/
}elseif(isset($_POST['adSellerId']) and isset($_POST['SellerName'])){
	//赋值
	$id = $_POST['adSellerId'];//商户ID
	$name = $_POST['SellerName'];//商家名称
	$agio = $_POST['SellerAgio']; //商家折扣
	$setel = $_POST['SellerSetel'];//负责人电话
	$RegionId = $_POST['area'];//所属区域
	$address = $_POST['SellerAddress'];//详细地址
	$longitude = $_POST['longitude']; //经度
	$latitude = $_POST['latitude']; //纬度
	//判断
	if(strstr($adDuty['Power'],"车辆管理") == false){
		$json['warn'] = "权限不足";
	}elseif(empty($name)){
		$json['warn'] = "请填写商家名称";
	}elseif(empty($setel)){
		$json['warn'] = "请填写负责人电话";
	}elseif(empty($agio)){
		$json['warn'] = "请输入商家折扣";
	}elseif(empty($RegionId)){
		$json['warn'] = "请选择所属区域";
	}elseif(empty($address)){
		$json['warn'] = "请填写详细地址";
	}elseif(empty($longitude)){
		$json['warn'] = "X坐标不不能为空" ;
	}elseif(empty($latitude)){
		$json['warn'] = "Y坐标不不能为空" ;
	}elseif(empty($id)){
		$id = suiji();
		$bool = mysql_query(" insert into seller
        (seid,name,agio,setel,RegionId,address,longitude,latitude,UpdateTime,time)
        values
        ('$id','$name','$agio','$setel','$RegionId','$address','$longitude','$latitude','$time','$time') ");
		if($bool){
			$_SESSION['warn'] = "商户基本资料新增成功";
			LogText("商户管理",$Control['adid'],"管理员{$Control['adname']}新增了商户（商户名称：{$name}，商户ID：{$id}）");
			$json['warn'] = 2;
		}else{
			$json['warn'] = "商户基本资料新增失败";
		}
	}else{
		$Seller = query("seller"," seid = '$id' ");
		if($Seller['seid'] != $id){
			$json['warn'] = "本商户未找到";
		}else{
			$bool = mysql_query(" update seller set
            name = '$name',
            agio = '$agio',
            setel = '$setel',
            RegionId = '$RegionId',
            address = '$address',
            longitude = '$longitude',
            latitude = '$latitude',
            UpdateTime = '$time' where seid = '$id' ");
			if($bool){
				$_SESSION['warn'] = "商户基本资料更新成功";
				LogText("商户管理",$Control['adid'],"管理员{$Control['adname']}更新了商户基本信息（商户名称：{$name}，商户ID：{$id}）");
				$json['warn'] = 2;
			}else{
				$json['warn'] = "商户基本资料更新失败";
			}
		}
	}
	$json['href'] = root."control/adSellerMx.php?id=".$id;
	/*-----------------商户管理-新建或更新商户员工基本资料-------------------------------------------------------------*/
}elseif(isset($_POST['adSellerStaffId']) and isset($_POST['SellerStaffName'])){
	//赋值
	$id = $_POST['adSellerStaffId'];//商户员工ID
	$seid = $_POST['sellerName'];//商户ID/名称
	$name = $_POST['SellerStaffName'];//员工姓名
	$tel = $_POST['SellerStaffTel'];//员工手机号码
	$OpenId = $_POST['SellerStaffOpenId'];//本员工的微信OpenId
	//判断
	if(strstr($adDuty['Power'],"商户管理") == false){
		$json['warn'] = "权限不足";
	}elseif(empty($seid)){
		$json['warn'] = "请选择商户名称";
	}elseif(empty($name)){
		$json['warn'] = "请填写员工姓名";
	}elseif(empty($tel)){
		$json['warn'] = "请填写员工手机号码";
	}elseif(empty($OpenId)){
		$json['warn'] = "请填写本员工的微信OpenId";
	}elseif(empty($id)){
		$id = suiji();
		$bool = mysql_query(" insert into SellerStaff
        (id,seid,name,tel,OpenId,UpdateTime,time)
        values
        ('$id','$seid','$name','$tel','$OpenId','$time','$time') ");
		if($bool){
			$_SESSION['warn'] = "员工基本资料新增成功";
			LogText("商户管理",$Control['adid'],"管理员{$Control['adname']}新增了商户员工（员工名称：{$name}，员工ID：{$id}）");
			$json['warn'] = 2;
		}else{
			$json['warn'] = "员工基本资料新增失败";
		}
	}else{
		$SellerStaff = query("SellerStaff"," id = '$id' ");
		if($SellerStaff['id'] != $id){
			$json['warn'] = "本员工未找到";
		}else{
			$bool = mysql_query(" update SellerStaff set
            seid = '$seid',
            name = '$name',
            tel = '$tel',
            OpenId = '$OpenId',
            UpdateTime = '$time' where id = '$id' ");
			if($bool){
				$_SESSION['warn'] = "员工基本资料更新成功";
				LogText("商户管理",$Control['adid'],"管理员{$Control['adname']}更新了商户员工基本信息（员工名称：{$name}，员工ID：{$id}）");
				$json['warn'] = 2;
			}else{
				$json['warn'] = "员工基本资料更新失败";
			}
		}
	}
	$json['href'] = root."control/adSellerStaffMx.php?id=".$id;
	/*-----------------车辆管理-根据品牌返回子品牌-------------------------------------------------------------*/
}else if(isset($_POST['BrandTypeGetName'])){
	//赋值
	$type = $_POST['BrandTypeGetName'];//品牌
	$json['name'] = RepeatOption("Brand where type = '$type'","name","--选择--","");
	/*-----------------车辆管理-根据品牌，子品牌返回年限-------------------------------------------------------------*/
}else if(isset($_POST['BrandNameGetModelYear'])){
	//赋值
	$type = $_POST['BrandTypeGetModelYear'];//品牌
	$name = $_POST['BrandNameGetModelYear'];//子品牌
	$json['ModelYear'] = RepeatOption("Brand where type = '$type' and name = '$name'","ModelYear","--选择--","");
	/*-----------------车辆管理-根据品牌，子品牌,年限返回车型-------------------------------------------------------------*/
}else if(isset($_POST['BrandModelYearGetMotorcycleType'])){
	//赋值
	$type = $_POST['BrandTypeGetMotorcycleType'];//品牌
	$name = $_POST['BrandNameGetMotorcycleType'];//子品牌
	$ModelYear = $_POST['BrandModelYearGetMotorcycleType'];//年限
	$json['MotorcycleType'] = IdOption("Brand where type = '$type' and name = '$name' and ModelYear = '$ModelYear' ","id","MotorcycleType","--选择--","");
}elseif(isset($_POST['BrandId'])){ //根据车型ID获取车色
	$BrandId = $_POST['BrandId']; //返回的ID
	$Brand =query("Brand","id ='$BrandId'");
	$json['CarColour'] = option("--选择--",explode("，", $Brand['color']),"");

	/*-----------------客户管理-更新客户积分----------------------------------------------------*/
}else if(isset($_POST['kehuIntegral']) and isset($_POST['adClientId'])){
	//赋值
	$id = $_POST['adClientId'];//客户ID
	$integral = $_POST['kehuIntegral'];// 积分操作
	//判断
	if(strstr($adDuty['Power'],"客户管理") == false){
		$json['warn'] = "权限不足";
	}else if(empty($_POST['kehuIntegral'])){
		$json['warn'] = "积分不能为空".$_POST['kehuIntegral'];
	}else{
		$kehu = query("kehu"," khid = '$id' ");
		if($kehu['khid'] != $id){
			$json['warn'] = "该客户未找到";
		}else{
			$bool = mysql_query(" update kehu set
            integral = integral +'$integral',
            UpdateTime = '$time' where khid = '$id' ");
			if($bool){
				$_SESSION['warn'] = "客户积分更新成功";
				LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}更新了客户积分（客户ID：{$id}）");
				$json['warn'] = 2;
			}else{
				$json['warn'] = "客户基本资料更新失败";
			}
		}
	}
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
		//客户
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
				//删除客户活动报名
				mysql_query("delete from Enroll where khid = '$id'");
				//删除客户谁看过我或者谁关注我
				mysql_query("delete from follow where khid = '$id'");
				//删除客户送礼物
				mysql_query("delete from GiftGive where khid = '$id'");
				//删除客户我的相册
				$kehuImgSql = mysql_query(" select * from kehuImg where khid = '$id' ");
				while($kehuImg = mysql_fetch_assoc($kehuImgSql)){
					unlink(ServerRoot.$kehuImg['src']);
				}
				mysql_query("delete from kehuImg where khid = '$id'");
				//删除客户私信
				mysql_query("delete from message where khid = '$id'");
				//删除客户预支付记录
				mysql_query("delete from pay where khid = '$id'");
				//删除客户头像
				unlink(ServerRoot.$kehu['ico']);
				//最后删除本客户基本资料
				mysql_query("delete from kehu where khid = '$id'");
				//添加日志
				LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}删除了客户（客户微信名：{$kehu['NickName']}，客户ID：{$kehu['khid']}）");
				$x++;
			}
			$_SESSION['warn'] = "删除了{$x}个客户";
			$json['warn'] = 2;
		}
		//车辆品牌管理
	}elseif($type == "DeleteBrand"){
		$Array = $_POST['BrandList'];
		if($adDuty['name'] != "超级管理员"){
			$json['warn'] = "只有超级管理员才能删除品牌";
		}elseif(empty($Array)){
			$json['warn'] = "您一个品牌都没有选择呢";
		}else{
			foreach($Array as $id){
				//查询本品牌基本信息
				$Brand = query("Brand"," id = '$id' ");
				//删除品牌车辆
				mysql_query("delete from Car where BrandId = '$id'");
				//删除本品牌
				mysql_query("delete from Brand where id = '$id'");
				//添加日志
				LogText("品牌管理",$Control['adid'],"管理员{$Control['adname']}删除了品牌（品牌名称：{$Brand['type']}，品牌ID：{$Brand['id']}）");
				$x++;
			}
			$_SESSION['warn'] = "删除了{$x}个品牌";
			$json['warn'] = 2;
		}
		//车辆管理
	}elseif($type == "DeleteCar"){
		$Array = $_POST['CarList'];
		if($adDuty['name'] != "超级管理员"){
			$json['warn'] = "只有超级管理员才能删除车辆";
		}elseif(empty($Array)){
			$json['warn'] = "您一个车辆都没有选择呢";
		}else{
			foreach($Array as $id){
				//查询本车辆基本信息
				$Car = query("Car"," id = '$id' ");
				//删除行驶证扫描件
				unlink(ServerRoot.$Car['DrivingLicense']);
				//删除本车辆
				mysql_query("delete from Car where id = '$id'");
				//添加日志
				LogText("车辆管理",$Control['adid'],"管理员{$Control['adname']}删除了车辆（车辆名称：{$Car['name']}，车辆ID：{$Car['id']}）");
				$x++;
			}
			$_SESSION['warn'] = "删除了{$x}个车辆";
			$json['warn'] = 2;
		}
		//商户管理
	}elseif($type == "DeleteSeller"){
		$Array = $_POST['SellerList'];
		if($adDuty['name'] != "超级管理员"){
			$json['warn'] = "只有超级管理员才能删除商户";
		}elseif(empty($Array)){
			$json['warn'] = "您一个商户都没有选择呢";
		}else{
			foreach($Array as $id){
				//查询本商户基本信息
				$Seller = query("seller"," seid = '$id' ");
				//删除商户员工
				mysql_query("delete from SellerStaff where seid = '$id'");
				//删除本商户
				mysql_query("delete from seller where seid = '$id'");
				//添加日志
				LogText("商户管理",$Control['adid'],"管理员{$Control['adname']}删除了商户（商户名称：{$Seller['name']}，商户ID：{$Seller['seid']}）");
				$x++;
			}
			$_SESSION['warn'] = "删除了{$x}个商户";
			$json['warn'] = 2;
		}
		//商户员工管理
	}elseif($type == "DeleteSellerStaff"){
		$Array = $_POST['SellerStaffList'];
		if($adDuty['name'] != "超级管理员"){
			$json['warn'] = "只有超级管理员才能删除员工";
		}elseif(empty($Array)){
			$json['warn'] = "您一个员工都没有选择呢";
		}else{
			foreach($Array as $id){
				//查询本员工基本信息
				$SellerStaff = query("SellerStaff"," id = '$id' ");
				//删除本员工
				mysql_query("delete from SellerStaff where id = '$id'");
				//添加日志
				LogText("员工管理",$Control['adid'],"管理员{$Control['adname']}删除了员工（员工姓名：{$SellerStaff['name']}，员工ID：{$SellerStaff['id']}）");
				$x++;
			}
			$_SESSION['warn'] = "删除了{$x}个员工";
			$json['warn'] = 2;
		}
	}else{
		$json['warn'] = "未知执行指令";
	}

}
/*-----------------返回-------------------------------------------------------------*/
echo json_encode($json);
?>
