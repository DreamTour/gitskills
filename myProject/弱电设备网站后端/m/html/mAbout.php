<?php
include "../library/mFunction.php";
$article = query("content", "id = 'hBO65751498kf' ");
echo head("m").mHeader();
;?>
<div class="mAbout">
    <h3><?php echo $article['title'];?></h3>
    <p><?php echo ArticleMx("hBO65751498kf");?></p>
</div>
<?php echo mFooter().mNav().warn();?>
</body>
</html>