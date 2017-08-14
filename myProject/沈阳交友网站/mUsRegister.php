<?php
include "../mLibrary/mFunction.php";
echo head("m");
if($KehuFinger == 1){
	header("location:{$root}m/user/mUser.php");
	exit(0);	
}
?>
<!--头部-->
<div class="header fz16">
    <div class="head-center">	<div class="head-left"><a href="<?php echo getenv("HTTP_REFERER");?>" class="col1">&lt;返回</a></div>
</div>
</div>
<!--登录-->
<div class="register-content">
	<form name="mUsRegisterForm">
        <ul class="register-box bg2">
        <li class="register"><span>手机号：</span><input name="phone" type="text" placeholder="请输入手机号"></li>
        <li class="register"><span>验证码：</span><input name="verificationCode" type="text" placeholder="请输入验证码" id="re-code"><a href="javascript:;" class="re-code-btn tc bg1 col1 fz14" id="verificationCode">发送验证码</a></li>
        <li class="register"><span>分享码：</span><input name="shareCode" type="text" placeholder="请输入邀请人分享码 没有可以不填" value="<?php echo $_GET['ShareCode'];?>"></li>
        <li class="register"><span>密码：</span><input name="password" type="password" placeholder="请输入密码"></li>
        <li class="register"><span>确认密码：</span><input name="truePassword" type="password" placeholder="请确认密码" style="border:none;"></li>
    </ul>
    <div class="register-btn-box"><a href="javascript:;" class="register-btn bg1 col1 fz16 fw2" onClick="Sub('mUsRegisterForm','<?php echo root."m/mLibrary/mData.php";?>')">免费注册</a></div>
    </form>
</div>
</body>
</html>
<?php echo warn();?>
<script>
	$(function(){
		//获取验证码
		$('#verificationCode').click(function(){
			$.post("<?php echo "{$root}library/OpenData.php";?>",{RegisterCheckTel:$('[name=mUsRegisterForm] [name=phone]').val()},function(data){
				warn(data.warn);
			},"json")	
		})
	})
</script>

