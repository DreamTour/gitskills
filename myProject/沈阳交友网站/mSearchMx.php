<?php
include "mLibrary/mFunction.php";
echo head("m");
UserRoot("m");
//生成年龄下拉菜单
for($n = 18;$n <= 60;$n++){
		$option[$n] = $n."岁";
	}
$Age1 = select('searchMinAge','age1',"年龄",$option);
$Age2 = select('searchMaxAge','age2',"年龄",$option);
?>
<!--头部-->
<div class="header fz16">
    <div class="head-center">
    	<div class="head-left"><a href="<?php echo $root;?>m/mSearch.php" class="col1">&lt;返回</a></div>
    	<h3></h3>
    </div>
</div>
 <!--个人资料-->
 <div class="se-mx-content">
 	<form name="searchForm" action="<?php echo root."library/usPost.php";?>" method="post">
    <ul class="pe-item-box bg2">
        <li class="pe-item"><span>性别</span>
        	<select name="searchSex" class="s_style4">
                <option value="">请选择</option>
                <option value="男">男</option>
                <option value="女">女</option>
            </select>
        </li>
        <li class="pe-item"><span>年龄</span><?php echo $Age1;?><span id="age-line">-</span><?php echo $Age2;?></li>
        <li class="pe-item"><span>所在地区</span>
        	<select name="area" class="s_style3">
                <?php echo IdOption("region where province = '辽宁省' and city = '沈阳市'","id","area","--区县--",$_SESSION['userSearch']['area']);?>
            </select>
        </li>
    </ul>
    <div class="se-btn-box"><a href="javascript:;" class="se-btn fz16 col1 fw2" onClick="document.searchForm.submit();">确定</a></div>
    </form>
</div>
<!--底部-->
</body>
</html>
