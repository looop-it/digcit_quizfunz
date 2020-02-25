$('.section .section-middle > div .left-content div p:not(:nth-child(1)) a,.section .section-right .middle-info p a').each(function(){
 //设置显示获取字符串的字数  这个根绝要求 看需要大概显示几行
    if ($(window).width() > 1200){
    	var maxwidth=45;
    }else if ($(window).width()  <= 1200 && $(window).width()  >= 992){
     	var maxwidth=40;
    }else if($(window).width() <= 991 && $(window).width() >= 768){
    	var maxwidth=30;
    }else if($(window).width() < 768 && $(window).width() >= 578){
    	var maxwidth=110;
    }else if ($(window).width() < 578 && $(window).width() >= 400){
     	var maxwidth=70;
    }else{
    	var maxwidth=50;
    }
    if($(this).text().length>maxwidth){
         //截取字符串
        $(this).text($(this).text().substring(0,maxwidth));
        //多余的用省略号显示
        $(this).html($(this).html()+'...');
    }
});
$('.section .section-middle > div .left-content > div p').each(function(){
 //设置显示获取字符串的字数  这个根绝要求 看需要大概显示几行
    if ($(window).width() > 1200){
    	var maxwidth=45;
    }else if ($(window).width()  <= 1200 && $(window).width()  > 520){
     	var maxwidth=45;
    }else{
    	var maxwidth=20;
    }
    if($(this).text().length>maxwidth){
         //截取字符串
        $(this).text($(this).text().substring(0,maxwidth));
        //多余的用省略号显示
        $(this).html($(this).html()+'...');
    }
});
$('.section .section-middle > div .left-content > div > div > div:nth-child(2) p:nth-child(1)').each(function(){
 //设置显示获取字符串的字数  这个根绝要求 看需要大概显示几行
    if ($(window).width() > 1200){
    	var maxwidth=20;
    }else if ($(window).width()  <= 1200 && $(window).width()  >992){
     	var maxwidth=12;
    }else if ($(window).width()  <= 992 && $(window).width()  >= 768){
     	var maxwidth=10;
    }else if($(window).width() < 768 && $(window).width() >= 578){
    	var maxwidth=160;
    }else if ($(window).width() < 578 && $(window).width() >= 400){
     	var maxwidth=50;
    }else{
    	var maxwidth=18;
    }
    if($(this).text().length>maxwidth){
         //截取字符串
        $(this).text($(this).text().substring(0,maxwidth));
        //多余的用省略号显示
        $(this).html($(this).html()+'...');
    }
});
$('.section .section-right > div > div > div:nth-child(2) p').each(function(){
 //设置显示获取字符串的字数  这个根绝要求 看需要大概显示几行
    if ($(window).width() > 1200){
    	var maxwidth=150;
    }else if ($(window).width()  <= 1200 && $(window).width()  >= 992){
     	var maxwidth=100;
    }else if($(window).width() <= 991 && $(window).width() >= 768){
    	var maxwidth=60;
    }else if($(window).width() < 768 && $(window).width() >= 578){
    	var maxwidth=150;
    }else if ($(window).width() < 578 && $(window).width() >=500){
     	var maxwidth=80;
    }else if ($(window).width() < 500 && $(window).width() >=375){
     	var maxwidth=40;
    }else if ($(window).width() < 340){
     	var maxwidth=20;
    }else{
    	var maxwidth=20;
    }
    if($(this).text().length>maxwidth){
         //截取字符串
        $(this).text($(this).text().substring(0,maxwidth));
        //多余的用省略号显示
        $(this).html($(this).html()+'...');
    }
});