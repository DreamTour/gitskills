<?php
include "ku/adfunction.php";
ControlRoot("活动报名");
$ThisUrl = $adroot."adEnroll.php";
$sql = "select * from Enroll ".$_SESSION['adEnroll']['Sql'];
//生成年龄下拉菜单
for($n = 18;$n <= 60;$n++){
		$option[$n] = $n."岁";
	}
$Age1 = select('searchMinAge','select TextPrice',"年龄",$option);
$Age2 = select('searchMaxAge','select TextPrice',"年龄",$option);
paging($sql," order by time desc",100);
echo head("ad").adheader();
?>
<div class="column minheight">
    <a href="<?php echo $ThisUrl;?>"><img src="<?php echo "{$root}img/adimg/adMessage.png";?>"></a>
    <!--查询开始-->
	<div class="kuang">
		<form name="Search" action="<?php echo "{$adroot}ku/adpost.php";?>" method="post">
        	<?php echo select("SearchEnrollType","select","--类型--",array("本地通","最新活动"),$_SESSION['adEnroll']['type']);?>
            活动ID号：<input name="SearchEnrollContentId" type="text" class="text TextPrice" value="<?php echo $_SESSION['adEnroll']['ContentId'];?>">
            客户ID号：<input name="SearchEnrollKhid" type="text" class="text TextPrice" value="<?php echo $_SESSION['adEnroll']['khid'];?>">
			<input type="submit" value="模糊查询">
		</form>
	</div>
	<div class="kuang">
		<span class="SpanButton">
			共找到<b class="must"><?php echo $num;?></b>条信息
			当前显示第<b class="must"><?php echo $page;?></b>页的信息
	</div>
	<!--查询结束-->
	<!--列表开始-->
	<form name="EnrollForm">
	<table class="TableMany">
		<tr>
			<td></td>
			<td>活动类型</td>
			<td>活动标题</td>
			<td>活动ID号</td>
			<td>客户昵称</td>
			<td>客户ID号</td>
			<td>客户性别</td>
			<td>客户年龄</td>
			<td>客户电话</td>
			<td>客户地址</td>
			<td>创建时间</td>
			<td></td>
		</tr>
		<?php
		if($num > 0){
			while($Enroll = mysql_fetch_array($query)){
				$kehu = query("kehu","khid = '$Enroll[khid]'");
				$content = query("content","id = '$Enroll[ContentId]'");
				$age = date("Y") - substr($kehu['Birthday'],0,4);
				$Region = query("region", "id = '$kehu[RegionId]' ");
				echo "
				<tr>
					<td><input name='EnrollList[]' type='checkbox' value='{$message['id']}'/></td>
					<td>{$Enroll['type']}</td>
					<td>{$content['title']}</td>
					<td>{$content['id']}</td>
					<td>{$kehu['NickName']}</td>
					<td>{$kehu['khid']}</td>
					<td>{$kehu['sex']}</td>
					<td>{$age}岁</td>
					<td>{$kehu['khtel']}</td>
					<td>{$Region['province']}{$Region['city']}{$Region['area']}</td>
					<td>{$Enroll['time']}</td>
					<td><a href='{$adroot}adMessageMx.php?id={$Enroll['id']}'><span class='SpanButton'>详情</span></a></td>
				</tr>
				";
			}
		}else{
			echo "<tr><td colspan='8'>一条信息都没有</td></tr>";
		}
		?>
	</table>
	</form>
	<div style="padding:10px;"><?php echo fenye($ThisUrl,7);?></div>
	<!--列表结束-->
</div>
<?php echo PasWarn("{$adroot}ku/addata.php").warn().adfooter();?>