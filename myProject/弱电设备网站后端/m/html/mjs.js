/* @author Hui He */
/**
 * 动态加载数据利用父级来获取子元素
 * @author Hui He
 * @param parentID 父级元素
 * @param coverID 遮罩层
 * @param eventName 事件名称
 * @param labelID 标签名称
 * @param classID 样式名称
 * @param qrCodeID 二维码
 */
function entrust(parentID, coverID, eventName, labelID, classID, qrCodeID) {
    var parent = document.getElementById(parentID);
    var cover = document.querySelector(coverID);
    // 获得父元素DIV, 添加监听器...
    parent.addEventListener(eventName, function(e) {
        var e = e || window.event;
        e.stopPropagation();
        // e.target是被点击的元素
        if (e.target && e.target.nodeName == labelID) {
            var classes = e.target.className.split(' ');
            if (classes) {
                // For every CSS class the element has...
                for (var i=0;i<classes.length;i++) {
                    // If it has the CSS class we want...
                    if (classes[i] == classID) {
                        // Bingo! Now do something here....
                        cover.style.display = 'block';
                        var src = e.target.getAttribute('src');
                        var qrCode = document.querySelector(qrCodeID);
                        qrCode.setAttribute('src', src);
                    }
                }
            }
        }
    })
    document.onclick = function() {
        cover.style.display = 'none';
    }
}

/**
 * 点击弹出对应的图纸
 * @param smallImgID 列表图片
 * @param bigImgID 弹出层显示的图片
 * @param shadeID 弹出层
 * @constructor
 */
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
 * @param form 表单名称
 * @param url 提交地址
 * @constructor 异步提交函数
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

/**
 * 轮播图
 * @param a 配置
 * @returns {boolean}
 * @constructor
 */
var TouchSlide = function(a) {
    a = a || {};
    var b = {
            slideCell: a.slideCell || "#touchSlide",
            titCell: a.titCell || ".hd li",
            mainCell: a.mainCell || ".bd",
            effect: a.effect || "left",
            autoPlay: a.autoPlay || !1,
            delayTime: a.delayTime || 200,
            interTime: a.interTime || 2500,
            defaultIndex: a.defaultIndex || 0,
            titOnClassName: a.titOnClassName || "on",
            autoPage: a.autoPage || !1,
            prevCell: a.prevCell || ".prev",
            nextCell: a.nextCell || ".next",
            pageStateCell: a.pageStateCell || ".pageState",
            pnLoop: "undefined " == a.pnLoop ? !0 : a.pnLoop,
            startFun: a.startFun || null,
            endFun: a.endFun || null,
            switchLoad: a.switchLoad || null
        },
        c = document.getElementById(b.slideCell.replace("#", ""));
    if (!c) return !1;
    var d = function(a, b) {
            a = a.split(" ");
            var c = [];
            b = b || document;
            var d = [b];
            for (var e in a) 0 != a[e].length && c.push(a[e]);
            for (var e in c) {
                if (0 == d.length) return !1;
                var f = [];
                for (var g in d) if ("#" == c[e][0]) f.push(document.getElementById(c[e].replace("#", "")));
                else if ("." == c[e][0]) for (var h = d[g].getElementsByTagName("*"), i = 0; i < h.length; i++) {
                    var j = h[i].className;
                    j && -1 != j.search(new RegExp("\\b" + c[e].replace(".", "") + "\\b")) && f.push(h[i])
                } else for (var h = d[g].getElementsByTagName(c[e]), i = 0; i < h.length; i++) f.push(h[i]);
                d = f
            }
            return 0 == d.length || d[0] == b ? !1 : d
        },
        e = function(a, b) {
            var c = document.createElement("div");
            c.innerHTML = b, c = c.children[0];
            var d = a.cloneNode(!0);
            return c.appendChild(d), a.parentNode.replaceChild(c, a), m = d, c
        },
        g = function(a, b) {
            !a || !b || a.className && -1 != a.className.search(new RegExp("\\b" + b + "\\b")) || (a.className += (a.className ? " " : "") + b)
        },
        h = function(a, b) {
            !a || !b || a.className && -1 == a.className.search(new RegExp("\\b" + b + "\\b")) || (a.className = a.className.replace(new RegExp("\\s*\\b" + b + "\\b", "g"), ""))
        },
        i = b.effect,
        j = d(b.prevCell, c)[0],
        k = d(b.nextCell, c)[0],
        l = d(b.pageStateCell)[0],
        m = d(b.mainCell, c)[0];
    if (!m) return !1;
    var N, O, n = m.children.length,
        o = d(b.titCell, c),
        p = o ? o.length : n,
        q = b.switchLoad,
        r = parseInt(b.defaultIndex),
        s = parseInt(b.delayTime),
        t = parseInt(b.interTime),
        u = "false" == b.autoPlay || 0 == b.autoPlay ? !1 : !0,
        v = "false" == b.autoPage || 0 == b.autoPage ? !1 : !0,
        w = "false" == b.pnLoop || 0 == b.pnLoop ? !1 : !0,
        x = r,
        y = null,
        z = null,
        A = null,
        B = 0,
        C = 0,
        D = 0,
        E = 0,
        G = /hp-tablet/gi.test(navigator.appVersion),
        H = "ontouchstart" in window && !G,
        I = H ? "touchstart" : "mousedown",
        J = H ? "touchmove" : "",
        K = H ? "touchend" : "mouseup",
        M = m.parentNode.clientWidth,
        P = n;
    if (0 == p && (p = n), v) {
        p = n, o = o[0], o.innerHTML = "";
        var Q = "";
        if (1 == b.autoPage || "true" == b.autoPage) for (var R = 0; p > R; R++) Q += "<li>" + (R + 1) + "</li>";
        else for (var R = 0; p > R; R++) Q += b.autoPage.replace("$", R + 1);
        o.innerHTML = Q, o = o.children
    }
    "leftLoop" == i && (P += 2, m.appendChild(m.children[0].cloneNode(!0)), m.insertBefore(m.children[n - 1].cloneNode(!0), m.children[0])), N = e(m, '<div class="tempWrap" style="overflow:hidden; position:relative;"></div>'), m.style.cssText = "width:" + P * M + "px;" + "position:relative;overflow:hidden;padding:0;margin:0;";
    for (var R = 0; P > R; R++) m.children[R].style.cssText = "display:table-cell;vertical-align:top;width:" + M + "px";
    var S = function() {
            "function" == typeof b.startFun && b.startFun(r, p)
        },
        T = function() {
            "function" == typeof b.endFun && b.endFun(r, p)
        },
        U = function(a) {
            var b = ("leftLoop" == i ? r + 1 : r) + a,
                c = function(a) {
                    for (var b = m.children[a].getElementsByTagName("img"), c = 0; c < b.length; c++) b[c].getAttribute(q) && (b[c].setAttribute("src", b[c].getAttribute(q)), b[c].removeAttribute(q))
                };
            if (c(b), "leftLoop" == i) switch (b) {
                case 0:
                    c(n);
                    break;
                case 1:
                    c(n + 1);
                    break;
                case n:
                    c(0);
                    break;
                case n + 1:
                    c(1)
            }
        },
        V = function() {
            M = N.clientWidth, m.style.width = P * M + "px";
            for (var a = 0; P > a; a++) m.children[a].style.width = M + "px";
            var b = "leftLoop" == i ? r + 1 : r;
            W(-b * M, 0)
        };
    window.addEventListener("resize", V, !1);
    var W = function(a, b, c) {
            c = c ? c.style : m.style, c.webkitTransitionDuration = c.MozTransitionDuration = c.msTransitionDuration = c.OTransitionDuration = c.transitionDuration = b + "ms", c.webkitTransform = "translate(" + a + "px,0)" + "translateZ(0)", c.msTransform = c.MozTransform = c.OTransform = "translateX(" + a + "px)"
        },
        X = function(a) {
            switch (i) {
                case "left":
                    r >= p ? r = a ? r - 1 : 0 : 0 > r && (r = a ? 0 : p - 1), null != q && U(0), W(-r * M, s), x = r;
                    break;
                case "leftLoop":
                    null != q && U(0), W(-(r + 1) * M, s), -1 == r ? (z = setTimeout(function() {
                        W(-p * M, 0)
                    }, s), r = p - 1) : r == p && (z = setTimeout(function() {
                        W(-M, 0)
                    }, s), r = 0), x = r
            }
            S(), A = setTimeout(function() {
                T()
            }, s);
            for (var c = 0; p > c; c++) h(o[c], b.titOnClassName), c == r && g(o[c], b.titOnClassName);
            0 == w && (h(k, "nextStop"), h(j, "prevStop"), 0 == r ? g(j, "prevStop") : r == p - 1 && g(k, "nextStop")), l && (l.innerHTML = "<span>" + (r + 1) + "</span>/" + p)
        };
    if (X(), u && (y = setInterval(function() {
            r++, X()
        }, t)), o) for (var R = 0; p > R; R++)!
        function() {
            var a = R;
            o[a].addEventListener("click", function() {
                clearTimeout(z), clearTimeout(A), r = a, X()
            })
        }();
    k && k.addEventListener("click", function() {
        (1 == w || r != p - 1) && (clearTimeout(z), clearTimeout(A), r++, X())
    }), j && j.addEventListener("click", function() {
        (1 == w || 0 != r) && (clearTimeout(z), clearTimeout(A), r--, X())
    });
    var Y = function(a) {
            clearTimeout(z), clearTimeout(A), O = void 0, D = 0;
            var b = H ? a.touches[0] : a;
            B = b.pageX, C = b.pageY, m.addEventListener(J, Z, !1), m.addEventListener(K, $, !1)
        },
        Z = function(a) {
            if (!H || !(a.touches.length > 1 || a.scale && 1 !== a.scale)) {
                var b = H ? a.touches[0] : a;
                if (D = b.pageX - B, E = b.pageY - C, "undefined" == typeof O && (O = !! (O || Math.abs(D) < Math.abs(E))), !O) {
                    switch (a.preventDefault(), u && clearInterval(y), i) {
                        case "left":
                            (0 == r && D > 0 || r >= p - 1 && 0 > D) && (D = .4 * D), W(-r * M + D, 0);
                            break;
                        case "leftLoop":
                            W(-(r + 1) * M + D, 0)
                    }
                    null != q && Math.abs(D) > M / 3 && U(D > -0 ? -1 : 1)
                }
            }
        },
        $ = function(a) {
            0 != D && (a.preventDefault(), O || (Math.abs(D) > M / 10 && (D > 0 ? r-- : r++), X(!0), u && (y = setInterval(function() {
                r++, X()
            }, t))), m.removeEventListener(J, Z, !1), m.removeEventListener(K, $, !1))
        };
    m.addEventListener(I, Y, !1)
};