<?php            
include "OpenFunction.php";
/*--------------------------代理商注册---------------------------------------------------------------------------------------------------------*/
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
}elseif(isset($_POST['usPhone']) and isset($_POST['usPassword']) and isset($_POST['usLogShare']) and isset($_POST['usPhoneyzm'])){
	//赋值
	$tel = $_POST['usPhone'];//注册手机号码
	$pas = $_POST['usPassword'];//注册密码
	$ShareCode = $_POST['usLogShare'];//推荐人分享码或手机号码
	$prove = $_POST['usPhoneyzm'];//短信验证码
	$agreement = $_POST['agreement'];//客户是否点击同意《琦然易购用户注册协议》
	//判断
	if(empty($tel)){
		$json['warn'] = "请输入手机号码";
   }elseif(preg_match($CheckTel,$tel) == 0){
		$json['warn'] = "手机号码格式有误";
	}elseif(empty($pas)){
		$json['warn'] = "请输入密码";
    }elseif(strlen($pas) < 6 || strlen($pas) > 16){
		$json['warn'] = "密码不得小于六位或大于16位";
	}elseif(empty($prove)){
		$json['warn'] = "请输入验证码";
	}elseif($prove != $_SESSION['Prove']['rand']){
		$json['warn'] = "手机验证码输入错误！";
	}elseif($_SESSION['Prove']['tel'] != $tel){
		$json['warn'] = "请使用接受验证短信的手机号码注册！";
	}elseif($agreement != "yes"){
	    $json['warn'] = "请阅读并同意《琦然易购用户注册协议》";
	}else{
	    $RepeatTel = mysql_num_rows(mysql_query(" select * from kehu where khtel = '$tel' "));
		if($RepeatTel > 0){
		    $json['warn'] = "本手机号码已经注册";
		}else{
			//查询推荐人
			if(empty($ShareCode)){
			    $RefereeId = "";
			}else{
				$RefereeSql = mysql_query(" select * from kehu where ShareCode = '$ShareCode' or khtel = '$ShareCode' ");
				if(mysql_num_rows($RefereeSql) == 0){
					$json['warn'] = "分享码或分享人手机号码输入有误";
				}else{
					$Referee = mysql_fetch_array($RefereeSql);
					$RefereeId = $Referee['khid'];
				}
			}
			if(empty($json['warn'])){
				$suiji = suiji();
				$ShareCode = rand(10000000,99999999);
				while(mysql_num_rows(mysql_query(" select * from kehu where ShareCode = '$ShareCode' ")) > 0){  
					$ShareCode = rand(10000000,99999999);
				}
				$bool = mysql_query(" insert into kehu (khid,khtel,khpas,referee,ShareCode,UpdateTime,time) values ('$suiji','$tel','$pas','$RefereeId','$ShareCode','$time','$time') ");
				if($bool){
					$_SESSION['khid'] = $suiji;
					$json['warn'] = 2;
				}else{
					$json['warn'] = "注册失败";
				}
			}
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
}elseif(isset($_POST['usLogPhone']) and isset($_POST['usLogPassword']) and isset($_POST['usPhoneyzm'])){
	//赋值
	$tel = $_POST['usLogPhone'];
	$pas = $_POST['usLogPassword'];
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
	    $ExistTel = mysql_num_rows(mysql_query(" select * from kehu where khtel = '$tel' "));
		$kehu = query("kehu"," khtel = '$tel' and khpas = '$pas' ");
		if($ExistTel == 0){
		    $json['warn'] = "本手机号码未注册";
		}elseif($kehu['khtel'] != $tel){
			$json['warn'] = "登录密码错误";
		}else{
			$_SESSION['khid'] = $kehu['khid'];
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