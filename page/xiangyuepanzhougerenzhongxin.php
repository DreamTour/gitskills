<?php
require_once("../library/PcFunction.php");
UserRoot("pc");
$ThisUrl = root."user/user.php";
if(isset($_GET['type'])){
	if($_GET['type'] == "basicData"){
		$and = " and classify = '基本资料' ";	
		$ThisUrl .= "?type=basicData";
		$num = 1;
	}elseif($_GET['type'] == "myAlbum"){
		$and = " and classify = '我的相册' ";	
		$ThisUrl .= "?type=myAlbum";
		$num = 2;
	}elseif($_GET['type'] == "InnerMonologue"){
		$and = " and classify = '内心独白' ";	
		$ThisUrl .= "?type=InnerMonologue";
		$num = 3;
	}elseif($_GET['type'] == "spouseIntention"){
		$and = " and classify = '择偶意向' ";	
		$ThisUrl .= "?type=spouseIntention";
		$num = 4;
	}else{
		$and = " and classify = '基本资料' ";	
		$ThisUrl .= "?type=basicData";
		$num = 1;
	} 
}else{
	header("location:{$ThisUrl}?type=basicData");
	exit(0);
}
/*********************************我的相册图片循环*********************************************************/
$Sql = mysql_query(" select * from kehuImg where khid = '$kehu[khid]' order by time desc ");
$img = "";
while($array = mysql_fetch_array($Sql)){
	$img .= "<a target='_blank' href='{$root}{$array['src']}'><img src='{$root}{$array['src']}'></a>";
}
$Region = query("region"," id = '$kehu[RegionId]' ");
$LoveRegion = query("region", " id = '$kehu[LoveRegionId]' ");
echo head("pc").pc_header();
?>
<style>
.personal_service_icon{width:20px;height:20px;background-image:url(<?php echo img("htj50521405nK");?>);vertical-align:top;margin-right:2px}
.personal_letter{width:1000px;margin:20px auto 20px;overflow:hidden}
.personal_box{width:160px;float:left}
.personal,.personal_service{height:300px;border:1px solid #d4d4d4}
.personal img{margin:20px 0 15px 30px}
.edit_profile_btn,.upload_pictures_btn{display:inline-block;width:65px;line-height:22px;text-align:center;border:1px solid #ff536a;border-radius:12px;color:#ff536a}
.upload_pictures_btn{margin-left:10px;margin-right:4px}
.personal_message{text-align:center;margin:20px 0 20px}
.personal_title{font-size:16px;color:#000;margin-right:5px;display:inline-block}
.personal_icon{width:16px;height:16px;background-image:url(<?php echo img("amS49933027Nk");?>);background-position:0 0;margin-bottom:-2px}
.id_number span{font-size:14px;color:#ff536a}
#yellow{color:#f9a61c}
.personal_message_head{overflow:hidden;margin-bottom:5px}b
.function_tab_box{text-align:center}
.function_tab{display:inline-block;width:50px;height:36px}
.function_tab_special{border-left:1px solid #ddd;border-right:1px solid #ddd}
.function_tab_message,.function_tab_text{color:#ff536a;font-size:14px}
.function_tab_message{color:#ff536a}
.function_tab_text{color:#000}
.publish_btn{width:100%;display:inline-block;line-height:44px;font-size:20px;text-align:center;background-color:#ff536a;color:#fff;margin-top:25px}
.personal_service{margin-top:20px;padding-left:10px}
.personal_service h2,.personal_use h2{color:#333;font-size:18px;margin:25px 0}
.personal_member{margin-bottom:15px}
.personal_member a,.personal_member p{font-size:14px}
.personal_member span{color:#000;font-weight:700;font-size:16px;margin-right:5px}
.personal_member a{display:inline-block;width:40px;height:20px;line-height:20px;text-align:center;background-color:#ff536a;color:#fff}
.personal_service_icon01{background-position:-14px -26px}
.personal_service_icon02{background-position:-14px -50px}
.personal_service_icon03{background-position:-14px -74px}
.personal_service_icon04{background-position:-14px -99px}
.personal_use{margin-top:20px;padding-left:10px;border:1px solid #d4d4d4}
.personal_use_content{display:inline-block;margin-bottom:15px}
.personal_use_content span{color:#000;font-size:14px;font-weight:700}
.personal_use_icon01{background-position:-14px -142px}
.personal_use_icon02{background-position:-14px -225px}
.personal_use_icon03{background-position:-14px -196px}
.personal_use_icon04{background-position:-14px -256px}
.personal_use_icon05{background-position:-14px -169px}
.center_box{float:left;margin-left:30px;width:810px}
.center_head{width:770px;height:50px;line-height:50px;border-bottom:1px solid #ff536a;overflow:hidden}
.center_head a{color:#000;font-size:16px;display:block;height:50px;width:130px;text-align:center;line-height:50px;float:left}
.center_head .current{background-color:#ff536a;color:#fff}
.center_head a:hover{background-color:#ff536a;color:#fff}
.center_body{overflow:hidden}
.basic_information h2,.contact_information h2,.papers h2{color:#000;font-size:16px;padding-left:20px;margin-top:20px;font-weight:400}
.basic_information input,.basic_information select,.contact_information input,.contact_information select{display:inline-block;height:24px;line-height:24px;border:1px solid #ddd;padding-left:2px}
.basic_information input,.basic_information select{width:183px}
.basic_information .information_select-width select{width: 60px;}
.contact_information input,.contact_information selec{width:153px}
.information{margin:20px;position:relative;padding-left:70px}
.contact_information01 span,.information span{font-size:14px}
.information_r span{position:absolute;left:0;top:2px;width:70px}
.basic_information_left{margin-right:140px}
.basic_information_content{margin-left:-70px}
.contact_information{clear:both;float:left;margin-right:180px}
.contact_information_content{margin-left:20px}
.contact_information h2{margin-bottom:20px}
.contact_information01{margin:20px 0;position:relative;padding-left:70px}
.contact_information01 span{position:absolute;left:0;width:70px}
.papers{float:left}
.papers h2{margin-bottom:20px;margin-left:-20px}
.papers_btn{width:130px;height:28px;border:1px solid #ddd;background-color:#f6f6f6;text-align:center;line-height:28px;margin-bottom:20px;border-radius:2px}
.center_btn_box{width:100%;margin:auto;text-align:center;margin-top:20px;clear:both}
.center_btn{clear:both;display:inline-block;width:140px;height:40px;text-align:center;line-height:40px;background-color:#ff536a;color:#fff;border-radius:5px;font-size:16px;border:none}
.photo_album{margin:30px 0}
.photo_album img{display:inline-block;width:240px;height:150px;border:1px solid #ddd;margin-right:10px;margin-bottom:10px}
.monologue{margin:20px 0;width:800px;height:500px;padding:15px;border:1px solid #ddd}
.monologue p{text-indent:2em;line-height:30px;font-size:14px}
.ad{width:1000px;height:90px;clear:both;margin:50px auto}
[data-show-num]{ display:none;}
[data-show-num='<?php echo $num;?>']{ display:block!important;}
.hide{ display:none;}
</style>
  <!--内容-->
    <div class="personal_letter">
   		<!--左边-->
    	<div class="personal_box">
        	<!--个人资料-->
        	<?php echo center().serve();?>
            <!--我的应用-->
            <!--<div class="personal_use">
                <h2>我的应用</h2>
                <a class="personal_use_content" href="activity.html">
                	<i class="personal_service_icon personal_use_icon01"></i>
                    <span>最新活动</span>
                </a>
                <a class="personal_use_content" href="search.html">
                	<i class="personal_service_icon personal_use_icon02"></i>
                    <span>缘分搜索</span>
                </a>
                <a class="personal_use_content" href="personal _letter.html">
                	<i class="personal_service_icon personal_use_icon03"></i>
                    <span>交友手札</span>
                </a>
                <a class="personal_use_content" href="success_stories.html">
                	<i class="personal_service_icon personal_use_icon04"></i>
                    <span>成功案例</span>
                </a>
                <a class="personal_use_content" href="contact_us.html">
                	<i class="personal_service_icon personal_use_icon05"></i>
                    <span>盘州信息</span>
                </a>
            </div>-->
        </div>
        <!--右边个人信息-->
        <div class="center_box">
        	<div class="center_head" id="tabBtn">
            	<a href="<?php echo root."user/user.php?type=basicData";?>" class="<?php echo MenuGet("type","basicData","current");?>" data-num='1'>基本资料</a>
                <a href="<?php echo root."user/user.php?type=myAlbum";?>" class="<?php echo MenuGet("type","myAlbum","current");?>" data-num='2'>我的相册</a>
                <a href="<?php echo root."user/user.php?type=InnerMonologue";?>" class="<?php echo MenuGet("type","InnerMonologue","current");?>" data-num='3'>内心独白</a>
                <a href="<?php echo root."user/user.php?type=spouseIntention";?>" class="<?php echo MenuGet("type","spouseIntention","current");?>" data-num='4'>择偶意向</a>
            </div>
             <!--基本资料-->
            <form name="basicDataForm">
            <div class="center_body switch_tab" data-show-num='1'>
            	<!--基本信息-->
            	<div class="basic_information">
                  <div class="basic_information_content">
                  	<!--基本信息左边-->
                 	 <div class="fl basic_information_left">
                        <div class="information">
                            <span>昵称：</span>
                            <input name="userNickName" type="text" value="<?php echo $kehu['NickName'];?>">
                        </div>
                        <div class="information">
                            <span>性别：</span>
                            <?php echo select("userSex","","请选择",array("男","女"));?>
                        </div>
                        <div class="information information_select-width">
                            <span>生日：</span>
   			                <?php echo year('year','','').moon('moon','').day('day','');?>
                        </div>
                        <div class="information">
                            <span>星座：</span>
                            <select name="userConstellation">
                                <option value="">请选择</option>
                                <option value="白羊座">白羊座</option>
                                <option value="金牛座">金牛座</option>
                                <option value="双子座">双子座</option>
                                <option value="巨蟹座">巨蟹座</option>
                                <option value="狮子座">狮子座</option>
                                <option value="处女座">处女座</option>
                                <option value="天秤座">天秤座</option>
                                <option value="天蝎座">天蝎座</option>
                                <option value="射手座">射手座</option>
                                <option value="摩羯座">摩羯座</option>
                                <option value="水瓶座">水瓶座</option>
                                <option value="双鱼座">双鱼座</option>
                            </select>
                        </div>
                        <div class="information">
                            <span>属相：</span>
                            <select name="userZodiac">
                                <option value="">请选择</option>
                                <option value="鼠">鼠</option>
                                <option value="鼠">牛</option>
                                <option value="虎">虎</option>
                                <option value="兔">兔</option>
                                <option value="龙">龙</option>
                                <option value="蛇">蛇</option>
                                <option value="马">马</option>
                                <option value="羊">羊</option>
                                <option value="猴">猴</option>
                                <option value="鸡">鸡</option>
                                <option value="狗">狗</option>
                                <option value="猪">猪</option>
                            </select>
                        </div>
                        <div class="information">
                            <span>身高：</span>
                            <input name="userHeight" placeholder="请填写多少厘米" value="<?php echo $kehu['height'];?>" />cm
                        </div>
                        <div class="information">
                            <span>学历：</span>
                            <select name="userDegree">
                                <option value="">请选择</option>
                                <option value="高中及以下">高中及以下</option>
                                <option value="大专">大专</option>
                                <option value="本科">本科</option>
                                <option value="硕士">硕士</option>
                                <option value="博士及以上">博士及以上</option>
                            </select>
                        </div>
                    </div>
                    <!--基本信息右边-->
                    <div class="fl information_r">
                    <div class="information">
                        <span>婚姻状况：</span>
                        <select name="userMarry">
                            <option value="">请选择</option>
                            <option value="未婚">未婚</option>
                            <option value="离异">离异</option>
                            <option value="丧偶">丧偶</option>
                        </select>
                    </div>
                    <div class="information">
                        <span>子女情况：</span>
                        <select name="userChildren">
                        <option value="">请选择</option>
                        <option value="无小孩">无小孩</option>
                        <option value="有小孩归对方">有小孩归对方</option>
                        <option value="有小孩归自己">有小孩归自己</option>
                        </select>
                    </div>
                    <div class="information information_select-width">
                        <span>所在地区：</span>
                        <select name="province"><?php echo RepeatSele("region","province","--省份--");?></select>
                        <select name="city"><?php echo RepeatSele("region where province = '$Region[province]' ","city","--城市--");?></select>
                        <select name="area"><?php echo IDSele("region where province = '$Region[province]' and city = '$Region[city]'","id","area","--区县--");?></select>
                    </div>
                    <div class="information">
                        <span>月收入：</span>
                        <select name="userSalary">
                            <option value="">请选择</option>
                            <option value="2000元及以下">2000元及以下</option>
                            <option value="2000-5000元">2000-5000元</option>
                            <option value="5000-10000元">5000-10000元</option>
                            <option value="10000-20000元">10000-20000元</option>
                            <option value="20000元及以上">20000元及以上</option>
                        </select>
                    </div>
                    <div class="information">
                        <span>购房情况：</span>
                        <select name="userBuyHouse">
                            <option value="">请选择</option>
                            <option value="已购房">已购房</option>
                            <option value="暂未购房">暂未购房</option>
                        </select>
                    </div>
                    <div class="information">
                        <span>购车情况：</span>
                        <select name="userBuyCar">
                            <option value="请选择">请选择</option>
                            <option value="已购车">已购车</option>
                            <option value="暂未购车">暂未购车</option>
                        </select>
                    </div>
                    <div class="information">
                            <span>职业：</span>
                            <input name="userOccupation" placeholder="请填写职业" value="<?php echo $kehu['Occupation'];?>" />
                        </div>
                    </div>
                  </div>
                </div>
                <!--联系信息-->
                <div class="contact_information">
               	  <h2>联系信息</h2>
                  <div class="contact_information_content">
                        <div class="contact_information01">
                            <span>手机号码：</span>
                            <input name="userTel" type="text" value="<?php echo $kehu['khtel'];?>">
                        </div>
                        <div class="contact_information01">
                            <span>微信号：</span>
                            <input name="userWxNum" type="text" value="<?php echo $kehu['wxNum'];?>">
                        </div>
                        <div class="contact_information01">
                            <span>QQ：</span>
                            <input name="userQQ" type="text" value="<?php echo $kehu['khqq'];?>">
                        </div>
                  </div>
                </div>
                <!--证件上传-->
                <div class="papers">
    	            <h2>上传证件</h2>
                    <!--<div onClick="window.post.file.click()" class="papers_btn" >请上传身份证正面</div>
                    <div onClick="window.post.file.click()" class="papers_btn" >请上传身份证反面</div>
                    <div onClick="window.post.file.click()" class="papers_btn" >请上传手持身份证照片</div>
                    <form name="post">
                    <input name="file" type="file" id="file" style="display:none">
                    </form>-->
                    <div onClick="document.IDCardFrontForm.IDCardFrontUpload.click()" class="papers_btn" >请上传身份证正面</div>
                    <div onClick="document.IDCardReverseForm.IDCardReverseUpload.click()" class="papers_btn" >请上传身份证反面</div>
                    <div onClick="document.IDCardHandForm.IDCardHandUpload.click()"  class="papers_btn" >请上传手持身份证照片</div>
                </div>
                <div class="center_btn_box"><button class="center_btn" type="button" onClick="Sub('basicDataForm','<?php echo root."user/usData.php";?>')">保存</button></div>
            </div>
            </form>
            <!--我的相册-->
            <div id="switch_tab" class="switch_tab" data-show-num='2'>
                <div class="photo_album">
                	<?php echo $img;?>
                </div>
                <div class="center_btn_box"><label onClick="document.kehuAlbumForm.kehuAlbumUpload.click()" class="center_btn">上传</label></div>
            </div>
            
<!--            <div id="switch_tab" class="switch_tab" data-show-num='2'>
                <div class="photo_album">
                    <img src="<?php echo img("yHn50521931pw");?>">
                    <img src="<?php echo img("yHn50521931pw");?>">
                    <img src="<?php echo img("yHn50521931pw");?>">
                    <img src="<?php echo img("yHn50521931pw");?>">
                    <img src="<?php echo img("yHn50521931pw");?>">
                    <img src="<?php echo img("yHn50521931pw");?>">
                </div>
                <div class="center_btn_box"><label id="upload-label" class="center_btn">上传</label> 
                <input type="file" id="upload" style="display:none;"></div>
            </div>
-->            <!--内心独白-->
            <div class="switch_tab" data-show-num='3'>
            	<form name="summaryForm">
            	<textarea name="InnerMonologueSummary" style="resize:none; font-size:14px; text-indent:2em; line-height:20px;" class="monologue"><?php echo $kehu['summary'];?></textarea>
                <div class="center_btn_box"><button class="center_btn" type="button" onClick="Sub('summaryForm','<?php echo root."user/usData.php";?>')">保存</button></div>
                </form>
            </div>
            <!--择偶意向-->
            <form name="spouseIntentionForm">
        <div class="center_body switch_tab" data-show-num='4'>
            	<!--基本信息-->
            	<div class="basic_information">
                  <div class="basic_information_content">
                  	<!--择偶意向左边-->
                 	 <div class="fl basic_information_left">
                        <div class="information">
                            <span>年龄：</span>
                            <select name="spouseAge">
                            <option value="">请选择</option>
                                <option value="20岁-25岁">20岁-25岁</option>
                                <option value="25岁-30岁">25岁-30岁</option>
                                <option value="30岁-35岁">30岁-35岁</option>
                                <option value="35岁-40岁">35岁-40岁</option>
                            </select>
                        </div>
                        <div class="information">
                            <span>身高：</span>
                            <input name="spouseHeight" placeholder="请填写多少厘米" value="<?php echo $kehu['LoveHeight'];?>" />cm
                        </div>
                        <div class="information">
                            <span>学历：</span>
                            <select name="spouseDegree">
                                <option value="">请选择</option>
                                <option value="高中及以下">高中及以下</option>
                                <option value="大专">大专</option>
                                <option value="本科">本科</option>
                                <option value="硕士">硕士</option>
                                <option value="博士及以上">博士及以上</option>
                            </select>
                        </div>
                    <div class="information">
                        <span>民族：</span>
                        <input name="spouseNation" placeholder="请填写民族" value="<?php echo $kehu['LoveNation'];?>" />
                    </div>
                    <div class="information">
                            <span>职业：</span>
                            <input name="spouseOccupation" placeholder="请填写职业" value="<?php echo $kehu['LoveOccupation'];?>" />
                    </div>
                    </div>
                    <!--择偶意向右边-->
                    <div class="fl information_r">
                    <div class="information">
                        <span>婚姻状况：</span>
                        <select name="spouseMarry">
                            <option value="">请选择</option>
                            <option value="未婚">未婚</option>
                            <option value="离异">离异</option>
                            <option value="丧偶">丧偶</option>
                        </select>
                    </div>
                    <div class="information information_select-width">
                        <span>所在地区：</span>
                        <select name="province"><?php echo RepeatSele("region","province","--省份--");?></select>
                        <select name="city"><?php echo RepeatSele("region where province = '$LoveRegion[province]' ","city","--城市--");?></select>
                        <select name="area"><?php echo IDSele("region where province = '$LoveRegion[province]' and city = '$LoveRegion[city]'","id","area","--区县--");?></select>
                    </div>
                    <div class="information">
                        <span>月收入：</span>
                        <select name="spouseSalary">
                            <option value="">请选择</option>
                            <option value="2000元及以下">2000元及以下</option>
                            <option value="2000-5000元">2000-5000元</option>
                            <option value="5000-10000元">5000-10000元</option>
                            <option value="10000-20000元">10000-20000元</option>
                            <option value="20000元及以上">20000元及以上</option>
                        </select>
                    </div>
                    <div class="information">
                        <span>购房情况：</span>
                        <select name="spouseBuyHouse">
                            <option value="">请选择</option>
                            <option value="已购房">已购房</option>
                            <option value="暂未购房">暂未购房</option>
                        </select>
                    </div>
                    <div class="information">
                        <span>购车情况：</span>
                        <select name="spouseBuyCar">
                            <option value="请选择">请选择</option>
                            <option value="已购车">已购车</option>
                            <option value="暂未购车">暂未购车</option>
                        </select>
                    </div>
                    </div>
                  </div>
                </div>
         <div class="center_btn_box"><button class="center_btn" type="button" onClick="Sub('spouseIntentionForm','<?php echo root."user/usData.php";?>')">保存</button></div>
         </form>
        </div>
        </div>
    </div>
    <?php echo my_gift();?>
    <div class="ad">
		<a target="_blank" href="<?php echo imgurl("oGv49861379ud");?>"><img src="<?php echo img("oGv49861379ud");?>"></a>
    </div>
<!--隐藏表单开始-->
<div class="hide">
<form name="IDCardFrontForm" action="<?php echo root."user/usPost.php";?>" method="post" enctype="multipart/form-data">
<input name="IDCardFrontUpload" type="file" onChange="document.IDCardFrontForm.submit()">
</form>
<form name="IDCardReverseForm" action="<?php echo root."user/usPost.php";?>" method="post" enctype="multipart/form-data">
<input name="IDCardReverseUpload" type="file" onChange="document.IDCardReverseForm.submit()">
</form>
<form name="IDCardHandForm" action="<?php echo root."user/usPost.php";?>" method="post" enctype="multipart/form-data">
<input name="IDCardHandUpload" type="file" onChange="document.IDCardHandForm.submit()">
</form>
<form name="kehuAlbumForm" action="<?php echo root."user/usPost.php";?>" method="post" enctype="multipart/form-data">
<input name="kehuAlbumUpload" type="file" onChange="document.kehuAlbumForm.submit()">
</form>
</div>
<!--隐藏表单结束-->
<?php echo warn().footer();?>
<script>
$(function() {
	$('#show-my-gift').click(function(){
		MG.show();
	});
	 //根据省份获取下属城市下拉菜单 基本资料
	$(document).on('change','[name="basicDataForm"] [name=province]',function(){
		$.post('<?php echo root."library/OpenData.php";?>',{ProvincePostCity:$(this).val()},function(data){
			$('[name="basicDataForm"] [name=city]').html(data.city);
		},'json');
	});
	//根据省份和城市获取下属区域下拉菜单 基本资料
	$(document).on('change','[name="basicDataForm"] [name = city]',function(){
		$.post('<?php echo root."library/OpenData.php";?>',{ProvincePostArea:$('[name="basicDataForm"] [name=province]').val(),CityPostArea:$(this).val()},function(data){
			$('[name="basicDataForm"] [name=area]').html(data.area);
		},"json");
	});
	 //根据省份获取下属城市下拉菜单 择偶意向
	$(document).on('change','[name="spouseIntentionForm"] [name=province]',function(){
		$.post('<?php echo root."library/OpenData.php";?>',{ProvincePostCity:$(this).val()},function(data){
			$('[name="spouseIntentionForm"] [name=city]').html(data.city);
		},'json');
	});
	//根据省份和城市获取下属区域下拉菜单 择偶意向
	$(document).on('change','[name="spouseIntentionForm"] [name = city]',function(){
		$.post('<?php echo root."library/OpenData.php";?>',{ProvincePostArea:$('[name="spouseIntentionForm"] [name=province]').val(),CityPostArea:$(this).val()},function(data){
			$('[name="spouseIntentionForm"] [name=area]').html(data.area);
		},"json");
	});
		//文件上传
	(function(){
		var M={
			getId:function(id){
				return document.getElementById(id);
			},
			init:function(){
				var label = M.getId('upload-label');
				label.onclick= function(){
					M.getId('upload').click();
				}
			}
		}
		M.init();
	})()
	//选项卡切换
	/**$(function(){
		$("#tabBtn>a").click(function(){
			$(this).addClass('current').siblings().removeClass('current');
			var num =$(this).attr("data-num");
			$(".switch_tab").hide();
			$("[data-show-num = "+num+"]").fadeIn(300);
		});
	});**/
	<?php
	echo 
	/*基本资料*/
	KongSele("basicDataForm.userSex",$kehu['sex']).
	KongTime("basicDataForm.year",$kehu['Birthday'],"Y").
	KongTime("basicDataForm.moon",$kehu['Birthday'],"m").
	KongTime("basicDataForm.day",$kehu['Birthday'],"d").
	KongSele("basicDataForm.userConstellation",$kehu['constellation']).
	KongSele("basicDataForm.userZodiac",$kehu['Zodiac']).
	KongSele("basicDataForm.userDegree",$kehu['degree']).
	KongSele("basicDataForm.userMarry",$kehu['marry']).
	KongSele("basicDataForm.userChildren",$kehu['children']).
	KongSele("basicDataForm.province",$Region['province']).
	KongSele("basicDataForm.city",$Region['city']).
	KongSele("basicDataForm.area",$Region['id']).
	KongSele("basicDataForm.userSalary",$kehu['salary']).
	KongSele("basicDataForm.userBuyHouse",$kehu['BuyHouse']).
	KongSele("basicDataForm.userBuyCar",$kehu['BuyCar']).
	/*择偶意向*/
	KongSele("spouseIntentionForm.spouseAge",$kehu['LoveAge']).
	KongSele("spouseIntentionForm.spouseMarry",$kehu['LoveMarry']).
	KongSele("spouseIntentionForm.province",$LoveRegion['province']).
	KongSele("spouseIntentionForm.city",$LoveRegion['city']).
	KongSele("spouseIntentionForm.area",$LoveRegion['id']).
	KongSele("spouseIntentionForm.spouseDegree",$kehu['LoveDegree']).
	KongSele("spouseIntentionForm.spouseSalary",$kehu['LoveSalary']).
	KongSele("spouseIntentionForm.spouseBuyHouse",$kehu['LoveHouse']).
	KongSele("spouseIntentionForm.spouseBuyCar",$kehu['LoveCar']);
	?>
});
</script>