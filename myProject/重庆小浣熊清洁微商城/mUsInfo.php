<?php
include "../../library/mFunction.php";
$kehu = query("kehu","khid = '$kehu[khid]'");
echo head("m");
?>
<!--头部-->
<div class="header header-fixed">
    <div class="nesting"> <a href="<?php echo root;?>m/mUser/mUser.php" class="header-btn header-return"><span class="return-ico">&#xe600;</span></a>
        <div class="align-content">
            <p class="align-text">个人资料</p>
        </div>
    </div>
</div>
<!--//-->
<div class="container">
    <div class="edit-info mui-ptop45">
        <form name="usInfo" method="post">
            <ul>
                <li><span>头像</span><label><img src="<?php echo $kehu['wxIco'];?>"/></label></li>
                <li><span>昵称</span><label><input name="khNickName" type="text" value="<?php echo $kehu['wxNickName'];?>" /></label></li>
                <li><span>真实姓名</span><label><input name="khName" type="text" placeholder="请输入你的真实姓名" value="<?php echo $kehu['name'];?>"/></label></li>
                <li><span>性别</span>
                    <div>
                        <?php echo radio("khSex",array('男','女'),$kehu['wxSex']);?>
                    </div>
                </li>
                <li><span>手机号码</span><label><input type="text" placeholder="请输入你的手机号码" value="<?php echo kong($kehu['tel']);?>" readonly/></label><a href="<?php echo $root.'m/mUser/mUsTel.php'?>" class="bind-phone-btn1">修改</a></li>
            </ul>
        </form>
    </div>
</div>
<a href="#" class="bind-phone_btn" onclick="Sub('usInfo',root+'library/mData.php?type=mUsInfo')">确定</a>
<?php echo mWarn();?>
</body>
</html>