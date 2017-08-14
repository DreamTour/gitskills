<!-- 网站头部 -->
<?php
include "../../library/mFunction.php";
UserRoot("m");
$Region = query("region", "id = '$client[regionId]' ");
$recordList = "";
//循环我的预约
if ($_GET['type'] == bespeak) {
    $recordListHead = "
        <li>
            <span>设备类型</span>
            <span>故障现象描述</span>
            <span>联系人</span>
            <span>联系电话</span>
            <span>操作</span>
            <span>操作</span>
        </li>
    ";
    $title = "我的预约";
    $bespeakSql = mysql_query("SELECT * FROM bespeak WHERE khid = '$kehu[khid]' ORDER BY updateTime DESC ");
    if (mysql_num_rows($bespeakSql) == 0) {
        $recordList = "一条我的预约都没有";
    } else {
        while ($array = mysql_fetch_assoc($bespeakSql)) {
            $device  = query("device", "identifyId = '$array[identifyId]' ");
            if (empty($device['ico'])) {
                $ico = img('ZEg70828834DN');
            }
            else {
                $ico = $root.$device['ico'];
            }
            $system = query("system", "id = '$array[type]' ");
            $recordList .= "
            <li>
                <span>{$system['name']}</span>
                <span>{$array['bespeakText']}</span>
                <span>{$array['contactName']}</span>
                <span>{$array['contactTel']}</span>
                <a class='delete' href='#' data_del_id='{$array['id']}'>删除</a>
                <a class='delete' href='{$root}m/mUser/mUsFeedback.php?bespeakId={$array['id']}'>详情</a>
            </li>
        ";
        }
    }
}
//循环我的投诉
else if ($_GET['type'] == complain) {
    $recordListHead = "
        <li>
            <span>投诉说明</span>
            <span>反馈</span>
            <span>投诉时间</span>
            <span>操作</span>
            <span>操作</span>
        </li>
    ";
    $title = "我的投诉";
    $complainSql = mysql_query("SELECT * FROM complain WHERE khid = '$kehu[khid]' ORDER BY time DESC ");
    if (mysql_num_rows($complainSql) == 0) {
        $recordList = "一条我的投诉都没有";
    } else {
        while ($array = mysql_fetch_assoc($complainSql)) {
            $device = query("device", "id = '$array[deviceId]' ");
            if (empty($array['feedbackText'])) {
                $array['feedbackText'] = "未反馈";
            }
            $recordList .= "
			<li>
                <span>{$array['complainText']}</span>
                <span>{$array['feedbackText']}</span>
                <span>{$array['time']}</span>
                <a class='delete' href='#' data_del_id2='{$array['id']}'>删除</a>
                <a class='delete' href='{$root}m/mUser/mUsFeedback.php?complainId={$array['id']}'>详情</a>
            </li>
        ";
        }
    }
}
//循环我的维修记录
else if ($_GET['type'] == service) {
    $recordListHead = "
        <li>
            <span>设备查询ID</span>
            <span>选择方式</span>
            <span>维修人</span>
            <span>状态</span>
            <span>操作</span>
            <span>操作</span>
        </li>
    ";
    $title = "我的维修记录";
    $client = query("kehu", "khid = '$kehu[khid]' ");
    $recordSql = mysql_query("SELECT * FROM service WHERE khid = '$kehu[khid]' ORDER BY updateTime DESC ");
    if (mysql_num_rows($recordSql) == 0) {
        $recordList = "一条我的维修记录都没有";
    } else {
        while ($array = mysql_fetch_assoc($recordSql)) {
            $device  = query("device", "identifyId = '$array[identifyId]' ");
            $recordList .= "
                <li>
                    <span>{$array['identifyId']}</span>
                    <span>{$array['manner']}</span>
                    <span>{$array['serviceName']}</span>
                    <span>{$array['status']}</span>
                    <a class='delete' href='#' data_del_id3='{$array['id']}'>删除</a>
                    <a class='delete' href='{$root}m/mUser/mUsFeedback.php?serviceId={$array['id']}'>详情</a>
                </li>
        ";
        }
    }
}
echo head("m").mHeader();
;?>
<!-- 记录列表 -->
<h2 class="clearfix public-title">
    <div class="fl"><?php echo $title?></div>
    <a href="javascript:;" class="fr">></a>
</h2>
<div class="mRecordList">
    <ul>
        <?php echo $recordListHead.$recordList;?>
    </ul>
</div>
<?php echo mFooter().mNav().warn();?>
</body>
<script>
    $(function(){
        /**
         * 删除个人中心列表
         * @param obj 传递参数
         * @author Hui He
         */
        function deleteList(obj){
            this.deleteBtn = obj.deleteBtnSelector;
        }
        deleteList.prototype = {
            /**
             * 删除列表
             * @param type 删除列表类型
             */
            delete:function(type){
                var self = this;
                $(document).on('click','['+this.deleteBtn+']',function(e){
                    var _this =$(this);
                    var DeleteId = _this.attr(self.deleteBtn);
                    if(type == 'bespeak'){
                        var d = {DeleteBespeakId:DeleteId};
                    }else if(type == 'complain'){
                        var d = {DeleteComplainId:DeleteId};
                    }else if(type == 'service'){
                        var d = {DeleteServiceId:DeleteId};
                    }
                    if(confirm("确定要删除吗？")){
                        $.getJSON('<?php echo root."library/usData.php";?>',d,function(data){
                            if(data.warn == 2){
                                var tar = _this.parents('li');
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
         * @type {deleteList} 传递参数
         */
        var bespeak = new deleteList({deleteBtnSelector:'data_del_id'});
        bespeak.delete('bespeak');
        var complain = new deleteList({deleteBtnSelector:'data_del_id2'});
        complain.delete('complain');
        var service = new deleteList({deleteBtnSelector:'data_del_id3'});
        service.delete('service');
        //轮播图
        TouchSlide({
            slideCell:"#index_banner",
            titCell:"#index_banner .banner_count",
            mainCell:"#index_banner .banner_img",
            effect:"leftLoop",
            autoPage:true,
            autoPlay:true
        });
    })
</script>
</html>
