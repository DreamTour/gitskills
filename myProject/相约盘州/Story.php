<?php
require_once("library/PcFunction.php");
$ThisUrl = root."Story.php";
$sql = " select * from content where type = '成功故事' and classify = '成功故事' ";
paging($sql," order by UpdateTime desc ",5);
/*************故事列表**********************************************/
$Story = "";
if($num == 0){
	$Story .= "一个故事都没有";
}else{
	while($array = mysql_fetch_array($query)){
		$dateTime = date("Y-m-d",strtotime($array['UpdateTime']));
		$Story .= "
		<div class='stories_content01'>
		  <h1>{$array['title']}</h1>
		  <span class='stories_date'>更新日期：{$dateTime}</span>
		  <div class='stories_content'>
			<img src='".ListImg($array['ico'])."'>
			<div class='stories_introduce'>
			  <div class='details_box details_box01'>
				<h5 class='details_title'>幸福女生：</h5>
				<span class='details_content'>{$array['girl']}</span>
				<h5 class='details_title'>幸福男生：</h5>
				<span class='details_content'>{$array['boy']}</span>
			  </div>
			  <p>{$array['summary']}</p>
			  <a class='details_btn' href='{$root}StoryMx.php?id={$array['id']}'>查看详情</a>
			</div>
		  </div>
		</div> 
		";
	}
}
/*************图片列表**********************************************/
$Sql = mysql_query(" select * from img where type = '成功故事' order by list desc limit 7 ");
$img = "";
while($array = mysql_fetch_array($Sql)){
	$img .= "<a target='_blank' href='{$array['url']}'><img src='{$array['imgsrc']}'></a>";
}
echo head("pc").pc_header();
?>
<!--广告-->
<div class="ad">
<a target="_blank" href="<?php echo imgurl("oGv49861379ud");?>"><img src="<?php echo img("oGv49861379ud");?>"></a>
</div>
<!--成功故事-->
<div class="success_stories_show">
   <h2>成功故事</h2>
   <?php echo $img;?>
</div>
<!--成功案例-->
<div class="success_stories">
    <div class="stories_container">
        <div class="stories_content"><?php echo $Story;?></div>
        <div class="activity_btn"><?php echo fenye($ThisUrl,7);?></div>
    </div>
</div>
<?php echo footer();?>

