<?php
require_once("../library/PcFunction.php");
if($KehuFinger == 1){
	header("location:{$root}user/user.php");
	exit(0);
}
echo head('pc').pc_header();
?>
<!--头部-->
<style>
/*banner*/
.banner{
	height:450px;
	margin:auto;
	overflow:hidden;
	position:relative;
	margin-bottom:30px;	
}
#banner-scontainer {
    position: absolute;
    overflow: hidden;
    height: 450px;
    top: 0;
    width: 100%;
}
#banner-scontainer .list-item li{ float:left; height:450px;}
#banner-scontainer .list-item:after{ content:''; display:block; clear:both;}
#banner-scontainer .sort-item{ position:absolute; width:100%; bottom:20px; left:0; z-index:100; text-align:center}
#banner-scontainer .sort-item li{ width:10px; height:10px; background:#fff; display:inline-block; margin:0 5px;}
#banner-scontainer .sort-item .cur{ background:#C00 !important;}
/*注册透明块儿*/
.register_box{
	height:450px;
	width:1000px;
	position:relative;
	margin:auto;
	z-index:1;
}
.index-banner{
	position: absolute;
    top: 0;
    height: 100%;
    width: 100%;
	overflow:hidden;
}
.zzc,.register{
	width:400px;
	height:380px;
	position:absolute;
	left:25px;
	top:30px;
	text-align:center;
	border:1px solid #ddd;	
}
.zzc{ 
	background:#fff;
	opacity:.9; 
	filter:alpha(opacity=90);
}
.register span{
	font-size:16px;
}
.reg{
	font-size:20px;
	padding:20px 0;
	color:#000;
}
.register h1{
	display:inline;
	font-size:16px;
	margin-right:20px;
	margin-left:25px;
}
.line{
	width:380px;
	height:1px;
	background-color:#ddd;
	margin-left:10px;
}
.free_reg{
	display:inline-block;
	width:230px;
	padding:15px 18px;
	background:#ff536a;
	font-size:20px;
	color:#fff;
	margin:20px 0;
}
.login_quick{
	display:block;
	font-size:14px;
	text-decoration:underline;	
}
.register .select_box{
	text-align:left;
	padding-left:50px;
}
.select_box{
	margin-top:45px;
}
.login_page{
	margin-bottom:15px;
}
.login_page span{
	display:inline-block;
	width:70px;
	line-height:30px;
	text-align:justify;
}
.login_page input{
	width: 220px;
    height: 40px;
    border: 1px solid #ddd;
    margin-right: 5px;
	padding-left:10px;
	font-size:14px;
}
</style>
<!--banner-->
<div class="banner">
    <div class="register_box">
        <div class="zzc"></div>
        <div class="register">
            <div class="reg">会员登录</div>
            <div class="line"></div>
            <form name="usLoginForm">
                <div class="select_box">
                    <div class="login_page">
                        <span>登录账号</span>
                        <input name="usLoginTel" type="text" placeholder="请输入手机号码">
                    </div>                        
                    <div class="login_page">
                        <span>密码</span>
                        <input name="usLoginPassword" type="password" placeholder="请输密码">
                    </div>
               </div>
               <a class="login_quick" href="javascript:;" id="ForgetPasswordId">忘记密码？</a>
               <a id="free_reg" class="free_reg" href="javascript:;" onClick="Sub('usLoginForm','<?php echo root."library/PcData.php";?>')">立即登录</a>
           </form>
           <a class="login_quick" href="<?php echo root."user/usRegister.php";?>">还不是会员？立即注册</a>
        </div>
    </div>
    <div id="banner-scontainer" class="banner-scontainer">
        <div class="banner-listitem">
            <ul class="list-item">
                <li style="background:url(<?php echo img("fIX49944449NG");?>) no-repeat scroll center/cover"></li>
                <li style="background:url(<?php echo img("fIX49944449NG");?>) no-repeat scroll center/cover"></li>
                <li style="background:url(<?php echo img("fIX49944449NG");?>) no-repeat scroll center/cover"></li>
            </ul>
        </div>
        <div class="banner-sortitem">
            <ul class="sort-item"></ul>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
	//忘记密码
    $("#ForgetPasswordId").click(function(){
        $.post("<?php ro();?>library/OpenData.php",{UserType:"user",ForgetTel:document.usLoginForm.usLoginTel.value},function(data){
            warn(data.warn);
        },"json");
    });
});
var banner = function(a) {
		var a = a || {};
		var timer = null;
		var count = 0;
		var sorts = jQuery(a.sortItem);
		var lists = jQuery(a.listItem);
		var sortItem = sorts.find('li');
		var listItem = lists.find('li');
		var length = listItem.length;
		for (var i = 0; i < length; i++) {
			sorts.append('<li></li>')
		}
		sorts.find('li:first').addClass('cur').siblings().removeClass('cur');
		lists.width(sorts.width() * length);
		var w = window;
		lists.find('li').width(w.innerWidth);
		lists.find('img').width(w.innerWidth);
		lists.width(w.innerWidth * length);
		var resize = function() {
				var w = window;
				lists.find('li').width(w.innerWidth);
				lists.find('img').width(w.innerWidth);
				lists.width(w.innerWidth * length)
			}
		window.addEventListener('resize', resize, false);
		var setMove = function(index) {
				lists.animate({
					marginLeft: -index * sorts.width()
				}, 600)
			}
		var interval = function() {
				timer = setInterval(function() {
					count++;
					if (count == length) {
						count = 0
					}
					sorts.find('li').eq(count).addClass('cur').siblings().removeClass('cur');
					setMove(count)
				}, 2500)
			}
		$('.sort-item li').click(function() {
			clearInterval(timer);
			var index = $(this).index();
			sorts.find('li').eq(index).addClass('cur').siblings().removeClass('cur');
			count = index;
			setMove(index);
			interval()
		});
		lists.hover(function() {
			clearInterval(timer)
		}, function() {
			interval()
		});
		interval()
}
</script>
<!--底部-->
<?php echo warn().footer();?> 