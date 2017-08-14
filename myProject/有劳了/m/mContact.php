<?php 
include "../library/mFunction.php";
$contact = query("content","id = 'fGU61931621vO' ");
echo head("m");
?>
<!--头部-->
<div class="header fz16">
	<div class="head-left"><a href="<?php echo $root;?>m/mindex.php" class="col1">&lt;返回</a></div>
    <div class="head-center"><h3>联系我们</h3></div>
</div>
<!--内容-->
<div class="activity-details-content">
    <ul class="activity-details-list">
    	<li class="activity-details-item">
            <h2>联系电话</h2>
            <p><?php echo website("rmP61931797aI");?></p>
        </li>
    	<li class="activity-details-item">
        	<h2>联系地址</h2>
            <p><?php echo website("SfJ61931881OJ");?></p>
        </li>
        <li class="activity-details-item">
        	<h2><?php echo $contact['title'];?></h2>
            <?php echo ArticleMx("fGU61931621vO");?>
        </li>
    </ul>
</div>
</body>
</html>
