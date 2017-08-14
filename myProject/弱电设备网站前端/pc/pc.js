/* @author Hui He */

/**
 * 点击小图片显示对应的大图
 * @param configure 配置
 */
function imgTab(configure) {
    var bigImg = document.getElementById(configure.bigImgID);
    var imgList = document.getElementById(configure.smallImgID);
    var smallLi = imgList.getElementsByTagName('li');
    var smallImg = imgList.getElementsByTagName('img');

    //点击切换
    if (bigImg && smallLi && smallImg) {
        for (var i=0;i<smallLi.length;i++) {
            smallLi[i].index = i;
            smallLi[i].onclick = function() {
                for (var i=0;i<smallImg.length;i++) {
                    smallLi[i].className = '';
                    var smallImgSrc = smallImg[this.index].getAttribute('src');
                    bigImg.setAttribute('src', smallImgSrc);
                }
                this.className = 'current';
            }
        }
    }

    var next = document.getElementById(configure.nextID);
    var prev = document.getElementById(configure.prevID);
    var count = 0;

    //切换函数
    function mutual() {
        for (var i=0;i<smallImg.length;i++) {
            var smallImgSrc = smallImg[count].getAttribute('src');
            bigImg.setAttribute('src', smallImgSrc);
        }
        for (var j=0;j<smallLi.length;j++) {
            smallLi[j].className = 0;
            smallLi[count].className = 'current';
        }
    }
    //下一张
    if (next) {
        next.onclick = function() {
            count++;
            if (count == smallImg.length) {
                count = 0;
            }
            mutual();
        }
    }
    //上一张
    if (prev) {
        prev.onclick = function() {
            if (count == 0) {
                count = smallImg.length;
            }
            count--;
            mutual();
        }
    }

    //鼠标移入移除显示隐藏箭头
    var box = document.querySelector(configure.boxID);
    box.onmouseover = function() {
        next.style.display = 'block';
        prev.style.display = 'block';
    }
    box.onmouseout = function() {
        next.style.display = 'none';
        prev.style.display = 'none';
    }
}

/**
 * 无缝滚动
 * @param configure 配置
 */
function seamlessScroll(configure) {
    var container=document.querySelector(configure.containerID);
    var picWrapOne=document.querySelector(configure.picWrapOneID);
    var picWrapTwo=document.querySelector(configure.picWrapTwoID);
    picWrapTwo.innerHTML = picWrapOne.innerHTML;
    function marqueeLeft(){
        if (picWrapTwo.offsetWidth - container.scrollLeft == 0)
            container.scrollLeft -= picWrapOne.offsetWidth
        else {
            container.scrollLeft++;
        }
    }
    function marqueeTop() {
        if (picWrapOne.offsetHeight - container.scrollTop == 0) {
            container.scrollTop -= picWrapOne.offsetWidth
        }
        else {
            container.scrollTop++;
        }
    }
    function directionMove() {
        if (configure.direction == 'left') {
            marqueeLeft();
        }
        else if (configure.direction == 'top') {
            marqueeTop();
        }
        else {
            marqueeLeft();
        }
    }
    var hhTimer = setInterval(directionMove,configure.speed);
    container.onmouseover = function() {
        clearInterval(hhTimer);
    };
    container.onmouseout = function() {
        hhTimer = setInterval(directionMove,configure.speed);
    };
}

/**
 * 选项卡
 * @param titleID 标题
 * @param divID 盒子
 */
function tabSwitch(titleID, divID) {
    var title = document.querySelectorAll(titleID);
    var div = document.querySelectorAll(divID);
    if (title && div) {
        for (var i=0;i<title.length;i++) {
            title[i].index = i;
            title[i].onclick = function() {
                for (var i=0;i<div.length;i++) {
                    title[i].className = '';
                    div[i].style.display = 'none';
                }
                this.className = 'current';
                div[this.index].style.display = 'block';
            }
        }
    }
}

//点击弹出对应的图纸
function Drawing(smallImgID, bigImgID, shadeID) {
    var smallImg = document.querySelectorAll(smallImgID);
    var bigImg = document.querySelector(bigImgID);
    var shade = document.querySelector(shadeID);
    if (smallImg && bigImg && shade) {
        for (var i=0;i<smallImg.length;i++) {
            smallImg[i].onclick = function(ev) {
                var e = ev||event;
                e.stopPropagation();
                shade.style.display = 'block';
                var src = this.getAttribute('src');
                bigImg.setAttribute('src', src);
            }
        }
        document.onclick = function() {
            shade.style.display = 'none';
        }
    }
}


/**
 * 异步提交函数
 * @param form 表单名称
 * @param url 提交地址
 * @constructor
 */
function Sub(form,url){
    $.post(url,$("[name="+form+"]").serialize(),function(data){
        if(data.warn == 2){
            if(data.href){//如果异步返回的json参数中定义了重定向url，则跳转到本url
                window.location.href = data.href;
            }else{
                window.location.reload();
            }
        }else{
            warn(data.warn);
        }
    },"json");
}

//导航条移动函数
(function($){
    $.fn.movebg=function(options){
        var defaults={
            width:114,/*移动块的大小*/
            extra:50,/*反弹的距离*/
            speed:300,/*块移动的速度*/
            rebound_speed:300/*块反弹的速度*/
        };
        var defaultser=$.extend(defaults,options);
        return this.each(function(){
            var _this=$(this);
            var _item=_this.children("ul").children("li").children("a");/*找到触发滑块滑动的元素	*/
            var origin=_this.children("ul").children("li.cur").index();/*获得当前导航的索引*/
            var _mover=_this.find(".move-bg");/*找到滑块*/
            var hidden;/*设置一个变量当html中没有规定cur时在鼠标移出导航后消失*/
            if (origin==-1){origin=0;hidden="1"} else{_mover.show()};/*如果没有定义cur,则默认从第一个滑动出来*/
            var cur=prev=origin;/*初始化当前的索引值等于上一个及初始值;*/
            var extra=defaultser.extra;/*声明一个变量表示额外滑动的距离*/
            _mover.css({left:""+defaultser.width*origin+"px"});/*设置滑块当前显示的位置*/

            //设置鼠标经过事件
            _item.each(function(index,it){
                $(it).mouseover(function(){
                    cur=index;/*对当前滑块值进行赋值*/
                    move();
                    prev=cur;/*滑动完成对上个滑块值进行赋值*/
                });
            });
            _this.mouseleave(function(){
                cur=origin;/*鼠标离开导航时当前滑动值等于最初滑块值*/
                move();
                if(hidden==1){_mover.stop().fadeOut();}/*当html中没有规定cur时在鼠标移出导航后消失*/
            });

            //滑动方法
            function move(){
                _mover.clearQueue();
                if(cur<prev){extra=-Math.abs(defaultser.extra);} /*当当前值小于上个滑块值时，额外滑动值为负数*/
                else{extra=Math.abs(defaultser.extra)};/*当当前值大于上个滑块值时，滑动值为正数*/
                _mover.queue(
                    function(){
                        $(this).show().stop(true,true).animate({left:""+Number(cur*defaultser.width+extra)+""},defaultser.speed),
                            function(){$(this).dequeue()}
                    }
                );
                _mover.queue(
                    function(){
                        $(this).stop(true,true).animate({left:""+cur*defaultser.width+""},defaultser.rebound_speed),
                            function(){$(this).dequeue()}
                    }
                );
            };
        })
    }
})(jQuery);

/**
 * 信息返回提示函数
 * @param mes 返回的信息
 */
function warn(mes){
    dialog.showDialog(mes);
}
(function(w,d){
    var dialog={
        showDialog:function(mes){
            var a=[];
            a.push('<div class="dialog-title">提示信息</div>');
            a.push('<div class="dialog-content">'+mes+'</div>');
            a.push('<div class="dialog-bottom"><a href="javascript:;" class="sure" id="sure">确&nbsp;定</a></div>');
            var db = d.createElement('div');
            db.className='dia-ba';
            db.id = 'back';
            var dw = d.createElement('div');
            dw.className='dialog';
            dw.id = 'wind';
            dw.innerHTML = a.join('');
            d.body.appendChild(db);
            d.body.appendChild(dw);
            return d.getElementById("sure").onclick=function(){
                dialog.closeDialog();
            };
        },
        closeDialog:function(){
            var _bg_dialog = d.getElementById('wind');
            var _dialog = d.getElementById('back');
            d.body.removeChild(_bg_dialog);
            d.body.removeChild(_dialog);
        },
    }
    w.dialog=dialog||{};
})(window,document);
(function(w,d){
    var M={
        getById:function(id){
            return d.getElementById(id);
        },
        show:function(a,b){
            M.getById(a).style.display='block';
            M.getById(b).style.display='block';
        },
        hide:function(a,b){
            M.getById(a).style.display='none';
            M.getById(b).style.display='none';
        }
    }
    w.M=M||{};
})(window,document);

$(function() {
    $(".nav a").each(function(){
        $this = $(this);
        if( $this[0].href == String(window.location) ){
            $this.addClass("active");
        }
    });
})

//轮播图
var conBox, child, timer, pagetion, prev, next, index = 0;
function sliderWrap(param) {
    param = param || {};
    wrapper = document.getElementById(param.slideCell);
    if (!wrapper) return;
    conBox = document.getElementById(param.mainCell);
    pagetion = document.getElementById(param.titCell);
    prev = document.getElementById(param.prev);
    next = document.getElementById(param.next);
    child = childNodes(conBox);

    // 初始化conBox的css
    addStyle(conBox, {
        position: "relative",
        zIndex: "5"
    });
    // 初始化child的css
    for (var i = 0; i < child.length; i++) {
        addStyle(child[i], {
            width: (child[0].clientWidth) + "px",
            position: "absolute",
            zIndex: "5",
            display: "block",
            opacity: "0"
        });
        // 添加排序号
        pagetion.innerHTML += "<li>" + (i) + "</li>"
    }

    // 初始化第0个child
    addStyle(child[0], {
        zIndex: "10",
        opacity: "1"
    });

    // 初始化第0个pagetionChild的className
    pagetionChild = childNodes(pagetion);
    pagetionChild[0].className = "current"

    // 设置鼠标移入与移出
    conBox.onmouseover = function() {
        clearInterval(timer)
    }
    conBox.onmouseout = function() {
        onInterval()
    }

    // 检测window是否支持window.addEventListener
    if (window.addEventListener) {
        window.addEventListener('resize', function() {
            onWindowResize()
        }, false)
    }else{
        window.onresize = function(){
            onWindowResize()
        }
    }

    // 调用函数
    onWindowResize();
    onInterval();
    onDoPage();
    onPage()
}

// 点击按钮执行上翻页与下翻页
function onDoPage() {
    if (prev || next) {
        prev.onclick = function() {
            index--;
            if (index < 0) {// 判断点击是否小于最小值
                index = child.length - 1
            }
            clearInterval(timer);
            onDoPlay(index);
            onInterval()
        };
        next.onclick = function() {
            index++;
            if (index >= child.length) {// 判断点击是否大于最大值
                index = 0
            }
            clearInterval(timer);
            onDoPlay(index);
            onInterval()
        }
    }
}

// 点击排序号执行翻页
function onPage() {
    pagetionChild = childNodes(pagetion);
    for (var i = 0; i < pagetionChild.length; i++) {
        pagetionChild[i].index = i;
        pagetionChild[i].onclick = function(event) {
            clearInterval(timer);
            index = this.index; // index 同步当前的index
            onDoPlay(index);// 传递当前的index
            onInterval()
        }
    }
}
// 定时器自动执行运动
function onInterval() {
    timer = setInterval(function() {
        index++;
        if (index >= child.length) {// 判断点击是否大于最大值
            index = 0
        }
        onDoPlay(index)
    }, 3000)
}

// 运动执行
function onDoPlay(index) {
    pagetionChild = childNodes(pagetion);

    for (var i = 0; i < child.length; i++) {// 当每次执行onDoPlay函数的时候 都清除child之前所有的默认属性
        Animation(child[i], {
            opacity: "0"
        }, 40, 10);
        addStyle(child[i], {
            zIndex: "5"
        });
        pagetionChild[i].className = ""
    }
    pagetionChild[index].className = "current";
    Animation(child[index], {// 执行当前第index个child
        opacity: "100"
    }, 40, 10);
    addStyle(child[index], {
        zIndex: "10"
    })
}
// 设置css
function addStyle(obj, Text) {
    if (typeof obj == "undefined" || typeof Text == "undefined") return;
    if (typeof Text === "object") {// 检测类型
        for (read in Text) {
            obj.style[read] = Text[read]
        }
    } else if (typeof Text === "string") {
        var clipText = Text.split(";");
        for (var read = 0; read < clipText.length; read++) {
            var clipText_2 = clipText[read].split(":");
            obj.style[clipText_2[0]] = clipText_2[1]
        }
    }
}
// 读取子元素
function childNodes(parent) {
    var node = parent.childNodes;
    var index = node.length;
    var addArray = [];
    for (var i = 0; i < index; i++) {
        if (node[i].nodeName != "#text") {
            addArray.push(node[i])
        }
    }
    if ( !! addArray) {
        return addArray
    }
}
// 设置窗口缩放
function onWindowResize() {
    var windowInnerWidth = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth;
    var windowInnerHeight = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight;
    if (windowInnerWidth <= 500) {// 判断窗口最小值
        for (var i = 0; i < child.length; i++) {
            addStyle(child[i], {
                width: 500 + "px"
            })
        }
        return
    }
    for (var i = 0; i < child.length; i++) {
        addStyle(child[i], {
            width: windowInnerWidth + "px"
        })
    }
    addStyle(conBox, {
        height: child[0].clientHeight + "px"
    })
}
// 动画函数
function Animation(apply, json, transition, duration) {
    var TIMER = null;
    var OPACITY = "opacity";
    var OPACITY_NUM = 100;
    var CSS_GET = function(obj, name) {
        return obj.currentStyle ? obj.currentStyle[name] : getComputedStyle(obj, false)[name]
    };
    window.clearInterval(apply.TIMER);
    apply.TIMER = window.setInterval(function() {
        for (var transAttr in json) {
            var setSpeed = 0;
            var setAttr = parseInt(CSS_GET(apply, transAttr));
            if (transAttr == OPACITY) {
                setAttr = Math.round(parseFloat(CSS_GET(apply, transAttr)) * OPACITY_NUM)
            } else {
                setAttr = parseInt(CSS_GET(apply, transAttr))
            };
            setSpeed = ((json[transAttr] - setAttr) / transition);
            if (setSpeed > 0) {
                setSpeed = Math.ceil(setSpeed)
            } else {
                setSpeed = Math.floor(setSpeed)
            };
            if (transAttr == OPACITY) {
                apply.style.filter = "alpha(opacity:" + (setAttr + setSpeed) + ")";
                apply.style.opacity = ((setAttr + setSpeed) / OPACITY_NUM)
            } else {
                apply.style[transAttr] = (setAttr + setSpeed) + "px"
            }
        }
    }, duration)
}
