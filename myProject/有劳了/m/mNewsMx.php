<?php 
include "../library/mFunction.php";
$NewsMx = mysql_fetch_array(mysql_query("select * from content where id = '$_GET[News_id]' "));
echo head("m").mHeader();
?>
<div class="way">
    <a href="<?php echo $root;?>m/mindex.php">首页</a>
    <span>&gt;&gt;</span><a href="<?php echo $root;?>m/mNews.php">资讯</a>
    <span>&gt;&gt;</span><a href="javascript:;">详情</a>
</div>
<!--内容-->
<section id="info-de-co">
	<h2><?php echo $NewsMx['title']?></h2>
    <div class="article">
    	<p><?php echo ArticleMx($NewsMx['id']);?></p>
    </div>
</section>
</body>
</html>
