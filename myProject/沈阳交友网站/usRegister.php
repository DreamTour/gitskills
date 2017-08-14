<?php
include "../library/PcFunction.php";
echo head("pc");
if($KehuFinger == 1){
	header("location:{$root}user/user.php");
	exit(0);	
}
?>
<style>
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
.logo{margin:20px 165px}
.register{width:670px;margin:auto;background-color:#fff;margin-top:15px;padding-bottom:70px}
.select_content,.select_content01{position:relative;padding-left:110px;margin-bottom:20px;line-height:30px}
.select_content span,.select_content01 span{font-size:14px;margin-right:5px}
.select_content h1,.select_content01 h1{display:inline;font-size:14px;margin-left:20px;width:70px;position:absolute;left:0;top:2px;text-align:right}
.select_box{padding-left:20px}
.select_content select,.select_content textarea,.select_content01 select,.select_text{border:1px solid #ddd;margin-right:5px;padding-left:5px}
.select_content select,.select_text{width:225px;padding:5px}
#select_special{width:110px}
.phone_code{display:inline-block;width:106px;text-align:center;border:1px solid #ddd}
.select_content01 select{width:70px;height:30px;line-height:30px}
.select_content textarea{width:400px;height:200px;padding:5px}
.free_reg{display:inline-block;width:225px;padding:15px 18px;background:#ff7c7c;font-size:20px;color:#fff;margin-left:130px;text-align:center;border-radius:2px;margin-bottom:10px}
.agree input{margin-top:2px}
.agree,.promise{margin:20px 130px}
.agree a{text-decoration:underline}
.agree span,.promise{color:#888}
</style>
	<form name="usRegisterForm">
    <div class="register">
    	<img src="<?php echo img("EeZ53378297Yq");?>" class="logo">
        <div class="select_box">
            <div class="select_content">
                <h1>性别</h1>
                <input type="radio" name="sex" value="男" /><span>男</span>
                <input type="radio" name="sex" value="女" /><span>女</span>
            </div>
            <div class="select_content01">
                <h1>生日</h1>
                <?php echo year('year','','').moon('moon','').day('day','');?>
            </div>
            <div class="select_content01">
                <h1>所在地区</h1>
                <select name="province"><?php echo RepeatOption("region where province = '辽宁省'","province","--省份--","辽宁省");?></select>
                <select name="city"><?php echo RepeatOption("region where province = '辽宁省' and city = '沈阳市' ","city","--城市--","沈阳市");?></select>
                <select name="area"><?php echo IdOption("region where province = '辽宁省' and city = '沈阳市'","id","area","--区县--","");?></select>
            </div>
            <div class="select_content">
                <h1>婚姻状况</h1>
                <input type="radio" name="marry" value="未婚" /><span>未婚</span>
                <input type="radio" name="marry" value="离婚" /><span>离婚</span>
                <input type="radio" name="marry" value="丧偶" /><span>丧偶</span>
            </div>
            <div class="select_content">
                 <h1>分享码</h1>
                 <input name="shareCode" class="select_text" type="text" placeholder="请输入邀请人分享码 没有可以不填" value="<?php echo $_GET['ShareCode'];?>" />
                 <span>(选填)</span>
             </div>
             <div class="select_content">
                 <h1>手机号</h1>
                 <input name="phone" class="select_text" type="text" />
             </div>
             <div class="select_content">
                 <h1>验证码</h1>
                 <input name="verificationCode" class="select_text" id="select_special" type="text" />
                 <a href="javascript:;" id="verificationCode" class="phone_code">获取验证码</a>
             </div>
             <div class="select_content">
                 <h1>创建密码</h1>
                 <input name="password" class="select_text" type="password" />
             </div>
             <div class="select_content">
                 <h1>确认密码</h1>
                 <input name="truePassword" class="select_text" type="password" />
             </div>
             <div class="select_content">
                 <h1>微信名</h1>
                 <input name="nickName" class="select_text" type="text" />
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
         <a href="<?php echo root."clause.php";?>">注册条款</a>
         <span>和</span>
         <a href="<?php echo root."declare.php";?>">隐私保护</a>
     </div>
     <span class="promise">我承诺年满18岁、单身、抱着严肃的态度，真诚寻找另一半</span>
	</div>
    </form>
<?php echo warn();?>  
</body>
</html>
<script>
	$(function(){
		//根据省份获取下属城市下拉菜单基本资料
		$(document).on('change','[name=usRegisterForm] [name=province]',function(){
			$('[name=usRegisterForm] [name=area]').html("<option value=''>--区域--</option>");	
			$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostCity:$(this).val()},function(data){
				$('[name=usRegisterForm] [name=city]').html(data.city);		
			},"json");	
		})
		//根据省份和城市获取下属区域下拉菜单基本资料
		$(document).on('change','[name=usRegisterForm] [name=city]',function(){
			$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostArea:$('[name=usRegisterForm] [name=province]').val(),
			CityPostArea:$(this).val()},function(data){
				$('[name=usRegisterForm] [name=area]').html(data.area);
			},"json");	
		})
		//获取验证码
		$('#verificationCode').click(function(){
			$.post("<?php echo "{$root}library/OpenData.php";?>",{RegisterCheckTel:$('[name=usRegisterForm] [name=phone]').val()},function(data){
				warn(data.warn);
			},"json")	
		})
	})
</script>
