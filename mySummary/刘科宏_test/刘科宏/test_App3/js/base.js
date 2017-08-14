/**
 * Created by Administrator on 17-2-8.
 */
$(function(){
   $('.xuanxiang_box').on('click','.one',function(){
       $(this).children('div').removeClass();
       $(this).children('div').addClass('xuanzhong');
       $(this).next().children('div').removeClass();
       $(this).next().children('div').addClass('weixuan');
   });
    $('.xuanxiang_box').on('click','.two',function(){
        $(this).children('div').removeClass();
        $(this).children('div').addClass('xuanzhong');
        $(this).prev().children('div').removeClass();
        $(this).prev().children('div').addClass('weixuan');
    });
    var json=[
        {"xunhao":"1","title":"当你在一个星期以内完成一个大项目，会开始怎么做？","xx1":"马上做1","xx2":"把要做的工作依次列出"},
        {"xunhao":"2","title":"当你在一个星期以内完成一个大项目，会开始怎么做？","xx1":"马上做2","xx2":"把要做的工作依次列出"},
        {"xunhao":"3","title":"当你在一个星期以内完成一个大项目，会开始怎么做？","xx1":"马上做3","xx2":"把要做的工作依次列出"},
        {"xunhao":"4","title":"当你在一个星期以内完成一个大项目，会开始怎么做？","xx1":"马上做4","xx2":"把要做的工作依次列出"},
        {"xunhao":"5","title":"当你在一个星期以内完成一个大项目，会开始怎么做？","xx1":"马上做5","xx2":"把要做的工作依次列出"},
        {"xunhao":"6","title":"当你在一个星期以内完成一个大项目，会开始怎么做？","xx1":"马上做6","xx2":"把要做的工作依次列出"},
        {"xunhao":"7","title":"当你在一个星期以内完成一个大项目，会开始怎么做？","xx1":"马上做7","xx2":"把要做的工作依次列出"},
        {"xunhao":"8","title":"当你在一个星期以内完成一个大项目，会开始怎么做？","xx1":"马上做8","xx2":"把要做的工作依次列出"},
        {"xunhao":"9","title":"当你在一个星期以内完成一个大项目，会开始怎么做？","xx1":"马上做9","xx2":"把要做的工作依次列出"},
    ];
    var data=eval(json);
    console.log(data);
    var html='';
    for(var i=0;i<data.length;i++){
        console.log(data[i].xunhao);
       html+=`
       <p><strong>${data[i].xunhao}</strong>.${data[i].title}</p>
    <div class="select">
        <div class="one">
            <div class="weixuan">
                <span class="circle">
                <span class="circle_n"></span>
              </span>
            </div>
            <span class="wenzi">${data[i].xx1}</span>
        </div>
        <div class="two">
            <div class="weixuan">
                <span class="circle">
                <span class="circle_n"></span>
            </span>
            </div>
            <span class="wenzi">${data[i].xx2}</span>
        </div>
    </div>
       `
    };
    $('.xuanxiang_box').html(html);
    var button=`
    <div class="container"><a href="result.html" class="result">提交测试结果</a></div>
    `;
    $('.xuanxiang_box').append(button);
});
