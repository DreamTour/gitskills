<?php         
include "Mlibrary/mfunction.php";           
echo head("m");         
?>            
<header> <a href="<?php echo "{$mroot}mindex.php";?>"><i class="u_return"></i></a><a href="<?php echo $root;?>m/mUser/mUser.php"><i class="u_login"></i></a>      
    <p class="search-line">       
      <input type="button" id="popBtn" accesskey="s" aria-controls="true" class="search-icon">       
      <input type="search" id="popSear" accesskey="s" autocomplete="off" aria-haspopup="true" class="searcc-box" placeholder="搜索商家">       
    </p>  
</header>             
<section>           
  <aside class="list-nav">         
     <a href="<?php echo "{$mroot}mList.php?TypeOne=$_GET[TypeOne]";?>">全部商家</a>           
  </aside>           
</section>           
<section>           
  <div class="list-block">           
    <ul class="list-wrap">           
      <?php    
        if($_GET['store'] != "" and isset($_GET['store'])){  
            $sql="select * from seller where name like '%$_GET[store]%' and authentication = '已认证' or Brand like '%$_GET[store]%' and authentication = '已认证' order by authentication='已认证' desc,PageView desc,time desc";          
        }else{  
            $sql="select * from seller where TypeOneId ='$_GET[TypeOne]' and authentication = '已认证' order by authentication='已认证' desc,PageView desc,time desc";   
        }  
        $Seller_query =mysql_query($sql);          
        if(mysql_num_rows($Seller_query) == 0){          
            echo "没有相关商家";              
        }else{          
            while($Seller_result =mysql_fetch_array($Seller_query)){     
                //检测商家是否已经认证    
                $Score_result =mysql_fetch_array(mysql_query("select avg(score) from secomment where commenttargetid ='$Seller_result[seid]' and status ='已通过' "));           
                $avgscore =(double)substr($Score_result[0],0,3);    
                if($Seller_result['authentication'] == "已认证"){     
                    $prove = "<em style=\"margin-right:5px\" class=\"zheng\">已认证</em>";     
                }else{     
                    $prove = "";     
                }     
                if($Seller_result['Guarantee'] == "关闭" or $Seller_result['Guarantee'] ==""){     
                    $Guarantee = "";     
                }else{     
                    $Guarantee = "<em class=\"fei\">消费保障</em>";     
                }     
                $Coupons = query("coupon"," coupontargetid = '$Seller_result[seid]' ");   
                if($Coupons['couponid'] != ""){   
                    $coupon ="<em class=\"jin\">现金券</em>";   
                }else{
                    $coupon ="";   
				} 
                echo "          
                      <li>
                          <a href=\"{$mroot}mStore.php?seller=$Seller_result[seid]\" class=\"block-elm\">
                          <img src=\"".ListImg($Seller_result['logo'])."\">
                          <dl class=\"ltwrap\">
                            <dt><span>{$Seller_result['Brand']}</span></dt>
                            <dd>{$prove}{$Guarantee}{$coupon}</dd>
                            <dd>
                            <span class=\"all-star\">
                            <i class='top-star' style=\"width:".($avgscore*15)."px;\"></i>
                            <i class='bottom-star'></i>
                            <ins>&nbsp;{$avgscore}分</ins></span><ins>&nbsp;人气指数:{$Seller_result['PageView']}</ins></dd>
                            <dd>商家地址:{$Seller_result['address']}</dd>
                          </dl>
                          <i class=\"arround-go\"></i>
                         </a>          
                      </li>
                     ";          
            }   
        }   
      ?>          
    </ul>           
  </div>           
</section>           
<?php echo mPageFooter();?>     
<script>  
    $('#popBtn').click(function(){     
        var store = $('#popSear').val();     
        if(store ==""){     
            alert("请输入商家名称");     
            $('#popSear').focus();     
        }else{     
            window.location.href = "<?php echo "{$root}m/mList.php?TypeOne={$_GET['TypeOne']}&store=";?>"+store;     
        }     
    });  
</script>        
</body>           
</html>