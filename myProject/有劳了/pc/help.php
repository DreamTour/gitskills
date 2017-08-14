<?php 
include "library/PcFunction.php";
$contact = query("content","id = 'fGU61931621vO' ");
$about = query("content","id = 'lhd63679544uq' ");
$law = query("content","id = 'ZyV61931716sj' ");
if(isset($_GET['type'])) {
	if ($_GET['type'] == "contact") {
		$ThisUrl .= "?type=contact";
		$number = 1;
	}
	else if ($_GET['type'] == "about") {
		$ThisUrl .= "?type=about";
		$number = 2;
	}
	else if ($_GET['type'] == "law") {
		$ThisUrl .= "?type=law";
		$number = 3;
	}
	else {
		$ThisUrl .= "?type=contact";
		$number = 1;
	}
}else{
	header("location:{$ThisUrl}?type=contact");
	exit(0);
}
echo head("pc").pcHeader();
?>
<!--内容-->
<div class="info-container"> 
   <!--导航-->
    <?php echo pcNavigation();?>
    <!--row-->
    <div class="row">
        <!--广告-->
        <div class="info-ad"><a href="javascript:;"><img src="<?php echo img("RCV57016301qE");?>"></a></div>
        <!--联系我们/网站地图/法律声明-->
        <div class="bottom-box clearfix">
            <ul id="bottomBtn">
                <li class="<?php echo MenuGet("type","contact","bottomActive");?>" data-show-num="1"><a href="<?php echo root."help.php?type=contact";?>">联系我们</a></li>
                <li class="<?php echo MenuGet("type","about","bottomActive");?>" data-show-num="2"><a href="<?php echo root."help.php?type=about";?>">关于我们</a></li>
                <li class="<?php echo MenuGet("type","law","bottomActive");?>" data-show-num="3"><a href="<?php echo root."help.php?type=law";?>">法律声明</a></li>
            </ul>
            <ul id="bottomContent">
            	<li data-show-num="1" class="hide">
                	<h2 style="text-align: center; padding-bottom: 15px;font-weight: normal;"><?php echo $contact['title'];?></h2>
                    <?php echo ArticleMx("fGU61931621vO");?>
                </li>
                <li data-show-num="2" class="hide">
					<h2 style="text-align: center; padding-bottom: 15px;font-weight: normal;"><?php echo $about['title'];?></h2>
					<?php echo ArticleMx("lhd63679544uq");?>
                </li>
                <li data-show-num="3" class="hide">
                	<h2 style="text-align: center; padding-bottom: 15px;font-weight: normal;"><?php echo $law['title'];?></h2>
                	<?php echo ArticleMx("ZyV61931716sj");?>
                </li>
            </ul>
        </div>
   </div>
<!--页脚-->
<script>
	$('[data-show-num=<?php echo $number;?>]').show();
/*window.onload=function(){
	var bottomBtn=document.querySelectorAll("#bottomBtn li"),
		bottomContent=document.querySelectorAll("#bottomContent li");
		for(i=0;i<bottomBtn.length;i++){
			bottomBtn[i].index=i;
			bottomBtn[i].onclick=function(){
				for(i=0;i<bottomBtn.length;i++){
					bottomBtn[i].className="";
					bottomContent[i].style.display="none";
				};
				this.className="bottomActive";
				bottomContent[this.index].style.display="block";
				showmap();
			}
		}
}*/
</script>
<?php echo pcFooter().warn();?>

