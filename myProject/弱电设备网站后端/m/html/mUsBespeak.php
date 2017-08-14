<?php
include "../../library/mFunction.php";
UserRoot("m");
echo head("m");
;?>
<div class="m-page">
    <h2 class="clearfix"><a class="fl" href="<?php echo getenv("HTTP_REFERER")?>"><</a>申请服务预约</h2>
    <form name="bespeakForm">
        <div class="wrap">
            <ul class="mcdiv mcdiv11">
                <li>
                    <strong>系统类别：</strong>
                    <?php echo IDSelect("system", "type", "select-box", "id", "name", "--系统类别--", $device['type']);?>
                </li>
                <li>
                    <strong>故障现象描述：</strong>
                    <textarea name="bespeakText"  placeholder="请填写故障现象描述"></textarea>
                </li>
                <li>
                    <strong>预约维护时间：</strong>
                    <?php echo year('bespeakYear','select-time TextPrice','',$service['bespeakTime']).moon('bespeakMoon','select-time TextPrice',$service['bespeakTime']).day('bespeakDay','select-time TextPrice',$service['bespeakTime']);?>
                </li>
                <li>
                    <strong>联系人：</strong>
                    <input type="text" name="contactName" value="" placeholder="请填写联系人姓名" />
                </li>
                <li>
                    <strong>联系电话：</strong>
                    <input type="text" name="contactTel" value="" placeholder="请填写联系人电话" />
                </li>
                <li>
                    <strong>备注：</strong>
                    <textarea name="remark"  placeholder="请填写备注"></textarea>
                </li>
            </ul>
            <a href="#" class="btn" onclick='Sub("bespeakForm", "<?php echo "{$root}library/usData.php?type=bespeak";?>")'>预约</a>
        </div>
    </form>
</div>
</body>
<?php echo warn();?>
</html>




