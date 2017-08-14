<?php
include "mLibrary/mFunction.php";
echo head("m");
UserRoot("m");
$id = $_GET['mActivity_id'];
$mActivityMx = mysql_fetch_assoc(mysql_query("select * from content where id = '$id' ")); 
if(empty($mActivityMx['id'])){
	header("Location:{$root}m/mActivity.php");
	exit(0);
}
$enrollNum = mysql_num_rows(mysql_query("select * from Enroll where khid = '$kehu[khid]' and ContentId = '$mActivityMx[id]' "));
if($enrollNum > 0){
	$buttonValue = "取消报名";
	$buttonBackground = "style='background:#999;'";		
}else{
	$buttonValue = "立即报名";
	$buttonBackground = "";	
}	
?>
<!--头部-->
<div class="header fz16">
    <div class="head-center">	<div class="head-left"><a href="<?php echo $root;?>m/mActivity.php" class="col1"><返回</a></div>
</div>
</div>
<!--内容-->
<div class="activity-details-content">
	<img src="<?php echo "{$root}{$mActivityMx['ico']}";?>">
    <ul class="activity-details-list">
    	<li class="activity-details-item">
            <h2>活动名称</h2>
            <p><?php echo $mActivityMx['title'];?></p>
        </li>
    	<li class="activity-details-item">
        	<h2>活动时间</h2>
            <p><?php echo $mActivityMx['DepartDay'];?></p>
        </li>
        <li class="activity-details-item">
        	<h2>活动地址</h2>
            <p><?php echo $mActivityMx['address'];?></p>
        </li>
        <li class="activity-details-item">
        	<h2>活动内容</h2>
            <p><?php echo $mActivityMx['summary'];?></p>
        </li>
    </ul>
    <div class="su-btn-box"><a href="javascript:;" <?php echo $buttonBackground?> class="su-btn fz16 col1 fw2" signUp=<?php echo $mActivityMx['id']?>><?php echo $buttonValue?></a></div>
</div>
</body>
<?php echo warn();?>
<script>
	$(function(){
		/*$("[signUp]").click(function(){
			var signUp = $(this).attr("signUp");
			$.ajax({
				url:"<?php echo root."m/mLibrary/mUsData.php";?>",
				async:true,
				type:"GET",
				data:{signUp:signUp},
				dataType:"json",
				success: function(data){
					warn(data.warn);
					if(data.warn == "报名成功"){
						$("[signUp="+signUp+"]").html("取消报名").css("background","#999");
					}else if(data.warn == '取消成功'){
						$("[signUp="+signUp+"]").html("立即报名").css("background","#ff7f00");
					}
				},
				error: function(){
					alert("服务器错误");
				}
			})
		})*/
		//立即报名
		$("[signUp]").click(function(){
			var signUp = $(this).attr('signUp');
			$.post("<?php echo root."library/usData.php";?>",{signUp:signUp},function(data){
				warn(data.warn);
				if(data.warn == "报名成功"){
					$("[signNum="+signUp+"]").html(data.num);
					$("[signUp="+signUp+"]").html("取消报名").css("background","#999");	
				}else if(data.warn == '取消成功'){
					$("[signNum="+signUp+"]").html(data.num);
					$("[signUp="+signUp+"]").html("立即报名").css("background","#ff7c7c");	
				}
			},"json");		
		})
	})
</script>
</html>
