<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>Order Your Food</title>
    <meta name="description" content="Title">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    
    <!-- ====== Fonts start ====== -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400&display=swap" rel="stylesheet">
    <!-- ====== Fonts end ====== -->

    <!-- ====== main style start ====== -->
    <link rel="shortcut icon" href="{{ asset('contents/front-end') }}/images/logo/favicon.png">
    <link rel="stylesheet" href="{{ asset('contents/front-end') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('contents/front-end') }}/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('contents/front-end') }}/css/animate.css">
    <link rel="stylesheet" href="{{ asset('contents/front-end') }}/css/venobox.min.css">
    <link rel="stylesheet" href="{{ asset('contents/front-end') }}/css/vegas.min.css">
    <link rel="stylesheet" href="{{ asset('contents/front-end') }}/css/csshake.min.css">
    <link rel="stylesheet" href="{{ asset('contents/front-end') }}/css/style.css">
    <!-- ====== main style end ====== -->
</head>

<body>
<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->
<!-- ====== Navbar Start ====== -->
<section id="navbar-main" class="fixed-top banner-sticky-top">
    <div class="container pl-lg-0 pr-lg-0">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand logo-main-top" href=""><img src="{{ asset('uploads/logos/'.$restaurant->logo) }}" alt="Logo" class="img-fluid"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-ico">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto" id="myDIV">
                    <li class="nav-item active">
                        <a class="nav-link smooth-s">Menu <span class="sr-only">(current)</span></a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link smooth-s" href="">Menu</a>
                    </li> --}}
                    <!--<li class="nav-item">
                        <a class="nav-link smooth-s" href="#">More</a>
                    </li>
                    <li class="nav-item">
                        <div class="blink-bg-menu">
                            <a class="nav-link smooth-s" href="#"><img src="{{ asset('contents/front-end') }}/images/icon/cart.png" alt="cart-icon" class="img-fluid"></a>
                        </div>
                    </li>-->
                    <li class="nav-item">
                        <div class="nav-link">

                            <!--  THIS WRAPPER NEEDS TO EXIST IN ORDER TO SEND THE MARKUP TO GOOGLE -->
                            <div class="wrap-a">
                                <div id="google_translate_element"></div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</section>
<!-- ====== Navbar End ====== -->

<!-- ====== Main-menu-part ====== -->
<section id="Main-menu-part">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="container-box-main">
                    <div class="container-box">
                        <div class="menu-heading">
                            <img src="{{ asset('contents/front-end') }}/images/logo/menu-logo.png" alt="piv" class="img-fluid">
                            <h2>{!! $restaurant->menu_heading !!}</h2>
                        </div>
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            {{-- <li class="nav-item tab-item ml-0">
                                <a class="nav-link btn tab-btn active" id="pills-breakfast-tab" data-toggle="pill" href="#pills-breakfast" role="tab" aria-controls="pills-breakfast" aria-selected="true">BREAKFAST</a>
                            </li> --}}
                            @php $first = 1 @endphp
                            @foreach($restaurant->categoryInfo as $category)
                                <li class="nav-item tab-item">
                                    <a class="nav-link btn tab-btn {{ $first == 1 ? 'active' : '' }}" id="pills-{{ str_slug($category->name) }}-tab" data-toggle="pill" href="#pills-{{ str_slug($category->name) }}" role="tab" aria-controls="pills-{{ str_slug($category->name) }}" aria-selected="false">{{ Str::upper($category->name) }}</a>
                                </li>
                                @php $first++ @endphp
                            @endforeach
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            @php $first = 0 @endphp
                            @forelse($restaurant->categoryInfo as $category)
                                <div class="tab-pane fade {{ $first == 0 ? 'active show' : '' }}" id="pills-{{ str_slug($category->name) }}" role="tabpanel" aria-labelledby="pills-{{ str_slug($category->name) }}-tab">
                                    <div class="main-menu-box-wrap">
                                        <div class="row">
                                            @foreach($restaurant->menuInfo as $menu)
                                                @if($menu->cate_id == $category->id)
                                                    <div class="col-lg-6 col-md-10 m-auto food-box{{ $first == 0 ? '' : $first }}">
                                                        <div class="main-menu-box-sub shake-trigger">
                                                            @if($restaurant->menu_image_display == 1)
                                                                <div class="main-menu-box main-menu-box-pic">
                                                                    <img src="{{ asset('uploads/foods/'.$menu->photo) }}" alt="pic" class="img-fluid shake-little">
                                                                </div>
                                                            @endif
                                                            <div class="main-menu-box main-menu-box-text" style="width: {{ $restaurant->menu_image_display == 1 ? '': '100%' }}">
                                                                <div class="main-menu-box-heading">
                                                                    <h4>{{ $menu->name }}</h4>
                                                                    <span>€ {{ $menu->price }}</span>
                                                                </div>
                                                                <p>{{ $menu->description }}</p>
                                                                {{-- <a href="#" class="btn shake-little"><img src="{{ asset('contents/front-end') }}/images/icon/cart-small.png" alt="pic" class="img-fluid"> Add to Cart</a> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                            <a id="load-more" class="top-mouse smooth-s"><span></span></a>
                                        </div>
                                    </div>
                                </div>
                                @php $first++ @endphp
                            @empty
                                <h5 style="text-align: center; color: #fff">No item is added</h5>
                            @endforelse
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ====== Main-menu-part ====== -->

<!-- ====== Footer-part ====== -->
<section id="footer-part">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="footer-box">
                    <img src="{{ asset('uploads/logos/'.$restaurant->logo) }}" alt="pic" class="img-fluid" style="height: 50px; width: 50px">
                    {{-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Totam et ea, excepturi, repellat fuga cumque!</p> --}}
                </div>
            </div>
            <div class="col-lg-5 m-auto">
                {{-- <div class="footer-box text-center">
                    <h3>SUBSCRIBE TO OUR NEWSLETTER</h3>
                    <div class="subscribe">
                        <form role="form" action="" method="post" id="sub-form">
                            <input type="email" id="sub-email" class="form-control" placeholder="Enter your email here">
                            <button type="submit" id="submit" class="footer-btn">SUBSCRIBE</button>
                        </form>
                    </div>
                </div> --}}
            </div>
            <div class="col-lg-3 m-auto">
                <div class="footer-box pt-4">
                    <p class="pt-0">Copyright &copy; 2020 by <a href="https://www.euroweboss.com/">EuroWebOss</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ====== Footer-part ====== -->

<a class="top-up smooth-s" href="#banner-main">
    <i class="fas fa-chevron-up"></i>
</a>
    <!-- ====== JS link Start ====== -->
    <script src="{{ asset('contents/front-end') }}/js/jquery-3.3.1.min.js"></script>
    <script src="{{ asset('contents/front-end') }}/js/popper.min.js"></script>
    <script src="{{ asset('contents/front-end') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('contents/front-end') }}/js/wow.min.js"></script>
    <script src="{{ asset('contents/front-end') }}/js/tilt.jquery.min.js"></script>
    <script src="{{ asset('contents/front-end') }}/js/sweetalert.min.js"></script>
    <script src='https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit&languages=en,es'></script>
    <script src='{{ asset('contents/front-end') }}/js/translate.js'></script>
    <script src="{{ asset('contents/front-end') }}/js/venobox.min.js"></script>
    <script src="{{ asset('contents/front-end') }}/js/vegas.js"></script>
    <script src="{{ asset('contents/front-end') }}/js/custom.js"></script>
    
    <script>
        $("#submit").click(function() {
            $('#sub-form').on('submit', function(e){
                e.preventDefault(); 
                var email = $("#sub-email").val();
                if (email == ''){
                    swal({
                        title: "Field is empty!!!",
                        text: "Please enter your email here!",
                        icon: "warning",
                        button: "Try Again"
                    });
                } else {
                    swal({
                        title: "Succcess",
                        text: "Email has been subscribed!",
                        icon: "success",
                        button: "Okay"
                    });
                }
            });
        });
    </script>
    <script>
        $('.js-tilt').tilt({
            scale: 1
        })
    </script>
    <script>
        $(document).ready(function(){
            $('body').scrollspy({target: ".navbar", offset: 40});
            $('#Main-menu-part').vegas({
                overlay: true,
                shuffle: true,
                firstTransition: 'fade',
                firstTransitionDuration: 15000,
                transition: 'fade2',
                slidesToKeep: 1,
                transitionDuration: 4000,
                delay: 12000,
                color: '#000',
                animation: 'random',
                animationDuration: 20000,
                slides: [
                    {src: '{{ asset('contents/front-end') }}/images/main-menu-bg.jpg', transition: "fade2", valign: "60%"},
                    {src: '{{ asset('contents/front-end') }}/images/main-menu-bg1.jpg', transition: "zoomOut"},
                    {src: '{{ asset('contents/front-end') }}/images/main-menu-bg2.jpg', transition: "zoomOut"},
                    {src: '{{ asset('contents/front-end') }}/images/main-menu-bg3.jpg', transition: "blur2", valign: "50%"},
                    {src: '{{ asset('contents/front-end') }}/images/main-menu-bg4.jpg', transition: "fade2"},
                    {src: '{{ asset('contents/front-end') }}/images/main-menu-bg5.jpg', transition: "swirlLeft2", valign: "50%"},
                    {src: '{{ asset('contents/front-end') }}/images/main-menu-bg6.jpg', transition: "fade2"}
                ]
            });

            @php $num = 0 @endphp
            @foreach($restaurant->categoryInfo as $category)
                $(function () {
                    $(".food-box{{ $num == 0 ? '' : $num }}")
                        .slice(0, 4)
                        .show();
                    $("#load-more{{ $num == 0 ? '' : $num }}").on("click", function (e) {
                        e.preventDefault();
                        $(".food-box{{ $num == 0 ? '' : $num }}:hidden")
                            .slice(0, 2)
                            .slideDown();
                        if ($(".food-box{{ $num == 0 ? '' : $num }}:hidden").length == 0) {
                            $("#load-more{{ $num == 0 ? '' : $num }}").fadeOut("slow");
                        }
                        $("html,body").animate({
                                scrollTop: $(this).offset().top
                            },
                            1500
                        );
                    });
                });
                @php $num++ @endphp
            @endforeach   
        });
    </script>
    <!-- ====== JS link End ====== -->
</body>
</html>