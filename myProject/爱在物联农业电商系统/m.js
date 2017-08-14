/***********************导航栏变色****************************/
function changeNav(){
    var mUrl = location.href;
    if(mUrl.indexOf("mindex") != -1){
        $(".footer li").eq(0).attr("class","on");
    }else if(mUrl.indexOf("mClassify") != -1){
        $(".footer li").eq(1).attr("class","on");
    }else if(mUrl.indexOf("mUsBuyCar") != -1){
        $(".footer li").eq(2).attr("class","on");
    }else if(mUrl.indexOf("mUser") != -1){
        $(".footer li").eq(3).attr("class","on");
    }else if(mUrl.indexOf("mGoods") != -1){
        $(".footer li").eq(1).attr("class","on");
    }
}
/********异步提交函数**************************/
//form支持多表单提交，中间用,隔开，url为提交地址
function Sub(form,url){
    //串联表单
    var formName = form.split(",");
    var serialize = "";
    var a = "";
    for(var i=0;i<formName.length;i++){
        if(serialize == ""){
            a = "";
        }else{
            a = "&";
        }
        serialize += a + $("[name="+formName[i]+"]").serialize();
    }
    //console.log(serialize);
    //异步提交数据
    $.post(url,serialize,function(data){
        if(data.warn == "2"){
            if(data.href){//如果异步返回的json参数中定义了重定向url，则跳转到本url
                window.location.href = data.href;
            }else{
                window.location.reload();
            }
        }else{
            mwarn(data.warn);
        }
    },"json");
}

//返回首页
pushHistory();
window.addEventListener("popstate", function(e) {
    window.location = 'http://www.yumukeji.com/project/aizai/m/mindex.php';
}, false);

function pushHistory() {
    var state = {
        title: "title",
        url: "#"
    };
    window.history.pushState(state, "title", "#");
}
