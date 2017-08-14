<?php
include "ku/adfunction.php";
ControlRoot("客户管理");
$kehu = query("kehu"," khid = '$_GET[id]' ");
if(empty($kehu['khid']) and $kehu['khid'] != $_GET['id']){
	$_SESSION['warn'] = "未找到这个客户的信息";
	header("location:{$adroot}adClient.php");
	exit(0);
}
$Region = query("region", "id = '$kehu[RegionId]' ");
$info = "";
if($kehu['type'] == "公司"){
	$company = query("company"," khid = '$kehu[khid]' ");
	$info .= "
	<tr>
	    <td>单位全称：</td>
		<td>".kong($company['CompanyName'])."</td>
	</tr>
	<tr>
	    <td>负责人全名：</td>
		<td>".kong($company['LegalName'])."</td>
	</tr>
	<tr>
	    <td>营业执照信用代码：</td>
		<td>".kong($company['BusinessLicense'])."</td>
	</tr>
	<tr>
	    <td>营业执照扫描件：</td>
		<td>".kong($company['BusinessLicenseImg'])."</td>
	</tr>
	";
}elseif($kehu['type'] == "个人"){
	$personal = query("personal"," khid = '$kehu[khid]' ");
	$info .= "
	<tr>
	    <td>性别：</td>
		<td>".kong($personal['sex'])."</td>
	</tr>
	<tr>
	    <td>出生日期：</td>
		<td>".kong($personal['Birthday'])."</td>
	</tr>
	<tr>
	    <td>受教育程度：</td>
		<td>".kong($personal['EducationLevel'])."</td>
	</tr>
	";
}
echo head("ad").adheader();
?>
<div class="column MinHeight">
	<!--标题开始-->
	<a href="<?php echo "{$adroot}adClient.php";?>"><img src="<?php echo "{$root}img/adimg/AdTitleClient.png";?>"></a>
	<p>
		<a href="<?php echo $adroot."adClient.php";?>">客户管理</a>&nbsp;>&nbsp;
		<a href="<?php echo $adroot."adClientMx.php?id=".$_GET['id'];?>"><?php echo kong($kehu['NickName']);?></a>
	</p>
	<!--标题结束-->
	<!--基本资料开始-->
	<div class="kuang">
		<p>
			<img src="<?php echo root."img/images/text.png";?>">
			客户基本资料
			<a class="SpanButton FloatRight" onClick="window.location.href='<?php echo "{$root}control/ku/adpost.php?client_delete_id={$kehu['khid']}";?>'">删除</a>
		</p>
		<form name="ClientForm">
		<table class="TableRight">
			<tr>
			    <td style="width:200px;">客户ID号：</td>
				<td><?php echo kong($kehu['khid']);?></td>
			</tr>
			<tr>
			    <td>头像：</td>
				<td><?php echo ProveImgShow($kehu['ico']);?></td>
			</tr>
            <tr>
			    <td>类型：</td>
				<td><?php echo kong($kehu['type']);?></td>
			</tr>
			<tr>
			    <td>联系人姓名：</td>
				<td><?php echo kong($kehu['ContactName']);?></td>
			</tr>
			<tr>
			    <td>联系人手机号码：</td>
				<td><?php echo kong($kehu['ContactTel']);?></td>
			</tr>
			<tr>
			    <td>身份证号：</td>
				<td><?php echo kong($kehu['IDCard']);?></td>
			</tr>
            <tr>
			    <td>联系邮箱：</td>
				<td><?php echo kong($kehu['email']);?></td>
			</tr>
			<tr>
			    <td>所属区域：</td>
				<td><?php echo kong($Region['province']."-".$Region['city']."-".$Region['area']);?></td>
			</tr>
			<tr>
			    <td>详细地址：</td>
				<td><?php echo kong($kehu['AddressMx']);?></td>
			</tr>
            <tr>
			    <td>手持身份证照片：</td>
				<td><?php echo ProveImgShow($kehu['IDCardHand']);?></td>
			</tr>
		    <?php echo $info;?>
            <tr>
			    <td>更新时间：</td>
				<td><?php echo kong($kehu['UpdateTime']);?></td>
			</tr>
		    <tr>
			    <td>注册时间：</td>
				<td><?php echo kong($kehu['time']);?></td>
			</tr>
			<!--<tr>
			    <td><input name="adClientId" type="hidden" value="<?php echo $kehu['khid'];?>"></td>
				<td><input onclick="Sub('ClientForm','<?php echo root."control/ku/addata.php";?>')" type="button" class="button" value="提交"></td>
			</tr>-->
		</table>
		</form>
	</div>
	<!--基本资料结束-->
</div>
<?php echo warn().adfooter();?>