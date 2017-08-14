<?php       
include "../library/function.php";                 
function CatoGoryForum($num){      
    $html  = "";      
    $sql = mysql_query("select * from type where forumnum = '$num'");      
    while($result = mysql_fetch_array($sql)) {      
        $html.="<li><a href='{$root}forum.php?forumType={$result[forumtype]}'>{$result[forumtype]}</a></li>";      
    }      
    return $html;      
}       
if(isset($_POST["couponType"]) and isset($_POST["cpSeid"])){       
    $query = query("coupon"," cptype = '$_POST[couponType]' and coupontargetid = '$_POST[cpSeid]' ");       
    $arrdata = array("couponcount" =>$query["couponcount"],"coupontotal" =>$query["coupontotal"],"coupontime" =>$query["activetime"]);       
    echo json_encode($arrdata);       
}       

//商家类型        
function coupsCatoName(){       
    $html = "";       
    $query = mysql_query("select * from TypeOne order by list ");       
    while($result = mysql_fetch_array($query)){       
        $html.="<div class='coupsCatoName'><a class='more' href='{$root}coupons.php?type={$result['id']}'>更多&gt;&gt;</a>{$result['name']}</div>".coupsCatoShows($result['id']);       
    }       
    return  $html;       
}       
//根据类型查询商家现金券信息        
function coupsCatoShows($TypeOneId){       
    $html = "<div class='coupsCatoShows'><ul class='clear'>";       
    $query = mysql_query("select * from couponsetype where TypeOneId = '$TypeOneId' limit 0,5");       
    if(mysql_num_rows($query) > 0){       
        while($result = mysql_fetch_array($query)){       
            $se_query = query("seller"," seid = '$result[couponseid]' ");       
            //查询商家共获得的评论数        
            $num = mysql_num_rows(mysql_query("select * from secomment where commenttargetid = '$result[couponseid]' and status = '已通过' "));       
            //查询统计商家获得的评分的平均分        
            $avgscore = mysql_fetch_array(mysql_query("select avg(score) from secomment where commenttargetid = '$result[couponseid]' and status = '已通过' "));       
            $coupon_result = mysql_fetch_array(mysql_query("select * from coupon where coupontargetid = '$result[couponseid]' order by couponprice desc"));       
            $html.= getHtml($se_query,$coupon_result,$num,$avgscore);       
        }       
    }else{   
        $html .= "找不到相关信息";       
    }   
    $html .= "</ul></div>";       
    return $html;       
}       

//根据类型显示全部现金券        
function showAllCoupon($setypeid){       
    $html = "<div class='coupsShows'><ul class='clear'>";       
    $query = mysql_query("select * from couponsetype where TypeOneId = '$setypeid'");       
    if(mysql_num_rows($query) == 0){       
        $html.="<li>找不到相关信息</li></ul></div>";       
        echo $html;       
        return;       
    }       
    while($result = mysql_fetch_array($query)){       
        $se_query = query("seller"," seid = '$result[couponseid]' ");       
        //查询商家共获得的评论数        
        $num = mysql_num_rows(mysql_query("select * from secomment where commenttargetid = '$result[couponseid]' and status = '已通过' "));       
        //查询统计商家获得的评分的平均分        
        $avgscore = mysql_fetch_array(mysql_query("select avg(score) from secomment where commenttargetid = '$result[couponseid]' and status = '已通过' "));       
        //根据商家id查询商家的现金券信息        
        $coupon_result = mysql_fetch_array(mysql_query("select * from coupon where coupontargetid = '$result[couponseid]' order by couponprice desc"));       
        $html.=getHtml($se_query,$coupon_result,$num,$avgscore);       
    }       
    $html.= "</ul></div>";       
    echo $html;       
}       

function getHtml($se_query,$coupon_result,$num,$avgscore){       
    $fenshu=$coupon_result['coupontotal']-$coupon_result['couponcount'];
	return "        
    <li>        
        <div class='top'>        
            <a class='couponName' href='{$GLOBALS[root]}store.php?seller={$se_query[seid]}' title='$se_query[name]'>$se_query[name]</a>        
            <div class='coupImg'>    
                    <img alt='$se_query[name]现金券' src='".ListImg($se_query["logo"],"seller/")."' width='110' height='110'>
            </div>        
            <div class='coupDtails'>        
                <ul class='st_score'>        
                    <li class='score'>        
                        <div class='dimStar'> 
                            <i class='greyFive'></i>  
                            <i class='yellowFive' style='width: ".($avgscore[0]*15)."px;'></i>  
                        </div>        
                        <b>".(substr($avgscore[0],0,3) == 0?0:substr($avgscore[0],0,3))."分</b>        
                    </li>        
                    <li><a href='' target='_blank'>共<span class='red'>{$num}</span>条点评</a></li>        
                </ul>        
            </div>        
        </div>        
        <div class='bottom'>        
                <p class='price'><em>￥</em><b>$coupon_result[couponprice]</b></p>        
                <div class='get'>        
                    <a href='{$GLOBALS['root']}forum/singleCoupon.php?seid=$se_query[seid]'>我要领取</a>        
                </div>        
                <p><span class='getCNumber'>{$coupon_result['couponcount']}</span>人领取</p>        
                <p>本期剩余".($fenshu<=0?"0":$fenshu)."份 </p>        
        </div>        
    </li>        
    ";       
}    

function suijiCoupon(){       
    $html = "";       
    $randnum = rand(0,12);       
    $query = mysql_query("select * from coupon where cptype = '现金券一' order by coupondate desc limit $randnum, 3");       
    while($result = mysql_fetch_array($query)){       
        $se_query = query("seller"," seid = '$result[coupontargetid]' ");       
        //查询商家共获得的评论数        
        $num = mysql_num_rows(mysql_query("select * from secomment where commenttargetid = '$se_query[seid]' and status = '已通过' "));       
        //查询统计商家获得的评分的平均分        
        $avgscore = mysql_fetch_array(mysql_query("select avg(score) from secomment where commenttargetid = '$result[coupontargetid]' and status = '已通过' "));       
        $html.=getHtml($se_query,$result,$num,$avgscore);       
    }       
    echo $html;       
}       


function showkhcomment($id){       
    $query = mysql_query("select * from secomment where commenttargetid = '{$id}' and status = '已通过' order by commentdate desc");       
    if(mysql_num_rows($query) > 0) {       
        $result = mysql_fetch_array($query);       
        echo showHtml($result);       
    }       
    else{       
        echo "暂无评论";       
    }       
}       

function KhSeComment($seid,$page){       
    $html = "";       
    $query = mysql_query("select * from secomment where commenttargetid = '$seid' and status = '已通过' order by commentdate desc limit " . (($page - 1) * 5) . ",5");       
    if(mysql_num_rows($query) > 0) {       
        while ($row_result = mysql_fetch_array($query)) {       
            $kehu = query("kehu"," khid = '$row_result[userid]' ");
			$html .= "<dl class='clear'>        
                        <dt class='shv-sin-l'>        
                            <a href='javascript:;'>        
                                <img src='" . ListImg($kehu['ico']) . "'>        
                            </a>        
                        </dt>        
                        <dd class='shv-sin-r'>        
                            <h3 class='shv-con-tit'><a href='' target='_blank'>" . khname("客户", $row_result['userid']) . "</a>        
                                <div class='shv-con-gets'>        
                                    <span class='dimStar'> 
                                        <i class='greyFive'></i>  
                                        <i class='yellowFive' style='width: ".($row_result['score']*15)."px;'></i> 
                                    </span>     
                                    <div class='shv-get-num'>        
                                        <b class='col-cri'>{$row_result['score']}</b>        
                                        <b class='col-g'>分</b>        
                                    </div>        
                                </div>        
                            </h3>        
                            <div class='shv-mark-content'>        
                                <dl class='shv-ad-mark clear'>        
                                    <dt class='advan'>优点</dt>        
                                    <dd>".SeparativeSign($row_result['advantage'])."</dd>        
                                </dl>        
                                <dl class='shv-bad-mark clear'>        
                                    <dt class='disadvan'>缺点</dt>        
                                    <dd>".SeparativeSign($row_result['shortcoming'])."</dd>        
                                </dl>        
                                <dl class='shv-all-mark clear'>        
                                    <dt class='asse'>总评</dt>        
                                    <dd>".SeparativeSign($row_result['generalcomment'])."</dd>        
                                </dl>        
                            </div>        
                            <div class='revDate'>        
                                评论日期：<span>{$row_result[commentdate]}</span>        
                            </div>        
                        </dd>        
                    </dl>";       
        }       
        echo $html;       
    }else{       
        echo "没有相关评论哦";       
    }       
}       

function KhSePage($seid,$page){       
    $num =mysql_num_rows(mysql_query("select * from secomment where commenttargetid = '{$seid}' and status = '已通过' order by commentdate desc"));       
    if($num == 0){       
        echo "<div id='page-query' class='sendB clear'><ul><li class='sendBt'><a href='review.php?seid={$seid}'>发点评论</a></li></ul></div>";       
        return ;       
    }       
    $res = mysql_fetch_array(mysql_query("select count(*) as total from secomment where commenttargetid = '$seid' and status = '已通过'"));       
    $totalpage = (int)$res['total'];       
    if ($totalpage == 0){       
        return ;       
    }       
    if ($totalpage % 5 == 0) {       
        $totalpage = (int)$totalpage / 5;       
    } else {       
        $totalpage = (int)($totalpage / 5) + 1;       
    }       
    $html = "";       
    $html .= "<div id='page-query' class='sendB clear'>        
                   <ul>        
                        <li class='sendBt'><a href='review.php?seid={$seid}'>发点评论</a></li>        
                        <li><a href='{$GLOBALS['root']}forum/reviewsC.php?seid={$seid}&pages=1'>首页</a></li>        
                        <li class='forword'><a href='{$GLOBALS['root']}forum/reviewsC.php?seid={$seid}&pages=" . (($page - 1) <= 0 ? 1 : ($page - 1)) . "'></a></li>        
                        <li class='current'>{$page}/{$totalpage}</li>" . KhSePagemes($totalpage,$seid) . "        
                        <li class='backword'><a href='{$GLOBALS['root']}forum/reviewsC.php?seid={$seid}&pages=" . (($page + 1) < $totalpage ? ($page + 1) : $totalpage) . "'>下一页</a></li>        
                        <li><a href='{$GLOBALS['root']}forum/reviewsC.php?seid={$seid}&pages={$totalpage}'>尾页</a></li>        
                   </ul>        
                  </div>        
                  ";       
    echo $html;       
}       

function KhSePagemes($totalpage,$seid){       
    $html = "";       
    for($i=1;$i<=$totalpage;$i++){       
        $html .= "<li><a href='{$GLOBALS['root']}forum/reviewsC.php?seid={$seid}&pages={$i}'>{$i}</a></li>";       
    }       
    return $html;       
}       

function insertComment($userid,$replttargetid,$comcomtent){       
    $suijiid = suiji();       
    $time=date("Y-m-d H:i:s");       
    $sql = "insert into reply (replyid,usertype,userid,replytarget,replytargetid,text,replydate,status) values('$suijiid','客户','$userid','评论','$replttargetid','$comcomtent','$time','未审核')";       
    $bool = mysql_query($sql);       
    if($bool){       
        echo "感谢您的评论，审核通过后显示您得评论!";       
        unset($_SESSION["forumid"]);       
    }else{       
        echo "评论失败!";       
    }       
}       
function insertForum($secatogory,$title,$content){       
    $usertype = "";       
    $targetid = "";       

    $suijiid = suiji();       
    $time=date("Y-m-d H:i:s");       

    if($_SESSION['HunzhongKhid'] == "" and $_SESSION['HunzhongSeid'] != ""){       
        $usertype = "商户";       
        $targetid = $_SESSION['HunzhongSeid'];       
    }       
    if($_SESSION['HunzhongKhid'] != "" and $_SESSION['HunzhongSeid'] == ""){       
        $usertype = "客户";       
        $targetid = $_SESSION['HunzhongKhid'];       
    }       

    $bool_forumposts = mysql_query("insert into forumposts (forumid,forumtarget,forumtargetid,forumtitle,cont,forumtype,status,gold,forumdate) values('$suijiid','$usertype','$targetid','$title','0','$secatogory','隐藏','否','$time')");       
    $bool_forumcontent = mysql_query("insert into article (id,TargetId,word,img,list) values ('".suiji()."','$suijiid','$content','',0)");       
    if($bool_forumcontent and $bool_forumposts){       
        echo "1";       
    }       
    else{       
        echo "0";       
    }       
}       


//每页显示10条数据        
function showForum($page,$forumType){       
    $html ="";       
    $tiezi_sql = "";        
    //如果帖子类型为空的时候说明用户浏览全部页面        
    if($forumType ==""){       
        $tiezi_sql = "select * from forumposts where status='显示'  order by forumdate desc limit ".(($page-1)*10).",10";       
    }else{       
        $tiezi_sql = "select * from forumposts where status='显示' and forumtype='$forumType' order by forumdate desc limit ".(($page-1)*10).",10";       
    }        
    $tiezi_query = mysql_query($tiezi_sql);       
    if(mysql_num_rows($tiezi_query) > 0){       
        while($result = mysql_fetch_array($tiezi_query)){      
            $ForumTargetName ="";      
            if($result['forumtarget'] =="商户"){      
                $target = query("seller"," seid = '$result[forumtargetid]'");       
                $ForumTargetName =$target["name"];      
            }else if($result['forumtarget'] == "客户"){       
                $target = query("kehu"," khid = '$result[forumtargetid]'");       
                $ForumTargetName =$target["khname"];       
            }      
            $html .="<ul class='ar clear'>        
                            <li class='topic clear'>        
                                <span class='addScore' style='display:".($result[gold] =="是"?"block":"none")."'></span>        
                                <a href='{$GLOBALS['root']}forum/reply.php?id={$result['forumid']}' title='{$result['forumtitle']}'>{$result['forumtitle']}        
                                </a>        
                            </li>        
                            <li class='author'>        
                                <a href='' class='artN'>{$ForumTargetName}</a>        
                                <span class='date'>".substr($result["forumdate"],5,11)."</span>        
                            </li>        
                            <li class='reAndLook'>        
                                <span class='re' title='帖子回复数'>".printTotalreply($result["forumid"])."</span>/        
                                <span class='l' title='帖子浏览数'>{$result["cont"]}</span>        
                            </li>        
                            <li class='lastRe'>".lastReply($result["forumid"])."        
                            </li>        
                     </ul>";        
        }       
    }       
    else{       
        echo "无相关信息";       
    }       
    echo $html;       
}      
function lastReply($targetid){       
    $re_sql =mysql_query("select replyid from reply where replytargetid = '$targetid' order by replydate desc");         
    if(mysql_num_rows($re_sql) == 0){       
        return "<span class='rm'>无</span>";       
    }else{      
        while($result = mysql_fetch_array($re_sql)){       
            $sql = mysql_query("select * from reply where replytargetid = '$result[replyid]' and status='已通过' order by replydate desc");       
            if(mysql_num_rows($sql) > 0){       
                while($replyResult = mysql_fetch_array($sql)){       
                    if ($replyResult["usertype"] == "客户") {       
                        $target = query("kehu", " khid = '$replyResult[userid]'");       
                        return "<a href=''  class='rm' title='{$target['khname']}'>{$target['khname']}</a><span class='day'>".substr($replyResult['replydate'],10)."</span>";       
                    }       
                    if ($replyResult["usertype"] == "商户") {       
                        $target = query("seller", " seid = '$replyResult[userid]' ");       
                        return "<a href=''  class='rm' title='{$target['name']}'>{$target['name']}</a><span class='day'>".substr($replyResult['replydate'],11)."</span>";       
                    }       
                }       
            }       
            else{       
                return "<span class='rm'>无</span>";       
            }       
        }       
    }      
}       

//获取一个对帖子评论回复的总数        
function printTotalreply($targetid){       
    $re = mysql_query("select * from reply where replytargetid = '$targetid' and status='已通过' order by replydate desc");       
    //用于统计一个评论的所有回复数        
    $count = 0;       
    while($arrResult = mysql_fetch_array($re)){       
        $count += mysql_num_rows(mysql_query("select * from reply where replytargetid = '$arrResult[replyid]' and status='已通过' order by replydate desc"));       
    }       
    return $count;       
}        
//获取客户姓名        
function khname($target,$targetid){       
    if($target == "客户"){       
        $query = query("kehu","khid='$targetid'");       
        if(empty($query["nickname"])){
			if(empty($query["khname"])){
				return $query["khid"];
			}else{
				return $query["khname"];
			}
		}else{
			return $query["nickname"];
		}
    }       
    if($target == "商户"){       
        $query = query("seller","seid='$targetid'");       
        return $query["Brand"];       
    }       
}       
//根据用户类型返回信息        
function khdata($target,$targetid){       
    if($target == "客户"){       
        $query = query("kehu","khid='$targetid'");       
        return $query;       
    }       
    if($target == "商户"){       
        $query = query("seller","seid='$targetid'");       
        return $query;       
    }       
}       


//打印评论        
function comment($forumid){       
    $sql = "select * from reply where replytargetid = '$forumid' and status = '已通过' order by replydate desc";       
    $query = mysql_query($sql);       
    $html = "";       
    if(mysql_num_rows($query) > 0){       
        while($result = mysql_fetch_array($query)){       
            $kh_query = khdata($result['usertype'],$result['userid']);       
            $kh_name = $kh_query['khname']==""?$kh_query['name']:$kh_query['khname'];       
            $kh_integrate = $kh_query['khintegrate']==0 ? 0: $kh_query['khintegrate'];       
            //获取头像        
            $html.="        
                 <div class='post-mark clear'>        
                    <div class='post-mark-l'>        
                        <ul>        
                            <li><img src='". ListImg($kh_query['ico'],"user/")."' alt='pic' width='80' height='80'/></li>        
                            <li class='nAndR'><a href='' class='khname' title='{$kh_name}'>{$kh_name}</a></li>        
                            <li class='gets'>普通积分：<a href='' class='num'>{$kh_integrate}</a></li>        
                        </ul>        
                    </div>        
                    <div class='post-mark-r'>        
                        <div class='post-mark-tit'>评论于&nbsp;{$result['replydate']}</div>        
                        <div class='post-mark-con'>{$result['text']}<div class='reply' style='float: right;cursor:pointer;font-size:12px;padding-top:2px;' title='回复'>回复<input type='hidden' class='commentid' value='{$result['replyid']}' /></div></div>        
                        <div class='qutton_reply'><textarea name='reply' class='reply-area' id='replyInput' placeholder='我的回复...'></textarea><input type='button' class='reply-btn' value='发表'/></div>        
                        <ul class='post-mark-re' unfold='no'>        
                        ".printReply($result['replyid'])."        
                        </ul>        
          
                    </div>        
                </div>        
            ";       
        }       
    }       
    echo $html;       
}       

if(!empty($_POST["keywords"]) and !empty($_POST["page"])) {       
    $keywords = $_POST["keywords"];       
    $page = $_POST["page"];       
    unset($_SESSION["keywords"]);       
    searchSecomment($keywords, $page);       
}       

function searchSecomment($keywords,$page){       
    $_SESSION["keywords"] = $keywords;       
    $html = "";       
    $sql = mysql_query("select * from secomment,seller where seller.name = '{$keywords}' and secomment.commenttargetid = seller.seid and secomment.status = '已通过' limit " . (($page - 1) * 5) . ",5");       
    if(mysql_num_rows($sql) > 0){       
        while($row_result = mysql_fetch_array($sql)){       
            $myrows = mysql_fetch_array(mysql_query("select ico from kehu where khid = '{$row_result[userid]}'"));       
            $html.=showHtml($row_result,$myrows);       
        }       
        $arrData = array("secomment" => $html,"query" => searchQuery($keywords,$page));       
        echo json_encode($arrData);       
    }       
    else{       
        $arrData = array("secomment" => "<div class='shv-sin-mark'>没有找到相关信息!</div>");       
        echo json_encode($arrData);       
    }       
}       
function searchQuery($keywords,$page){       
    $res = mysql_fetch_array(mysql_query("select count(*) as total from secomment,seller where seller.name = '{$keywords}' and seller.seid = secomment.commenttargetid and status = '已通过'"));       
    $totalpage = (int)$res['total'];       
    if ($totalpage == 0){       
        return ;       
    }       
    if ($totalpage % 5 == 0) {       
        $totalpage = (int)$totalpage / 5;       
    } else {       
        $totalpage = (int)($totalpage / 5) + 1;       
    }       
    $html = "";       
    $html .= "<div id='page-query' class='sendB clear'>       
                   <ul>       
                        <li><a href='javascript:;' onclick='secomment(1,1);'>首页</a></li>       
                        <li class='forword'><a href='javascript:;'  onclick='secomment(1," . (($page - 1) <= 0 ? 1 : ($page - 1)) . ");'></a></li><!--secomment(1,page) 1代表传入一个参数给前端判断 -->       
                        <li class='current'>{$page}/{$totalpage}</li>" . commentPage($totalpage) . "       
                        <li class='backword'><a href='javascript:;' onclick='secomment(1," . (($page + 1) < $totalpage ? ($page + 1) : $totalpage) . ");'>下一页</a></li>       
                        <li><a href='javascript:;' onclick='secomment(1,{$totalpage});'>尾页</a></li>       
                   </ul>       
                  </div>       
                  ";       
    return $html;       
}       
function commentPage($totalpage){       
    $html = "";       
    for($i=1;$i<=$totalpage;$i++){       
        $html .= "<li><a href='javascript:;' onclick='secomment(1,{$i});'>{$i}</a></li>";       
    }       
    return $html;       
}       



//显示商户评论列表       
function showSecomment($page,$TypeId){       
    $html = "";       
    if($TypeId == "") {       
        $query_sql = mysql_query("select * from secomment where status = '已通过' order by commentdate desc limit " . (($page - 1) * 5) . ",5");       
        while ($row_result = mysql_fetch_array($query_sql)) {       
            $myrows = mysql_fetch_array(mysql_query("select ico from kehu where khid = '{$row_result[userid]}'"));       
            $html .= showHtml($row_result,$myrows);       
        }       
        echo $html;       
    }       
    else{       
        $query_sql = mysql_query("select * from secomment,seller where seller.TypeOneId = '{$TypeId}' and seller.seid = secomment.commenttargetid and status = '已通过' order by commentdate desc limit " . (($page - 1) * 5) . ",5");       
        if(mysql_num_rows($query_sql) == 0){       
            echo "<div class='shv-sin-mark'>没有相关信息!</div>";       
            return ;       
        }       
        while ($row_result = mysql_fetch_array($query_sql)) {       
            $myrows = mysql_fetch_array(mysql_query("select ico from kehu where khid = '{$row_result[userid]}'"));       
            $html .= showHtml($row_result,$myrows);       
        }       
        echo $html;       
    }       
}       
function getImgurl($commentid){       
    $html = "";       
    $query = mysql_query("select * from seCommentImg where secommentId = '{$commentid}'");       
    if(mysql_num_rows($query) > 0) {       
        $html.="<div class='shv-sin-pic' shvmarknowl='0' >       
                  <div class='shv-sin-pic' shvMarkNowL='0'>       
                   <span ThisArrow='Left' class='shv-forword-arrow'></span>       
                        <div class='shv-img-warp'>       
                            <ul class='shv-scollImg'>";       
        while ($result = mysql_fetch_array($query)) {       
            $html .= "       
               <li>       
                <a href='{$GLOBALS['root']}{$result['src']}' target='_blank' class='_jdp_pic'>       
                  <img src='{$GLOBALS['root']}{$result['src']}' width='80' height='80'/> 
                </a>       
               </li>       
                ";       
        } 
        $html.="</ul>       
                </div>       
                <span ThisArrow='Right' class='shv-next-arrow'></span></div></div>";       
        return $html;       
    }       
    else{       
        return $html;       
    }       
}       
/******************************/       
function secommentQuery($page,$type){       
    if($type == "") {       
        $res = mysql_fetch_array(mysql_query("select count(*) as total from secomment where status = '已通过'"));       
        $totalpage = (int)$res['total'];       
        if ($totalpage == 0){       
            return ;       
        }       
        if ($totalpage % 5 == 0) {       
            $totalpage = (int)$totalpage / 5;       
        } else {       
            $totalpage = (int)($totalpage / 5) + 1;       
        }       
        $html = "";       
        $html .= "<div id='page-query' class='sendB clear'>       
                   <ul>       
                        <li><a href='{$GLOBALS['root']}forum/showReview.php?page=1'>首页</a></li>       
                        <li class='forword'><a href='{$GLOBALS['root']}forum/showReview.php?page=" . (($page - 1) <= 0 ? 1 : ($page - 1)) . "'></a></li>       
                        <li class='current'>{$page}/{$totalpage}</li>" . secommentPage($totalpage,$type) . "       
                        <li class='backword'><a href='{$GLOBALS['root']}forum/showReview.php?page=" . (($page + 1) < $totalpage ? ($page + 1) : $totalpage) . "'>下一页</a></li>       
                        <li><a href='{$GLOBALS['root']}forum/showReview.php?page={$totalpage}'>尾页</a></li>       
                   </ul>       
                  </div>       
                  ";       
        echo $html;       
    }       
    else{       
        $res = mysql_fetch_array(mysql_query("select count(*) as total from secomment,seller where seller.setype = '{$type}' and seller.seid = secomment.commenttargetid and status = '已通过'"));       
        $totalpage = (int)$res['total'];       
        if ($totalpage == 0){       
            return ;       
        }       
        if ($totalpage % 5 == 0) {       
            $totalpage = (int)$totalpage / 5;       
        } else {       
            $totalpage = (int)($totalpage / 5) + 1;       
        }       
        $html = "";       
        $html .= "<div id='page-query' class='sendB clear'><ul>";       
        if($totalpage != 0) {       
               $html.="<li><a href='{$GLOBALS['root']}forum/showReview.php?type={$type}&page=1'>首页</a></li>       
                <li class='forword'><a href='{$GLOBALS['root']}forum/showReview.php?type={$type}&page=" . (($page - 1) <= 0 ? 1 : ($page - 1)) . "'></a></li>       
                <li class='current'>{$page}/{$totalpage}</li>" . secommentPage($totalpage, $type) . "       
                <li class='backword'><a href='{$GLOBALS['root']}forum/showReview.php?type={$type}&page=" . (($page + 1) < $totalpage ? ($page + 1) : $totalpage) . "'>下一页</a></li>       
                <li><a href='{$GLOBALS['root']}forum/showReview.php?type={$type}&page={$totalpage}'>尾页</a></li>";       
        }       
        $html.= "</ul></div>";       
        echo $html;       
    }       
}       
function secommentPage($totalpage,$type){       
    $html = "";       
    for($i=1;$i<=$totalpage;$i++){       
        $html .= "<li><a href='{$GLOBALS['root']}forum/showReview.php?type={$type}&page={$i}'>{$i}</a></li>";       
    }       
    return $html;       
}       


function showHotForum(){       
    $html = "";       
    $query = mysql_query("select * from forumposts where status = '已发布' order by forumdate desc limit 0,20");       
    while($result = mysql_fetch_array($query)){       
        $html.="<li><a href='{$GLOBALS['root']}bbs.php?id={$result['forumid']}&type=all' target='_blank'>{$result['forumtitle']}</a></li>";       
    }       
    echo $html;       
}       

//返回html代码片段       
function showHtml($row_result,$myrows){       
    return  "<div class='shv-sin-mark'>       
                <dl class='clear'>       
                    <dt class='shv-sin-l'>       
                        <a href='javascript:;'>       
                            <img src='".ListImg($myrows["ico"],"user/")."'>       
                        </a>       
                    <h4><a href='javascript:;' class='shv-user' title='".khname("客户",$row_result['userid'])."'>".khname("客户",$row_result['userid'])."</a></h4>       
                    <p>".substr($row_result['commentdate'],0,10)."</p>       
                    </dt>       
                    <dd class='shv-sin-r'>       
                        <h3 class='shv-con-tit'><a href='{$GLOBALS['root']}store.php?seller={$row_result[commenttargetid]}' target='_blank'>".khname("商户",$row_result['commenttargetid'])."</a>       
                            <div class='shv-con-gets'>       
                                <span class='dimStar'> 
                                    <i class='greyFive'></i>  
                                    <i class='yellowFive' style='width: ".($row_result['score']*15)."px;'></i>  
                                </span>      
                                <div class='shv-get-num' style='position: relative;top:-4px;'>       
                                    <b class='col-cri'>{$row_result['score']}</b>       
                                    <b class='col-g'>分</b>       
                                </div>       
                            </div>       
                        </h3>       
                        <div class='shv-mark-content'>       
                            <dl class='shv-ad-mark clear'>       
                                <dt class='advan'>优点</dt>       
                                <dd>".SeparativeSign($row_result['advantage'])."</dd>       
                            </dl>       
                            <dl class='shv-bad-mark clear'>       
                                <dt class='disadvan'>缺点</dt>       
                                <dd>".SeparativeSign($row_result['shortcoming'])."</dd>       
                            </dl>       
                            <dl class='shv-all-mark clear'>       
                                <dt class='asse'>总评</dt>       
                                <dd>".SeparativeSign($row_result['generalcomment'])."</dd>       
                            </dl>       
                        </div>  
                        ".getImgurl($row_result['secommentid'])."      
                    </dd>        
                </dl>      
            </div> 
            ";       
}       
/*-------------客户浏览量函数---------------------------------------------------------------------------*/       
function PageView(){       
    if($_SESSION['PageView'] != "yes"){       
        $seller = query("seller"," seid = '$_GET[seller]' ");       
        $PageView = $seller['PageView'] + 1;       
        mysql_query(" update seller set PageView = '$PageView' where seid = '$Seller[seid]' ");       
        $_SESSION['PageView'] = "yes";       
    }       
}       


?>  