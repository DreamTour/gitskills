<?php
include "../../library/mFunction.php";
//需求
if(empty($_GET['demand_id'])){
    $demandButton = "发布";
}else{
    $demandButton = "更新";
    $demand = query("demand"," id = '$_GET[demand_id]'");
    if($demand['id'] != $_GET['demand_id']){
        $_SESSION['warn'] = "未找到此供给信息";
        header("location:{$root}user/user.php");
        exit(0);
    }
    $demandClassify = query("classify","id = '$demand[ClassifyId]'");
}
//劳务需求列表
$demandSql = mysql_query("select * from demand where khid = '$kehu[khid]'");
$demandNum = mysql_num_rows(mysql_query("select * from demand where khid = '$kehu[khid]'"));
$demandList = "";
while($array = mysql_fetch_assoc($demandSql)){
    $demandList .= "
		<div class='release-menu'>
			<span>{$array['title']}</span>
			<p class='menu-btn'>
                <a href='{$root}m/mUser/mUsDemand.php?demand_id={$array['id']}' class='edit' data_edit_id2='{$array['id']}'>编辑</a>
                <a href='javascript:;' class='delete' data_del_id2='{$array['id']}'>删除</a><a href='{$root}m/mRecruit.php?demandMx_id={$array['id']}' class='view'>预览</a>
            </p>
		</div>
		";
}
echo head("m");
?>
<header id="minetopBox">
    <div class="mine-top clearfix">
        <img src="../../img/WebsiteImg/oqX58150379Bb.jpg" class="fl">
        <div class="fr mine-publish"><a href="<?php echo $root;?>m/mUser/mUsDemand.php"><span style="font-size:16px;font-weight:bold;">+新增</span></a></div>
    </div>
    <div class="way"><a href="<?php echo $root;?>m/mindex.php">首页</a><span>&gt;&gt;</span><a href="<?php echo $root;?>m/mUser/mUsIssue.php">发布</a><span>&gt;&gt;</span><a href="javascript:;">发布劳务需求</a></div>
    <!--广告-->
    <div class="ad"><a href="javascript:;"><img src="../../img/WebsiteImg/Vls58315686MZ.jpg"></a></div>

</header>
<!--内容-->
<form name="demandForm" action="" method="post">
    <ul class="Mine-content">
        <li class="Mine-content-item">
            <p>我要找</p>
            <div class="mine-multiple">
                <?php echo RepeatSelect('classify','type','demandColumn','select-box','请选择劳务主项目',$demandClassify['type']);?>
                <select class='select-box' name='demandColumnChild'>
                    <?php echo IdOption("classify where type = '{$demandClassify[type]}' ",'id','name','请选择劳务子项目',$demandClassify['id']);?>
                </select>
                <input name='demandOther' type='text' class='input-box' value='<?php echo $demand['ClassifyOther'];?>' placeholder='如选其他请填写' />
            </div>
        </li>
        <li class="Mine-content-item">
            <p>方式</p>
            <select class='select-box' name='demandMode'>
                <?php echo option('请选择劳务提供方式',array('上门','如约'),$demand['mode']);?>
            </select>
        </li>
        <li class="Mine-content-item">
            <p>面向</p>
            <select class='select-box' name='demandFace'>
                <?php echo option('请选择劳务面向',array('全国','本地'),$demand['face']);?>
            </select>
        </li>
        <li class="Mine-content-item">
            <p>收费</p>
            <div class='time-check'><?php echo radio('demandPayType',array('面议','如约',"薪酬"),$demand['payType']);?></div>
            <div class="mine-multiple hide" id="demandPayBox">
                <input name='demandPay' type='text' class='input-box' value='<?php echo $demand['pay'];?>' placeholder='请填写劳务收费'>
                <span style="margin:12px 5px 0 0;">元</span>
                <select class='select-box' name='demandPayCycle'>
                    <?php echo option('请选择劳务结算方式',array('小时','日','周','月'),$demand['PayCycle']);?>
                </select>
            </div>
        </li>
        <li class="Mine-content-item">
            <p>需求时间</p>
            <div class="need-date">
                <div class="mine-multiple">
                    <?php echo year('StartYear','select_width_time','new',$demand['StartTime']).moon('StartMoon','select_width_time',$demand['StartTime']).day('StartDay','select_width_time',$demand['StartTime']);?>
                </div>
                <span style="margin: 6px 3px;">—</span>
                <div class="mine-multiple">
                    <?php echo year('EndYear','select_width_time','new',$demand['EndTime']).moon('EndMoon','select_width_time',$demand['EndTime']).day('EndDay','select_width_time',$demand['EndTime']);?>
                </div>
            </div>
        </li>
        <li class="Mine-content-item">
            <p>类型</p>
            <select class='select-box' name='demandType'>
                <?php echo option('请选择劳务类型',array('全职','兼职'),$demand['type']);?>
            </select>
        </li>
        <li class="Mine-content-item"><p>标题</p>
            <input name='demandTitle' type='text' class='input-box' value='<?php echo $demand['title'];?>' maxlength='10' placeholder='请输入标题,10字以内'>
        </li>
        <li class="Mine-content-item"><p>关键词</p>
            <input name='demandKeyWord' type='text' class='input-box' value='<?php echo $demand['KeyWord'];?>' placeholder='选填用逗号隔开如：词1，词2，词3'>
        </li>
        <li class="Mine-content-item" style="position: relative;"><p>展示/介绍/说明</p>
            <textarea name='demandText' class='textarea-box textareaLength-one' maxlength='80' placeholder='展示/介绍/说明：80字以内，不可输入联系方式、敏感词及不良信息。'><?php echo $demand['text'];?></textarea>
            <div style='position: absolute;right: 70px; bottom: 10px;font-size: 14px;'><span class='textLength-one'>0</span> / 80</div>
        </li>
    </ul>
    <div class="extra" style="text-align: center;padding-top: 10px;">
        <input name='demandAgree' type="checkbox" value="yes" style="width: initial">
        <span> 我已阅读并同意“有劳了网”《<a style='color:#689fee;' href='<?php echo $root;?>m/mLaw.php'>法律申明</a>》
    </div>
    <div class="save-box"><a href="javascript:;" class="save-btn" onClick="Sub('demandForm','<?php echo "{$root}library/usdata.php";?>')"><?php echo $demandButton;?></a></div>
    <input name='demandId' type='hidden' value='<?php echo $_GET['demand_id'];?>'>
</form>
<?php echo $demandList;?>
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
        var useDemandPay = new ChoiceTime({
            btn:'[name="demandPayType"]',
            table:"#demandPayBox",
            type: "薪酬"
        });
        useDemandPay.ChoiceTab();
        //点击同意我已阅读并同意“有劳了网”《法律申明》
        $('[name=demandAgree]').prop('checked', true);
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
            addBtnSelector:'[name=demandForm] .peSave-btn',
            targetSelector: '#demand',
            deleteBtnSelector:'data_del_id2'
        });
        demand.deleteList('demand');
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
        Pay("demandPayType","#demandPayBox");
    });
    //时间表
    $(document).ready(function(){
        var timeBox=document.getElementById("timeBox"),
            touchtime = new Date().getTime();

        change1=function(){
            timeBox.style.display="block";
        };
        change2=function(){
            timeBox.style.display="none";
        };
        $(".time-current").on("click", function(){
            if( new Date().getTime() - touchtime < 500 ){
                $(this).removeClass("current1");
            }else{
                touchtime = new Date().getTime();
                $(this).addClass("current1");
            }
        });
    })
</script>
</html>
<?php echo warn();?>
