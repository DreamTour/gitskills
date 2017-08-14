<?php
include "mLibrary/mFunction.php";
echo head("m");
UserRoot("m");
limit($kehu);
$sql = mysql_query("select * from content where type = '活动展示' and xian = '显示' ");
$num = mysql_num_rows(mysql_query("select * from content where type = '活动展示' and xian = '显示' "));
$mActivity = "";
if($num == 0){
	$mActivity = "一个活动都没有";	
}else{
	while($array = mysql_fetch_assoc($sql)){
		$mActivity .="
		<li class='activity-item of'>
			<img src='{$root}{$array['ico']}' class='fl'>
			<ul class='activity-text fr'>
				<li class='activity-title'><a href='javascript:;'><h3 class='col'>{$array['title']}</h3></a></li>
				<li class='activity-body'><i class='activity-icon activity-icon1'></i><span>{$array['DepartDay']}</span>
				<a href='{$root}m/mActivityMx.php?mActivity_id={$array['id']}' style='display:inline-block' class='story-btn col1 bg1 fw2 fz14 tc'>查看详情</span></a>
				<li class='activity-body'><i class='activity-icon activity-icon2'></i><span>{$array['address']}</span></li>
			</ul>
        </li>
	";	
	}
}
?>
<!--头部-->
<div class="header fz16">
    <div class="head-center">	<div class="head-left"><a href="<?php echo $root;?>m/user/mUser.php" class="col1"><返回</a></div>
<h3></h3></div>
</div>
<!--活动列表-->
<div class="activity-content">
<!--	<a href="<?php echo "{$root}m/user/mUsExtend.php";?>">
    	<img src="<?php echo img("KKR54253637kM");?>">
    </a>
-->    <ul class="activity-list">
    	<?php echo $mActivity;?>
    </ul>
</div>
<!--底部-->
<?php echo warn();?>

