<?php
include "ku/adfunction.php";
ControlRoot("车辆管理");
$ThisUrl = root."control/adCarBrand.php";
$sql="select * from Brand ".$_SESSION['adBrand']['Sql'];
paging($sql," order by type asc ",100);
echo head("ad").adheader();
?>
<div class="column minheight">
	<!--标题开始-->
	<a href="<?php echo $ThisUrl;?>"><img src="<?php echo "{$root}img/adimg/adCar.png";?>"></a>
	<p>
		<a href="<?php echo root."control/adCar.php";?>">车辆管理</a>&nbsp;&nbsp;>&nbsp;
        <a href="<?php echo root."control/adCarBrand.php";?>">品牌管理</a>
	</p>
	<!--标题结束-->
    <!--查询开始-->
	<div class="kuang">
		<form name="Search" action="<?php echo "{$adroot}ku/adpost.php";?>" method="post">
			车辆品牌：<input name="adBrandType" type="text" class="text TextPrice" value="<?php echo $_SESSION['adBrand']['type'];?>">
            子品牌：<input name="adBrandName" type="text" class="text TextPrice" value="<?php echo $_SESSION['adBrand']['name'];?>">
			年限：<input name="adBrandModelYear" type="text" class="text TextPrice" value="<?php echo $_SESSION['adBrand']['ModelYear'];?>">
            车辆型号：<input name="adBrandMotorcycleType" type="text" class="text TextPrice" value="<?php echo $_SESSION['adBrand']['MotorcycleType'];?>">
			显示状态：<input name="adBrandXian" type="text" class="text TextPrice" value="<?php echo $_SESSION['adBrand']['xian'];?>">	
            排序号：<input name="adBrandList" type="text" class="text TextPrice" value="<?php echo $_SESSION['adBrand']['list'];?>">
			<input type="submit" value="模糊查询">
		</form>
	</div>
	<div class="kuang">
		<span class="SpanButton">
			共找到<b class="must"><?php echo $num;?></b>条信息&nbsp;&nbsp;
			当前显示第<b class="must"><?php echo $page;?></b>页的信息
		</span>
        <a href="<?php echo root."control/adCarBrandMx.php";?>"><span class="SpanButton FloatRight">新建品牌</span></a>
        <span onclick="EditList('BrandForm','DeleteBrand')" class="SpanButton FloatRight">删除品牌</span>
        <span onclick="$('[name=BrandForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
		<span onclick="$('[name=BrandForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
	</div>
	<!--查询结束-->
	<!--列表开始-->
	<form name="BrandForm">
	<table class="TableMany">
		<tr>
        	<td></td>
			<td>车辆品牌</td>
			<td>车辆子品牌</td>
			<td>年款</td>
			<td>车辆型号</td>
            <td>显示状态</td>
            <td>排序号</td>
			<td>更新时间</td>
            <td></td>
		</tr>
		<?php
		if($num > 0){
			while($Brand = mysql_fetch_array($query)){
				echo "
				<tr>
					<td><input name='BrandList[]' type='checkbox' value='{$Brand['id']}'/></td>
					<td>{$Brand['type']}</td>
					<td>{$Brand['name']}</td>
					<td>{$Brand['ModelYear']}款</td>
					<td>{$Brand['MotorcycleType']}</td>
					<td>{$Brand['xian']}</td>
					<td>{$Brand['list']}</td>
					<td>{$Brand['UpdateTime']}</td>
					<td><a href='{$adroot}adCarBrandMx.php?id={$Brand['id']}'><span class='SpanButton'>详情</span></a></td>
				</tr>
				";
			}
		}else{
			echo "<tr><td colspan='9'>一个车辆品牌都没有</td></tr>";
		}
		?>
	</table>
	</form>
	<div style="padding:10px;"><?php echo fenye($ThisUrl,7);?></div>
	<!--列表结束-->
</div>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>