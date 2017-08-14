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
			    <td>微信名：</td>
				<td><?php echo kong($kehu['NickName']);?></td>
			</tr>
			<tr>
			    <td>性别：</td>
				<td><?php echo kong($kehu['sex']);?></td>
			</tr>
				<tr>
			    <td>生日：</td>
				<td><?php echo kong($kehu['Birthday']);?></td>
			</tr>
			<tr>
			    <td>生肖：</td>
				<td><?php echo kong($kehu['Zodiac']);?></td>
			</tr>
			<tr>
			    <td>星座：</td>
				<td><?php echo kong($kehu['constellation']);?></td>
			</tr>
			<tr>
			    <td>民族：</td>
				<td><?php echo kong($kehu['Nation']);?></td>
			</tr>
			<tr>
			    <td>身高：</td>
				<td><?php echo kong($kehu['height']);?></td>
			</tr>
			<tr>
			    <td>体重：</td>
				<td><?php echo kong($kehu['weight']);?></td>
			</tr>
			<tr>
			    <td>学历：</td>
				<td><?php echo kong($kehu['degree']);?></td>
			</tr>
			<tr>
			    <td>婚育状况：</td>
				<td><?php echo kong($kehu['marry']);?></td>
			</tr>
			<tr>
			    <td>家乡：</td>
				<td><?php echo kong($kehu['Hometown']);?></td>
			</tr>
			<tr>
			    <td>所在地区：</td>
				<td><?php echo kong($Region['city'].$Region['area']);?></td>
			</tr>
			<tr>
			    <td>工作：</td>
				<td><?php echo kong($kehu['Occupation']);?></td>
			</tr>
			<tr>
			    <td>月收入：</td>
				<td><?php echo kong($kehu['salary']);?></td>
			</tr>
			<tr>
			    <td>是否吸烟：</td>
				<td><?php echo kong($kehu['smoke']);?></td>
			</tr>
			<tr>
			    <td>是否饮酒：</td>
				<td><?php echo kong($kehu['drink']);?></td>
			</tr>
			<tr>
			    <td>是否有房：</td>
				<td><?php echo kong($kehu['BuyHouse']);?></td>
			</tr>
			<tr>
			    <td>是否有车：</td>
				<td><?php echo kong($kehu['BuyCar']);?></td>
			</tr>
			<tr>
			    <td>有无贷款：</td>
				<td><?php echo kong($kehu['loan']);?></td>
			</tr>
			<tr>
			    <td>兴趣爱好：</td>
				<td><?php echo kong($kehu['Hobby']);?></td>
			</tr>
			<tr>
			    <td>优点：</td>
				<td><?php echo kong($kehu['Advantage']);?></td>
			</tr>
			<tr>
			    <td>缺点：</td>
				<td><?php echo kong($kehu['defect']);?></td>
			</tr>
			<tr>
			    <td>家中排行：</td>
				<td><?php echo kong($kehu['HomeRanking']);?></td>
			</tr>
			<tr>
			    <td>家庭成员：</td>
				<td><?php echo kong($kehu['family']);?></td>
			</tr>
			<tr>
			    <td>微信号：</td>
				<td><?php echo kong($kehu['wxNum']);?></td>
			</tr>
			<tr>
			    <td>身份证号：</td>
				<td><?php echo kong($kehu['IDCard']);?></td>
			</tr>
			<tr>
			    <td>内心独白：</td>
				<td><?php echo kong($kehu['summary']);?></td>
			</tr>
            <tr>
                <td>身份认证：</td>
                <td><?php echo select("authentication","select","--选择--",array("是","否"),$kehu['authentication']);?></td>
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
				<td><input onclick="Sub('ClientForm','<?php echo root."control/ku/addata.php";?>')" type="button" class="button" value="提交"></td>
			</tr>
		</table>
		</form>
	</div>
	<!--基本资料结束-->
</div>
<?php echo warn().adfooter();?>