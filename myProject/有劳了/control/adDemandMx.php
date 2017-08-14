<?php
include "ku/adfunction.php";
ControlRoot("需求管理");
$demand = query("demand"," id = '$_GET[id]' ");
if(empty($demand['id']) and $demand['id'] != $_GET['id']){
	$_SESSION['warn'] = "未找到这条需求的信息";
	header("location:{$adroot}adDemand.php");
	exit(0);
}
$classify = query("classify", "id = '$demand[ClassifyId]' ");
//判断收费类型，根据收费类型显示内容
if ($demand['payType'] == "薪酬") {
	$pay = "{$demand['pay']}/{$demand['PayCycle']}";
}
else {
	$pay = $demand['payType'];
}
echo head("ad").adheader();
?>
<div class="column MinHeight">
	<!--标题开始-->
	<a href="<?php echo "{$adroot}adDemand.php";?>"><img src="<?php echo "{$root}img/adimg/AdTitleClient.png";?>"></a>
	<p>
		<a href="<?php echo $adroot."adDemand.php";?>">需求管理</a>&nbsp;>&nbsp;
		<a href="<?php echo $adroot."adDemandMx.php?id=".$_GET['id'];?>"><?php echo kong($demand['ClassifyId']);?></a>
	</p>
	<!--标题结束-->
	<!--基本资料开始-->
	<div class="kuang">
		<p>
			<img src="<?php echo root."img/images/text.png";?>">
			需求基本资料
			<a target="_blank" class="SpanButton FloatRight" href="<?php echo "{$root}recruit.php?demandMx_id={$demand['id']} ";?>">预览</a>
			<a class="SpanButton FloatRight" onClick="window.location.href='<?php echo "{$root}control/ku/adpost.php?demand_delete_id={$demand['id']}";?>'">删除</a>
		</p>
		<form name="demandForm">
		<table class="TableRight">
			<tr>
			    <td style="width:200px;">需求ID号：</td>
				<td><?php echo $demand['id'];?></td>
			</tr>
            <tr>
			    <td>客户ID号：</td>
				<td>
				<?php echo $demand['khid'];?>
                <a href="<?php echo "{$root}control/adClientMx.php?id={$demand['khid']}";?>"><span class="SpanButton">详情</span></a>
                </td>
			</tr>
			<tr>
			    <td>分类：</td>
				<td><?php echo $classify['type']."-".$classify['name'];?></td>
			</tr>
			<tr>
			    <td>方式：</td>
				<td><?php echo kong($demand['mode']);?></td>
			</tr>
			<tr>
			    <td>面向：</td>
				<td><?php echo kong($demand['face']);?></td>
			</tr>
            <tr>
			    <td>收费：</td>
				<td><?php echo $pay;?></td>
			</tr>
			<tr>
			    <td>类型：</td>
				<td><?php echo kong($demand['type']);?></td>
			</tr>
			<tr>
			    <td>标题：</td>
				<td><?php echo kong($demand['title']);?></td>
			</tr>
            <tr>
			    <td>关键词：</td>
				<td><?php echo kong($demand['KeyWord']);?></td>
			</tr>
            <tr>
			    <td>资历展示：</td>
				<td><?php echo kong($demand['text']);?></td>
			</tr>
            <tr>
			    <td>工作时间：</td>
				<td><?php echo kong($demand['WorkingHours']);?></td>
			</tr>
            <tr>
			    <td>需求开始时间：</td>
				<td><?php echo kong($demand['StartTime']);?></td>
			</tr>
            <tr>
			    <td>需求结束时间：</td>
				<td><?php echo kong($demand['EndTime']);?></td>
			</tr>
		    <tr>
			    <td>更新时间：</td>
				<td><?php echo kong($demand['UpdateTime']);?></td>
			</tr>
		    <tr>
			    <td>注册时间：</td>
				<td><?php echo kong($demand['time']);?></td>
			</tr>
		</table>
		</form>
	</div>
	<!--基本资料结束-->
</div>
<?php echo warn().adfooter();?>