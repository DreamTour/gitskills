<?php
require_once "../library/PcFunction.php";
UserRoot("pc");
$ThisUrl = root."user/usLetter.php";
$sql = " select * from message where TargetId = '$kehu[khid]' ";
paging($sql," order by time desc ",5);
/*************信件列表**********************************************/
$letter = "";
if($num == 0){
	$letter .= "一个信件都没有";
}else{
	while($array = mysql_fetch_array($query)){
		$client = query("kehu","khid = '$array[khid]'");
		$dataTime = date("Y-m-d",strtotime($client['UpdateTime']));
		$Region = query("region"," id = '$client[RegionId]' ");
		$age = date("Y") - substr($client['Birthday'],0,4);
		$letter .= "
		<div class='letter_body_content'>
			<a href='vip.html' class='letter_img'><img style='width:100px;' src='".HeadImg($client['sex'],$client['ico'])."'></a>
			<div class='letter_content_text'>
				<h1 style='margin: 0 5px;' class='letter_text_title'><a href='vip.html'>{$client['NickName']}</a></h1>
				<p style='margin: 0 5px;font-size:14px;line-height:28px;'>{$age}岁<br/>{$client['marry']}<br/>来自{$Region['city']}<br/>{$dataTime}</p>
			</div>
			<div class='letter_rt'>
				<a href='javascript:;' class='read_btn' data-id='{$array['id']}'>阅读信件</a>
			</div>
         </div>
		";
	}
}
echo head("pc").pc_header();
?>
<style>
.personal_service_icon{width:20px;height:20px;background-image:url(<?php echo img("htj50521405nK");?>);vertical-align:top;margin-right:2px}
.ad{width:1000px;height:90px;clear:both;margin:20px auto 15px}
.activity_btn_item{display:inline-block;width:30px;height:30px;border:1px solid #d4d4d4;text-align:center;font-size:16px;line-height:30px;background-color:#fff;margin-right:5px}
.activity_btn_icon01{background-position:-12px -61px}
.activity_btn_icon01,.activity_btn_icon02{color:transparent}
.activity_btn_icon02{background-position:-9px -85px}
.activity_btn_current{background-color:#ff536a;color:#fff}
.activity_btn{text-align:center;margin:30px 0 50px;clear:both}
.personal_letter{width:1000px;margin:20px auto 20px;overflow:hidden}
.personal_box{width:160px;float:left}
.personal{height:320px;border:1px solid #d4d4d4}
.personal img{margin:20px 0 15px 30px}
.edit_profile_btn,.upload_pictures_btn{display:inline-block;width:65px;line-height:22px;text-align:center;border:1px solid #ff536a;border-radius:12px;color:#ff536a}
.upload_pictures_btn{margin-left:10px;margin-right:4px}
.personal_message{text-align:center;margin:20px 0 20px}
.personal_title{font-size:16px;color:#000;margin-right:5px;display:inline-block}
.personal_icon{width:16px;height:16px;background-image:url(<?php echo img("Tam50521719LT");?>);background-position:0 0;margin-bottom:-2px}
.id_number span{font-size:14px;color:#ff536a}
#yellow{color:#f9a61c}
.personal_message_head{overflow:hidden;margin-bottom:5px}
.function_tab_box{text-align:center}
.function_tab{display:inline-block;width:50px;height:36px}
.function_tab_special{border-left:1px solid #ddd;border-right:1px solid #ddd}
.function_tab_message,.function_tab_text{color:#ff536a;font-size:14px}
.function_tab_message{color:#ff536a}
.function_tab_text{color:#000}
.publish_btn{width:100%;display:inline-block;line-height:44px;font-size:20px;text-align:center;background-color:#ff536a;color:#fff;margin-top:25px}
.personal_service{margin-top:20px;padding-left:10px;border:1px solid #ddd}
.personal_service h2,.personal_use h2{color:#333;font-size:18px;margin:15px 0}
.personal_member{margin-bottom:10px}
.personal_member a,.personal_member p{font-size:13px;line-height:22px;}
.personal_member span{color:#000;font-weight:700;font-size:16px;margin-right:5px}
.personal_member a{display:inline-block;width:40px;height:20px;line-height:20px;text-align:center;background-color:#ff536a;color:#fff}
.personal_service_icon01{background-position:-14px -26px}
.personal_service_icon02{background-position:-14px -50px}
.personal_service_icon03{background-position:-14px -74px}
.personal_service_icon04{background-position:-14px -99px}
.letter_box{float:left;margin-left:30px;margin-top:-15px;}
.letter_head{width:800px;height:50px;line-height:50px;border-bottom:1px solid #d4d4d4}
.letter_head a{color:#000;font-size:16px;margin-right:40px;display:inline-block;height:49px;border-bottom:3px solid #6094d2}
.letter_body{width:800px;margin:10px 0 30px}
.letter_body_content{padding:15px 0;border-bottom:1px solid #d4d4d4;overflow:hidden}
.letter_body_content a{margin-right:10px}
.letter_content_text,.letter_img{float:left}
.letter_text_title a{font-size:15px;color:#6094d2;margin-bottom:5px}
.letter_content_text{float:left}
.letter_rt{float:right;overflow:hidden;margin-top:25px}
.letter_rt{float:right}
.letter_rt s{width:1px;height:10px;border-right:1px solid #ddd;margin:0 3px}
.letter_icon{width:22px;height:22px;background-image:url(images/personal_icon2.png)}
.letter_icon1{background-position:-7px -40px;margin-right:15px}
.letter_icon2{background-position:-7px -68px}
.read_btn{display:inline-block;background-color:#1ba0c6;width:80px;color:#fff;line-height:34px;text-align:center}
.hide{display:none;}
</style>
  <!--广告-->
    <div class="ad">
    <a href="javascript:;"><img src="<?php echo img("oGv49861379ud");?>"></a>
    </div>
    <!--内容-->
    <div class="personal_letter">
   			<!--左边-->
    	<div class="personal_box">
        	<?php echo center().serve();?>
        </div>
        <!--收件箱-->
        <div class="letter_box">
        	<div class="letter_head">
            	<a href="javascript:;">收件箱</a>
            </div>
            <div class="letter_body">
            	<?php echo $letter;?>
            </div>
    </div>
    <?php echo letter("receive").my_gift();?>
    <script>
	$(function(){
$('#show-my-gift').click(function(){
	MG.show();
});
		//点击阅读信件
		$("[data-id]").click(function(){
			LG.show();
			//传到那里去，传了些什么东西，回调函数
			$.post("<?php echo root."user/usData.php";?>",{sendLetterId:$(this).attr('data-id')},function(data) {
				if(data.warn == 2){
					//收到的信件
					$("[receiveId]").html(data.receive);
					//回复的信件的内容
					$("[name=messageReplyForm] [name=messageReplyText]").html(data.text);
					//当前信件的ID
					$("[name=messageReplyForm] [name=messageId]").val(data.id);
				}else{
				    warn(data.warn);
				}
			},"json");
		});
	});
	</script>
    <!--翻页按钮-->
    <div class="activity_btn">
        <?php echo fenye($ThisUrl,7);?>
    </div>
    </div>
<?php echo warn().footer();?>