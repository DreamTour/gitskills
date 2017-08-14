<?php
require_once("../library/PcFunction.php");
if($KehuFinger == 1){
	header("location:{$root}user/user.php");
	exit(0);
}
//确认性别
if(isset($_GET['sex'])){
	if($_GET['sex'] == "男"){
	    $man = "checked";
		$woman = "";	
	}elseif($_GET['sex'] == "女"){
	    $man = "";
		$woman = "checked";	
	}else{
	    $man = "";
		$woman = "";	
	}
}
//确认婚姻状况
if(isset($_GET['marry'])) {
	if($_GET['marry'] == "未婚") {
		$unmarried = "checked";
		$divorce = $widowed = "";
	}elseif($_GET['marry'] == "离婚") {
		$unmarried = $widowed = "";	
		$divorce = "checked";
	}elseif($_GET['marry'] == "丧偶") {
		$unmarried = $divorce = "";
		$widowed = "checked";	
	}else{
		$unmarried = $divorce = $widowed = "";	
	}	
}
echo head("pc");
?>
<style>
/***注册*****/
*{margin:0;padding:0;font-size:12px;color:#666;font-family:Microsoft YaHei;box-sizing:border-box}
li,ol,ul{list-style:none}
a{text-decoration:none}
i{display:inline-block}
i,s{text-decoration:none}
input{border:none;outline:0}
select{outline:0}
h1,h2,h3,h4,h5,h6{font-style:normal}
h1{display:inline-block}
form,select{display:inline}
img{border:none}
.icon{background-image:url(images/icon.png)}
.activity_icon{background-image:url(images/activity_icon.png)}
.fl{float:left}
body{background-color:#f6f6f6}
.logo{margin:20px 250px}
.register{width:670px;margin:auto;background-color:#fff;margin-top:15px;padding-bottom:70px}
.select_content,.select_content01{position:relative;padding-left:110px;margin-bottom:20px;line-height:30px}
.select_content span,.select_content01 span{font-size:14px;margin-right:5px}
.select_content h1,.select_content01 h1{display:inline;font-size:14px;margin-left:20px;width:70px;position:absolute;left:0;top:2px;text-align:right}
.select_box{padding-left:20px}
.select_content select,.select_content textarea,.select_content01 select,.select_text{border:1px solid #ddd;margin-right:5px;padding-left:5px}
.select_content select,.select_text{width:225px;padding:5px}
#select_special{width:110px}
.phone_code{display:inline-block;width:106px;text-align:center;border:1px solid #ddd}
.select_content01 select{width:120px;height:30px;line-height:30px}
.select_content textarea{width:400px;height:200px;padding:5px}
.free_reg{display:inline-block;width:225px;padding:15px 18px;background:#ff536a;font-size:20px;color:#fff;margin-left:130px;text-align:center;border-radius:2px;margin-bottom:10px}
.agree input{margin-top:2px}
.agree,.promise{margin:20px 130px}
.agree a{text-decoration:underline}
.agree span,.promise{color:#888}
</style>
<div class="register">
    	<img src='<?php echo img("ULa49857883GM");?>' class="logo">
        <div style="clear:both"></div>
        <form name="usRegisterForm">
            <div class="select_box">
                 <div class="select_content">
                    <h1>性别</h1>
                    <input type="radio" name="sex" value="男" <?php echo $man;?>><span>男</span>
                    <input type="radio" name="sex" value="女" <?php echo $woman;?>><span>女</span>
                 </div>
                 <div class="select_content01">
                    <h1>生日</h1>
                     <?php echo year('year','','').moon('moon','').day('day','');?>
                 </div>
                 <div class="select_content01">
                    <h1>所在地区</h1>
                    <select name="province"><?php echo RepeatSele("region","province","--省份--");?></select>
                    <select name="city"><?php echo RepeatSele("region where province = '$_GET[province]' ","city","--城市--");?></select>
                    <select name="area"><?php echo IDSele("region where province = '$_GET[province]' and city = '$_GET[city]'","id","area","--区县--");?></select>
                 </div>
                 <div class="select_content">
                    <h1>婚姻状况</h1>
                    <label><input type="radio" name="marry" value="未婚" <?php echo $unmarried;?>><span>未婚</span></label>
                    <label></label><input type="radio" name="marry" value="离婚" <?php echo $divorce;?>><span>离婚</span></label>
                    <label><input type="radio" name="marry" value="丧偶" <?php echo $widowed;?>><span>丧偶</span></label>
                 </div>
                 <div class="select_content">
                     <h1>身高：</h1>
                     <select name="height">
                        <option value="">请选择</option>
                        <option value="150cm及以下">150cm及以下</option>
                        <option value="150-155cm">150-155cm</option>
                        <option value="160-165cm">160-165cm</option>
                        <option value="165-170cm">165-170cm</option>
                        <option value="170-175cm">170-175cm</option>
                        <option value="175-180cm">175-180cm</option>
                        <option value="180-185cm">180-185cm</option>
                        <option value="185-190cm">185-190cm</option>
                        <option value="190cm及以上">190cm及以上</option>
                     </select>
                 </div>
                 <div class="select_content">
                     <h1>学历：</h1>
                     <select name="education">
                        <option value="">请选择</option>
                        <option value="高中及以下">高中及以下</option>
                        <option value="大专">大专</option>
                        <option value="本科">本科</option>
                        <option value="硕士">硕士</option>
                        <option value="博士及以上">博士及以上</option>
                     </select>
                 </div>
                 <div class="select_content">
                     <h1>月薪：</h1>
                     <select name="month_money">
                        <option value="">请选择</option>
                        <option value="2000元及以下">2000元及以下</option>
                        <option value="2000-5000元">2000-5000元</option>
                        <option value="5000-10000元">5000-10000元</option>
                        <option value="10000-20000元">10000-20000元</option>
                        <option value="20000元及以上">20000元及以上</option>
                     </select>
                 </div>
                 <div class="select_content">
                     <h1>手机号</h1>
                     <input name="usRegisterTel" class="select_text" type="text"></input>
                 </div>
                 <div class="select_content">
                     <h1>验证码</h1>
                     <input name="verificationCode" class="select_text" id="select_special" type="text"></input>
                     <a href="javascript:;" id="RegisterProve" class="phone_code">获取验证码</a>
                 </div>
                 <div class="select_content">
                     <h1>创建密码</h1>
                     <input name="usRegisterPassword" class="select_text" type="password"></input>
                 </div>
                 <div class="select_content">
                     <h1>确认密码</h1>
                     <input name="trueusRegisterPassword" class="select_text" type="password"></input>
                 </div>
                 <div class="select_content">
                     <h1>昵称</h1>
                     <input name="usRegisterNickName" class="select_text" type="text"></input>
                 </div>
                 <div class="select_content">
                     <h1>内心独白</h1>
                     <textarea name="summary"></textarea>
                 </div>
           </div>
           <a class="free_reg" href="javascript:;" onClick="Sub('usRegisterForm','<?php echo root."library/PcData.php";?>')">免费注册</a>
      
     <div class="agree">
         <input name="agree" type="checkbox" value="yes">
         <span>我同意</span>
         <a href="clause.html">注册条款</a>
         <span>和</span>
         <a href="disclaimer.html">免责声明</a>
     </div>
     <span class="promise">我承诺年满18岁、单身、抱着严肃的态度，真诚寻找另一半</span>
     </form>
</div>     
<?php echo warn();?>
</body>
</html>
<script>
$(document).ready(function(){
	//根据省份获取下属城市下拉菜单
	document.usRegisterForm.province.onchange = function(){
		document.usRegisterForm.area.innerHTML = "<option value=''>--区县--</option>";
		$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostCity:this.value},function(data){
			document.usRegisterForm.city.innerHTML = data.city;
		},"json");
	}
	//根据省份和城市获取下属区域下拉菜单
	$(document).on("change","[name=usRegisterForm] [name = city]",function(){
	    $.post("<?php echo root."library/OpenData.php";?>",{ProvincePostArea:document.usRegisterForm.province.value,CityPostArea:this.value},function(data){
			document.usRegisterForm.area.innerHTML = data.area;
		},"json");
	});
	//发送验证码
	$("#RegisterProve").click(function(){
	    $.post("<?php echo "{$root}library/OpenData.php";?>",{RegisterCheckTel:document.usRegisterForm.usRegisterTel.value},function(data){
		    warn(data.warn);
		},"json");
	});
	//显示从index.php传送过来在生日和地区
	<?php
	echo
	KongSele("usRegisterForm.year",$_GET['year']).
	KongSele("usRegisterForm.moon",$_GET['moon']).
	KongSele("usRegisterForm.day",$_GET['day']).
	KongSele("usRegisterForm.province",$_GET['province']).
	KongSele("usRegisterForm.city",$_GET['city']).
	KongSele("usRegisterForm.area",$_GET['area']);
	?>
});

</script>