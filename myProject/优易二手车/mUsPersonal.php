<?php
include "../../library/mFunction.php";
$Region = query("region","id = '$kehu[RegionId]' ");
echo head("m");
?>
	<body>
    	<form name="userForm">
		<div class="wrap">
			<div class="mcdiv mcdiv11">
				<p>姓&nbsp;&nbsp;&nbsp;&nbsp;名：<input type="text" name="userName" class="input1" value="<?php echo $kehu['name'];?>" /></p>
				<p>电&nbsp;&nbsp;&nbsp;&nbsp;话：<input type="text" name="userKhtel" class="input1" value="<?php echo $kehu['khtel'];?>" /></p>
				<p>所属区域：
				<select name="province" class="select_width"><?php echo RepeatOption("region","province","--省份--",$Region['province']);?></select>
                                <select name="city" class="select_width"><?php echo RepeatOption("region where province = '$Region[province]' ","city","--城市--",$Region['city']);?></select>
                                <select name="area" class="select_width"><?php echo IdOption("region where province = '$Region[province]' and city = '$Region[city]'","id","area","--区县--",$kehu['RegionId']);?></select>
				</p>
				<p>详细地址：<input type="text" name="usreAddressMx" class="input1" value="<?php echo $kehu['AddressMx'];?>" /></p>
			</div>
			<a href="#" class="queren" onClick="Sub('userForm','<?php echo root."library/mData.php";?>')">确认修改</a>
		</div>
        </form>
	</body>
<?php echo warn();?>    
<script>
$(function(){
	var Form = document.userForm;
	//根据省份获取下属城市下拉菜单
	Form.province.onchange = function(){
		Form.area.innerHTML = "<option value=''>--区县--</option>";
		$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostCity:this.value},function(data){
			Form.city.innerHTML = data.city;
		},"json");
	}
	//根据省份和城市获取下属区域下拉菜单
	Form.city.onchange = function(){
		$.post("<?php echo root."library/OpenData.php";?>",{ProvincePostArea:Form.province.value,CityPostArea:this.value},function(data){
			Form.area.innerHTML = data.area;
		},"json");
	}	
})
</script>    
</html>