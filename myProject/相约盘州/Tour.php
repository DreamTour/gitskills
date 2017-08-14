<?php
require_once("library/PcFunction.php");
$ThisUrl = root."Tour.php";
if(isset($_GET['type'])) {
	if($_GET['type'] == "tourism") {
		$ThisUrl .= "?type=tourism";
		$number = 1;	
	} elseif($_GET['type'] == "other") {
		$ThisUrl .= "?type=other";
		$number = 2;	
	} else {
		$ThisUrl .= "?type=tourism";
		$number = 1;	
	}	
} else {
	header("location:{$ThisUrl}?type=tourism");
	exit(0);	
}
if( $number == 1) {
	$classify = "旅游";
} elseif( $number == 2) {
	$classify = "其他";
}
$sql = " select * from content where type = '本地通' and classify = '$classify' and xian = '显示' ";	
paging($sql,"order by time desc", 8);
/******************旅游或者其他的列表***********************/
$message = "";
if($num == 0) {
	$message .= "一条旅游或其他的信息都没有";	
} else {
	while($array = mysql_fetch_array($query)) {
		$message .= "
					<li class='news_content_item of'>
                    	<div class='local_img fl of'><a href='{$root}TourMx.php?tourId={$array['id']}'><img src='".ListImg($array['ico'])."'></a></div>
                        <div class='local_text fl of'>
                        	<h5><a href='{$root}TourMx.php?tourId={$array['id']}' class='fz16'>{$array['title']}</a></h5>
                            <p><span>推荐理由：</span>{$array['Recommend']}</p>
                            <p><span>出发日期：</span>{$array['DepartDay']}</p>
                        </div>
                        <div class='local_price fr'><a href='http://www.yumukeji.com/project/xiangyuepanzhou/TourMx.php'><span>￥{$array['money']}</span>起</a></div>
                    </li>	
					";	
	}	
}
echo head("pc").pc_header();
?>
<style>
#news_btn{text-align:center;background-image:url(images/panzhou_news_icon.png)}
.local_ad{width:1000px;height:90px;overflow:hidden;margin:30px auto}
.panzhou_news{width:1000px;margin:20px auto;overflow:hidden}
.news_place a,.news_place span{font-size:14px}
.news_place a{color:#ff536a}
.news_place_icon{width:20px;height:20px;background-position:-22px -94px;margin-bottom:-3px}
.news_btn1{display:block;float:right;width:190px;height:56px;line-height:56px;background-position:-13px -13px;color:#fff;font-size:16px}
.news_btn1:after{content:"";clear:both}
.news_content{margin-bottom:60px}
.news_content ul{min-height: 500px;}
.news_content_head{border-bottom:1px solid #ddd}
.news_content_head a{display:inline-block;height:30px;font-size:16px;margin-right:8px;border-bottom:2px solid #fff}
.news_current{border-bottom-color:#ff536a!important;color:#ff536a!important}
.news_content_head a:hover{font-weight:600;color:#ff536a;border-bottom-color:#ff536a}
.news_line{border-right:1px solid #333;margin-right:10px}
.news_content_item{padding:15px 0;border-bottom:1px dashed #ddd}
.local_img{width:140px;height:120px}
.local_text{margin-left:10px;width:720px}
.local_text h5{margin:10px 0 15px 0}
.local_text p{margin-bottom:10px}
.local_price{padding-top:45px}
.local_price span{color:#f9a61c;font-size:20px;margin-right:2px}
.page_btn_box{text-align:center;margin:20px 0 50px;clear:both}
.page_btn{display:inline-block;width:58px;height:24px;border:1px solid #d4d4d4;text-align:center;line-height:24px;color:#000;font-size:14px;margin-right:5px}
.page_number{width:70px;position:relative;top:-1px}
</style>
<script>
	var btn = document.getElementById('tabBtn').getElementsByTagName('a');
	
	var switchTab = document.getElementsByClassName('switch_tab');
	
	for(var i =0;i<btn.length;i++){
		btn[i].dataId = i;
		btn[i].onclick = function(){
			for(var i =0;i<btn.length;i++){
				switchTab[i].style.display = 'none';
				btn[i].className = '';
			}
			this.className = 'news_current'
			switchTab[this.dataId].style.display = 'block';
		}
	}
</script>
 <!--广告-->
        <div class="local_ad"><a target="_blank" href="<?php echo imgurl("oGv49861379ud");?>"><img src="<?php echo img("oGv49861379ud");?>"></a></div>
        <!--内容-->
        <div class="panzhou_news">
            <div class="news_content">
            	<div id="tabBtn" class="news_content_head">
                    <a href="<?php echo root."Tour.php?type=tourism";?>" class="<?php echo MenuGet("type","tourism","news_current");?>">旅游</a>
                    <span class="news_line"></span>
                    <a href="<?php echo root."Tour.php?type=other";?>" class="<?php echo MenuGet("type","other","news_current");?>">其他</a>
                </div>
                <ul class="switch_tab">
                    <?php echo $message;?>
                </ul>
                <ul id="switch_tab" class="switch_tab" style="display:none;">
					<?php echo $message;?>
                </ul>
            </div>
            <div class="page_btn_box">
            	<?php echo fenye($ThisUrl,7);?>
            </div>
    </div>
        </div>
<?php echo warn().footer();?>