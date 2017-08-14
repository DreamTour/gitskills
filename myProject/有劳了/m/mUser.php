<?php 
include "../../library/mFunction.php";
UserRoot("m");
//打印个人资料
$Region = query("region", "id = '$kehu[RegionId]' ");
$personal = query("personal","khid = '$kehu[khid]'");
//判断手持身份证照片
if(empty($kehu['IDCardHand'])){
	$kehu['IDCardHand'] = img("PGI58296514zx");
}else{
	$kehu['IDCardHand'] = $root.$kehu['IDCardHand'];	
}
echo head("m");
?>
<body>
<!--页眉-->
<header id="minetopBox">
	<div class="mine-top clearfix">
    	<a href="<?php echo "{$root}m/mindex.php";?>"><img src="../../img/WebsiteImg/oqX58150379Bb.jpg" class="fl"></a>
        <div class="fr mine-publish"><a href="<?php echo $root;?>m/mUser/mUsIssue.php"><i class="mine-publish-icon"></i><span>发布</span></a></div>
    </div>
    <div class="mine-top2"></div>
    <div class="portrait">
        <img src="<?php echo HeadImg($kehu['sex'],$kehu['ico']);?>" width="90" height="90" onClick='document.headPortraitForm.headPortraitUpload.click()'>
        <p>点击上面图片上传头像</p>
    </div>
</header>
<!--内容-->
<form name="userForm">
<ul class="Mine-content">
	<li class="Mine-content-item"><p><s>*</s>全名</p>
    	<input value="<?php echo $kehu['ContactName'];?>" name="userContactName" type="text" />
    </li>
    <li class="Mine-content-item"><p><s>*</s>性别</p>
    	<?php echo select("userSex","","请选择",array("男","女"),$personal['sex']);?>
    </li>
    <li class="Mine-content-item"><p>身份证号</p>
    	<input value="<?php echo $kehu['IDCard'];?>" name="userIDCard" type="text" class="input-box" placeholder="选填">
    </li>
    <li class="Mine-content-item">
    	<p><s>*</s>出生年月</p>
        <div class="mine-multiple">
        	<?php echo year('year','select_width','',$personal['Birthday']).moon('moon','select_width',$personal['Birthday']).day('day','select_width',$personal['Birthday']);?>
        </div>
    </li>
    <li class="Mine-content-item"><p><s></s>教育程度</p>
    	<input value="<?php echo $personal['EducationLevel'];?>" name="userEducationLevel" type="text" class="input-box" placeholder="选填">
    </li>
    <li class="Mine-content-item">
    	<p>常驻地点</p>
        <div class="mine-multiple">
        	<select name="province" class="select_width"><?php echo RepeatOption("region","province","--省份--",$Region['province']);?></select>
            <select name="city" class="select_width"><?php echo RepeatOption("region where province = '$Region[province]' ","city","--城市--",$Region['city']);?></select>
            <select name="area" class="select_width"><?php echo IdOption("region where province = '$Region[province]' and city = '$Region[city]'","id","area","--区县--",$kehu['RegionId']);?></select>
        </div>
    </li>
    <li class="Mine-content-item"><p><s>*</s>邮箱</p>
    	<input value="<?php echo $kehu['email'];?>" name="userEmail" type="text" class="input-box" />
    </li>
    <li class="Mine-content-item"><p><s>*</s>手机</p>
    	<input value="<?php echo $kehu['ContactTel'];?>" name="userContactTel" type="text" class="input-box" />
    </li>
    <li class="Mine-item-special">
    	<span>手持身份证照片</span>
        <div class="upload-box">
            <a href="javascript:;" class="upload-btn" onClick="document.IDCardHandForm.IDCardHandUpload.click()">点击上传</a>
            <img src="<?php echo $kehu['IDCardHand'];?>">
        </div>
    </li>
    <li class="mine-note"><?php echo website("Gat62449970Xp");?></li>
</ul>
<div class="save-box"><a href="javascript:;" class="save-btn" onClick="Sub('userForm','<?php echo root."library/usdata.php";?>')">保存</a></div>
</form>
<div class="quit-box">退出</div>
<!--隐藏表单开始-->
<div style="display:none;">
    <form name='headPortraitForm' action='<?php echo root."library/uspost.php";?>' method='post' enctype='multipart/form-data'>
        <input name='headPortraitUpload' type='file' onChange='document.headPortraitForm.submit()'>
    </form>
    <form name="IDCardHandForm" action="<?php echo root."library/uspost.php";?>" method="post" enctype="multipart/form-data">
   		<input name="IDCardHandUpload" type="file" onChange="document.IDCardHandForm.submit()">
    </form>
    <form name="kehuSupplyImgForm" action="<?php echo root."library/uspost.php";?>" method="post" enctype="multipart/form-data">
        <input name="kehuSupplyImgUpload" type="file" onChange="document.kehuSupplyImgForm.submit()">
        <input name="SupplyId" type="hidden" value="<?php echo $_GET['supply_id'];?>" />
    </form>
</div>
<!--隐藏表单结束-->
<?php echo mFooter().warn();?>
<script>
$(document).ready(function(){
	var Form = document.userForm;
	//根据省份获取下属城市下拉菜单
	Form.province.onchange = function(){
		Form.area.innerHTML = "<option value=''>--区县--</option>";
		$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostCity:this.value},function(data){
			Form.city.innerHTML = data.city;
		},"json");
	}
	//根据省份和城市获取下属区域下拉菜单
	Form.city.onchange = function(){
		$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostArea:Form.province.value,CityPostArea:this.value},function(data){
			Form.area.innerHTML = data.area;
		},"json");
	}
});
</script>

