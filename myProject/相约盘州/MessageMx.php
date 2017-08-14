<?php
require_once "library/PcFunction.php";
$message = mysql_fetch_array(mysql_query("select * from talk where id = '$_GET[talkId]'"));
//浏览量
$Browse = $message['num'] + 1;
mysql_query(" update talk set num = '$Browse' where id = '$message[id]' ");
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
.news_details_content{margin-bottom:60px;text-align:center}
.news_details_content h1{margin-bottom:8px;font-weight:400;font-size:24px}
.details_content_header{padding:20px;border-bottom:1px dotted #ddd}
.news_extro{color:#888}
.details_content_body{margin-top:15px;text-align:left;min-height:500px;}
.details_content_body p{text-indent:2em;line-height:30px;font-size:15px;}
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
        	<div class="news_place"><i class="news_place_icon" id="news_btn"></i><span>您所在的位置：</span><a href='http://www.yumukeji.com/project/xiangyuepanzhou/index.php'>首页</a><span>>></span><a href='http://www.yumukeji.com/project/xiangyuepanzhou/Message.php'>盘州信息</a></div>
            <div class="news_details_content">
            	<div class="details_content_header">
                    <h1><?php echo $message['title'];?></h1>
                    <p class="news_extro"><span>2016-10-21</span><span>浏览:<?php echo $message['num'];?>次</span></p>
                </div>
                <div class="details_content_body">
                    <p><?php echo $message['text'];?></p>
                </div>
            </div>
        </div>
<?php echo footer();?>