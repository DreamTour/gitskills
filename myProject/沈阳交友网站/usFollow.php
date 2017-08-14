<?php
include "../library/PcFunction.php";
UserRoot("pc");
echo head("pc");
limit($kehu);
$sql = "select * from follow where type = '1' and TargetId = '$kehu[khid]' ";
paging($sql,"order by time desc",18);
$follow = "";
if($num == 0){
	$follow = "一个关注过你的人都没有";	
}else{
	while($array = mysql_fetch_assoc($query)){
		$client = mysql_fetch_assoc(mysql_query("select * from kehu where khid = '$array[khid]' "));
		$follow .= "
			<div class='content01_box'>
				<div class='content01'>
					<a class='photo' href='{$root}searchMx.php?search_khid={$array['khid']}'>
						<img style='width:120px;height:150px;' src='".HeadImg($client['sex'],$client['ico'])."'>
					</a>
					<h2>{$client['NickName']}</h2>
					<div class='content_text'>
						<span>已关注你</span>
					</div>
					<a class='look-btn fz14' href='{$root}searchMx.php?search_khid={$array['khid']}'>查看资料</a>
				</div>
			 </div>
		";	
	}
}
?>
<style>
.ad{width:1000px;height:90px;clear:both;margin:20px auto 30px}
.news_place{width:1000px;margin:30px auto}
.news_place a,.news_place span{font-size:14px}
.news_place a{color:#ff7c7c}
.news_place_icon{width:20px;height:20px;background-position:-22px -94px;margin-bottom:-3px;background-image:url(<?php echo img("GRE50462428Fy");?>)}
.content{width:1020px;margin:auto;margin-top:20px}
.content select{font-size:14px}
.look_box{width:1000px}
.look_top{height:35px;line-height:35px;margin:20px;overflow:hidden;padding-left:160px}
.look_top *{float:left}
.look_bg{display:inline-block;width:32px;height:32px;background-position:-18px -146px;margin-top:3px}
.look_title{font-size:18px;font-weight:700;color:#000;margin:0 10px 0 5px}
.look_btn{float:left;display:inline-block;width:86px;height:34px;background-color:#ff7f00;text-align:center;border-radius:3px;color:#fff;font-size:16px;margin-left:10px}
.s_style2,.s_style3,.s_style4{height:30px;border:1px sold #ddd;margin-right:8px}
.s_style2{width:70px}
.s_style3{width:80px}
.s_style4{width:50px}
.look_content{clear:both;width:1020px;padding-top:10px;padding-left:10px;overflow:hidden}
.content01_box{clear:both;width:152px;height:275px;background:#fff;border:1px solid #ccc;text-align:center;margin-right:12px;margin-bottom:14px;display:inline-block}
.content01{padding:10px;margin-top:10px}
.content01 h2{margin-top:10px;font-size:14px;color:#ff7c7c}
.content_text{margin:3px 0 8px 0}
.content_text span{margin-right:3px}
.look-btn{width:80px;height:30px;display:inline-block;background:#ff7c7c;color:#fff;vertical-align:top;line-height:30px;border-radius:3px}
.give_gift{background:#ff7c7c;color:#fff}
.page_btn_box{text-align:center;margin:20px 0 50px;clear:both}
.page_btn{display:inline-block;width:58px;height:24px;border:1px solid #d4d4d4;text-align:center;line-height:24px;color:#000;font-size:14px;margin-right:5px}
.page_number{width:70px;position:relative;top:-1px}
</style>
 <!--头部-->
    <?php echo pcHeader();?>	
    <!--广告-->
    <div class="ad">
        <a href="javascript:;"><img src="<?php echo img("uiJ53377569IG");?>"></a>
    </div>
    <!--搜索内容-->
    <div class="content">
    	<!--位置-->
        <div class="news_place"><i class="news_place_icon" id="news_btn"></i><span>您所在的位置：</span><a href="<?php echo "{$root}user/user.php";?>">个人中心</a><span>>></span><a href="javascript:;">谁关注我</a></div>
       <!--谁关注我-->
        <div class="look_box">
            <div class="look_content">
                <?php echo $follow;?>
            </div>
        </div>
        <div class="page_btn_box">
        	<?php echo fenye($ThisUrl,7);?>			
        </div>
    </div>
<!--底部-->
<?php echo warn().pcFooter();?>
</body>
</html>
