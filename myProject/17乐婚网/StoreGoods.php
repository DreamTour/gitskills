<?php 
include "library/function.php";
$ThisUrl = $root."StoreGoods.php?seller=".$_GET['seller'];
StoreID();echo head("pc");ThisHeader();
?>
<div class="column">
	<?php StoreHead($seller);?>
	<!--商品列表开始-->
	<?php
	$GoodsSql = mysql_query("select * from goods where sellerid = '$_GET[seller]' order by time desc ");
	$GoodsNum = mysql_num_rows($GoodsSql);
	?>
	<div class="AlbumTitle">
		所有商品
		<span class="FloatRight">共<?php echo $GoodsNum;?>个商品</span>
	</div>
	<div class="kuang" style="min-height:552px;">
		<?php
		if($GoodsNum > 0){
			echo "<ul class='GoodsListUl'>";
			while($goods = mysql_fetch_array($GoodsSql)){
				echo "
				<a href='{$root}goodsmx.php?seller={$_GET['seller']}&goods={$goods['id']}'>
				<li>
					<div class='GoodsIcoDiv'>
						<img src='".ListImg($goods['ico'],"seller/")."'>
					</div>
					<p class='GoodsPrice'>
						￥{$goods['price']}&nbsp;&nbsp;
						<s class='smallword'>￥{$goods['MarketPrice']}</s>
					</p>
					<p class='GoodsName'>".zishu($goods['name'],20)."</p>
				</li>
				</a>
				";
			} 
			echo "</ul>";
		}else{
			echo "一个商品都没有";
		}
		?>
		<div class="clear"></div>
	</div>
	<!--商品列表结束-->
</div>
<?php 
echo warn();
ThisFooter();
?>