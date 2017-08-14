<?php
include "../library/mFunction.php";
$kehu = query("kehu"," khid = '$kehu[khid]' ");
if(empty($kehu['longitude']) and empty($kehu['latitude'])){
    $sql = "select * from Gym where xian = '显示' order by time ";
}else{
    $sql = "select sqrt(POWER((longitude-$kehu[longitude]),2)+POWER((latitude-$kehu[latitude]),2)) as sq,id,name,type,RegionId,AddressMx,PeopleNum,ico,list from Gym where xian = '显示' order by sq";
}
$result = mysql_query($sql);
while($array = mysql_fetch_assoc($result)){
    if (!empty($array['ico'])) {
        $ico = $root.$array['ico'];
    }else{
        $ico = img("Ffp46226310zK"); //替换图像
    }
    $html .= "<a href='{$root}m/mHealth.php?id={$array['id']}'>
                             <li>
                                <div class='fbd1left'>
                                    <i></i>
                                    <img src='{$ico}' alt='{$array['name']}' />
                                </div>
                                <div class='fbd1right'>
                                    <span >{$array['name']}</span>
                                    <p>{$array['type']}<p/><p>{$array['AddressMx']}</p>
                                </div>
                            </li>
                        </a>";
}
echo head("m");
?>
<!-- 选择列表 -->
<!--<div class="wrap-box">
    <div class="select-list">
        <div class="list-parent" id="listParentBtn">
            深圳全城
            <i class="arrow-icon">&#xe60e;</i>
        </div>
        <div class="list-child" id="listChildBtn">
            选择地区
            <i class="arrow-icon">&#xe60e;</i>
        </div>
    </div>
</div>-->
<!-- 选择列表 end -->
<!-- 选择列表父级弹出层  -->
<!--<div class="select-list-shade hide" id="listParentShade">
    <div class="shade-template">
        <ul>
            <li>
                <h3>
                    重庆市
                    <div class="template-line"></div>
                </h3>
                <div class="template-close">
                    <a class="current" href="javascript:;">南岸区</a>
                    <a href="javascript:;">渝北区</a>
                </div>
            </li>
            <li>
                <h3>
                    重庆市
                    <div class="template-line"></div>
                </h3>
                <div class="template-close">
                    <a href="javascript:;">南岸区</a>
                    <a href="javascript:;">渝北区</a>
                </div>
            </li>
            <li>
                <h3>
                    重庆市
                    <div class="template-line"></div>
                </h3>
                <div class="template-close">
                    <a href="javascript:;">南岸区</a>
                    <a href="javascript:;">渝北区</a>
                </div>
            </li>
            <li>
                <h3>
                    重庆市
                    <div class="template-line"></div>
                </h3>
                <div class="template-close">
                    <a href="javascript:;">南岸区</a>
                    <a href="javascript:;">渝北区</a>
                </div>
            </li>
            <li>
                <h3>
                    重庆市
                    <div class="template-line"></div>
                </h3>
                <div class="template-close">
                    <a href="javascript:;">南岸区</a>
                    <a href="javascript:;">渝北区</a>
                </div>
            </li>
            <li>
                <h3>
                    重庆市
                    <div class="template-line"></div>
                </h3>
                <div class="template-close">
                    <a href="javascript:;">南岸区</a>
                    <a href="javascript:;">沙坪坝区</a>
                    <a href="javascript:;">沙坪坝区</a>
                    <a href="javascript:;">渝北区</a>
                </div>
            </li>
            <li>
                <p>更多健身舱，敬请期待</p>
            </li>
        </ul>
    </div>
</div>-->
<!-- 选择列表父级弹出层 end -->
<!-- 选择列表子级弹出层  -->
<!--<div class="select-list-shade hide" id="listChildShade">
    <div class="shade-template">
        <ul>
            <li>
                <h3>
                    重庆市全城-猩店主题
                    <div class="template-line-short"></div>
                </h3>
                <div class="template-close">
                    <a class="current" href="javascript:;">南岸区</a>
                    <a href="javascript:;">渝北区</a>
                    <a href="javascript:;">渝北区</a>
                    <a href="javascript:;">渝北区</a>
                    <a href="javascript:;">渝北区</a>
                    <a href="javascript:;">渝北区</a>
                    <a href="javascript:;">渝北区</a>
                    <a href="javascript:;">渝北区</a>
                </div>
            </li>
        </ul>
    </div>
</div>-->
<!-- 选择列表子级弹出层 end -->
<div class="wrap">
    <div class="fbdiv1 wrap-box" style="margin-bottom: 2.5%;">
        <ul>
            <?php echo $html;?>
        </ul>
    </div>
</div>
<script>
    window.onload = function() {
        /**
         * 选择列表
         * @author He Hui
         * */
        /*var listParentBtn = document.getElementById('listParentBtn');
         var listChildBtn = document.getElementById('listChildBtn');
         var listParentShade = document.getElementById('listParentShade');
         var listChildShade = document.getElementById('listChildShade');
         listParentBtn.onclick = function() {
         listParentShade.style.display = 'block';
         }
         listParentShade.onclick = function() {
         this.style.display = 'none';
         }
         listChildBtn.onclick = function() {
         listChildShade.style.display = 'block';
         }
         listChildShade.onclick = function() {
         this.style.display = 'none';
         }*/
    }

    $.post("<?php echo root."library/backups.php";?>",{ThisBackups:"ThisBackups"});
</script>
<?php echo mWarn().footer();?>
</body>
</html>