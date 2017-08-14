<?php 
include "../library/PcFunction.php";
UserRoot("pc");
$Region = query("region", "id = '$kehu[RegionId]' ");
$personal = query("personal","khid = '$kehu[khid]'");
//判断手持身份证照片
if(empty($kehu['IDCardHand'])){
	$kehu['IDCardHand'] = img("PGI58296514zx");
}else{
	$kehu['IDCardHand'] = $root.$kehu['IDCardHand'];	
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
//获取到供给
$supplyId = query("supply","id = '$_GET[supply_id]' ");
echo head("pc").pcHeader();
?>
<!--内容-->
<div class="info-container"> 
	<?php echo pcNavigation();?>
    <!--row-->
    <div class="row">
        <!--广告-->
        <div class="info-ad"><a href="javascript:;"><img src="<?php echo img("RCV57016301qE")?>"></a></div>
        <!--内容-->
        <div class="mine-box clearfix">
        	<!--左边目录-->
            <!--<ul class="mine_list_width fl"></ul> 占位符 为了实现绝对定位 客户改了效果 先注释了-->
            <ul class="mine-list fl">
            	<li class="peMine-list bg1 col1">我的</li>
                <li class="userAnchor">
					<i class="icon2 mine-icon1 <?php echo MenuGet("type","basicData","");?>"></i>
					<a href="<?php echo root."user/user.php?type=basicData";?>">个人资料</a>
				</li>
                <li class="supplyAnchor">
					<i class="icon2 mine-icon2 <?php echo MenuGet("type","supply","");?>"></i>
					<a href="<?php echo root."user/user.php?type=supply";?>">我的供给</a>
				</li>
                <li class="demandAnchor">
					<i class="icon2 mine-icon3 <?php echo MenuGet("type","demand","");?>"></i>
					<a href="<?php echo root."user/user.php?type=demand";?>">我的需求</a>
				</li>
                <li class="myCollection">
					<i class="icon2 mine-icon7 <?php echo MenuGet("type","collection","");?>"></i>
					<a href="<?php echo root."user/user.php?type=collection";?>">我的收藏</a>
				</li>
            </ul>
                       <!--右边-->
            <div class="mine-right fl">
            	<!--个人资料-->
            	<div class="pe-info" id="userAnchor">
                	<div class="pe-info-title"><i class="icon2 mine-icon4"></i><span>个人资料</span></div>
                    <form name="userForm">
                    <div class="pe-info-content clearfix">
                    	<div class="portrait fl">
                        	<img src="<?php echo HeadImg($kehu['sex'],$kehu['ico']);?>" width='120' height='120' />
                            <div class="portrait-text"><a href="javascript:;" onClick='document.headPortraitForm.headPortraitUpload.click()'>修改</a><span>丨</span><a href="javascript:;" onClick='document.headPortraitForm.headPortraitUpload.click()'>上传</a></div>
                        </div>
                        <ul class="content-info fl clearfix">
                            <li class="co-info-item"><span class="pe-black"><s>*</s>全名</span>
                            	<input value="<?php echo $kehu['ContactName'];?>" name="userContactName" type="text" class="input-box">
                            </li>
                            <li class="co-info-item"><span class="pe-black"><s>*</s>性别</span>
								<?php echo select("userSex","select-box","请选择",array("男","女"),$personal['sex']);?></li>
                            <li class="co-info-item"><span class="pe-black">身份证号</span>
                            	<input value="<?php echo $kehu['IDCard'];?>" name="userIDCard" type="text" class="input-box" placeholder="选填"><span class="pe-gray">不公开</span>
                            </li>
                            <li class="co-info-item"><span class="pe-black"><s>*</s>出生年月</span>
								<?php echo year('year','select_width','',$personal['Birthday']).moon('moon','select_width',$personal['Birthday']).day('day','select_width',$personal['Birthday']);?></li>
                            <li class="co-info-item"><span class="pe-black">教育程度</span>
                            	<input value="<?php echo $personal['EducationLevel'];?>" name="userEducationLevel" type="text" class="input-box" placeholder="选填"><!--<input name="userEducationLevelOpen" type="checkbox" value=""><span class="pe-gray">选择公开</span>-->
                            </li>
                            <li class="co-info-item"><span class="pe-black"><s>*</s>常驻地点</span>
                                <select name="province" class="select_width"><?php echo RepeatOption("region","province","--省份--",$Region['province']);?></select>
                                <select name="city" class="select_width"><?php echo RepeatOption("region where province = '$Region[province]' ","city","--城市--",$Region['city']);?></select>
                                <select name="area" class="select_width"><?php echo IdOption("region where province = '$Region[province]' and city = '$Region[city]'","id","area","--区县--",$kehu['RegionId']);?></select>
                            </li>
                            <li class="co-info-item"><span class="pe-black"><s>*</s>邮箱</span>
                            	<input value="<?php echo $kehu['email'];?>" name="userEmail" type="text" class="input-box">
                            </li>
                            <li class="co-info-item"><span class="pe-black"><s>*</s>手机</span>
                            	<input value="<?php echo $kehu['ContactTel'];?>" name="userContactTel" type="text" class="input-box">
                            </li>
                            <li class="clearfix"><span class="pe-black fl">手持身份证照片</span>
                                <a href="javascript:;" class="idUpload-btn fl" onClick="document.IDCardHandForm.IDCardHandUpload.click()">点击上传</a>
                                <div class="pe-photo-show fl"><img src="<?php echo $kehu['IDCardHand'];?>" width="120" height="120" /></div>
                            </li>
                            <li><p class="pe-note" style="line-height: 25px;"><?php echo website("Gat62449970Xp");?></p></li>
							<li class="pe-btn-box"><a href="javascript:;" class="peSave-btn" onClick="Sub('userForm','<?php echo root."library/usdata.php";?>')">保存</a></li>
                        </ul>
                    </div>
                    </form>
                </div>
                <!--发布劳务供给-->
                <?php echo $s;?>
                <!--发布劳务需求-->
                <?php echo $d;?>
                <!--我的收藏-->
                <div class="pe-info hide" id="myCollection">
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
    <form name='headPortraitForm' action='<?php echo root."library/uspost.php";?>' method='post' enctype='multipart/form-data'>
        <input name='headPortraitUpload' type='file' onChange='document.headPortraitForm.submit()'>
    </form>
    <form name="IDCardHandForm" action="<?php echo root."library/uspost.php";?>" method="post" enctype="multipart/form-data">
   		<input name="IDCardHandUpload" type="file" onChange="document.IDCardHandForm.submit()">
    </form>
</div>
<!--隐藏表单结束-->
<script>
$(document).ready(function(){
	//显示复选框输入字数
	function keypress(textareaID, textID) { //text输入长度处理
		var textarea=document.querySelector(textareaID);
		textarea.onkeyup = function() {
			document.querySelector(textID).innerText=textarea.value.length;
		}
	}
	keypress(".textareaLength-one", ".textLength-one");
	keypress(".textareaLength-two", ".textLength-two");
	//我的个人中心点击显示隐藏
	$('.pe-info').hide().eq(<?php echo $number-1;?>).show();
	var Form = document.userForm;
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
	/**
	 * 添加删除劳务列表
	 * @param obj 传递参数
	 * @author Hui He
	 */
	function addDelete(obj){
		this.addBtn = $(obj.addBtnSelector);
		this.target = $(obj.targetSelector);
		this.deleteBtn = obj.deleteBtnSelector;
	}
	addDelete.prototype = {
		/**
		 *  添加列表
		 * @param url 提交地址
		 * @param params 提交数据
		 * @param fn 回调函数
		 */
		addList:function(url,params,fn){
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
				});
				
				$('.pe-info-compress').first().css({'display':'none'}).fadeIn(1000);
			})
		},
		/**
		 * 删除列表
		 * @param type 删除列表类型
		 */
		deleteList:function(type){
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
	};
	/**
	 * 调用函数
	 * @type {addDelete} 传递参数
	 */
	var supply = new addDelete({
		addBtnSelector:'[name=supplyForm] .peSave-btn',	
		targetSelector: '#supply',
		deleteBtnSelector:'data_del_id'
	});
	/*supply.addList("<?php echo root."library/usdata.php";?>",$('[name="supplyForm"]'),function(self,data){
		self.target.after('<div class="pe-info-compress clearfix"><h2 class="fl">'+data.title+'</h2><div class="fr"><a href="javascript:;" class="pe-edit-btn" data_edit_id="'+data.id+'">编辑</a><a href="javascript:;" class="pe-delete-btn" data_del_id="'+data.id+'">删除</a><a href="javascript:;" class="pe-preview-btn">预览</a></div></div>');	
	});*/
	supply.deleteList('supply');
	/**
	 * 调用函数
	 * @type {addDelete} 传递参数
	 */
	var demand = new addDelete({
		addBtnSelector:'[name=demandForm] .peSave-btn',	
		targetSelector: '#demand',
		deleteBtnSelector:'data_del_id2'
	});
	/*demand.addList("<?php echo root."library/usdata.php";?>",$('[name="demandForm"]'),function(self,data){
		self.target.after('<div class="pe-info-compress clearfix"><h2 class="fl">'+data.title+'</h2><div class="fr"><a href="javascript:;" class="pe-edit-btn" data_edit_id2="'+data.id+'">编辑</a><a href="javascript:;" class="pe-delete-btn" data_del_id2="'+data.id+'">删除</a><a href="javascript:;" class="pe-preview-btn">预览</a></div></div>');	
	});*/
	demand.deleteList('demand');
	function Switch(object) {
		this.btn = $(object.btn);
	}
	/**
	 * 点击编辑跳转到表格进行编辑
	 * @param object 传递参数
	 * @constructor
	 * @author Hui He
     */
	function Anchor(object){
		this.btn = $(object.btn);
		this.target = $(object.target);
		this.Scroll();	
	}
	Anchor.prototype={
		Scroll:function(){
			var self = this;
			this.btn.bind('click',function(){
				$("html,body").animate({scrollTop:self.target.offset().top},300)	
			})
		}	
	};
	//客户改了效果先禁用
	/*new Anchor({
		btn:".pe-edit-btn1",
		target:".supplyAnchor"
	});*/
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
					self.TimeTableCheckBox.each(function(index, element) {
						if($(this).val() == TimeTable ){
							$(this).prop('checked',true);	
						}
                	});	
				}else{
					self.TimeTableCheckBox.each(function(index, element) {
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
	//公开教育程度
	var EducationLevelOpen = $('[name=userForm] [name=userEducationLevelOpen]');
	EducationLevelOpen.click(function(){
		if($(this).is(':checked')){
			$(this).val("公开");	
		}
	
	});
	var EducationLevelOpenSql = '<?php echo $personal['EducationLevelOpen'];?>';
	if(EducationLevelOpenSql == '公开'){
		EducationLevelOpen.prop('checked', true).val('公开');	
	}
});
</script>
<!--页脚-->
<?php echo pcFooter().warn();?>
