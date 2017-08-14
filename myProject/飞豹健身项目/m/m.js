!function(a) {
    function g(b) {
        var e = Math.abs(b._moveY);
        "" != b.opts.loadUpFn && 0 >= b.touchScrollTop && "down" == b.direction && !b.isLockUp && (f(b.$domUp, 300), e > b.opts.distance ? (b.$domUp.css({
            height: b.$domUp.children().height()
        }), b.$domUp.html(b.opts.domUp.domLoad), b.loading = !0, b.opts.loadUpFn(b)) : b.$domUp.css({
            height: "0"
        }).on("webkitTransitionEnd transitionend",
            function() {
                b.upInsertDOM = !1;
                a(this).remove()
            }), b._moveY = 0)
    }
    function h(b) {
        b._scrollContentHeight = b.opts.scrollArea == m ? l.height() : b.$element[0].scrollHeight
    }
    function f(b, a) {
        b.css({
            "-webkit-transition": "all " + a + "ms",
            transition: "all " + a + "ms"
        })
    }
    var e, m = window,
        n = document,
        p = a(m),
        l = a(n);
    a.fn.dropload = function(a) {
        return new e(this, a)
    };
    e = function(b, e) {
        this.$element = a(b);
        this.isLockDown = this.isLockUp = this.loading = this.upInsertDOM = !1;
        this.isData = !0;
        this._scrollTop = 0;
        this.init(e)
    };
    e.prototype.init = function(b) {
        function e() {
            c.direction = "up";
            c.$domDown.html(c.opts.domDown.domLoad);
            c.loading = !0;
            c.opts.loadDownFn(c)
        }
        var c = this;
        c.opts = a.extend({},
            {
                scrollArea: c.$element,
                domUp: {
                    domClass: "dropload-up",
                    domRefresh: '<div class="dropload-refresh">\u2193\u4e0b\u62c9\u5237\u65b0</div>',
                    domUpdate: '<div class="dropload-update">\u2191\u91ca\u653e\u66f4\u65b0</div>',
                    domLoad: '<div class="dropload-load"><span class="loading"></span>\u52a0\u8f7d\u4e2d...</div>'
                },
                domDown: {
                    domClass: "dropload-down",
                    domRefresh: '<div class="dropload-refresh">\u2191\u4e0a\u62c9\u52a0\u8f7d\u66f4\u591a</div>',
                    domLoad: '<div class="dropload-load"><span class="loading"></span>\u52a0\u8f7d\u4e2d...</div>',
                    domNoData: '<div class="dropload-noData">\u6682\u65e0\u6570\u636e</div>'
                },
                distance: 50,
                threshold: "",
                loadUpFn: "",
                loadDownFn: ""
            },
            b);
        "" != c.opts.loadDownFn && (c.$element.append('<div class="' + c.opts.domDown.domClass + '">' + c.opts.domDown.domRefresh + "</div>"), c.$domDown = a("." + c.opts.domDown.domClass));
        c.opts.scrollArea == m ? (c.$scrollArea = p, c._scrollContentHeight = l.height(), c._scrollWindowHeight = n.documentElement.clientHeight) : (c.$scrollArea = c.opts.scrollArea, c._scrollContentHeight = c.$element[0].scrollHeight, c._scrollWindowHeight = c.$element.height());
        c._scrollContentHeight <= c._scrollWindowHeight && e();
        p.on("resize",
            function() {
                c._scrollWindowHeight = c.opts.scrollArea == m ? m.innerHeight: c.$element.height()
            });
        c.$element.on("touchstart",
            function(a) {
                if (!c.loading) {
                    a.touches || (a.touches = a.originalEvent.touches);
                    var b = c;
                    b._startY = a.touches[0].pageY;
                    b.touchScrollTop = b.$scrollArea.scrollTop()
                }
            });
        c.$element.on("touchmove",
            function(b) {
                if (!c.loading) {
                    b.touches || (b.touches = b.originalEvent.touches);
                    var d = c;
                    d._curY = b.touches[0].pageY;
                    d._moveY = d._curY - d._startY;
                    0 < d._moveY ? d.direction = "down": 0 > d._moveY && (d.direction = "up");
                    var e = Math.abs(d._moveY);
                    "" != d.opts.loadUpFn && 0 >= d.touchScrollTop && "down" == d.direction && !d.isLockUp && (b.preventDefault(), d.$domUp = a("." + d.opts.domUp.domClass), d.upInsertDOM || (d.$element.prepend('<div class="' + d.opts.domUp.domClass + '"></div>'), d.upInsertDOM = !0), f(d.$domUp, 0), e <= d.opts.distance ? (d._offsetY = e, d.$domUp.html(d.opts.domUp.domRefresh)) : e > d.opts.distance && e <= 2 * d.opts.distance ? (d._offsetY = d.opts.distance + .5 * (e - d.opts.distance), d.$domUp.html(d.opts.domUp.domUpdate)) : d._offsetY = d.opts.distance + .5 * d.opts.distance + .2 * (e - 2 * d.opts.distance), d.$domUp.css({
                        height: d._offsetY
                    }))
                }
            });
        c.$element.on("touchend",
            function() {
                c.loading || g(c)
            });
        c.$scrollArea.on("scroll",
            function() {
                c._scrollTop = c.$scrollArea.scrollTop();
                c._threshold = "" === c.opts.threshold ? Math.floor(1 * c.$domDown.height() / 3) : c.opts.threshold;
                "" != c.opts.loadDownFn && !c.loading && !c.isLockDown && c._scrollContentHeight - c._threshold <= c._scrollWindowHeight + c._scrollTop && e()
            })
    };
    e.prototype.lock = function(b) {
        void 0 === b ? "up" == this.direction ? this.isLockDown = !0 : "down" == this.direction ? this.isLockUp = !0 : (this.isLockUp = !0, this.isLockDown = !0) : "up" == b ? this.isLockUp = !0 : "down" == b && (this.isLockDown = !0)
    };
    e.prototype.unlock = function() {
        this.isLockDown = this.isLockUp = !1
    };
    e.prototype.noData = function() {
        this.isData = !1
    };
    e.prototype.resetload = function() {
        var b = this;
        "down" == b.direction && b.upInsertDOM ? b.$domUp.css({
            height: "0"
        }).on("webkitTransitionEnd mozTransitionEnd transitionend",
            function() {
                b.loading = !1;
                b.upInsertDOM = !1;
                a(this).remove();
                h(b)
            }) : "up" == b.direction && (b.loading = !1, b.isData ? (b.$domDown.html(b.opts.domDown.domRefresh), h(b)) : b.$domDown.html(b.opts.domDown.domNoData))
    }
} (window.jQuery); (function() {
    window.M = {
        getById: function(a) {
            return document.getElementById(a)
        },
        init: function(a) {
            if (!M.getById("Dialog")) {
                var g = [];
                g.push('<div class="js_dialog" id="Dialog">');
                g.push('<div class="weui_mask"></div>');
                g.push('<div class="weui_dialog">');
                g.push('<div class="weui_dialog_bd" style="padding: 2.7em 20px 1.7em;">' + a + "</div>");
                g.push('<div class="weui_dialog_ft">');
                g.push("<a href='javascript:;' class='weui_dialog_btn' id='ok'>知道了</a><a href='javascript:;' onclick='hideWarn()'>取消</a>");
                g.push("</div></div></div>");
                $(document.body).append(g.join(""))
            }
            M.remove()
        },
        remove: function() {
            M.getById("ok").addEventListener("click",
                function(a) {
                    $("#Dialog").remove()
                },
                !1)
        },
        loadCss: function(a, g) {
            var h = document.head || document.getElementsByTagName("head")[0],
                f = document.createElement("link");
            f.href = a;
            f.rel = "stylesheet";
            f.type = "text/css";
            g && (f.charset = g);
            h.appendChild(f)
        }
    }
})();
$(window).resize(function() {
    $(".j-child-neat").each(function(a, g) {
        var h = $(this).width(),
            f = $(this).children(),
            e = f.length;
        for (i = 0; i < e; i++) f.eq(i).width(h / e)
    });
    for (k = 1; 12 > k; k++) $(".j-child-row" + k).each(function(a, g) {
        var h = $(this).width();
        $(this).children().width(h / k)
    })
});
$(window).load(function() {
    pageHeight();
    proHeight()
});
/*$(document).ready(function() {
 for (var a = 1; 12 > a; a++) $(".j-child-row" + a).each(function(e, g) {
 var f = $(this).width();
 $(this).children().width(f / a)
 });
 $(".j-child-num").each(function(a, g) {
 for (var f = $(this).children(), h = f.length, l = 0; l < h; l++) {
 var b = f.eq(l).attr("class");
 null == b && (b = "");
 j2 = l + 1;
 b = "child-" + j2 + " " + b;
 f.eq(l).attr("class", b)
 }
 });
 $(".j-child-neat").each(function(a, f) {
 var g = $(this).width(),
 h = $(this).children(),
 l = h.length;
 for (i = 0; i < l; i++) h.eq(i).width(g / l)
 });
 for (a = 2; 12 > a; a++) $(".j-child-auto" + a).each(function(e, g) {
 $(this).find("li").width(100 / a + "%");
 var f = $(this).find("li"),
 h = f.length;
 for (i = 0; i <= a; i++) if (0 == (h + i) % a) for (j = 1; j <= a - i; j++) f.eq(h - j).width(100 / (a - i) + "%")
 });
 if (0 < $(".swiper-1").length) {
 var g = $(".swiper-1").swiper({
 pagination: ".pag-1",
 freeModeFluid: !0,
 autoPlay: 3E3,
 slidesPerSlide: 1
 });
 $(".pag-1 .swiper-pagination-switch").click(function() {
 g.swipeTo($(this).index())
 })
 }
 if (0 < $(".swiper-2").length) {
 var h = $(".swiper-2").swiper({
 pagination: ".pag-2",
 freeModeFluid: !0,
 autoPlay: 3E3,
 slidesPerSlide: 1
 });
 $(".pag-2 .swiper-pagination-switch").click(function() {
 h.swipeTo($(this).index())
 })
 }
 if (0 < $(".thumb-con").length) {
 var f = $(".thumb-con").swiper({
 freeModeFluid: !0,
 slidesPerSlide: 4
 });
 $(".thumb-prev").on("click",
 function(a) {
 a.preventDefault();
 f.swipePrev()
 });
 $(".thumb-next").on("click",
 function(a) {
 a.preventDefault();
 f.swipeNext()
 })
 }
 });*/
$(function(){
    $("#fbpay").on("click",
        function(){
            alertMask()
        });
    $("#fbpay1").on("click",
        function() {
            alertMask()
        });
    $("#close_btn").click(function() {
        $("#pay").hide();
        $("#mask").css({
            display: "none"
        })
    });
    $("#bottom li").click(function() {
        $(this).children(".bomenu").toggle();
        $(this).siblings().children(".bomenu").hide()
    })
});
function proHeight() {
    var a = $(".photo-list li:first img").height();
    $(".photo-list .over").css({
        height: a
    });
    a = $(".photo-list2 li:first img").height();
    $(".photo-list2 .over").css({
        height: a
    });
    a = $(".photo-list3 li:first img").height();
    $(".photo-list3 .over").css({
        height: a
    });
    a = $(".photo-list4 li:first img").height();
    $(".photo-list4 .over").css({
        height: a
    });
    a = $(".j-photoheight li:first img").height();
    $(".j-photoheight .over").css({
        height: a
    })
}
function pageHeight() {
    var a = $(".swiper .swiper-slide:first img").height();
    $(".swiper,.swiper .swiper-wrapper, .swiper .swiper-slide").css({
        height: a
    })
}
function alertMask() {
    document.getElementById("mask") || ($("body").append("<div id='mask'></div>"), $("#mask").addClass("mask"));
    $("#mask").show();
    $("#pay").show()
}
function alert(a) {
    M.init(a)
}
$(function() {
    $(".ploading").fadeOut();
    $(".bota").click(function(a) {
        a = $(this).next(".SecondMenu");
        "none" == a.css("display") ? a.show() : a.hide()
    })
});
//隐藏提示弹出层
function hideWarn(){
    $("#Dialog").remove();
}




//关闭获得勋章弹出层
$(document).on('click', '#medal-shade', function() {
    $(this).hide();
})

/**
 * 获取id
 * @param id 元素id
 * @author He Hui
 * */
function getId(id) {
    return document.getElementById(id);
}

/**
 * 写cookies
 * @param name 名字
 * @param value 值
 * @author He Hui
 * */
function setCookie(name,value)
{
    var Days = 30;
    var exp = new Date();
    exp.setTime(exp.getTime() + Days*24*60*60*1000);
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
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


