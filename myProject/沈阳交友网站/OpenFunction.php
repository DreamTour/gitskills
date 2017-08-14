<?php
/*
本函数库存放电脑端和手机端的公共函数
*/
include dirname(dirname(__FILE__))."/control/ku/configure.php";
function share($page){
	$kehu = $GLOBALS['kehu'];
	$one = '';
	$two = '';
	$sql = mysql_query("select * from kehu where ShareId = '$kehu[khid]' order by time desc limit ".(($page-1)*5).",5");
	if(mysql_num_rows($sql) == 0){
		$one = "<dd>没有分享人</dd>";
		$two = "<dd>没有分享人</dd>";
	}else{
		while($array = mysql_fetch_assoc($sql)){
			$one .= "<dd>{$array['NickName']}</dd>";
			$two .= "<dd>".mb_substr($array['time'],0,10,'utf-8')."</dd>";	
		}	
	}
	$html1 = "<dl class='share_table fl'><dt class='fw1'>被分享人微信名</dt>{$one}</dl>";
	$html2 = "<dl class='share_table fl'><dt class='fw1'>注册时间</dt>{$two}</dl>";
	$json['html1'] = $html1;
	$json['html2'] = $html2;
	return $json;
}
function limit($kehu){
	if(empty($kehu['Occupation'])){//检查客户是否有权限打开此页面
		$_SESSION['warn'] = "请您完善个人详细资料后点击查阅";	
		$finger = 1;	
	}else if(empty($kehu['LoveOccupation'])){
		$_SESSION['warn'] = "请您完善择偶意向后点击查阅";
		$finger = 1;	
	}else if(empty($kehu['ico'])){
		$_SESSION['warn'] = "请您上传头像后点击查阅";
		$finger = 1;
	}else if(empty($kehu['summary'])){
		$_SESSION['warn'] = "请您完善内心独白后点击查阅";
		$finger = 1;	
	}else{
		$finger = 2;	
	}
	if($finger == 1){
		if(isMobile()){
			header("Location:".root."m/user/mUsDatum.php");
			exit(0);
		}else{
			header("Location:".root."user/user.php");
			exit(0);
		}
	}
}
function KeyWords(){
	return array('壹','贰','叁','肆','伍','陆','柒','捌','玖','拾','一','二','三','四','五','六','七','八','九','十');
}
?>