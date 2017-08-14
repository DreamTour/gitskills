<?php
include "../library/mFunction.php";
//获取id显示不同的文章
$dynamic = query("content", "id = '$_GET[id]' ");
echo head("m").mHeader();
;?>
<div class="mAbout">
    <h3><?php echo $dynamic['title'];?></h3>
    <p><?php echo ArticleMx($dynamic['id']);?></p>
</div>
<?php echo mFooter().mNav().warn();?>
</body>
</html>