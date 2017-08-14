<?php
include "../mLibrary/mFunction.php";
echo head("m");
UserRoot("m");
limit($kehu);
$gift = mysql_fetch_assoc(mysql_query("select * from Gift "));
$giftGiveNum = mysql_num_rows(mysql_query("select * from GiftGive where TargetId = '$kehu[khid]' "));
$giftGive = mysql_query("select * from GiftGive where TargetId = '$kehu[khid]' ");
$getGift = "";
if($giftGiveNum == 0) {
	$getGift .= "你一件礼物都没有收到"; 
}else{
	while($array = mysql_fetch_array($giftGive)){
		$client = mysql_fetch_array(mysql_query("select * from kehu where khid = '$array[khid]' "));
		$getGift .= "
		<li><img src='{$root}{$gift['ico']}'><p class='gift-give'><a href='{$root}m/userDatum.php?search_khid={$array['khid']}' class='col2'>{$client['NickName']}</a>赠送</p></li>
		";
	} 
}
?>
<!--头部-->
<div class="header fz16">
	<div class="head-left"><a href="<?php echo $root;?>m/user/mUser.php" class="col1"><返回</a></div>
    <div class="head-center"><h3>我的礼物</h3></div>
</div>
<!--我的-->
<div class="photo-content">
	<?php echo my_top();?>
    <div class="photo-top-nav bg2">
    	<p class="fz16"><a href="<?php echo $root;?>m/user/mUsAlbum.php"><i class="my-icon-top my-icon1"></i><span>我的相册</span></a></p>
        <p class="fz16"><a href="javascript:;"><i class="my-icon-top my-icon2"></i><span>我的礼物</span></a></p>
    </div>
    <ul class="photo-co bg2">
        <?php echo $getGift;?>
    </ul>
</div>
</body>
</html>
