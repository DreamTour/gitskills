<?php
include "mLibrary/mFunction.php";
echo head("m");
?>
<style>
    .text{ width:100%; height:35px; line-height:35px; z-index:10000;
        font-size: 17px;
        text-align: center;
        font-weight: bold; color: #fff;}
</style>
<div id="back" onClick="paly();"><div class="zhezhao"></div></div>
<video id="voc" src="<?php echo $get['url']?>" controls  style="width:100%; height:288px;"></video>
<div class="text"></div>
<script>
    (function(w){
        var e = <?php echo website("Tvh56486340BI");?>;
        var target = document.getElementsByClassName('text')[0];
        var timeout = function(){
            target.innerHTML = "为保障用户隐私，画面已做处理。"+"<em style='color:#FFEB3B;'>"+e+"</em>秒后返回";
            e--;
            if (e == 0) {
                w.location = "<?php echo getenv("HTTP_REFERER");?>";
                w.clearTimeout(b);
            }else {
                var b = w.setTimeout(timeout,1E3);
            }
        };
        timeout();
    })(window);
    function paly(){
        var voc = document.getElementById('voc');
        voc.play();
    }
</script>
<?php echo footer();?>
</body>
</html>