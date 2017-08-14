<?php
include "ku/adfunction.php";
ControlRoot("摆位图");
$system = query("system"," id = '$_GET[id]' ");
if(empty($system['id']) and $system['id'] != $_GET['id']){
    $_SESSION['warn'] = "未找到这个系统的信息";
    header("location:{$adroot}adClient.php");
    exit(0);
}
//摆位图
$sketchMap = "
	<tr>
	   <td>摆位图：</td>
	   <td>
	";
$sketchMapSql = mysql_query(" select * from systemImg where systemId = '$system[id]' order by time desc ");
$num = mysql_num_rows($sketchMapSql);
if($num > 0){
    while($array = mysql_fetch_array($sketchMapSql)){
        $sketchMap .= "
			<a class='GoodsWin' href='{$root}control/adSystemImg.php?imgId={$array['id']}&systemId=$_GET[id]'><img src='{$root}{$array['src']}'></a>
			<a href='{$root}control/ku/adpost.php?sketchMapDelete={$array['id']}'><div>X</div></a>
			";
    }
}else{
    $sketchMap .= "一张图片都没有";
}
if($num < 4){
    $sketchMap .= "&nbsp;<span onclick='document.adSketchMapMxIcoForm.adSketchMapMxIcoUpload.click();' class='SpanButton'>新增</span> 请上传宽度为1000px的图片";
}
$sketchMap .= "
       </td>
    </tr>
	";
$onion = array(
    "摆位图" => "{$root}control/adSystem.php",
    kong($system['name']) => $ThisUrl
);
echo head("ad").adheader($onion);
?>
    <div class="column MinHeight">
        <!--基本资料开始-->
        <div class="kuang">
            <p>
                <img src="<?php echo root."img/images/text.png";?>">
                系统基本资料
            </p>
            <form name="SystemForm">
                <table class="TableRight">
                    <tr>
                        <td style="width:200px;">系统ID号：</td>
                        <td><?php echo kong($system['id']);?></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;系统名称：</td>
                        <td><input name="name" type="text" class="text" value="<?php echo $system['name'];?>"></td>
                    </tr>
                    <tr>
                        <td><span class="must">*</span>&nbsp;系统简称：</td>
                        <td><input name="abbreviation" type="text" class="text" value="<?php echo $system['abbreviation'];?>"></td>
                    </tr>
                    <?php echo $sketchMap;?>
                    <tr>
                        <td>更新时间：</td>
                        <td><?php echo kong($system['updateTime']);?></td>
                    </tr>
                    <tr>
                        <td>创建时间：</td>
                        <td><?php echo kong($system['time']);?></td>
                    </tr>
                    <tr>
                        <td><input name="adSystemId" type="hidden" value="<?php echo $system['id'];?>"></td>
                        <td><input onclick="Sub('SystemForm','<?php echo root."control/ku/addata.php?type=adSystemMx";?>')" type="button" class="button" value="提交"></td>
                    </tr>
                </table>
            </form>
        </div>
        <!--基本资料结束-->
    </div>
    <!--隐藏表单-->
    <div class="hide">
        <!--摆位图-->
        <form name="adSketchMapMxIcoForm" action="<?php echo root."control/ku/adpost.php";?>" method="post" enctype="multipart/form-data">
            <input name="adSketchMapMxIcoUpload" type="file" onchange="document.adSketchMapMxIcoForm.submit();">
            <input name="adSystemId" type="hidden" value="<?php echo $system['id'];?>">
        </form>
    </div>
<?php echo warn().adfooter();?>