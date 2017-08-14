<?php
include "../library/PcFunction.php";
UserRoot("pc");
$client = query("kehu", "khid = '$kehu[khid]' ");
$Region = query("region", "id = '$client[regionId]' ");
/*//循环我的预约
$bespeakSql = mysql_query("SELECT * FROM bespeak");
$bespeak = "";
if (mysql_num_rows($bespeakSql) == 0) {
    $bespeak = "一条我的预约都没有";
} else {
    while ($array = mysql_fetch_assoc($bespeakSql)) {
        $bespeak .= "
            <tr>
                <td width=\"290\" align=\"left\">
                    <p class=\"order-name\">{$array['name']}</p>
                </td>
                <td width=\"84\">{$array['identifyId']}</td>
                <td width=\"180\" align=\"center\">
                    <a>删除</a>
                </td>
                <td width=\"84\"><a class=\"td-color-two\" href=\"{$root}user/feedback.php?bespeakId={$array['id']}\">反馈</a></td>
                <td width=\"180\">{$array['time']}</td>
            </tr>
        ";
    }
}
//循环我的投诉
$complainSql = mysql_query("SELECT * FROM complain");
$complain = "";
if (mysql_num_rows($complainSql) == 0) {
    $complain = "一条我的投诉都没有";
} else {
    while ($array = mysql_fetch_assoc($complainSql)) {
        $device = query("device", "id = '$array[deviceId]' ");
        $complain .= "
            <tr>
                <td width=\"290\" align=\"left\">
                    <p class=\"order-name\">{$device['name']}</p>
                </td>
                <td width=\"84\">
                {$device['id']}</td>
                <td width=\"180\" align=\"center\">
                    <a>删除</a>
                </td>
                <td width=\"84\"><a class=\"td-color-two\" href=\"{$root}user/feedback.php?complainId={$array['id']}\">反馈</a></td>
                <td width=\"180\">{$array['time']}</td>
            </tr>
        ";
    }
}
//循环我的维修记录
$recordSql = mysql_query("SELECT * FROM service");
$record = "";
if (mysql_num_rows($recordSql) == 0) {
    $record = "一条我的维修记录都没有";
} else {
    while ($array = mysql_fetch_assoc($recordSql)) {
        $record .= "
            <tr>
                <td width=\"290\" align=\"left\">
                    <p class=\"order-name\">{$array['name']}</p>
                </td>
                <td width=\"84\">{$array['id']}</td>
                <td width=\"180\" align=\"center\">
                    <a>删除</a>
                </td>
                <td width=\"84\" align=\"center\">
                    <a class=\"td-color-one\" href=\"{$root}deviceDetails.php?id={$array['id']}\">详情</a>
                </td>
                <td width=\"180\">{$array['time']}</td>
            </tr>
        ";
    }
}*/
//查询投诉的次数
$complainNumber = mysql_num_rows(mysql_query("select * from complain where khid = '$kehu[khid]' "));
if($complainNumber % 10 == 0){
    $total_page = intval($complainNumber / 10);
}else{
    $total_page = intval($complainNumber / 10)+1;
}
//查询预约的次数
$bespeakNumber = mysql_num_rows(mysql_query("select * from bespeak where khid = '$kehu[khid]' "));
if($bespeakNumber % 10 == 0){
    $total_page2 = intval($bespeakNumber / 10);
}else{
    $total_page2 = intval($bespeakNumber / 10)+1;
}
//查询维修记录的次数
$client = query("kehu", "khid = '$kehu[khid]' ");
$complainNumber = mysql_num_rows(mysql_query("select * from service where contactNumber = '$client[accountNumber]' "));
if($complainNumber % 10 == 0){
    $total_page3 = intval($complainNumber / 10);
}else{
    $total_page3 = intval($complainNumber / 10)+1;
}
echo head("pc").headerPC().navTwo();
?>
<!-- 内容 -->
<div class="device-bg">
    <!--侧边栏-->
    <div class="user-wrap container clearfix">
        <div class='user-sidebar'>
            <!--<div class='user-head'>
                <div class='user-heads'> <img src='<?php /*echo HeadImg($kehu['sex'],$kehu['ico']);*/?>' alt='加载中..' onClick='document.headPortraitForm.headPortraitUpload.click()'> </div>
                <p class='user-name' style='color:red'>点击上传头像</p>
            </div>-->
            <ul class='user-options'>
                <li class='current options-title'> <a href='#'><i class='uicon_3 site-icon'></i>我的维修记录</a> </li>
                <li class='options-title'> <a href='#'><i class='uicon_1 site-icon'></i>我的信息</a> </li>
                <li class='options-title'> <a href='#'><i class='uicon_1 site-icon'></i>我的预约</a> </li>
                <li class='options-title'> <a href='#'><i class='uicon_2 site-icon'></i>我的投诉</a> </li>
            </ul>
        </div>

        <!--主体-->
        <div class="user-content options-content">
            <div class="user-content-title"><i class="uicon_1 site-icon"></i>我的维修记录</div>
            <!--buycar-->
            <div class="userCart">
                <div class="userCart-table">
                    <table id="list3">
                        <!--<tr>
                            <th width="290">设备名称</th>
                            <th width="84">设备ID</th>
                            <th width="180">操作</th>
                            <th width="84">操作</th>
                            <th width="180">维修时间</th>
                        </tr>
                        --><?php /*echo $record;*/?>
                        <?php
                        $json = share3(1);
                        echo $json['html3'];
                        ?>
                    </table>
                </div>
            </div>
            <div class="tcdPageCode tcdPageCode3"></div>
        </div>
        <div class="user-content options-content hide">
            <div class="user-content-title"><i class="uicon_1 site-icon"></i>我的信息</div>
            <!--buycar-->
            <div class="userCart user-message">
                <form name="userForm">
                    <ul>
                        <li>
                            <span>登录帐号：</span>
                            <input name="accountNumber" type="text" value="<?php echo $client['accountNumber'];?>" />
                        </li>
                        <li>
                            <span>公司名称：</span>
                            <input name="companyName" type="text" value="<?php echo $client['companyName'];?>" />
                        </li>
                        <li>
                            <span>所属区域：</span>
                            <select name="province" class="select"><?php echo RepeatOption("region","province","--省份--",$Region['province']);?></select>
                            <select name="city" class="select"><?php echo RepeatOption("region where province = '$Region[province]' ","city","--城市--",$Region['city']);?></select>
                            <select name="area" class="select"><?php echo IdOption("region where province = '$Region[province]' and city = '$Region[city]'","id","area","--区县--",$kehu['regionId']);?></select>
                        </li>
                        <li>
                            <span>详细地址：</span>
                            <input name="addressMx" type="text" value="<?php echo $client['addressMx'];?>" />
                        </li>
                        <li>
                            <span>联系人姓名：</span>
                            <input name="contactName" type="text" value="<?php echo $client['contactName'];?>" />
                        </li>
                        <li>
                            <span>联系人手机号码：</span>
                            <input name="contactTel" type="text" value="<?php echo $client['contactTel'];?>" />
                        </li>
                        <li>
                            <span>登录密码：</span>
                            <input name="khpas" type="text" value="<?php echo $client['khpas'];?>" />
                        </li>
                        <li>
                            <a href="#" onClick="Sub('userForm','<?php echo root."library/usData.php?type=modifyData";?>')">修改</a>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
        <div class="user-content options-content hide">
            <div class="user-content-title clearfix">
                我的预约
                <a href="<?php echo $root;?>user/bespeak.php"><span class="fr">服务预约</span></a>
            </div>
            <!--buycar-->
            <div class="userCart">
                <div class="userCart-table">
                    <table id="list2">
                        <!--<tr>
                            <th width="290">设备名称</th>
                            <th width="84">设备ID</th>
                            <th width="180">操作</th>
                            <th width="84">操作</th>
                            <th width="180">预约时间</th>
                        </tr>
                        --><?php /*echo $bespeak;*/?>
                        <?php
                        $json = share2(1);
                        echo $json['html2'];
                        ?>
                    </table>
                </div>
            </div>
            <div class="tcdPageCode tcdPageCode2"></div>
        </div>
        <div class="user-content options-content hide">
            <div class="user-content-title">
                我的投诉
                <a href="<?php echo $root;?>user/complain.php"><span class="fr">投诉</span></a>
            </div>
            <!--buycar-->
            <div class="userCart">
                <div class="userCart-table">
                    <table id="list">
                        <!--<tr>
                            <th width="290">设备名称</th>
                            <th width="84">设备识别ID</th>
                            <th width="180">操作</th>
                            <th width="84">操作</th>
                            <th width="180">投诉时间</th>
                        </tr>
                        --><?php /*echo $complain;*/?>
                        <?php
                        $json = share(1);
                        echo $json['html'];
                        ?>
                    </table>
                </div>
            </div>
            <div class="tcdPageCode"></div>
        </div>
    </div>
</div>
<!--隐藏表单开始-->
<div style="display:none;">
    <form name='headPortraitForm' action='<?php echo root."library/usPost.php";?>' method='post' enctype='multipart/form-data'>
        <input name='headPortraitUpload' type='file' onChange='document.headPortraitForm.submit()'>
    </form>
</div>
<!--隐藏表单结束-->
<!-- 页脚 -->
<?php echo footerPC().warn();?>
</body>
<script>
    window.onload = function() {
        //个人中心切换
        tabSwitch('.options-title', '.options-content');
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
                                var tar = _this.parents('.trList');
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
        //我的投诉分页
        $(".tcdPageCode").createPage({
            pageCount:<?php echo $total_page;?>,
            current:1,
            backFn:function(p){
                $.getJSON('<?php echo $root;?>library/usData.php?act=share',{page:p},function(data){
                    $("#list").html(data.html);
                });
            }
        });
        //我的预约分页
        $(".tcdPageCode2").createPage({
            pageCount:<?php echo $total_page2;?>,
            current:1,
            backFn:function(p){
                $.getJSON('<?php echo $root;?>library/usData.php?act2=share',{page:p},function(data){
                    $("#list2").html(data.html2);
                });
            }
        });
        //我的维修记录分页
        $(".tcdPageCode3").createPage({
            pageCount:<?php echo $total_page3;?>,
            current:1,
            backFn:function(p){
                $.getJSON('<?php echo $root;?>library/usData.php?act3=share',{page:p},function(data){
                    $("#list3").html(data.html3);
                });
            }
        });
    }
    var ms = {
        init:function(obj,args){
            return (function(){
                ms.fillHtml(obj,args);
                ms.bindEvent(obj,args);
            })();
        },
        //填充html
        fillHtml:function(obj,args){
            return (function(){
                obj.empty();
                //上一页
                if(args.current > 1){
                    obj.append('<a href="javascript:;" class="prevPage">上一页</a>');
                }else{
                    obj.remove('.prevPage');
                    obj.append('<span class="disabled">上一页</span>');
                }
                //中间页码
                if(args.current != 1 && args.current >= 4 && args.pageCount != 4){
                    obj.append('<a href="javascript:;" class="tcdNumber">'+1+'</a>');
                }
                if(args.current-2 > 2 && args.current <= args.pageCount && args.pageCount > 5){
                    obj.append('<span>...</span>');
                }
                var start = args.current -2,end = args.current+2;
                if((start > 1 && args.current < 4)||args.current == 1){
                    end++;
                }
                if(args.current > args.pageCount-4 && args.current >= args.pageCount){
                    start--;
                }
                for (;start <= end; start++) {
                    if(start <= args.pageCount && start >= 1){
                        if(start != args.current){
                            obj.append('<a href="javascript:;" class="tcdNumber">'+ start +'</a>');
                        }else{
                            obj.append('<span class="current">'+ start +'</span>');
                        }
                    }
                }
                if(args.current + 2 < args.pageCount - 1 && args.current >= 1 && args.pageCount > 5){
                    obj.append('<span>...</span>');
                }
                if(args.current != args.pageCount && args.current < args.pageCount -2  && args.pageCount != 4){
                    obj.append('<a href="javascript:;" class="tcdNumber">'+args.pageCount+'</a>');
                }
                //下一页
                if(args.current < args.pageCount){
                    obj.append('<a href="javascript:;" class="nextPage">下一页</a>');
                }else{
                    obj.remove('.nextPage');
                    obj.append('<span class="disabled">下一页</span>');
                }
            })();
        },
        //绑定事件
        bindEvent:function(obj,args){
            return (function(){
                obj.on("click","a.tcdNumber",function(){
                    var current = parseInt($(this).text());
                    ms.fillHtml(obj,{"current":current,"pageCount":args.pageCount});
                    if(typeof(args.backFn)=="function"){
                        args.backFn(current);
                    }
                });
                //上一页
                obj.on("click","a.prevPage",function(){
                    var current = parseInt(obj.children("span.current").text());
                    ms.fillHtml(obj,{"current":current-1,"pageCount":args.pageCount});
                    if(typeof(args.backFn)=="function"){
                        args.backFn(current-1);
                    }
                });
                //下一页
                obj.on("click","a.nextPage",function(){
                    var current = parseInt(obj.children("span.current").text());
                    ms.fillHtml(obj,{"current":current+1,"pageCount":args.pageCount});
                    if(typeof(args.backFn)=="function"){
                        args.backFn(current+1);
                    }
                });
            })();
        }
    }
    $.fn.createPage = function(options){
        var args = $.extend({
            pageCount : 15,
            current : 1,
            backFn : function(){}
        },options);
        ms.init(this,args);
    }
</script>
</html>