<?php 
include "../../library/mFunction.php";
echo head("m").mHeader();
?>
<div class="way"><a href="javascript:;">首页</a><span>&gt;&gt;</span><a href="javascript:;">发布</a></div>
<!--广告-->
<div class="ad"><a href="javascript:;"><img src="<?php echo img("Vls58315686MZ");?>"></a></div>

<!--内容-->
<div class="login-content">
	<h2>请选择发布类型</h2>
    <div class="login-btn">
        <a href="<?php echo $root;?>m/mSeller/mSeDemand.php" class="qq-btn"><span>发布劳务供给</span></a>
        <a href="<?php echo $root;?>m/mSeller/mSeSupply.php" class="weibo-btn"><span>发布劳务需求</span></a>
    </div>
</div>
<!--底部-->
<?php echo mFooter().warn();?>