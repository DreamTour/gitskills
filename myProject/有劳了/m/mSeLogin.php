<?php
include "../../library/mFunction.php";
echo head("m");
?>
<body style="background-color:#fff;">
<header id="login">
    <a href="../../m/mindex.php"><img src="../../img/WebsiteImg/oqX58150379Bb.jpg"></a>
    <a href="../../m/mUser/mUsLogin.php"><span>个人登录</span></a>
</header>
<div class="login-content">
    <h2>企业用户登录</h2>
    <div class="login-btn">
        <!--<a href="<?php /*echo root."library/WXnotify.php?IdentityType=company";*/?>" class="weixin-btn"><i class="login-icon login-icon1"></i><span>微信登录</span></a>-->
        <a href="<?php echo root."library/QQnotify.php?IdentityType=company";?>" class="qq-btn"><i class="login-icon login-icon2"></i><span>QQ登录</span></a>
        <a href="<?php echo root."library/WBnotify.php?IdentityType=company";?>" class="weibo-btn"><i class="login-icon login-icon3"></i><span>微博登录</span></a>
    </div>
</div>
</body>
</html>
