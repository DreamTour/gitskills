<?php
include "../mLibrary/mFunction.php";
echo head("m");
UserRoot("m");
limit($kehu);
$sql = mysql_query("select * from content where type = '商务合作' and xian = '显示' order by time desc limit 3");
$sqlNum = mysql_num_rows(mysql_query("select * from content where type = '商务合作' and xian = '显示' "));
$cooperationTitle = "";
$cooperationContent = "";
$x = 0;
if($sqlNum == 0){
	$cooperationTitle = "未设置";	
	$cooperationContent = "一个商务合作都没有";
}else{
	while($array = mysql_fetch_assoc($sql)){
	if($x == 0){
	   $h = "";
	   $b = "bu-current";
	}else{
		$h = "hide";	
		$b = "";
	}
	$cooperationTitle .= "
		<li class='{$b}'>{$array['title']}</li>		
	";	
	$cooperationContent .= "
		<div class='bu-in bg2 fz14 {$h}'>".ArticleMx($array['id'])."</div>
	";
	$x++;
    }
}
?>
<style>
.hide{display:none;}
</style>
<!--头部-->
<div class="header fz16">
    <div class="head-center">	<div class="head-left"><a href="<?php echo getenv("HTTP_REFERER");?>" class="col1"><返回</a></div>
<h3></h3></div>
</div>
<!--内容-->
<div class="bu-content">
	<ul class="bu-nav bg2 fz16 col tc">
    	<?php echo $cooperationTitle;?>
    </ul>
    <div class="bu-co">
    	<?php echo $cooperationContent;?>
    </div>
</div>
<!--底部-->
</body>
<script>
function fn(){
	this.tab();
}
fn.prototype={
	tab:function(){
		var nav = document.querySelector('.bu-nav').getElementsByTagName('li');
		var plane = document.querySelector('.bu-co').getElementsByTagName('div');
		for( var i = 0;i<nav.length;i++ ){
			nav[i].ins = i;
			nav[i].onclick = function(){	
				for( var i = 0;i<nav.length;i++ ){
					plane[i].style.display = "none";
					nav[i].className = "";
				};
				this.className = "bu-current";
				plane[this.ins].style.display = "block";
			}
		}
		
	}		
}
window.onload = function(){	
	new fn();	
}
</script>
</html>
