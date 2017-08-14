<?php
include "../../library/mFunction.php";
UserRoot("m");
$Region = query("region","id = '$kehu[regionId]' ");
echo head("m");
?>
<body>
<div class="m-page">
    <h2 class="clearfix"><a class="fl" href="<?php echo $root?>m/mUser/mUser.php"><</a>我的信息</h2>
    <form name="userForm">
        <div class="wrap">
            <div class="mcdiv mcdiv11">
                <p>登录帐号：<input type="text" name="accountNumber" class="input1" value="<?php echo $kehu['accountNumber'];?>" /></p>
                <p>公司名称：<input type="text" name="companyName" class="input1" value="<?php echo $kehu['companyName'];?>" /></p>
                <p>所属区域：
                    <select name="province" class="select_width"><?php echo RepeatOption("region","province","--省份--",$Region['province']);?></select>
                    <select name="city" class="select_width"><?php echo RepeatOption("region where province = '$Region[province]' ","city","--城市--",$Region['city']);?></select>
                    <select name="area" class="select_width"><?php echo IdOption("region where province = '$Region[province]' and city = '$Region[city]'","id","area","--区县--",$kehu['regionId']);?></select>
                </p>
                <p>详细地址：<input type="text" name="addressMx" class="input1" value="<?php echo $kehu['addressMx'];?>" /></p>
                <p>联系人姓名：<input type="text" name="contactName" class="input1" value="<?php echo $kehu['contactName'];?>" /></p>
                <p>联系人手机号码：<input type="text" name="contactTel" class="input1" value="<?php echo $kehu['contactTel'];?>" /></p>
                <p>登录密码：<input type="text" name="khpas" class="input1" value="<?php echo $kehu['khpas'];?>" /></p>
            </div>
            <a href="#" class="btn" onClick="Sub('userForm','<?php echo root."library/usData.php?type=modifyData";?>')">确认修改</a>
        </div>
    </form>
<div>
</body>
<?php echo warn();?>
<script>
    $(function(){
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
    })
</script>
</html>