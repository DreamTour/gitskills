<?php
include "OpenFunction.php";
if($KehuFinger == 2){
    $json['warn'] = "您未登录";
/*----------------------------生成微信扫码支付二维码------------------------------------*/
}else if($_GET['type'] == "wxScanPay"){
	$json = payForm("微信扫码支付",$kehu);
/*----------------------------微信扫码支付异步查询是否已支付------------------------------------*/
}else if($_POST['OutTradeNo']){
	$PayId = $_POST['OutTradeNo'];//支付订单号
	$payNum = mysql_num_rows(mysql_query("select * from pay where WorkFlow = '已支付' and PayId = '$PayId' "));
	if($payNum > 0){
		$_SESSION['warn'] = "微信扫码支付成功";	
		$json['warn'] = 2;
	}else{
		$json['warn'] = "微信扫码尚未支付";	
	}
/*----------------------------活动立即/取消报名------------------------------------*/
}else if(isset($_POST['signUp'])){
	$contentId = $_POST['signUp'];//内容表的id号/活动的ID号
	$content = mysql_fetch_array(mysql_query("select * from content where id = '$contentId' "));//活动内容表
	$enroll = mysql_fetch_assoc(mysql_query("select * from Enroll where khid = '$kehu[khid]' and ContentId = '$contentId' "));//活动报名
	//判断
	if(empty($contentId)){
		$json['warn'] = "报名活动ID号为空";	
	}else if($content['id'] != $contentId){
		$json['warn'] = "没找到这个活动的记录";	
	}else if(!empty($enroll['id'])){
		if(mysql_query("delete from Enroll where id = '$enroll[id]' ")){
			$json['warn'] = "取消成功";
			$num = $content['EnrollNum'] - 1;
			mysql_query("update content set EnrollNum = '$num' where id = '$contentId' ");
			$json['num'] = $num;
		}else{
			$json['warn'] = "取消失败";
		}
	}else{
		$id = suiji();
		$bool = mysql_query("insert into Enroll (id,type,khid,ContentId,time) values ('$id','$content[type]','$kehu[khid]','$contentId','$time') ");
		if($bool){
			$json['warn'] = '报名成功';
			$num = $content['EnrollNum'] + 1;
			mysql_query("update content set EnrollNum = '$num' where id = '$contentId' ");
			$json['num'] = $num;
		}else{
			$json['warn'] = '报名失败';	
		}	
	}
	
/*----------------------------个人中心基本资料更新------------------------------------*/		
}else if(isset($_POST['userNickName']) and isset($_POST['year'])){
	//赋值 
	$NickName = htmlentities($_POST['userNickName'],ENT_QUOTES,'utf-8');//微信名
	$sex = $_POST['userSex'];//性别
	$Birthday = $_POST['year']."-".$_POST['moon']."-".$_POST['day'];//生日
	$Zodiac = $_POST['userZodiac'];//生肖
	$constellation = $_POST['userConstellation'];//星座
	$Nation = $_POST['userNation'];//民族
	$height = htmlentities($_POST['userHeight'],ENT_QUOTES,'urf-8');//身高
	$weight = htmlentities($_POST['userWeight'],ENT_QUOTES,'urf-8');//体重
	$degree = $_POST['userDegree'];//学历
	$marry = $_POST['userMarry'];//婚育状况
	$Hometown = $_POST['userHometown'];//家乡
	$RegionId = $_POST['area'];//所在区县ID号
	$Occupation = htmlentities($_POST['userOccupation'],ENT_QUOTES,'utf-8');//工作
	$salary = $_POST['userSalary'];//月收入
	$smoke = $_POST['userSmoke'];//是否吸烟
	$drink = $_POST['userDrink'];//是否饮酒
	$BuyHouse = $_POST['userBuyHouse'];//购房情况
	$BuyCar = $_POST['userBuyCar'];//购车情况
	$loan = $_POST['userLoan'];//是否贷款
	$Hobby = htmlentities($_POST['userHobby'],ENT_QUOTES,'utf-8');//兴趣爱好
	$Advantage = htmlentities($_POST['userAdvantage'],ENT_QUOTES,'utf-8');//优点
	$defect = htmlentities($_POST['userShortcoming'],ENT_QUOTES,'utf-8');//缺点
	$HomeRanking = $_POST['userHomerank'];//家中排行
	$family = $_POST['userFamily'];//家庭成员
	$wxNum = htmlentities($_POST['userWxNum'],ENT_QUOTES,'utf-8');//微信号
	$IDCard = htmlentities($_POST['userIDCard'],ENT_QUOTES,'utf-8');//身份证号<br>
	$reg_chinese = "/^[\x{4e00}-\x{9fa5}]+$/u";
	$reg_match = "/^[^0-9^a-z^A-Z]*$/u";
	$keyword = KeyWords();
	foreach($keyword as $word){
		$NickName = str_replace($word,'',$NickName);
		$Nation = str_replace($word,'',$Nation);
		$Hometown = str_replace($word,'',$Hometown);
		$Occupation = str_replace($word,'',$Occupation);
		$Hobby = str_replace($word,'',$Hobby);
		$Advantage = str_replace($word,'',$Advantage);
		$defect = str_replace($word,'',$defect);
		$family = str_replace($word,'',$family);
	}
	//判断
	if(empty($NickName)){
		$json['warn'] = "亲，微信名不能为空，资料请全部填写完哦~";
	}else if(preg_match($reg_chinese,$NickName) == 0){
		$json['warn'] = "亲，微信名请填写汉字，资料请全部填写完哦~";
	}else if(empty($sex)){
		$json['warn'] = "亲，性别不能为空，资料请全部填写完哦~";
	}else if(empty($Birthday)){
		$json['warn'] = "亲，生日不能为空，资料请全部填写完哦~";
	}else if(empty($Zodiac)){
		$json['warn'] = "亲，生肖不能为空，资料请全部填写完哦~";
	}else if(empty($constellation)){
		$json['warn'] = "亲，星座不能为空，资料请全部填写完哦~";
	}else if(empty($Nation)){
		$json['warn'] = "亲，民族不能为空，资料请全部填写完哦~";
	}else if(preg_match($reg_chinese,$Nation) == 0){
		$json['warn'] = "亲，民族请填写汉字，资料请全部填写完哦~";
	}else if(empty($height)){
		$json['warn'] = "亲，身高不能为空，资料请全部填写完哦~";
	}else if(strlen($height) > 3){
		$json['warn'] = "亲，身高只能为三位数的egeegergrer5正整数，资料请全部填写完哦~";
	}else if(preg_match($CheckInteger,$height) == 0){
		$json['warn'] = "亲，身高只能为三位数的正整数，资料请全部填写完哦~";
	}else if(empty($weight)){
		$json['warn'] = "亲，体重不能为空，资料请全部填写完哦~";
	}else if(strlen($weight) > 3){
		$json['warn'] = "亲，体重只能为三位数的正整数，资料请全部填写完哦~";
	}else if(preg_match($CheckInteger,$weight) == 0){
		$json['warn'] = "亲，体重只能为三位数的正整数，资料请全部填写完哦~";
	}else if(empty($degree)){
		$json['warn'] = "亲，学历不能为空，资料请全部填写完哦~";
	}else if(empty($marry)){
		$json['warn'] = "亲，婚育状况不能为空，资料请全部填写完哦~";
	}else if(empty($Hometown)){
		$json['warn'] = "亲，家乡不能为空，资料请全部填写完哦~";
	}else if(preg_match($reg_chinese,$Hometown) == 0){
		$json['warn'] = "亲，家乡请填写汉字，资料请全部填写完哦~";
	}else if(empty($RegionId)){
		$json['warn'] = "亲，所在地区不能为空，资料请全部填写完哦~";
	}else if(empty($Occupation)){
		$json['warn'] = "亲，工作不能为空，资料请全部填写完哦~";
	}else if(preg_match($reg_chinese,$Occupation) == 0){
		$json['warn'] = "亲，工作请填写汉字，资料请全部填写完哦~";
	}else if(empty($salary)){
		$json['warn'] = "亲，月收入不能为空，资料请全部填写完哦~";
	}else if(empty($smoke)){
		$json['warn'] = "亲，是否吸烟不能为空，资料请全部填写完哦~";
	}else if(empty($drink)){
		$json['warn'] = "亲，是否饮酒不能为空，资料请全部填写完哦~";
	}else if(empty($BuyHouse)){
		$json['warn'] = "亲，是否购房不能为空，资料请全部填写完哦~";
	}else if(empty($BuyCar)){
		$json['warn'] = "亲，是否购车不能为空，资料请全部填写完哦~";
	}else if(empty($loan)){
		$json['warn'] = "亲，是否贷款不能为空，资料请全部填写完哦~";
	}else if(empty($Hobby)){
		$json['warn'] = "亲，兴趣爱好不能为空，资料请全部填写完哦~";
	}else if(preg_match($reg_match,$Hobby) == 0){
		$json['warn'] = "亲，兴趣爱好不能填写数字或字母，资料请全部填写完哦~";
	}else if(empty($Advantage)){
		$json['warn'] = "亲，优点不能为空，资料请全部填写完哦~";
	}else if(preg_match($reg_match,$Advantage) == 0){
		$json['warn'] = "亲，优点不能填写数字或字母，资料请全部填写完哦~";
	}else if(empty($defect)){
		$json['warn'] = "亲，缺点不能为空，资料请全部填写完哦~";
	}else if(preg_match($reg_match,$defect) == 0){
		$json['warn'] = "亲，缺点不能填写数字或字母，资料请全部填写完哦~";
	}else if(empty($HomeRanking)){
		$json['warn'] = "亲，家中排行不能为空，资料请全部填写完哦~";
	}else if(empty($family)){
		$json['warn'] = "亲，家庭成员不能为空，资料请全部填写完哦~";
	}else if(preg_match($reg_match,$family) == 0){
		$json['warn'] = "亲，家庭成员不能填写数字或字母，资料请全部填写完哦~";
	}else if(empty($wxNum)){
		$json['warn'] = "亲，微信号不能为空，资料请全部填写完哦~";
	}else if(preg_match("/^[0-9a-zA-Z]*$/u",$wxNum) == 0){
		$json['warn'] = "亲，微信号请填写数字或字母，资料请全部填写完哦~";
	}else if(empty($IDCard)){
		$json['warn'] = "亲，身份证号不能为空，资料请全部填写完哦~";
	}else if(preg_match("/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}(\d|x|X)$/",$IDCard) == 0){
		$json['warn'] = "亲，您的身份证号格式不正确，资料请全部填写完哦~";
	}else if(mb_strlen($NickName,"GB2312") < 4 or mb_strlen($NickName,"GB2312") > 12){
		$json['warn'] = "亲，微信名不能小于4个字符且不能大于12个字符";	
	}else{
		$bool = mysql_query("update kehu set
		NickName = '$NickName',
		sex = '$sex',
		Birthday = '$Birthday',
		Zodiac = '$Zodiac',
		constellation = '$constellation',
		Nation = '$Nation',
		height = '$height',
		weight = '$weight',
		degree = '$degree',
		marry = '$marry',
		Hometown = '$Hometown',
		RegionId = '$RegionId',
		Occupation = '$Occupation',
		salary = '$salary',
		smoke = '$smoke',
		drink = '$drink',
		BuyHouse = '$BuyHouse',
		BuyCar = '$BuyCar',
		loan = '$loan',
		Hobby = '$Hobby',
		Advantage = '$Advantage',
		defect = '$defect',
		HomeRanking = '$HomeRanking',
		family = '$family',
		wxNum = '$wxNum',
		IDCard = '$IDCard',
		Auditing = '审核中',
		UpdateTime = '$time' where khid = '$kehu[khid]' ");
		if($bool){
			$_SESSION['warn'] = "基本资料更新成功";	
			$json['warn'] = 2;
		}else{
			$json['warn'] = "基本资料更新失败";	
		}
	}
/*----------------------------个人中心内心独白更新------------------------------------*/					
}else if(isset($_POST['InnerMonologueSummary'])){
	//赋值
	$summary = htmlentities($_POST['InnerMonologueSummary'],ENT_QUOTES,'utf-8');//内心独白
	$keyword = KeyWords();
	foreach($keyword as $word){
		$summary = str_replace($word,'*',$summary);
	}
	//判断
	if(empty($summary)){
		$json['warn'] = "内心独白不能为空";	
	}else if(preg_match("/^[^0-9^a-z^A-Z]*$/u",$summary) == 0){
		$json['warn'] = "内心独白不能填写数字或字母";			
	}else{
		$bool = mysql_query("update kehu set
		summary = '$summary',
		Auditing = '审核中',
		UpdateTime = '$time' where khid = '$kehu[khid]' ");
		if($bool){
			$_SESSION['warn'] = "内心独白更新成功";
			$json['warn'] = 2;	
		}else{
			$json['warn'] = "内心独白更新失败";	
		}	
	}
/*----------------------------个人中心择偶意向更新------------------------------------*/					
}else if(isset($_POST['spouseAgeMin']) and isset($_POST['spouseZodiac'])){
	//赋值
	$keyword = KeyWords();
	$LoveAgeMin = $_POST['spouseAgeMin'];//最小年龄
	$LoveAgeMax = $_POST['spouseAgeMax'];//最大年龄
	$LoveZodiac = $_POST['spouseZodiac'];//生肖
	$LoveConstellation = $_POST['spouseConstellation'];//星座
	$LoveNation = $_POST['spouseNation'];//民族
	$LoveHeightMin = htmlentities($_POST['spouseHeightMin'],ENT_QUOTES,'urf-8');//最小身高
	$LoveHeightMax = htmlentities($_POST['spouseHeightMax'],ENT_QUOTES,'urf-8');//最大身高
	$LoveWeightMin = htmlentities($_POST['spouseWeightMin'],ENT_QUOTES,'urf-8');//最小体重
	$LoveWeightMax = htmlentities($_POST['spouseWeightMax'],ENT_QUOTES,'urf-8');//最大体重
	$LoveDegree = $_POST['spouseDegree'];//学历
	$LoveMarry = $_POST['spouseMarry'];//婚育状况
	$LoveHometown = $_POST['spouseHometown'];//家乡
	$LoveRegionId = $_POST['area2'];//所在区县ID号
	$LoveOccupation = htmlentities($_POST['spouseOccupation'],ENT_QUOTES,'utf-8');//工作
	$LoveSalary = $_POST['spouseSalary'];//月收入
	$LoveSmoke = $_POST['spouseSmoke'];//是否吸烟
	$LoveDrink = $_POST['spouseDrink'];//是否饮酒
	$LoveHouse = $_POST['spouseBuyHouse'];//购房情况
	$LoveCar = $_POST['spouseBuyCar'];//购车情况
	$LoveLoan = $_POST['spouseLoan'];//有无贷款
	$LoveHobby = htmlentities($_POST['spouseHobby'],ENT_QUOTES,'utf-8');//兴趣爱好
	$LoveAdvantage = htmlentities($_POST['spouseAdvantage'],ENT_QUOTES,'utf-8');//优点
	$LoveDefect = htmlentities($_POST['spouseShortcoming'],ENT_QUOTES,'utf-8');//缺点
	$LoveHomeRanking = $_POST['spouseHomerank'];//家中排行
	$LoveFamily = $_POST['spouseFamily'];//家庭成员
	$reg_chinese = "/^[\x{4e00}-\x{9fa5}]+$/u";
	$reg_match = "/^[^0-9^a-z^A-Z]*$/u";
	$keyword = KeyWords();
	foreach($keyword as $word){
		$LoveNation = str_replace($word,'',$LoveNation);
		$LoveHometown = str_replace($word,'',$LoveHometown);
		$LoveOccupation = str_replace($word,'',$LoveOccupation);
		$LoveHobby = str_replace($word,'',$LoveHobby);
		$LoveAdvantage = str_replace($word,'',$LoveAdvantage);
		$LoveDefect = str_replace($word,'',$LoveDefect);
		$LoveFamily = str_replace($word,'',$LoveFamily);
	}
	//判断
	if(empty($LoveAgeMin)){
		$json['warn'] = "亲，年龄不能为空，择偶意向请全部填写完哦~";
	}else if(empty($LoveAgeMax)){
		$json['warn'] = "亲，年龄不能为空，择偶意向请全部填写完哦~";
	}else if(strlen($LoveAgeMin) > 2){
		$json['warn'] = "亲，年龄只能为两位数的正整数，择偶意向请全部填写完哦~";
	}else if(preg_match($CheckInteger,$LoveAgeMin) == 0){
		$json['warn'] = "亲，年龄只能为两位数的正整数，择偶意向请全部填写完哦~";
	}else if(strlen($LoveAgeMax) > 2){
		$json['warn'] = "亲，年龄只能为两位数的正整数，择偶意向请全部填写完哦~";
	}else if(preg_match($CheckInteger,$LoveAgeMax) == 0){
		$json['warn'] = "亲，年龄只能为两位数的正整数，择偶意向请全部填写完哦~";
	}else if(empty($LoveZodiac)){
		$json['warn'] = "亲，生肖不能为空，择偶意向请全部填写完哦~";
	}else if(empty($LoveConstellation)){
		$json['warn'] = "亲，星座不能为空，择偶意向请全部填写完哦~";
	}else if(empty($LoveNation)){
		$json['warn'] = "亲，民族不能为空，择偶意向请全部填写完哦~";
	}else if(preg_match($reg_chinese,$LoveNation) == 0){
		$json['warn'] = "亲，民族请填写汉字，择偶意向请全部填写完哦~";
	}else if(empty($LoveHeightMin)){
		$json['warn'] = "亲，身高不能为空，择偶意向请全部填写完哦~";
	}else if(empty($LoveHeightMax)){
		$json['warn'] = "亲，身高不能为空，择偶意向请全部填写完哦~";
	}else if(strlen($LoveHeightMin) > 3){
		$json['warn'] = "亲，身高只能为三位数的正整数，择偶意向请全部填写完哦~";
	}else if(preg_match($CheckInteger,$LoveHeightMin) == 0){
		$json['warn'] = "亲，身高只能为三位数的正整数，择偶意向请全部填写完哦~";
	}else if(strlen($LoveHeightMax) > 3){
		$json['warn'] = "亲，身高只能为三位数的正整数，择偶意向请全部填写完哦~";
	}else if(preg_match($CheckInteger,$LoveHeightMax) == 0){
		$json['warn'] = "亲，身高只能为三位数的正整数，择偶意向请全部填写完哦~";
	}else if(empty($LoveWeightMin)){
		$json['warn'] = "亲，体重不能为空，择偶意向请全部填写完哦~";
	}else if(empty($LoveWeightMax)){
		$json['warn'] = "亲，体重不能为空，择偶意向请全部填写完哦~";
	}else if(strlen($LoveWeightMin) > 3){
		$json['warn'] = "亲，体重只能为三位数的正整数，择偶意向请全部填写完哦~";
	}else if(preg_match($CheckInteger,$LoveWeightMin) == 0){
		$json['warn'] = "亲，体重只能为三位数的正整数，择偶意向请全部填写完哦~";
	}else if(strlen($LoveWeightMax) > 3){
		$json['warn'] = "亲，体重只能为三位数的正整数，择偶意向请全部填写完哦~";
	}else if(preg_match($CheckInteger,$LoveWeightMax) == 0){
		$json['warn'] = "亲，体重只能为三位数的正整数，择偶意向请全部填写完哦~";		
	}else if(empty($LoveDegree)){
		$json['warn'] = "亲，学历不能为空，择偶意向请全部填写完哦~";
	}else if(empty($LoveMarry)){
		$json['warn'] = "亲，婚育状况不能为空，择偶意向请全部填写完哦~";
	}else if(empty($LoveHometown)){
		$json['warn'] = "亲，家乡不能为空，择偶意向请全部填写完哦~";
	}else if(preg_match($reg_chinese,$LoveHometown) == 0){
		$json['warn'] = "亲，家乡请填写汉字，择偶意向请全部填写完哦~";
	}else if(empty($LoveOccupation)){
		$json['warn'] = "亲，工作不能为空，择偶意向请全部填写完哦~";
	}else if(preg_match($reg_chinese,$LoveOccupation) == 0){
		$json['warn'] = "亲，工作请填写汉字，择偶意向请全部填写完哦~";
	}else if(empty($LoveSalary)){
		$json['warn'] = "亲，月收入不能为空，择偶意向请全部填写完哦~";
	}else if(empty($LoveSmoke)){
		$json['warn'] = "亲，是否吸烟不能为空，择偶意向请全部填写完哦~";
	}else if(empty($LoveDrink)){
		$json['warn'] = "亲，是否饮酒不能为空，择偶意向请全部填写完哦~";
	}else if(empty($LoveHouse)){
		$json['warn'] = "亲，是否有房不能为空，择偶意向请全部填写完哦~";
	}else if(empty($LoveCar)){
		$json['warn'] = "亲，是否有车不能为空，择偶意向请全部填写完哦~";
	}else if(empty($LoveLoan)){
		$json['warn'] = "亲，是否贷款不能为空，择偶意向请全部填写完哦~";
	}else if(empty($LoveHobby)){
		$json['warn'] = "亲，兴趣爱好不能为空，择偶意向请全部填写完哦~";
	}else if(preg_match($reg_match,$LoveHobby) == 0){
		$json['warn'] = "亲，兴趣爱好不能为数字或字母，择偶意向请全部填写完哦~";
	}else if(empty($LoveAdvantage)){
		$json['warn'] = "亲，优点不能为空，择偶意向请全部填写完哦~";
	}else if(preg_match($reg_match,$LoveAdvantage) == 0){
		$json['warn'] = "亲，优点不能为数字或字母，择偶意向请全部填写完哦~";
	}else if(empty($LoveDefect)){
		$json['warn'] = "亲，缺点不能为空，择偶意向请全部填写完哦~";
	}else if(preg_match($reg_match,$LoveDefect) == 0){
		$json['warn'] = "亲，缺点不能为数字或字母，择偶意向请全部填写完哦~";
	}else if(empty($LoveHomeRanking)){
		$json['warn'] = "亲，家中排行不能为空，择偶意向请全部填写完哦~";
	}else if(empty($LoveFamily)){
		$json['warn'] = "亲，家庭成员不能为空，择偶意向请全部填写完哦~";
	}else if(preg_match($reg_match,$LoveFamily) == 0){
		$json['warn'] = "亲，家庭成员不能为数字或字母，择偶意向请全部填写完哦~";
	}else{
		$bool = mysql_query("update kehu set 
	LoveAgeMin = '$LoveAgeMin',
	LoveAgeMax = '$LoveAgeMax',
	LoveZodiac = '$LoveZodiac',
	LoveConstellation = '$LoveConstellation',
	LoveNation = '$LoveNation',
	LoveHeightMin = '$LoveHeightMin',
	LoveHeightMax = '$LoveHeightMax',
	LoveWeightMin = '$LoveWeightMin',
	LoveWeightMax = '$LoveWeightMax',
	LoveDegree = '$LoveDegree',
	LoveMarry = '$LoveMarry',
	LoveHometown = '$LoveHometown',
	LoveRegionId = '$LoveRegionId',
	LoveOccupation = '$LoveOccupation',
	LoveSalary = '$LoveSalary',
	LoveSmoke = '$LoveSmoke',
	LoveDrink = '$LoveDrink',
	LoveHouse = '$LoveHouse',
	LoveCar = '$LoveCar',
	LoveLoan = '$LoveLoan',
	LoveHobby = '$LoveHobby',
	LoveAdvantage = '$LoveAdvantage',
	LoveDefect = '$LoveDefect',
	LoveHomeRanking = '$LoveHomeRanking',
	LoveFamily = '$LoveFamily',
	Auditing = '审核中',
	UpdateTime = '$time' where khid = '$kehu[khid]' ");
		if($bool){
			$_SESSION['warn'] = "择偶意向更新成功";	
			$json['warn'] = 2;
		}else{
			$json['warn'] = "择偶意向更新失败";	
		}
	}
/*---------------------------打招呼------------------------------------*/					
}else if(isset($_POST['sayHi'])){
	//赋值
	$text = $kehu['NickName']."向你打招呼了~请赶快回复吧~";//打招呼的内容
	$TargetId = $_POST['sayHi'];//收件客户的ID号
	$TargetKehu = mysql_fetch_assoc(mysql_query("select * from kehu where khid = '$TargetId' "));
	$t = date("Y-m-d H:i:s",(time() - 60));//当前时间减去60秒
	$num = mysql_num_rows(mysql_query("select * from message where khid = '$kehu[khid]' and TargetId = '$TargetId' and text = '$text' and time > '$t' "));
	//判断
	if($num > 0){
		$json['warn'] = "亲~你刚刚才打过招呼呢~"; 	
	}else{
		$id = suiji();
		$bool = mysql_query("insert into message (id,khid,TargetId,text,time) values ('$id','$kehu[khid]','$TargetId','$text','$time') ");	
			if($bool){
			$json['warn'] = "你向".$TargetKehu['NickName']."打招呼成功";
		}else{
		    $json['warn'] = "打招呼失败";
		}
	}
/*---------------------------发送信件------------------------------------*/					
}else if(isset($_POST['sendLetter'])){
	//赋值
	$text = htmlentities($_POST['sendLetter'],ENT_COMPAT,"utf-8");//发送信件内容
	$TargetId = $_POST['TargetId'];//收件客户的ID号
	$t = date("Y-m-d H:i:s",(time() - 60));//当前时间减去60秒
	$num = mysql_num_rows(mysql_query("select * from  message where khid = '$kehu[khid]' and TargetId = '$TargetId' and text = '$text' and time < '$t' "));
	//包年包月发信
	$minMonth = date("Y-m-d H:i:s",strtotime("$time - 1 month"));//当前时间减去一个月
	$payMonth = mysql_num_rows(mysql_query(" select * from pay where classify = '发信包月' and khid = '$kehu[khid]' and WorkFlow = '已支付' and UpdateTime > '$minMonth' "));
	$minYear = date("Y-m-d H:i:s",strtotime("$time - 1 year"));//当前时间减去一年
	$payYear = mysql_num_rows(mysql_query(" select * from pay where classify = '发信包年' and khid = '$kehu[khid]' and WorkFlow = '已支付' and UpdateTime > '$minYear' "));
	//判断
	if(empty($text)){
		$json['warn'] = "亲~发布内容不能为空哟~";
	}else if($num > 0){
		$json['warn'] = "亲~请勿重复提交哟~";	
	}else if($payMonth == 0 and $payYear == 0 and $kehu['letterEndTime'] < $time){
		$json['warn'] = "亲~发信需要包月包年哦~";	
	}else{
		$id = suiji();
		$bool = mysql_query(" insert into message (id,khid,TargetId,text,time) values ('$id','$kehu[khid]','$TargetId','$text','$time') ");
		if($bool){
			$_SESSION['warn'] = "发布成功";
			$json['warn'] = 2;
		}else{
		    $json['warn'] = "发布失败";
		}	
	}
/*------------------删除个人中心我的相册图片-------------------------------------------------*/
}else if(isset($_GET['deletePhotoImg'])){
	//赋值
	$id = $_GET['deletePhotoImg'];//我的相册的图片ID号
	$kehuImg = mysql_fetch_array(mysql_query("select * from kehuImg where id = '$id' "));
	//判断
	if(empty($id)){
		$_SESSION['warn'] = '图片的id号不能为空';	
	}else if($kehuImg['id'] != $id){
		$_SESSION['warn'] = '图片不存在';	
	}else{
		$bool = mysql_query("delete from kehuImg where id = '$id' ");
		//删除图片函数
		unlink(ServerRoot.$kehuImg['src']);	
		if($bool){
			$_SESSION['warn'] = "我的相册图片删除成功";
			$json['warn'] = 2;
		}else{
			$_SESSION['warn'] = "我的相册图片删除失败";	
		}
	}	
/*---------------------------我收到的信件------------------------------------*/					
}elseif(isset($_POST['sendLetterId'])){
	//赋值
	$messageId = $_POST['sendLetterId'];//信件的ID号
	$message = mysql_fetch_assoc(mysql_query("select * from message where id = '$messageId' "));//信件
	//判断
	if(empty($messageId)){
		$json['warn'] = "信件ID号为空";	
	}else if($message['id'] != $messageId){
		$json['warn'] = "未找到这个信件";
	}else{
		$text = "";
		if(!empty($message['ReplyTarget'])){
			$LastMessage = mysql_fetch_assoc(mysql_query("select * from message where id='$message[ReplyTarget]' "));
			$text .= "您：".$LastMessage['text']."\n";
		}
		$text .="TA：".$message['text'];
		$json['receive'] = neirong($text);
		$Reply = mysql_fetch_assoc(mysql_query("select * from message where ReplyTarget = '$messageId' "));
		$json['text'] = $Reply['text'];
		$json['id'] = $message['id'];
		$json['warn'] = 2;	
	}
/*---------------------------回复收到的信件------------------------------------*/					
}else if(isset($_POST['messageReplyText'])){
	//赋值
	$ReplyText = htmlentities($_POST['messageReplyText'],ENT_COMPAT,"utf-8");//回复信件内容
	$messageId = $_POST['messageId'];//消息的ID号
	$message = mysql_fetch_assoc(mysql_query("select * from message where id='$messageId' "));
	//判断
	if(empty($messageId)){
	    $json['warn'] = "信息的ID号为空";
	}elseif($message['id'] != $messageId){
		$json['warn'] = "未找到此条信息";
	}elseif(empty($ReplyText)) {
		$json['warn'] = "亲~回复内容不能为空哟~";
	}else{
		$id = suiji();
		$bool = mysql_query(" insert into message (id,khid,TargetId,text,ReplyTarget,UpdateTime,time) 
		values ('$id','$kehu[khid]','$message[khid]','$ReplyText','$messageId','$time','$time') ");
		if($bool){
			$_SESSION['warn'] = "回复成功";
			$json['warn'] = 2;
		}else{
		    $json['warn'] = "回复失败";
		}
	}
/*---------------------------加关注/取消关注------------------------------------*/					
}else if(isset($_POST['follow'])){
	//赋值
	$TargetId = $_POST['follow'];//被看过的客户的ID号
	$follow = query("follow"," type = '1' and khid = '$kehu[khid]' and TargetId = '$TargetId' ");
	if(empty($follow['id'])){
		$id = suiji();
		$bool = mysql_query(" insert into follow (id,type,khid,TargetId,time) values ('$id','1','$kehu[khid]','$TargetId','$time') ");
		if($bool){
			$json['warn'] = "关注成功";
			$json['flag'] = 2;
		}else{
		    $json['warn'] = "关注失败";
		}
	}else{
		if(mysql_query("delete from follow where id = '$follow[id]' ")){
			$json['warn'] = "取消成功";
		}else{
			$json['warn'] = "取消失败";
		}
	}
/*---------------------------推广分页------------------------------------*/					
}else if(isset($_GET['act']) and $_GET['act'] == 'share'){
	$page = $_GET['page'];
	$json = share($page);
}
echo json_encode($json);
?>