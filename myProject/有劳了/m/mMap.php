<?php
include "../library/mFunction.php";
$about = query("content","id = 'lhd63679544uq' ");
echo head("m");
?>
<!--头部-->
<div class="header fz16">
	<div class="head-left"><a href="<?php echo $root;?>m/mindex.php" class="col1">&lt;返回</a></div>
	<div class="head-center"><h3>关于我们</h3></div>
</div>
<!--内容-->
<div class="activity-details-content">
	<ul class="activity-details-list">
		<li class="activity-details-item">
			<h2><?php echo $about['title'];?></h2>
			<?php echo ArticleMx("lhd63679544uq");?>
		</li>
	</ul>
</div>
</body>
</html>
