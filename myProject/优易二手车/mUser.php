<?php
include "../../library/mFunction.php";
//判断是否改变签到按钮值和颜色
if($kehu['SignDate'] == $date){
	$buttonValue = "你已签到";
	$buttonBackground = "style='background:#999;'";		
}else{
	$buttonValue = "今日签到";
	$buttonBackground = "";	
}	
//积分使用说明
$integral = query("content","id = 'sxc60808727iM' ");
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
	<body style="padding-bottom:6em;">
		<div class="wrap">
		<div class="member">
			<div class="mem_user"><img src="../../img/WebsiteImg/TYj57634277eP.jpg" alt="" /></div>
			<a href="#" class="sign" <?php echo $buttonBackground;?> id="signUp"><?php echo $buttonValue;?></a>
		</div>
		<div class="hydiv1">
			<a href="<?php echo $root;?>m/mUser/mUsAuction.php" class="hyd1a1">拍&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;卖</a><a href="<?php echo $root;?>m/mUser/mUsGroup.php" class="hyd1a2">团&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;购</a>
			<div class="clear"></div>
		</div>
		<div class="hydiv hydiv2">
			<p class="hyp2"><span>我的积分 : <b class="red" id="signNum"><?php echo $kehu['integral'];?></b><a href="#" class="jifen">详细</a></span></p>
			<p class="hyp1"><a href="<?php echo $root;?>m/mUser/mUsAbout.php"><span class="hyico1">关于我们</span></a></p>
		</div>
		<div class="hydiv hydiv3">
			<p class="hyp1"><a href="<?php echo $root;?>m/mUser/mUsRecord.php"><span class="hyico3">交易记录</span></a></p>
			<p class="hyp1"><a href="<?php echo $root;?>m/mUser/mUsPersonal.php"><span class="hyico2">我的资料</span></a></p>
		</div>
		<div class="infoul">
		<div class="title"><b>我的收藏</b></div>
		<ul class="info-ul1">
			<?php echo $collect;?>
		</ul>
		</div>
		<div class="hybottom"><a href="#">收&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;款</a></div>
		<div id="tan7" class="tan"><div class="tan7 tanc">
			<div class="ctitle"><?php echo $integral['title'];?></div>
			<p class="integral"><?php echo ArticleMx("sxc60808727iM");?></p>
		</div></div>
		<div id="mackbg"></div>
		</div>
	</body>
<script>
$(function(){
	//每日签到
	var signUp = $("#signUp");
	signUp.click(function(){
		$.post("<?php echo root."library/mData.php";?>",{signUp:"yes"},function(data){
			warn(data.warn);
			if(data.warn == "签到成功"){
				signUp.html("你已签到").css("background","#999");
				$("#signNum").html(data.num);	
			}
		},"json");		
	})		
})
</script>    
</html>