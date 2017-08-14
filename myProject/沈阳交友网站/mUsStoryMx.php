<?php
include "../mLibrary/mFunction.php";
echo head("m");
UserRoot("m");
$storyMx = mysql_fetch_assoc(mysql_query("select * from content where id = '$_GET[story_id]' "));
?>
<!--头部-->
<div class="header fz16">
    <div class="head-center">	<div class="head-left"><a href="<?php echo $root;?>m/user/mUsStory.php" class="col1"><返回</a></div>
</div>
</div>
<!--成功故事详情-->
<div class="story-de-co">
	<div class="story-de bg2">
        <h2 class="tc col"><?php echo $storyMx['title'];?></h2>
        <p class="fz14"><?php echo ArticleMx($storyMx['id']);?></p>
	</div>
</div>
<!--底部-->
</body>
</html>
