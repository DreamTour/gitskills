<?php 
include "../library/PcFunction.php";
echo head("pc");
?>
<!--头部-->
<div class="login-header bg1 fz14">
	<div class="row">
    	<a href="<?php echo $root;?>index.php"><img src="<?php echo $root;?>img/WebsiteImg/PBr57277184XW.jpg" class="fl login-logo"></a>
        <!--<div class="fr"><a href="javascript:;"><i class="icon2 login-phone"></i><span class="col1">手机有劳了</span></a></div>-->
    </div>
</div>
<!--内容-->
<div class="login-content">
	<div class="row login-center">
    	<div class="login-box">
        	<h2>企业用户登录</h2>
           	<div class="login-btn">
            	<a href="<?php echo root."library/WXnotify.php?IdentityType=company";?>" class="weixin-btn"><i class="icon2 login-weixin"></i>微信扫描登陆</a>
                <a href="<?php echo root."library/QQnotify.php?IdentityType=company";?>" class="qq-btn"><i class="icon2 login-qq"></i>QQ一键登录</a>
                <a href="<?php echo root."library/WBnotify.php?IdentityType=company";?>" class="weibo-btn"></a>
            </div> 
        </div>
    </div>
</div>
<!--页脚-->
<?php echo pcFooter().warn();?>

