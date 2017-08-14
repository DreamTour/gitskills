<?php
require_once dirname(__FILE__)."/OpenFunction.php";
/*******************网站头部******************************/
function mHeader(){
    $root = $GLOBALS['root'];
    if($GLOBALS['KehuFinger'] == 2) {
        $login = "<a href='{$root}m/mUser/mUsLogin.php'>客户登录</a>";
    } else{
        $login = "<a id='outLogin' href='{$root}m/mIndex.php?delete=client'>退出登录</a>";
    }
    $mHeader = "
		<div class=\"header\">
            <div class=\"clearfix\">
                <div class=\"logo fl\">
                    <a href='{$root}m/mIndex.php'><img src=\"".img("yu3548d")."\" alt=\"logo\"></a>
                </div>
                <div class=\"login fr\">
                    <div class=\"phone\">咨询热线：<span>023-43646686</span></div>
                    {$login}
                </div>
            </div>
        </div>
	";
    return $mHeader;
}
function mFooter(){
    $mFooter = "
        <div class=\"footer\">
            <p>公司电话：0411-83652666 公司地址：大连市西岗区胜利路121号 Copyright © 2010-2020 大连索创智能系统工程有限公司 All Right Reserved</p>
            <p>备案号：辽ICP备07501779号-1</p>
        </div>
	";
    return $mFooter;
}
function mNav(){
    $root = $GLOBALS['root'];
    $mNav = "
        <ul class=\"nav\">
            <li class=\"box ".menu("m/mIndex.php","box2")."\">
                <a href=\"{$root}m/mIndex.php\">
                    <div class=\"box-icon\">
                        <i class=\"box-font\">&#xe604;</i>
                    </div>
                    <span>首页</span>
                </a>
            </li>
            <li class=\"box ".menu("m/mDynamic.php","box2")."\">
                <a href=\"{$root}m/mDynamic.php\">
                    <div class=\"box-font\">
                        <i class=\"box-dynamic\">&#xe62a;</i>
                    </div>
                    <span>业界动态</span>
                </a>
            </li>
            <li class=\"box ".menu("m/mProductAssess.php","box2")."\">
                <a href=\"{$root}m/mProductAssess.php\">
                    <div class=\"box-font\">
                        <i class=\"box-assess\">&#xe669;</i>
                    </div>
                    <span>产品评测</span>
                </a>
            </li>
            <li class=\"box ".menu("m/mContact.php","box2")."\">
                <a href=\"{$root}m/mContact.php\">
                    <div class=\"box-font\">
                        <i class=\"box-contact\">&#xe605;</i>
                    </div>
                    <span>联系我们</span>
                </a>
            </li>
            <li class=\"box ".menu("m/mUser/mUser.php","box2")."\">
                <a href=\"{$root}m/mUser/mUser.php\">
                    <div class=\"box-font\">
                        <i class=\"box-font\">&#xe62e;</i>
                    </div>
                    <span>用户中心</span>
                </a>
            </li>
        </ul>
	";
    return $mNav;
}
?>
