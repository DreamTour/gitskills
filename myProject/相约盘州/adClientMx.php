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
			    <td>昵称：</td>
				<td><?php echo kong($kehu['NickName']);?></td>
			</tr>
			<tr>
			    <td>性别：</td>
				<td><?php echo kong($kehu['sex']);?></td>
			</tr>
			<tr>
			    <td>手机号码：</td>
				<td><?php echo kong($kehu['khtel']);?></td>
			</tr>
			<tr>
			    <td>QQ：</td>
				<td><?php echo kong($kehu['khqq']);?></td>
			</tr>
			<tr>
			    <td>会员等级：</td>
				<td><?php echo kong($kehu['Grade']);?></td>
			</tr>
			<tr>
			    <td>自我介绍：</td>
				<td><?php echo kong($kehu['summary']);?></td>
			</tr>
			<tr>
			    <td>地址：</td>
				<td><?php echo kong($Region['province'].$Region['city'].$Region['area']);?></td>
			</tr>
			<tr>
			    <td>子女情况：</td>
				<td><?php echo kong($kehu['children']);?></td>
			</tr>
			<tr>
			    <td>属相：</td>
				<td><?php echo kong($kehu['Zodiac']);?></td>
			</tr>
			<tr>
			    <td>婚姻状况：</td>
				<td><?php echo kong($kehu['marry']);?></td>
			</tr>
			<tr>
			    <td>身高：</td>
				<td><?php echo kong($kehu['height']);?></td>
			</tr>
			<tr>
			    <td>学历：</td>
				<td><?php echo kong($kehu['degree']);?></td>
			</tr>
			<tr>
			    <td>星座：</td>
				<td><?php echo kong($kehu['constellation']);?></td>
			</tr>
			<tr>
			    <td>月薪：</td>
				<td><?php echo kong($kehu['salary']);?></td>
			</tr>
			<tr>
			    <td>生日：</td>
				<td><?php echo kong($kehu['Birthday']);?></td>
			</tr>
			<tr>
			    <td>购房情况：</td>
				<td><?php echo kong($kehu['BuyHouse']);?></td>
			</tr>
			<tr>
			    <td>购车情况：</td>
				<td><?php echo kong($kehu['BuyCar']);?></td>
			</tr>
			<tr>
			    <td>职业：</td>
				<td><?php echo kong($kehu['Occupation']);?></td>
			</tr>
			<tr>
			    <td>微信号：</td>
				<td><?php echo kong($kehu['wxNum']);?></td>
			</tr>
			<tr>
			    <td>身份证正面：</td>
				<td><?php echo ProveImgShow($kehu['IDCardFront']);?></td>
			</tr>
			<tr>
			    <td>身份证反面：</td>
				<td><?php echo ProveImgShow($kehu['IDCardBack']);?></td>
			</tr>
			<tr>
			    <td>手持身份证：</td>
				<td><?php echo ProveImgShow($kehu['IDCardHand']);?></td>
			</tr>
		    <tr>
			    <td>更新时间：</td>
				<td><?php echo kong($kehu['UpdateTime']);?></td>
			</tr>
		    <tr>
			    <td>注册时间：</td>
				<td><?php echo kong($kehu['time']);?></td>
			</tr>
			<tr>
			    <td><input name="adClientId" type="hidden" value="<?php echo $kehu['khid'];?>"></td>
				<td><input onclick="Sub('ClientForm','<?php echo root."control/ku/addata.php";?>')" type="hidden" class="button" value="提交"></td>
			</tr>
		</table>
		</form>
	</div>
	<!--基本资料结束-->
</div>
<script>
$(document).ready(function(){
    <?php
	echo 
	KongSele("ClientForm.ClientReferee",$kehu['Referee']);
	?>
});
</script>
<?php echo warn().adfooter();?>