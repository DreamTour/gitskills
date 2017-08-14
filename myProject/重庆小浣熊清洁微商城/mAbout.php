<?php
include "../library/mFunction.php";
echo head("m");
?>
<!--头部-->
<div class="header header-fixed">
    <div class="nesting"> <a href="<?php echo $root;?>m/mUser/mUser.php" class="header-btn header-return"><span class="return-ico">&#xe600;</span></a>
        <div class="align-content">
            <p class="align-text">关于我们</p>
        </div>
        <a href="#" class="header-btn"></a>
    </div>
</div>
<!--//-->
<div class="container contain-about">
    <div class="about-us mui-ptop45">
        <!--<p><img src="img/about-us.png"/></p>-->
        <dl class="about-us-info">
            <dd><span>网站logo：</span><label><img src="<?php echo img("yu3548d");?>"/></label></dd>
            <dd><span>网站名称 ：</span><label><?php echo website("uisuwd");?></label></dd>
            <dd><span>店铺电话 ：</span><label><?php echo website("w5we63sd");?></label></dd>
            <dd><span>店铺地址 ：</span><label><?php echo website("s87dsw");?></label></dd>
        </dl>
        <div class="attention">
            <span>扫一扫下面二维码，关注公众号</span>
            <p><img src="<?php echo img("ftU69203477Ka");?>"/></p>
        </div>
    </div>
</div>
</body>
</html>