<?php 
include "../../library/mFunction.php";
UserRoot("m");
//打印个人资料
$Region = query("region", "id = '$kehu[RegionId]' ");
$company = query("company","khid = '$kehu[khid]'");
//判断LOGO
if(empty($kehu['ico'])){
    $kehu['ico'] = img("PGI58296514zx");
}else{
    $kehu['ico'] = $root.$kehu['ico'];
}
//判断营业执照
if(empty($company['BusinessLicenseImg'])){
    $company['BusinessLicenseImg'] = img("PGI58296514zx");
}else{
    $company['BusinessLicenseImg'] = $root.$company['BusinessLicenseImg'];
}
//判断手持身份证照片
if(empty($kehu['IDCardHand'])){
    $kehu['IDCardHand'] = img("PGI58296514zx");
}else{
    $kehu['IDCardHand'] = $root.$kehu['IDCardHand'];
}
echo head("m");
?>
<!--页眉-->
<header id="minetopBox">
	<div class="mine-top clearfix">
    	<a href="<?php echo $root;?>m/mindex.php"><img src="../../img/WebsiteImg/oqX58150379Bb.jpg" class="fl"></a>
        <div class="fr mine-publish"><a href="<?php echo $root;?>m/mUser/mUsIssue.php"><i class="mine-publish-icon"></i><span>发布</span></a></div>
    </div>
    <div class="mine-top2"></div>
    <div class="portrait"><img src="<?php echo $kehu['ico'];?>" width="90" height="90" onClick='document.logoPortraitForm.logoPortraitUpload.click()'><p>有劳了网</p></div>
</header>
<!--内容-->
<form name="sellerForm">
    <ul class="Mine-content">
        <li class="Mine-content-item"><p><s>*</s>联系人全名</p>
            <input value="<?php echo $kehu['ContactName'];?>" name="sellerContactName" type="text" class="input-box input-box01">
        </li>
        <li class="Mine-content-item"><p><s>*</s>单位全称</p>
            <input value="<?php echo $company['CompanyName'];?>" name="sellerCompanyName" type="text" class="input-box input-box01">
        </li>
        <li class="Mine-content-item"><p><s>*</s>法人/负责人全名</p>
            <input value="<?php echo $company['LegalName'];?>" name="sellerLegalName" type="text" class="input-box input-box01">
        </li>
        <li class="Mine-content-item"><p><s>*</s>单位地址</p>
            <div class="mine-multiple">
                <select name="province" class="select_width"><?php echo RepeatOption("region","province","--省份--",$Region['province']);?></select>
                <select name="city" class="select_width"><?php echo RepeatOption("region where province = '$Region[province]' ","city","--城市--",$Region['city']);?></select>
                <select name="area" class="select_width"><?php echo IdOption("region where province = '$Region[province]' and city = '$Region[city]'","id","area","--区县--",$kehu['RegionId']);?></select>
            </div>
        </li>
        <li class="Mine-content-item"><p><s>*</s>法人/负责人身份证号</p>
            <input value="<?php echo $kehu['IDCard'];?>" name="sellerIDCard" type="text" class="input-box input-box01">
        </li>
        <li class="Mine-content-item"><p><s>*</s>营业执照/社会统一信用代码</p>
            <input value="<?php echo $company['BusinessLicense'];?>" name="sellerBusinessLicense" type="text" class="input-box input-box01">
        </li>
        <li class="Mine-content-item"><p><span><s>*</s>邮箱</p>
            <input value="<?php echo $kehu['email'];?>" name="sellerEmail" type="text" class="input-box input-box01">
        </li>
        <li class="Mine-content-item"><p><span><s>*</s>联系手机</p>
            <input value="<?php echo $kehu['ContactTel'];?>" name="sellerContactTel" type="text" class="input-box input-box01">
        </li>
        <li class="Mine-item-special">
            <span>营业执照</span>
            <div class="upload-box">
                <a href="javascript:;" class="upload-btn" onClick="document.BusinessLicenseForm.BusinessLicenseUpload.click()">点击上传</a>
                <img src="<?php echo $company['BusinessLicenseImg'];?>">
            </div>
        </li>
        <li class="Mine-item-special">
            <span>法人手持身份证照片</span>
            <div class="upload-box">
                <a href="javascript:;" class="upload-btn" onClick="document.seIDCardHandForm.seIDCardHandUpload.click()">点击上传</a>
                <img src="<?php echo $kehu['IDCardHand'];?>">
            </div>
        </li>
        <li class="mine-note">注：带*为必填项目。营业执照与人手持身份证照片非必填项，提交资料越全诚信值越高，排名越好。用户基本资料每月仅能修改2次。</li>
    </ul>
    <div class="save-box"><a href="javascript:;" class="save-btn" onClick="Sub('sellerForm','<?php echo root."library/usdata.php";?>')">保存</a></div>
</form>
<!--<div class="quit-box">退出</div>-->
<!--隐藏表单开始-->
<div style="display:none;">
    <form name='logoPortraitForm' action='<?php echo root."library/uspost.php";?>' method='post' enctype='multipart/form-data'>
        <input name='logoPortraitUpload' type='file' onChange='document.logoPortraitForm.submit()'>
    </form>
    <form name="BusinessLicenseForm" action="<?php echo root."library/uspost.php";?>" method="post" enctype="multipart/form-data">
        <input name="BusinessLicenseUpload" type="file" onChange="document.BusinessLicenseForm.submit()">
    </form>
    <form name="seIDCardHandForm" action="<?php echo root."library/uspost.php";?>" method="post" enctype="multipart/form-data">
        <input name="seIDCardHandUpload" type="file" onChange="document.seIDCardHandForm.submit()">
    </form>
    <form name="kehuSupplyImgForm" action="<?php echo root."library/uspost.php";?>" method="post" enctype="multipart/form-data">
        <input name="kehuSupplyImgUpload" type="file" onChange="document.kehuSupplyImgForm.submit()">
        <input name="SupplyId" type="hidden" value="<?php echo $_GET['supply_id'];?>" />
    </form>
</div>
<!--隐藏表单结束-->
<!--底部-->
<?php echo mFooter().warn();?>
<script>
    $(document).ready(function(){
        var Form = document.sellerForm;
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
