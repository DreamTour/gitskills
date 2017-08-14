<?php
include "mLibrary/mFunction.php";
$id = $get['id'];
if(empty($id)){
    header("location:{$root}m/mCourse.php");
    exit(0);
}
echo head("m");
?>
<div class="ploading">
    <div class="load-container load">
        <div class="loader">Loading...</div>
    </div>
</div>
<div class="wrap">
    <div class="fbdiv2 wrap-box"><br>
        <ul>
            <?php
            $sql = mysql_query("select * from Course where CourseOneId = '$id' and xian = '显示' order by list desc ");
            if(mysql_num_rows($sql) == 0){
                echo "<li>一条记录也没有</li>";
            }else{
                while($array = mysql_fetch_array($sql)){
                    echo "
			<li>
				<div class='fbd2left'>
				    <i class='play-icon'>&#xe600;</i>
				    <a href='{$root}m/mCourseMx.php?id={$array['id']}'><img src='{$root}{$array['ico']}' alt='{$array['name']}' /></a>
			    </div>
				<div class='fbd2right'>
					<a href='{$root}m/mCourseMx.php?id={$array['id']}'>{$array['name']}</a>
					".$array['summary']."
				</div>
			</li>
			";
                }
            }
            ?>
        </ul>
    </div>
</div>
<?php echo footer();?>
</body>
</html>