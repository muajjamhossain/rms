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
    });
    
    //top-up-scroll
    $(window).scroll(function () {
        $(this).scrollTop() > 100 ? $(".top-up").fadeIn() : $(".top-up").fadeOut()
    }),
    $(".top-up").click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 2e3)
    });
    
    // Load More Script
    $(function () {
        $(".food-box")
            .slice(0, 4)
            .show();
        $("#load-more").on("click", function (e) {
            e.preventDefault();
            $(".food-box:hidden")
                .slice(0, 2)
                .slideDown();
            if ($(".food-box:hidden").length == 0) {
                $("#load-more").fadeOut("slow");
            }
            $("html,body").animate({
                    scrollTop: $(this).offset().top
                },
                1500
            );
        });
    });
//    $(function () {
//        $(".food-box1")
//            .slice(0, 4)
//            .show();
//        $("#load-more1").on("click", function (e) {
//            e.preventDefault();
//            $(".food-box1:hidden")
//                .slice(0, 2)
//                .slideDown();
//            if ($(".food-box1:hidden").length == 0) {
//                $("#load-more1").fadeOut("slow");
//            }
//            $("html,body").animate({
//                    scrollTop: $(this).offset().top
//                },
//                1500
//            );
//        });
//    });
//    $(function () {
//        $(".food-box2")
//            .slice(0, 4)
//            .show();
//        $("#load-more2").on("click", function (e) {
//            e.preventDefault();
//            $(".food-box2:hidden")
//                .slice(0, 2)
//                .slideDown();
//            if ($(".food-box2:hidden").length == 0) {
//                $("#load-more2").fadeOut("slow");
//            }
//            $("html,body").animate({
//                    scrollTop: $(this).offset().top
//                },
//                1500
//            );
//        });
//    });
//    $(function () {
//        $(".food-box3")
//            .slice(0, 4)
//            .show();
//        $("#load-more3").on("click", function (e) {
//            e.preventDefault();
//            $(".food-box3:hidden")
//                .slice(0, 2)
//                .slideDown();
//            if ($(".food-box3:hidden").length == 0) {
//                $("#load-more3").fadeOut("slow");
//            }
//            $("html,body").animate({
//                    scrollTop: $(this).offset().top
//                },
//                1500
//            );
//        });
//    });
//    $(function () {
//        $(".food-box4")
//            .slice(0, 4)
//            .show();
//        $("#load-more4").on("click", function (e) {
//            e.preventDefault();
//            $(".food-box4:hidden")
//                .slice(0, 2)
//                .slideDown();
//            if ($(".food-box4:hidden").length == 0) {
//                $("#load-more4").fadeOut("slow");
//            }
//            $("html,body").animate({
//                    scrollTop: $(this).offset().top
//                },
//                1500
//            );
//        });
//    });
});