<?php
include "../library/PcFunction.php";
UserRoot("pc");
echo head("pc").headerPC().navTwo();
;?>
<!-- 内容 -->
<div class="mine-box clearfix container">
    <!--右边-->
    <div class="mine-right">
        <!--服务预约-->
        <div class="pe-info">
            <div class="pe-info-title"><i class="icon2 mine-icon5"></i><span>申请服务预约</span><a href="javascript:;" class="fr new-add"></a></div>
            <div class="pe-info-content clearfix">
                <form name="bespeakForm">
                    <ul class="labour-info">
                        <li>
                            <span class="pe-black01">系统类别</span>
                            <?php echo IDSelect("system", "type", "select-box", "id", "name", "--系统类别--", "");?>
                        </li>
                        <li>
                            <span class="pe-black01">故障现象描述</span>
                            <textarea name="bespeakText" class="textarea-box" placeholder="请输入故障现象描述"></textarea>
                        </li>
                        <li>
                            <span class="pe-black01">预约维护时间</span>
                            <?php echo year('bespeakYear','select-box','',$device['bespeakTime']).moon('bespeakMoon','select-box',$device['bespeakTime']).day('bespeakDay','select-box',$device['bespeakTime']);?>
                        </li>
                        <li>
                            <span class="pe-black01">联系人</span>
                            <input name="contactName" type="text" class="input-box" placeholder="请输入联系人" />
                        </li>
                        <li>
                            <span class="pe-black01">联系电话</span>
                            <input name="contactTel" type="text" class="input-box" placeholder="请输入联系电话" />
                        </li>
                        <li>
                            <span class="pe-black01">备注</span>
                            <textarea name="remark" class="textarea-box" placeholder="请输入备注"></textarea>
                        </li>
                        <li class="pe-btn-box02">
                            <a href="javascript:;" class="peSave-btn" onclick='Sub("bespeakForm", "<?php echo "{$root}library/usData.php?type=bespeak";?>")'>预约</a>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- 页脚 -->
<?php echo footerPC().warn();?>
</body>
<script>
    window.onload = function() {
        //搜索表单placeholder
        jQuery('input[placeholder]').placeholder();
    }
</script>
</html>