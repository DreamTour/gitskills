<?php
require_once "../mLibrary/mFunction.php";

//第一次打卡的时间
$second = query("CardRecord"," khid = '$kehu[khid]' and StartTime != '0000-00-00 00:00:00' and EndTime != '0000-00-00 00:00:00' order by time desc");
$first_time = time();
if(empty($second['id'])){
    $day = -1;
}else{
    $second_time = strtotime($second['StartTime']);
    $day = intval(($first_time - $second_time)/(24*3600));
}
if($day < 0){
    $text = "您还没有健身，赶快去打卡健身吧！";
}elseif($day == 0){
    $text = "还不错哦，继续保持成为健身达人^_^";
}elseif($day > 0 and $day <= 5){
    $text = "请继续保持健身！";
}elseif($day <= 10){
    $text = "不能偷懒哦！";
}else{
    $text = "需要加油哦！";
}
echo head("m");
?>
<style>
    .dropload-refresh{
        height: 50px;
        line-height: 50px;
        text-align: center;
    }
</style>
<div class="wrap">
    <div class="dkxqdiv1 wrap-box">
        <?php
        if($day < 0){
            echo "<!--<p class='p2'>{$text}</p>-->";
        }else{
            echo "
		<p class='p1'>平均<input type='text' value='{$day}天'  disabled/>一次</p>
		<!--<p class='p2'>{$text}</p>-->
		";
        }
        ?>
    </div>
    <div class="dkxqdiv2 wrap-box" style="margin-bottom:3.5%;">
        <div class="title"><h3><i class="icon">&#xe608;</i> 打卡记录</h3></div>
        <div class="content">
            <ul id="record-list">
                <?php
                $sql = mysql_query("select StartTime,EndTime from CardRecord where khid = '$kehu[khid]' order by time desc limit 0,10");
                if(mysql_num_rows($sql) == 0){
                    $print_script = false;
                    echo "<li>暂无打卡记录</li>";
                }else{
                    $print_script = true;
                    while($array = mysql_fetch_assoc($sql)){
                        if($array['EndTime'] != '0000-00-00 00:00:00'){
                            echo "<li>健身时间：{$array['StartTime']}<span>-</span>{$array['EndTime']}</li>";
                        }
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</div>
<?php if($print_script){?>
    <script>
        $(function(){
            var page = 2;
            $('.content').dropload({
                scrollArea : window,
                loadDownFn : function(me){
                    $(".dropload-load").show('<div class="dropload-load"><span class="loading"></span>加载中...</div>');
                    $.post('<?php echo $root;?>m/mLibrary/mData.php',{CheckRecord:"yes",page:page},function(data){
                        if(data.flag == 2){
                            page++;
                            var time = setTimeout(function(){
                                $('#record-list').append(data.html);
                                me.resetload();
                                window.clearTimeout(time);
                            },500);
                        }else if(data.flag == 3){
                            var time = setTimeout(function(){
                                $(".dropload-down").html('<div class="dropload-noData">没有更多数据了</div>');
                                me.lock();
                                // 无数据
                                me.noData();
                                window.clearTimeout(time);
                            },500);
                        }
                    },"json");
                }
            });
        });
    </script>
<?php }?>
<?php echo footer();?>
</body>
</html>