<?php
include "ku/adfunction.php";
if($ControlFinger == 1){header("Location:{$root}control/adpersonal.php");}
echo head("ad");
?>
    <img class="loginBack" src="<?php echo root."img/adimg/bg.jpg";?>">
    <div class="loginWin">
        <img class="loginIco" src="<?php echo root."img/adimg/adloginIco.png";?>">
        <h2><?php echo website("name");?></h2>
        <p>数据，如影随形</p>
        <form name="adLoginForm">
            <table>
                <tr>
                    <td>手机号码：</td>
                    <td><input name="ControlTel" type="text" placeholder="公司分配的手机号码"></td>
                </tr>
                <tr>
                    <td>登录密码：</td>
                    <td><input name="ControlPasword" type="password" placeholder="可发送密码短信至注册手机"></td>
                </tr>
                <tr>
                    <td>验证码：</td>
                    <td>
                        <input name="prove" type="text" placeholder="图形验证码">
                        <img src="<?php echo root."library/proveImg.php";?>" id="CheckNumImg" title="点击切换验证码">
                    </td>
                </tr>
            </table>
            <input name="SubButton" type="button" onClick="Sub('adLoginForm','<?php echo root."library/libData.php?type=adLogin";?>')" value="登录">
            <p><a id="ForgetPasswordId" href="javascript:;" class="forgetpasA">忘记密码？点击发送短信登录密码到注册手机</a></p>
        </form>
    </div>
    <script>
        $(function(){
            //客户状态变化
            $.ajax({
                url: '<?php echo root."control/ku/addata.php?type=changeStatus";?>',
                type: 'POST',
                dataType: 'json',
                success: function(data) {

                },
                error: function() {
                    alert('服务器错误');
                },
            })

            var form = document.adLoginForm;
            //打开时定位到手机号码输入框，按enter键时执行提交事件
            form.ControlTel.focus();
            $(document).keydown(function(event){
                if(event.keyCode==13){
                    form.SubButton.click();
                }
            });
            //返回验证码
            $("#CheckNumImg").click(function(){
                $(this).attr("src",root + "library/proveImg.php?" + Math.random());
            });
            //忘记密码
            $("#ForgetPasswordId").click(function(){
                $.post(root+"library/libData.php?type=adForgetPassword",{UserType:"admin",ForgetTel:form.ControlTel.value},function(data){
                    warn(data.warn);
                },"json");
            });
            //数据库每日备份
            $.post(root+"library/backups.php",{ThisBackups:"ThisBackups"},function(data){});
        });
    </script>
<?php echo warn();?>