<?php
include "../ku/adfunction.php";
ControlRoot("员工管理");
$admin = adlist("AdListAdmin.jpg","Internal/admin.php","员工管理","本模块专为超级管理员定制，以实现对网站管理员的增删改查。我们已经针对本网站精心定制了多种管理员职位供您选择。您可以自由的添加管理员并给他们赋予相应的职位，让他们各司其职的为您工作。");
$adRepair = adlist("adRepair.jpg","Internal/adRepair.php","设备报修","本模块用于公司内部报修流程");
$adService = adlist("adService.jpg","Internal/adAfterSale.php","维修反馈","本模块用于公司处理设备维修和售后");
$Internal = "";
if(power("员工管理")){
    $Internal .= $admin;
}
/*if(power("设备报修")){
    $Internal .= $adRepair;
}
if(power("维修反馈")){
    $Internal .= $adService;
}*/
$onion = array(
    "内部管理" => root."control/Internal/adInternal.php"
);
echo head("ad").adheader($onion);
?>
    <div class="column minheight">
        <div class="kuang">
            <h2>温馨提示：</h2>
            <p>本模块用于公司内部管理和工作协同</p>
        </div>
        <!--标题结束-->
        <?php echo $Internal;?>
    </div>
<?php echo warn().adfooter();?>