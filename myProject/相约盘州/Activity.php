<?php
require_once("library/PcFunction.php");
$ThisUrl = root."Activity.php";
if(isset($_GET['type'])){
	if($_GET['type'] == "offlineActivity"){
		$ThisUrl .= "?type=offlineActivity";
		$finger = 1;
	}elseif($_GET['type'] == "myActivity"){
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
//串联活动列表
if($finger == 1){
	$sql = " select * from content where type = '最新活动' and classify = '线下活动' and xian = '显示' ";
	paging($sql," order by  UpdateTime desc ",5);
	$Activity = "";
	if($num == 0){
		$Activity .= "一个活动都没有";
	}else{
		while($array = mysql_fetch_array($query)){
			$Activity .= Activity($array);
		}
	}
}elseif($finger == 2){
	$sql = " select * from Enroll where khid = '$kehu[khid]' ";
	paging($sql," order by  time desc ",5);
	$Activity = "";
	if($num == 0){
		$Activity .= "一个活动都没有";
	}else{
		while($Enroll = mysql_fetch_array($query)){
			$array = query("content"," id = '$Enroll[ContentId]' ");
			$Activity .= Activity($array);
		}
	}
}
//活动列表模板函数
function Activity($array){
	//赋值
	$kehu = $GLOBALS['kehu'];
	//判断是否该显示活动报名按钮
	if($_GET['type'] == 'myActivity'){
		$button = "";
	}else{
		$EnrollNum = mysql_num_rows(mysql_query(" select * from Enroll where khid = '$kehu[khid]' and ContentId = '$array[id]' "));
		if($EnrollNum > 0){
		    $ButtonValue = "您已报名";
			$color = " style=' background-color:#bbb;' ";
		}else{
		    $ButtonValue = "立即报名";
			$color = "";
		}
		$button = "<a class='sign_up_btn' {$color} href='javascript:;' signUp='{$array['id']}'>{$ButtonValue}</a>";
	}
	return "
	<div class='activity_content01'>
		<h1>{$array['title']}</h1>
		<div class='activity_content_body'>
			<img src='".ListImg($array['ico'])."'>
			<div class='activity_body_introduce'>
				<p>{$array['summary']}</p>
				<div class='activity_time'><i class='activity_icon activity_icon01'></i>
					<span>{$array['DepartDay']}</span>
				</div>
				<div class='activity_place'><i class='activity_icon activity_icon02'></i>
					<span>{$array['address']}</span>
				</div>
				<div class='sign_up '>已报名<a href='javascript:;' signNum='{$array['id']}'>{$array['EnrollNum']}</a>人</div>
				{$button}
			</div>
		</div>
	</div>
	";
}
//判断是否应该显示我的活动
if($KehuFinger == 1){
    $myActivity = "<a href='".root.'Activity.php?type=myActivity'."'>
                       <p class='off-line ".MenuGet('type','myActivity','active')."' id='my-activity'>我的活动</p>
                   </a>
					  ";
}else{
	$myActivity = "";	
} 
echo head("pc").pc_header();
?>
<style>
.off-line{ background:#fff;color:#000;}
.active{background-color: #ff536a;color:#fff;}
/*banner*/
.banner{
	height:450px;
	margin:auto;
	overflow:hidden;
	position:relative;	
}
#banner-scontainer {
    position: absolute;
    overflow: hidden;
    height: 450px;
    top: 0;
    width: 100%;
}
#banner-scontainer .list-item li{ float:left; height:450px;}
#banner-scontainer .list-item:after{ content:''; display:block; clear:both;}
#banner-scontainer .sort-item{ position:absolute; width:100%; bottom:20px; left:0; z-index:100; text-align:center}
#banner-scontainer .sort-item li{ width:10px; height:10px; background:#fff; display:inline-block; margin:0 5px;}
#banner-scontainer .list-item li{max-width:1903px !important;}
#banner-scontainer .sort-item .cur{ background:#C00 !important;}
</style>
<!--banner-->
<div class="banner">
    <div id="banner-scontainer" class="banner-scontainer">
        <div class="banner-listitem">
            <ul class="list-item">
                <li style="background:url(<?php echo img("fIX49944449NG");?>) no-repeat scroll center/cover"></li>
                <li style="background:url(<?php echo img("YOs52692750nh");?>) no-repeat scroll center/cover"></li>
                <li style="background:url(<?php echo img("LNq52692953Ny");?>) no-repeat scroll center/cover"></li>
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
            <a href="<?php echo root."Activity.php?type=offlineActivity";?>">
                <p class="off-line <?php echo MenuGet("type","offlineActivity","active");?>" id="activity">线下活动</p>
            </a>
            <?php echo $myActivity;?>
        </div>
        <div class="activity_content" id="activity-one">
            <?php echo $Activity;?>                
        </div>
       <div class="activity_content" id="activity-two" style="display:none;">
            <?php echo $Activity;?>                
        </div>
        <div class="activity_btn">
            <?php echo fenye($ThisUrl,7);?>
        </div>
    </div>
</div>
<script>
/*banner切换*/
var banner = function(a) {
		var a = a || {};
		var timer = null;
		var count = 0;
		var sorts = jQuery(a.sortItem);
		var lists = jQuery(a.listItem);
		var sortItem = sorts.find('li');
		var listItem = lists.find('li');
		var length = listItem.length;
		console.log(length);
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
$(function() {
	//立即报名
	$("[signUp]").click(function(){
		var signUp = $(this).attr('signUp');
		$.post("<?php echo root."user/usData.php";?>", { signUp: signUp},function(data) {
			if(data.warn == "报名成功"){
				$("[signNum="+signUp+"]").html(data.num);
				$("[signUp="+signUp+"]").html('你已报名');
				$("[signUp="+signUp+"]").css('background','#999');	
			}
			warn(data.warn);
		},"json");
	});
});
</script>
<?php echo warn().footer();?>
