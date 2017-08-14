<?php 
include "../../library/mFunction.php";
echo head("m");
?>
<body style="background-color:#fff;">
<header id="login">
	<a href="../../m/mindex.php"><img src="../../img/WebsiteImg/oqX58150379Bb.jpg"></a>
    <a href="../../m/mSeller/mSeLogin.php"><span>企业登录</span></a>
</header>
<div class="login-content">
	<h2>个人用户登录</h2>
    <div class="login-btn">
    	<!--<a href="<?php /*echo root."library/WXnotify.php?IdentityType=personal";*/?>" class="weixin-btn"><i class="login-icon login-icon1"></i><span>微信登录</span></a>-->
        <a href="<?php echo root."library/QQnotify.php?IdentityType=personal";?>" class="qq-btn"><i class="login-icon login-icon2"></i><span>QQ登录</span></a>
        <a href="<?php echo root."library/WBnotify.php?IdentityType=personal";?>" class="weibo-btn"><i class="login-icon login-icon3"></i><span>微博登录</span></a>
    </div>
</div>
</body>
</html>
