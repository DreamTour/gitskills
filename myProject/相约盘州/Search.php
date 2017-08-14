<?php
require_once("library/PcFunction.php");
$ThisUrl = root."Search.php";
$sql = " select * from kehu ".$_SESSION['userSearch']['Sql'];
paging($sql," order by UpdateTime desc ",18);
/*************同城搜索列表**********************************************/
$Search = "";
if($num == 0){
	$Search .= "一条搜索都没有";
}else{
	while($array = mysql_fetch_array($query)){
		$age = date("Y") - substr($array['Birthday'],0,4);
		$Region = query("region"," id = '$array[RegionId]' ");
		$Search .= "
		<div class='content01_box'>
            <div class='content01'>
				<a class='photo' href='{$root}SearchMx.php?search_khid={$array['khid']}'>
					<img style='width:120px;height:150px;' src='".HeadImg($array['sex'],$array['ico'])."'>
				</a>
				<h2>{$array['NickName']}</h2>
				<div class='content_text'>
					<span>{$age}岁</span><span>{$Region['province']}</span><span>{$Region['city']}</span>
				</div>
				<a class='say_hi' href='javascript:;' sayHi='{$array['khid']}'>打招呼</a>
				<a class='give_gift' href='javascript:;' data-id='{$array['khid']}'>送礼物</a>
             </div>
         </div>
		";
	}
}
//生成年龄下拉菜单
for($n = 18;$n <= 60;$n++){
		$option[$n] = $n."岁";
	}
$Age1 = select('searchMinAge','s_style2',"年龄",$option);
$Age2 = select('searchMaxAge','s_style2',"年龄",$option);
echo head("pc").pc_header();
?>
<style>
/*搜索内容*/
.content{width:1020px;margin:auto;margin-top:20px;}
.search_box{width:1000px;height:880px;}
.search_top{height:35px;line-height:35px;margin:20px;overflow:hidden;padding-left:160px;}
.search_top *{float:left;}
.search_bg{display:inline-block;width:32px;height:32px;background-position:-18px -146px;margin-top:3px;}
.search_title{font-size:18px;font-weight:bold;color:#000;margin:0 10px 0 5px;}
.search_btn{float:left;display:inline-block;width:86px;height:34px;background-color:#f9a61c;text-align:center;border-radius:3px;color:#fff;font-size:16px;margin-left:10px;}
.s_style2,.s_style3,.s_style4{height:30px;border:1px sold #ddd;margin-right:8px;}
.s_style2{width:70px;}
.s_style3{width:80px;}
.s_style4{}
.search_content{clear:both;width:1020px;padding-top:10px;padding-left:10px;overflow:hidden;}
.content01_box{
	width:152px;
	background:#fff;
	border:1px solid #ccc;
	text-align:center;
	margin-right:15px;
	margin-bottom:20px;
	float: left;
}
.content01{
	padding:10px;
	margin-top: 5px;
    height: 265px;
}
.content01 h2{
	margin-top:8px;
	font-size:14px;
	color:#f55173;
	white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.content_text{
	margin:3px 0 8px 0;
	height: 30px;
	display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
}
.content_text span{margin-right:3px;}
.say_hi,.give_gift{width:56px;height:24px;display:inline-block;background:#fff8f9;border:1px solid #f55173;color:#f55173;vertical-align:top;line-height:22px;}
.give_gift{background:#f55173;color:#fff;}
.page_btn_box{text-align:center;margin: 20px 0 50px;clear: both;}
.page_btn{display:inline-block;width:58px;height:24px;border:1px solid #d4d4d4;text-align:center;line-height:24px;color:#000;font-size:14px;margin-right:5px;}
.page_number{width:70px;position:relative;top:-1px;}
</style>
<!--广告-->
<div class="ad">
	<a target="_blank" href="<?php echo imgurl("oGv49861379ud");?>"><img src="<?php echo img("oGv49861379ud");?>"></a>
</div>
<!--搜索内容-->
<div class="content">
    <div class="search_top">
        <i class="search_bg icon"></i>
        <div class="search_condition">
        <form name="searchForm" action="<?php echo root."library/PcPost.php";?>" method="post">
            <h1 class="search_title">同城搜索:</h1>
            <select name="searchSex" class="s_style4">
            	<option value="">请选择</option>
                <option value="男">男</option>
                <option value="女">女</option>
            </select>
            <?php echo $Age1;?>
            <span style="margin-right:10px;">至</span>
            <?php echo $Age2;?>
            <select name="province" class="s_style3">
            	<?php echo RepeatSele("region","province","--省份--");?>
            </select>
            <select name="city" class="s_style3">
                 <?php echo RepeatSele("region where province = '{$_SESSION['userSearch']['province']}'","city","--城市--");?>   
            </select>
        </div>
        <a class="search_btn" href="javascript:;" onClick="document.searchForm.submit();">搜索</a>
        </form>
     </div>
    <div class="search_box">
        <div class="search_content">
            <?php echo $Search;?>
        </div>
    </div>
    <?php echo send_gift();?>
    <script>
	$(function(){
		$("[data-id]").click(function(){
			G.show();
		});
	});
	</script>
    <div class="page_btn_box">
        <?php echo fenye($ThisUrl,7);?>
    </div>
</div>
<?php echo warn().footer();?>
<script>
$(function() {
//点击打招呼发送默认消息
$("[sayHi]").click(function() {
	$.post("<?php echo root."user/usData.php";?>",{sayHiMessageId:$(this).attr("sayHi")},function(data) {
		warn(data.warn);
	},"json");
});
 //根据省份获取下属城市下拉菜单
$(document).on('change','[name="searchForm"] [name=province]',function(){
	$.post('<?php echo root."library/OpenData.php";?>',{ProvincePostCity:$(this).val()},function(data){
		$('[name="searchForm"] [name=city]').html(data.city);
	},"json");
});
<?php echo 
	KongSele("searchForm.searchSex",$_SESSION['userSearch']['sex']).
	KongSele("searchForm.searchMinAge",$_SESSION['userSearch']['minAge']).	
	KongSele("searchForm.searchMaxAge",$_SESSION['userSearch']['maxAge']).	
	KongSele("searchForm.province",$_SESSION['userSearch']['province']).	
	KongSele("searchForm.city",$_SESSION['userSearch']['city'])	
;?>
});
</script>