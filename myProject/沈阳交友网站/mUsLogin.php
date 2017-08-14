<?php
include "../mLibrary/mFunction.php";
echo head("m");
if(isset($_GET['detele']) and $_GET['detele'] == 'yes'){
	unset($_SESSION['khid']);
	header("Location:{$root}m/user/mUsLogin.php");
	exit(0);
}
?>
<!--头部-->
<div class="header fz16">
    <div class="head-center"><div class="head-left"><a href="<?php echo getenv("HTTP_REFERER");?>" class="col1">&lt;返回</a></div>
</div>
</div>
<!--登录-->
<ul class="login-box">
	<form name="mUsLoginForm">
    <li class="login">
        <input name="usLoginTel" type="text" placeholder="请输入手机号">
        <input name="usLoginPassword" type="password" placeholder="请输入密码">
    </li>
    <li class="login-fo">
		<a href="javascript:;" id="ForgetPasswordId">忘记密码？</a>
    </li>
    <li class="login-btn">
    	<a href="<?php echo root."m/user/mUsRegister.php";?>" class="login-btn-re bg2 col2 fz16 fw2">免费注册</a>
        <a href="javascript:;" class="login-btn-lo bg1 col1 fz16 fw2" onClick="Sub('mUsLoginForm','<?php echo "{$root}library/PcData.php?type=m";?>')">立即登录</a>
    </li>
    </form>
    <li class="login-logo">
    	<img src="<?php echo img("pBR54253846nl");?>">
    </li>
</ul>
</body>
<?php echo warn();?>
<script>
$(document).ready(function(){
	//忘记密码
    $("#ForgetPasswordId").click(function(){
        $.post("<?php ro();?>library/OpenData.php",{UserType:"user",ForgetTel:document.mUsLoginForm.usLoginTel.value},function(data){
            warn(data.warn);
        },"json");
    });
});
</script>
</html>
