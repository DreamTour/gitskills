<?php
include "mLibrary/mFunction.php";
echo head("m");
UserRoot("m");
$sql = mysql_query(" select * from kehu where Auditing = '已通过' and khid != '$kehu[khid]' order by rankingTop='是' desc,UpdateTime desc");
$num = mysql_num_rows(mysql_query("select * from kehu where khid != '$kehu[khid]' "));
/*************会员列表**********************************************/
$client = "";
if($num == 0){
	$client .= "一条搜索都没有";
}else{
	while($array = mysql_fetch_array($sql)){
		$age = date("Y") - substr($array['Birthday'],0,4);
		$client .= "
	<li>
    	<a href='{$root}m/userDatum.php?search_khid={$array['khid']}'>
            <div class='index-list'>
                <img src='".HeadImg($array['sex'],$array['ico'])."'>
                <div class='mask'>
                    <p>{$array['NickName']}<br/>{$age}岁 {$array['height']}cm</p>
                </div>
            </div>
        </a>
    </li>
		";
	}
}
?>
<!--头部-->
<div class="header fz16">
    <a href="<?php echo "{$root}m/user/mUsExtend.php";?>"><img src="<?php echo img("KKR54253637kM");?>"></a>
    <div class="head-left"><a href="<?php echo $root;?>m/user/mUsLogin.php" class="col1"></a></div>
    <div class="head-center"><h3></h3></div>
    <div class="head-right"><a href="<?php echo $root;?>m/user/mUsRegister.php" class="col1"></a></div>
</div>
<!--内容-->
<ul class="index-content">
	<?php echo $client;?>
</ul>
<!--底部-->
<?php echo warn().mFooter();?>