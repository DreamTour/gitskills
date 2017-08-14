<?php
include "OpenFunction.php";
/*--------------------------用户登录---------------------------------------------*/
if(isset($_POST['usLoginTel']) and isset($_POST['usLoginPassword'])){
	//赋值
	$type = $_GET['type'];
	$khtel = $_POST['usLoginTel'];//用户登录账号/手机号码
	$khpas = $_POST['usLoginPassword'];//用户登录密码
	//判断
	if(empty($khtel)){
		$json['warn'] = "请输入账号（手机号码）";	
	}else if(preg_match($CheckTel,$khtel) == 0){
		$json['warn'] = "手机号码格式有误";	
	}else if(empty($khpas)){
		$json['warn'] = "请输入登录密码";	
	}else{
		$ExistTel = mysql_num_rows(mysql_query("select * from kehu where khtel = '$khtel' "));
		$kehu = mysql_fetch_array(mysql_query("select * from kehu where khtel = '$khtel' and khpas = '$khpas' "));
		if($ExistTel == 0){
			$json['warn'] = "本手机号码未注册";	
		}else if($kehu['khtel'] != $khtel){
			$json['warn'] = "登录账号(手机号码)或密码错误";	
		}else{
			if($type == 'm'){
				$json['href'] = "{$root}m/user/mUser.php";
			}else{
				$json['href'] = "{$root}user/user.php";
			}
			$_SESSION['khid'] = $kehu['khid'];
			$json['warn'] = "2";	
		}	
	}
/*-----------------优职查询表单提交返回数据-------------------------------------------------------------*/
}elseif(isset($_POST['searchJobKey'])){	
	//赋值
	$province = $_POST['province'];//省份
	$city = $_POST['city'];//城市
	$area = $_POST['area'];//区县
	$type = $_POST['searchColumn'];//一级分类
	$name = $_POST['searchColumnChild'];//二级分类
	$key = $_POST['searchJobKey'];//搜索关键词
	$money = $_POST['searchMoney'];//劳务薪酬
	$searchType = $_POST['searchType'];//劳务类型
	$searchMode = $_POST['searchMode'];//提供方式
	$searchJobTag = $_POST['searchJobTag'];//搜索劳务标签
	$Subject = $_POST['searchSubject'];//劳务主体
	$where = " where 1=1 ";
	//判断
	if(!empty($province)){
	    if(empty($city)){
		    $where .= " and khid in ( select khid from kehu where RegionId in ( select id from region where province = '$province' ) )";
		}else{
			if(empty($area)){
				$where .= " and khid in ( select khid from kehu where RegionId in ( select id from region where province = '$province' and city = '$city' ) )";
			}else{
			    $where .= " and khid in ( select khid from kehu where RegionId = '$area' ) ";
			}
		}
	}
	if(!empty($type)){
	    if(empty($name)){
		    //$where .= " and ( ClassifyId = '1' or ClassifyId = '2' or ClassifyId = '3' or ClassifyId = '4' or ClassifyId = '5' or ClassifyId = '6' ) ";
		    //$where .= " and ClassifyId in ('1','2','3','4','5','6') ";
		    $where .= " and ClassifyId in ( select id from classify where type = '$type' ) ";
		}else{
		    $where .= " and ClassifyId = '$name' ";
		}
	}
	if(!empty($key)){
		$where .= " and ( title like '%$key%' or text like '%$key%' or KeyWord like '%$key%' ) ";
	}
	if (!empty($money)) {
		if ($money == "面议") {
			$where .= " and payType = '面议' ";

		}
		else if ($money == "如约") {
			$where .= " and payType = '如约' ";
		}
		else if ($money == "20000及以上") {
			$where .= " and pay > 20000 ";
		}
		else {
		   $pay = explode("-",$money);
		   $where .= "and payType = '薪酬' and pay >= '$pay[0]' and pay < '$pay[1]' ";
		}
	}
	if(!empty($searchType)){
		$where .= "and type = '$searchType'";	
	}
	if(!empty($searchMode)){
		$where .= "and mode = '$searchMode'";	
	}
	if(!empty($Subject)){
		$where .= "and IdentityType = '$Subject'";	
	}
	//查询返回结果
	$demandSql = mysql_query(" select * from demand {$where} order by UpdateTime desc " );
	$message = "<ul class='search-co-list clearfix'><li style='color: #F44336;'>没有您要的信息?去发布一条吧！</li></ul>";
	if(mysql_num_rows($demandSql) == 0){
		$json['html'] = $message;
	}else{
		while($array = mysql_fetch_array($demandSql)){
			$kehu = query("kehu","khid = '$array[khid]'");
			$company = query("company","khid = '$kehu[khid]'");
			$UpdateTime = substr($array['UpdateTime'],0,10);
			$address = query("region", "id = '$kehu[RegionId]' ");
			//判断收费类型，根据收费类型显示内容
			if ($array['payType'] == "薪酬") {
				$pay = "{$array['pay']}/{$array['PayCycle']}";
			}
			else {
				$pay = $array['payType'];
			}

			$json['html'] .= "
				<ul class='search-co-list clearfix'>
					<a href='{$root}recruit.php?demandMx_id={$array['id']}' style='display:inline-block'>
						<li class='search-co01'><input type='checkbox'>{$array['title']}</li>
						<li class='search-co02'>{$kehu['ContactName']}</li>
						<li class='search-co03'>{$address['city']}-{$address['area']}</li>
						<li class='search-co04'>{$pay}</li>
						<li class='search-co05'>{$UpdateTime}</li>
					</a>
				</ul>
			";	
		}
		$json['html'] .= $message;
	}
/*-----------------优才查询表单提交返回数据-------------------------------------------------------------*/
}elseif(isset($_POST['searchTalentKey'])){	
	//赋值
	$province = $_POST['province'];//省份
	$city = $_POST['city'];//城市
	$area = $_POST['area'];//区县
	$type = $_POST['searchColumn'];//一级分类
	$name = $_POST['searchColumnChild'];//二级分类
	$key = $_POST['searchTalentKey'];//搜索关键词
	$money = $_POST['searchMoney'];//劳务薪酬
	$searchType = $_POST['searchType'];//劳务类型
	$searchMode = $_POST['searchMode'];//提供方式
	$minYear = $_POST['searchMinYear'];//最小年龄
	$maxYear = $_POST['searchMaxYear'];//最大年龄
	$Subject = $_POST['searchSubject'];//劳务主体
	$where = " where 1=1 ";
	//判断
	if(!empty($province)){
	    if(empty($city)){
		    $where .= " and khid in ( select khid from kehu where RegionId in ( select id from region where province = '$province' ) )";
		}else{
			if(empty($area)){
				$where .= " and khid in ( select khid from kehu where RegionId in ( select id from region where province = '$province' and city = '$city' ) )";
			}else{
			    $where .= " and khid in ( select khid from kehu where RegionId = '$area' ) ";
			}
		}
	}
	if(!empty($type)){
	    if(empty($name)){
		    //$where .= " and ( ClassifyId = '1' or ClassifyId = '2' or ClassifyId = '3' or ClassifyId = '4' or ClassifyId = '5' or ClassifyId = '6' ) ";
		    //$where .= " and ClassifyId in ('1','2','3','4','5','6') ";
		    $where .= " and ClassifyId in ( select id from classify where type = '$type' ) ";
		}else{
		    $where .= " and ClassifyId = '$name' ";
		}
	}
	if(!empty($key)){
		$where .= " and ( title like '%$key%' or text like '%$key%' or KeyWord like '%$key%' ) ";
	}
	if (!empty($money)) {
		if ($money == "面议") {
			$where .= " and payType = '面议' ";

		}
		else if ($money == "如约") {
			$where .= " and payType = '如约' ";
		}
		else if ($money == "20000及以上") {
			$where .= " and pay > 20000 ";
		}
		else {
			$pay = explode("-",$money);
			$where .= "and payType = '薪酬' and pay >= '$pay[0]' and pay < '$pay[1]' ";
		}
	}
	if(!empty($searchType)){
		$where .= "and type = '$searchType'";	
	}
	if(!empty($searchMode)){
		$where .= "and mode = '$searchMode'";	
	}
	if(!empty($Subject)){
		$where .= "and IdentityType = '$Subject'";	
	}
	//查询返回结果
	$supplySql = mysql_query(" select * from supply {$where} order by UpdateTime desc " );
	$message = "<ul class='search-co-list clearfix'><li style='color: #F44336;'>没有您要的信息?去发布一条吧！</li></ul>";
	if(mysql_num_rows($supplySql) == 0){
		$json['html'] = $message;
	}else{
		while($array = mysql_fetch_array($supplySql)){
			$client = query("kehu","khid = '$array[khid]'");
			$personal = query("personal","khid = '$client[khid]'");
			$age = date("Y") - substr($personal['Birthday'],0,4);
			//判断是企业供给的情况下性别，年龄，学历是否为空
			if ($personal['sex'] == "") {
				$personal['sex'] = "--";
			}
			if ($age == "2017") {
				$age = "--";
			}
			if ($personal['EducationLevel'] == "") {
				$personal['EducationLevel'] = "--";
			}
			//判断收费类型，根据收费类型显示内容
			if ($array['payType'] == "薪酬") {
				$pay = "{$array['pay']}/{$array['PayCycle']}";
			}
			else {
				$pay = $array['payType'];
			}
			//判断我是个人还是商家，显示对应的名称
			if ($array['IdentityType'] == "商家") {
				$ContactName = $array['CompanyName'];
			}
			else {
				$ContactName = $client['ContactName'];
			}
			$json['html'] .= "
				<ul class='search-co-list clearfix'>
					<a href='{$root}JobMx.php?supplyMx_id={$array['id']}' style='display:inline-block'>
						<li class='search-ta01'><input name='items' type='checkbox'>{$array['title']}</li>
						<li class='search-ta02'>{$ContactName}</li>
						<li class='search-ta03'>{$personal['sex']}</li>
						<li class='search-ta04'>{$age}</li>
						<li class='search-ta05'>{$personal['EducationLevel']}</li>
						<li class='search-ta06'>{$pay}</li>
					</a>
				</ul>
			";
		}
		$json['html'] .= $message;
	}	
/*-----------------学生兼职查询表单提交返回数据-------------------------------------------------------------*/
}elseif(isset($_POST['searchPartKey'])){	
	//赋值
	$province = $_POST['province'];//省份
	$city = $_POST['city'];//城市
	$area = $_POST['area'];//区县
	$type = $_POST['searchColumn'];//一级分类
	$name = $_POST['searchColumnChild'];//二级分类
	$key = $_POST['searchPartKey'];//搜索关键词
	$money = $_POST['searchMoney'];//劳务薪酬
	$searchType = $_POST['searchType'];//劳务类型
	$searchMode = $_POST['searchMode'];//提供方式
	$Subject = $_POST['searchSubject'];//劳务主体
	$where = " where ClassifyId in (select id from classify where type in ('服务/市场','私教/培训')) ";
	//判断
	if(!empty($province)){
	    if(empty($city)){
		    $where .= " and khid in ( select khid from kehu where RegionId in ( select id from region where province = '$province' ) )";
		}else{
			if(empty($area)){
				$where .= " and khid in ( select khid from kehu where RegionId in ( select id from region where province = '$province' and city = '$city' ) )";
			}else{
			    $where .= " and khid in ( select khid from kehu where RegionId = '$area' ) ";
			}
		}
	}
	if(!empty($type)){
	    if(empty($name)){
		    //$where .= " and ( ClassifyId = '1' or ClassifyId = '2' or ClassifyId = '3' or ClassifyId = '4' or ClassifyId = '5' or ClassifyId = '6' ) ";
		    //$where .= " and ClassifyId in ('1','2','3','4','5','6') ";
		    $where .= " and ClassifyId in ( select id from classify where type = '$type' ) ";
		}else{
		    $where .= " and ClassifyId = '$name' ";
		}
	}
	if(!empty($key)){
		$where .= " and ( title like '%$key%' or text like '%$key%' or KeyWord like '%$key%' ) ";
	}
	if (!empty($money)) {
		if ($money == "面议") {
			$where .= " and payType = '面议' ";

		}
		else if ($money == "如约") {
			$where .= " and payType = '如约' ";
		}
		else if ($money == "20000及以上") {
			$where .= " and pay > 20000 ";
		}
		else {
			$pay = explode("-",$money);
			$where .= "and payType = '薪酬' and pay >= '$pay[0]' and pay < '$pay[1]' ";
		}
	}
	if(!empty($searchType)){
		$where .= "and type = '$searchType'";	
	}
	if(!empty($searchMode)){
		$where .= "and mode = '$searchMode'";	
	}
	if(!empty($Subject)){
		$where .= "and IdentityType = '$Subject'";	
	}
	//查询返回结果
	$demandSql = mysql_query(" select * from demand {$where} order by UpdateTime desc " );
	$message = "<ul class='search-co-list clearfix'><li style='color: #F44336;'>没有您要的信息?去发布一条吧！</li></ul>";
	if(mysql_num_rows($demandSql) == 0){
		$json['html'] = $message;
	}else{
		while($array = mysql_fetch_array($demandSql)){
			$kehu = query("kehu","khid = '$array[khid]'");
			$company = query("company","khid = '$kehu[khid]'");
			$UpdateTime = substr($array['UpdateTime'],0,10);
			$address = query("region", "id = '$kehu[RegionId]' ");
			//判断收费类型，根据收费类型显示内容
			if ($array['payType'] == "薪酬") {
				$pay = "{$array['pay']}/{$array['PayCycle']}";
			}
			else {
				$pay = $array['payType'];
			}
			$json['html'] .= "
				<ul class='search-co-list clearfix'>
					<a href='{$root}recruit.php?demandMx_id={$array['id']}' style='display:inline-block'>
						<li class='search-co01'><input type='checkbox'>{$array['title']}</li>
						<li class='search-co02'>{$kehu['ContactName']}</li>
						<li class='search-co03'>{$address['city']}-{$address['area']}</li>
						<li class='search-co04'>{$pay}</li>
						<li class='search-co05'>{$UpdateTime}</li>
					</a>
				</ul>
			";	
		}
		$json['html'] .= $message;
	}	
/*-----------------搜索分类根据主项目返回子项目-------------------------------------------------------------*/
}elseif(isset($_POST['searchColumnTwoChild'])){
	$type = $_POST['searchColumnTwoChild'];//主项目
	$json['ColumnChild'] = IdOption("classify where type = '$type' ","id","name","请选择劳务子项目","");			
/*--------------------------用户注册---------------------------------------------*/
}else if(isset($_POST['phone']) and isset($_POST['password'])){
	//赋值
	$sex = $_POST['sex'];//性别
	$Birthday = $_POST['year']."-".$_POST['moon']."-".$_POST['day'];//生日
	$RegionId = $_POST['area'];//所在区县ID号
	$marry = $_POST['marry'];//婚姻状况
	$shareCode = $_POST['shareCode'];//分享码
	$khtel = $_POST['phone'];//手机号
	$prove = $_POST['verificationCode'];//验证码
	$khpas = $_POST['password'];//创建密码
	$truepas = $_POST['truePassword'];//确认密码
	$NickName = $_POST['nickName'];//昵称
	$summary = $_POST['summary'];//内心独白
	$agreement = $_POST['agree'];//客户是否点击同意注册条款和免责声明
	
	//判断
	if(empty($sex)){
		$json['warn'] = "请选择性别";	
	}else if(empty($khtel)){
		$json['warn'] = "请输入手机号码";	
	}else if(preg_match($CheckTel,$khtel) == 0){
		$json['warn'] = "手机号码格式有误";	
	}else if(mysql_num_rows(mysql_query("select * from kehu where khtel = '$khtel' ")) > 0){
		$json['warn'] = "本手机号码已经注册";	
	}else if(empty($prove)){
		$json['warn'] = "请输入验证码";	
	}else if($_SESSION['Prove']['tel'] != $khtel){
		$json['warn'] = "请使用接受验证短信的手机号码注册！";	
	}else if($prove != $_SESSION['Prove']['rand']){
		$json['warn'] = "手机验证码输入错误！";
	}else if(empty($khpas)){
		$json['warn'] = "请输入密码";
	}else if(strlen($khpas) < 6 || strlen($khpas) > 16){
		$json['warn'] = "密码不能小于六位或大于16位";	
	}else if($khpas != $truepas){
		$json['warn'] = "两次密码输入不一致";	
	}else if(empty($NickName)){
		$json['warn'] = "请输入微信名";	
	}else if($agreement != "yes"){
		$json['warn'] = "请阅读并同意注册条款和隐私保护";	
	}else{
		$khid = suiji();
		if(empty($shareCode)){
			$shareId = "";	
		}else{
			$share = query("kehu","khtel = '$shareCode' ");
			if($share['khtel'] != $shareCode){
				$json['warn'] = "分享码填写错误";	
			}else{
				$shareId = $share['khid'];
				//给推荐人叠加免费发信时间
				$OneTime = 86400;//一天的时间
				if($share['letterEndTime'] < $time){
					$letterEndTime = date("Y-m-d H:i:s",(time() + $OneTime));//当前时间加上一天的时间
				}else{
					$letterEndTime = date("Y-m-d H:i:s",(strtotime($share['letterEndTime']) + $OneTime));//没用完的时间加上一天的时间
				}
				mysql_query("update kehu set letterEndTime = '$letterEndTime' where khid = '$shareId' ");
			}
		}
		if(empty($json['warn'])){
			$bool = mysql_query("insert into kehu 
			(khid,NickName,sex,khtel,khpas,summary,RegionId,marry,Birthday,ShareId,UpdateTime,time) values
			('$khid','$NickName','$sex','$khtel','$khpas','$summary','$RegionId','$marry','$Birthday','$shareId','$time','$time') ");
			if($bool){
				$_SESSION['khid'] = $khid;
				$json['warn'] = "2";
				$json['href'] = "{$root}user/user.php";	
			}else{
				$json['warn'] = "注册失败";	
			}
		}
	}
/*------------------新增或更新个人中心我的头像-------------------------------------------------*/
}else if(isset($_FILES['headPortraitUpload'])){
	$FileName = "headPortraitUpload";//上传图片的表单文件域名称
	$cut['type'] = "需要裁剪";//"需要裁剪"或"需要缩放"或空
	$cut['width'] = "480";//裁剪宽度
	$cut['height'] = "600";//裁剪高度
	$cut['NewWidth'] = "";//缩放的宽度
	$cut['MaxHeight'] = "";//缩放后图片的最大高度
	$type['name'] = "更新图像";//"更新图像"or"新增图像"
	$type['num'] = 9;//新增图像时限定的图像总数
	$sql = " select * from kehu where khid = '$kehu[khid]' ";//查询图片的数据库代码
	$column = "ico";//保存图片的数据库列的名称
	$suiji = suiji();
	$Url['root'] = "../";//图片处理页相对于网站根目录的级差，如差一级及标注为（../）
	$Url['NewImgUrl'] = "img/usHead/{$suiji}.jpg";//新图片保存的网站根目录位置
	$NewImgSql = "update kehu set {$column} = '$Url[NewImgUrl]',UpdateTime = '$time' where khid = '$kehu[khid]' ";
	$ImgWarn = "我的头像更新成功";//图片保存成功后返回的文字内容
	UpdateImg($FileName,$cut,$type,$sql,$column,$Url,$NewImgSql,$ImgWarn);	
/*------------------网站顶部根据省份返回城市-------------------------------------------------*/
}else if(isset($_POST['ProvinceBackCity'])){
	$Province = $_POST['ProvinceBackCity'];//省份
	$regionSql = mysql_query("select distinct city from region where Province = '$Province' ");
	$json['html'] = "";
	while($region = mysql_fetch_assoc($regionSql)){
		$json['html'] .= "<a class='partCity' href='javascript:;'>{$region['city']}</a>"; 
	}
}
/*-----------------返回信息---------------------------------------------------------*/
echo json_encode($json);
?>