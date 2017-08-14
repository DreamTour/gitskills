<?php 
include "../../library/mFunction.php";
UserRoot("m");
//我的收藏
$collectSql = mysql_query("select * from collect where khid = '$kehu[khid]' ");
$collectNum = mysql_num_rows($collectSql);
$myCollection = "";
if($collectSql == 0){
	$myCollection .= "一条收藏信息都没有";
}else{
	while($array = mysql_fetch_assoc($collectSql)) {
		$time = substr($array['time'], 0, 10);
		if ($array['Target'] == "优职") {
			$demand = query("demand", "id = '$array[TargetId]' ");
			$title = $demand['title'];
			$url = root . "m/mRecruit.php?demandMx_id=".$demand['id'];
		} elseif ($array['Target'] == "优才") {
			$supply = query("supply", "id = '$array[TargetId]' ");
			$title = $supply['title'];
			$url = root . "m/mJobMx.php?supplyMx_id=".$supply['id'];
		}
		$myCollection .= "
		<li><a href='{$url}' class='collect-list'><span>{$title}</span><p>{$time}</p></a></li>
		";
	}
}
echo head("m").mHeader();
?>	
<!--内容-->
<ul class="collect-box">
    <?php echo $myCollection;?>
</ul>
<!--底部-->
<?php echo mFooter().warn();?>