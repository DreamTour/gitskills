<?php
include "../../library/mFunction.php";
echo head("m");
;?>
<div class="mUsLogin">
    <h2><img src="<?php echo img("yu3548d") ;?>" /></h2>
    <form name="usLoginForm">
        <input name="accountNumber" type="text" placeholder="帐号" />
        <input name="khpas" type="password" placeholder="密码" />
        <div class="btn" onClick="Sub('usLoginForm','<?php echo "{$root}library/PcData.php?type=mUsLogin";?>')">立即登录</div>
        <!--<a href="">忘记密码? | </a>
        <a href="">立即注册</a>-->
    </form>
</div>
</body>
<?php echo warn();?>
</html>




