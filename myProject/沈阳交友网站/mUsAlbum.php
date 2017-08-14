<?php
include "../mLibrary/mFunction.php";
echo head("m");
UserRoot("m");
//个人中心我的相册图片循环
$imgSql = mysql_query("select * from kehuImg where khid = '$kehu[khid]' order by time desc");
$img = "";
while($array = mysql_fetch_array($imgSql)){
	$img .= "<li data-id={$array['id']}><img src='{$root}{$array['src']}'></li>";	
}
?>
<style>
.hide{ display:none;}
.shade img{ width:100%;}
.shade{ position:fixed; top:0; left:0; bottom:0; right:0; background: rgba(33,33,33,.9); display:-webkit-box; -webkit-box-align:center; -webkit-box-pack:center; color:#fff; z-index:999;}
.shade_content{ margin:0 5%; width:90%;}
.shade_back{position: absolute;
    top: 5%;
    left: 10%;
    font-size: 20px;}
[data-delete]{position: absolute;
    bottom: 5%;
    left: 41%;
    font-size: 20px;}
</style>
<!--头部-->
<div class="header fz16">
	<div class="head-left"><a href="<?php echo $root;?>m/user/mUser.php" class="col1">&lt;返回</a></div>
    <div class="head-center"><h3>我的相册</h3></div>
</div>
<!--我的-->
<div class="photo-content">
    <?php echo my_top();?>
    <div class="photo-top-nav bg2">
    	<p class="fz16"><a href="javascript:;"><i class="my-icon-top my-icon1"></i><span>我的相册</span></a></p>
        <p class="fz16"><a href="<?php echo $root;?>m/user/mUsGift.php"><i class="my-icon-top my-icon2"></i><span>我的礼物</span></a></p>
    </div>
    <ul class="photo-co bg2">
        <li><img onClick="document.kehuAlbumForm.kehuAlbumUpload.click()" src="<?php echo $root;?>img/WebsiteImg/gym54493039OB.jpg"></li>
        <!--隐藏表单开始-->
            <div class="hide">
                <form name="kehuAlbumForm" action="<?php echo root."library/usPost.php";?>" method="post" enctype="multipart/form-data">
                	<input name="kehuAlbumUpload" type="file" onChange="document.kehuAlbumForm.submit()">
                </form>
            </div>
			<!--隐藏表单结束-->
        <?php echo $img;?>
    </ul>
</div>
<div class="shade hide">
    <div class="shade_content">
        <img src="<?php echo "{$root}img/ClientAlbum/jYf54841840De.jpg";?>" />
    </div>
    <div data-delete>删除图片</div>
</div>
</body>
<?php echo warn();?>
<script>
	$(function(){
		$('.shade').hide();
		$('[data-id]').click(function(){
			$('.shade').show();	
			var src = $(this).find('img').attr('src');
			var id = $(this).attr('data-id');
			$('.shade_content').find('img').attr('src',src);
			$('[data-delete]').attr('data-delete',id);
		})
		$('.shade').click(function(){
			$(this).hide();	
		})
		$('[data-delete]').click(function(ev){
			ev.stopPropagation();
			var deletePhotoImg = $(this).attr('data-delete');
			$.ajax({
				type:"GET",
				url:"<?php echo "{$root}library/usData.php";?>",
				data:{deletePhotoImg:deletePhotoImg},
				dataType:"json",
				success: function(data){
					if(data.warn == 2){
						window.location.reload();
					}else{
				    	warn(data.warn);
					}
				},
				error: function(){
					alert('服务器错误');	
				}	
			})	
		})	
	})
</script>
</html>
