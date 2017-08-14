<?php
include "mLibrary/mFunction.php";
$id = $get['id'];
if(!empty($id)){
    $course = query("Course"," id = '$id' ");
    if(empty($course['id'])){
        header("Location:{$root}m/mCourse.php");
        exit(0);
    }
    mysql_query(" insert into CourseRecord (id,khid,CourseId,time) values('".suiji()."','$kehu[khid]','$course[id]','$time') ");
}else{
    header("Location:".getenv("HTTP_REFERER"));
    exit(0);
}
//判断视频
if(empty($course['VideoUrl'])){
    $video = "";
}else{
    $video = "<iframe style='width:100%;' src='{$course['VideoUrl']}' frameborder=0 'allowfullscreen'></iframe>";
}
echo head("m");
?>
<div class="wrap">
    <?php echo $video;?>
    <div class="spdiv1 wrap-box">
        <div class="title"><h3><i class='icon'>&#xe6d8;</i> 健身部位</h3></div>
        <div class="content">
            <?php
            echo $course['Position'];
            $sql = mysql_query("select * from CourseImg where CourseId = '$id' order by time ");
            if(mysql_num_rows($sql) > 0){
                while($array = mysql_fetch_assoc($sql)){
                    echo "<p class='spdiv1p'><img src='{$root}{$array['img']}' /></p>";
                }
            }
            ?>
        </div>
    </div>
    <div class="spdiv2 wrap-box">
        <div class="title"><h3><i class='icon'>&#xe6ad;</i> 动作要领</h3></div>
        <div class="content">
            <?php echo $course['Skill'];?>
        </div>
    </div>
    <div class="spdiv3 wrap-box">
        <div class="title"><h3><i class='icon'>&#xe683;</i> 注意事项</h3></div>
        <div class="content">
            <?php echo $course['Hint'];?>
        </div>
    </div>
</div>
<?php echo footer();?>
</body>
</html>