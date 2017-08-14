<?php
include "../library/mFunction.php";
$ThisUrl = "{$root}m/mindex.php";
//打印车型
$Brand = query();
//智能排序
if($_GET['order'] == 'default'){
	$order = 'UpdateTime desc';	
}else if($_GET['order'] == 'newTime'){
	$order = 'time desc';
}else if($_GET['order'] == 'priceLow'){
	$order = 'price asc';	
}else if($_GET['order'] == 'priceHeight'){
	$order = 'price desc';	
}else if($_GET['order'] == 'cardTime'){
	$order = 'RegisterTime desc';	
}else if($_GET['order'] == 'distanceLess'){
	$order = 'mileage asc';	
}else{
	$order = 'UpdateTime desc';	
}
//车辆列表
$carSql = mysql_query("select * from Car order by {$order}");
$carNum = mysql_num_rows(mysql_query("select * from Car"));
$car = "";
if($carNum == 0){
	$car = "一条车辆信息都没有";	
}else{
	while($array = mysql_fetch_assoc($carSql)){
		$Brand = query("Brand","id = '$array[BrandId]' ");
		$car .= "
			<li><a href='{$root}m/mCar.php?carMx_id={$array['id']}'>
				<img src='{$root}{$array['ico']}' alt='汽车图片' />
				<div class='inli1-right'>
					<p class='inli1-p1'>{$array['name']}</p>
					<p class='inli1-p2'>{$Brand['ModelYear']}年/{$array['mileage']}公里/{$Brand['GearBox']}</p>
					<p class='inli1-p3 red'>{$array['price']}万</p>
				</div>
			</a></li>	
		";
	}	
}
//生成价格下拉菜单
for($n = 0;$n <= 100;$n++){
	$option[$n] = $n."万";
}
$minMoney = select('searchMinMoney','s_style2',"最小价格",$option,"$n");
$maxMoney = select('searchMaxMoney','s_style2',"最大价格",$option,"$n");
echo head("m");
?>
	<body>
		<div class="wrap">
		<!-- 轮播图开始 -->
		<div class="focus">
        <div class="pag pag-1"></div>
        <div class="swiper swiper-1">
            <ul class="swiper-wrapper">
                <li class='swiper-slide';><a href='#'><img  src='<?php echo img("hsC57370578IV");?>'/></a></li>
                <li class='swiper-slide';><a href='#'><img  src='<?php echo img("ZwR60729103YZ");?>'/></a></li>
                <li class='swiper-slide';><a href='#'><img  src='<?php echo img("EqL60729196rH");?>'/></a></li>
                <li class='swiper-slide';><a href='#'><img  src='<?php echo img("Fnz60729235cu");?>'/></a></li>
            </ul>
        </div>
		<a href="<?php echo $root;?>m/mUser/mUser.php" class="user"></a>
		</div>
        <form name="configForm">
		<div class="menu">
			<a class="menua menu-a1">智能排序</a>
			<a class="menua menu-a2">品牌</a>
			<a class="menua menu-a3">价格</a>
			<a class="menua menu-a4">筛选</a>
			<div class="menu-cont1">
				<a href="<?php echo $ThisUrl."?order=default";?>">智能排序</a>
				<a href="<?php echo $ThisUrl."?order=newTime";?>">最新上架</a>
				<a href="<?php echo $ThisUrl."?order=priceLow";?>">价格最低</a>
				<a href="<?php echo $ThisUrl."?order=priceHeight";?>">价格最高</a>
				<a href="<?php echo $ThisUrl."?order=cardTime";?>">上牌时间</a>
				<a href="<?php echo $ThisUrl."?order=distanceLess";?>">里程最少</a>
			</div>
			<div class="menu-cont2">
				<?php echo RepeatSelect("Brand","type","BrandTypeSelect","select","--选择--",$Brand['type']);?>
				<select name="BrandName" class="select">
				 	<?php echo IdOption("Brand where type = '{$Brand[type]}' ","id","name","--子品牌--",$Brand['name']);?>
                 </select>
				<div class="clear"></div>
				<a href="#" class="queding">确定</a>
			</div>
			<div class="menu-cont3">
				<?php echo $minMoney;?>
                <?php echo $maxMoney;?>
				<div class="clear"></div>
				<a href="#" class="queding">确定</a>
			</div>
			<div class="menu-cont4">
				<a >车型</a>
				<a >车龄</a>
				<a >排量</a>
				<a >里程</a>
				<a >变速箱</a>
				<a >排放标准</a>
				<a >国别</a>
			</div>
			<div class="menu-on">
				<a href="<?php echo $ThisUrl."?oneClassify=default&twoClassify=";?>">SUV</a>
				<a href="<?php echo $ThisUrl."?order=default";?>">轿车</a>
				<a href="<?php echo $ThisUrl."?order=default";?>">MPV</a>
				<a href="<?php echo $ThisUrl."?order=default";?>">皮卡</a>
			</div>
			<div class="menu-on">
				<a href="<?php echo $ThisUrl."?oneClassify=ageTime&twoClassify=one";?>">1年以内</a>
				<a href="<?php echo $ThisUrl."?oneClassify=ageTime&twoClassify=three";?>">3年以内</a>
				<a href="<?php echo $ThisUrl."?oneClassify=ageTime&twoClassify=five";?>">5年以内</a>
				<a href="<?php echo $ThisUrl."?oneClassify=ageTime&twoClassify=eight";?>">8年以内</a>
				<a href="<?php echo $ThisUrl."?oneClassify=ageTime&twoClassify=other";?>">8年以上</a>
			</div>
			<div class="menu-on">
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=one";?>">1.0以下</a>
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=two";?>">2.0以下</a>
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=three";?>">3.0以下</a>
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=four";?>">4.0以下</a>
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=other";?>">4.0以上</a>
			</div>
			<div class="menu-on">
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=other";?>">1万以内</a>
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=other";?>">3万以内</a>
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=other";?>">6万以内</a>
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=other";?>">9万以内</a>
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=other";?>">12万以内</a>
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=other";?>">15万以内</a>
			</div>
			<div class="menu-on">
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=other";?>">手动</a>
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=other";?>">自动</a>
			</div>
			<div class="menu-on">
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=other";?>">国二以上</a>
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=other";?>">国三以上</a>
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=other";?>">国四以上</a>
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=other";?>">国五以上</a>
			</div>
			<div class="menu-on">
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=other";?>">德系</a>
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=other";?>">日系</a>
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=other";?>">美系</a>
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=other";?>">法系</a>
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=other";?>">韩系</a>
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=other";?>">国产</a>
				<a href="<?php echo $ThisUrl."?oneClassify=outputVolume&twoClassify=other";?>">其他</a>
			</div>
		</div>
        </form>
		<div class="mack"></div>
		<!-- 轮播图结束 -->
		<ul class="info-ul1" style="min-height: 300px;">
			<?php echo $car;?>
		</ul>
		</div>
	</body>
<script>
	$(function() {
		//车辆根据品牌返回子品牌
		var Form = document.configForm;
		Form.BrandTypeSelect.onchange = function(){
			$.post("<?php echo root."library/mData.php";?>",{BrandTypeSelect:this.value},function(data){
				Form.BrandName.innerHTML = data.ColumnChild;
			},"json")
		};
		//筛选品牌价格表单提交
		$('.queding').click(function(){
			$.post("<?php echo root."library/mData.php";?>",$("[name=configForm]").serialize(),function(data){
				$('.info-ul1').html(data.html);
			},"json");
		});
	})
</script>    
</html>