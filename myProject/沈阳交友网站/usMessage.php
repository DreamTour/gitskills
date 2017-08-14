<?php 
include "../library/PcFunction.php";
echo head("pc");
UserRoot("pc");
limit($kehu);
$ThisUrl = root."user/usMessage.php";
$sql = " select * from message where TargetId = '$kehu[khid]' ";
paging($sql," order by time desc ",8);
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
			<a href='{$root}searchMx.php?search_khid={$client['khid']}' class='letter_img'><img style='width:120px;height:150px;' src='".HeadImg($client['sex'],$client['ico'])."'></a>
			<div class='letter_content_text'>
				<h1 style='margin: 0 5px;' class='letter_text_title'><a href='{$root}searchMx.php?search_khid={$client['khid']}'>{$client['NickName']}</a></h1>
				<p style='margin: 0 5px;font-size:14px;line-height:28px;'>{$age}岁<br/>{$client['marry']}<br/>来自{$Region['city']}<br/>{$dataTime}</p>
			</div>
			<div class='letter_rt'>
				<a href='javascript:;' class='read_btn' data-id='{$array['id']}'>阅读</a>
				<a href='{$root}library/usPost.php?delectLetter={$array['id']}' class='read_btn'>删除</a>
			</div>
         </div>
		";
	}
}
?>
<style>
.center_btn_box {
    width: 100%;
    margin: auto;
    text-align: center;
    margin-top: 10px;
    clear: both;
}
.center_btn_user{clear:both;display:inline-block;width:100px;height:30px;text-align:center;line-height:30px;background-color:#ff7c7c;color:#fff;font-size:14px;border:none}
.icon{ background:url(<?php echo img("WxN53377734Xb");?>)}
.personal_service_icon{width:20px;height:20px;background-image:url(<?php echo img("Gwl57090161Zn");?>);vertical-align:top;margin-right:2px}
.ad{width:1000px;height:90px;clear:both;margin:20px auto 15px}
.activity_btn_item{display:inline-block;width:30px;height:30px;border:1px solid #d4d4d4;text-align:center;font-size:16px;line-height:30px;background-color:#fff;margin-right:5px}
.activity_btn_icon01{background-position:-12px -61px}
.activity_btn_icon01,.activity_btn_icon02{color:transparent}
.activity_btn_icon02{background-position:-9px -85px}
.activity_btn_current{background-color:#ff536a;color:#fff}
.activity_btn{text-align:center;margin:30px 0 50px;clear:both}
.personal_letter{width:1000px;margin:20px auto 20px;overflow:hidden}
.personal_box{width:160px;float:left}
.personal{border:1px solid #d4d4d4}
.personal img{margin:20px 20px}
.edit_profile_btn,.upload_pictures_btn{display:inline-block;width:65px;line-height:22px;text-align:center;border:1px solid #ff7c7c;border-radius:12px;color:#ff7c7c}
.upload_pictures_btn{margin-left:10px;margin-right:4px}
.personal_message{text-align:center}
.personal_title{font-size:16px;color:#000;margin-right:5px;display:inline-block}
.personal_icon{width:16px;height:16px;background-image:url(<?php echo img("Tam50521719LT");?>);background-position:0 0;margin-bottom:-2px}
.id_number span{font-size:14px;color:#ff7c7c}
#yellow{color:#f9a61c}
.personal_message_head{overflow:hidden;margin-bottom:5px}
.function_tab_box{text-align:center}
.function_tab{display:inline-block;width:50px;height:36px}
.function_tab_special{border-left:1px solid #ddd;border-right:1px solid #ddd}
.function_tab_message,.function_tab_text{color:#ff7c7c;font-size:14px}
.function_tab_message{color:#ff7c7c}
.function_tab_text{color:#000}
.publish_btn{width:100%;display:inline-block;line-height:44px;font-size:20px;text-align:center;background-color:#ff7c7c;color:#fff;margin-top:25px}
.look_box{background-color:#ff7c7c;line-height:40px;height:40px;margin-top:12px}
.look_box a{display:inline-block;font-size:14px;color:#fff;text-align:center}
.personal_service{height:260px;margin-top:15px;padding-left:10px;border:1px solid #d4d4d4}
.ps-line p{width:3px;height:20px;background-color:#ff7f00;margin-right:5px}
.ps-line{margin:15px 0}
.ps-line h2{color:#333;font-size:18px;margin-top:-2px}
.personal_member{margin-bottom:10px}
.personal_member a{font-size:14px}
.personal_member p{color:#888}
.personal_member span{color:#000;font-size:16px;margin-right:5px}
.personal_member a{display:inline-block;width:40px;height:20px;line-height:20px;text-align:center;background-color:#ff7f00;color:#fff}
.personal_service_icon01{background-position:-14px -26px}
.personal_service_icon02{background-position:-14px -50px}
.personal_service_icon03{background-position:-14px -74px}
.personal_service_icon04{background-position:-14px -99px}
.ad_link{border:1px solid #ddd;margin-top:15px;background:url(<?php echo img("UZk53377931Uh");?>) no-repeat scroll 0 0;text-align:center;padding:36px 15px 15px}
.link_icon{display:block;width:52px;height:52px;background:url(<?php echo img("Gwl57090161Zn");?>) no-repeat scroll 0 -138px;margin:10px 35px}
.ad_link h2{overflow:hidden;line-height:22px;max-height:44px}
.ad_link p{overflow:hidden;line-height:16px;max-height:100px;word-break:break-all;text-align:justify}
.link_btn{display:inline-block;width:110px;line-height:30px;background-color:#ff7f00;border-radius:3px;text-align:center;color:#fff;margin-top:10px}
.letter_box{float:left;margin-left:30px;margin-top:-15px;margin-bottom:20px}
.letter_head{width:800px;height:50px;line-height:50px;border-bottom:1px solid #d4d4d4}
.letter_head a{color:#000;font-size:16px;margin-right:40px;display:inline-block;height:49px;border-bottom:3px solid #6094d2}
.letter_body{width:800px;margin:10px 0 30px}
.letter_body_content{padding:15px 0;border-bottom:1px solid #d4d4d4;overflow:hidden}
.letter_body_content a{margin-right:10px}
.letter_content_text,.letter_img{float:left}
.letter_text_title a{font-size:16px;color:#6094d2;margin-bottom:5px}
.letter_content_text{float:left}
.letter_rt{float:right;overflow:hidden;margin-top:25px}
.letter_rt{float:right}
.letter_rt s{width:1px;height:10px;border-right:1px solid #ddd;margin:0 3px}
.letter_icon{width:22px;height:22px;background-image:url(images/personal_icon2.png)}
.letter_icon1{background-position:-7px -40px;margin-right:15px}
.letter_icon2{background-position:-7px -68px}
.read_btn{display:inline-block;background-color:#1ba0c6;width:80px;color:#fff;line-height:34px;text-align:center}
</style> 	
  <!--头部-->
    <?php echo pcHeader();?>
    <!--广告-->
    <div class="ad">
    <a href="javascript:;"><img src="<?php echo img("uiJ53377569IG");?>"></a>
    </div>
    <!--内容-->
    <div class="personal_letter">
   		<!--左边-->
    	<div class="personal_box">
        	<!--个人资料-->
        	<?php echo data();?>
        <!--收件箱-->
        <div class="letter_box">
        	<div class="letter_head">
            	<a href="javascript:;">收件箱</a>
            </div>
            <div class="letter_body">
            	<?php echo $letter;?>
            </div>
    </div>
    <!--翻页按钮-->
    <div class="activity_btn">
        <?php echo fenye($ThisUrl,7);?>
    </div>
    </div>
<!--底部-->
<?php echo letter("receive").my_gift().warn().choosePay().pcFooter();?>
</body>
<script>
	$(function(){
		//显示收到的礼物
		$('#show-my-gift').click(function(){
			MG.show();
		});
		//点击阅读信件
		$("[data-id]").click(function(){
			LG.show();
			//传到那里去，传了些什么东西，回调函数
			$.post("<?php echo root."library/usData.php";?>",{sendLetterId:$(this).attr('data-id')},function(data) {
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
	})
</script>
</html>
