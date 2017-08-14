<?php
require_once "library/PcFunction.php";
$ThisUrl = root."Message.php";
if(isset($_GET['type'])) {
	if($_GET['type'] == "newest") {
		$ThisUrl .= "?type=newest";
		$order = "time";
	} elseif($_GET['type'] == "hot") {
		$ThisUrl .= "?type=hot";
		$order = "num";	
	} else {
		$ThisUrl .= "?type = newest";
		$order = "time";	
	}	
} else {
	header("location:{$ThisUrl}?type=newest");
	exit(0);	
}
$sql = " select * from talk where type = '盘州信息' and Auditing = '已通过' ";
paging($sql,"order by {$order} desc", 6);
/*************盘州信息列表**********************************************/
$message = "";
if($num == 0){
	$message .= "一条信息都没有";
}else{
	while($array = mysql_fetch_array($query)){
		$dateTime = date("Y-m-d",strtotime($array['time']));
		$kehu = mysql_fetch_array(mysql_query("select * from kehu where khid = '$array[khid]'"));
		$message .= "
		<div class='news_content1'>
                <div class='news_left'>
                    <a href='{$root}SearchMx.php?search_khid={$kehu['khid']}'><img style='width:100px;' src='".HeadImg($kehu['sex'],$kehu['ico'])."'></a>
                    <p style='width:106px;'>{$kehu['NickName']}</p>
                </div>
                <div class='news_right'>
                    <i id='news_btn' class='news_btn2'></i>
                    <a href='{$root}MessageMx.php?talkId={$array['id']}'><h1>{$array['title']}</h1></a>
                    <span class='browse'>浏览量：{$array['num']}</span>
                    <a href='{$root}MessageMx.php?talkId={$array['id']}'><p>{$array['text']}</p></a>
                    <span>发布时间：{$dateTime}</span>
                </div>
            </div>
		";
	}
}
echo head("pc").pc_header();
?>
<style>
#news_btn{background-image:url(<?php echo img("GRE50462428Fy");?>);text-align:center}
.banner{position:relative;margin:auto}
#banner-scontainer,.banner{overflow:hidden;height:450px}
#banner-scontainer{position:absolute;top:0;width:100%}
#banner-scontainer .list-item li{float:left;height:450px}
#banner-scontainer .list-item:after{clear:both;display:block;content:''}
#banner-scontainer .sort-item{position:absolute;bottom:20px;left:0;z-index:100;width:100%;text-align:center}
#banner-scontainer .sort-item li{display:inline-block;margin:0 5px;width:10px;height:10px;background:#fff}
#banner-scontainer .sort-item .cur{background:#c00!important}
.panzhou_news{overflow:hidden;margin:20px auto;width:750pt}
.news_place a,.news_place span{font-size:14px}
.news_place a{color:#ff536a}
.news_place_icon{margin-bottom:-3px;width:20px;height:20px;background-position:-22px -94px}
.news_btn1{float:right;display:block;width:190px;height:56px;background-position:-13px -13px;color:#fff;font-size:1pc;line-height:56px}
.news_btn1:after{clear:both;content:""}
.news_content{margin-top:50px;margin-bottom:60px}
.news_content_head{border-bottom:1px solid #ddd}
.news_content_head a{display:inline-block;margin-right:8px;height:30px;border-bottom:2px solid #fff;font-size:1pc}
.news_current{color:#ff536a!important;border-bottom-color:#ff536a!important}
.news_content_head a:hover{color:#ff536a;font-weight:600;border-bottom-color:#ff536a}
.news_line{margin-right:10px;border-right:1px solid #333}
.news_content1{overflow:hidden;margin-top:10px;padding:15px;border-bottom:1px dotted #ddd}
.news_left,.news_right{float:left;overflow:hidden}
.news_left{text-align:center;}
.news_right{margin-left:20px;width:840px;}
.news_right h1{font-size:14px;padding-top:4px;}
.news_right p{margin:6px 0;height:72px;color:#888;overflow:hidden;line-height:24px;display:-webkit-box;-webkit-box-orient:vertical;
-webkit-line-clamp:3;}
.browse{float:right;color:#ff536a}
.news_btn2{margin-bottom:-3px;width:1pc;height:1pc;background-position:-53px -98px}
.activity_icon01{background-position:-18px -9px}
.activity_icon02{background-position:-18px -37px}
.activity_btn_item{display:inline-block;margin-right:5px;width:30px;height:30px;border:1px solid #d4d4d4;background-color:#fff;text-align:center;font-size:1pc;line-height:30px}
.activity_btn_icon01{background-position:-9pt -61px}
.activity_btn_icon01,.activity_btn_icon02{color:transparent}
.activity_btn_icon02{background-position:-9px -85px}
.activity_btn_current{background-color:#ff536a;color:#fff}
.activity_btn{margin:30px 0 50px;text-align:center}
.gift_current{
	background-image:url(images/pop-up.png);background-repeat:no-repeat;
    background-position: -9px -1px;
}
.pop-up{
	width:13px;
	height:13px;;
	background-image:url(<?php echo img("PPM50625481WQ");?>)};
}
.gift_box{
	width:100%;
	height:100%;
	position:relative;
	z-index:1;
}
.gift_zzc,.gift{
	position:fixed;
	margin:auto;
	top:0;
	right:0;
	bottom:0;
	left:0;
	z-index:100;
}
.gift_zzc{
	background-color:#000;
	opacity:.5; 
	filter:alpha(opacity=50);
}
.gift{
	width:495px;
	height:500px;
	background-color:#fff;
}
.gift_header{
	background-color:#fd8eb9;
	line-height:30px;
	color:#fff;
	overflow:hidden;
}
.gift_header span{
	float:left;
	margin-left:8px;
	font-size:14px;
}
.gift_header i{
	float:right;
	margin-right:8px;
	background-position:-9px -15px;
	margin-top:7px;
}
.send_letter_content{
	margin:30px 30px 15px 30px;
	width:435px;
	height:345px;
	border:1px solid #ddd;
	padding:10px;
}
.pop-up_btn{
	display:inline-block;
	background-color:#f9a61c;
	width:110px;
	line-height:34px;
	color:#fff;
	font-size:14px;
	float:right;
	border-radius:3px;
	text-align:center;
	margin:15px 30px 0 0;
}
.switch_tab{min-height: 498px;}
.messageCongent{margin:0 30px;}
.messageTitle{width: 435px; height:30px;line-height:30px;border: 1px solid rgb(169, 169, 169);margin: 8px 0;padding:0 5px;}
</style>
<!--banner-->
<div class="banner">
    <div id="banner-scontainer" class="banner-scontainer">
        <div class="banner-listitem">
            <ul class="list-item">
                <li style="background:url(<?php echo img("fIX49944449NG");?>) no-repeat scroll center/cover"></li>
                <li style="background:url(<?php echo img("fIX49944449NG");?>) no-repeat scroll center/cover"></li>
                <li style="background:url(<?php echo img("fIX49944449NG");?>) no-repeat scroll center/cover"></li>
            </ul>
        </div>
        <div class="banner-sortitem">
            <ul class="sort-item"></ul>
        </div>
    </div>
</div>
<!--内容-->
<div class="panzhou_news">
    <div class="news_place"><i class="news_place_icon" id="news_btn"></i><span>您所在的位置：</span><a href='<?php echo root."index.php";?>'>首页</a><span>>></span><a href='<?php echo root."Message.php";?>'>盘州信息</a></div>
    <a href="javascript:;" id="news_btn" class="news_btn1">+发布信息</a>
    <div class="news_content">
        <div id="tabBtn" class="news_content_head">
            <a href="<?php echo root."Message.php?type=newest";?>" class="<?php echo MenuGet("type","newest","news_current");?>">最新</a>
            <span class="news_line"></span>
            <a href="<?php echo root."Message.php?type=hot";?>" class="<?php echo MenuGet("type","hot","news_current");?>">热门</a>
        </div>
        <div class="switch_tab">
            <?php echo $message;?>
        </div>
        <div id="switch_tab" class="switch_tab" style="display:none;">
            <?php echo $message;?>
        </div>
    </div>
        <div class="activity_btn">
            <?php echo fenye($ThisUrl,7);?>
        </div>
</div>
    <!--发布信息弹出层-->
    <div class="gift_zzc" id="bg-let"></div>
<div class="gift" id="let-q">
    <div class="gift_header">
        <span>发布信息</span>
        <i class="pop-up" id="close-let" style="cursor:pointer;"></i>
    </div>
    <form name="messageForm">
    	<div class="messageCongent" style="padding:0;">
        <input name="messageTitle" class="messageTitle" type="text" placeholder="请输入标题" /> 
        <textarea name="message" style="width: 435px;height: 345px; padding:10px 5px;" placeholder="请输入发布内容"></textarea>
        </div>
        <a href="javascript:;" class="pop-up_btn" id="send-let" onClick="Sub('messageForm','<?php echo root."user/usData.php";?>')">点击发布</a>
    </form>
</div>
<script>
$(function() {
var LG ={
	show:function(){
		$('#bg-let').show();
		$('#let-q').fadeIn(300);
	},
	hide:function(){
		$('#bg-let').hide();
		$('#let-q').hide();
	},
	sent_gift:function(){
		$('.news_btn1').click(function() {
			LG.show();	
		})
		$('#close-let').click(function(){
			LG.hide();
		});
	}
}
LG.hide();
LG.sent_gift();
})
</script>
<?php echo warn().footer();?>