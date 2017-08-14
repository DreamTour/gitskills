<?php 
include "../../library/mFunction.php";
//供给
if(empty($_GET['supply_id'])){
	$SupplyButton = "发布";
}else{
	$SupplyButton = "更新";
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
	    <div class='pe-photo-show fl'>
		    <img src='".img("PGI58296514zx")."' />
		</div>
	";
}else{
	while($array = mysql_fetch_array($imgSql)){
		$img .= "
				<div class='pe-photo-show fl'><span title='点击删除图片' onClick=\"window.location.href='{$root}library/uspost.php?deletePhotoImg={$array['id']}'\">x</span/>
					<img src='{$root}{$array['src']}'></div>
				";	
	}	
}
//劳务供给列表
$supplySql = mysql_query("select * from supply where clientType = '$kehu[type]' and khid = '$kehu[khid]' ");
$supplyNum = mysql_num_rows($supplySql);
$supplyList = "";
while($array = mysql_fetch_assoc($supplySql)){
	$supplyList .= "
		<div class='release-menu'>
			<span>{$array['title']}</span>
			<p class='menu-btn'>
                <a href='{$root}m/mUser/mUsSupply.php?supply_id={$array['id']}' class='edit' data_edit_id='{$array['id']}'>编辑</a>
                <a href='javascript:;' class='delete' data_del_id='{$array['id']}'>删除</a>
                <a href='{$root}m/mJobMx.php?supplyMx_id={$array['id']}' class='view'>预览</a>
            </p>
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
//判断是否显示选择个人还是商家 主语显示我还是我们
if ($kehu[type] == "个人") {
    $IdentityType = "
	<li class='Mine-content-item'>
    	<p>我是</p>
        <div class='mine-multiple'>
        	<select class='select-box' name='supplyMy' style='flex:1;'>
                ".option('请选择个人或者商家',array('个人','商家'),$supply['IdentityType'])."
            </select>
            <input style='flex:1;' name='supplyName' type='text' class='input-box' value='{$supply['CompanyName']}' placeholder='选择商家，请填写商家名称' />
        </div>
    </li>
		";
    $my = "我";
}
else {
    $my = "我们";
}
//获取到供给
$supplyId = query("supply","id = '$_GET[supply_id]' ");
echo head("m");
?>
<!--页眉-->
<header id="minetopBox">
	<div class="mine-top clearfix">
    	<img src="../../img/WebsiteImg/oqX58150379Bb.jpg" class="fl">
        <div class="fr mine-publish"><a href="<?php echo $root;?>m/mUser/mUsSupply.php"><span style="font-size:16px;font-weight:bold;">+新增</span></a></div>
    </div>
    <div class="way"><a href="<?php echo $root;?>m/mindex.php">首页</a><span>&gt;&gt;</span><a href="<?php echo $root;?>m/mUser/mUsIssue.php">发布</a><span>&gt;&gt;</span><a href="javascript:;">发布劳务供给</a></div>
    <!--广告-->
<div class="ad"><a href="javascript:;"><img src="<?php echo img("Vls58315686MZ");?>"></a></div>

</header>
<!--内容-->
<form name="supplyForm">
<ul class="Mine-content">
	<li class="Mine-content-item">
    	<p><?php echo $my;?>提供</p>
        <div class="mine-multiple">
        	<?php echo RepeatSelect('classify','type','supplyColumn','select-box','请选择劳务主项目',$SupplyClassify['type']);?>
            <select class='select-box' name='supplyColumnChild'>
                 <?php echo IdOption("classify where type = '$SupplyClassify[type]' ",'id','name','请选择劳务子项目',$SupplyClassify['id']);?>
            </select>
            <input name='supplyOther' type='text' class='input-box' value='<?php echo $supply['ClassifyOther'];?>' placeholder='如选其他请填写' />
        </div>
    </li>
    <?php echo $IdentityType;?>
    <li class="Mine-content-item">
    	<p>方式</p>
		<select class='select-box' name='supplyMode'>
        	<?php echo option('请选择劳务提供方式',array('上门','如约'),$supply['mode']);?>
        </select>    
    </li>
    <li class="Mine-content-item">
    	<p>面向</p>
        <select class='select-box' name='supplyFace'>
            <?php echo option('请选择劳务面向',array('全国','本地'),$supply['face']);?>
        </select>
    </li>
    <li class="Mine-content-item Mine-content-item1">
        <p>收费</p>
        <div class='time-check'><?php echo radio('supplyPayType',array('面议','如约',"薪酬"),$supply['payType']);?></div>
        <div class="mine-multiple hide" id="supplyPayBox">
            <input name='supplyPay' type='text' class='input-box' value='<?php echo $supply['pay'];?>' placeholder='请填写劳务收费' />
            <span style="margin:12px 5px 0 0;">元/</span>
            <select class='select-box' name='supplyPayCycle'>
                <?php echo option('请选择劳务结算方式',array('小时','日','周','月'),$supply['PayCycle']);?>
            </select>
        </div>
    </li>
    <li class="Mine-content-item">
    	<p>类型</p>
        <select class='select-box' name='supplyType'>
            <?php echo option('请选择劳务类型',array('全职','兼职'),$supply['type']);?>
        </select>
    </li>
    <li class="Mine-content-item">
         <p>工作时间</p>
        <div class="time-table fl">
            <div class="time-check">
                <?php echo radio('supplyWorkingHours',array('时间表','如约'),$supply['WorkingHours']);?>
            </div>
            <div class="time-box hide" id="timeBox">
                <div class="timeBox_flex">
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
        </div>
    </li>
    <li class="Mine-content-item"><p>标题</p>
    	<input name='supplyTitle' type='text' class='input-box' value='<?php echo $supply['title'];?>' maxlength='10' placeholder='请输入标题,10字以内'>
    </li>
    <li class="Mine-content-item"><p>关键词</p>
    	<input name='supplyKeyWord' type='text' class='input-box' value='<?php echo $supply['KeyWord'];?>' placeholder='选填用逗号隔开如：词1，词2，词3'>
    </li>
    <li class="Mine-content-item" style="position: relative;"><p>展示/介绍/说明</p>
    	<textarea name='supplyText' class='textarea-box textareaLength-one' maxlength='80' placeholder='展示/介绍/说明：80字以内，不可输入联系方式、敏感词及不良信息。'><?php echo $supply['text'];?></textarea>
        <div style='position: absolute;right: 70px; bottom: 10px;font-size: 14px;'><span class='textLength-one'>0</span> / 80</div>
    </li>
    <li class="Mine-item-special">
    	<span>上传照片</span>
        <div class="upload-box">
        	<a href="javascript:;" class="upload-btn" onClick='document.kehuSupplyImgForm.kehuSupplyImgUpload.click()'>点击上传</a>
            <?php echo $img;?>
        </div>
    </li>
    <li class="mine-note">注：请上传介绍图片，最多2张。</li>
</ul>
<div class="extra" style="text-align: center;padding-top: 10px;">
    <input name='supplyAgree' type="checkbox" value="yes" style="width: initial">
    <span> 我已阅读并同意“有劳了网”《<a style='color:#689fee;' href='<?php echo $root;?>m/mLaw.php'>法律申明</a>》
</div>
<div class="save-box"><a href="javascript:;" class="save-btn" onClick='Sub("supplyForm","<?php echo "{$root}library/usdata.php";?>")'><?php echo $SupplyButton;?></a></div>
<div style='display:none;'><?php echo $TimeTableCheckBox;?></div>
<input name='SupplyId' type='hidden' value='<?php echo $_GET['supply_id'];?>'>
</form>
<!--隐藏表单开始-->
<div style="display:none;">
    <form name="kehuSupplyImgForm" action="<?php echo root."library/uspost.php";?>" method="post" enctype="multipart/form-data">
        <input name="kehuSupplyImgUpload" type="file">
        <input name="SupplyId" type="hidden" value="<?php echo $_GET['supply_id'];?>" />
    </form>
</div>
<!--隐藏表单结束-->
<?php echo $supplyList;?>
</body>
<script>
    $(function(){
        //显示复选框输入字数
        function keypress(textareaID, textID) { //text输入长度处理
            var textarea=document.querySelector(textareaID);
            textarea.onkeyup = function() {
                document.querySelector(textID).innerText=textarea.value.length;
            }
        }
        keypress(".textareaLength-one", ".textLength-one");
        //点击同意我已阅读并同意“有劳了网”《法律申明》
        $('[name=supplyAgree]').prop('checked', true);
        //劳务供给根据主项目返回子项目
        var supplyForm = document.supplyForm;
        supplyForm.supplyColumn.onchange = function(){
            $.post("<?php echo root."library/usdata.php";?>",{supplyColumn:this.value},function(data){
                supplyForm.supplyColumnChild.innerHTML = data.ColumnChild;
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
                                var tar = _this.parents('.release-menu');
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
        var demand = new addDelete({
            addBtnSelector:'[name=supplyForm] .peSave-btn',
            targetSelector: '#supply',
            deleteBtnSelector:'data_del_id'
        });
        demand.deleteList('supply');

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
        //供给图片上传
        $('#idUpload_btn').click(function(){
            document.kehuSupplyImgForm.kehuSupplyImgUpload.click();
        })
        document.kehuSupplyImgForm.kehuSupplyImgUpload.onchange = function(){
            $.post('<?php echo "{$root}library/usdata.php";?>',$('[name=supplyForm]').serialize(),function(data){
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
    });
</script>
</html>
<?php echo warn();?>
