<?php
include "../../library/mFunction.php";
echo head("m");
?>
<!--头部-->
<div class="header header-fixed">
    <div class="nesting"> <a href="<?php echo $root;?>m/mUser/mUser.php" class="header-btn header-return"><span class="return-ico">&#xe600;</span></a>
        <div class="align-content">
            <p class="align-text">推荐二维码</p>
        </div>
        <a href="#" class="header-btn"></a>
    </div>
</div>
<!--//-->
<div class="container contain-about">
    <div class="about-us mui-ptop45">
        <div class="attention">
            <span>扫一扫下面二维码，进入微网站</span>
            <p><img src="<?php echo "{$root}pay/wxpay/wxScanPng.php?url={$root}m/mindex.php?shareId={$kehu['khid']}";?>"/></p>
        </div>
    </div>
</div>
</body>
</html>