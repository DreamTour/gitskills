<?php 
include "../library/PcFunction.php";
UserRoot("pc");
$Region = query("region", "id = '$kehu[RegionId]' ");
$company = query("company","khid = '$kehu[khid]'");
//判断手持身份证照片
if(empty($kehu['IDCardHand'])){
	$kehu['IDCardHand'] = img("PGI58296514zx");
}else{
	$kehu['IDCardHand'] = $root.$kehu['IDCardHand'];
}
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
//我的收藏
$collectSql = mysql_query("select * from collect where khid = '$kehu[khid]' ");
$collectNum = mysql_num_rows($collectSql);
$myCollection = "";
if ($collectNum == 0) {
	$myCollection = "一条收藏信息都没有";
}
else{
	while($array = mysql_fetch_assoc($collectSql)) {
		$client = query("kehu", "khid = '$array[khid]'");
		$time = substr($array['time'], 0, 10);
		if ($array['Target'] == "优职") {
			$demand = query("demand", "id = '$array[TargetId]' ");
			$address = query("region", "id = '$client[RegionId]' ");
			$url = root . "recruit.php?demandMx_id=".$demand['id'];
			$title = $demand['title'];
			$other = $address['city']."-".$address['area'];
		}
		else if ($array['Target'] == "优才") {
			$supply = query("supply", "id = '$array[TargetId]' ");
			$url = root . "JobMx.php?supplyMx_id=".$supply['id'];
			$title = $supply['title'];
			$other = $personal['sex'];
		}
		$myCollection .= "
		<li class='collect-items'>
			<a href='{$url}'>
				<span style='width:320px;'>{$title}</span>
				<span style='width:300px;'>{$client['ContactName']}</span>
				<span style='width:150px;'>{$other}</span>
				<span style='width:82px;'>{$time}</span>
			</a>
		</li>
		";
	}
}
//执行供给，需求两个模块，防止location不起作用
$s = supply();
$d = demand();
//我的个人中心跳转对应的分类
if (isset($_GET['type'])) {
	if($_GET['type'] == "basicData") {
		$ThisUrl .= "?type=basicData";
		$number = 1;
	}
	else if ($_GET['type'] == "supply") {
		$ThisUrl .= "?type=supply";
		$number = 2;
	}
	else if ($_GET['type'] == "demand") {
		$ThisUrl .= "?type=demand";
		$number = 3;
	}
	else if ($_GET['type'] == "collection") {
		$ThisUrl .= "?type=collection";
		$number = 4;
	}
	else {
		$ThisUrl .= "?type=basicData";
		$number = 1;
	}
}
else {
	header("location:{$ThisUrl}?type=basicData");
	exit(0);
}
echo head("pc").pcHeader();
?>
<!--内容-->
<div class="info-container"> 
   <!--导航-->
    <?php echo pcNavigation();?>
    <!--row-->
    <div class="row">
        <!--广告-->
        <div class="info-ad"><a href="javascript:;"><img src="<?php echo img("RCV57016301qE")?>"></a></div>
        <!--内容-->
        <div class="mine-box clearfix">
        	<!--左边目录-->
            <ul class="mine-list fl">
            	<li class="peMine-list bg1 col1">我的</li>
                <li class="userAnchor"><i class="icon2 mine-icon1 <?php echo MenuGet("type","basicData","");?>"></i>
					<a href="<?php echo root."seller/seller.php?type=basicData";?>">个人资料</a>
				</li>
                <li class="supplyAnchor"><i class="icon2 mine-icon2 <?php echo MenuGet("type","basicData","");?>"></i>
					<a href="<?php echo root."seller/seller.php?type=supply";?>">我的供给</a>
				</li>
                <li class="demandAnchor"><i class="icon2 mine-icon3 <?php echo MenuGet("type","basicData","");?>"></i>
					<a href="<?php echo root."seller/seller.php?type=demand";?>">我的需求</a>
				</li>
                <li class="myCollection"><i class="icon2 mine-icon7 <?php echo MenuGet("type","basicData","");?>"></i>
					<a href="<?php echo root."seller/seller.php?type=collection";?>">我的收藏</a>
				</li>
            </ul>
 <!--右边-->
            <div class="mine-right fl">
            	<!--个人资料-->
            	<div class="pe-info" id="userAnchor">
                	<div class="pe-info-title"><i class="icon2 mine-icon4"></i><span>企业/工商用户基本资料</span></div>
                    <form name="sellerForm">
                    <div class="pe-info-content clearfix">
                    	<div class="portrait fl">
                        	<img src="<?php echo $kehu['ico'];?>" width="120" height="120" />
                            <div class="portrait-text"><a href="javascript:;" onClick='document.logoPortraitForm.logoPortraitUpload.click()'>修改</a><span>丨</span><a href="javascript:;" onClick='document.logoPortraitForm.logoPortraitUpload.click()'>上传</a></div>
                            <div class="photo-text">请上传照片，可以是企业logo，门头，工作间等。</div>
                        </div>
                        <ul class="content-info fl clearfix">
                            <li class="info-item"><span class="pe-black02"><s>*</s>联系人全名</span>
                            	<input value="<?php echo $kehu['ContactName'];?>" name="sellerContactName" type="text" class="input-box input-box01">
                               <!-- <input name="sellerContactNameOpen" type="checkbox" value=""><span class="pe-gray">选择公开</span>-->
                            </li>
                            <li class="info-item"><span class="pe-black02"><s>*</s>单位全称</span>
                            	<input value="<?php echo $company['CompanyName'];?>" name="sellerCompanyName" type="text" class="input-box input-box01">
                            </li>
                            <li class="info-item"><span class="pe-black02"><s>*</s>法人/负责人全名</span>
                            	<input value="<?php echo $company['LegalName'];?>" name="sellerLegalName" type="text" class="input-box input-box01">
                            	<span class="pe-gray">不公开</span>
                            </li>
                            <li class="info-item"><span class="pe-black02"><s>*</s>单位地址</span>
								<select name="province" class="select_width_len"><?php echo RepeatOption("region","province","--省份--",$Region['province']);?></select>
                                <select name="city" class="select_width_len"><?php echo RepeatOption("region where province = '$Region[province]' ","city","--城市--",$Region['city']);?></select>
                                <select name="area" class="select_width_len"><?php echo IdOption("region where province = '$Region[province]' and city = '$Region[city]'","id","area","--区县--",$kehu['RegionId']);?></select>
                            </li>
                            <li class="info-item"><span class="pe-black02"><s>*</s>法人/负责人身份证号</span>
                            	<input value="<?php echo $kehu['IDCard'];?>" name="sellerIDCard" type="text" class="input-box input-box01">
                            	<span class="pe-gray">不公开</span>
                            </li>
                            <li class="info-item"><span class="pe-black02"><s>*</s>营业执照/社会统一信用代码</span>
                            	<input value="<?php echo $company['BusinessLicense'];?>" name="sellerBusinessLicense" type="text" class="input-box input-box01">
                            	<span class="pe-gray">不公开</span>
                            </li>
                            <li class="info-item"><span class="pe-black02"><s>*</s>邮箱</span>
                            	<input value="<?php echo $kehu['email'];?>" name="sellerEmail" type="text" class="input-box input-box01">
                            	<!--<input name="sellerEmailOpen" type="checkbox"><span class="pe-gray">选择公开</span>-->
                            </li>
                            <li class="info-item"><span class="pe-black02"><s>*</s>联系手机</span>
                            	<input value="<?php echo $kehu['ContactTel'];?>" name="sellerContactTel" type="text" class="input-box input-box01">
                            </li>
                            <li class="clearfix"><span class="pe-black fl">营业执照</span>
                                <a href="javascript:;" class="idUpload-btn fl" onClick="document.BusinessLicenseForm.BusinessLicenseUpload.click()">点击上传</a>
                                <div class="pe-photo-show fl"><img src="<?php echo $company['BusinessLicenseImg'];?>" width="120" height="120" /></div>
                            </li>
                            <li class="clearfix"><span class="pe-black fl">法人手持身份证照片</span>
                                <a href="javascript:;" class="idUpload-btn fl" onClick="document.seIDCardHandForm.seIDCardHandUpload.click()">点击上传</a>
                                <div class="pe-photo-show fl"><img src="<?php echo $kehu['IDCardHand'];?>" width="120" height="120" /></div>
                            </li>
							<li><p class="pe-note" style="line-height: 25px;"><?php echo website("Gat62449970Xp");?></p></li>
                            <li class="pe-btn-box">
								<a href="javascript:;" class="peSave-btn" onClick="Sub('sellerForm','<?php echo root."library/usdata.php";?>')">保存</a>
								<!--<a href="javascript:;" class="peCancel-btn">取消</a>-->
							</li>
                        </ul>
                    </div>
                    </form>
                </div>
                <!--发布劳务供给-->
				<?php echo $s;?>
                <!--发布劳务需求-->
				<?php echo $d;?>
                <!--我的收藏-->
               	<div class="pe-info" id="myCollection">
                	<div class="pe-info-title"><i class="icon2 mine-icon8"></i><span>我的收藏</span></div>
                    <ul class="pe-info-content clearfix">
                    	<?php echo $myCollection;?>
                    </ul>
                </div>
            </div>
            <!--右边-->
       </div>
    </div>
    <!--row-->
</div>
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
</div>
<!--隐藏表单结束-->
<script>
$(document).ready(function(){
	//我的个人中心点击显示隐藏
	$('.pe-info').hide().eq(<?php echo $number-1;?>).show();
	var Form = document.sellerForm;
	//根据省份获取下属城市下拉菜单
	Form.province.onchange = function(){
		Form.area.innerHTML = "<option value=''>--区县--</option>";
		$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostCity:this.value},function(data){
			Form.city.innerHTML = data.city;
		},"json");
	};
	//根据省份和城市获取下属区域下拉菜单
	Form.city.onchange = function(){
		$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostArea:Form.province.value,CityPostArea:this.value},function(data){
			Form.area.innerHTML = data.area;
		},"json");
	};
	//劳务供给根据主项目返回子项目
	var supplyForm = document.supplyForm;
	supplyForm.supplyColumn.onchange = function(){
		$.post("<?php echo root."library/usdata.php";?>",{supplyColumn:this.value},function(data){
			supplyForm.supplyColumnChild.innerHTML = data.ColumnChild;
		},"json")	
	};
	//劳务需求根据主项目返回子项目
	var demandForm = document.demandForm;
	demandForm.demandColumn.onchange = function(){
		$.post("<?php echo root."library/usdata.php";?>",{demandColumn:this.value},function(data){
			demandForm.demandColumnChild.innerHTML = data.ColumnChild;
		},"json")	
	};
	//添加删除劳务列表
	function addDelete(obj){
		this.addBtn = $(obj.addBtnSelector);
		this.target = $(obj.targetSelector);
		this.deleteBtn = obj.deleteBtnSelector;
	}
	addDelete.prototype = {
		addSupplyList:function(url,params,fn){
			var self = this;
			this.addBtn.click(function(){
				$.ajax({
					url:url,
					type:"POST",
					dataType: "json",
					data:params.serialize(),
					success:function(data){
						if(data.warn == 2){
							if(typeof fn == 'function'){
								fn(self,data);
							}
						}else{
							warn(data.warn);
						}
					},error: function(){
						warn('服务器拒绝了你的请求');
					}
				})
				
				$('.pe-info-compress').first().css({'display':'none'}).fadeIn(1000);
			})
		},
		deleteSupplyList:function(type){
			var self = this;
			$(document).on('click','['+this.deleteBtn+']',function(e){
				var _this =$(this);
				var DeleteId = _this.attr(self.deleteBtn);
				if(type == 'supply'){
					var d = {DeleteId:DeleteId};
				}else if(type == 'demand'){
					var d = {DeleteDemandId:DeleteId};
				}
				if(confirm("确定要删除吗？")){
					$.getJSON('<?php echo root."library/usdata.php";?>',d,function(data){
						if(data.warn == 2){
							var tar = _this.parents('.pe-info-compress');
							tar.fadeOut(function(){
								tar.remove();
							});
						}else{
							warn(data.warn);
						}
					})
				}
				
			});

		}	
	}
	var supply = new addDelete({
		addBtnSelector:'[name=supplyForm] .peSave-btn',	
		targetSelector: '#supply',
		deleteBtnSelector:'data_del_id'
	});
	/*supply.addSupplyList("<?php echo root."library/usdata.php";?>",$('[name="supplyForm"]'),function(self,data){
		self.target.after('<div class="pe-info-compress clearfix"><h2 class="fl">'+data.title+'</h2><div class="fr"><a href="javascript:;" class="pe-edit-btn" data_edit_id="'+data.id+'">编辑</a><a href="javascript:;" class="pe-delete-btn" data_del_id="'+data.id+'">删除</a><a href="javascript:;" class="pe-preview-btn">预览</a></div></div>');	
	});*/
	supply.deleteSupplyList('supply');
	var demand = new addDelete({
		addBtnSelector:'[name=demandForm] .peSave-btn',	
		targetSelector: '#demand',
		deleteBtnSelector:'data_del_id2'
	});
	/*demand.addSupplyList("<?php echo root."library/usdata.php";?>",$('[name="demandForm"]'),function(self,data){
		self.target.after('<div class="pe-info-compress clearfix"><h2 class="fl">'+data.title+'</h2><div class="fr"><a href="javascript:;" class="pe-edit-btn" data_edit_id2="'+data.id+'">编辑</a><a href="javascript:;" class="pe-delete-btn" data_del_id2="'+data.id+'">删除</a><a href="javascript:;" class="pe-preview-btn">预览</a></div></div>');	
	});*/
	demand.deleteSupplyList('demand');
	/**
	 *	劳务时间表
	 * @param object 传递参数
	 * @constructor
	 * @author Hui He
	 */
	function ChoiceTime(object){
		this.btn = $(object.btn);
		this.table = $(object.table);
		this.Hook = object.Hook;
		this.TimeTableCheckBox = $(object.TimeTableCheckBox);
		this.type = object.type;
		this.ChoiceTab();
		this.HookTab();
	}
	ChoiceTime.prototype = {
		ChoiceTab:function(){
			var self = this;
			this.btn.click(function(){
				if($(this).val() == self.type){
					self.table.fadeIn();
				}else{
					self.table.fadeOut();
				}
			})
		},
		HookTab:function(){
			var self = this;
			$(document).on('click',this.Hook,function(){
				$(this).toggleClass("current1");
				var TimeTable = $(this).attr('TimeTable');
				if($(this).hasClass('current1')){
					self.TimeTableCheckBox.each(function() {
						if($(this).val() == TimeTable ){
							$(this).prop('checked',true);
						}
					});
				}else{
					self.TimeTableCheckBox.each(function() {
						if($(this).val() == TimeTable){
							$(this).removeAttr('checked');
						}
					});
				}
			});
		}
	};
	/**
	 * 调用
	 */
	new ChoiceTime({
		btn:'[name="supplyWorkingHours"]',
		table:"#timeBox",
		Hook:".time-current",
		TimeTableCheckBox:".TimeTableCheckBox",
		type: "时间表"
	});
	var useSupplyPay = new ChoiceTime({
		btn:'[name="supplyPayType"]',
		table:"#supplyPayBox",
		type: "薪酬"
	});
	useSupplyPay.ChoiceTab();
	var useDemandPay = new ChoiceTime({
		btn:'[name="demandPayType"]',
		table:"#demandPayBox",
		type: "薪酬"
	});
	useDemandPay.ChoiceTab();
	/**
	 * 打印薪酬
	 * @param name input名字选择器
	 * @param id 让谁显示出来
	 * @constructor
	 */
	function Pay(name, id) {
		var payType = document.getElementsByName(name);
		if (payType[2].checked) {
			$(id).show();
		}
	}
	Pay("supplyPayType","#supplyPayBox");
	Pay("demandPayType","#demandPayBox");
	//打印时间表
	var supplyMxId = '<?php echo $_GET['supply_id'];?>';	
	var input = document.getElementsByName("supplyWorkingHours");
	if(supplyMxId && input[0].checked){
		$('#timeBox').show();
		var currentTime = "<?php echo $supplyId['Timetable']?>".split(",");
		var timeTable = $("[timetable]");
		var TimeTableCheckBox = $(".TimeTableCheckBox");
		for(var i=0;i<currentTime.length;i++){
			timeTable[currentTime[i]-1].className +=" current1";
			TimeTableCheckBox[currentTime[i]-1].checked = true;
		}	
	}
	//公开联系人全名，邮箱
	var ContactNameOpen = $('[name=sellerForm] [name=sellerContactNameOpen]');
	var EmailOpen = $('[name=sellerForm] [name=sellerEmailOpen]');
	ContactNameOpen.click(function(){
		if($(this).is(':checked')){
			$(this).val("公开");	
		}
	
	});
	EmailOpen.click(function(){
		if($(this).is(':checked')){
			$(this).val("公开");	
		}
	
	});
	var ContactNameOpenSql = '<?php echo $kehu['ContactNameOpen'];?>';
	if(ContactNameOpenSql == '公开'){
		ContactNameOpen.prop('checked', true).val('公开');	
	}
	var EmailOpenSql = '<?php echo $kehu['emailOpen'];?>';
	if(EmailOpenSql == '公开'){
		EmailOpen.prop('checked', true).val('公开');	
	}
});
</script>
<!--页脚-->
<?php echo pcFooter().warn();?>
