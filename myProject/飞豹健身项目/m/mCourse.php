<?php
include "mLibrary/mFunction.php";

echo head("m");
?>
<style>
    .lbcx{padding:3%;padding-bottom:0;font-size:2em;overflow:hidden;}
    .lbcx select{font-size:1em;width:33%;float:left;margin-right:3%;height:2em;}
    .lbcx a{display:block;width:28%;float:right;line-height:2em;text-align:center;background:#fddc0a;color:#000;border-radius:0.5em;}
</style>
<!--顶部查询开始-->
<h3 class="mCourse-title"><?php echo website("Qyb70309742TZ");?></h3>
<div class="lbcx">
    <form name="searchForm">
        <?php echo IDSelect("CourseOne where xian = '显示' order by list ","searchCourseOne","","id","name","--课程分类--","");?>
        <select name="searchCourseName">
            <option value="">--课程名称--</option>
        </select>
    </form>
    <a href="javascript:;" id="searchCourseButton">查询</a>
</div>
<!--顶部查询结束-->
<div class="ploading">
    <div class="load-container load">
        <div class="loader">Loading...</div>
    </div>
</div>
<div class="wrap">
    <?php
    $sql = mysql_query("select * from CourseOne where xian = '显示' order by list ");
    while($array = mysql_fetch_assoc($sql)){
        $num = mysql_num_rows(mysql_query(" select * from Course as C,CourseRecord as CR where C.CourseOneId = '$array[id]' and CR.CourseId = C.id "));
        echo "
	<div class='kcsydiv1'>
	   <a href='{$root}m/mCourseList.php?id={$array['id']}'>
		<img src='{$root}{$array['ico']}' />
		<div class='kcsydiv2'><span>{$array['name']}</span><span>{$num}人参与</span></div>
	   </a>
	</div>
	";
    }
    ?>
</div>
<?php echo footer();?>
</body>
</html>
<script>
    $(document).ready(function(){
        //根据课程分类获取课程名称
        var form = document.searchForm;
        form.searchCourseOne.onchange = function(){
            $.post(root + 'm/mLibrary/mData.php?type=mCourseOne', {oid:this.value}, function(data) {
                form.searchCourseName.innerHTML = data.name;
            },'json');
        }
        //点击搜索按钮时跳转到对应课程
        $("#searchCourseButton").click(function(){
            var id = form.searchCourseName.value;
            if(id == ""){
                var typeId = form.searchCourseOne.value;
                document.location.href = root + "m/mCourseList.php?id=" + typeId;
            }else{
                document.location.href = root + "m/mCourseMx.php?id=" + id;
            }
        });
    });
</script>
</script>