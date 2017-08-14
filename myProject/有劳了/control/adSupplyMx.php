<?php
include "ku/adfunction.php";
ControlRoot("供给管理");
$supply = query("supply"," id = '$_GET[id]' ");
if(empty($supply['id']) and $supply['id'] != $_GET['id']){
	$_SESSION['warn'] = "未找到这条供给的信息";
	header("location:{$adroot}adSupply.php");
	exit(0);
}
$classify = query("classify", "id = '$supply[ClassifyId]' ");
//判断收费类型，根据收费类型显示内容
if ($supply['payType'] == "薪酬") {
	$pay = "{$supply['pay']}/{$supply['PayCycle']}";
}
else {
	$pay = $supply['payType'];
}
echo head("ad").adheader();
?>
<div class="column MinHeight">
	<!--标题开始-->
	<a href="<?php echo "{$adroot}adSupply.php";?>"><img src="<?php echo "{$root}img/adimg/AdTitleClient.png";?>"></a>
	<p>
		<a href="<?php echo $adroot."adSupply.php";?>">供给管理</a>&nbsp;>&nbsp;
		<a href="<?php echo $adroot."adSupplyMx.php?id=".$_GET['id'];?>"><?php echo kong($supply['ClassifyId']);?></a>
	</p>
	<!--标题结束-->
	<!--基本资料开始-->
	<div class="kuang">
		<p>
			<img src="<?php echo root."img/images/text.png";?>">
			供给基本资料
			<a target="_blank" class="SpanButton FloatRight" href="<?php echo "{$root}JobMx.php?supplyMx_id={$supply['id']} ";?>">预览</a>
			<a class="SpanButton FloatRight" onClick="window.location.href='<?php echo "{$root}control/ku/adpost.php?supply_delete_id={$supply['id']}";?>'">删除</a>
			</p>
			<form name="supplyForm">
				<table class="TableRight">
			<tr>
			    <td style="width:200px;">供给ID号：</td>
				<td> <?php echo kong($supply['id']);?></td>
			</tr>
            <tr>
			    <td>客户ID号：</td>
				<td>
				<?php echo $supply['khid'];?>
                <a href="<?php echo "{$root}control/adClientMx.php?id={$supply['khid']}";?>"><span class="SpanButton">详情</span></a>
                </td>
			</tr>
			<tr>
			    <td>分类：</td>
				<td><?php echo $classify['type']."-".$classify['name'];?></td>
			</tr>
			<tr>
			    <td>方式：</td>
				<td><?php echo kong($supply['mode']);?></td>
			</tr>
			<tr>
			    <td>面向：</td>
				<td><?php echo kong($supply['face']);?></td>
			</tr>
            <tr>
			    <td>收费：</td>
				<td><?php echo $pay;?></td>
			</tr>
			<tr>
			    <td>类型：</td>
				<td><?php echo kong($supply['type']);?></td>
			</tr>
            <tr>
			    <td>工作时间：</td>
				<td><?php echo kong($supply['WorkingHours']);?></td>
			</tr>
            <tr>
			    <td>标题：</td>
				<td><?php echo kong($supply['title']);?></td>
			</tr>
            <tr>
			    <td>关键词：</td>
				<td><?php echo kong($supply['KeyWord']);?></td>
			</tr>
            <tr>
			    <td>资历展示：</td>
				<td><?php echo kong($supply['text']);?></td>
			</tr>
		    <tr>
			    <td>更新时间：</td>
				<td><?php echo kong($supply['UpdateTime']);?></td>
			</tr>
		    <tr>
			    <td>注册时间：</td>
				<td><?php echo kong($supply['time']);?></td>
			</tr>
		</table>
		</form>
	</div>
	<!--基本资料结束-->
</div>
<?php echo warn().adfooter();?>