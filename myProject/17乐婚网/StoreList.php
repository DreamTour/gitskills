<?php         
include "library/function.php";        
$TypeOne = query("TypeOne"," id = '$_GET[TypeOne]' ");        
$ThisUrl = "{$root}StoreList.php?TypeOne={$_GET['TypeOne']}";        
//当商家列表页分类改变时，清空模糊查询        
if($_SESSION['SearchStore']['SellerType'] != $_GET['TypeOne']){        
    unset($_SESSION['SearchStore']);       
}   
if($_GET['TypeOne'] == "all" ){ 
    $sql=$_SESSION['SearchStore']['Sql']; 
}else{ 
    $sql="select * from seller where TypeOneId = '$_GET[TypeOne]' and prove = '已通过' "; 
} 

$num = mysql_num_rows(mysql_query($sql));        
paging($sql," order by authentication='已认证' desc,PageView desc,time",100);        
echo head("pc");ThisHeader();        
echo insertBackUrl();        
?>        
<style>        
.StoreListLeft{ width:900px; float:left; background-color:#fff; padding:10px; border:1px solid #e9e9e9; margin:10px auto auto auto;}        
.StoreListRight{ width:250px; float:right; background-color:#fff; padding:10px; border:1px solid #e9e9e9; margin:-49px auto auto auto;}        
.StoreListDiv{ margin-bottom: 15px;height:81px;padding:16px 0 16px 0; border-bottom:1px solid #e9e9e9;}        
.StoreLogoDiv{ padding:4px; border:1px solid #e9e9e9; width:112px; height:80px; float:left; margin:auto 10px auto auto;}        
.StoreLogo{ width:112px; height:80px;}        
.StoreListTitle{ font-size:18px; font-weight:bold;}        
.StoreListMx{ font-size:14px; color:#888; line-height:20px;margin-top: 10px;}      
.dimStar i{background-color:transparent;}    
.dimStar{top:5px}    
.dimStar > b{position: relative;top: -4px;}   
.stScoreShow{margin-top: -53px;}   
</style>        
<div class="column">        
    <!--洋葱皮开始--> 
    <?php  
    if($_GET['TypeOne'] != "all"){ 
    ?> 
    <div class="kuang">        
        <p class="smallword">        
            当前位置：        
            <a href="<?php ro();?>">首页</a>&nbsp;>&nbsp;        
            <a href="<?php echo "{$root}goods.php?TypeOne={$_GET[TypeOne]}";?>"><?php echo $TypeOne['name'];?></a>&nbsp;>&nbsp;        
            <a href="<?php echo "{$root}StoreList.php?TypeOne={$_GET[TypeOne]}";?>">更多商铺</a>        
        </p>        
    </div> 
    <?php      
    } 
    ?>        
    <!--洋葱皮结束-->        
    <!--左边开始-->        
    <div class="StoreListLeft">        
        <form action="<?php echo "{$root}library/PcPost.php";?>" method="post">        
            <input name="SearchStoreBrandList" type="text" value="<?php echo $_SESSION['SearchStore']['Brand'];?>">        
            <input name="SellerType" type="hidden" value="all">        
            <input type="submit" value="搜索店铺" class="searchBtn">        
        </form>        
    </div>             
    <div class="StoreListLeft">        
        <?php        
        if($num > 0){        
            while($seller = mysql_fetch_array($query)){        
                //获取商家是否有现金卷    
                $avgscore = mysql_fetch_array(mysql_query("select avg(score) from secomment where commenttargetid = '$seller[seid]' and status = '已通过' "));   
                $score =(double)substr($avgscore[0],0,3);      
                $coupon = query("coupon"," coupontargetid = '$seller[seid]' ");       
                if($coupon['couponid'] !=""){       
                    $IsCoupon ="<i class='couponsOwner' title='现金券'></i> ";       
                }else{       
                    $IsCoupon ="";       
                }       
                //获取商家是否有评论       
                $secomment =query("secomment"," commenttargetid = '$seller[seid]' and status ='已通过' ");       
                if($secomment['secommentid'] !=""){       
                    $IsSecommentid ="<i class='remarkedSeller' title='有评商户'></i> ";       
                }else{       
                    $IsSecommentid ="";       
                }       
                       
                //修正商家认证状态图标        
                if($seller['authentication'] == "已认证"){        
                    $authentication = "<i class='authOwner' title='已认证'></i>";        
                }else{        
                    $authentication = "";        
                }      
                        
                //商家保障状态图标        
                if($seller['Guarantee'] == "关闭" or $seller['Guarantee'] == ""){        
                    $status = "";        
                }else{        
                    $status = "<i class='couponsSafe' title='消费保障'></i> ";        
                }       
				if($seller['League'] == "开"){
				    $league = "<i style='background-position: -2px -82px' class='couponsSafe' title='积分盟约'></i>";     
				}else{
				    $league = "";
				}
                //模糊查询关键字高亮显示        
                if(isset($_SESSION['SearchStore']['name'])){        
                    $seller['name'] = str_replace($_SESSION['SearchStore']['name'],"<span class='purpose'>{$_SESSION['SearchStore']['name']}</span>",$seller['name']);        
                }        
                if($seller['Brand'] == ""){        
                    $SellerName = $seller['name'];        
                }else{        
                    $SellerName = $seller['Brand'];        
                }        
                echo "        
                <a href='{$root}store.php?seller={$seller['seid']}' class='clear'>        
                    <div change='divback' class='StoreListDiv'>        
                        <div class='StoreLogoDiv'>        
                            <img class='StoreLogo' src='".ListImg($seller['logo'])."'>        
                        </div>        
                        <p class='StoreListTitle'>        
                            {$SellerName}&nbsp;{$authentication}{$IsCoupon}{$IsSecommentid}{$status}{$league}     
                        </p>        
                        <p class='StoreListMx'>商家地址：{$seller['address']}</p>        
                        <p class='StoreListMx' style='margin-top:10px;'>注册时间：{$seller['time']}</p>      
                        <span class='storePop'>人气指数：{$seller['PageView']}</span>      
                        <div class='stScoreShow'>     
                            <div class='dimStar'>     
                               <i class='greyFive'></i>    
                               <i class='yellowFive' style='width: ".($score*15)."px;'></i>      
                            </div>       
                            <b>{$score}分</b>      
                        </div>     
                        <div class='clear'></div>        
                    </div>        
                </a>        
                ";        
            }        
        }else{        
            echo "一个商家都没有";        
        }        
        ?>        
        </ul>        
        <div style="padding:10px;"><?php echo fenye($ThisUrl);?></div>        
    </div>   
    <div class="StoreListRight">   
        <h3>最新产品</h3>  
        <?php   
        $NewGoodsSql = mysql_query("select * from goods where Auditing = '已通过' order by UpdateTime desc limit 4");  
        while($NewGoods = mysql_fetch_array($NewGoodsSql)){  
            $TypeTwoResult = query("TypeTwo"," id = '$NewGoods[TypeTwoId]'");  
            echo "  
                <a class='sinStroePush' href='{$root}goodsmx.php?TypeOne={$TypeTwoResult['TypeOneId']}&goods={$NewGoods['id']}'>   
                    <img src='{$root}{$NewGoods['ico']}' class='stPushImg'/>   
                    <p class='stName' style='color:#8C8C8C;'>{$NewGoods['name']}</p>  
                    <p class='stName'>￥{$NewGoods['price']}</p>   
                </a>  
                ";  
        }  
        ?>   
    </div>       
</div>        
<?php         
echo warn();        
ThisFooter();        
?>       