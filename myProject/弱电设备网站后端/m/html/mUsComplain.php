<?php
include "../../library/mFunction.php";
$deviceId = $_GET['deviceId'];
echo head("m");
;?>
<div class="m-page">
    <h2 class="clearfix"><a class="fl" href="<?php echo getenv("HTTP_REFERER")?>"><</a>投诉</h2>
    <form name="complainForm">
        <div class="wrap">
            <div class="mcdiv mcdiv11">
                <p>投诉：<textarea type="text" name="complainText" class="textarea" value="<?php echo $kehu['name'];?>"></textarea></p>
                <input type="hidden" name="deviceId" value="<?php echo $deviceId;?>" />
            </div>
            <a href="#" class="btn" onclick='Sub("complainForm", "<?php echo "{$root}library/usData.php?type=complain";?>")'>投诉</a>
        </div>
    </form>
</div>
</body>
<?php echo warn();?>
</html>




