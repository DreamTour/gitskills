<?php
include "../library/PcFunction.php";
echo head("pc").headerPC().navOne();
;?>
<!-- 登录 -->
<div class="banner">
    <div class="register_box">
        <div class="zzc"></div>
        <form name="usLoginForm">
            <div class="register">
                <div class="reg">会员登录</div>
                <div class="line"></div>
                <div class="select_box">
                    <div class="login_page clearfix">
                        <span class="box-span fl">登录账号</span>
                        <input name="accountNumber" type="text" placeholder="请输入登录账号">
                    </div>
                    <div class="login_page clearfix">
                        <span class="box-span fl">密码</span>
                        <input name="khpas" type="password" placeholder="请输入登录密码">
                    </div>
                    <div class="login_page Verification clearfix">
                        <span class="box-span fl"><img src="<?php echo root."library/ProveImg.php?";?>" id="CheckNumImg" title="点击切换验证码"></span>
                        <input name="verificationCode" type="text" placeholder="请输入验证码">
                    </div>
                </div>
                <a class="free_reg" href="javascript:;" onClick="Sub('usLoginForm','<?php echo "{$root}library/PcData.php?type=usLogin";?>')">立即登录</a>
                <!--<a href="javascript:;" class="forget">忘记密码？</a>-->
            </div>
        </form>
    </div>
    <img class="img" src="<?php echo img("RYm68757835up");?>" alt="" />
</div>
<!-- 页脚 -->
<?php echo footerPC().warn();?>
</body>
<script>
    //返回验证码
    $("#CheckNumImg").click(function(){
        $(this).attr("src",root + "library/ProveImg.php?" + Math.random());
    });
    //搜索表单placeholder
    jQuery('input[placeholder]').placeholder();
</script>
</html>