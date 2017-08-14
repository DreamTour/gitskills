<?php
require_once "../library/mFunction.php";
if($KehuFinger == 2 or empty($KehuFinger)){
    $this_url = root."m/mQuestionnaire.php?type=".$_GET['type'];
    wxLogin($this_url);
}
//循环题目
$html = "";
$sql = mysql_query(" select * from question where type = '$_GET[type]' and xian = '显示' order by list ");
$num = mysql_num_rows($sql);
while($array = mysql_fetch_array($sql)){
    //循环题目
    $answer = "";
    $answerSql = mysql_query(" select * from questionAnswer where questionId = '$array[id]' and xian = '显示' order by list ");
    while($answerArray = mysql_fetch_array($answerSql)){
        $answer .= "<span><label>&nbsp;<input type='radio' name='{$array['id']}' value='{$answerArray['id']}' />&nbsp;&nbsp;{$answerArray['name']}</label></span>";
    }
    $html .= "
	<li>
		<p>{$array['title']}</p>
		{$answer}
	</li>
	";
}
echo head("m");
?>
    <style type="text/css">
        .diaocha{font-size:2em;}
        .diaocha li{padding:0 0 1em 0;border-bottom:1px solid #dcdcdc;overflow:hidden;}
        .diaocha p{line-height:1.5;padding:1em 0 0.5em;}
        .diaocha span{line-height:2;display:block;float:left;width:50%;}
        .dcbtn{display: block;width: 60%;text-align: center;color: #000; background: #FFEB3B;border-radius: 0.6em; -webkit-border-radius: 0.6em;
            -moz-border-radius: 0.6em;margin:1em auto;font-size: 1em;line-height: 2.4;}
    </style>
    <div class="ploading">
        <div class="load-container load">
            <div class="loader">Loading...</div>
        </div>
    </div>
    <div class="wrap">
        <div class="diaocha wrap-box">
            <p><?php echo $_GET['type'];?></p>
            <form name="questionForm">
                <ul><?php echo $html;?></ul>
                <input name="num" type="hidden" value="<?php echo $num;?>">
                <input type="button" id="dddddd" value="立&nbsp;即&nbsp;提&nbsp;交" class="dcbtn" onClick="Sub('questionForm','<?php echo root."library/mData.php?type=question";?>')" />
            </form>
        </div>
    </div>
    <script>
        $(function(){
            var root = "<?php echo root;?>";
            $(document).on("click","#ok",function(){
                window.location.href = root + "m/mUser/mUsCard.php";
            });
        });
    </script>
<?php echo footer();?>