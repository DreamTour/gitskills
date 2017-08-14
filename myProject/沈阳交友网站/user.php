<?php
include "../library/PcFunction.php";
UserRoot("pc");
echo head("pc");
$ThisUrl = root."user/user.php";
if(isset($_GET['type'])){
	if($_GET['type'] == "basicData"){
		//$and = " and classify = '基本资料' ";
		$ThisUrl .= "?type=basicData";
		$number = 1;	
	}else if($_GET['type'] == "myAlbum"){
		$ThisUrl .= "?type=myAlbum";
		$number = 2;
	}else if($_GET['type'] == "InnerMonologue"){
		$and = " and classify = '内心独白' ";
		$ThisUrl .= "?type=InnerMonologue";
		$number = 3;	
	}else if($_GET['type'] == "spouseIntention"){
		$ThisUrl .= "?type=spouseIntention";
		$number = 4;
	}else{
		$ThisUrl .= "?type=basicData";
		$number = 1;	
	}	
}else{
 header("location:{$ThisUrl}?type=basicData");
 exit(0);	
}
$Region = mysql_fetch_array(mysql_query("select * from region where id = '$kehu[RegionId]' "));
$LoveRegion = mysql_fetch_array(mysql_query("select * from region where id = '$kehu[LoveRegionId]' "));
//个人中心我的相册图片循环
$imgSql = mysql_query("select * from kehuImg where khid = '$kehu[khid]' order by time desc");
$img = "";
while($array = mysql_fetch_array($imgSql)){
	$img .= "<div class='deleteWrap' >
				<a target='_blank' href='{$root}{$array['src']}'><img src='{$root}{$array['src']}'></a>
				<i class='deleteIcon' style='cursor:pointer;' onClick=\"window.location.href='{$root}library/usPost.php?deletePhotoImg={$array['id']}'\"></i>
			</div>";	
}
?>
<style>
.icon{ background:url(<?php echo img("WxN53377734Xb");?>)}
[data-show-num]{display:none;}
[data-show-num='<?php echo $number;?>']{ display:block;}
#switch_tab img{border:1px solid #fff;}
#switch_tab .deleteWrap:hover img{border-color:#ff536a;}
#switch_tab .deleteWrap:hover .deleteIcon{display:block;}
.deleteWrap{position:relative;display:inline-block;z-index:1;}
.deleteIcon{
	width:13px;
	height:13px;;
	background-image:url(<?php echo img("PPM50625481WQ");?>);
	background-position:-9px -15px;
	position:absolute;
	top:0;
	right:10px;
	background-color: #ff536a;
	z-index:2;
	display:none;
}
.personal_service_icon{width:20px;height:20px;background-image:url(<?php echo img("Gwl57090161Zn");?>);vertical-align:top;margin-right:2px}
.personal_letter{width:1000px;margin:20px auto 20px;overflow:hidden}
.personal_box{width:160px;float:left}
.personal{border:1px solid #d4d4d4}
.personal img{margin:20px 20px}
.edit_profile_btn,.upload_pictures_btn{display:inline-block;width:65px;line-height:22px;text-align:center;border:1px solid #ff7c7c;border-radius:12px;color:#ff7c7c}
.upload_pictures_btn{margin-left:10px;margin-right:4px}
.personal_message{text-align:center}
.personal_title{font-size:16px;color:#000;margin-right:5px;display:inline-block}
.personal_icon{width:16px;height:16px;background-image:url(<?php echo img("amS49933027Nk");?>);background-position:0 0;margin-bottom:-2px}
.id_number span{font-size:14px;color:#ff7c7c}
#yellow{color:#f9a61c}
.personal_message_head{overflow:hidden;margin-bottom:5px}
.function_tab_box{text-align:center}
.function_tab{display:inline-block;width:50px;height:36px}
.function_tab_special{border-left:1px solid #ddd;border-right:1px solid #ddd}
.function_tab_message,.function_tab_text{color:#ff7c7c;font-size:14px}
.function_tab_message{color:#ff7c7c}
.function_tab_text{color:#000}
.publish_btn{width:100%;display:inline-block;line-height:44px;font-size:20px;text-align:center;background-color:#ff7c7c;color:#fff;margin-top:25px}
.look_box{background-color:#ff7c7c;line-height:40px;height:40px;margin-top:10px}
.look_box a{display:inline-block;font-size:14px;color:#fff;text-align:center}
.personal_service{height:260px;margin-top:15px;padding-left:10px;border:1px solid #d4d4d4}
.ps-line p{width:3px;height:20px;background-color:#ff7f00;margin-right:5px}
.ps-line{margin:15px 0}
.ps-line h2{color:#333;font-size:18px;margin-top:-2px}
.personal_member{margin-bottom:10px}
.personal_member a{font-size:14px}
.personal_member p{color:#888}
.personal_member span{color:#000;font-size:16px;margin-right:5px}
.personal_member a{display:inline-block;width:40px;height:20px;line-height:20px;text-align:center;background-color:#ff7f00;color:#fff}
.personal_service_icon01{background-position:-14px -26px}
.personal_service_icon02{background-position:-14px -50px}
.personal_service_icon03{background-position:-14px -74px}
.personal_service_icon04{background-position:-14px -99px}
.ad_link{border:1px solid #ddd;margin-top:60px;background:url(<?php echo img("UZk53377931Uh");?>) no-repeat scroll 0 0;text-align:center;padding:36px 15px 15px}
.link_icon{display:block;width:52px;height:52px;background:url(<?php echo img("Gwl57090161Zn");?>) no-repeat scroll 0 -138px;margin:10px 35px}
.ad_link h2{overflow:hidden;line-height:22px;max-height:44px}
.ad_link p{overflow:hidden;line-height:16px;max-height:100px;word-break:break-all;text-align:justify}
.link_btn{display:inline-block;width:110px;line-height:30px;background-color:#ff7f00;border-radius:3px;text-align:center;color:#fff;margin-top:10px}
.center_box{float:left;margin-left:30px;width:810px}
.center_head{width:770px;height:50px;line-height:50px;border-bottom:1px solid #ddd;overflow:hidden}
.center_head a{font-size:16px;display:block;height:50px;width:100px;text-align:center;line-height:50px;float:left}
.center_head a:hover{border-bottom:3px solid #ff7c7c;color:#ff7c7c;font-weight:700}
.center_body{overflow:hidden}
.current{border-bottom:3px solid #ff7c7c;font-weight:700;color:#ff7c7c}
.basic_information h2,.contact_information h2,.papers h2{color:#000;font-size:16px;padding-left:20px;margin-top:20px;font-weight:400}
.basic_information input,.basic_information select,.contact_information input,.contact_information select,.information01 input,.information01 select,.information02 input,.information02 select{display:inline-block;height:24px;line-height:24px;border:1px solid #ddd;padding-left:2px}
.basic_information input,.basic_information select{width:183px}
.contact_information input,.contact_information selec{width:153px}
.information,.information01,.information02{margin:20px;position:relative}
.information{padding-left:70px}
.information span,.information01 span,.information02 span{font-size:14px}
.information01 span{display:inline-block;width:70px}
.information02 span{display:inline-block}
.information01 input,.information01 select,.information02 input,.information02 select{width:183px}
.information_r span{position:absolute;left:0;top:2px;width:70px}
.basic_information_left{margin-right:140px}
.basic_information_content{margin-left:-70px}
.contact_information01{margin:20px 0;position:relative;padding-left:70px}
.contact_information01 span{position:absolute;left:0;width:70px}
.center_btn_box{width:100%;margin:auto;text-align:center;margin-top:10px;clear:both}
.center_btn{clear:both;display:inline-block;width:140px;height:40px;text-align:center;line-height:40px;background-color:#ff7c7c;color:#fff;border-radius:5px;font-size:16px;border:none}
.center_btn_user{clear:both;display:inline-block;width:100px;height:30px;text-align:center;line-height:30px;background-color:#ff7c7c;color:#fff;font-size:14px;border:none}
.photo_album{margin:30px 0}
.photo_album img{display:inline-block;height:150px;margin-right:10px;margin-bottom:10px}
.monologue textarea{margin:20px 0;width:800px;height:500px;padding:15px;text-indent:2em;line-height:30px;font-size:14px}
.ad{width:1000px;height:90px;clear:both;margin:30px auto}
.nav_current{background-color:#ff7f00;color:#fff;}
.basic_information .information_select-width select{width:60px;}
.hide{display:none;}
.center_body span{display: inline-block;width:80px;}
.information_input-width input{width:85px;}
</style> 	
<!--头部-->
	<?php echo pcHeader();?>
        <script>
		$(document).ready(function(){
         	$(".nav_bar li").click(function(){
				$(this).addClass(".nav_current").siblings().removeClass(".nav_current");
			});   
        });
		</script>
    <!--内容-->
    <div class="personal_letter">
   		<!--左边-->
    	<div class="personal_box">
        	<!--个人资料-->
 			<?php echo data();?>
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
                  <div class="basic_information_content of">
                  	<!--基本信息左边-->
                 	 <div class="fl basic_information_left">
                     	
                        <div class="information">
                            <span>微信名：</span>
                            <input name="userNickName" type="text" value="<?php echo $kehu['NickName'];?>">
                        </div>
                        <div class="information">
                            <span>性别：</span>
                            <?php echo select("userSex","","请选择",array("男","女"),$kehu['sex']);?>
                        </div>
                        <div class="information information_select-width">
                            <span>生日：</span>
                            <?php echo year('year','','').moon('moon','').day('day','');?>
                        </div>
                        <div class="information">
                            <span>生肖：</span>
                            <select name="userZodiac">
                                <option value="">请选择</option>
                                <option value="鼠">鼠</option>
                                <option value="牛">牛</option>
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
                            <span>民族：</span>
                            <input name="userNation" value="<?php echo $kehu['Nation'];?>" />
                    	</div>
                        <div class="information">
                            <span>身高：</span>
                            <input name="userHeight" placeholder="请填写多少厘米" value="<?php echo $kehu['height'];?>" />cm
                        </div>
                        <div class="information">
                        <span>体重：</span>
                        <input name="userWeight"placeholder="请填写多少斤" value="<?php echo $kehu['weight'];?>" />斤
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
                         <div class="information">
                        <span>婚育情况：</span>
                        <select name="userMarry">
                            <option value="">请选择</option>
                            <option value="未婚未育">未婚未育</option>
                            <option value="离异未育">离异未育</option>
                            <option value="离异有孩归自己">离异有孩归自己</option>
                            <option value="离异有孩归对方">离异有孩归对方</option>
                        </select>
                    </div>
                         <div class="information">
                        <span>家乡：</span>
                        <input name="userHometown" value="<?php echo $kehu['Hometown'];?>" />
                   	</div>
                     <div class="information information_select-width">
                        <span>所在地区：</span>
                        <select name="province"><?php echo RepeatOption("region where province = '辽宁省'","province","--省份--","辽宁省");?></select>
                        <select name="city"><?php echo RepeatOption("region where province = '辽宁省' and city = '沈阳市' ","city","--城市--","沈阳市");?></select>
                        <select name="area"><?php echo IdOption("region where province = '辽宁省' and city = '沈阳市'","id","area","--区县--",$Region['id']);?></select>
                    </div>
                    <div class="information">
                            <span>工作：</span>
                            <input name="userOccupation" value="<?php echo $kehu['Occupation'];?>" />
                     </div>
                    
                    </div>
                    <!--基本信息右边-->
                    <div class="fl information_r">
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
                        <span>是否吸烟：</span>
                        <select name="userSmoke">
                            <option value="">请选择</option>
                            <option value="是">是</option>
                            <option value="否">否</option>
                        </select>
                    </div>
                    <div class="information">
                        <span>是否饮酒：</span>
                        <select name="userDrink">
                            <option value="">请选择</option>
                            <option value="是">是</option>
                            <option value="否">否</option>
                        </select>
                    </div>
                    <div class="information">

                        <span>是否有房：</span>
                        <select name="userBuyHouse">
                            <option value="">请选择</option>
                            <option value="有">有</option>
                            <option value="无">无</option>
                        </select>
                    </div>
                    <div class="information">
                        <span>是否有车：</span>
                        <select name="userBuyCar">
                            <option value="">请选择</option>
                            <option value="有">有</option>
                            <option value="无">无</option>
                        </select>
                    </div>
                     <div class="information">
                        <span>有无贷款：</span>
                        <select name="userLoan">
                            <option value="">请选择</option>
                            <option value="有">有</option>
                            <option value="无">无</option>
                        </select>
                    </div>
                    <div class="information">
                        <span>兴趣爱好：</span>
                        <input name="userHobby" value="<?php echo $kehu['Hobby'];?>" placeholder="10字以内" maxlength="10" />
                    </div>
					
                    <div class="information">
                        <span>优点：</span>
                        <input name="userAdvantage" value="<?php echo $kehu['Advantage'];?>" />
                    </div>
                    <div class="information">
                        <span>缺点：</span>
                        <input name="userShortcoming" value="<?php echo $kehu['defect'];?>" />
                    </div>
                    
                    <div class="information">
                        <span>家中排行：</span>
                        <select name="userHomerank">
                            <option value="">请选择</option>
                            <option value="独生子女">独生子女</option>
                            <option value="老大">老大</option>
                            <option value="老二">老二</option>
                            <option value="老三">老三</option>
                            <option value="更多">更多</option>
                        </select>
                    </div>
                    <div class="information">
                        <span>家庭成员：</span>
                        <input name="userFamily" value="<?php echo $kehu['family'];?>" />
                    </div>
                    <div class="information">
                        <span>微信号：</span>
                        <input name="userWxNum" value="<?php echo $kehu['wxNum'];?>" />
                   	</div>
                    <div class="information">
                        <span>身份证号：</span>
                        <input name="userIDCard" value="<?php echo $kehu['IDCard'];?>" placeholder="实名认证审核 他人不可见" />
                    </div>
                  </div>
                </div>
                </div>
                <div class="center_btn_box"><button class="center_btn" type="button" onClick="Sub('basicDataForm','<?php echo root."library/usData.php";?>')">保存</button></div>
            </div>
            </form>	
            <!--我的相册-->
            <div id="switch_tab" class="switch_tab" data-show-num='2'>
                <div class="photo_album">
                    <?php echo $img;?>
                </div>
                <div class="center_btn_box"><label onClick="document.kehuAlbumForm.kehuAlbumUpload.click()" class="center_btn">上传</label></div>
            </div>
            <!--隐藏表单开始-->
            <div class="hide">
                <form name="kehuAlbumForm" action="<?php echo root."library/usPost.php";?>" method="post" enctype="multipart/form-data">
                	<input name="kehuAlbumUpload" type="file" onChange="document.kehuAlbumForm.submit()">
                </form>
                <form name='headPortraitForm' action='<?php echo root."library/usPost.php";?>' method='post' enctype='multipart/form-data'>
					<input name='headPortraitUpload' type='file' onChange='document.headPortraitForm.submit()'>
				</form>
            </div>
			<!--隐藏表单结束-->
            <!--内心独白-->
            <form name="summaryForm">
            <div class="switch_tab" data-show-num='3'>
            	<div class="monologue"><textarea name="InnerMonologueSummary"><?php echo $kehu['summary'];?></textarea></div>
                <div class="center_btn_box"><button class="center_btn" type="button" onClick="Sub('summaryForm','<?php echo root."library/usData.php";?>')">保存</button></div>
            </div>
            </form>
            <!--择偶意向-->
            <form name="spouseIntentionForm">
        <div class="center_body switch_tab" data-show-num='4'>
            	<!--基本信息-->
            	<div class="basic_information">
                  <div class="basic_information_content of">
                  	<!--择偶意向左边-->
                 	 <div class="fl basic_information_left">
                       <div class="information information_input-width">
                            <span>年龄：</span>
                              <input name="spouseAgeMin" value="<?php echo $kehu['LoveAgeMin'];?>" /> -
                              <input name="spouseAgeMax" value="<?php echo $kehu['LoveAgeMax'];?>" />岁
                        </div>
                        <div class="information">
                            <span>生肖：</span>
                             <?php echo select("spouseZodiac","","请选择",array('不限',"鼠","牛","虎","兔","龙","蛇","马","羊","猴","鸡","狗","猪"),$kehu['LoveZodiac']);?>
                        </div>
                        <div class="information">
                            <span>星座：</span>
                            <?php echo select("spouseConstellation","","请选择",array('不限','白羊座','金牛座','双子座','巨蟹座','狮子座','处女座','天秤座','天蝎座','射手座','摩羯座','水瓶座','双鱼座'),$kehu['LoveConstellation']);?>
                        </div>
                        <div class="information">
                            <span>民族：</span>
                           <input name="spouseNation" value="<?php echo $kehu['LoveNation'];?>" />
                    	</div>
                        <div class="information information_input-width">
                            <span>身高：</span>
                            <input name="spouseHeightMin" value="<?php echo $kehu['LoveHeightMin'];?>" /> -
                            <input name="spouseHeightMax" value="<?php echo $kehu['LoveHeightMax'];?>" />cm
                        </div>
                        <div class="information information_input-width">
                        <span>体重：</span>
                        	<input name="spouseWeightMin" value="<?php echo $kehu['LoveWeightMin'];?>" /> -
                            <input name="spouseWeightMax" value="<?php echo $kehu['LoveWeightMax'];?>" />斤
                   		</div>
                        <div class="information">
                            <span>学历：</span>
                            <?php echo select("spouseDegree","","请选择",array("不限","高中及以下","大专","本科","硕士","博士及以上"),$kehu['LoveDegree']);?>
                        </div>
                         <div class="information">
                        <span>婚育情况：</span>
                        <select name="spouseMarry">
  	                      <?php echo option("请选择",array('不限','未婚未育','离异未育','离异有孩归自己','离异有孩归自己'),$kehu['LoveMarry']);?>
                        </select>
                    </div>
                         <div class="information">
                        <span>家乡：</span>
                        <input name="spouseHometown" value="<?php echo $kehu['LoveHometown'];?>" />
                   	</div>
                     <div class="information information_select-width">
                        <span>所在地区：</span>
                        <select name="province2"><?php echo RepeatOption("region where province = '辽宁省'","province","--省份--","辽宁省");?></select>
                        <select name="city2"><?php echo RepeatOption("region where province = '辽宁省' and city = '沈阳市' ","city","--城市--","沈阳市");?></select>
                        <select name="area2"><?php echo IdOption("region where province = '辽宁省' and city = '沈阳市' ","id","area","--不限--",$LoveRegion['id']);?></select>
                    </div>
                    <div class="information">
                            <span>工作：</span>
                           <input name="spouseOccupation" value="<?php echo $kehu['LoveOccupation'];?>" />
                     </div>
                    </div>
                    <!--择偶意向右边-->
                    <div class="fl information_r">
                   <div class="information">
                        <span>月收入：</span>
                            <?php echo select("spouseSalary","","请选择",array('不限',"2000元及以下","2000-5000元","5000-10000元","10000-20000元","20000元及以上"),$kehu['LoveSalary']);?>
                    </div>           
                   <div class="information">
                        <span>是否吸烟：</span>
                        <?php echo select("spouseSmoke","","请选择",array('不限',"是","否"),$kehu['LoveSmoke']);?>
                    </div>
                    <div class="information">
                        <span>是否饮酒：</span>
                        <?php echo select("spouseDrink","","请选择",array('不限',"是","否"),$kehu['LoveDrink']);?>
                    </div>
                    <div class="information">
                        <span>是否有房：</span>
                        <select name="spouseBuyHouse">
                        <?php echo option("请选择",array('不限','有','无'),$kehu['LoveHouse']);?>
                        </select>
                    </div>
                    <div class="information">
                        <span>是否有车：</span>
                        <select name="spouseBuyCar">
                        <?php echo option("请选择",array('不限','有','无'),$kehu['LoveCar']);?>
                        </select>
                    </div>
                     <div class="information">
                        <span>有无贷款：</span>
                        <?php echo select("spouseLoan","","请选择",array('不限',"有","无"),$kehu['LoveLoan']);?>
                    </div>
                    <div class="information">
                        <span>兴趣爱好：</span>
                        <input name="spouseHobby" value="<?php echo $kehu['LoveHobby'];?>" placeholder="10字以内" maxlength="10" />
                    </div>
					
                    <div class="information">
                        <span>优点：</span>
                        <input name="spouseAdvantage" value="<?php echo $kehu['LoveAdvantage'];?>" />
                    </div>
                    <div class="information">
                        <span>缺点：</span>
                        <input name="spouseShortcoming" value="<?php echo $kehu['LoveDefect'];?>" />
                    </div>
                    
                    <div class="information">
                        <span>家中排行：</span>
                         <?php echo select("spouseHomerank","","请选择",array('不限',"独生子女","老大","老二","老三","更多"),$kehu['LoveHomeRanking']);?>
                    </div>
                    <div class="information">
                        <span>家庭成员：</span>
                        <input name="spouseFamily" value="<?php echo $kehu['LoveFamily'];?>" />
                    </div>
                    </div>
                  </div>
                </div>
         <div class="center_btn_box"><button class="center_btn" type="button" onClick="Sub('spouseIntentionForm','<?php echo root."library/usData.php";?>')">保存</button></div>
         </form>
        </div>
        </div>
    </div>
    <script>
	$(function(){
		//根据省份获取下属城市下拉菜单 基本资料
		$(document).on('change','[name=basicDataForm] [name=province]',function(){
			$('[name=basicDataForm] [name=area]').html("<option value=''>--区县--</option>");	
			$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostCity:$(this).val()},function(data){
				$('[name=basicDataForm] [name=city]').html(data.city);		
			},"json");	
		})
		//根据省份和城市获取下属区域下拉菜单 基本资料
		$(document).on('change','[name=basicDataForm] [name=city]',function(){
			$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostArea:$('[name=basicDataForm] [name=province]').val(),
			CityPostArea:$(this).val()},function(data){
				$('[name=basicDataForm] [name=area]').html(data.area);
			},"json");	
		})
		//根据省份获取下属城市下拉菜单 择偶意向
		$(document).on('change','[name=spouseIntentionForm] [name=province2]',function(){
			$('[name=spouseIntentionForm] [name=area2]').html("<option value=''>--区县--</option>");	
			$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostCity:$(this).val()},function(data){
				$('[name=spouseIntentionForm] [name=city2]').html(data.city);
			},"json");
		})
		//根据省份和城市获取下属区域下拉菜单 择偶意向
		$(document).on('change','[name=spouseIntentionForm] [name=city2]',function(){
			$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostArea:$('[name=spouseIntentionForm] [name=province2]').val(),
			CityPostArea:$(this).val()},function(data){
				$('[name=spouseIntentionForm] [name=area2]').html(data.area);
			},"json");	
		})
		//显示收到的礼物
		$('#show-my-gift').click(function(){
			MG.show();
		});
		<?php 
	echo //显示基本资料
	KongTime("basicDataForm.year",$kehu['Birthday'],"Y").
	KongTime("basicDataForm.moon",$kehu['Birthday'],"m").
	KongTime("basicDataForm.day",$kehu['Birthday'],"d").
	KongSele("basicDataForm.userConstellation",$kehu['constellation']).
	KongSele("basicDataForm.userZodiac",$kehu['Zodiac']).
	KongSele("basicDataForm.userDegree",$kehu['degree']).
	KongSele("basicDataForm.userMarry",$kehu['marry']).
	KongSele("basicDataForm.userChildren",$kehu['children']).
/*	KongSele("basicDataForm.province",$Region['province']).
	KongSele("basicDataForm.city",$Region['city']).
	KongSele("basicDataForm.area",$Region['id']).
*/	KongSele("basicDataForm.userSalary",$kehu['salary']).
	KongSele("basicDataForm.userBuyHouse",$kehu['BuyHouse']).
	KongSele("basicDataForm.userBuyCar",$kehu['BuyCar']).
	KongSele("basicDataForm.userSmoke",$kehu['smoke']).
	KongSele("basicDataForm.userDrink",$kehu['drink']).
	KongSele("basicDataForm.userLoan",$kehu['loan']).
	KongSele("basicDataForm.userHomerank",$kehu['HomeRanking']).
	KongSele("basicDataForm.userWeight",$kehu['weight']);
?>
	})
	</script>
<!--    <div class="ad">
        <a href="javascript:;"><img src="<?php echo img("uiJ53377569IG");?>"></a>
    </div>
--><!--底部-->
<?php echo my_gift().warn().choosePay().pcFooter();?>
</body>
</html>