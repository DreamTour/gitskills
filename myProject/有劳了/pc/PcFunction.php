<?php
/*********************引入库文件*********************/
#前端不用管
require_once dirname(__FILE__)."/OpenFunction.php";
/*******************如果是移动设备，则跳转到手机网站首页******************************/
if(isMobile()){
	header("Location:{$root}m/mindex.php");
	exit(0);
}
/*******************网站头部******************************/
function pcHeader(){
	$root = $GLOBALS['root'];
	$kehu = $GLOBALS['kehu'];
	if($GLOBALS['KehuFinger'] == 2) {
		$login = "<li> <a href='{$root}user/usLogin.php'>个人登录</a> </li>
			<li> <a href='{$root}seller/seLogin.php'>企业登录</a> </li>";
		$ContactName = "";
	} else{
		if(strstr($GLOBALS['ThisUrl'],"?")==false){
			$b="?";
		}else{
			$b="&";
		}
		$login = "<li> <a href='{$GLOBALS['ThisUrl']}{$b}delete=client'>退出登录</a> </li>";
		if ( $kehu['type'] == "个人" ) {
			$myUrl = "user/user.php";
		}
		else if ( $kehu['type'] == "企业" ) {
			$myUrl = "seller/seller.php";
		}
		$ContactName = "<a href='{$root}{$myUrl}'>欢迎".$kehu['ContactName']."!</a>";
	}
	$city = null;
	$regionSql = mysql_query("select distinct province from region order by convert(province using gbk) ");
	while($region = mysql_fetch_assoc($regionSql)){
		$city.="<a class='partProvince' href='javascript:;'>{$region['province']}</a>";
	}
	$pcHeader = "
	<!--顶部-->
	<div class='notice'>
	    <div class='row clearfix'>
			<div class='notice-text fl'>".website("dik60717956tJ")."</div>
			{$ContactName}
			<ul class='clearfix fr'>
				{$login}
			</ul>
	    </div>
	</div>
	<!--头部-->
	<div class='header'>
	    <div class='row clearfix'> <a href='{$root}index.php'><img src='".img("kmc57109735qO")."' class='fl logo' /></a>
		    <div class='city fl fz13'>
				<span id='province'>省份</span> |
				<span id='city'>城市<span>
		    </div>
				<div class='provinceBox hide'>
				<div class='dropcaret'><span class='caret-in'></span><span class='caret-out'></span></div>
				{$city}
		    </div>
		    <div class='cityBox hide'>
		    </div>
		    <div class='search-box fl'>
		    	<input id='searchText' type='text' placeholder='请输入搜索关键词' class='fz14' value='{$_GET['search_text']}'>
		    	<a id='searchBtn' href='javascript:void(0)' class='search-btn bg1 col1 fz18'>搜索</a>
		    </div>
	    </div>
	</div>
	<script>
	//选择省份城市
	$(function(){		
		//声明变量
		var objProvince = $('#province');
		var objCity = $('#city');
		var objProvinceBox = $('.provinceBox');
		var objCityBox = $('.cityBox');
		var partProvince = $('.partProvince');
		document.addEventListener('click',function(event) {
			objProvinceBox.hide();
			objCityBox.hide();	
		},false);
		objProvinceBox.click(function(event) {
			event.stopPropagation();	
		});
		objProvince.click(function(event) {
			event.stopPropagation();
			objProvinceBox.show();
			objCity.html('城市');
		});
		var provinceValue = null;
		var cityValue = null;
		//各个省份点击
		partProvince.click(function(event) {
			event.stopPropagation();
			objProvinceBox.hide();
			objProvince.html($(this).html());
			provinceValue = $(this).html();//存储省份
			objCityBox.show();
			_this = this;
			var dropcaret = \"<div class='dropcaret'><span class='caret-in'></span><span class='caret-out'></span></div>\";
			$.post('{$root}library/PcData.php',{ProvinceBackCity:_this.innerHTML},function(data) {
				objCityBox.html(dropcaret+data.html);
				if($('.partCity').lengh != 0){
					$('.partCity').click(function(){
						event.stopPropagation();
						objCityBox.hide();
						objCity.html($(this).html());	
						cityValue = $(this).html();//存储城市
					})
				}
			},'json');
		});
		//城市点击
		objCity.click(function(event) {
			event.stopPropagation();
			objCityBox.show();
			objProvince.html(objProvince.html());
			provinceValue = objProvince.html();//存储省份
			var dropcaret = \"<div class='dropcaret'><span class='caret-in'></span ><span class='caret-out'></span></div>\";
			$.post('{$root}library/PcData.php',{ProvinceBackCity:objProvince.html()},function(data) {
				objCityBox.html(dropcaret+data.html);
				if($('.partCity').lengh != 0){
					$('.partCity').click(function(){
						event.stopPropagation();
						objCityBox.hide();
						objCity.html($(this).html());
						cityValue = $(this).html();//存储城市
					})
				}
			},'json');
		})
		//点击阻止冒泡
		objCityBox.click(function(event){
			event.stopPropagation();
			//设置
			store.set('provinceCookie', provinceValue);
			store.set('CityCookie', cityValue);
		});
		//调用
		objProvince.html(store.get('provinceCookie'));
		objCity.html(store.get('CityCookie'));
		//顶部搜索
		$('#searchBtn').click(function() {
			//赋值
			var provinceCookie = store.get('provinceCookie');
			var cityCookie = store.get('CityCookie');
			window.location.href = '{$root}talent.php?search_text=' + $('#searchText').val()+'&province='+provinceCookie+'&city='+cityCookie;	
		});
		document.onkeydown=keyDownSearch;    
		function keyDownSearch(e) {  
			// 兼容FF和IE和Opera  
			var theEvent = e || window.event;  
			var code = theEvent.keyCode || theEvent.which || theEvent.charCode;  
			if (code == 13) {   
				$('#searchBtn').click();//具体处理函数  
				return false;  
			}  
			return true;  
		} 
		})
	</script>
	";	
	return $pcHeader;
}
/*******************网站导航******************************/
function pcNavigation(){
	$root = $GLOBALS['root'];
	$kehu = $GLOBALS['kehu'];
	//判断个人中心应该跳转的连接
	if ( $kehu['type'] == "个人" ) {
		$myUrl = "user/user.php";	
	}
	else if ( $kehu['type'] == "企业" ) {
		$myUrl = "seller/seller.php";	
	}
	$pcNavigation = "
	<!--导航-->
	<div class='nav-main bg1'>
		<ul class='row'>
			<li class='nav-list'><a href='{$root}index.php'>首页</a></li>
			<li class='nav-list ".menu("job.php","navCurrent")."'><a href='{$root}job.php'>优职</a></li>
			<li class='nav-list ".menu("talent.php","navCurrent")."'><a href='{$root}talent.php'>优才</a></li>
			<li class='nav-list ".menu("PartTimeJob.php","navCurrent")."'><a href='{$root}PartTimeJob.php'>学生兼职</a></li>
			<li class='nav-list ".menu("news.php","navCurrent")."'><a href='{$root}news.php'>资讯</a></li>
			<li class='nav-list ".menu("{$myUrl}","navCurrent")."'><a href='{$root}{$myUrl}'>我的</a></li>
	        <li class='nav-list' id='attention'><a href='javascript:;'>关注</a></li>
		    <li class='attention-box' id='attentionBox'><img src='".img("EUL61841061Oa")."' width='164' height='200' /></li>
		</ul>
	</div>
	<script>
		$(function() {
			//关注鼠标移入移出
			var attention=document.getElementById('attention'),
				attentionBox=document.getElementById('attentionBox');
			attention.onmouseover=function(){
				attentionBox.style.display='block';
			};
			attention.onmouseout=function(){
				attentionBox.style.display='none';
			};	
		})
	</script>
	";	
	return $pcNavigation;
}
/*******************发布劳务供给******************************/
function supply(){
	$root = $GLOBALS['root'];
	$kehu = $GLOBALS['kehu'];
	//供给
	
	if(empty($_GET['supply_id'])){
		$SupplyButton = "发布";
	}else{
		$SupplyButton = "修改";
		$supply = query("supply"," id = '$_GET[supply_id]'");
		if($supply['id'] != $_GET['supply_id']){
			$_SESSION['warn'] = "未找到此供给信息";
			header("location:{$root}user/user.php");
			exit(0);
		}
		$SupplyClassify = query("classify","id = '$supply[ClassifyId]'");
	}
	//循环供给图片
	$imgSql = mysql_query("select * from SupplyImg where SupplyId = '$_GET[supply_id]' order by time desc");
	$imgNum = mysql_num_rows(mysql_query("select * from SupplyImg where SupplyId = '$_GET[supply_id]'"));
	$img = "";
	if($imgNum == 0){
		$img = "
			<div class='pe-photo-show fl'><img src='".img("PGI58296514zx")."' /></div>
		";
	}else{
		while($array = mysql_fetch_array($imgSql)){
			$img .= "
					<div class='pe-photo-show fl'><span title='点击删除图片' onClick=\"window.location.href='{$root}library/uspost.php?deletePhotoImg={$array['id']}#supplyAnchor'\">x</span/>
					<img src='{$root}{$array['src']}'></div>
					";	
		}	
	}
	//劳务供给列表
	$supplySql = mysql_query("select * from supply where clientType = '$kehu[type]' and khid = '$kehu[khid]' ");
	$supplyList = "";
	while($array = mysql_fetch_assoc($supplySql)){
		$supplyList .= "
			<div class='pe-info-compress clearfix'>
				<h2 class='fl'>{$array['title']}</h2>
				<div class='fr'>
					<a href='{$root}user/user.php?type=supply&supply_id={$array['id']}#supplyAnchor' class='pe-edit-btn' data_edit_id='{$array['id']}'>编辑</a>
					<a href='javascript:;' class='pe-delete-btn' data_del_id='{$array['id']}'>删除</a>
					<a href='{$root}JobMx.php?supplyMx_id={$array['id']}' class='pe-preview-btn' >预览</a>
				</div>
			</div>
		";	
	}
	//循环一个checkbox
	$TimeTableCheckBox = "";
	$i = 1;
	while($i<=21){
		$TimeTableCheckBox .= "<input class='TimeTableCheckBox' name='TimeTable[]' type='checkbox' value='{$i}'>";
		$i++;
	}
	//判断是否显示选择个人还是商家 主语显示我还是我们 链接应该跳转到哪里
	if ($kehu[type] == "个人") {
		$IdentityType = "
			<li><span class='pe-black01'>我是</span>
				<select class='select-box' name='supplyMy'>
					".option('请选择个人或者商家',array('个人','商家'),$supply['IdentityType'])."
				</select>
				<input name='supplyName' type='text' class='input-box' value='{$supply['CompanyName']}' placeholder='选择商家，请填写商家名称'>
			</li>
		";
		$my = "我";
		$url  = "{$root}user/user.php?type=supply";
	}
	else {
		$my = "我们";
		$url  = "{$root}seller/seller.php?type=supply";
	}
	$supply = "
		<div class='pe-info hide'>
                	<div class='pe-info-title' id='supply'><i class='icon2 mine-icon5'></i><span>劳务供给</span><a href='{$url}' class='fr new-add'>+发布劳务供给</a></div>
                    {$supplyList}
                    <form name='supplyForm'>
                    <div class='pe-info-content clearfix' id='supplyAnchor'>
                        <ul class='labour-info'>
                            <li><span class='pe-black01'>{$my}提供</span>
                                ".RepeatSelect('classify','type','supplyColumn','select-box','请选择劳务主项目',$SupplyClassify['type'])."
                                <select class='select-box' name='supplyColumnChild'>
                                	 ".IdOption("classify where type = '$SupplyClassify[type]' ",'id','name','请选择劳务子项目',$SupplyClassify['id'])."
                                </select>
                                <input name='supplyOther' type='text' class='input-box' value='{$supply['ClassifyOther']}' placeholder='请填写其他'>
                            </li>
							{$IdentityType}
                            <li><span class='pe-black01'>方式</span>
                            	<select class='select-box' name='supplyMode'>
                                	".option('请选择劳务提供方式',array('上门','如约'),$supply['mode'])."
                                </select>
                            </li>
                            <li><span class='pe-black01'>面向</span>
                            	<select class='select-box' name='supplyFace'>
                                	".option('请选择劳务面向',array('全国','本地'),$supply['face'])."
                                </select>
                            </li>
                            <li  class='clearfix'><span class='pe-black01 fl'>收费</span>
                            	<div class='time-table fl'>
                                	<div class='time-check'>".radio('supplyPayType',array('面议','如约',"薪酬"),$supply['payType'])."</div>
                                    <div class='hide' style='padding: 10px 0 0 3px;' id='supplyPayBox'>
										<input name='supplyPay' type='text' class='input-box' value='{$supply['pay']}' placeholder='请填写劳务收费'><span class='pe-yuan'>元 /</span>
										<select class='select-box' name='supplyPayCycle'>
										".option('请选择劳务结算方式',array('小时','日','周','月'),$supply['PayCycle'])."
										</select>
                                    </div>
                                </div>
                            </li>
                            <li><span class='pe-black01'>类型</span>
                           		<select class='select-box' name='supplyType'>
                               		".option('请选择劳务类型',array('全职','兼职'),$supply['type'])."
                                </select>
                            </li>
                            <li class='clearfix'><span class='pe-black01 fl'>工作时间</span>
                                 <div class='time-table fl'>
                                	<div class='time-check'>".radio('supplyWorkingHours',array('时间表','如约'),$supply['WorkingHours'])."</div>
                                    <div class='time-box hide' id='timeBox'>
                                    	<ul class='time-head clearfix'>
                                        	<li class='time-title'>星期</li><li>周一</li><li>周二</li><li>周三</li><li>周四</li><li>周五</li><li>周六</li><li>周日</li>
                                        </ul>
                                        <ul class='time-body clearfix'>
                                        	<li class='time-title'>上午</li>
                                            <li class='time-current' TimeTable='1'></li>
                                            <li class='time-current' TimeTable='2'></li>
                                            <li class='time-current' TimeTable='3'></li>
                                            <li class='time-current' TimeTable='4'></li>
                                            <li class='time-current' TimeTable='5'></li>
                                            <li class='time-current' TimeTable='6'></li>
                                            <li class='time-current' TimeTable='7'></li>
                                        </ul>
                                        <ul class='time-body clearfix'>
                                        	<li class='time-title'>下午</li>
                                            <li class='time-current' TimeTable='8'></li>
                                            <li class='time-current' TimeTable='9'></li>
                                            <li class='time-current' TimeTable='10'></li>
                                            <li class='time-current' TimeTable='11'></li>
                                            <li class='time-current' TimeTable='12'></li>
                                            <li class='time-current' TimeTable='13'></li>
                                            <li class='time-current' TimeTable='14'></li>
                                        </ul>
                                        <ul class='time-body clearfix'>
                                        	<li class='time-title'>业余时间</li>
                                            <li class='time-current' TimeTable='15'></li>
                                            <li class='time-current' TimeTable='16'></li>
                                            <li class='time-current' TimeTable='17'></li>
                                            <li class='time-current' TimeTable='18'></li>
                                            <li class='time-current' TimeTable='19'></li>
                                            <li class='time-current' TimeTable='20'></li>
                                            <li class='time-current' TimeTable='21'></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li><span class='pe-black01'>标题</span>
                            	<input name='supplyTitle' type='text' class='input-box' value='".$supply['title']."' maxlength='10' placeholder='请输入标题,10字以内'>
                            </li>
                            <li><span class='pe-black01'>关键词	</span>
                            	<input name='supplyKeyWord' type='text' class='input-box' value='".$supply['KeyWord']."' placeholder='选填用逗号隔开如：词1，词2，词3'>
                            </li>
                            <li style='position: relative;'>
                            	<span class='pe-black01'>供给说明</span>
                            	<textarea name='supplyText' class='textarea-box textareaLength-one' maxlength='80' placeholder='展示/介绍/说明：80字以内，不可输入联系方式、敏感词及不良信息。'>".$supply['text']."</textarea>
                            	<div style='position: absolute;right: 70px; bottom: 10px;font-size: 14px;'><span class='textLength-one'>0</span> / 80</div>
                            </li>
                      		<li class='clearfix'><span class='pe-black01 fl'>上传照片</span>
                            	<a href='javascript:;' class='idUpload-btn fl' id='idUpload_btn'>点击上传</a>
                                ".$img."
                                <div class='pe-long fl'>
                            </li>
                            <li><p class='pe-note01'>注：请上传介绍图片，最多2张。</p></li>
							<li class='extra'><input name='supplyAgree' type='checkbox' value='yes'>
								<span> 我已阅读并同意“有劳了网”《<a style='color:#689fee;' href='{$root}help.php?type=law'>法律申明</a>》</span>
							</li>
                            <li class='pe-btn-box02'>
                            	<a href='javascript:;' class='peSave-btn' onClick=\"Sub('supplyForm','{$root}library/usdata.php')\">{$SupplyButton}</a>
                            </li>
                        </ul>
                    </div>
                    <div class='hide'>".$TimeTableCheckBox."</div>
                    <input name='SupplyId' type='hidden' value='".$_GET['supply_id']."'>	
                    </form>
                </div>
				<div style='display:none;'>				
					<form name='kehuSupplyImgForm' action='{$root}library/uspost.php' method='post' enctype='multipart/form-data'>
						<input name='kehuSupplyImgUpload' type='file' />
						<input name='SupplyId' type='hidden' value='{$_GET['supply_id']}' />
					</form>
				</div>
				<script>
					$(function() {
						//供给图片上传
						$('#idUpload_btn').click(function(){
						    document.kehuSupplyImgForm.kehuSupplyImgUpload.click();
						})
						document.kehuSupplyImgForm.kehuSupplyImgUpload.onchange = function(){
							$.post('{$root}library/usdata.php',$('[name=supplyForm]').serialize(),function(data){
								if (data.warn == 2) {
									document.supplyForm.SupplyId.value = data.id;
									document.kehuSupplyImgForm.SupplyId.value = data.id;
									document.kehuSupplyImgForm.submit();
								}
								else {
									warn(data.warn);		
								}
							},'json');
						}
						//点击同意我已阅读并同意“有劳了网”《法律申明》
						$('[name=supplyAgree]').prop('checked', true);
					})
				</script>
	";
	return $supply;	
}
/*******************发布劳务需求******************************/
function demand(){
	$root = $GLOBALS['root'];
	$kehu = $GLOBALS['kehu'];
	//需求
	if(empty($_GET['demand_id'])){
		$demandButton = "发布";
	}else{
		$demandButton = "修改";
		$demand = query("demand"," id = '$_GET[demand_id]'");
		if($demand['id'] != $_GET['demand_id']){
			$_SESSION['warn'] = "未找到此供给信息";
			header("location:{$root}user/user.php");
			exit(0);
		}
		$demandClassify = query("classify","id = '$demand[ClassifyId]'");
	}
	//劳务需求列表
	$demandSql = mysql_query("select * from demand where clientType = '$kehu[type]' and khid = '$kehu[khid]' ");
	$demandList = "";
	while($array = mysql_fetch_assoc($demandSql)){
		$demandList .= "
			<div class='pe-info-compress clearfix'>
				<h2 class='fl'>{$array['title']}</h2>
				<div class='fr'>
					<a href='{$root}user/user.php?type=demand&demand_id={$array['id']}#demandAnchor' class='pe-edit-btn' data_edit_id2='{$array['id']}'>编辑</a>
					<a href='javascript:;' class='pe-delete-btn' data_del_id2='{$array['id']}'>删除</a>
					<a href='{$root}recruit.php?demandMx_id={$array['id']}' class='pe-preview-btn' >预览</a>
				</div>
			</div>
		";	
	}
	//判断是否显示选择个人还是商家 主语显示我还是我们
	if ($kehu[type] == "个人") {
		$my = "我";
		$url = "{$root}user/user.php?type=demand";
	}
	else {
		$my = "我们";
		$url = "{$root}seller/seller.php?type=demand";
	}
	$demand = "
		<div class='pe-info hide'>
                	<div class='pe-info-title' id='demand'><i class='icon2 mine-icon6'></i><span>劳务需求</span><a href='{$url}' class='fr new-add'>+发布劳务需求</a></div>
                    ".$demandList."
                    <form name='demandForm'>
                    <div class='pe-info-content clearfix' id='demandAnchor'>
                        <ul class='labour-info'>
                            <li><span class='pe-black01'>{$my}要找</span>
                            	".RepeatSelect('classify','type','demandColumn','select-box','请选择劳务主项目',$demandClassify['type'])."
                                <select class='select-box' name='demandColumnChild'>
                                	".IdOption("classify where type = '{$demandClassify[type]}' ",'id','name','请选择劳务子项目',$demandClassify['id'])."
                                </select>
                                <input name='demandOther' type='text' class='input-box' value='".$demand['ClassifyOther']."' placeholder='请填写其他'>
                            </li>
                            <li><span class='pe-black01'>方式</span>
                            	<select class='select-box' name='demandMode'>
                                	".option('请选择劳务提供方式',array('上门','如约'),$demand['mode'])."
                                </select>
                            </li>
                            <li><span class='pe-black01'>面向</span>
                            	<select class='select-box' name='demandFace'>
                                	".option('请选择劳务面向',array('全国','本地'),$demand['face'])."
                                </select>
                            </li>
                            <li  class='clearfix'><span class='pe-black01 fl'>收费</span>
                            	<div class='time-table fl'>
                                	<div class='time-check'>".radio('demandPayType',array('面议','如约',"薪酬"),$demand['payType'])."</div>
                                    <div class='hide' style='padding: 10px 0 0 3px;' id='demandPayBox'>
										<input name='demandPay' type='text' class='input-box' value='{$demand['pay']}' placeholder='请填写劳务收费'><span class='pe-yuan'>元 /</span>
										<select class='select-box' name='demandPayCycle'>
										".option('请选择劳务结算方式',array('小时','日','周','月'),$demand['PayCycle'])."
										</select>
                                    </div>
                                </div>
                            </li>
                            <li class='pe-date-box'><span class='pe-black01'>需求时间</span>
								".year('StartYear','select_width_time','new',$demand['StartTime']).moon('StartMoon','select_width_time',$demand['StartTime']).day('StartDay','select_width_time',$demand['StartTime'])."&nbsp;&nbsp;—&nbsp;&nbsp;
                                ".year('EndYear','select_width_time','new',$demand['EndTime']).moon('EndMoon','select_width_time',$demand['EndTime']).day('EndDay','select_width_time',$demand['EndTime'])."
                            </li>
                            <li><span class='pe-black01'>类型</span>
                           		<select class='select-box' name='demandType'>
                               		".option('请选择劳务类型',array('全职','兼职'),$demand['type'])."
                                </select>
                            </li>
                            <li><span class='pe-black01'>标题</span>
                            	<input name='demandTitle' type='text' class='input-box' value='".$demand['title']."' maxlength='10' placeholder='请输入标题,10字以内'>
                            </li>
                            <li><span class='pe-black01'>关键词</span>
                            	<input name='demandKeyWord' type='text' class='input-box' value='".$demand['KeyWord']."' placeholder='选填用逗号隔开如：词1，词2，词3'>
                            </li>
                            <li style='position: relative;'>
                            	<span class='pe-black01'>需求说明</span>
                            	<textarea name='demandText' class='textarea-box textareaLength-two' maxlength='80' placeholder='展示/介绍/说明：80字以内，不可输入联系方式、敏感词及不良信息。'>".$demand['text']."</textarea>
								<div style='position: absolute;right: 70px; bottom: 10px;font-size: 14px;'><span class='textLength-two'>0</span> / 80</div>
                            </li>
							<li class='extra'><input name='demandAgree' type='checkbox' value='yes'><span> 我已阅读并同意“有劳了网”《<a style='color:#689fee;' href='{$root}help.php?type=law'>法律申明</a>》</span></li>
                            <li class='pe-btn-box02'><a href='javascript:;' class='peSave-btn' onClick=\"Sub('demandForm','{$root}library/usdata.php')\">".$demandButton."</a>
							</li>
                        </ul>
                    </div>
                    <input name='demandId' type='hidden' value='".$_GET['demand_id']."'>
                    </form>
                </div>
                <script>
                	$(function() {
                		//点击同意我已阅读并同意“有劳了网”《法律申明》
						$('[name=demandAgree]').prop('checked', true);
                	})
                </script>
	";
	return $demand;	
}
/*******************网站底部******************************/
function pcFooter(){
	$root = $GLOBALS['root'];
	$kehu = $GLOBALS['kehu'];
	//判断个人中心应该跳转的连接
	if ( $kehu['type'] == "个人" ) {
		$myUrl = "user/user.php";	
	}
	else if ( $kehu['type'] == "企业" ) {
		$myUrl = "seller/seller.php";	
	}
	$pcFooter = "
	<div class='footer bg1 col1'>
	  <div class='row'>
		<div class='footer-nav'>
			<a href='{$root}index.php'>首页</a>
			<a href='{$root}job.php'>优职</a>
			<a href='{$root}talent.php'>优才</a>
			<a href='{$root}PartTimeJob.php'>学生兼职</a>
			<a href='{$root}news.php'>资讯</a>
			<a href='{$root}{$myUrl}'>我的</a><br />
			<a href='{$root}help.php?type=contact'>联系我们</a>
			<a href='{$root}help.php?type=about'>关于我们</a>
			<a href='{$root}help.php?type=law'>法律声明</a>
		</div>
		<p>".website("uisjue410q")."</p>
		<p>".website("WnZ58122742ym")."</p>
	  </div>
	</div>
	</body>
	</html>
	";
	return $pcFooter;
}
?>