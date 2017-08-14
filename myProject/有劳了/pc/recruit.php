<?php
include "library/PcFunction.php";
//打印详情
$demand = mysql_fetch_array(mysql_query("select * from demand where id = '$_GET[demandMx_id]' "));
$recruit = query("kehu","khid = '$demand[khid]'");
$personal = query("personal","khid = '$recruit[khid]'");
$age = date("Y") - substr($personal['Birthday'],0,4);
$region = query("region","id = '$jobMx[RegionId]'");
//根据ClassifyId查询分类
$classify = query("classify","id = '$demand[ClassifyId]' ");
//判断是否改变按钮值和颜色
$collectNum = mysql_fetch_array(mysql_query("select * from collect where khid = '$kehu[khid]' and TargetId = '$_GET[demandMx_id]' "));
if($collectNum > 0){
    $buttonValue = "取消收藏";
    $buttonBackground = "style='background:#999;'";
}else{
    $buttonValue = "收藏";
    $buttonBackground = "";
}
//是否显示联系人全名
if(empty($recruit['ContactNameOpen'])){
    $recruit['ContactName'] = "保密";
}
//判断是否显示联系号码
if($GLOBALS['KehuFinger'] == 1){
    $contactNumber = $recruit['ContactTel'];
    $contactEmail = $recruit['email'];
}
//判断收费类型，根据收费类型显示内容
if ($demand['payType'] == "薪酬") {
    $pay = "{$demand['pay']}/{$demand['PayCycle']}";
}
else {
    $pay = $demand['payType'];
}
echo head("pc").pcHeader();
?>
<!--内容-->
<div class="info-container">
    <!--导航-->
    <?php echo pcNavigation();?>
    <!--row-->
    <div class="row">
        <!--面包屑导航-->
        <div class="breadcrumb-nav">
            <a href="<?php echo $root;?>index.php">首页</a><span>>></span>
            <a href="<?php echo $root;?>job.php">优职</a><span>>></span>
            <a href="<?php echo $root."job.php?classifyType=".$classify['type'];?>"><?php echo $classify['type'];?></a><span>>></span>
            <a href="<?php echo $root."job.php?classifyId=".$classify['id'];?>"><?php echo $classify['name'];?></a>
        </div>
        <!--劳务详情-->
        <div class="job-content">
            <div class="job-header clearfix">
                <div class="job-title fl"><h2><?php echo $demand['title'];?></h2><span><?php echo $recruit['ContactName'];?></span></div>
                <div class="function-box fl">
                    <a href="javascript:;" <?php echo $buttonBackground;?> class="job-collect-btn" demandId="<?php echo $_GET['demandMx_id'];?>"><i class="job-icon job-icon01"></i><?php echo $buttonValue;?></a>
                    <a href="javascript:;" class="share-btn"><i class="job-icon job-icon02"></i>分享</a>
                    <!-- JiaThis Button BEGIN -->
                    <div class="jiathis_style_32x32 hide">
                        <a class="jiathis_button_qzone"></a>
                        <a class="jiathis_button_tsina"></a>
                        <a class="jiathis_button_tqq"></a>
                        <a class="jiathis_button_weixin"></a>
                        <a class="jiathis_button_renren"></a>
                        <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
                    </div>
                    <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
                    <!-- JiaThis Button END -->
                    <a href="javascript:;" class="inform-btn" id="informBtn"><i class="job-icon job-icon03"></i>举报</a>
                </div>
                <a href="javascript:;" class="jobApply-btn fr">查看联系方式</a>
            </div>
            <!--举报弹出层-->
            <div class="inform-popUp hide" id="informPopUp">
                <div id="informClose"><img src="../img/WebsiteImg/vZd61501073iN.jpg"></div>
                <form name="ReportForm">
                    <label><input name="Report[]" type="checkbox" value="虚假信息/冒用他人信息" /><span>虚假信息/冒用他人信息</span></label>
                    <label><input name="Report[]" type="checkbox" value="不良信息/违法违规信息" /><span>不良信息/违法违规信息</span></label>
                    <label><input name="Report[]" type="checkbox" value="有瞒偏和欺诈行为" /><span>有瞒偏和欺诈行为</span></label>
                    <label><input name="Report[]" type="checkbox" value="恶意营销、广告" /><span>恶意营销、广告</span></label>
                    <input name="targetId" type="hidden" value="<?php echo $demand['khid'];?>" />
                    <input name="ReportType" type="hidden" value="优职" />
                </form>
                <a href="javascript:;" class="inform-btn inform-btn2" id="informBtn2">确认举报</a>
            </div>
            <div class="job-body-box clearfix">
                <div class="job-body-left fl">
                    <ul class="job-details clearfix">
                        <li><span class="textTitle">方式:</span><?php echo $demand['mode'];?></li>
                        <li><span class="textTitle">面向：</span><?php echo $demand['face'];?></li>
                        <li><span class="textTitle">薪酬：</span><?php echo $pay?></li>
                        <li><span class="textTitle">需求时间：</span><?php echo $demand['StartTime'];?> 至 <?php echo $demand['EndTime'];?></li>
                        <li><span class="textTitle">类型：</span><?php echo $demand['type'];?></li>
                        <li class="contact_way hide" style="color: #FFC107;"><span class="textTitle">电话：</span><?php echo $contactNumber;?></li>
                        <li class="contact_way hide" style="color: #FFC107;"><span class="textTitle">邮箱：</span><?php echo $contactEmail;?></li>
                    </ul>
                    <div class="job-info">
                        <h2>说明</h2>
                        <p><?php echo $demand['text'];?></p>
                    </div>
                </div>
                <div class="job-body-right fr">
                    <a href="javascript:;"><img src="<?php echo img("KXQ57016334gu");?>"></a>
                    <a href="javascript:;"><img src="<?php echo img("eZn57016371kp");?>"></a>
                    <a href="javascript:;"><img src="<?php echo img("FlH57016428QU");?>"></a>
                </div>
            </div>
        </div>
    </div>
    <!--row-->
</div>
<script>
    $(function(){
        //收藏
        $('.job-collect-btn').click(function(){
            var demandId = $("[demandId]").attr("demandId");
            var element = "<i class='job-icon job-icon01'></i>";
            $.post("<?php echo root."library/usdata.php";?>",{collectiondemandId:demandId,demandType:"优职"},function(data){
                warn(data.warn);
                if(data.warn == "收藏成功"){
                    $("[demandId="+demandId+"]").html(element+"取消收藏").css("background","#999");
                }else if(data.warn == '取消成功'){
                    $("[demandId="+demandId+"]").html(element+"收藏").css("background","#689fee");
                }
            },"json");
        })
        //查看联系方式
        $('.jobApply-btn').click(function(){
            //判断是否显示联系号码
            var ClientFinger = "<?php echo $KehuFinger;?>";
            if(ClientFinger == 1){
                $('.contact_way').show();
            }else{
                warn("未登陆，请在网站右上角选择登录");
            }
        });
        //分享
        var jiathis = $('.jiathis_style_32x32');
        $('.share-btn').mouseenter(function(){
            jiathis.show();
        })
        jiathis.mouseleave(function(){
            $(this).hide();
        })
        /*举报弹出层*/
        var informBtn=document.getElementById("informBtn"),
            informPopUp=document.getElementById("informPopUp"),
            informClose=document.getElementById("informClose"),
            informBtn2=document.getElementById("informBtn2");
        informBtn.onclick=function(){
            informPopUp.style.display="block";
        };
        informBtn2.onclick=function(){
            //点击提交表单
            $.post("<?php echo "{$root}library/usdata.php?reportMessage";?>",$('[name=ReportForm]').serialize(),function(data) {
                warn(data.warn);
            }, "json")
        };
        informClose.onclick=function(){
            informPopUp.style.display="none";
        }
    })
</script>
<!--页脚-->
<?php echo pcFooter().warn();?>
