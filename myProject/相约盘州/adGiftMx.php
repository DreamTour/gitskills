<?php
include "ku/adfunction.php";
ControlRoot("礼物管理");
if(isset($_GET['id']) and !empty($_GET['id'])){
	$id = $_GET['id'];
	//根据传过来的id号查询礼物
    $Gift = query("Gift"," id = '$id' ");
	//没有查询到
	if(empty($Gift['id'])){
		$_SESSION['warn'] = "未找到这个礼物的信息";
		header("location:{$adroot}adGift.php");
		exit(0);
	}else{
		//礼物名称
		$title = $Gift['name'];
		//礼物图像
		$giftIco = "&nbsp;<span onclick='document.adGiftIcoForm.adGiftIcoUpload.click();' class='SpanButton'>更新</span>";
	}
}else{
	$title = "新建礼物";
}
echo head("ad").adheader();
?>
<div class="column MinHeight">
    <!--标题开始-->
    <a href="<?php echo "{$adroot}adGift.php";?>"><img src="<?php echo "{$root}img/adimg/adGift.png";?>"></a>
	<p>
		<a href="<?php echo "{$adroot}adGift.php";?>">礼物管理</a>&nbsp;>&nbsp;
		<a href="<?php echo $ThisUrl;?>"><?php echo $title;?></a>
	</p>
	<!--标题结束-->
	<!--基本资料开始-->
	<div class="kuang">
    <p>
    	<img src="<?php echo root."img/images/PersonalData.png";?>">
        礼物基本资料
    </p>
    <form name="GiftForm">
    	<table class="TableRight">
			<tr>
			    <td style="width:200px;">礼物ID号：</td>
				<td><?php echo kong($Gift['id']);?></td>
			</tr>
            <tr>
            	<td><span class="must">*</span>&nbsp;礼物名称：</td>
                <td><input name="giftName" type="text" class="text" value="<?php echo $Gift['name'];?>" /></td>
            </tr>
			<tr>
			    <td><span class="must">*</span>&nbsp;礼物单价：</td>
				<td><input name="giftPrice" type="text" class="text" value="<?php echo $Gift['price'];?>" /></td>
			</tr>
			<tr>
			    <td>礼物图像：</td>
				<td><?php echo ProveImgShow($Gift['ico']).$giftIco;?></td>
			</tr>
		    <tr>
			    <td>更新时间：</td>
				<td><?php echo kong($Gift['UpdateTime']);?></td>
			</tr>
		    <tr>
			    <td>创建时间：</td>
				<td><?php echo kong($Gift['time']);?></td>
			</tr>
            <tr>
            	<td><input name="adGiftId" type="hidden" value="<?php echo $Gift['id'];?>" /></td>
                <td><input type="button" class="button" value="提交" onClick="Sub('GiftForm','<?php echo root."control/ku/addata.php";?>')" /></td>
            </tr>
		</table>
    </form>	
	</div>
	<!--基本资料结束-->
</div>
<div class="hide">
<form name="adGiftIcoForm" action="<?php echo "{$adroot}ku/adpost.php";?>" method="post" enctype="multipart/form-data">
<input name="adGiftIcoUpload" type="file" onchange="document.adGiftIcoForm.submit();">
<input name="adGiftId" type="hidden" value="<?php echo $Gift['id'];?>">
</form>
</div>   
<?php echo warn().adfooter();?>