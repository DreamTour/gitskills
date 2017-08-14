<?php
require_once("library/PcFunction.php");
$ThisUrl = root."Talk.php";
$sql = " select * from talk where type = '新感悟' and Auditing = '已通过' ";
paging($sql," order by time desc ",5);
/*************缘分圈动态列表**********************************************/
$Talk = "";
if($num == 0){
	$Talk .= "一个缘分圈动态都没有";
}else{
	while($array = mysql_fetch_array($query)){
		$client = mysql_fetch_array(mysql_query("select * from kehu where khid = '$array[khid]'"));
		$clickNum = mysql_num_rows(mysql_query("select * from TalkLaud where talkId = '$array[id]' "));
		/*缘分圈回复列表*/
		$talkReplySql = mysql_query("select * from TalkReply where TalkId = '$array[id]' order by time desc ");
		$talkReply = "";
		while($talkReplyArray = mysql_fetch_array($talkReplySql)){
			$kehuReply = query("kehu","khid = '$talkReplyArray[khid]'");
			$talkReply .= "
			<div class='replyText'>
				<h1 class='replyText_title'><a href='{$root}SearchMx.php?search_khid={$kehuReply['khid']}'>{$kehuReply['NickName']}</a></h1>
				<p>{$talkReplyArray['text']}</p>
			</div>
			";	
		}
		if($clickNum > 0){
			$color = " style=' background-position: -7px -8px;' ";
		}else{
			$color = "";
		}
		$Talk .= "
		<div class='letter_body_content'>
			<a href='{$root}SearchMx.php?search_khid={$array['khid']}'><img style='width:100px;' src='".HeadImg($client['sex'],$client['ico'])."'></a>
			<div class='letter_content_text'>
				<h1 class='letter_text_title'><a href='{$root}SearchMx.php?search_khid={$array['khid']}'>{$client['NickName']}</a></h1>
				<p>{$array['text']}</p>
				<a class='talkClick' talkClick='{$array['id']}' href='javascript:;'>
					<i class='letter_icon letter_icon1' {$color}></i>
					<span clickNum='{$array['id']}'>{$clickNum}<span>
				</a>
				<a class='talkReply' href='javascript:;' clickReply='{$array['id']}'><i class='letter_icon letter_icon2'></i></a>
			</div>
			{$talkReply}
         </div>
		";
	}
}
 echo head("pc").pc_header();
?>
<style>
.replyText{width:810px;padding-left:110px;font-size:14px;padding-top:10px;}
.replyText_title a{color: #F36;}
.ad{clear:both;margin:20px auto 15px;width:1000px;height:90px}
.activity_btn_item{display:inline-block;margin-right:5px;width:30px;height:30px;border:1px solid #d4d4d4;background-color:#fff;text-align:center;font-size:16px;line-height:30px}
.activity_btn_icon01{background-position:-12px -61px}
.activity_btn_icon01,.activity_btn_icon02{color:transparent}
.activity_btn_icon02{background-position:-9px -85px}
.activity_btn_current{background-color:#ff536a;color:#fff}
.activity_btn{clear:both;margin:30px 0 50px;text-align:center}
.personal_letter{overflow:hidden;margin:20px auto 20px;width:1000px}
.personal_box{float:left;width:160px}
.personal{height:320px;border:1px solid #d4d4d4}
.personal img{margin:20px 0 15px 30px}
.edit_profile_btn,.upload_pictures_btn{display:inline-block;width:65px;border:1px solid #ff536a;border-radius:12px;color:#ff536a;text-align:center;line-height:22px}
.upload_pictures_btn{margin-right:4px;margin-left:10px}
.personal_message{margin:20px 0 20px;text-align:center}
.personal_title{display:inline-block;margin-right:5px;color:#000;font-size:16px}
.id_number span{color:#ff536a;font-size:14px}
#yellow{color:#f9a61c;}
.personal_message_head{overflow:hidden;margin-bottom:5px}
.function_tab_box{text-align:center}
.function_tab{display:inline-block;width:50px;height:36px}
.function_tab_special{border-right:1px solid #ddd;border-left:1px solid #ddd}
.function_tab_message,.function_tab_text{color:#ff536a;font-size:14px}
.function_tab_message{color:#ff536a}
.function_tab_text{color:#000}
.publish_btn{display:inline-block;margin-top:25px;width:100%;background-color:#ff536a;color:#fff;text-align:center;font-size:20px;line-height:44px}
.letter_box{float:left;margin-top:-15px;margin-bottom:20px;margin-left:30px;width:810px;}
.letter_head{margin-bottom:20px;width:800px;height:50px;border-bottom:1px solid #d4d4d4;line-height:50px}
.letter_head a{display:inline-block;margin-right:40px;height:49px;border-bottom:3px solid #6094d2;color:#000;font-size:16px}
.letter_body_content{margin-bottom:20px;border-bottom:1px solid #d4d4d4;padding-bottom:15px;overflow:hidden;}
.letter_body_content a{margin-right:10px}
.letter_body_content a,.letter_content_text{float:left}
.letter_content_text {width:700px;padding-bottom: 10px;}
.letter_text_title a{margin-bottom:5px;color:#6094d2;font-size:16px}
.letter_content_text p{margin-bottom:10px;height:100px;color:#000;font-size:14px}
.letter_icon{width:22px;height:22px;background-image:url(<?php echo img("CxT50023344PL");?>)}
.letter_icon1{margin-right:5px;vertical-align: middle;background-position:-7px -40px}
.letter_icon2{background-position:-7px -68px}
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
.hide{display:none;}
</style>
    <!--广告-->
    <div class="ad">
		<a target="_blank" href="<?php echo imgurl("oGv49861379ud");?>"><img src="<?php echo img("oGv49861379ud");?>"></a>
    </div>
    <!--内容-->
    <div class="personal_letter">
   		<!--左边个人资料-->
    	<div class="personal_box">
        	<?php echo center();?>
            <script>
            $(function(){
				$("#show-my-gift").click(function(){
					$.post("<?php echo $root."user/usData.php";?>",{action:'check_login'},function(data){
						if(data.warn == 2){
							MG.show();
						}else{
							warn(data.warn);
						}
					},"json");
				})
			});
            </script>
            <a class="publish_btn" href="javascript:;">发布新感悟</a>
        </div>
        <!--右边手札-->
        <div class="letter_box">
        	<div class="letter_head">
            	<a href="javascript:;">缘分圈动态</a>
            </div>
            <div class="letter_body">
            	<?php echo $Talk;?>
            </div>
    </div>
    <!--翻页按钮-->
    <div class="activity_btn">
        <?php echo fenye($ThisUrl,7);?>
    </div>
    </div>
<!--发布新感悟弹出层-->
<div class="gift_zzc" id="bg-let"></div>
<div class="gift" id="let-q">
    <div class="gift_header">
        <span>发布新感悟</span>
        <i class="pop-up" id="close-let" style="cursor:pointer;"></i>
    </div>
    <form name="feelingForm">
        <div class="send_letter_content" style="padding:0;">
            <textarea name="feeling" style="width: 435px;height: 345px; padding:10px;"></textarea>
        </div>
        <a href="javascript:;" class="pop-up_btn" id="send-let" onClick="Sub('feelingForm','<?php echo root."user/usData.php";?>')">点击发布</a>
    </form>
</div>
<!--回复新感悟弹出层-->
<div class="gift_zzc" id="bg-let1"></div>
<div class="gift" id="let-q1">
    <div class="gift_header">
        <span>回复</span>
        <i class="pop-up" id="close-let1" style="cursor:pointer;"></i>
    </div>
    <form name="replyForm">
        <div class="send_letter_content" style="padding:0;">
            <textarea name="reply" style="width: 435px;height: 345px; padding:10px;"></textarea>
            <input name="talkId" type="hidden" />
        </div>
        <a href="javascript:;" class="pop-up_btn" id="send-let" onClick="Sub('replyForm','<?php echo root."user/usData.php";?>')">点击回复</a>
    </form>
</div>
<?php echo my_gift();?>
<script>
$(function() {
/*$('#show-my-gift').click(function(){
	MG.show();
});
*/var LG ={
	show:function(){
		$('#bg-let').show();
		$('#let-q').fadeIn(300);
	},
	hide:function(){
		$('#bg-let').hide();
		$('#let-q').hide();
	},
	sent_gift:function(){
		$('.publish_btn').click(function() {
			LG.show();	
		})
		$('#close-let').click(function(){
			LG.hide();
		});
	}
}
LG.hide();
LG.sent_gift();
var LG1 ={
	show:function(){
		$('#bg-let1').show();
		$('#let-q1').fadeIn(300);
	},
	hide:function(){
		$('#bg-let1').hide();
		$('#let-q1').hide();
	},
	sent_gift:function(){
		$('[clickReply]').click(function() {
			LG1.show();	
			document.replyForm.talkId.value = $(this).attr('clickReply');
		})
		$('#close-let1').click(function(){
			LG1.hide();
		});
	}
}
LG1.hide();
LG1.sent_gift();
	//新感悟点赞
	$("[talkClick]").click(function(){
		var talkClick = $(this).attr('talkClick');
		$.post("<?php echo root."user/usData.php";?>", { talkClick: talkClick},function(data) {
			if(data.warn == "点赞成功"){
				$("[clickNum="+talkClick+"]").html(data.num);
				$("[talkClick="+talkClick+"]").find('i').css({'background-position': '-7px -8px'});
			}
			warn(data.warn);
		},"json");
	});
})
</script>
<?php echo footer();?>