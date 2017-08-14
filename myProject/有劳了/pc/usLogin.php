<?php 
include "../library/PcFunction.php";
echo head("pc");
?>
<!--头部-->
<div class="login-header bg1 fz14">
	<div class="row">
    	<a href="<?php echo $root;?>index.php"><img src="<?php echo $root;?>img/WebsiteImg/PBr57277184XW.jpg" class="fl login-logo"></a>
    </div>
</div>
<!--内容-->
<div class="login-content">
	<div class="row login-center">
    	<div class="login-box">
        	<h2>个人用户登录</h2>
           	<div class="login-btn">
            	<a href="<?php echo root."library/WXnotify.php?IdentityType=personal";?>" class="weixin-btn"><i class="icon2 login-weixin"></i>微信扫描登陆</a>
                <a href="<?php echo root."library/QQnotify.php?IdentityType=personal";?>" class="qq-btn"><i class="icon2 login-qq"></i>QQ一键登录</a>
                <a href="<?php echo root."library/WBnotify.php?IdentityType=personal";?>" class="weibo-btn"></a>
            </div> 
        </div>
    </div>
</div>
<!--页脚-->
<?php echo pcFooter().warn();?>


