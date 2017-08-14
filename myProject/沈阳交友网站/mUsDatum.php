<?php
include "../mLibrary/mFunction.php";
if($KehuFinger == 2) {
	$login = "";
} else{
	$login = "退出登录";
}
echo head("m");
UserRoot("m");
$Region = mysql_fetch_array(mysql_query("select * from region where id = '$kehu[RegionId]' "));
$LoveRegion = mysql_fetch_array(mysql_query("select * from region where id = '$kehu[LoveRegionId]' "));
?>
<style>
.pe-item-box .pe-item_width select{width:33.333333333%;}
.pe-item input, .pe-item select{ background:none;}
ul .pe-item:nth-last-child(1) input,ul .pe-item:nth-last-child(1) select{border:none;}
.pe-item{display:flex;}
.pe-item span{width:30%;}
.pe-item-box .pe-item_input input{width:50%;}
</style>
<!--头部-->
<div class="header fz16">
	<!--<div class="head-left"><a href="<?php echo "{$root}m/mindex.php";?>" class="col1"><返回</a></div>-->
    <div class="head-center"><a href="<?php echo $root;?>m/user/mUsLogin.php?Delete=kehu" class="col1"><?php echo $login;?></a></div>
</div>
<!--我的-->
<div class="my-content">
	<?php echo my_top();?>
    <div class="my-top-nav bg2">
    	<p class="fz16"><a href="<?php echo $root?>m/user/mUsAlbum.php"><i class="my-icon-top my-icon1"></i><span>我的相册</span></a></p>
        <p class="fz16"><a href="<?php echo $root?>m/user/mUsGift.php"><i class="my-icon-top my-icon2"></i><span>我的礼物</span></a></p>
    </div>
 <!--个人资料-->
 	<form name="personalDataForm">
 	 <ul>
         <li class="my-personal">
            <h2 class="col"><p class="my-line bg1"></p><span>内心独白</span></h2>
            <div class="my-pe-list bg2">
            	<ul class="pe-item-box">
                    <li class="pe-item"><textarea name="InnerMonologueSummary" class="fz14"><?php echo $kehu['summary'];?></textarea></li>
            </div>
         </li>
         <li class="my-personal">
            <h2 class="col"><p class="my-line bg1"></p><span>基本信息</span></h2>
            <div class="my-pe-list bg2">
                <ul class="pe-item-box">
                    <li class="pe-item"><span>微信名</span><input name="userNickName" type="text" value="<?php echo $kehu['NickName'];?>"></li>
                    <li class="pe-item"><span>性别</span><?php echo select("userSex","","请选择",array("男","女"),$kehu['sex']);?></li>
                    <li class="pe-item pe-item_width"><span>生日</span><?php echo year('year','','').moon('moon','').day('day','');?></li>
                    <li class="pe-item"><span>生肖</span>
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
                    </li>
                    <li class="pe-item"><span>星座</span>
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
                    </li>
                    <li class="pe-item"><span>民族</span><input name="userNation" value="<?php echo $kehu['Nation'];?>" /></li>
                    <li class="pe-item"><span>身高</span><input name="userHeight" placeholder="请填写多少厘米" value="<?php echo $kehu['height'];?>" /></li>
                    <li class="pe-item"><span>体重</span><input name="userWeight"placeholder="请填写多少斤" value="<?php echo $kehu['weight'];?>" /></li>
                    <li class="pe-item"><span>学历</span>
                    	<select name="userDegree">
                                <option value="">请选择</option>
                                <option value="高中及以下">高中及以下</option>
                                <option value="大专">大专</option>
                                <option value="本科">本科</option>
                                <option value="硕士">硕士</option>
                                <option value="博士及以上">博士及以上</option>
                            </select>
                    </li>
                    <li class="pe-item"><span>婚育情况</span>
                    	<select name="userMarry">
                            <option value="">请选择</option>
                            <option value="未婚未育">未婚未育</option>
                            <option value="离异未育">离异未育</option>
                            <option value="离异有孩归自己">离异有孩归自己</option>
                            <option value="离异有孩归对方">离异有孩归对方</option>
                        </select>
                    </li>
                    <li class="pe-item"><span>家乡</span>
                    	<input name="userHometown" value="<?php echo $kehu['Hometown'];?>" />
                    </li>
                    <li class="pe-item pe-item_width"><span>所在地区</span>
                    	<select name="province"><?php echo RepeatOption("region where province = '辽宁省'","province","--省份--","辽宁省");?></select>
                        <select name="city"><?php echo RepeatOption("region where province = '辽宁省' and city = '沈阳市' ","city","--城市--","沈阳市");?></select>
                        <select name="area"><?php echo IdOption("region where province = '辽宁省' and city = '沈阳市'","id","area","--区县--",$Region['id']);?></select>
                    </li>
                    <li class="pe-item"><span>工作</span><input name="userOccupation" value="<?php echo $kehu['Occupation'];?>" /></li>
                    <li class="pe-item"><span>月收入</span>
                    	<select name="userSalary">
                            <option value="">请选择</option>
                            <option value="2000元及以下">2000元及以下</option>
                            <option value="2000-5000元">2000-5000元</option>
                            <option value="5000-10000元">5000-10000元</option>
                            <option value="10000-20000元">10000-20000元</option>
                            <option value="20000元及以上">20000元及以上</option>
                        </select>
                    </li>
                </ul>
            </div>
         </li>
         <li class="my-personal">
            <h2 class="col"><p class="my-line bg1"></p><span>详细信息</span></h2>
            <div class="my-pe-list bg2">
                <ul class="pe-item-box">
                    <li class="pe-item"><span>吸烟</span>
                    	<select name="userSmoke">
                            <option value="">请选择</option>
                            <option value="是">是</option>
                            <option value="否">否</option>
                        </select>
                    </li>
                    <li class="pe-item"><span>饮酒</span>
                    	 <select name="userDrink">
                            <option value="">请选择</option>
                            <option value="是">是</option>
                            <option value="否">否</option>
                        </select>
                    </li>
                    <li class="pe-item"><span>购房情况</span>
                    	<select name="userBuyHouse">
                            <option value="">请选择</option>
                            <option value="有">有</option>
                            <option value="无">无</option>
                        </select>
                    </li>
                    <li class="pe-item"><span>购车情况</span>
                    	<select name="userBuyCar">
                            <option value="">请选择</option>
                            <option value="有">有</option>
                            <option value="无">无</option>
                        </select>
                    </li>
                    <li class="pe-item"><span>贷款</span>
                    	<select name="userLoan">
                            <option value="">请选择</option>
                            <option value="有">有</option>
                            <option value="无">无</option>
                        </select>
                    </li>
                    <li class="pe-item"><span>兴趣爱好</span><input name="userHobby" value="<?php echo $kehu['Hobby'];?>" placeholder="10字以内" maxlength="10" /></li>
                    <li class="pe-item"><span>优点</span><input name="userAdvantage" value="<?php echo $kehu['Advantage'];?>" /></li>
                    <li class="pe-item"><span>缺点</span><input name="userShortcoming" value="<?php echo $kehu['defect'];?>" /></li>
                    <li class="pe-item"><span>家中排行</span>
                    	<select name="userHomerank">
                            <option value="">请选择</option>
                            <option value="独生子女">独生子女</option>
                            <option value="老大">老大</option>
                            <option value="老二">老二</option>
                            <option value="老三">老三</option>
                            <option value="更多">更多</option>
                        </select>
                    </li>
                    <li class="pe-item"><span>家庭成员</span><input name="userFamily" value="<?php echo $kehu['family'];?>" /></li>
                    <li class="pe-item"><span>微信号</span><input name="userWxNum" value="<?php echo $kehu['wxNum'];?>" /></li>
                    <li class="pe-item"><span>身份证号</span><input name="userIDCard" value="<?php echo $kehu['IDCard'];?>" placeholder="实名认证审核 他人不可见" /></li>
                </ul>
            </div>
         </li>
         <li class="my-personal">
            <h2 class="col"><p class="my-line bg1"></p><span>择偶意向</span></h2>
            <div class="my-pe-list bg2">
                <ul class="pe-item-box">
                    <li class="pe-item pe-item_input"><span>年龄</span><input name="spouseAgeMin" value="<?php echo $kehu['LoveAgeMin'];?>" />
                              <input name="spouseAgeMax" value="<?php echo $kehu['LoveAgeMax'];?>" /></li>
                    <li class="pe-item"><span>生肖</span> <?php echo select("spouseZodiac","","请选择",array('不限',"鼠","牛","虎","兔","龙","蛇","马","羊","猴","鸡","狗","猪"),$kehu['LoveZodiac']);?></li>
                    <li class="pe-item"><span>星座</span><?php echo select("spouseConstellation","","请选择",array('不限','白羊座','金牛座','双子座','巨蟹座','狮子座','处女座','天秤座','天蝎座','射手座','摩羯座','水瓶座','双鱼座'),$kehu['LoveConstellation']);?></li>
                    <li class="pe-item"><span>民族</span><input name="spouseNation" value="<?php echo $kehu['LoveNation'];?>" /></li>
                    <li class="pe-item pe-item_input"><span>身高</span><input name="spouseHeightMin" value="<?php echo $kehu['LoveHeightMin'];?>" />
                            <input name="spouseHeightMax" value="<?php echo $kehu['LoveHeightMax'];?>" /></li>
                    <li class="pe-item pe-item_input"><span>体重</span><input name="spouseWeightMin" value="<?php echo $kehu['LoveWeightMin'];?>" />
                            <input name="spouseWeightMax" value="<?php echo $kehu['LoveWeightMax'];?>" /></li>
                    <li class="pe-item"><span>学历</span><?php echo select("spouseDegree","","请选择",array("不限","高中及以下","大专","本科","硕士","博士及以上"),$kehu['LoveDegree']);?></li>
                    <li class="pe-item"><span>婚育情况</span>
                    	<select name="spouseMarry">
  	                      <?php echo option("请选择",array('不限','未婚未育','离异未育','离异有孩归自己','离异有孩归自己'),$kehu['LoveMarry']);?>
                        </select></li>
                    <li class="pe-item"><span>家乡</span><input name="spouseHometown" value="<?php echo $kehu['LoveHometown'];?>" /></li>
                    <li class="pe-item pe-item_width"><span>所在地区</span>
                    	<select name="province2"><?php echo RepeatOption("region where province = '辽宁省'","province","--省份--","辽宁省");?></select>
                        <select name="city2"><?php echo RepeatOption("region where province = '辽宁省' and city = '沈阳市' ","city","--城市--","沈阳市");?></select>
                        <select name="area2"><?php echo IdOption("region where province = '辽宁省' and city = '沈阳市' ","id","area","--不限--",$LoveRegion['id']);?></select></li>
                    <li class="pe-item"><span>工作</span><input name="spouseOccupation" value="<?php echo $kehu['LoveOccupation'];?>" /></li>
                    <li class="pe-item"><span>月收入</span><?php echo select("spouseSalary","","请选择",array('不限',"2000元及以下","2000-5000元","5000-10000元","10000-20000元","20000元及以上"),$kehu['LoveSalary']);?></li>
                    <li class="pe-item"><span>吸烟</span><?php echo select("spouseSmoke","","请选择",array('不限',"是","否"),$kehu['LoveSmoke']);?></li>
                    <li class="pe-item"><span>饮酒</span><?php echo select("spouseDrink","","请选择",array('不限',"是","否"),$kehu['LoveDrink']);?></li>
                    <li class="pe-item"><span>购房情况</span>
                    	<select name="spouseBuyHouse">
                        	<?php echo option("请选择",array('不限','有','无'),$kehu['LoveHouse']);?>
                        </select></li>
                    <li class="pe-item"><span>购车情况</span>
                    	<select name="spouseBuyCar">
                       		<?php echo option("请选择",array('不限','有','无'),$kehu['LoveCar']);?>
                        </select></li>
                    <li class="pe-item"><span>贷款</span><?php echo select("spouseLoan","","请选择",array('不限',"有","无"),$kehu['LoveLoan']);?></li>
                    <li class="pe-item"><span>兴趣爱好</span><input name="spouseHobby" value="<?php echo $kehu['LoveHobby'];?>" placeholder="10字以内" maxlength="10" /></li>
                    <li class="pe-item"><span>优点</span><input name="spouseAdvantage" value="<?php echo $kehu['LoveAdvantage'];?>" /></li>
                    <li class="pe-item"><span>缺点</span><input name="spouseShortcoming" value="<?php echo $kehu['LoveDefect'];?>" /></li>
                    <li class="pe-item"><span>家中排行</span>
						<?php echo select("spouseHomerank","","请选择",array('不限',"独生子女","老大","老二","老三","更多"),$kehu['LoveHomeRanking']);?></li>
                    <li class="pe-item"><span>家庭成员</span><input name="spouseFamily" value="<?php echo $kehu['LoveFamily'];?>" /></li>
                </ul>
            </div>
         </li>
     </ul>
     <div class="pe-btn-box"><a href="javascript:;" class="pe-btn fz16 col1 fw2" onClick="Sub('personalDataForm','<?php echo "{$root}m/mLibrary/mUsData.php";?>')">保存</a></div>
     </form>
</div>
<?php echo warn().mFooter();?>
<!--底部-->
</body>
    <script>
	$(function(){
		//根据省份获取下属城市下拉菜单 基本资料
		$(document).on('change','[name=personalDataForm] [name=province]',function(){
			$('[name=personalDataForm] [name=area]').html("<option value=''>--区县--</option>");	
			$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostCity:$(this).val()},function(data){
				$('[name=personalDataForm] [name=city]').html(data.city);		
			},"json");	
		})
		//根据省份和城市获取下属区域下拉菜单 基本资料
		$(document).on('change','[name=personalDataForm] [name=city]',function(){
			$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostArea:$('[name=personalDataForm] [name=province]').val(),
			CityPostArea:$(this).val()},function(data){
				$('[name=personalDataForm] [name=area]').html(data.area);
			},"json");	
		})
		//根据省份获取下属城市下拉菜单 择偶意向
		$(document).on('change','[name=personalDataForm] [name=province2]',function(){
			$('[name=personalDataForm] [name=area2]').html("<option value=''>--区县--</option>");	
			$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostCity:$(this).val()},function(data){
				$('[name=personalDataForm] [name=city2]').html(data.city);
			},"json");
		})
		//根据省份和城市获取下属区域下拉菜单 择偶意向
		$(document).on('change','[name=personalDataForm] [name=city2]',function(){
			$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostArea:$('[name=personalDataForm] [name=province2]').val(),
			CityPostArea:$(this).val()},function(data){
				$('[name=personalDataForm] [name=area2]').html(data.area);
			},"json");	
		})
		<?php 
	echo //显示基本资料
	KongTime("personalDataForm.year",$kehu['Birthday'],"Y").
	KongTime("personalDataForm.moon",$kehu['Birthday'],"m").
	KongTime("personalDataForm.day",$kehu['Birthday'],"d").
	KongSele("personalDataForm.userConstellation",$kehu['constellation']).
	KongSele("personalDataForm.userZodiac",$kehu['Zodiac']).
	KongSele("personalDataForm.userDegree",$kehu['degree']).
	KongSele("personalDataForm.userMarry",$kehu['marry']).
	KongSele("personalDataForm.userChildren",$kehu['children']).
	KongSele("personalDataForm.userSalary",$kehu['salary']).
	KongSele("personalDataForm.userBuyHouse",$kehu['BuyHouse']).
	KongSele("personalDataForm.userBuyCar",$kehu['BuyCar']).
	KongSele("personalDataForm.userSmoke",$kehu['smoke']).
	KongSele("personalDataForm.userDrink",$kehu['drink']).
	KongSele("personalDataForm.userLoan",$kehu['loan']).
	KongSele("personalDataForm.userHomerank",$kehu['HomeRanking']).
	KongSele("personalDataForm.userWeight",$kehu['weight']);
?>
	})
	</script>
</html>
