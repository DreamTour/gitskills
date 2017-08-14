<?php
include dirname(__FILE__)."/configure.php";
/***********************列表菜单************************/
function adlist($img,$url,$title,$word){
    $root = $GLOBALS['root'];
    $adroot = $GLOBALS['adroot'];
    return "
    <div class='kuang'>
        <div change='ico' class='list' style=' background-image:url({$root}img/adimg/{$img})'></div>
        <a href='{$adroot}{$url}'>
        <h2>{$title}</h2>
        <p>{$word}</p>
        </a>
        <div class='clear'></div>
    </div>
    ";
}
/***********************网站管理中心页头************************/
function adheader($onion){
    //赋值
    $info = "<a href='".root."control/info/info.php'><li class='".menu("info","menuHover")."'>信息管理</li></a>";
    $Internal = "<a href='".root."control/Internal/adInternal.php'><li class='".menu("Internal","menuHover")."'>内部管理</li></a>";
    $Finance = "<a href='".root."control/finance/adFinancial.php'><li class='".menu("finance","menuHover")."'>财务管理</li></a>";
    $adDevice = "<a href='".root."control/adDevice.php'><li class='".menu("adDevice","menuHover")."'>设备管理</li></a>";
    $adSystem = "<a href='".root."control/adSystem.php'><li class='".menu("adSystem","menuHover")."'>摆位图</li></a>";
    $adClient = "<a href='".root."control/adClient.php'><li class='".menu("adClient","menuHover")."'>客户管理</li></a>";
    $adBespeak = "<a href='".root."control/adBespeak.php'><li class='".menu("adBespeak","menuHover")."'>客户预约</li></a>";
    $adComplain = "<a href='".root."control/adComplain.php'><li class='".menu("adComplain","menuHover")."'>客户投诉</li></a>";
    $personal = "<a href='".root."control/adpersonal.php'><li class='".menu("adpersonal","menuHover")."'>个人中心</li></a>";
    //判断
    $menu = $info;
    if(power("员工管理")){
        $menu .= $Internal;
    }
    if(power("参数管理")){
        $menu .= $Finance;
    }
    /*if(power("设备管理")){
        $menu .= $adDevice;
    }*/
    if(power("摆位图")){
        $menu .= $adSystem;
    }
    if(power("客户管理、设备报修、售后管理、设备管理")){
        $menu .= $adClient;
    }
    if(power("客户预约")){
        $menu .= $adBespeak;
    }
    if(power("客户投诉")){
        $menu .= $adComplain;
    }
    $menu .= $personal;
    //洋葱皮导航
    $url = "";
    foreach($onion as $key => $value){
        $url .= "&nbsp;>&nbsp;<a href='{$value}'>{$key}</a>";
    }
    $url .= "<a href='".root."control/login.php?Delete=admin' class='FloatRight'>注销登录</a>";
    return "
	<div class='menu'>
		<div class='column'>
			<a target='_blank' href='".root."'><img src='".img("yu3548d")."'></a>
			<ul>{$menu}</ul>
		</div>
	</div>
	<div class='onion'>
		<div>".website("uisuwd")."{$url}</div>
	</div>
	";
}
/***********************网站管理中心页脚************************/
function adfooter(){
    //赋值
    $info = "<a href='".root."control/info/info.php'>信息管理</a>";
    $Internal = "<a href='".root."control/Internal/adInternal.php'>内部管理</a>";
    $Finance = "<a href='".root."control/finance/adFinancial.php'>财务管理</a>";
    $adDevice = "<a href='".root."control/adDevice.php'>设备管理</a>";
    $adSystem = "<a href='".root."control/adSystem.php'>摆位图</a>";
    $adClient = "<a href='".root."control/adClient.php'>客户管理</a>";
    $adBespeak = "<a href='".root."control/adBespeak.php'>客户预约</a>";
    $adComplain = "<a href='".root."control/adComplain.php'>客户投诉</a>";
    $personal = "<a href='".root."control/adpersonal.php'>个人中心</a>";
    //判断
    $menu = $info;
    if(power("员工管理")){
        $menu .= $Internal;
    }
    if(power("参数管理")){
        $menu .= $Finance;
    }
    /*if(power("设备管理")){
        $menu .= $adDevice;
    }*/
    if(power("摆位图")){
        $menu .= $adSystem;
    }
    if(power("客户管理")){
        $menu .= $adClient;
    }
    if(power("客户预约")){
        $menu .= $adBespeak;
    }
    if(power("客户投诉")){
        $menu .= $adComplain;
    }
    $menu .= $personal;
    //返回
    return "
	<div style='clear:both; height:10px;'></div>
	<div style='background-color:#555;'>
		<div class='column BlackMenu'>
			{$menu}
		</div>
	</div>
	</body>
	</html>
	";
}
/***********************警示函数************************/
/*
本函数不仅可以用户列表页、还可以用于明细页表单的附加密码警示
javascript的EditList函数带表单名称的作用是让同一个页面多个表单都可以使用本函数
注：表单中不用input type='hidden'而用type='text'且class来隐藏文本框的原因是本表单为单一文本框，客户按enter时会自动提交。
*/
function PasWarn($PostUrl){
    $div = "
	<div class='hide' id='PasWarn'>
		<div class='dibian'></div>
		<div class='win' style='width:500px; height:202px; margin:-101px 0 0 -250px;'>
			<p class='winTitle'>一级警告<span class='winClose' onclick=\"$('#PasWarn').hide()\">×</span></p>
			<form name='PasForm'>
			<table class='TableRight'>
				<tr>
					<td style='width:100px;'>警告信息：</td>
					<td id='PasWarnWord'></td>
				</tr>
				<tr>
					<td>登录密码：</td>
					<td><input name='Password' type='password' class='text short'></td>
				</tr>
				<tr>
					<td>
					<input name='FormName' type='text' class='hide'>
					<input name='PadWarnType' type='text' class='hide'>
					</td>
					<td><input type='button' class='button' value='确认提交' onclick=\"Sub('PasForm,' + document.PasForm.FormName.value,'{$PostUrl}')\"></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	<script>
	function EditList(FormName,type){
		document.PasForm.FormName.value = FormName;
		document.PasForm.PadWarnType.value = type;
		$('#PasWarn').fadeIn();
		$.post('".root."control/ku/data.php',{PasWarnWord:type},function(data){
			$('#PasWarnWord').html(data.word);
		},'json');
	}
	</script>
	";
    return $div;
}
?>