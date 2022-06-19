$(window).resize(function(){ 
    $(".mydiv").css({ 
        position: "absolute", 
        left: ($(window).width() - $(".mydiv").outerWidth())/2, 
        top: ($(window).height() - $(".mydiv").outerHeight())/2 
    });
});