<?php
/*
*移动端函数库
*/
include (dirname(__FILE__))."/OpenFunction.php";
/*********移动端使用微信自动登录函数***********************/
if($KehuFinger == 2){
    wxLogin($ThisUrl);
}

/******底部*****************************/
function Footer(){
    global $root;
    $html = "
            <div class='footer mui-fixed'>
		<ul class='mui-dis-flex'>
		    <li> <a href='{$root}m/mindex.php'> <span class='mindex'>&#xe604;</span><p>首页</p></a> </li>
		    <li> <a href='{$root}m/mClassify.php'> <span class='mclassy'>&#xe609;</span><p>商城</p></a> </li>
		     <li> <a href='{$root}m/mUser/mUsBuyCar.php'> <span class='mcar'>&#xe60c;</span><p>购物车</p></a> </li>
		    <li> <a href='{$root}m/mUser/mUser.php'> <span class='musercenter'>&#xe60f;</span><p>我的</p></a> </li>
		</ul>
	</div>
	";
    return $html;
}

/******移动端函数库*****************************/
function mWarn(){

    if (isset ($_SESSION['warn']) and !empty ($_SESSION['warn']) ){
        $GLOBALS['warn'] = $_SESSION['warn'];//使用全局变量的原因：$warn可能从函数外部传入
        unset($_SESSION['warn']);
    }
    if (!empty($GLOBALS['warn']) ){
        $show =  "mwarn('{$GLOBALS['warn']}');";
    }

    $html .= "
	<div id='cover'>
		<div id='cover_con'>
			<p id='coverP'>空</p>
			<div>
				<button id='coverSure'>确 认</button>
				<button id='coverCancel'>取 消</button>
			</div>
		</div>
	</div>
	<script>
	$(document).ready(function(){
	    {$show}
		$('#coverSure,#coverCancel').click(function(){
		    $('#cover').hide();
		});
	});
	function mwarn(word){
		$('#cover').show();
		$('#coverP').html(word);
	}
	</script>
	";
    return $html;
}

/**
 * 查询函数
 * @param $table 数据库表名称
 * @param null $where 条件
 * @param null $feild 字段
 * @param bool $debug 报错
 * @return array|string 返回二维数组
 */
function inquiry($table,$where=null,$feild=null,$debug=FALSE){
    if(empty($feild)){
        $feild='*';
    }
    if(!empty($where)){
        if(strpos($where,"where")){
            $where="$where";
        }else{
            $where="where $where";
        }
    }
    $query=mysql_query("select $feild from $table $where");
    while (@$content=mysql_fetch_assoc($query)){
        $re[]=$content;
    }
    if($debug){
        return "select $feild from $table $where";
    }
    return $re;
}
?>