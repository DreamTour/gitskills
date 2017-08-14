<?php
include "../../library/mFunction.php";
echo head("m");
?>
<!--头部-->
<div class="header header-fixed">
    <div class="nesting"> <a href="<?php echo $root;?>m/mUser/mUsReceive.php" class="header-btn header-return"><span class="return-ico">&#xe600;</span></a>
        <div class="align-content">
            <p class="align-text">确认领取</p>
        </div>
        <a href="#" class="header-btn"></a>
    </div>
</div>
<!--//-->
<div class="container contain-about">
    <div class="about-us mui-ptop45">
        <div class="attention">
            <span>扫一扫下面二维码，确认领取</span>
            <p><img src="<?php echo "{$root}pay/wxpay/wxScanPng.php?url={$root}control/ku/QRCode.php?clientId={$kehu['khid']}";?>"/></p>
        </div>
    </div>
</div>
</body>
</html>