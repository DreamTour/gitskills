<?php 
include "library/PcFunction.php";
UserRoot("pc");
echo head("pc");
limit($kehu);
$ThisUrl = root."activity.php";
/***********活动类型切换******************/
if(isset($_GET['type'])){
	if($_GET['type'] == "offlineActivity"){
		$ThisUrl .= "?type=offlineActivity";
		$finger = 1;	
	}else if($_GET['type'] == "myActivity"){
		$ThisUrl .= "?type=myActivity";
		$finger = 2;
	}else{
		$ThisUrl .= "?type=offlineActivity";
		$finger = 1;
	}	
}else{
	header("location:{$ThisUrl}?type=offlineActivity");
	exit(0);	
}
/***********活动列表******************/
//活动报名成功后才在我的活动里面显示
$activitySql = "";
if($finger == 1){
	//线下活动
	$activitySql = "select * from content where type = '活动展示' and classify = '线下活动' and xian = '显示' ";
	paging($activitySql,"order by UpdateTime desc",5);
}else if($finger == 2){
	//我的活动
	$activitySql = "select * from content as C,Enroll as E where C.type = '活动展示' and C.classify = '线下活动' and C.xian = '显示' and C.id = E.ContentId and E.khid = '$kehu[khid]'";
	paging($activitySql,"order by UpdateTime desc",5);
}	
$activity = "";
$button = "";
$buttonValue = "";
$buttonBackground = "";
if($num == 0){
	$activity .= "一个活动都没有";	
}else{
	while($array = mysql_fetch_array($query)){
	//判断是否显示活动报名按钮
	if($_GET['type'] == offlineActivity){
		$EnrollNum = mysql_fetch_array(mysql_query("select * from Enroll where khid = '$kehu[khid]' and ContentId = '$array[id]' "));
		//判断是否改变按钮值和颜色
		if($EnrollNum > 0){
			$buttonValue = "取消报名";
			$buttonBackground = "style='background:#999;'";		
		}else{
			$buttonValue = "立即报名";
			$buttonBackground = "";	
		}	
		$button = "<a class='sign_up_btn' {$buttonBackground} href='javascript:;' signUp={$array['id']}>{$buttonValue}</a>";
	}else{
		$button = "";	
	}
	$activity .= "
		<div class='activity_content01'>
			<h1>{$array['title']}</h1>
			<div class='activity_content_body'>
				<img src='{$array['ico']}'>
				<div class='activity_body_introduce'>
					<p>{$array['summary']}</p>
					<div class='activity_time'><i class='activity_icon activity_icon01'></i><span>{$array['DepartDay']}</span></div>
					<div class='activity_place'><i class='activity_icon activity_icon02'></i><span>{$array['address']}</span></div>
					<div class='sign_up '>已报名<a href='javascript:;' signNum={$array['id']}>{$array['EnrollNum']}</a>人</div>
					{$button}
				</div>
			</div>
        </div> 
	";
	}
}
//判断是否应该显示我的活动
$myActivity = "";
if($KehuFinger == 1){
	$myActivity = "
		<a href='{$root}activity.php?type=myActivity'>  
			<p class='off-line ".MenuGet('type','myActivity','active')."' id='my-activity'>我的活动</p>
		</a>
	";	
}else{
	$myActivity = "";	
}
?>
<style>
.icon{ background:url(<?php echo img("WxN53377734Xb");?>)}
.banner{height:450px;margin:auto;overflow:hidden;position:relative}
#banner-scontainer{position:absolute;overflow:hidden;height:450px;top:0;width:100%}
#banner-scontainer .list-item li{float:left;height:450px}
#banner-scontainer .list-item:after{content:'';display:block;clear:both}
#banner-scontainer .sort-item{position:absolute;width:100%;bottom:20px;left:0;z-index:100;text-align:center}
#banner-scontainer .sort-item li{width:10px;height:10px;background:#fff;display:inline-block;margin:0 5px}
#banner-scontainer .sort-item .cur{background:#C00!important}
.activity_container_box{background-color:#f6f7fb;margin-top:20px;overflow:hidden}
.activity_container{width:1000px;margin:auto}
.activity_top{height:60px;background-color:#fff;margin:20px 0;overflow:hidden}
.my_activity,.off-line{float:left;line-height:60px;font-size:18px}
.off-line{width:130px;text-align:center;color:#000}
.active{background-color:#ff7c7c;color:#fff}
.my_activity{color:#000;margin-left:40px}
.activity_content01{height:260px;background-color:#fff;border:1px solid #d4d4d4;padding:20px 30px;margin-bottom:15px}
.activity_content01 h1{font-size:20px;font-weight:700;color:#000;margin-bottom:15px}
.activity_body_introduce{width:560px;float:right;position:relative}
.activity_body_introduce p{color:#000;font-size:14px;height:60px;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:3;
overflow:hidden;margin-bottom:10px}
.activity_place,.activity_time{margin-bottom:10px}
.activity_place i,.activity_time i{width:22px;height:22px;margin-bottom:-4px}
.activity_place span,.activity_time span{color:#747474;font-size:16px;margin-left:5px}
.sign_up{color:#000;font-size:16px;margin-left:4px}
.sign_up a{color:#ff7c7c;font-size:16px;margin:0 3px;text-decoration:underline}
.sign_up_btn{position:absolute;right:0;bottom:-8px;display:inline-block;width:130px;height:40px;background-color:#ff7c7c;color:#fff;font-size:18px;line-height:40px;text-align:center}
.activity_icon01{background-position:-18px -9px}
.activity_icon02{background-position:-18px -37px}
.activity_btn_item{display:inline-block;width:30px;height:30px;border:1px solid #d4d4d4;text-align:center;font-size:16px;line-height:30px;background-color:#fff;margin-right:5px}
.activity_btn_icon01{background-position:-12px -61px}
.activity_btn_icon01,.activity_btn_icon02{color:transparent}
.activity_btn_icon02{background-position:-9px -85px}
.activity_btn_current{background-color:#ff7c7c;color:#fff}
.activity_btn{text-align:center;margin:30px 0 50px}
.activity_icon{background-image:url(<?php echo img("eyP49932853ks");?>)}
/*::-webkit-scrollbar{ width:0;}*/
</style>
<!--头部-->
    <?php echo pcHeader();?>
        <!--banner-->
        <div class="banner">
            <div id="banner-scontainer" class="banner-scontainer">
                <div class="banner-listitem">
                    <ul class="list-item">
                        <li style="background:url(<?php echo img("fIX49944449NG");?>) no-repeat scroll center/cover"></li>
                        <li style="background:url(<?php echo img("paX53378607Rf");?>) no-repeat scroll center/cover"></li>
                        <li style="background:url(<?php echo img("OzS53378634dZ");?>) no-repeat scroll center/cover"></li>
                    </ul>
                </div>
                <div class="banner-sortitem">
                    <ul class="sort-item"></ul>
                </div>
            </div>
        </div>
        <!--内容-->
        <div class="activity_container_box">
            <div class="activity_container">
                <div class="activity_top" id="jeep">
                	<a href="<?php echo root."activity.php?type=offlineActivity";?>">
                    	<p class="off-line <?php echo MenuGet("type","offlineActivity","active");?>" id="activity">线下活动</p>
                    </a>
                    <?php echo $myActivity?>
                </div>
                <div class="activity_content" id="activity-one">
                    <?php echo $activity;?>
               </div>
               <div class="activity_content" id="activity-two" style="display:none;">
                    <?php echo $activity;?>
               </div>
                <div class="activity_btn">
					<?php echo fenye($ThisUrl,7);?>
                </div>
            </div>
        </div>
<!--底部-->
<?php echo warn().pcFooter();?>
<script>
var banner = function(a) {
		var a = a || {};
		var timer = null;
		var count = 0;
		var sorts = jQuery(a.sortItem);
		var lists = jQuery(a.listItem);
		var sortItem = sorts.find('li');
		var listItem = lists.find('li');
		var length = listItem.length;
		for (var i = 0; i < length; i++) {
			sorts.append('<li></li>')
		}
		sorts.find('li:first').addClass('cur').siblings().removeClass('cur');
		lists.width(sorts.width() * length);
		var w = window;
		lists.find('li').width(w.innerWidth);
		lists.find('img').width(w.innerWidth);
		lists.width(w.innerWidth * length);
		var resize = function() {
				var w = window;
				lists.find('li').width(w.innerWidth);
				lists.find('img').width(w.innerWidth);
				lists.width(w.innerWidth * length)
			}
		window.addEventListener('resize', resize, false);
		var setMove = function(index) {
				lists.animate({
					marginLeft: -index * sorts.width()
				}, 600)
			}
		var interval = function() {
				timer = setInterval(function() {
					count++;
					if (count == length) {
						count = 0
					}
					sorts.find('li').eq(count).addClass('cur').siblings().removeClass('cur');
					setMove(count)
				}, 2500)
			}
		$('.sort-item li').click(function() {
			clearInterval(timer);
			var index = $(this).index();
			sorts.find('li').eq(index).addClass('cur').siblings().removeClass('cur');
			count = index;
			setMove(index);
			interval()
		});
		lists.hover(function() {
			clearInterval(timer)
		}, function() {
			interval()
		});
		interval()
}
$(function(){
	//立即报名
	$("[signUp]").click(function(){
		var signUp = $(this).attr('signUp');
		$.post("<?php echo root."library/usData.php";?>",{signUp:signUp},function(data){
			warn(data.warn);
			if(data.warn == "报名成功"){
				$("[signNum="+signUp+"]").html(data.num);
				$("[signUp="+signUp+"]").html("取消报名").css("background","#999");	
			}else if(data.warn == '取消成功'){
				$("[signNum="+signUp+"]").html(data.num);
				$("[signUp="+signUp+"]").html("立即报名").css("background","#ff7c7c");	
			}
		},"json");		
	})	
})
</script>
</body>
</html>

