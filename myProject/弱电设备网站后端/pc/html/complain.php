<?php
include "../library/PcFunction.php";
UserRoot("pc");
echo head("pc").headerPC().navTwo();
;?>
<!-- 内容 -->
<div class="mine-box clearfix container">
    <!--右边-->
    <div class="mine-right">
        <!--发布劳务供给-->
        <div class="pe-info">
            <div class="pe-info-title"><i class="icon2 mine-icon5"></i><span>投诉</span><a href="javascript:;" class="fr new-add"></a></div>
            <div class="pe-info-content clearfix">
                <form name="complainForm">
                    <ul class="labour-info">
                        <li>
                            <span class="pe-black01">投诉说明</span>
                            <textarea name="complainText" class="textarea-box" placeholder="请输入投诉说明"></textarea>
                        </li>
                        <li class="pe-btn-box02">
                            <a href="javascript:;" class="peSave-btn" onclick='Sub("complainForm", "<?php echo "{$root}library/usData.php?type=complain";?>")'>投诉</a>
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
</html>