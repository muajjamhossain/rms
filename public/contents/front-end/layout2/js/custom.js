$(document).ready(function () {
    //navbar
    $(window).scroll(function(){
        var scrolling = $(this).scrollTop();
        var sticky = $(".banner-sticky-top");
        if(scrolling >=120){
            sticky.addClass("banner-manu-black");
        }
        else{
            sticky.removeClass("banner-manu-black");
        }
    });

    //smooth-scroll
    $("a.smooth-s").on("click", function () {
        if (location.pathname.replace(/^\//, "") === this.pathname.replace(/^\//, "") && location.hostname === this.hostname) {
            var e = $(this.hash);
            if ((e = e.length ? e : $("[name=" + this.hash.slice(1) + "]")).length) return $("html, body").animate({
                scrollTop: e.offset().top
            }, 1e3), !1
        }
    })
    
    //top-up-scroll
    $(window).scroll(function () {
        $(this).scrollTop() > 100 ? $(".top-up").fadeIn() : $(".top-up").fadeOut()
    }),
    $(".top-up").click(function () {
        $("html, body").animate({
            scrollTop: 0
        })
    });
});
