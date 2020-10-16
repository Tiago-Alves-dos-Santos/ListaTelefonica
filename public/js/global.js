$(function(){
    //load das paginas
    $(window).bind('load',function(e){
        setTimeout(function () {
            $("#load-page").fadeOut(1000);
        }, 1000);
    });
    //esconder loads de btn forms
    $(".img-load-form").hide();
});
