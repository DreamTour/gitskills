<?php
include "library/function.php";
//婚礼人查询
$and = "";
if(!empty($_GET['type'])){
    $and = " and Petype = '$_GET[type]' ";
}
$and .= $_SESSION['SearchIndivdual']['Sql'];
$sql = "select * from seller where type = '个人商户' and prove = '已通过' {$and} ";
paging($sql," order by PageView desc",20);
echo head("pc");ThisHeader();
?>
<div id="w-main" class="w-max"> 
<div id="w-1200" class="w-1200"> 
  <!--<div class="hlr-top"> 
    <div class="hlr-top-tit fl">分类</div> 
    <div class="hlr-top-plu fl"> <a href="#" class="current">不限</a> <a href="#">宴会设计师</a> <a href="#">策划师</a> <a href="#">化妆师</a> <a href="#">摄影师</a> <a href="#">摄像师</a> <a href="#">婚礼司仪</a> </div> 
    <div class="clear"></div> 
  </div>--> 
  <div class="hlr-top2"> 
    <div class="hlr-top-tit fl">婚礼人查询</div> 
    <div class="hlr-top-menu fl"> 
      <ul class="hlr-top-menu-li fl"> 
        <li><a class="<?php echo MenuGet("type","","must");?>" href="<?php echo root."IndividualBus.php";?>">全部</a></li> 
		<li><a class="<?php echo MenuGet("type","摄影师","must");?>" href="<?php echo root."IndividualBus.php?type=摄影师";?>">摄影师</a></li> 
        <li><a class="<?php echo MenuGet("type","化妆师","must");?>" href="<?php echo root."IndividualBus.php?type=化妆师";?>">化妆师</a></li> 
        <li><a class="<?php echo MenuGet("type","摄像师","must");?>" href="<?php echo root."IndividualBus.php?type=摄像师";?>">摄像师</a></li> 
        <li><a class="<?php echo MenuGet("type","司仪","must");?>" href="<?php echo root."IndividualBus.php?type=司仪";?>">司仪</a></li> 
        <li><a class="<?php echo MenuGet("type","策划师","must");?>" href="<?php echo root."IndividualBus.php?type=策划师";?>">策划师</a></li>
		<li><a class="<?php echo MenuGet("type","宴会设计师","must");?>" href="<?php echo root."IndividualBus.php?type=宴会设计师";?>">宴会设计师</a></li> 
      </ul> 
    </div> 
    <div class="hlr-top-item fr"> 
	  <form action="<?php echo $root."library/PcPost.php";?>" method="post"> 
        <div class="hlr-top-group fl">
		  按姓名查询&nbsp;
          <input name="IndividualBusBrand" type="text" class="hlr-group-input" style="width:90px;" maxlength="10" value="<?php echo $_SESSION['SearchIndivdual']['Brand'];?>"/> 
          <input type="submit" class="hlr-top-btn" value="确认"/> 
        </div> 
        <!--<div class="hlr-top-group fl"> 共41个商品 </div> 
        <div class="hlr-top-group fl"> 1/4 <a href="#" id="prev">&lt;</a> <a href="#" id="next">&gt;</a> </div> -->
      </form> 
    </div> 
  </div>
  <div style=" float:right;"><?php echo fenye($ThisUrl,7);?></div>
  <div style="clear:both;"></div>
  <div class='w-block'>  
  <?php 
	 while($PersonSeller=mysql_fetch_array($query)){
		 if($PersonSeller['authentication'] == "已认证"){     
			 $authentication = "<img class='IDCard' src='{$root}img/images/IDCard.png'>";
		 }else{
		     $authentication = "";
		 }    
		 $url = root."store.php?seller=".$PersonSeller['seid'];
		 echo "
			<div class='hlr-block'> 
			  <div class='hlr-block-pic fl'> <img  src='".ListImg($PersonSeller['logo'])."'/> </div> 
				  <div class='hlr-block-info fl'> 
					<h3>
						<a href='{$url}'>{$PersonSeller['Brand']}</a>
						{$PersonSeller['Petype']}
						{$authentication}
						<span class='IndividualBusPrice'>报价：￥{$PersonSeller['price']}</span>
					</h3> 
					<p class='summary'>".neirong(zishu($PersonSeller['summary'],100))."</p>
					<p class='Browse'>浏览量：".(100+$PersonSeller['PageView'])."</p>
				  </div>
				  <div class='hlr-block-control fr'><a href='{$url}' class='nextBtn'>档期查询</a> </div> 
				  <div class='hlr-block-control fr'><a class='nextBtn'>我要预订</a> </div> 
			  <div class='clear'></div>
			</div> 
		"; 
	 }
  ?>
  </div> 
  <?php echo fenye($ThisUrl,7);?>
</div>
<?php echo warn();ThisFooter();?>