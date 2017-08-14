<?php
include "../mLibrary/mFunction.php";
echo head("m");
UserRoot("m");
limit($kehu);
$sql = mysql_query("select * from content where type = '牵手成功' and xian = '显示' ");
$sqlNum = mysql_fetch_assoc(mysql_query("select * from content where type = '牵手成功' and xian = '显示' "));
$story = "";
if($sqlNum == 0){
	$story = "一个成功故事都没有";	
}else{
	while($array = mysql_fetch_assoc($sql)){
		$story .= "
		<li class='story-item of'>
            <img src='{$root}{$array['ico']}' class='fl'>
            <ul class='story-text fr'>
                <li class='story-title'><a href='javascript:;'><h3 class='col'>{$array['title']}</h3></a></li>
                <li class='story-bottom'><p>{$array['summary']}</p></li>
                <li><a href='{$root}m/user/mUsStoryMx.php?story_id={$array['id']}' class='story-btn col1 bg1 fw2 fz14 tc'>查看详情</a></li>
            </ul>
        </li>
		";	
	}
}
?>
<!--头部-->
<div class="header fz16">
    <div class="head-center">	<div class="head-left"><a href="<?php echo "{$root}m/user/mUser.php"?>" class="col1"><返回</a></div>
<h3></h3></div>
</div>
<!--成功故事-->
<div class="story-content">
<!--	<a href="<?php echo $root;?>m/user/mUsExtend.php"><img src="<?php echo img("KKR54253637kM");?>"></a>
-->    <ul class="story-list">
    	<?php echo $story;?>
    </ul>
</div>
<!--底部-->
</body>
</html>
