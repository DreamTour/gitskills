<?php
/*********************引入库文件*********************/
#前端不用管
require_once dirname(__FILE__)."/OpenFunction.php";
/*******************如果是移动设备，则跳转到手机网站首页******************************/
if(isMobile()){
    header("Location:{$root}m/mIndex.php");
    exit(0);
}
//网站头部
function headerPC() {
    $root = $GLOBALS['root'];
    if($GLOBALS['KehuFinger'] == 2) {
        $login = " <li> <a href='{$root}user/usLogin.php'>客户登录</a> </li>";
    } else{
        if(strstr($GLOBALS['ThisUrl'],"?")==false){
            $b="?";
        }else{
            $b="&";
        }
        $login = "<li> <a href='{$GLOBALS['ThisUrl']}{$b}delete=client'>退出登录</a> </li>";
    }
    $header = "
        <div class=\"header\">
            <div class='notice'>
                <div class='container clearfix'>
                    <div class='notice-text fl'>您好，欢迎访问弱电365！</div>
                    <ul class='clearfix fr'>
                        {$login}
                    </ul>
                </div>
            </div>
            <div class=\"head clearfix\">
                <div class=\"head-left fl clearfix\">
                    <div class=\"logo fl\"><a href=\"{$root}index.php\"><img src=\"".img("yu3548d")."\" alt=\"logo图片\" width=\"120\" height=\"50\" /></a></div>
                </div>
                <div class=\"head-right fr\">
                    <span>追求品质，追求卓越</span>
                    <p>THE PURSUIT OF EXCELLENCE</p>
                </div>
                <div class=\"head-center fr\">
                    <span>咨询热线</span>
                    <p>".website("Hkc65756720CO")."</p>
                </div>
            </div>
        </div>
    ";
    return $header;
}
//网站导航one
function navOne() {
    $root = $GLOBALS['root'];
    $nav = "
        <div class=\"nav-wrap clearfix\">
            <div class=\"nav\">
                <ul>
                    <li class=\"nav-item ".menu("index.php", "cur")."\"><a href=\"{$root}index.php\">首页</a></li>
                    <li class=\"nav-item ".menu("about.php", "cur")."\"><a href=\"{$root}about.php\">关于我们</a></li>
                    <li class=\"nav-item ".menu("dynamic.php", "cur")."\"><a href=\"{$root}dynamic.php\">业界动态</a></li>
                    <li class=\"nav-item ".menu("productAssess.php", "cur")."\"><a href=\"{$root}productAssess.php\">产品评测</a></li>
                    <li class=\"nav-item ".menu("contact.php", "cur")."\"><a href=\"{$root}contact.php\">联系我们</a></li>
                    <li class=\"nav-item ".menu("user/user.php", "cur")."\"><a href=\"{$root}user/user.php\">用户中心</a></li>
                </ul>
                <!--移动的滑动-->
                <div class=\"move-bg\"></div>
                <!--移动的滑动 end-->
            </div>
        </div>
    ";
    return $nav;
}
//网站导航two
function navTwo() {
    $root = $GLOBALS['root'];
    $systemSql = mysql_query("select * from system");
    $deviceSystem = "";
    $sketchMapSystem = "";
    while ($array = mysql_fetch_assoc($systemSql)) {
        $deviceSystem .= " <li><a href=\"{$root}device.php?id={$array['id']}\">{$array['name']}</a></li>";
        $sketchMapSystem .= " <li><a href=\"{$root}sketchMap.php?id={$array['id']}\">{$array['name']}</a></li>";
    }
    $nav = "
    <div class=\"user-nav-wrap\">
        <div class=\"user-nav\">
            <ul class=\"clearfix\">
                <li class=\"nav-item nav-item-pic\"><a href=\"{$root}user/user.php\"><img src=\"".img("Pcx64186528LH")."\"></a></li>
                <li class=\"nav-item clearfix\">
                    <a href=\"javascript:;\">我的设备</a>
                    <ul class=\"level\">
                        {$deviceSystem}
                    </ul>
                </li>
                <li class=\"nav-item\">
                    <a href=\"javascript:;\">摆位图</a>
                    <ul class=\"level\">
                        {$sketchMapSystem}
                    </ul>
                </li>
            </ul>
            <div class=\"user-nav-search\">
                <form name=\"\">
                    <input id='searchText' type=\"text\" name=\"\" value=\"{$_GET['search_text']}\" placeholder=\"搜索设备的名称、型号\" />
                    <span class='searchBtn' id='searchBtn'>搜索</span>
                </form>
            </div>
        </div>
    </div>
    <script>
	//选择省份城市
	$(function(){
		//导航设备搜索
		$('#searchBtn').click(function() {
			window.location.href = '{$root}device.php?search_text=' + $('#searchText').val();
		});
	})
	</script>
    ";
    return $nav;
}
//网站底部
function footerPC() {
    $root = $GLOBALS['root'];
    if($GLOBALS['KehuFinger'] == 2) {
        $login = " <li> <a href='{$root}user/usLogin.php'>客户登录</a> </li>";
    } else{
        if(strstr($GLOBALS['ThisUrl'],"?")==false){
            $b="?";
        }else{
            $b="&";
        }
        $login = "<li> <a href='{$GLOBALS['ThisUrl']}{$b}delete=client'>退出登录</a> </li>";
    }
    $footer = "
        <div class=\"footer\">
            <div class=\"container\">
                <div class=\"footer-nav\">
                    <a href=\"{$root}index.php\">首页</a>
                    <a href=\"{$root}about.php\">关于弱电365</a>
                    <a href=\"{$root}dynamic.php;\">业界动态</a>
                    <a href=\"{$root}productAssess.php\">产品评测</a>
                    <a href=\"{$root}contact.php\">联系我们</a>
                    <a href=\"{$root}user/user.php\">用户中心</a>
                </div>
                <p>".website("uisjue410q")."</p>
                <p>".website("QKd65746896TJ")."</p>
            </div>
        </div>
        <!--[if lt IE 10]>
            <script>alert('浏览器当前版本已经不建议使用! 微软已停止对IE8/9/10的支持! 请升级IE版本或者更换浏览器!'); window.close();</script>
        <![endif]-->
    ";
    return $footer;
}