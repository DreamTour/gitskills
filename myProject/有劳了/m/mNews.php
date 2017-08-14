<?php 
include "../library/mFunction.php";
$sql = " select * from content where type = '热点资讯' ";
paging($sql," order by UpdateTime desc ",20);
/*************热点资讯**********************************************/
$news = "";
if($num == 0){
	$news .= "一条热点资讯都没有";
}else{
	while($array = mysql_fetch_array($query)){
		$news .= "
    	<li class='po-co-item'><a href='{$root}m/mNewsMx.php?News_id={$array['id']}' class='clearfix po-text-box'><h2 class='fl' style='padding-left:10px;'>{$array['title']}</h2><span class='fr'>[查看详情]</span></a></li>
		";
	}	
}
echo head("m").mHeader();
?>
<!--内容-->
<section id="position-content1">
	<ul class="po-content">
    	<?php echo $news;?>
    </ul>
	<!--<div class="po-btn-box">
    	
    </div>-->  
</section>
<!--页脚-->
</body>
</html>
