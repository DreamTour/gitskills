<?php
include "mLibrary/mFunction.php";
echo head("m");
?>
<body>
<div class="wrap">
    <!-- 健身计时 -->
    <div class="wrap-box timer-box " id="timerTemplate">
        <div class="title"><h3><i class="timer-icon">&#xe60b;</i> 健身计时</h3></div>
        <div class="content">
            <span id="timerContent">00:00:00:00</span>
        </div>
        <div class="title-content">
            <span id="outDoorTemplate">结束健身</span>
            <span>继续健身</span>
        </div>
    </div>
    <!-- 健身计时 end -->
</div>
<!-- 结束健身出门弹出层 -->
<div class="out-door-shade hide" id="outDoorShade">
    <div class="shade-module">
        <div class="module-head">
            温馨提示！
        </div>
        <div class="module-content">
            您一共健身<span id="totalTimeText"> 100 </span>分钟<br />
            您应付<span id="totalMoneyText"> 30 </span>元
        </div>
        <div class="module-btn">
            <a href="javascript:;" class="btn-confirm" id="outConfirm">确认</a>
            <a href="javascript:;" class="btn-cancel" id="outCancel">取消</a>
        </div>
    </div>
</div>
<!-- 结束健身出门弹出层 end -->
</body>
<script>
    window.onload = function() {
        /**
         * 健身计时,结束健身弹出层
         * @author He Hui
         * */
        var outDoorTemplate = getId('outDoorTemplate');
        var outDoorShade = getId('outDoorShade');
        var timer = null;
        var days = null;
        var hours = null;
        var minutes = null;
        var seconds = null;

        //初始化
        totalTimer();

        //健身计时
        timer = setInterval(function() {
            totalTimer();
        }, 1e3)

        //点击出门
        outDoorTemplate.onclick = function() {
            var totalTime = parseInt(days) * 1440 + parseInt(hours) * 60 + parseInt(minutes);
            var price = 0.3; // 调用后台一分钟多少钱
            var money = accMul(totalTime,price);
            var totalTimeText = getId('totalTimeText');
            var totalMoneyText = getId('totalMoneyText');
            totalTimeText.innerHTML = totalTime; //锻炼分钟
            totalMoneyText.innerHTML = money;   //应付多少钱
            outDoorShade.style.display = 'block';
        }

        var outConfirm = getId('outConfirm');
        var outCancel = getId('outCancel');
        //确认出门按钮
        outConfirm.onclick = function() {
            clearInterval(timer);
            delCookie('beginTime');
        }
        //取消出门按钮
        outCancel.onclick = function() {
            outDoorShade.style.display = 'none';
        }

        /**
         * 获取id
         * @param id 元素id
         * @author He Hui
         * */
        function getId(id) {
            return document.getElementById(id);
        }

        /**
         * 读取cookies
         * @param name 名字
         * @author He Hui
         * */
        function getCookie(name)
        {
            var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
            if(arr=document.cookie.match(reg)) return unescape(arr[2]);
            else return null;
        }
        /**
         * 删除cookies
         * @param name 名字
         * @author He Hui
         * */
        function delCookie(name)
        {
            var exp = new Date();
            exp.setTime(exp.getTime() - 1);
            var cval=getCookie(name);
            if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
        }

        /**
         * 乘法函数
         * @param arg1 乘数
         * @param arg2 被乘数
         * @returns {number} 整数
         * @author He Hui
         */
        function accMul(arg1,arg2) {
            var m=0,s1=arg1.toString(),s2=arg2.toString();
            try{m+=s1.split(".")[1].length}catch(e){}
            try{m+=s2.split(".")[1].length}catch(e){}
            return  Number(s1.replace(".",""))*Number(s2.replace(".",""))/Math.pow(10,m)
        }

        /**
         * 计算时间
         * @author He Hui
         * */
        function totalTimer() {
            var date = new Date();
            var currentTime = date.getTime();
            //相差时间
            var differ = currentTime - getCookie('beginTime');
            //计算出相差天数
            days = Math.floor(differ/(24*3600*1000));
            //计算出小时数
            var remainHours = differ%(24*3600*1000);    //计算天数后剩余的毫秒数
            hours = Math.floor(remainHours/(3600*1000));
            //计算相差分钟数
            var remainMinutes = remainHours%(3600*1000);        //计算小时数后剩余的毫秒数
            minutes = Math.floor(remainMinutes/(60*1000));
            //计算相差秒数
            var leaveSeconds = remainMinutes%(60*1000);      //计算分钟数后剩余的毫秒数
            seconds = Math.round(leaveSeconds/1000);
            if (days.toString().length < 2) days = '0' +　days;
            if (hours.toString().length < 2) hours = '0' +　hours;
            if (minutes.toString().length < 2) minutes = '0' + minutes;
            if (seconds.toString().length < 2) seconds = '0' + seconds;
            var timerContent = getId('timerContent');
            timerContent.innerHTML = days+":"+hours+":"+minutes+":"+seconds;
        }
    }
</script>
</html>