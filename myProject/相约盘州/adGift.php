<?php
include "ku/adfunction.php";
$ThisUrl = $adroot."adGift.php";
$sql = "select * from Gift ".$_SESSION['adGift']['Sql'];
paging($sql," order by UpdateTime desc",100);
echo head("ad").adheader();
?>
<div class="column minheight">
    <a href="<?php echo $ThisUrl;?>"><img src="<?php echo "{$root}img/adimg/adGift.png";?>"></a>
    <!--查询开始-->
	<div class="kuang">
		<form name="Search" action="<?php echo "{$adroot}ku/adpost.php";?>" method="post">
			礼物名称：<input name="adGiftName" type="text" class="text TextPrice" value="<?php echo $_SESSION['adGift']['name'];?>">
            礼物单价：<input name="adGiftPrice" type="text" class="text TextPrice" value="<?php echo $_SESSION['adGift']['price'];?>">
			<input type="submit" value="模糊查询">
		</form>
	</div>
	<div class="kuang">
		<span class="SpanButton">
			共找到<b class="must"><?php echo $num;?></b>条信息
			当前显示第<b class="must"><?php echo $page;?></b>页的信息
		</span>
		<a href="<?php echo "{$adroot}adGiftMx.php";?>"><span class="SpanButton FloatRight">新建礼物</span></a>
        <span onclick="EditList('GiftForm','DeleteGift')" class="SpanButton FloatRight">删除礼物</span>
        <span onclick="$('[name=GiftForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
		<span onclick="$('[name=GiftForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
	</div>
	<!--查询结束-->
	<!--列表开始-->
	<form name="GiftForm">
	<table class="TableMany">
		<tr>
			<td></td>
            <td>礼物名称</td>
			<td>礼物单价</td>
			<td>更新时间</td>
			<td></td>
		</tr>
		<?php
		if($num > 0){
			while($Gift = mysql_fetch_array($query)){
				echo "
				<tr>
					<td><input name='GiftList[]' type='checkbox' value='{$Gift['id']}'/></td>
					<td>{$Gift['name']}</td>
					<td>{$Gift['price']}</td>
					<td>{$Gift['UpdateTime']}</td>
					<td><a href='{$adroot}adGiftMx.php?id={$Gift['id']}'><span class='SpanButton'>详情</span></a></td>
				</tr>
				";
			}
		}else{
			echo "<tr><td colspan='5'>一个礼物都没有</td></tr>";
		}
		?>
	</table>
	</form>
	<div style="padding:10px;"><?php echo fenye($ThisUrl,7);?></div>
	<!--列表结束-->
</div>
<?php echo PasWarn("{$adroot}ku/addata.php").warn().adfooter();?>