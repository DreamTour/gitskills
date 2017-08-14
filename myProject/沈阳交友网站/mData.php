<?php
include "../../library/OpenFunction.php";
/*--------------------------用户注册---------------------------------------------*/
if(isset($_POST['phone']) and isset($_POST['password'])){
	//赋值
	$khtel = $_POST['phone'];//手机号
	$prove = $_POST['verificationCode'];//验证码
	$ShareCode = $_POST['shareCode'];//分享码
	$khpas = $_POST['password'];//创建密码
	$truepas = $_POST['truePassword'];//确认密码
	//判断
	if(empty($khtel)){
		$json['warn'] = "请输入手机号码";	
	}else if(preg_match($CheckTel,$khtel) == 0){
		$json['warn'] = "手机号码格式有误".$CheckTel."****".$khtel;	
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
	}else{
		$khid = suiji();
		if(empty($ShareCode)){
			$shareId = "";	
		}else{
			$share = query("kehu","ShareCode = '$ShareCode' ");
			if($share['ShareCode'] != $ShareCode){
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
			//创建分享码
			$ShareCode = rand(10000000,99999999);
			while(mysql_num_rows(mysql_query(" select * from kehu where ShareCode = '$ShareCode' ")) > 0){  
				$ShareCode = rand(10000000,99999999);
			}
			$bool = mysql_query("insert into kehu 
			(khid,ShareCode,khtel,khpas,ShareId,UpdateTime,time) values
			('$khid','$ShareCode','$khtel','$khpas','$shareId','$time','$time') ");
			if($bool){
				$_SESSION['khid'] = $khid;
				$json['warn'] = "2";
				$json['href'] = "{$root}m/user/mUsDatum.php";	
			}else{
				$json['warn'] = "注册失败";	
			}		
		}
	}
}
/*-----------------返回信息---------------------------------------------------------*/
echo json_encode($json);
?>