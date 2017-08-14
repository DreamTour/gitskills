<?php
include "ku/adfunction.php";
ControlRoot("车辆管理");
$ThisUrl = root."control/adCar.php";
$sql="select * from Car ".$_SESSION['adCar']['Sql'];
paging($sql," order by time desc ",100);
echo head("ad").adheader();
?>
<div class="column minheight">
	<!--标题开始-->
	<a href="<?php echo $ThisUrl;?>"><img src="<?php echo "{$root}img/adimg/adCar.png";?>"></a>
	<p>
		<a href="<?php echo $ThisUrl;?>">车辆管理</a>
	</p>
	<!--标题结束-->
    <!--查询开始-->
	<div class="kuang">
		<form name="Search" action="<?php echo root."control/ku/adpost.php";?>" method="post">
            名称：<input name="adCarName" type="text" class="select TextPrice" value="<?php echo $_SESSION['adCar']['name'];?>">
            颜色：<input name="adCarColour" type="text" class="select TextPrice" value="<?php echo $_SESSION['adCar']['colour'];?>">
            行驶里程：<input name="adCarMileage" type="text" class="select TextPrice" value="<?php echo $_SESSION['adCar']['mileage'];?>">
            价格：<input name="adCarPrice" type="text" class="select TextPrice" value="<?php echo $_SESSION['adCar']['price'];?>">
            车架号：<input name="adCarVin" type="text" class="select TextPrice" value="<?php echo $_SESSION['adCar']['vin'];?>">
			<input type="submit" value="模糊查询">
		</form>
	</div>
	<div class="kuang">
		<span class="SpanButton">
			共找到<b class="must"><?php echo $num;?></b>条信息&nbsp;&nbsp;
			当前显示第<b class="must"><?php echo $page;?></b>页的信息
		</span>
        <a href="<?php echo root."control/adCarMx.php";?>"><span class="SpanButton FloatRight">新建车辆</span></a>
        <a href="<?php echo root."control/adCarBrand.php";?>"><span class="SpanButton FloatRight">品牌管理</span></a>
        <span onclick="EditList('CarForm','DeleteCar')" class="SpanButton FloatRight">删除车辆</span>
        <span onclick="$('[name=CarForm] [type=checkbox]').prop('checked',false);" class="SpanButton FloatRight">取消选择</span>
		<span onclick="$('[name=CarForm] [type=checkbox]').prop('checked',true);" class="SpanButton FloatRight">选择全部</span>
	</div>
	<!--查询结束-->
	<!--列表开始-->
	<form name="CarForm">
	<table class="TableMany">
		<tr>
        	<td></td>
			<td>名称</td>	
            <td>颜色</td>
            <td>行驶里程(万公里)</td>
            <td>价格(万元)</td>
            <td>车架号</td>
            <td>品牌</td>
            <td>子品牌</td>
            <td>年款</td>
            <td>车型</td>
            <td>更新时间</td>
			<td>创建时间</td>
        	<td></td>
		</tr>
		<?php
		if($num > 0){
			while($Car = mysql_fetch_array($query)){
				$Brand = query("Brand", "id = '$Car[BrandId]' ");
				echo "
				<tr>
					<td><input name='CarList[]' type='checkbox' value='{$Car['id']}'/></td>
					<td>{$Car['name']}</td>
					<td>{$Car['colour']}</td>
					<td>{$Car['mileage']}</td>
					<td>{$Car['price']}</td>
					<td>{$Car['vin']}</td>
					<td>{$Brand['type']}</td>
					<td>{$Brand['name']}</td>
					<td>{$Brand['ModelYear']}</td>
					<td>{$Brand['MotorcycleType']}</td>
					<td>{$Car['UpdateTime']}</td>
					<td>{$Car['time']}</td>
					<td><a href='{$adroot}adCarMx.php?id={$Car['id']}'><span class='SpanButton'>详情</span></a></td>
				</tr>
				";
			}
		}else{
			echo "<tr><td colspan='13'>一个车辆都没有</td></tr>";
		}
		?>
	</table>
	</form>
	<div style="padding:10px;"><?php echo fenye($ThisUrl,7);?></div>
	<!--列表结束-->
</div>
<?php echo PasWarn(root."control/ku/addata.php").warn().adfooter();?>