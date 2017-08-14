<?php 
include "adfunction.php";
if($adDuty['name'] != "超级管理员"){
	$_SESSION['warn'] = "权限不足";
	header("Location:{$root}control/adClient.php");
	exit(0);
}
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=客户信息.xls");    //改成你需要的filename
//注意下面的head必须，charset必须跟你将要输出的内容的编码一致，否则用Excel打开时，可能得到的是乱码。
echo "
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<title>客户信息</title>
</head>
<table>
	<tr>
		<th>姓名</th>
		<th>手机号</th>
		<th>邮箱</th>
	</tr>
";
$sql=mysql_query("select * from kehu".$_SESSION['adClient']['Sql']);
if($ControlFinger == 2){
	header("Location:{$root}control/adClient.php");
	exit(0);
}else{
	while($kehu = mysql_fetch_array($sql)){
		echo "
		<tr>
			<td>".kong($kehu['ContactName'])."</td>
			<td>".kong($kehu['ContactTel'])."</td>
			<td>".kong($kehu['email'])."</td>
		</tr>
		";
	} 
}
echo "</table>";
?>