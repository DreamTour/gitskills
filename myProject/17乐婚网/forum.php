<?php                 
include "../library/function.php";                 
echo head("pc");         
ThisHeader();         
echo insertBackUrl();            
?>                
<div id="bbsWrap" class="clear">              
    <?php bbsLBan();?>             
    <div class="rightBanner">              
        <span class="border"></span>          
      <h3>          
        <?php           
        if(isset($_GET['TypeTwo'])){          
            $query =query("ForumTypeTwo"," id ='$_GET[TypeTwo]' ");          
            echo $query['name'];          
        }else{          
            echo "全部";          
        }          
        ?>          
        </h3>              
        <a class="sendPpipe" href="<?php echo $root;?>forum/addtopic.php" style="color:#fff;float:right;">              
            发帖              
        </a>            
        <?php              
            if($_GET['page'] ==""){             
               $page =1;             
            }else{             
               $page =(int)$_GET['page'];             
            }             
            if(isset($_GET['TypeTwo'])){                   
                        $TypeForum_query =mysql_query("select * from forumposts where forumtype in ( select id from ForumTypeThree where ForumTypeTwoId ='$_GET[TypeTwo]' ) and status ='已发布' order by PageTop = '是' desc,UpdateTime desc limit  ".(10*($page-1)).",10");             
                        if(mysql_num_rows($TypeForum_query) >0){             
                            while($TypeForum_result =mysql_fetch_array($TypeForum_query)){             
                                $TypeThreeResult =query("ForumTypeThree"," id ='$TypeForum_result[forumtype]' ");             
                                $Article_result =query("article"," TargetId ='$TypeForum_result[forumid]' ");             
                                $kehu_result =query("kehu"," khid ='$TypeForum_result[forumtargetid]' ");     
                                $Comment_result = query("reply"," replytargetid = '$TypeForum_result[forumid]' and replytarget = '评论' and status ='已通过' order by replydate desc");             
                                $Result_result = query("reply"," replytargetid = '$Comment_result[replyid]' and replytarget = '回复' and status ='已通过' order by replydate desc");     
                                $CommentNum = mysql_num_rows(mysql_query("select * from reply where replytargetid = '$TypeForum_result[forumid]' and replytarget = '评论' and status ='已通过'"));     
                                $ReplyNum = mysql_num_rows(mysql_query("select * from reply where replytargetid = '$Comment_result[replyid]' and replytarget = '回复'  and status ='已通过'"));     
                                $TotalNum =$CommentNum+$ReplyNum;     
                                echo "             
                                 <div class='sinPost'>              
                                   <div class='postHead'>              
                                        <h4 class='sinPClass'>           
                                            【{$TypeThreeResult['name']}】           
                                            ·           
                                            <a href='{$root}bbs.php?id={$TypeForum_result['forumid']}&TypeTwoId={$_GET[TypeTwo]}'>{$TypeForum_result['forumtitle']}</a>";    
                                            if($TypeForum_result['gold'] == "是"){    
                                                echo "<span class='jinghua topIcon'></span> ";    
                                            }    
                                            if($TypeForum_result['PageTop'] == "是"){    
                                                echo "<span class='zhiding topIcon'></span> ";    
                                            }    
                                 echo  "</h4>              
                                        <div class='postMsg'>              
                                            <span>作者：".Authod($kehu_result)."</span>              
                                            <span>浏览/回复：{$TypeForum_result['cont']}/{$TotalNum}</span>              
                                            <span style='float:right;'>发布时间：{$TypeForum_result['forumdate']}</span>      
                                            ".PrintReply($Comment_result,$Result_result,$TypeForum_result['forumid'],"TypeTwoId={$_GET[TypeTwo]}")."           
                                        </div>              
                                    </div>              
                                    <div class='postBot clear'>              
                                        <p class='postSummary'>             
                                            {$Article_result['word']}          
                                        </p>";         
                                        $ArticleImgSql =mysql_query("select * from article where TargetId ='$TypeForum_result[forumid]' and img !='' limit 0,8");        
                                        while($ArticleImg =mysql_fetch_array($ArticleImgSql)){        
                                            echo "<a href='javascript:;' class='postImgTit'>             
                                                        <img alt='{$kehu_result['khname']}' src='{$root}$ArticleImg[img]' width='30' height='30'>               
                                                  </a>";        
                                        }           
                                 echo"   </div>              
                                    </div>              
                                 ";             
                            }          
                            $FingerForum =2;                                 
                }             
                if($FingerForum !=2){         
                    echo "<div class='sinPost'>没有相关帖子</div>";         
                }         
            }else{             
                $AllForum_query =mysql_query("select * from forumposts where status ='已发布' order by PageTop desc,UpdateTime desc limit ".(10*($page-1)).",10");             
                if(mysql_num_rows($AllForum_query) > 0){            
                    while($AllForum_result =mysql_fetch_array($AllForum_query)){             
                        $TypeThree_result =query("ForumTypeThree"," id ='$AllForum_result[forumtype]' ");             
                        $Article_result =query("article"," TargetId ='$AllForum_result[forumid]' ");             
                        $kehu_result =query("kehu"," khid ='$AllForum_result[forumtargetid]' ");       
                        $Comment_result = query("reply"," replytargetid = '$AllForum_result[forumid]' and replytarget = '评论' and status ='已通过' order by replydate desc");             
                        $Result_result = query("reply"," replytargetid = '$Comment_result[replyid]' and replytarget = '回复' and status ='已通过' order by replydate desc");     
                        $CommentNum = mysql_num_rows(mysql_query("select * from reply where replytargetid = '$AllForum_result[forumid]' and replytarget = '评论' and status ='已通过'"));     
                             
                        $ReplyNum = mysql_num_rows(mysql_query("select * from reply where replytargetid = '$Comment_result[replyid]' and replytarget = '回复' and status ='已通过'"));     
                        $TotalNum =$CommentNum+$ReplyNum;          
                        echo "             
                         <div class='sinPost'>              
                           <div class='postHead'>              
                                <h4 class='sinPClass'>         
                                【{$TypeThree_result['name']}】         
                                .         
                                <a href='{$root}bbs.php?id={$AllForum_result['forumid']}&type=all'>{$AllForum_result['forumtitle']}</a>";     
                                if($AllForum_result['gold'] == "是"){    
                                    echo "<span class='jinghua topIcon'></span> ";    
                                }         
                                if($AllForum_result['PageTop'] == "是"){    
                                    echo "<span class='zhiding topIcon'></span> ";    
                                }    
                        echo  "</h4>              
                                <div class='postMsg'>              
                                    <span>作者：".Authod($kehu_result)."</span>              
                                    <span>浏览/回复：{$AllForum_result['cont']}/{$TotalNum}</span>              
                                    <span style='float:right;'>发布时间：{$AllForum_result['forumdate']}</span>     
                                    ".PrintReply($Comment_result,$Result_result,$AllForum_result['forumid'],"type=all")."             
                                </div>              
                            </div>              
                            <div class='postBot clear'>              
                                <p class='postSummary'>             
                                    {$Article_result['word']}           
                                </p>";        
                                $ArticleImgSql =mysql_query("select * from article where TargetId ='$AllForum_result[forumid]' and img !='' limit 0,8");        
                                while($ArticleImg =mysql_fetch_array($ArticleImgSql)){        
                                    echo "<a href='javascript:;' class='postImgTit'>             
                                                <img alt='{$kehu_result['khname']}' src='{$root}$ArticleImg[img]' width='30' height='30'>               
                                          </a>";        
                                }          
                         echo "</div>              
                            </div>              
                         ";             
                   }         
                   $FingerForum =2;           
                }        
                if($FingerForum !=2){         
                    echo "<div class='sinPost'>没有相关帖子</div>";         
                }         
            }        
                  
            function Authod($kehu_result){      
                if($kehu_result['nickname'] ==""){      
                    return $kehu_result['khname'];      
                }else{      
                    return $kehu_result['nickname'];      
                }      
            }      
                 
            function PrintReply($Comment_result,$Result_result,$id,$type){     
                if($Result_result['replydate'] == "" and $Comment_result['replydate'] == "" ){     
                    return "<span><a style='color:#c82631;border:1px solid #ededed;padding:2px 5px;' href=\"{$GLOBALS['root']}bbs.php?id={$id}&{$type}#ping\">抢沙发</a></span>";     
                }else if($Result_result['replydate'] == "" and $Comment_result['replydate'] != "" ){     
                    $KehuResult = query("kehu"," khid = '$Comment_result[userid]' ");     
                    return "<span>最后回复：".Authod($KehuResult)."</span><span style='float:right;'>回复时间：{$Comment_result[replydate]}</span>";     
                }     
                else{     
                    $ReplyKehu_result =query("kehu"," khid = '$Result_result[userid]' ");     
                    return "<span>最后回复：".Authod($ReplyKehu_result)."</span><span style='float:right;'>回复时间：{$Result_result[replydate]}</span>";     
                }     
            }     
        ?>         
        <a class="sendPpipe" href="<?php echo "{$root}forum/addtopic.php";?>" style="color:#fff;">              
            发帖              
        </a>              
        <div class='all_pages'>              
        <?php              
           if($_GET['page'] ==""){             
               $Currentpage =1;             
           }else{             
               $Currentpage =$_GET['page'];             
           }             
           if(isset($_GET['TypeTwo'])){             
               $TotalPage =0;             
               $TypeThree_query =mysql_query("select * from ForumTypeThree where ForumTypeTwoId ='$_GET[TypeTwo]' ");             
               while($TypeThree_result =mysql_fetch_array($TypeThree_query)){             
                     $TypeForum_query =mysql_query("select * from forumposts where forumtype ='$TypeThree_result[id]' and status ='已发布' order by UpdateTime desc ");                              
                     $TotalPage +=mysql_num_rows($TypeForum_query);             
               }             
               if ($TotalPage != 0){               
                     if ($TotalPage % 10 == 0){               
                        $TotalPage = (int)$TotalPage / 10;               
                     }else {               
                        $TotalPage = (int)($TotalPage / 10) + 1;               
                     } 
					 echo "<span>共<ins style='color:rgb(238,70,70);'>{$TotalPage}</ins>页</span>";
                     //根据二级分类查询帖子时候的页数大于10页的时候 
                     if($TotalPage > 10){ 
                         echo "<a href='{$root}forum/forum.php?TypeTwo=$_GET[TypeTwo]&page=1' class='list_page'>首页</a>";             
                         echo "<a href='{$root}forum/forum.php?TypeTwo=$_GET[TypeTwo]&page=".(($Currentpage - 1) <= 0 ? 1 : ($Currentpage - 1)) . "' class='list_page'>上一页</a>"; 
						 if($Currentpage ==1){
							echo "<a href='{$root}forum/forum.php?TypeTwo=$_GET[TypeTwo]&page=".(($Currentpage) <= 0 ? 1 : ($Currentpage)) . "' class='list_page'>{$Currentpage}</a>";        echo "<a href='javascript:;'>$nbsp...$nbsp</a>";
						 }else if($Currentpage == $TotalPage){
							echo "<a href='javascript:;'>&nbsp;...&nbsp;</a>";
							echo "<a href='{$root}forum/forum.php?TypeTwo=$_GET[TypeTwo]&page=".(($Currentpage) <= 0 ? 1 : ($Currentpage)) . "' class='list_page'>{$Currentpage}</a>";
						 }else{
							echo "<a href='javascript:;'>&nbsp;...&nbsp;</a>";
							echo "<a href='{$root}forum/forum.php?TypeTwo=$_GET[TypeTwo]&page=".(($Currentpage) <= 0 ? 1 : ($Currentpage)) . "' class='list_page'>{$Currentpage}</a>";
							echo "<a href='javascript:;'>&nbsp;...&nbsp;</a>";
						 }
                         
                         echo "<a href='{$root}forum/forum.php?TypeTwo=$_GET[TypeTwo]&page=".(($Currentpage + 1) < $TotalPage ? ($Currentpage + 1) : $TotalPage) . "' class='list_page'>下一页</a>";             
                         echo "<a href='{$root}forum/forum.php?TypeTwo=$_GET[TypeTwo]&page={$TotalPage}' class='list_page'>尾页</a>";
						 echo "&nbsp;跳转";
						 echo "&nbsp;<select id='tiaozhuan'>";
						 for($i =1;$i<=$TotalPage;$i++){             
                             if($Currentpage ==$i){             
                                 echo "<option value='{$root}forum/forum.php?TypeTwo=$_GET[TypeTwo]&page={$i}' selected='selected'>第{$i}页</option>";             
                             }else{             
                                 echo "<option value='{$root}forum/forum.php?TypeTwo=$_GET[TypeTwo]&page={$i}'>第{$i}页</option> ";             
                             }             
                         } 
						 echo "</select>"; 
                     }else{//根据二级分类查询帖子时候的页数小于10页的时候全部页数显示出来 
                         echo "<a href='{$root}forum/forum.php?TypeTwo=$_GET[TypeTwo]&page=1' class='list_page'>首页</a>";             
                         echo "<a href='{$root}forum/forum.php?TypeTwo=$_GET[TypeTwo]&page=".(($Currentpage - 1) <= 0 ? 1 : ($Currentpage - 1)) . "' class='list_page'>上一页</a>";             
                         for($i =1;$i<=$TotalPage;$i++){             
                             if($Currentpage ==$i){             
                                 echo "<a href='{$root}forum/forum.php?TypeTwo=$_GET[TypeTwo]&page={$i}' class='list_page cur'>{$i}</a> ";             
                             }else{             
                                 echo "<a href='{$root}forum/forum.php?TypeTwo=$_GET[TypeTwo]&page={$i}' class='list_page'>{$i}</a> ";             
                             }             
                         }             
                         echo "<a href='{$root}forum/forum.php?TypeTwo=$_GET[TypeTwo]&page=".(($Currentpage + 1) < $TotalPage ? ($Currentpage + 1) : $TotalPage) . "' class='list_page'>下一页</a>";             
                         echo "<a href='{$root}forum/forum.php?TypeTwo=$_GET[TypeTwo]&page={$TotalPage}' class='list_page'>尾页</a>";  
                     } 
                                 
               }              
           }else{             
               $TotalPage =mysql_num_rows(mysql_query("select * from forumposts where status ='已发布' and forumtype !='' order by UpdateTime desc "));             
               if ($TotalPage != 0){               
                     if ($TotalPage % 10 == 0){               
                        $TotalPage = (int)$TotalPage / 10;               
                     }else {               
                        $TotalPage = (int)($TotalPage / 10) + 1;               
                     }
					 echo "<span>共<ins style='color:rgb(238,70,70);'>{$TotalPage}</ins>页</span>";    
                     if($TotalPage > 10){ 
                         echo "<a href='{$root}forum/forum.php?page=1' class='list_page'>首页</a>";             
                         echo "<a href='{$root}forum/forum.php?page=".(($Currentpage - 1) <= 0 ? 1 : ($Currentpage - 1)) . "' class='list_page'>上一页</a>"; 
						 if($Currentpage ==1){
							echo "<a href='{$root}forum/forum.php?page=".(($Currentpage) <= 0 ? 1 : ($Currentpage)) . "' class='list_page'>{$Currentpage}</a>"; 
							echo "<a href='javascript:;'>&nbsp;...&nbsp;</a>";
						 }else if($Currentpage == $TotalPage){
							echo "<a href='javascript:;'>&nbsp;...&nbsp;</a>";
							echo "<a href='{$root}forum/forum.php?page=".(($Currentpage) <= 0 ? 1 : ($Currentpage)) . "' class='list_page'>{$Currentpage}</a>"; 
						 }else{
							echo "<a href='javascript:;'>&nbsp;...&nbsp;</a>";
							echo "<a href='{$root}forum/forum.php?page=".(($Currentpage) <= 0 ? 1 : ($Currentpage)) . "' class='list_page'>{$Currentpage}</a>"; 
							echo "<a href='javascript:;'>&nbsp;...&nbsp;</a>";
						 }
                          
                         echo "<a href='{$root}forum/forum.php?page=".(($Currentpage + 1) < $TotalPage ? ($Currentpage + 1) : $TotalPage) . "' class='list_page'>下一页</a>"; 
                         echo "<a href='{$root}forum/forum.php?page={$TotalPage}' class='list_page'>尾页</a>";
						 echo "&nbsp;跳转";
						 echo "&nbsp;<select id='tiaozhuan'>";
						 for($i =1;$i<=$TotalPage;$i++){             
                             if($Currentpage ==$i){             
                                 echo "<option value='{$root}forum/forum.php?page={$i}' selected='selected'>第{$i}页</option>";             
                             }else{             
                                 echo "<option value='{$root}forum/forum.php?page={$i}'>第{$i}页</option> ";             
                             }             
                         } 
						 echo "</select>";
						  
                     }else{//显示全部帖子的时候页数小于10页的时候全部显示出来 
                         echo "<a href='{$root}forum/forum.php?page=1' class='list_page'>首页</a>";             
                         echo "<a href='{$root}forum/forum.php?page=".(($Currentpage - 1) <= 0 ? 1 : ($Currentpage - 1)) . "' class='list_page'>上一页</a>";             
                         for($i =1;$i<=$TotalPage;$i++){             
                             if($Currentpage ==$i){             
                                 echo "<a href='{$root}forum/forum.php?page={$i}' class='list_page cur'>{$i}</a> ";             
                             }else{             
                                 echo "<a href='{$root}forum/forum.php?page={$i}' class='list_page'>{$i}</a> ";             
                             }             
                         }             
                         echo "<a href='{$root}forum/forum.php?page=".(($Currentpage + 1) < $TotalPage ? ($Currentpage + 1) : $TotalPage) . "' class='list_page'>下一页</a>";             
                         echo "<a href='{$root}forum/forum.php?page={$TotalPage}' class='list_page'>尾页</a>";   
                     } 
                                 
               }               
           }             
        ?>             
      </div>             
    </div>              
</div>
<script type="text/javascript">
$(function(){
	$("#tiaozhuan").change(function(){
		window.location.href = $("#tiaozhuan").val();
	});
});
</script>              
<?php                 
echo warn();                
ThisFooter();                
?>       