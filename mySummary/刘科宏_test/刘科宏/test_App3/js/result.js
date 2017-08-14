$(function(){
   function randomColor(){
       var r=parseInt(Math.random()*255);
       var g=parseInt(Math.random()*255);
       var b=parseInt(Math.random()*255);
       return "rgb(" + r + ", " + g + ", " + b + ")";
   }
    function randomSize(){
      var count=432;
        var number=parseInt(Math.random()*300);
        var number2=parseInt(number/432*100)+"%";
        return number2;
    };
    function randomSize2(){
        var count=432;
        var number=parseInt(Math.random()*300);
        return number
    };
  console.log(randomColor());

    $('.e .bili').css({"background":randomColor()}).width(randomSize());
    $('.i .bili').css({"background":randomColor()}).width(randomSize());
    $('.s .bili').css({"background":randomColor()}).width(randomSize());
    $('.n .bili').css({"background":randomColor()}).width(randomSize());
    $('.t .bili').css({"background":randomColor()}).width(randomSize());
    $('.f .bili').css({"background":randomColor()}).width(randomSize());
    $('.j .bili').css({"background":randomColor()}).width(randomSize());
    $('.p .bili').css({"background":randomColor()}).width(randomSize());
   // console.log(parseFloat($('.e .bili').width()));
    $('.e .bfb strong').html(randomSize());
    $('.i .bfb strong').html(randomSize());
    $('.s .bfb strong').html(randomSize());
    $('.n .bfb strong').html(randomSize());
    $('.t .bfb strong').html(randomSize());
    $('.f .bfb strong').html(randomSize());
    $('.j .bfb strong').html(randomSize());
    $('.p .bfb strong').html(randomSize());

});
