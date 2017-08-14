<?php
include "../library/mFunction.php";
if (empty($get['id'])) {
    header("Location:{$root}m/mTourRecommend.php");
    exit();
}else{
    $id = $get['id'];
    $tourism = query("content","id = '$id' and xian='显示' ");
    if (empty($tourism['id'])) {
        header("Location:{$root}m/mTourRecommend.php");
        exit();
    }else{
        $content = ArticleMx($tourism['id']);
        //验证文章是否为空
        if (empty($content)) {
            $content = "暂无文章内容";
        }
    }
}
echo head("m");
?>
<!--头部-->
<div class="header header-fixed">
    <div class="nesting"> <a href="<?php echo root;?>m/mTour.php" class="header-btn header-return"><span class="return-ico">&#xe600;</span></a>
        <div class="align-content">
            <p class="align-text"><?php echo $tourism['title']; ?></p>
        </div>
        <a href="#" class="header-btn"></a>
    </div>
</div>
<!--//-->
<div class="container mui-ptop45 mui-mbottom60">
    <div class="tourism-mx">
        <!-- 正文内容 -->
        <?php echo $content;?>
        <div class="question">
            <form name="questionForm">
                <ul>
                    <li>
                        <h3><?php echo $tourism['question'];?></h3>
                        <?php echo radio("answer",explode("，", $tourism['answer']),$tourism['answer']);?>
                    </li>
                </ul>
                <input name="contentId" type="hidden" value="<?php echo $id;?>">
                <input type="button" id="questionBtn" value="立即提交" class="question-btn" onclick="Sub('questionForm','<?php echo "{$root}library/mData.php?type=question";?>')">
            </form>
        </div>
    </div>
</div>
<!--底部-->
<?php echo mWarn().Footer(); ?>
<!--//-->
<script>
    $(function(){
        /***********************导航栏变色****************************/
        changeNav();
    });
</script>
</body>
</html>