$(function () {
   $('.nav>span').click(function () {
       $('.nav>span').removeClass('qur');
       $(this).addClass('qur');
   });
    //var number1=1;
    $('.xq1>p').click(function () {
          if($(this).children('b').hasClass('jia')){
              $(this).children('b').removeClass().addClass('jian');
          }else{
              $(this).children('b').removeClass().addClass('jia')
          }
        $(this).next().fadeToggle();
    });

    $('.study').click(function () {
        $('.xueqi').css({"display":"block"});
        $('.score').css({"display":"none"});
        $('.warn').css({"display":"none"});
    });
    $('.my_point').click(function () {
        $('.xueqi').css({"display":"none"});
        $('.score').css({"display":"block"});
        $('.warn').css({"display":"none"});
    });
    $('.warning').click(function () {
        $('.xueqi').css({"display":"none"});
        $('.score').css({"display":"none"});
        $('.warn').css({"display":"block"});
    });

    var json=[
        {"course":"语文1","kind":"必修","score":"77","credit":"4"},
        {"course":"语文2","kind":"必修","score":"40","credit":"4"},
        {"course":"语文3","kind":"必修","score":"40","credit":"4"},
        {"course":"语文4","kind":"必修","score":"60","credit":"4"},
        {"course":"语文5","kind":"必修","score":"77","credit":"4"},
        {"course":"语文6","kind":"必修","score":"80","credit":"4"},
        {"course":"语文7","kind":"必修","score":"77","credit":"4"},
        {"course":"语文8","kind":"必修","score":"66","credit":"4"},
        {"course":"语文9","kind":"必修","score":"66","credit":"4"},
        {"course":"语文10","kind":"必修","score":"77","credit":"4"},
        {"course":"语文11","kind":"必修","score":"77","credit":"4"},
        {"course":"语文12","kind":"必修","score":"77","credit":"4"},
        {"course":"语文13","kind":"必修","score":"77","credit":"4"},
        {"course":"语文14","kind":"必修","score":"77","credit":"4"},
        {"course":"语文14","kind":"必修","score":"77","credit":"4"}
    ];
    var data=eval(json);
    console.log(data);
    var point=0;
    for(var i=0;i<data.length;i++){
        if(parseInt(data[i].score)>=60){
            point+=parseInt(data[i].credit);
        }
    }
   $('.point>strong').html(point);


    function show(){
       var number=-180+point*1.5;
        console.log(number);
        $('.b1>img').css({"transform":"rotate("+number+"deg)"});
    };
    show();
});