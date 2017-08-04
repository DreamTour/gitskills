<?php
include "adfunction.php";
ControlRoot();
foreach($_POST as $key => $value){
	$post[$key] = FormSubArray($value);
}
/****************客户管理-多条件模糊查询*****************************/
if($_GET['type'] == "selectClient"){
	//赋值
	$CompanyName = $post['CompanyName'];//公司名称
	$ContactName = $post['ContactName'];//联系人姓名
	$ContactTel = $post['ContactTel'];//联系人手机
	$labeMaking = $post['labeMaking'];//标牌制作
	$FollowType = $post['FollowType'];//客户性质
	$IndustryName = $post['name'];//客户行业ID号
	$adid = $post['adId'];//所属员工
	$valid = $post['valid'];//有效客户
	$areaId = $post['area'];//区域ID
	$sign = $post['sign'] ;//合同签订时/否
	$year1 = $post['year1'];//开始日期年
	$moon1 = $post['moon1'];//开始日期月
	$day1 = $post['day1'];//开始日期日
	$year2 = $post['year2'];//结束日期年
	$moon2 = $post['moon2'];//结束日期月
	$day2 = $post['day2'];//结束日期日
	$year3 = $post['year3'];
	$moon3 = $post['moon3'];
	$day3 = $post['day3'];
	$year4 = $post['year4'];
	$moon4 = $post['moon4'];
	$day4 = $post['day4'];
	$x = "";
	$array = array();
	$i = 1;
	$arrayStr = "";
	$slot = "";//时间段语句
	$regionSql = "";//区域语句
	$industrySql = "";//行业语句
	$adidSql = "";//所属员工语句
	$signSql = "";//合同签入语
	$labeMakingSql = "";
	//查询员工所属id号
	if(!empty($adid)){
		$adidSql = " and adid = '$adid' ";
		$x .= $adidSql;
	}
	if(!empty($CompanyName)){
		$x .= " and CompanyName like '%$CompanyName%' ";
	}
	if(!empty($ContactName)){
		$x .= " and ContactName like '%$ContactName%' ";
	}
	if(!empty($ContactTel)){
		$x .= " and ContactTel like '%$ContactTel%' ";
	}
	if(!empty($FollowType)){
		$x .= " and followType = '$FollowType' ";
	}
	//行业名称
	if(!empty($IndustryName)){
		$industrySql = " and industry in( select id from kehuIndustry
		where name = '$IndustryName') ";
		$x .= $industrySql;
	}
	if(!empty($labeMaking)){
		if($labeMaking != "全部" and $labeMaking != "暂无" ){
			$array = explode("、",$labeMaking);//拆分字符串
			foreach ($array as $val){
				if($i==1){
					$arrayStr .= "'".$val."'";
					$i++;
				}else{
					$arrayStr .= ",'".$val."'";
				}
			}
			$labeMakingSql = " and labeMaking in($arrayStr) and khid in ( SELECT khid FROM buycar WHERE sign = '已签入' and pay>0)";
		}elseif($labeMaking == "暂无"){
			$labeMakingSql = " and length(labeMaking)=0 and khid in ( SELECT khid FROM buycar WHERE sign = '已签入' and pay>0)";
		}else{
			$labeMakingSql = " and length(labeMaking)>0 and khid in ( SELECT khid FROM buycar WHERE sign = '已签入' and pay>0)";
		}
		$x .= $labeMakingSql;
	}
	//客户区域
	if(!empty($areaId) ){
		$regionSql = " and regionId = '$areaId' ";
		$x .= $regionSql;
	}
	//有效客户
	if(!empty($valid)){
		if($valid == "未设置"){
			$valid = "";
		}
		$x .= " and valid = '$valid' ";
	}
	//合同签订
	if(!empty($sign)){
		if($sign == '是'){
			$signSql =  " and khid in ( SELECT khid FROM buycar WHERE sign = '已签入')";
		}elseif($sign == '否'){
			$signSql = " and khid in ( SELECT khid FROM buycar WHERE sign != '已签入')";
		}
		$x .= $signSql;
	}
	//按照客户创建时间段查询
	if(!empty($year1) and !empty($moon1) and !empty($day1) and !empty($year2) and !empty($moon2) and !empty($day2) ){
		$startTime = $year1."-".$moon1."-".$day1;
		$endTime = $year2."-".$moon2."-".$day2;
		$slot = " and time between '{$startTime} 00:00:00'and '{$endTime} 23:59:59' ORDER BY time ASC ";
		$x .= $slot;
	}
	if(!empty($year3) and !empty($moon3) and !empty($day3) and !empty($year4) and !empty($moon4) and !empty($day4) ){
		$startTime1 = $year3."-".$moon3."-".$day3;
		$endTime1 = $year4."-".$moon4."-".$day4;
	}
	//返回
	$_SESSION['adClient'] = array(
		"CompanyName" => $CompanyName,
		"ContactName" => $ContactName,
		"ContactTel" => $ContactTel,
		"FollowType" => $FollowType,
		"IndustryName" => $IndustryName,
		"industrySql" => $industrySql,
		"adid" => $adid,
		"adidSql" => $adidSql,
		"valid" => $valid,
		"labeMaking"=>$labeMaking,
		"labeMakingSql"=>$labeMakingSql,
		"province" => $post['province'],
		"city" => $post['city'],
		"area" => $post['area'],
		"regionSql" => $regionSql,
		"sign" => $sign,
		"signSql" => $signSql,
		"startTime" => $startTime,
		"endTime" => $endTime,
		"startTime1" => $startTime1,
		"endTime1" => $endTime1,
		"slot" => $slot,
		"Sql" => $x);
	/****************客户管理-地址管理-多条件模糊查询*****************************/
}elseif($_GET['type'] == "searchClientAddress"){
	//赋值
	$province = $post['province'];//所属省份
	$city = $post['city'];//所属城市
	$area = $post['area'];//所属区域
	$adAddressMx = $post['adAddressMx'];//详细地址
	$adAddressName = $post['adAddressName'];//联系人姓名
	$adAddressTel = $post['adAddressTel'];//联系人手机
	$x = " ";
	//串联查询语句
	if(!empty($province)){
		if(empty($city)){
			$x .= " and RegionId in ( select id from region where province = '$province' ) ";
		}else{
			if(empty($area)){
				$x .= " and RegionId in ( select id from region where province = '$province' and city = '$city'  ) ";
			}else{
				$x .= " and RegionId = '$area' ";
			}
		}
	}
	if(!empty($adAddressMx)){
		$x .= " and AddressMx like '%$adAddressMx%' ";
	}
	if(!empty($adAddressName)){
		$x .= " and AddressName like '%$adAddressName%' ";
	}
	if(!empty($adAddressTel)){
		$x .= " and AddressTel like '%$adAddressTel%' ";
	}
	//返回
	$_SESSION['adClientAddress'] = array(
		"province" => $province,"city" => $city,"area" => $area,"adAddressMx" => $adAddressMx,"adAddressName" => $adAddressName,"adAddressTel" => $adAddressTel,"Sql" => $x);
	/****************客户管理-合同管理-多条件模糊查询*****************************/
}elseif($_GET['type'] == "seachOrder"){
	//赋值
	$name = $post['orderName'];//订单名称
	$identifier = $post['orderIdentifier'];
	$sign = $post['sign'];//流程状态
	$adId = $post['adId'];//所属员工
	$IndustryName = $post['name'];//客户行业ID号
	$areaId = $post['area'];//区域ID
	$year1 = $post['year1'];//签入日期年
	$moon1 = $post['moon1'];//签入日期月
	$day1 = $post['day1'];//签入日期日
	$year2 = $post['year2'];//签出日期年
	$moon2 = $post['moon2'];//签出日期月
	$day2 = $post['day2'];//签出日期日
	$year3 = $post['year3'];//审批日期年
	$moon3 = $post['moon3'];//审批日期月
	$day3 = $post['day3'];//审批日期日
	$year4 = $post['year4'];//到期日期年
	$moon4 = $post['moon4'];//到期日期月
	$day4 = $post['day4'];//到期日期日
	$year5 = $post['year5'];//创建日期年
	$moon5 = $post['moon5'];//创建日期月
	$day5 = $post['day5'];//创建日期日
	$x = " ";
	if(!empty($name)){
		$x .= " and name like '%$name%' ";
	}
	if(!empty($identifier)){
		$x .= " and identifier like '%$identifier%' ";
	}
	if(!empty($sign)){
		$x .= " and sign = '$sign' ";
	}
	if(!empty($adId)){
		$x .= " and adid like '%$adId%' ";
	}
	//行业名称
	if(!empty($IndustryName)){
		$x .= " and khid in( select khid from kehu
		where industry in (select id from kehuIndustry
		where name = '$IndustryName')) ";
	}
	//合同区域
	if(!empty($areaId) ){
		$x .= " and regionId = '$areaId' ";
	}
	//签入日期
	if(!empty($year1) and !empty($moon1) and !empty($day1) ){
		$signInDay = $year1."-".$moon1."-".$day1;
		$x .= " and signInDay = '$signInDay' ";
	}
	//签出日期
	if(!empty($year2) and !empty($moon2) and !empty($day2) ){
		$signOutDay = $year2."-".$moon2."-".$day2;
		$x .= " and signOutDay = '$signOutDay' ";
	}
	//审批日期
	if(!empty($year3) and !empty($moon3) and !empty($day3) ){
		$approvalTime = $year3."-".$moon3."-".$day3;
		$x .= " and approvalTime = '$approvalTime' ";
	}
	//合同到期日期
	if(!empty($year4) and !empty($moon4) and !empty($day4) ){
		$endTime = $year4."-".$moon4."-".$day4;
		$x .= " and endTime = '$endTime' ";
	}
	//合同创建日期
	if(!empty($year5) and !empty($moon5) and !empty($day5) ){
		$foundTime = $year5."-".$moon5."-".$day5;
		$x .= " and time = '$foundTime' ";
	}
	//返回
	$_SESSION['adOrder'] = array(
		"name" => $name,
		"identifier" => $identifier,
		"sign" => $sign,
		"adId" => $adId,
		"IndustryName" => $IndustryName,
		"province" => $post['province'],
		"city" => $post['city'],
		"area" => $post['area'],
		"signInDay" => $signInDay,
		"signOutDay" => $signOutDay,
		"approvalTime" => $approvalTime,
		"endTime" => $endTime,
		"time" => $foundTime,
		"Sql" => $x);

	/****************转运需求-多条件模糊查询*****************************/
}elseif($_GET['type'] == 'transport'){
	//赋值
	$urgent = $post['urgent'];//紧急程度
	$atate = $post['state'];//转运状态
	$year1 = $post['year1'];//开始年
	$moon1 = $post['moon1'];//开始月
	$day1 = $post['day1'];//开始日
	$year2 = $post['year2'];//结束年
	$moon2 = $post['moon2'];//结束月
	$day2 = $post['day2'];//结束日
	$x = "";//sql语句拼接
	$slot = '';//excel查询导出的时间段
	if(!empty($urgent)){
		$x .= " and urgent = '$urgent' ";
	}
	if(!empty($atate)){
		$x .= " and state = '$atate' ";
	}
	if(!empty($year1) and !empty($moon1) and !empty($day1) and !empty($year2) and !empty($moon2) and !empty($day2)){
		$starTime = $year1."-".$moon1."-".$day1;//开始时间
		$endTime = $year2."-".$moon2."-".$day2;//结束时间
		$slot = " and transportTime between '{$starTime}'and '{$endTime}' ORDER BY transportTime ASC ";
		$x .= $slot;
	}
	$_SESSION['adTransport'] = array(
		"urgent" => $urgent,"state" => $atate,
		"starTime" => $starTime,
		"endTime" => $endTime,
		"Sql" => $x,'time'=>$slot);
	/********转运需求- 危险废物明细********************************************************/
}elseif($_GET['type'] == 'adTransportCatalog'){
	//赋值
	$name = $post['name'];//公司名称
	$type = $post['type'];//危废类别
	$code = $post['code'];//危废代码
	$car = $post['car'];//车牌号
	$year1 = $post['year1'];//开始年
	$moon1 = $post['moon1'];//开始月
	$day1 = $post['day1'];//开始日
	$year2 = $post['year2'];//结束年
	$moon2 = $post['moon2'];//结束月
	$day2 = $post['day2'];//结束日
	$x = "";//sql语句拼接
	if(!empty($name)){
		$x .= " and khid in (SELECT khid FROM kehu where CompanyName like '%$name%' )";
	}
	if(!empty($type)){
		$x .= " and catalogId in (SELECT id FROM Catalog where type like '%$type%' ) ";
	}
	if(!empty($car)){
		$x .= " and transportId in (SELECT id FROM transport where car like '%$car%' ) ";
	}
	if(!empty($code)){
		$x .= " and catalogCode like'%$code%' ";
	}
	if(!empty($year1) and !empty($moon1) and !empty($day1) and !empty($year2) and !empty($moon2) and !empty($day2)){
		$starTime = $year1."-".$moon1."-".$day1;//开始时间
		$endTime = $year2."-".$moon2."-".$day2;//结束时间
		$x .= " and transportId in ( SELECT id FROM transport WHERE transportTime between '{$starTime}'and '{$endTime}')";
	}
	$_SESSION['adTransportCatalog'] = array(
		"name" => $name,
		"type" => $type,
		"code" => $code,
		"car" => $car,
		"starTime" => $starTime,
		"endTime" => $endTime,
		"sql" => $x);
	/********危废出库-多条件模糊查询********************************************************/
}elseif($_GET['type'] == 'depotOut'){
	//赋值
	$catalogCode = $post['code'];//编号
	$car = $post['carCode'];//车牌号
	$company = $post['company'];//目的公司
	$year1 = $post['year1'];//开始年
	$moon1 = $post['moon1'];//开始月
	$day1 = $post['day1'];//开始日
	$year2 = $post['year2'];//结束年
	$moon2 = $post['moon2'];//结束月
	$day2 = $post['day2'];//结束日
	$year3 = $post['year3'];//开始年
	$moon3 = $post['moon3'];//开始月
	$day3 = $post['day3'];//开始日
	$year4 = $post['year4'];//结束年
	$moon4 = $post['moon4'];//结束月
	$day4 = $post['day4'];//结束日
	$x = "";
	$slot = '';//excel查询导出的时间段
	if(!empty($catalogCode)){
		$x .= " and catalogCode like '%$catalogCode%'  ";
	}
	if(!empty($company)){
		$x .= " and company like '%$company%' ";
	}
	if(!empty($car)){
		$x .= " and car like '%$car%' ";
	}
	if(!empty($year1) and !empty($moon1) and !empty($day1) and !empty($year2) and !empty($moon2) and !empty($day2)){
		$starTime = $year1."-".$moon1."-".$day1;//开始时间
		$endTime = $year2."-".$moon2."-".$day2;//结束时间
		$slot = " and outTime between '{$starTime}'and '{$endTime}' ORDER BY outTime ASC ";
		$x .= $slot;
	}
	if(!empty($year3) and !empty($moon3) and !empty($day3) and !empty($year4) and !empty($moon4) and !empty($day4)){
		$starTime1 = $year3."-".$moon3."-".$day3;//开始时间
		$endTime1 = $year4."-".$moon4."-".$day4;//结束时间
	}
	$_SESSION['depotOut'] = array(
		"code" => $catalogCode,"car" => $car,
		"company" => $company,
		"starTime" => $starTime,
		"endTime" => $endTime,
		"starTime1" => $starTime1,
		"endTime1" => $endTime1,
		"Sql" => $x,'time'=>$slot);
	/********财务管理-收支平衡-多条件模糊查询********************************************************/
}elseif($_GET['type'] == "adProfitSearch"){
	//赋值
	$type = $post['ProfitMoneyType'];//收款来源
	$source = $post['ProfitMoneySource'];//收款类型
	$direction = $post['adProfitDirection'];//变动方向
	$text = $post['adProfitText'];//备注
	//开票日
	$year = $post['year'];
	$moon = $post['moon'];
	$day = $post['day'];
	$year0 = $post['year0'];
	$moon0 = $post['moon0'];
	$day0 = $post['day0'];
	//结算日
	$year1 = $post['year1'];
	$moon1 = $post['moon1'];
	$day1 = $post['day1'];
	$year2 = $post['year2'];
	$moon2 = $post['moon2'];
	$day2 = $post['day2'];
	//收支平衡创建日
	$year3 = $post['year3'];
	$moon3 = $post['moon3'];
	$day3 = $post['day3'];
	$year4 = $post['year4'];
	$moon4 = $post['moon4'];

	$day4 = $post['day4'];
	$x = "";
	$payDateSql = "";//结算日语句
	$setTime = "";//结算日语句
	$buycarInvoiceSql = "";//合同开票语句
	//串联查询语句
	if(!empty($type)){
		$x .= " and type = '$type' ";
	}
	if(!empty($source)){
		$x .= " and source = '$source' ";
	}
	if(!empty($direction)){
		$x .= " and direction = '$direction' ";
	}
	if(!empty($text)){
		$x .= " and text like '%$text%' ";
	}
	if(!empty($year) and !empty($moon) and !empty($day) and !empty($year0) and !empty($moon0) and !empty($day0)){
		$startTime  = "{$year}-{$moon}-{$day}";
		$endTime = "{$year0}-{$moon0}-{$day0}";
		$buycarInvoiceSql = " and time between '{$startTime} 00:00:00 'and '{$endTime} 23:59:59 ' ";
	}
	if(!empty($year1) and !empty($moon1) and !empty($day1) and !empty($year2) and !empty($moon2) and !empty($day2)){
		$startTime1  = "{$year1}-{$moon1}-{$day1}";
		$endTime1 = "{$year2}-{$moon2}-{$day2}";
		$payDateSql = " and PayDate between '{$startTime1}'and '{$endTime1}' ";
		$x .= $payDateSql;
	}
	if(!empty($year3) and !empty($moon3) and !empty($day3) and !empty($year4) and !empty($moon4) and !empty($day4)){
		$startTime2 = "{$year3}-{$moon3}-{$day3}";
		$endTime2 = "{$year4}-{$moon4}-{$day4}";
		$setTime = " and time between '{$startTime2} 00:00:00'and '{$endTime2} 23:59:59' ";
		$x .= $setTime;
	}
	//返回值
	$_SESSION['adProfit'] = array(
		"type" => $type,
		"source" => $source,
		"direction" => $direction,
		"text" => $text,
		"buycarInvoiceSql" => $buycarInvoiceSql,
		"startTime" => $startTime,
		"endTime" => $endTime,
		"startTime1" => $startTime1,
		"endTime1" => $endTime1,
		"startTime2" => $startTime2,
		"endTime2" => $endTime2,
		"payDateSql" => $payDateSql,
		"setTime" => $setTime,
		"Sql" => $x);
	/********财务管理-收支平衡-汇总数据模糊查询********************************************************/
}elseif($_GET['type'] == "adNoProfit"){
	//赋值
	//开票日
	$year = $post['year'];
	$moon = $post['moon'];
	$day = $post['day'];
	$year0 = $post['year0'];
	$moon0 = $post['moon0'];
	$day0 = $post['day0'];
	//结算日
	$year1 = $post['year1'];
	$moon1 = $post['moon1'];
	$day1 = $post['day1'];
	$year2 = $post['year2'];
	$moon2 = $post['moon2'];
	$day2 = $post['day2'];
	$CompanyName = $post['CompanyName'];//公司名称
	$identifier = $post['identifier'];//合同编号
	$adid = $post['adId'];//所属员工
	$x = "";
	$payDateSql = "";//结算日语句
	$buycarInvoiceSql = "";//合同开票语句
	//串联查询语句
	if(!empty($CompanyName)){
		$x .= " and CompanyName like '%$CompanyName%' ";
	}
	if(!empty($identifier)){
		$x .= " and identifier like '%$identifier%' ";
	}
	if(!empty($adid)){
		$x .= " and adid = '$adid' ";
	}
	if(!empty($year) and !empty($moon) and !empty($day) and !empty($year0) and !empty($moon0) and !empty($day0)){
		$startTime  = "{$year}-{$moon}-{$day}";
		$endTime = "{$year0}-{$moon0}-{$day0}";
		$buycarInvoiceSql = " and time between '{$startTime} 00:00:00 'and '{$endTime} 23:59:59 ' ";
		//根据时间段查询
		$x .= " and id in (SELECT buycarId FROM buycarInvoice where time between '{$startTime} 00:00:00 'and '{$endTime} 23:59:59 ' )";
	}
	if(!empty($year1) and !empty($moon1) and !empty($day1) and !empty($year2) and !empty($moon2) and !empty($day2)){
		$startTime1  = "{$year1}-{$moon1}-{$day1}";
		$endTime1 = "{$year2}-{$moon2}-{$day2}";
		$payDateSql = " and PayDate between '{$startTime1}'and '{$endTime1}' ";
		//根据时间段查询
		$x .= " and id in (SELECT buycarId FROM Profit where PayDate between '{$startTime1}'and '{$endTime1}' )";
	}
	//返回值
	$_SESSION['adNoProfit'] = array(
		"CompanyName" => $CompanyName,
		"identifier" => $identifier,
		"adid" => $adid,
		"buycarInvoiceSql" => $buycarInvoiceSql,
		"payDateSql" => $payDateSql,
		"startTime" => $startTime,
		"endTime" => $endTime,
		"startTime1" => $startTime1,
		"endTime1" => $endTime1,
		"Sql" => $x);
	/********财务管理-收支平衡-开票模糊查询********************************************************/
}elseif($_GET['type'] == "adInvoice"){
	//赋值
	$CompanyName = $post['CompanyName'];//公司名称
	$identifier = $post['identifier'];//合同编号
	$type = $post['type'];//发票类型
	$money = $post['money'];//开票金额
	$num = $post['num'];//开票号
	//开票日
	$year = $post['year'];
	$moon = $post['moon'];
	$day = $post['day'];
	$year0 = $post['year0'];
	$moon0 = $post['moon0'];
	$day0 = $post['day0'];
	$m = '';
	$x = '';
	//串联查询语句
	if(!empty($CompanyName) or !empty($identifier)){
		if(!empty($CompanyName)){
			$m .= "CompanyName like '%$CompanyName%'";
		}
		if(!empty($identifier)){
			$m .= " and identifier like '%$identifier%' ";
		}
		$x .= " and buycarId in (SELECT id FROM buycar WHERE 1 =1 {$m})";
	}
	if(!empty($type)){
		$x .= " and type like '%$type%' ";
	}
	if(!empty($money)){
		$x .= " and money like '%$money%' ";
	}
	if(!empty($num)){
		$x .= " and num like '%$num%' ";
	}

	if(!empty($year) and !empty($moon) and !empty($day) and !empty($year0) and !empty($moon0) and !empty($day0)){
		$startTime  = "{$year}-{$moon}-{$day}";
		$endTime = "{$year0}-{$moon0}-{$day0}";
		$x .= " and time between '{$startTime} 00:00:00 'and '{$endTime} 23:59:59 ' ";
	}
	//返回值
	$_SESSION['adInvoice'] = array(
		"CompanyName" => $CompanyName,
		"identifier" => $identifier,
		"type" => $type,
		"money" => $money,
		"num" => $num,
		"buycarInvoiceSql" => $buycarInvoiceSql,
		"startTime" => $startTime,
		"endTime" => $endTime,
		"Sql" => $x);
	/********财务管理-收支平衡-查看合同模糊查询********************************************************/
}elseif(!empty($_GET['typeInvoice'])){
//返回值
	$type = $_GET['typeInvoice'];
//情况一：预支付
	$strProfit = "";
	$sqlbcProfit = mysql_query("select DISTINCT buycarId from Profit where 1=1 ");
	while($parray = mysql_fetch_array($sqlbcProfit)){
		$num = mysql_num_rows(mysql_query("select buycarId from buycarInvoice where buycarId = '$parray[buycarId]' "));
		if($num == 0){
			if(empty($strProfit)){
				$strProfit = "'".$parray['buycarId']."'";
			}else{
				$strProfit .= ",'".$parray['buycarId']."'";
			}
		}
	}
//已开票已回款
	$AllArray = array();
	$sqlbcInvoice = mysql_query("select DISTINCT b.buycarId from buycarInvoice as b,Profit as p where  b.buycarId = p.buycarId  ");
	while($iarray = mysql_fetch_array($sqlbcInvoice)){
		array_push($AllArray,"'".$iarray['buycarId']."'");
	}
//已开票未回款
	$strInvoice = "";
	$sql = mysql_query("select DISTINCT buycarId from buycarInvoice where 1=1 ");
	while($array = mysql_fetch_array($sql)){
		$num = mysql_num_rows(mysql_query("select buycarId from Profit where buycarId = '$array[buycarId]' "));
		if($num == 0){
			if(empty($strInvoice)){
				$strInvoice = "'".$array['buycarId']."'";
			}else{
				$strInvoice .= ",'".$array['buycarId']."'";
			}
		}
	}
	$AllStrId = implode(",",$AllArray);
	if($type == 'part'){
		$where = $strProfit;
	}elseif($type == 'invoice'){
		$where = $strInvoice;
	}elseif($type == 'allPay'){
		$where = $AllStrId;
	}elseif($type == 'all'){
		$where = "1";
	}
	$_SESSION['adNoProfit'] = array(
		"where" => $where);
	/********内部管理-危险废物名录-多条件模糊查询********************************************************/
}elseif($_GET['type'] == "adCatalogSearch"){
	//赋值
	$type = $post['SearchCatalogType'];//废物类别
	$industry = $post['SearchCatalogIndustry'];//行业来源
	$code = $post['SearchCatalogCode'];//废物代码
	$own = $post['CatalogOwn'];//是否为本公司储运
	$x = " where 1=1 ";
	//串联查询语句
	if(!empty($type)){
		$x .= " and type = '$type' ";
	}
	if(!empty($industry)){
		$x .= " and industry = '$industry' ";
	}
	if(!empty($own)){
		$x .= " and own = '$own' ";
	}
	//返回值
	$_SESSION['adCatalog'] = array("type" => $type,"industry" => $industry,"own" => $own,"Sql" => $x);
	/*************************合同--新增合同附件***************************************/
}elseif($_GET['type'] == "buycarAttachment"){
	//赋值
	$buyCarId = $post['buyCarId'];
	$fileName = "attachmentsUpload";//附件名称
	//判断
	$buycar = query("buycar"," id = '$buyCarId' ");
	if(empty($buyCarId)){
		$_SESSION['warn'] = "请先提交合同";
	}elseif($adDuty['orderEdit'] != "是"){
		$_SESSION['warn'] = "您没有编辑权";
	}elseif($buycar['id'] != $buyCarId){
		$_SESSION['warn'] = "没有该转运合同";
	}else{
		$tmp_name = $_FILES[$fileName]['tmp_name'];//临时文件名
		$name = $_FILES[$fileName]['name'];//附件名称
		$type = $_FILES[$fileName]['type'];//附件类型
		if(
			$type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" or //xlsx后缀
			$type == "application/vnd.ms-excel" or//xls后缀
			$type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" or//docx后缀
			$type == "application/octet-stream" or//docx,xlsx后缀
			$type == "application/msword" or//doc后缀
			$type == "application/pdf" or//PDF后缀
			$type == "image/jpeg" or//jpg后缀
			$type == "image/png" or//png后缀
			$type == "image/gif" //gif后缀
		){
			$id = suiji();
			//如果对应文件夹不存在，则创建文件夹
			$url = "img/buycarAttachment/".date("Ym");
			if(!file_exists(ServerRoot.$url)){
				mkdir(ServerRoot.$url);
			}
			//获取附件后缀
			$suffix = explode('.',$name);
			$arrayLast = array_pop($suffix);
			//组合本文件服务器根目录地址
			$src = $url."/".$id.".".$arrayLast;
			mysql_query("insert into buycarAttachment (id,buycarId,name,url,time)
			values ('$id','$buyCarId','$name','$src','$time') ");
			move_uploaded_file($tmp_name,ServerRoot.$src);
			LogText("任务管理",$Control['adid'],"{$Control['adname']}上传了附件，名称：".$name."，类型：".$type."，状态：上传成功");
			$_SESSION['warn'] = "成功上传合同附件";
			$json['warn'] = 2;
		}else{
			LogText("任务管理",$Control['adid'],"{$Control['adname']}上传了附件，名称：".$name."，类型：".$type."，状态：上传失败");
			$_SESSION['warn'] = "上传合同附件失败";
		}
	}
	/*************************合同--新增合同附件下载***************************************/
}elseif(isset($_GET['fileDownload'])){
	$url = $_GET['fileDownload'];
	download($url);
	/*************************新增危险废物现场图***************************************/
}elseif($_GET['type'] == "transportImg"){
	//赋值
	$transportId = $post['transportId'];
	//判断
	$transport = query("transport"," id = '$transportId' ");
	if(empty($transportId)){
		$_SESSION['warn'] = "请先提交转运需求";
	}elseif($adDuty['transportEdit'] != "是"){
		$_SESSION['warn'] = "您没有编辑权";
	}elseif($transport['id'] != $transportId){
		$_SESSION['warn'] = "没有该转运需求";
	}else{
		$cut['width'] = "";//裁剪宽度
		$cut['height'] = "";//裁剪高度
		$FileName = "transportImgUpload";//上传图片的表单文件域名称
		$cut['type'] = "需要缩放";//"需要裁剪"或"需要缩放"或空
		$cut['NewWidth'] = 1000;//缩放的宽度
		$cut['MaxHeight'] = 5000;//缩放后图片的最大高度
		$type['name'] = "新增图像";//"更新图像"or"新增图像"
		$type['num'] = 10;//新增图像时限定的图像总数
		$sql = "select * from transportImg where transportId = '$transportId'";//查询图片的数据库代码
		$column = "ico";//保存图片的数据库列的名称
		$suiji = suiji();
		$Url['root'] = "../../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
		$Url['NewImgUrl'] = "img/transportImg/{$suiji}.jpg";//新图片保存的网站根目录位置
		$NewImgSql = " insert into transportImg (id,transportId,ico,time) values ('$suiji','$transportId','$Url[NewImgUrl]','$time') ";//保存图片的数据库代码
		$ImgWarn = "转运现场图片新增成功";//图片保存成功后返回的文字内容
		UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);
	}
	/*************************转运需求--转运交接单图***************************************/
}elseif($_GET['type'] == "deliveryReceitp"){
	//赋值
	$id = $post['transportId'];
	//判断
	$transport = query("transport"," id = '$id' ");
	if(empty($id)){
		$_SESSION['warn'] = "请先提交转运需求";
	}elseif($adDuty['transportEdit'] != "是"){
		$_SESSION['warn'] = "您没有编辑权";
	}elseif($transport['id'] != $id){
		$_SESSION['warn'] = "没有该转运需求";
	}else{
		$cut['width'] = "";//裁剪宽度
		$cut['height'] = "";//裁剪高度
		$FileName = "deliveryReceitpUpload";//上传图片的表单文件域名称
		$cut['type'] = "需要缩放";//"需要裁剪"或"需要缩放"或空
		$cut['NewWidth'] = 1000;//缩放的宽度
		$cut['MaxHeight'] = 5000;//缩放后图片的最大高度
		$type['name'] = "更新图像";//"更新图像"or"新增图像"
		$type['num'] = "";//新增图像时限定的图像总数
		$sql = "select * from transport where id = '$id'";//查询图片的数据库代码
		$column = "deliveryReceitp";//保存图片的数据库列的名称
		$suiji = suiji();
		$Url['root'] = "../../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
		$Url['NewImgUrl'] = "img/transportDeliveryReceitp/{$suiji}.jpg";//新图片保存的网站根目录位置
		$NewImgSql = " update transport set
		deliveryReceitp = '$Url[NewImgUrl]',
		updateTime = '$time' where id = '$id' ";//保存图片的数据库代码
		$ImgWarn = "转运现场图片新增成功";//失败返回的文字内容
		UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);
	}
	/******************删除转运现场图片*******************************/
}elseif(!empty($_GET['transportImgDelete'])){
	$id = FormSub($_GET['transportImgDelete']);
	$transportImg = query("transportImg"," id = '$id' ");
	if(!power("转运需求")){
		$_SESSION['warn'] = "权限不足";
	}elseif($adDuty['transportEdit'] != "是"){
		$_SESSION['warn'] = "您没有编辑权";
	}elseif(empty($id)){
		$_SESSION['warn'] = "id号为空";
	}elseif(empty($transportImg['id'])){
		$_SESSION['warn'] = "此图片不存在";
	}else{
		unlink(ServerRoot.$transportImg['ico']);
		mysql_query("delete from transportImg where id = '$id'");
		$_SESSION['warn'] = "转运现场图删除成功";
	}
	/****************合同管理-CSV导入*****************************/
}elseif($_GET['type'] == 'orderExcel' and isset($_FILES['ExcelOrder']) and isset($_POST['Password'])){
	//赋值
	$pas = $_POST['Password'];
	//判断
	if($adDuty['name'] != "超级管理员"){
		$_SESSION['warn'] = "只有超级管理员才能批量合同";
	}elseif(empty($pas)){
		$_SESSION['warn'] = "管理员登录密码为空";
	}elseif($pas != $Control['adpas']){
		$_SESSION['warn'] = "管理员登录密码输入有误";
	}else{
		//将上传的csv临时文件读入数组

		//电话号码可能是手机号，也可能是座机号，格式不做限制
		$excel = file($_FILES['ExcelOrder']["tmp_name"]);
		$x = 0;
		$Eorrnum = "";
		$Eorrweight = "";
		$Eorrmoney = "";
		$Eorrkehu =  "";
		$Eorradid =  "";
		$RepeatOrder = "";
		$nonExistentAdid = "";
		foreach($excel as $row){
			$row = iconv("gb2312//IGNORE","utf-8",$row);
			$word = explode(",",$row);
			$num = FormSub($word[9]);
			$weight = FormSub($word[8]);
			$money = FormSub($word[10]);
			$pay = FormSub($word[11]);
			$invoice = FormSub($word[12]);
			$tel = FormSub($word[16]);
			$order = query("buycar"," identifier = '$word[2]' and companyName = '$word[1]' ");//合同排出重复
			if(!empty($order['id'])){
				$RepeatOrder = "该合同编号为：".$word[2]."公司名称：".$word[1].'/';
			}elseif(preg_match($CheckInteger,$num) == 0 and !empty($num)){
				$Eorrnum .= $num."/";
			}elseif(preg_match($CheckPrice,$weight) == 0 and !empty($weight)){
				$Eorrweight .= $weight."/";
			}elseif(preg_match($CheckPrice,$money) == 0 and !empty($money)){
				$Eorrmoney .= $money."/";
			}else{
				$kehu = query("kehu"," CompanyName = '$word[1]' ");
				$admin = query("admin"," adname = '$word[19]' ");
				if($kehu == false){
					$Eorrkehu .= $word[1]."/";
				}elseif(empty($admin['adid']) and !empty($word[19])){
					$Eorradid = "公司不存在该客户经理".$word[19].'/';
				}elseif($kehu['adid'] != $admin['adid']){
					$nonExistentAdid = "该客户{$word[1]}不属于该客户经理{$word[19]}/";
				}else{
					$id = suiji();
					//区域ID号
					$region = query("region"," area = '$word[18]' ");
					$bool = mysql_query(" insert into buycar
					(id,khid,adid,adName,name,standard,companyName,identifier,num,weight,money,pay,invoice,addressName,addressTel,
					regionId,addressMx,sign,source,signInDay,signOutDay,approvalTime,startTime,endTime,updateTime,time)
					values
					('$id','$kehu[khid]','$kehu[adid]','$word[19]','$word[0]','$word[7]','$word[1]','$word[2]','$num',
					'$weight','$money','$pay','$invoice','$word[15]','$tel','$region[id]','$word[17]','$word[3]','Excl导入','$word[6]','$word[5]','$word[4]','$word[13]','$word[14]','$time','$time') ");
					$x++;
				}
			}
		}
		$_SESSION['warn'] = "你已成功导入{$x}个合同";
		LogText("合同管理",$Control['adid'],"管理员{$Control['adname']}使用Excel上传了{$x}个合同（重复合同：{$RepeatOrder}，收运次数格式错误：{$Eorrnum}，约定的危险废物总收运量格式错误：{$Eorrweight}，合同金额格式错误：{$Eorrmoney},{$Eorradid}，不存在该客户：{$Eorrkehu}，{$nonExistentAdid}）");
	}
	/****************客户管理-CSV导入*****************************/
}elseif($_GET['type'] == 'ClientCsv' and isset($_FILES['ExcelClient']) and isset($_POST['Password'])){
	//赋值
	$pas = $_POST['Password'];
	//判断
	if($adDuty['name'] != "超级管理员" and $adDuty['name'] != "客户经理" and $adDuty['name'] != "市场部主管"){
		$_SESSION['warn'] = "只有超级管理员或客户经理或市场部主管才能批量导入客户";
	}elseif(empty($pas)){
		$_SESSION['warn'] = "登录密码为空";
	}elseif($pas != $Control['adpas']){
		$_SESSION['warn'] = "登录密码输入有误";
	}else{
		//将上传的csv临时文件读入数组
		$excel = file($_FILES['ExcelClient']["tmp_name"]);
		$x = 0;
		$ErrorTel = "";
		$AddressCom = "";
		$companyNameCom = "";
		$followType = "";
		foreach($excel as $row){
			$row = iconv("gb2312//IGNORE","utf-8",$row);
			$word = explode(",",$row);
			$tel = FormSub($word[3]);
			$adminId = query("admin"," adname = '$word[8]' ");
			$Sql = mysql_query(" select * from kehu where ContactTel = '$tel' ");
			//查询公司名称是否重复
			$kehuRe = query("kehu"," CompanyName = '$word[0]' ");
			//自动添加跟进记录
			if(!empty($adminId['adid'])){
				$kehuFollowId = suiji();
				mysql_query(" insert into kehuFollow

				(id,khid,adid,time)
				values ('$kehuFollowId','$khid','$adminId[adid]','$word[9]') ");
				$followType = "私客";
			}elseif(empty($word[8])){
				$followType = "公客";
			}
			//判断
			if(preg_match($CheckTel,$tel) == 0 and !empty($tel)){
				$ErrorTel .= $tel."/";
			}elseif(!empty($kehuRe['khid'])){
				$companyNameCom .= $word[0].'/';
			}elseif(!empty($word[8]) and empty($adminId['adid'])){
				$nameCom .= $word[8].'/';//不存在该客户经理
			}else{
				$kehuIndustry = query("kehuIndustry","name = '$word[1]' ");
				//自动添加行业名称
				if(empty($kehuIndustry['id']) and !empty($word[1])){
					$kehuIndustryId = suiji();
					$r = mysql_query(" insert into kehuIndustry
					(id,name,updateTime,time)
					values ('$kehuIndustryId','$word[1]','$time','$time') ");
				}
				//判断行业ID是否为空
				empty($kehuIndustry['id'])?$kehuIndustry['id'] = $kehuIndustryId : $kehuIndustry['id'];
				//查询重庆区域ID号
				if(!empty($word[10])){
					$regionId =  query("region"," province = '重庆市' and area = '$word[10]' ");
				}
				//添加客户信息
				$khid = suiji();
				mysql_query(" insert into kehu
				(khid,CompanyName,industry,ContactName,ContactTel,spareTel,Landline,fax,businessLicenseNum,regionId,followType,adid,labeMaking,source,UpdateTime,time)
				values ('$khid','$word[0]','$kehuIndustry[id]','$word[2]','$tel','$word[4]','$word[5]','$word[6]','$word[7]','$regionId[id]','$followType','$adminId[adid]','$word[12]','Excel导入','$time','$time') ");
				$x++;
				//自动添加地址（非默认地址）
				if(!empty($word[11])){
					//获取重庆地区区域ID号
					$Address = $word[11];
					$addressId = suiji();
					//根据要求暂时先匹配重庆地区的区域
					if(preg_match_all("/(.*?)市(.*?)区/",$Address,$array)){
						$region =  query("region"," province = '$array[1]市' and area = '$array[2]区' ");
						$AddressMx = substr($Address , strrpos($Address , '区')+3);
					}elseif(preg_match_all("/(.*?)市(.*?)县/",$Address,$array)){
						$region =  query("region"," province = '$array[1]市' and area = '$array[2]县' ");
						$AddressMx = substr($Address , strrpos($Address , '县')+3);
					}else{
						$AddressCom .= $Address.'/';
					}
					//插入客户地址数据
					mysql_query(" insert into address
					(id,khid,AddressName,AddressTel,RegionId,AddressMx,UpdateTime,time)
					values ('$addressId','$khid','$word[2]','$tel','$region[id]','$AddressMx','$time','$time') ");
				}
			}
		}
		LogText("客户管理",$Control['adid'],"管理员{$Control['adname']}使用Excel上传了{$x}个客户（公司名称重复：{$companyNameCom}，错误手机号码：{$ErrorTel},地址格式错误：{$AddressCom}，不存在客户经理：{$nameCom}）");
		$_SESSION['warn'] = "新增了{$x}个客户";
	}
	/****************合同约定的危废参数-CSV导入*****************************/
}elseif($_GET['file'] == 'buycarCatalogExcel' ){
	//赋值
	$pas = $_POST['Password'];
	//判断
	if($adDuty['name'] != "超级管理员"){
		$_SESSION['warn'] = "只有超级管理员才能批量导入合同约定的危废参数";
	}elseif(empty($pas)){
		$_SESSION['warn'] = "管理员登录密码为空";
	}elseif($pas != $Control['adpas']){
		$_SESSION['warn'] = "管理员登录密码输入有误";
	}else{
		//将上传的csv临时文件读入数组
		$excel = file($_FILES['buycarCatalogOrder']["tmp_name"]);
		$x = 0;//导入成功的次数
		$EorrCatalog = "";//危废
		$EorrBuycar = "";//错误合同
		$identifierArray = array();//创建合同编号名称数组
		$CompanyNameArray = array();//创建公司名称数组
		$i = 0;
		$m = 0;
		foreach($excel as $row){
			$row = iconv("gb2312//IGNORE","utf-8",$row);
			$word = explode(",",$row);
			//数据匹配
			$catalog = query("Catalog","type = '$word[2]' and code = '$word[3]'");
			//执行
			array_push($CompanyNameArray,$word[0]);
			$i = count($CompanyNameArray);
			//公司名称多个单元格合并时取第一个数据
			if(empty($word[0]) and $i >= 1){
				do{
					$i--;
					$CompanyName = $CompanyNameArray[$i];
				}while(empty($CompanyNameArray[$i]));
			}else{
				$CompanyName = $word[0];
			}
			//合同编号多个单元格合并时取第一个数据
			array_push($identifierArray,$word[1]);
			$m = count($identifierArray);
			if(empty($word[1]) and $m >= 1){
				do{
					$m--;
					$identifier = $identifierArray[$m];
				}while(empty($identifierArray[$m]));
			}else{
				$identifier = $word[1];
			}
			$buycar = query("buycar","companyName = '$CompanyName' and identifier = '$identifier' ");
			//执行
			if(empty($buycar['id'])){
				$EorrBuycar .= ",不存在由公司名称：{$CompanyName}合同编号组成的{$identifier}合同相关数据/";
			}elseif(empty($catalog['id'])){
				$EorrCatalog .= ",不存在该类型的".$word[2]."和该代码".$word[3]."组合的危险废物代码数据/";
			}else{

				$id = suiji();
				mysql_query(" insert into buycarCatalog
				(id,khid,buycarId,CatalogId,catalogCode,name,packing,source ,time)
				values ('$id','$buycar[khid]','$buycar[id]','$catalog[id]','$word[3]','$word[4]','$word[5]','Excel导入','$time') ");
				$x++;
			}
		}
		LogText("合同管理",$Control['adid'],"管理员{$Control['adname']}使用Excel上传了{$x}个合同约定的危废参数（{$EorrCatalog}{$EorrBuycar}）");
		$_SESSION['warn'] = "新增了{$x}个合同约定的危废参数";
	}
	/****************转运需求-CSV导入*****************************/
}elseif($_GET['file'] == 'transportExcel'){
	//赋值
	$pas = $_POST['Password'];
	//判断
	if($adDuty['name'] != "超级管理员" and $adDuty['name'] != "储运部主管"){
		$_SESSION['warn'] = "只有超级管理员或者储运部主管才能批量导入合同约定的危废参数";
	}elseif(empty($pas)){
		$_SESSION['warn'] = "登录密码为空";
	}elseif($pas != $Control['adpas']){
		$_SESSION['warn'] = "登录密码输入有误";
	}else{
		//将上传的csv临时文件读入数组
		$excel = file($_FILES['adTransportExcel']["tmp_name"]);
		$x = 0;
		$m = 0;
		$mStr = "";
		$dateTime = array();
		foreach($excel as $row){
			$row = iconv("gb2312//IGNORE","utf-8",$row);
			$word = explode(",",$row);
			$m++;
			//合同是否存在
			if(!empty($word[2])){
				$buycar = query("buycar","companyName = '$word[2]'");
			}
			//不存在
			if(empty($buycar['id'])){
				$orderName= $word[2].'/';
			}else{
				//存在
				//判断转运日期是否为空，如果为空则自动归为待收运状态
				if(empty($word[0])){
					$state = '待收运';
				}else{
					$state = '已收运';
				}
				//数据排重
				$Fnum = mysql_num_rows(mysql_query(" select * from transport where khid = '$buycar[khid]' and buycarId = '$buycar[id]' and car = '$word[7]' and urgent = '$word[8]' and source = 'Excel导入' and state = '$state' and bill = '$word[9]' and transportTime = '$word[0]' "));
				if($Fnum >= 1){
					$mStr .= $m.',';
				}else{
					//自动添加transport数据
					$id = IdRepeat('transport','id');//ID排重
					mysql_query(" insert into transport
					(id,khid,buycarId,car,urgent,source ,state,bill,transportTime,updateTime,time)
					values ('$id','$buycar[khid]','$buycar[id]','$word[7]','$word[8]','Excel导入','$state','$word[9]','$word[0]','$time','$time') ");
					$x++;
					//自动添加transportCatalog数据
					if(!empty($word[3]) or !empty($word[4]) or !empty($word[5]) or !empty($word[6])){
						$codeArray = explode('、',$word[3]);//拆分代码为数组
						$clientArray = explode('、',$word[4]);//拆分客户评估为数组
						$spotArray = explode('、',$word[5]);//拆分现场评估为数组
						$steelYardArray = explode('、',$word[6]);//拆分过磅重量为数组
						//循环出每一条transportCatalog对应的数据
						for ($i = 0;$i < count($codeArray);$i++){
							$catalogCode = $codeArray[$i];//危险废物代码
							$weightClient = $clientArray[$i]/1000;//客户评估单位转化为吨
							$weightSpot = $spotArray[$i]/1000;//现场评估单位转化为吨
							$weightSteelyard = $steelYardArray[$i]/1000;//过磅单位转化为吨
							$Catalog = query("Catalog"," code = '$catalogCode' ");//根据危废代码查询危险废物名录ID号
							$transportCatalogId = IdRepeat('transportCatalog','id');
							mysql_query(" insert into transportCatalog
							(id,khid,transportId,buycarId,catalogId,catalogCode,weightClient,weightSpot,weightSteelyard,updateTime ,time)
							values ('$transportCatalogId','$buycar[khid]','$id','$buycar[id]','$Catalog[id]','$catalogCode','$weightClient','$weightSpot','$weightSteelyard','$time','$time') ");
						}
					}
				}
			}
		}
		LogText("转运管理",$Control['adid'],"管理员{$Control['adname']}使用Excel上传了{$x}个合同约定的危废参数（合同约定的危废参数重量错误格式：{$Eorrweight}）,不存该公司名称为:({$orderName})数据录入第{$mStr}条重复,");
		$_SESSION['warn'] = "新增了{$x}个转运需求";
	}
	/*************客户管理-模糊查询跟进记录***************************/
}elseif($_GET['type'] == 'adClientFollow'){
	//赋值
	$adid = $_POST['adid'];
	$year1 = $post['year1'];//跟进开始日期年
	$moon1 = $post['moon1'];//跟进开始日期月
	$day1 = $post['day1'];//跟进开始日期日
	$year2 = $post['year2'];//跟进结束日期年
	$moon2 = $post['moon2'];//跟进结束日期月
	$day2 = $post['day2'];//跟进结束日期日
	if(!empty($adid)){
		$sql .= " and adid like '%$adid%' ";
	}
	//按照客户创建时间段查询
	if(!empty($year1) and !empty($moon1) and !empty($day1) and !empty($year2) and !empty($moon2) and !empty($day2) ){
		$startTime = $year1."-".$moon1."-".$day1;
		$endTime = $year2."-".$moon2."-".$day2;
		$sql .= " and time between '{$startTime} 00:00:00'and '{$endTime} 23:59:59' ORDER BY time ASC ";
	}
	$_SESSION['adClientFollow'] = array(
		'Sql'=>$sql,
		"startTime" => $startTime,
		"endTime" => $endTime,
	);
	/*************客户管理-删除跟进记录***************************/
}elseif(isset($_GET['DeleteClientFollow'])){
	//赋值
	$id = $_GET['DeleteClientFollow'];
	$n = mysql_num_rows(mysql_query(" select * from kehuFollow where id = '$id' "));
	//判断
	if(empty($id)){
		$_SESSION['warn'] = "跟进id号为空";
	}elseif($n == 0){
		$_SESSION['warn'] = "未找到本条跟进记录";
	}elseif($adDuty['name'] != "超级管理员"){
		$_SESSION['warn'] = "只有超级管理员才能删除跟进记录";
	}else{
		$bool = mysql_query(" delete from kehuFollow where id = '$id' ");
		if($bool){
			$_SESSION['warn'] = "删除成功";
		}else{
			$_SESSION['warn'] = "删除失败";
		}
	}
	/*************合同管理-删除合同附件***************************/
}elseif(isset($_GET['buycarAttachmentId'])){
	//赋值
	$id = $_GET['buycarAttachmentId'];//接受合同附件id
	$n = mysql_num_rows(mysql_query(" select * from buycarAttachment where id = '$id' "));
	$buycarAttachment = query('buycarAttachment',"id = '$id'");
	//判断
	if(empty($id)){
		$_SESSION['warn'] = "接受合同附件id号为空";
	}elseif($n == 0){
		$_SESSION['warn'] = "未找到此合同附件";
	}elseif($adDuty['orderEdit'] != "是" and $order['adid'] != $Control['adid']){
		$_SESSION['warn'] = "您没有该权限";
	}else{
		FileDelete(ServerRoot.$buycarAttachment['url']);
		$bool = mysql_query(" delete from buycarAttachment where id = '$id' ");
		if($bool){
			$_SESSION['warn'] = "删除成功";
		}else{
			$_SESSION['warn'] = "删除失败";
		}
	}
	/*************合同管理-删除危险废物明细***************************/
}elseif(isset($_GET['transportCatalogId'])){
	//赋值
	$id = $_GET['transportCatalogId'];//接受合同附件id
	$n = mysql_num_rows(mysql_query(" select * from transportCatalog where id = '$id' "));
	//判断
	if($adDuty['transportEdit'] != '是'){
		$_SESSION['warn'] = "您没有转运需求编辑权限";
	}elseif(empty($id)){
		$_SESSION['warn'] = "本次转运危险废物明细id号为空";
	}elseif($n == 0){
		$_SESSION['warn'] = "未找到此转运危险废物明细";
	}else{
		$bool = mysql_query(" delete from transportCatalog where id = '$id' ");
		if($bool){
			$_SESSION['warn'] = "删除成功";
		}else{
			$_SESSION['warn'] = "删除失败";
		}
	}
	/*************合同管理-转运地图***************************/
}elseif(isset($_GET['type']) == 'mapaddEventOnclick'){
	//赋值
	$id = FormSub($_GET['id']);//废物明细转运id
	$transport = query("transport"," id = '$id'");
	if(!power("转运需求")){
		$_SESSION['warn'] = "权限不足";
	}elseif($transport['state'] != '待收运'){
		$_SESSION['warn'] = "只有待收运才能切换为收运中";
	}elseif(empty($id)){
		$_SESSION['warn'] = "转运需求id号为空";
	}elseif($transport == false){
		$_SESSION['warn'] = "未找到此条转运需求";
	}else{
		$bool = mysql_query(" update transport set
		   state = '收运中',
		   updateTime = '$time' where id = '$id' ");
		$_SESSION['warn'] = "已绑定";
	}
}
/****************跳转回刚才的页面*****************************/
header("Location:".getenv("HTTP_REFERER"));
?>