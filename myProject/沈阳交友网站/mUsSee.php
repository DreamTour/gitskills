<?php
include "../mLibrary/mFunction.php";
echo head("m");
UserRoot("m");
limit($kehu);
$sql = mysql_query("select * from follow where type = '2' and TargetId = '$kehu[khid]' ");
$sqlNum = mysql_num_rows(mysql_query("select * from follow where type = '2' and TargetId = '$kehu[khid]' "));
$see = "";
if($sqlNum == 0){
	$see = "一个看过你的人都没有";		
}else{
	while($array = mysql_fetch_assoc($sql)){
		$client = mysql_fetch_assoc(mysql_query("select * from kehu where khid = '$array[khid]' "));
		$see .= "
	<li class='look-item of'>
    	<a href='{$root}m/userDatum.php?search_khid={$array['khid']}'><img src='".HeadImg($client['sex'],$client['ico'])."' class='fl'></a>
        <div class='look-text fr'>
        	<div class='look-title of'> 
                <a href='{$root}m/userDatum.php?search_khid={$array['khid']}'><h2 class='fl col2 fw2'>{$client['NickName']}</h2></a>
                <span class='fr'>".mb_substr($array['time'],0,10,'utf-8')."</span>
            </div>
            <p class='fz14'>已看过你</p>
        </div>
    </li>
		";	
	}
}
?>
<!--头部-->
<div class="header fz16">
    <div class="head-center">
    	<div class="head-left"><a href="<?php echo getenv("HTTP_REFERER");?>" class="col1"><返回</a></div>
		<h3></h3></div>
</div>
<!--信息-->
<ul class="look-content">
	<?php echo $see;?>
</ul>
<!--底部-->
</body>
</html>
