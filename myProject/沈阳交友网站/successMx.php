<?php 
include "library/PcFunction.php";
UserRoot("pc");
echo head("pc");
$successMx = mysql_fetch_array(mysql_query("select * from content where id = '$_GET[successMx_id]' "));
?>
<style>
.icon{ background:url(<?php echo img("WxN53377734Xb");?>)}
.stories_details{
	width:1000px;
	margin:30px auto 50px;
	border:1px solid #ff7c7c;
}
.go_back{
	width:100%;
	background-color:#fecad1;
	padding-left:15px;
}
.go_back a{
	color:#000;
	line-height:40px;
	font-size:14px;
}
.stories_header{
	margin:auto;
	width:950px;
	text-align:center;
	border-bottom:1px dashed #000;
	margin-bottom:15px;
}
.stories_header h1{
	line-height:50px;
	font-size:18px;
	color:#ff6600;
}
.stories_details p{
	text-indent:2em;
	color:#000;
	font-size:14px;
	margin-bottom:15px;
}
.stories_details img{    max-width: 958px;
    margin: 5px auto 0;
    display: block;}
.stories_details_content{
	padding:0 20px 30px;
}
</style>
<!--头部-->
	<?php echo pcHeader();?>
        <div class="stories_details">
        	<div class="go_back"><a href="success.php"><<返回</a></div>
            <div class="stories_details_content">
                <div class="stories_header">
                <h1><?php echo $successMx['title']?></h1>
                </div>
                	<?php echo ArticleMx($successMx['id']);?>
                </div>
        </div>
       <!--底部-->
       <?php echo pcFooter();?>
</body>
</html>
