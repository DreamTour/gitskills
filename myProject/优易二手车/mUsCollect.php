<?php
include "../../library/mFunction.php";
//循环收藏
$collectSql = mysql_query("select * from collect where khid = '$kehu[khid]' ");
$collectNum = mysql_num_rows($collectSql);
$collect = "";
if($collectNum == 0){
	$collect = "一条收藏都没有";	
}else{
	while($array = mysql_fetch_assoc($collectSql)){
		//打印信息
		$car = query("Car","id = '$array[CarId]' ");
		$Brand = query("Brand","id = '$car[BrandId]' ");
		$carNum = mysql_num_rows(mysql_query("select * from Car"));
		$collect .= "
			<li><a href='{$root}m/mCar.php?carMx_id={$array['CarId']}'>
				<img src='{$root}{$car['ico']}' alt='汽车图片' />
				<div class='inli1-right'>
					<p class='inli1-p1'>{$car['name']}</p>
					<p class='inli1-p2'>{$Brand['ModelYear']}年/{$car['mileage']}公里/{$Brand['GearBox']}</p>
					<p class='inli1-p3 red'>{$car['price']}万</p>
				</div>
			</a></li>
		";	
	}	
}

echo head("m");
?>
	<body>
		<div class="wrap">
		<!-- 轮播图开始 -->
		<ul class="info-ul1">
			<?php echo $collect;?>
		</ul>
		</div>
	</body>
</html>