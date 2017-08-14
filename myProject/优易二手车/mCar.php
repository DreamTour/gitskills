<?php
include "../library/mFunction.php";
//打印车辆基本资料
$carMx = query("Car","id = '$_GET[carMx_id]' ");
$Brand = query("Brand","id = '$carMx[BrandId]' ");
$Region = query("region","id = '$carMx[RegionId]' ");
//打印车辆详情图片
$carImgSql = mysql_query("select * from CarImg where CarId = '$_GET[carMx_id]' ");
$carImg = "";
while($array = mysql_fetch_assoc($carImgSql)){
	$carImg .= "
		<li class='swiper-slide';><a href='#'><img  src='{$root}{$array['src']}'/></a></li>
	";	
}
//判断是否改变按钮
$collectNum = mysql_fetch_array(mysql_query("select * from collect where khid = '$kehu[khid]' and CarId = '$_GET[carMx_id]' "));
if($collectNum > 0){
	$buttonClass = "coll2";
}else{
	$buttonClass = "";
} 
echo head("m");
?>
	<body style="padding-bottom:8em;">
	<div class="wrap">
		<!-- 轮播图开始 -->
		<div class="focus">
			<div class="pag pag-2"></div>
			<div class="swiper swiper-2">
				<ul class="swiper-wrapper">
					<?php echo $carImg;?>
				</ul>
			</div>
			<a href="<?php echo $root;?>m/mUser/mUser.php" class="user1"></a>
			<a href="#" class="coll <?php echo $buttonClass;?>" id="collection" carId="<?php echo $_GET['carMx_id'];?>"></a>
		</div>
		<div class="xqdiv xqdiv1">
			<h2><?php echo $carMx['name'];?></h2>
			<p><span class="red"><?php echo $carMx['price'];?>万</span>&nbsp;<span class="font1">新车含税<b class="zhx">11.02万</b></span></p>
			<div class="dai">首付2.39万&nbsp;&nbsp;月供2540元
				<select>
					<option value ="三成">三成</option>
					<option value ="两成">两成</option>
					<option value ="一成">一成</option>
				</select>
			</div>
			<p class="p2">服务费：1800元<span class="font1">（车价X2%，最低1800）</span><a href="#">详细</a></p>
		</div>
		<div class="hang"></div>
		<div class="xqdiv xqdiv2"><ul>
				<li><?php echo $Brand['EffluentStandard'];?><br/><span class="font1">排放标准</span></li>
				<li><?php echo $Brand['GearBox'];?><br/><span class="font1">变速箱</span></li>
				<li><?php echo $Brand['OutputVolume'];?>L<br/><span class="font1">排放量</span></li>
				<li><?php echo substr($carMx['RegisterTime'], 0, 7);?><br/><span class="font1">首次上牌时间</span></li>
				<li><?php echo $Brand['Nation'];?><br/><span class="font1">国别</span></li>
				<li><?php echo $Region['area'];?><br/><span class="font1">区域</span></li>
				<li><?php echo $carMx['mileage'];?>万公里<br/><span class="font1">里程数</span></li>
			</ul><div class="clear"></div></div>
		<div class="hang"></div>
		<div class="xqdiv xqdiv3">
			<ul>
				<li>电动天窗</li>
				<li>电动天窗</li>
				<li>电动天窗</li>
				<li>电动天窗</li>
				<li>电动天窗</li>
				<li>电动天窗</li>
				<li>电动天窗</li>
				<li>电动天窗</li>
			</ul>
			<a href="<?php echo $root;?>m/carParameter.php?Brand_id=<?php echo $Brand['id'];?>">查看更多参数配置</a>
		</div>
		<div class="hang"></div>
		<div class="xqdiv xqdiv4">
			<div class="title">车主描述</div>
			<div class="cont"><?php echo $carMx['text'];?></div>
		</div>
		<div class="xqbottom">
			<a href="#" class="xqba1">诚意金</a>
			<a href="#" class="xqba2">免费咨询</a>
			<a href="#" class="xqba3">预约看车</a>
		</div>
		<div id="tan1" class="tan">
			<div class="tan1 tanc">
				<div class="ctitle">诚意金须知</div>
				<p><?php echo website("mWO60741509OL");?></p>
				<a class="haode">好的</a>
			</div>
		</div>
		<div id="tan2" class="tan">
			<div class="tan2 tanc">
				<div class="ctitle">诚意金</div>
				<p><span>应收金额</span>&nbsp;&nbsp;<input type="text" name="" class="input1" value="请输入诚意金" /></p>
				<a class="xuzhi">诚意金须知</a>
				<div class="tanque">确&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;定</div>
			</div>
		</div>
		<div id="tan3" class="tan">
			<form name="seeCarForm">
				<div class="tan3 tanc">
					<div class="ctitle">预约看车</div>
					<p><span>手机号</span>&nbsp;&nbsp;<input type="text" name="" class="input1" value="请输入你的手机号" /></p>
					<p><span>验证码</span>&nbsp;&nbsp;<input type="text" name="" class="input2" value="请输入验证码" /><a href="#">获取验证码</a></p>
					<p><span>心理价位</span>&nbsp;&nbsp;<input type="text" name="" class="input1" value="请输入你的心理价位" /></p>
					<div class="tanque">确&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;定</div>
				</div>
			</form>
		</div>
		<div id="mackbg"></div>
	</div>
	</body>
<script>
$(function(){
	//收藏
	$('#collection').click(function(){
		var carId = $("[carId]").attr("carId");
		$.post("<?php echo root."library/mData.php";?>",{collectionCarId:carId},function(data){
			warn(data.warn);
			if(data.warn == "收藏成功"){
				$("[carId="+carId+"]").addClass('coll2');	
			}else if(data.warn == '取消成功'){
				$("[carId="+carId+"]").removeClass('coll2');	
			}
		},"json");	
	})	
})
</script>    
</html>
<?php echo warn();?>