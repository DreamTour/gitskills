<?php
include "../../library/mFunction.php";
if($kehu['staff'] == '是'){
	$client = query("kehu", "khid = '$get[clientId]' ");
	if ($client['receiveNumber'] == 0) {
		$state = "该客户已经没有领取次数了，不能确认领取";
	}
	else {
		$num = $client['receiveNumber'] - 1;
		mysql_query("UPDATE kehu SET receiveNumber = '$num' WHERE khid = '$get[clientId]' ");
		$state = "商品确认领取成功";
	}
}else{
	$state = "您不是内部员工，不能确认领取";
}
echo head("m");
?>
<div class="qr-code">
	<div class="code-pic">
		<img src="<?php echo img("yu3548d");?>" alt="图片" />
	</div>
	<div class="code-state"><?php echo $state;?></div>
	<a href="<?php echo "{$root}m/mindex.php";?>"><div class="code-btn">返回</div></a>
</div>
<?php echo mWarn();?>

