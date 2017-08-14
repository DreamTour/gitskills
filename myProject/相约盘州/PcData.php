<?php            
include "OpenFunction.php";
/*--------------------------代理商注册-----------------------------------------------------------------------------------------------------*/
if(isset($_POST['agPhone']) and isset($_POST['agPassword']) and isset($_POST['agPhoneyzm'])){
   //赋值
   $tel = $_POST['agPhone'];
   $pas = $_POST['agPassword'];
   $prove = $_POST['agPhoneyzm'];
   //判断
   if(empty($tel)){
       $json['warn'] = "请输入手机号码";
   }elseif(preg_match($CheckTel,$tel) == 0){
       $json['warn'] = "手机号码格式有误";
   }elseif(empty($pas)){
       $json['warn'] = "请输入密码";
   }elseif(strlen($pas) < 6 || strlen($pas) > 20){
       $json['warn'] = "密码不得小于六位或大于20位";
   }elseif(empty($prove)){
       $json['warn'] = "请输入手机验证码";
   }elseif($prove != $_SESSION['Prove']['rand']){
       $json['warn'] = "手机验证码输入错误！";
   }elseif($_SESSION['Prove']['tel'] != $tel){
		$json['warn'] = "请使用接受验证短信的手机号码注册！";
   }elseif($_POST['agreement'] != "yes"){
       $json['warn'] = "请同意网站服务协议";
   }else{
	   //判断手机号码是否已经注册
	   $RepeatTel = mysql_num_rows(mysql_query("select * from agent where agtel = '$tel' "));
	   if($RepeatTel > 0){
	       $json['warn'] = "这个手机号码已经注册了";
	   }else{
			//注册并获得sission
			$suiji = suiji();
			if(mysql_query("insert into agent (agid,agtel,agpas,UpdateTime,time) values ('$suiji','$tel','$pas','$time','$time');")){
				$_SESSION['agid'] = $suiji;
				$json['warn'] = 2;
			}else{
				$json['warn'] = "注册失败";
			}
	   }
   }
/*--------------------------商户注册---------------------------------------------------------------------------------------------------------*/
}elseif(isset($_POST['seRegisterTel']) and isset($_POST['seRegisterPas']) and isset($_POST['seRegisterProve'])){
	//赋值
	$tel = $_POST['seRegisterTel'];
	$pas = $_POST['seRegisterPas'];
	$prove = $_POST['seRegisterProve'];
	//判断
	if(empty($tel)){
		$json['warn'] = "请输入手机号码";
	}elseif(preg_match($CheckTel,$tel) == 0){
		$json['warn'] = "手机号码格式有误";
	}elseif(empty($pas)){
		$json['warn'] = "请输入密码";
	}elseif(strlen($pas) < 6 || strlen($pas) > 20){
		$json['warn'] = "密码不得小于六位或大于20位";
	}elseif(empty($prove)){
		$json['warn'] = "请输入手机验证码";
	}elseif($prove != $_SESSION['Prove']['rand']){
		$json['warn'] = "手机验证码输入错误！";
	}elseif($_SESSION['Prove']['tel'] != $tel){
		$json['warn'] = "请使用接受验证短信的手机号码注册！";
	}elseif($_POST['agree'] != "yes"){
		$json['warn'] = "请同意网站服务协议";
	}else{
		//判断手机号码是否已经注册
		$RepeatTel = mysql_num_rows(mysql_query("select * from seller where setel = '$tel' "));
		if($RepeatTel > 0){
			$json['warn'] = "这个手机号码已经注册了";
		}else{
			//注册并获得sission
			$suiji = suiji();
			$bool = mysql_query("insert into seller (seid,setel,sepas,Auditing,UpdateTime,time) values ('$suiji','$tel','$pas','未认证','$time','$time')");
			if($bool){
				$_SESSION['seid'] = $suiji;
				$json['warn'] = 2;
			}else{
				$json['warn'] = "注册失败";
			}
		}
	}
/*--------------------------用户注册-----------------------------------------------------------------------------------------*/
}elseif(isset($_POST['usRegisterTel']) and isset($_POST['usRegisterPassword']) and isset($_POST['usRegisterNickName'])){
	//赋值
	$sex = $_POST['sex'];//性别
	$Birthday = $_POST['year']."-".$_POST['moon']."-".$_POST['day'];//生日
	$RegionId = $_POST['area'];//所在区县ID号
	$marry = $_POST['marry'];//婚姻状况
	$height = $_POST['height'];//身高
	$degree = $_POST['education'];//学历
	$salary = $_POST['month_money'];//月薪
	$khtel = $_POST['usRegisterTel'];//注册手机号码
	$prove = $_POST['verificationCode'];//短信验证码
	$khpas = $_POST['usRegisterPassword'];//创建密码
	$truepas = $_POST['trueusRegisterPassword'];//确认密码
	$NickName = $_POST['usRegisterNickName'];//昵称
	$summary = $_POST['summary'];//自我介绍
	$agreement = $_POST['agree'];//客户是否点击同意注册条款和免责声明
	//判断
	if(empty($sex)){
		$json['warn'] = "请选择性别";
	}elseif(empty($khtel)){
		$json['warn'] = "请输入手机号码";
    }elseif(preg_match($CheckTel,$khtel) == 0){
		$json['warn'] = "手机号码格式有误";
	}elseif(mysql_num_rows(mysql_query(" select * from kehu where khtel = '$khtel' ")) > 0){
		$json['warn'] = "本手机号码已经注册";
	}elseif(empty($prove)){
		$json['warn'] = "请输入验证码";
	}elseif($_SESSION['Prove']['tel'] != $khtel){
		$json['warn'] = "请使用接受验证短信的手机号码注册！";
	}elseif($prove != $_SESSION['Prove']['rand']){
		$json['warn'] = "手机验证码输入错误！";
	}elseif(empty($khpas)){
		$json['warn'] = "请输入密码";
    }elseif(strlen($khpas) < 6 || strlen($khpas) > 16){
		$json['warn'] = "密码不得小于六位或大于16位";
	}elseif($khpas != $truepas){
		$json['warn'] = "两次密码输入不一致";
	}elseif(empty($NickName)){
		$json['warn'] = "请输入昵称";
	}elseif($agreement != "yes"){
	    $json['warn'] = "请阅读并同意注册条款和免责声明";
	}else{
		$khid = suiji();
		$bool = mysql_query(" insert into kehu 
		(khid,NickName,sex,khtel,khpas,Grade,summary,RegionId,marry,height,degree,salary,Birthday,UpdateTime,time) 
		values 
		('$khid','$NickName','$sex','$khtel','$khpas','铜牌会员','$summary','$RegionId','$marry','$height','$degree','$salary','$Birthday','$time','$time') ");
		if($bool){
			$_SESSION['khid'] = $khid;
			$json['warn'] = 2;
			$json['href'] = root."user/user.php";
		}else{
			$json['warn'] = "注册失败";
		}
	}
/*--------------------------代理商登录---------------------------------------------------------------------------------------------------------*/
}elseif(isset($_POST['agLogPhone']) and isset($_POST['agLogPassword']) and isset($_POST['agPhoneyzm'])){
	//赋值
	$tel = $_POST['agLogPhone'];
	$pas = $_POST['agLogPassword'];
	$prove = $_POST['agPhoneyzm'];
	//判断
	if(empty($tel)){
	    $json['warn'] = "请输入手机号码";
	}elseif(preg_match($CheckTel,$tel) == 0){
	    $json['warn'] = "手机号码格式有误";
	}elseif(empty($pas)){
	    $json['warn'] = "请输入登录密码";
	}elseif(empty($prove)){
	    $json['warn'] = "请输入验证码中公式的计算结果";
    }elseif($prove != $_SESSION['yan']){
        $json['warn'] = "验证码填写错误";
	}else{
	    $ExistTel = mysql_num_rows(mysql_query(" select * from agent where agtel = '$tel' "));//查询该手机号码在sql中是否有记录
		$agent = query("agent"," agtel = '$tel' and agpas = '$pas' ");
		if($ExistTel == 0){
		    $json['warn'] = "本手机号码未注册";
		}elseif($agent['agtel'] != $tel){
		    $json['warn'] = "登录密码错误";
		}else{
			$_SESSION['agid'] = $agent['agid'];
			$json['warn'] = 2;
		}
	}
/*--------------------------商户登录---------------------------------------------------------------------------------------------------------*/
}elseif(isset($_POST['SeLoginTel']) and isset($_POST['SeLoginPas']) and isset($_POST['usPhoneyzm'])){
	//赋值
	$tel = $_POST['SeLoginTel'];
	$pas = $_POST['SeLoginPas'];
	$prove = $_POST['usPhoneyzm'];
	//判断
	if(empty($tel)){
	    $json['warn'] = "请输入手机号码";
	}elseif(preg_match($CheckTel,$tel) == 0){
	    $json['warn'] = "手机号码格式有误";
	}elseif(empty($pas)){
	    $json['warn'] = "请输入登录密码";
	}elseif(empty($prove)){
	    $json['warn'] = "请输入验证码中公式的计算结果";
    }elseif($prove != $_SESSION['yan']){    
        $json['warn'] = "验证码填写错误"; 
	}else{
	    $ExistTel = mysql_num_rows(mysql_query(" select * from seller where setel = '$tel' "));//查询该手机号码在sql中是否有记录
		$seller = query("seller"," setel = '$tel' and sepas = '$pas' ");
		if($ExistTel == 0){
		    $json['warn'] = "本手机号码未注册";
		}elseif($seller['setel'] != $tel){
		    $json['warn'] = "登录密码错误";
		}else{
			$_SESSION['seid'] = $seller['seid'];
			$json['warn'] = 2;
		}
	}
/*--------------------------用户登录---------------------------------------------------------------------------------------------------------*/
}elseif(isset($_POST['usLoginTel']) and isset($_POST['usLoginPassword'])){
	//赋值
	$khtel = $_POST['usLoginTel'];//登录账号（手机号码）
	$khpas = $_POST['usLoginPassword'];//登录密码
	//判断
	if(empty($khtel)){
	    $json['warn'] = "请输入账号（手机号码）";
	}elseif(preg_match($CheckTel,$khtel) == 0){
	    $json['warn'] = "手机号码格式有误";
	}elseif(empty($khpas)){
	    $json['warn'] = "请输入登录密码";
	}else{
	    $ExistTel = mysql_num_rows(mysql_query(" select * from kehu where khtel = '$khtel' "));
		$kehu = query("kehu"," khtel = '$khtel' and khpas = '$khpas' ");
		if($ExistTel == 0){
		    $json['warn'] = "本手机号码未注册";
		}elseif($kehu['khtel'] != $khtel){
			$json['warn'] = "登录账号(手机号码)或密码错误";
		}else{
			$_SESSION['khid'] = $kehu['khid'];
			$json['href'] = root."user/user.php";
			$json['warn'] = 2;
		}
	}
/*-----------------用户加入购物车---------------------------------------------------------*/
}elseif(isset($_POST['BuyCarNum']) and isset($_POST['BuyCarRuleId'])){
	//赋值
	$RuleId = $_POST['BuyCarRuleId'];
	$num = $_POST['BuyCarNum'];
	$rule = query("specifications"," id = '$RuleId' ");
	$suiji = rand(100000,999999).(time()-1426408044);
	//判断
	if(empty($RuleId)){
	    $json['warn'] = "请选择商品规格";
	}elseif(empty($num)){
	    $json['warn'] = "请输入购买数量";
	}elseif($rule['id'] != $RuleId){
	    $json['warn'] = "未找到本商品规格";
	}elseif($KehuFinger == 2){
	    $json['warn'] = "您未登录";
		$_SESSION['skip'] = array("url" => "{$root}GoodsMx.php?id={$rule['GoodsId']}","type" => "未登录");
	}else{
	    $buycar = query("buycar"," khid = '$kehu[khid]' and goodsid = '$rule[GoodsId]' and GoodsSpec = '$RuleId' and WorkFlow in ('未选定','已选定') ");
		if($buycar['khid'] == $kehu['khid']){
		    $num = $buycar['BuyNumber'] + $num;
			$bool = mysql_query(" update buycar set BuyNumber = '$num' where id = '$buycar[id]' ");
		}else{
			$bool = mysql_query("insert into buycar (id,khid,goodsid,GoodsSpec,BuyNumber,WorkFlow,UpdateTime,time)
					values('$suiji','$kehu[khid]','$rule[GoodsId]','$RuleId','$num','已选定','$time','$time')");
		}
		if($bool){
		    $json['warn'] = 2;
		    $json['sum'] = BuyCarNum();
		}else{
		    $json['warn'] = "加入购物车失败";
		}
	}
/*-----------------用户收藏商品---------------------------------------------------------------------------------------------*/
}elseif(isset($_POST['CollectGoods'])){
    //赋值
	$id = $_POST['CollectGoods'];
	$goods = query("goods"," id = '$id' ");
	$Repeat = mysql_num_rows(mysql_query(" select * from collect where khid = '$kehu[khid]' and Target = '商品' and TargetId = '$id' "));
	//判断
	if($KehuFinger == 2){
		$json['warn'] = "您未登录";
		$_SESSION['skip'] = array("url" => "{$root}GoodsMx.php?id={$id}","type" => "未登录");
	}elseif(empty($id)){
	    $json['warn'] = "商品id号为空";
	}elseif($goods['id'] != $id){
	    $json['warn'] = "未找到本商品";
	}elseif($Repeat > 0){
	    $json['warn'] = "您已经收藏过本商品了";
	}else{
	    $suiji = suiji();
	    $bool = mysql_query(" insert into collect (id,khid,Target,TargetId,time) values ('$suiji','$kehu[khid]','商品','$id','$time') ");
		if($bool){
		    $json['warn'] = "商品收藏成功";
		}else{
		    $json['warn'] = "商品收藏失败";
		}
	}
}
/*-----------------返回信息---------------------------------------------------------*/
echo json_encode($json);
?>