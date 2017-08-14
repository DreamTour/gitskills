<?php
include "ku/adfunction.php";
ControlRoot("车辆管理");
if(empty($_GET['id'])){
	$title = "新建车型";
}else{
	$Brand = query("Brand"," id = '$_GET[id]' ");
	if($Brand['id'] != $_GET['id']){
		$_SESSION['warn'] = "未找到这个车型";
		header("location:{$root}control/adCarBrand.php");
		exit(0);
	}
	$title = $Brand['type']."-".$Brand['name'];
}
//车辆参数图片
// $carParameter = "
//     <tr>
//        <td>车辆参数图片：</td>
//        <td>
//     ";
// $carParameterSql = mysql_query(" select * from carParameter where BrandId = '$Brand[id]' order by time desc ");
// $num = mysql_num_rows($carParameterSql);
// if($num > 0){
//     while($array = mysql_fetch_array($carParameterSql)){
//         $carParameter .= "
//             <a class='GoodsWin' target='_blank' href='{$root}{$array['src']}'><img src='{$root}{$array['src']}'></a>
//             <a href='{$root}control/ku/adpost.php?carParameterDelete={$array['id']}'><div>X</div></a>
//             ";
//     }
// }else{
//     $carParameter .= "一张图片都没有";
// }
// if($num < 100){
//     $carParameter .= "&nbsp;<span onclick='document.adcarParamIcoForm.adcarParamIcoUpload.click();' class='SpanButton'>新增</span>";
// }
// $carParameter .= "
//        </td>
//     </tr>
//     ";
echo head("ad").adheader();
?>
	<style>label{word-wrap:break-word;line-height:2em;margin:0 0 6px 0;cursor:pointer;border:2px solid #ccc; padding:2px 10px 2px 10px; display:inline-block;}</style>
	<div class="column MinHeight">
		<!--标题开始-->
		<a href="<?php echo "{$root}control/adCarBrand.php";?>"><img src="<?php echo "{$root}img/adimg/adCar.png";?>"></a>
		<p>
			<a href="<?php echo root."control/adCar.php";?>">车辆管理</a>&nbsp;&nbsp;>&nbsp;
			<a href="<?php echo root."control/adCarBrand.php";?>">车型管理</a>&nbsp;&nbsp;>&nbsp;
			<a href="<?php echo $ThisUrl;?>"><?php echo $title;?></a>
		</p>
		<!--标题结束-->
		<!--基本资料开始-->
		<div class="kuang">
			<p>
				<img src="<?php echo root."img/images/text.png";?>">
				车型基本资料
			</p>
			<form name="BrandForm">
				<table class="TableRight">
					<tr>
						<td style="width:200px;">品牌ID号：</td>
						<td><?php echo kong($Brand['id']);?></td>
					</tr>
					<tr>
						<td><span class="must">*</span>&nbsp;品牌名称：</td>
						<td>
							<?php echo RepeatSelect("Brand","type","BrandTypeSelect","select","--选择--",$Brand['type']);?>
							<input name="BrandType" type="text" class="text short" value="<?php echo $Brand['type'];?>">
						</td>
					</tr>
					<tr>
						<td><span class="must">*</span>&nbsp;车系：</td>
						<td>
							<select name="BrandNameSelect" class="select">
								<?php echo RepeatOption("Brand where type = '$Brand[type]'","name","--选择--",$Brand['name']);?>
							</select>
							<input name="BrandName" type="text" class="text short" value="<?php echo $Brand['name'];?>">
						</td>
					</tr>
					<tr>
						<td><span class="must">*</span>&nbsp;年款：</td>
						<td>
							<select name="BrandModelYearSelect" class="select">
								<?php echo RepeatOption("Brand where type = '$Brand[type]' and name = '$Brand[name]'","ModelYear","--选择--",$Brand['ModelYear']);?>
							</select>
							<input name="BrandModelYear" type="text" class="text short" value="<?php echo $Brand['ModelYear'];?>">
						</td>
					</tr>
					<tr>
						<td><span class="must">*</span>&nbsp;车辆型号：</td>
						<td><input name="BrandMotorcycleType" type="text" class="text" value="<?php echo $Brand['MotorcycleType'];?>"></td>
					</tr>
					<?php //echo $carParameter;?>
					<tr>
						<td><span class="must">*</span>&nbsp;厂商指导价：</td>
						<td>￥&nbsp;&nbsp;<input name="BrandguidancePrice" type="text" class="text short" value="<?php echo $Brand['guidancePrice'];?>" placeholder="请输入厂商指导价"> 万元</td>
					</tr>
					<tr>
						<td><span class="must">*</span>&nbsp;国别：</td>
						<td><?php echo radio("BrandNation",explode("，",website("Nnf60655649OE")),$Brand['Nation']);?></td>
					</tr>
					<tr>
						<td><span class="must">*</span>&nbsp;车辆类型：</td>
						<td><?php echo radio("BrandCarType",explode("，",website("ZJy60655043qu")),$Brand['CarType']);?></td>
					</tr>
					<tr>
						<td><span class="must">*</span>&nbsp;进气形式：</td>
						<td><?php echo radio("BrandIntake",explode("，",website("zsb62728867tg")),$Brand['Intake']);?></td>
					</tr>
					<tr>
						<td><span class="must">*</span>&nbsp;变速箱：</td>
						<td><?php echo radio("BrandGearBox",explode("，",website("RXO60655413yz")),$Brand['GearBox']);?></td>
					</tr>
					<tr>
						<td><span class="must">*</span>&nbsp;发动机排量：</td>
						<td>
							<?php echo select("BrandOutputVolume","select","--选择发动机排量--",explode("，",website("RMS60655528WW")),$Brand['OutputVolume'] ); ?> L &nbsp;&nbsp;
							<input name="Brandhorsepower" type="text" class="text short" value="<?php echo $Brand['horsepower'] ;?>" placeholder="请输入马力" />马力
						</td>
					</tr>
					<tr>
						<td><span class="must">*</span>&nbsp;车身结构：</td>
						<td>
							<input type="text" name="BrandbodySize" class="text short" value="<?php echo $Brand['bodySize'];?>" placeholder="车身尺寸，如4753*1811*1458"/> mm &nbsp;
							<?php echo select("Brandseating","select","--选择座位数--",explode("，",website("yiu62730112FT")),$Brand['seating']); ?>
							座&nbsp;
							<?php echo select("Brandbodywork","select","--选择车身结构--",explode("，",website("egW62985848Uo")),$Brand['bodywork']); ?>
						</td>

					</tr>
					<tr>
						<td>工信部综合油耗：</td>
						<td>
							<input type="text" class="text short" name="Brandoil" value="<?php echo $Brand['oil'];?>" placeholder="请输入综合油耗，如6.8"/> (L/100km)
						</td>
					</tr>
					<tr>
						<td>发动机特有技术：</td>
						<td>
							<?php echo checkbox("BrandengineTechnology",explode(",",website("wmv62730196LK")),explode("，",$Brand['engineTechnology'])); ?>
					</tr>

					<tr>
						<td><span class="must">*</span>&nbsp;燃料形式:</td>
						<td><?php echo radio("Brandfuel",explode("，",website("swO62730262Fc")),$Brand['fuel']);?></td>
					</tr>
					<tr>
						<td><span class="must">*</span>&nbsp;供油方式:</td>
						<td><?php echo radio("BrandoilSupplyMode",explode("，",website("HHD62730287SU")),$Brand['oilSupplyMode']);?></td>
					</tr>

					<tr>
						<td><span class="must">*</span>&nbsp;环保标准:</td>
						<td>
							<?php echo radio("BrandenvironmentalStandards",explode("，",website("Ozs62730311Yb")),$Brand['environmentalStandards']);?></td>
					</tr>

					<tr>
						<td><span class="must">*</span>&nbsp;驱动方式:</td>
						<td><?php echo radio("BranddriveMode",explode("，",website("Gns62730325Zd")),$Brand['driveMode']);?></td>
					</tr>

					<tr>
						<td><span class="must">*</span>&nbsp;方向盘助力：</td>
						<td><?php echo radio("BrandsteeringWheelAssist",explode("，",website("ges62730408Dm")),$Brand['steeringWheelAssist']);?></td>
					</tr>

					<tr>
						<td><span class="must">*</span>&nbsp;悬架类型:</td>
						<td>
							<?php echo select("BrandsuspensionTypeFront","select","--选择前悬架类型--",explode("，",website("hoq65379409xM")),$Brand['suspensionTypeFront']); ?>
							&nbsp;&nbsp;
							<?php echo select("BrandsuspensionTypeBack","select","--选择后悬架类型--",explode("，",website("hoq6537940147")),$Brand['suspensionTypeBack']); ?>
					</tr>

					<tr>
						<td><span class="must">*</span>&nbsp;制动器类型:</td>
						<td>
							<?php echo select("BrandbrakeTypeFront","select","--选择前制动器类型--",explode("，",website("buD62730425Ur")),$Brand['brakeTypeFront']); ?>
							&nbsp;&nbsp;
							<?php echo select("BrandbrakeTypeBack","select","--选择后制动器类型--",explode("，",website("buD62730425Ur")),$Brand['brakeTypeBack']); ?>
					</tr>

					<tr>
						<td><span class="must">*</span>&nbsp;驻车制动类型：</td>
						<td><?php echo radio("BrandparkingBrakeType",explode("，",website("fET62730466TI")),$Brand['parkingBrakeType']);?></td>
					</tr>
					<tr>
						<td>安全装备:</td>
						<td><?php echo checkbox("BrandsafetyEquipment",explode("，",website("OMi62730491wZ")),explode("，",$Brand['safetyEquipment']));?></td>
					</tr>
					<tr>
						<td>操控配置:</td>
						<td><?php echo checkbox("BrandcontrolConfiguration",explode("，",website("mfX62730504tG")),explode("，",$Brand['controlConfiguration']));?></td>
					</tr>

					<tr>
						<td>外部配置:</td>
						<td><?php echo checkbox("BrandexternalConfiguration",explode("，",website("MSo62730529hr")),explode("，",$Brand['externalConfiguration']));?></td>
					</tr>

					<tr>
						<td>内部配置:</td>
						<td><?php echo checkbox("BrandinternalConfiguration",explode("，",website("Ioc62730552Ux")),explode("，",$Brand['internalConfiguration']));?></td>
					</tr>
					<tr>
						<td>座椅配置:</td>
						<td><?php echo checkbox("BrandseatConfiguration",explode("，",website("cPT62730567FD")),explode("，",$Brand['seatConfiguration']));?></td>
					</tr>
					<tr>
						<td>多媒体配置:</td>
						<td>
							<?php echo checkbox("BrandmultimediaConfiguration",explode("，",website("aBu62730609cZ")),explode("，",$Brand['multimediaConfiguration']));?></td>
					</tr>

					<tr>
						<td>灯光配置:</td>
						<td><?php echo checkbox("BrandlightingConfiguration",explode("，",website("kku62730643jz")),explode("，",$Brand['lightingConfiguration']));?></td>
					</tr>
					<tr>
						<td>玻璃/后视镜:</td>
						<td><?php echo checkbox("BrandglassAndRearviewMirror",explode("，",website("SGX62730656OW")),explode("，",$Brand['glassAndRearviewMirror']));?></td>
					</tr>

					<tr>
						<td>空调/冰箱:</td>
						<td><?php echo checkbox("BrandairConditioningAndRefrigerator",explode("，",website("tTn62730680or")),explode("，",$Brand['airConditioningAndRefrigerator']));?></td>
					</tr>

					<tr>
						<td>高科技配置:</td>
						<td><?php echo checkbox("BrandHighTechConfiguration",explode("，",website("LzO62730696ae")),explode("，",$Brand['HighTechConfiguration']));?></td>
					</tr>
					<tr>
						<td>车色：</td>
						<td>
							<input name="BrandColor" type="text" class="text" value="<?php echo $Brand['color']; ?>">
						</td>
					</tr>
					<tr>
						<td><span class="must">*</span>&nbsp;显示状态：</td>
						<td><?php echo radio("BrandShow",array("显示","隐藏"),$Brand['xian']);?></td>
					</tr>
					<tr>
						<td><span class="must">*</span>&nbsp;排序号：</td>
						<td><input name="BrandSort" type="text" class="text TextPrice" value="<?php echo $Brand['list']?>" /></td>
					</tr>
					<tr>
						<td>更新时间：</td>
						<td><?php echo kong($Brand['UpdateTime']);?></td>
					</tr>
					<tr>
						<td>创建时间：</td>
						<td><?php echo kong($Brand['time']);?></td>
					</tr>
					<tr>
						<td><input name="adBrandId" type="hidden" value="<?php echo $Brand['id'];?>"></td>
						<td><input onclick="Sub('BrandForm','<?php echo root."control/ku/addata.php";?>')" type="button" class="button" value="提交"></td>
					</tr>
				</table>
			</form>
		</div>
		<!--基本资料结束-->
	</div>
	<div class="hide">
		<!--车辆参数图片-->
		<form name="adcarParamIcoForm" action="<?php echo root."control/ku/adpost.php";?>" method="post" enctype="multipart/form-data">
			<input name="adcarParamIcoUpload" type="file" onchange="document.adcarParamIcoForm.submit();">
			<input name="adcarParamId" type="hidden" value="<?php echo $Brand['id'];?>">
		</form>
	</div>
	<script>
		$(document).ready(function(){
			var Form = document.BrandForm;
			//将品牌分类下拉菜单的值赋值到text
			Form.BrandTypeSelect.onchange = function(){
				Form.BrandType.value = this.value;
				Form.BrandName.value = "";
				Form.BrandModelYear.value = "";
				Form.BrandMotorcycleType.value = "";
				Form.BrandModelYearSelect.innerHTML = "<option value=''>--年款--</option>";
				$.post("<?php echo root."control/ku/addata.php";?>",{BrandTypeGetName:this.value},function(data){
					Form.BrandNameSelect.innerHTML = data.name;
				},"json");
			};
			//将子品牌下拉菜单的值赋值到text
			Form.BrandNameSelect.onchange = function(){
				Form.BrandName.value = this.value;
				Form.BrandModelYear.value = "";
				Form.BrandMotorcycleType.value = "";
				$.post("<?php echo root."control/ku/addata.php";?>",{
					BrandTypeGetModelYear:Form.BrandTypeSelect.value,
					BrandNameGetModelYear:this.value
				},function(data){
					Form.BrandModelYearSelect.innerHTML = data.ModelYear;
				},"json");
			};
			//将年款下拉菜单的值赋值到text
			Form.BrandModelYearSelect.onchange = function(){
				Form.BrandModelYear.value = this.value;
				Form.BrandMotorcycleType.value = "";
			}
			//如果发生点击事件，则显示点击效果
			$(":radio").change(function(){
				$(this).parent("label").siblings("label").css("border","2px solid #ccc");
				$(this).parent("label").css("border","2px solid #f98080");
			});
			$(':checkbox').click(function() {
				if ($(this).is(':checked')) {
					$(this).parent().css("border","2px solid #f98080");
				} else {
					$(this).parent().css("border","2px solid #ccc");
				}
			})

		});
	</script>
<?php echo warn().adfooter();?>