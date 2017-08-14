<?php   
include "FoFunction.php";           
echo head("pc");   
ThisHeader();  
echo insertBackUrl();
?>   
<style>
	.yellowFive {
		background: #fff url('<?php echo img(Iia26348328Vf);?>') no-repeat scroll;
	}
</style>
<div id="coupons">   
    <div class="center-top">   
        <div class="crumb">   
            当前位置：   
            <a href="<?php ro();?>">首页</a><span>&gt;</span><h3>现金券</h3>   
        </div>   
        <div class="coupsClass">   
            <ul class="clear">   
                <li class="cur"><a href="<?php echo $root?>forum/coupons.php">全部</a></li>   
                <?php   
                    $query =mysql_query("select * from TypeOne order by list");   
                    $i=1;   
                    while($result = mysql_fetch_array($query)){  
                        echo "<li><a href='{$root}forum/coupons.php?type={$result['id']}&n={$i}' >{$result['name']}</a></li>";   
                        $i++;   
                    }   
                ?>   
            </ul>   
        </div>   
    </div>   
    <?php   
      if($_GET['type'] ==""){  
         echo coupsCatoName();        
      }else{  
         echo showAllCoupon($_GET['type']);   
      }  
      
    ?>   
</div>   
<div class="toTop" title="返回顶部">返回顶部</div>   
<script>   
    $(function(){   
        if($('.coupsClass li:eq(<?php echo $_GET['n'];?>)').html() != null){   
            $('.clear li:eq(0)').removeClass();   
            $('.clear li:eq(<?php echo $_GET['n'];?>)').addClass("cur");   
            $(window).scroll(function () {   
                var scrollTop = $(window).scrollTop();   
                scrollTop > 100 ? $(".toTop").fadeIn(250) : $(".toTop").fadeOut(250);   

            });   
            $('.toTop').click(function(){   
                $('html,body').animate({ scrollTop:0},250);   
            });   
        }   
        else{   
            warn("请求有误!");   
            return false;   
        }   
    });   
</script>   

<?php   
echo warn();ThisFooter();   
?>   