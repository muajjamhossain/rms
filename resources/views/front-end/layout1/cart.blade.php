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
    <link href="{{asset('contents/admin')}}/assets/css/parsley.css" rel="stylesheet" type="text/css" />
    <!-- ====== main style start ====== -->
    <link rel="shortcut icon" href="{{ asset('contents/front-end/layout1') }}/images/logo/favicon.png">
    <link rel="stylesheet" href="{{ asset('contents/front-end/layout1') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('contents/front-end/layout1') }}/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('contents/front-end/layout1') }}/css/vegas.min.css">
    <link rel="stylesheet" href="{{ asset('contents/front-end/layout1') }}/css/csshake.min.css">
    <link rel="stylesheet" href="{{ asset('contents/front-end/layout1') }}/css/style.css">
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
            @if(is_null($restaurant->logo))
            <a class="navbar-brand logo-main-top" href=""><img src="{{ asset('contents/front-end/layout1') }}/images/logo/menu-logo.png" alt="Logo" class="img-fluid"></a>
            @else
            <a class="navbar-brand logo-main-top" href=""><img src="{{ asset('uploads/logos/'.$restaurant->logo) }}" alt="Logo" class="img-fluid"></a>
            @endif
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-ico">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto" id="myDIV">
                    <li class="nav-item {{ Request::is('menu/'.$restaurant->url) ? 'active' : ''}}">
                        <a class="nav-link" href="{{ url('menu/'.$restaurant->url) }}">Dine In</a>
                    </li>
                    
                    <li class="nav-item {{ Request::is('menu/takeaway/'.$restaurant->url) ? 'active' : ''}}">
                        <a class="nav-link" href="{{ url('menu/takeaway/'.$restaurant->url) }}">Takeaway</a>
                    </li>
                    <li class="nav-item {{ Request::is('menu/'.$restaurant->url.'/cart') ? 'active' : ''}}">
                        <div class="blink-bg-menu">
                            <a class="nav-link cart-link" href="{{ url('menu/'.$restaurant->url.'/cart') }}"><img src="{{ asset('contents/front-end/layout1') }}/images/icon/cart.png" alt="cart-icon" class="img-fluid">
                            <span id="cart-contents">{{ Cart::content()->count() }}</span>
                            </a>
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
                            @if(is_null($restaurant->logo))
                            <img src="{{ asset('contents/front-end/layout1') }}/images/logo/menu-logo.png" alt="Logo" class="img-fluid">
                            @else
                            <img src="{{ asset('uploads/logos/'.$restaurant->logo) }}" alt="Logo" class="img-fluid" style="max-width: 200px">
                            @endif
                            <h2><span>Customer</span>&nbsp;Cart</h2>
                        </div>
                        <div class="row" id="cart-items">
                        	
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
                    @if(is_null($restaurant->logo))
                    <img src="{{ asset('contents/front-end/layout1') }}/images/logo/menu-logo.png" alt="Logo" class="img-fluid" style="width: 100px">
                    @else
                    <img src="{{ asset('uploads/logos/'.$restaurant->logo) }}" alt="Logo" class="img-fluid" style="width: 100px">
                    @endif
                </div>
            </div>
            <div class="col-lg-5 m-auto">
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
    <script src="{{ asset('contents/front-end/layout1') }}/js/jquery-3.3.1.min.js"></script>
    <script src="{{ asset('contents/admin')}}/assets/js/parsley.min.js"></script>
    <script src="{{ asset('contents/front-end/layout1') }}/js/popper.min.js"></script>
    <script src="{{ asset('contents/front-end/layout1') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('contents/front-end/layout1') }}/js/sweetalert.min.js"></script>
    <script src="{{ asset('contents/front-end/layout1') }}/js/vegas.js"></script>
    <script src="{{ asset('contents/front-end/layout1') }}/js/custom.js"></script>
    
    <script>
        $(document).ready(function(){
            $.get('{{ url('loadCart/'.$restaurant->id) }}', function(data){
                $('#cart-items').empty().append(data);
            });

            this.deleteItem = function(id){
                $.get('{{ url('deleteCartItem/'.$restaurant->id) }}/'+id, function(data){
                    $('#cart-items').empty().append(data);
                });
            }

            this.updateQty = function(id, action){
                $.get('{{ url('updateQty/'.$restaurant->id) }}/'+id+'/'+action, function(data){
                    $('#cart-items').empty().append(data);
                });
            }

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
                    {src: '{{ asset('contents/front-end/layout1') }}/images/main-menu-bg.jpg', transition: "fade2", valign: "60%"},
                    {src: '{{ asset('contents/front-end/layout1') }}/images/main-menu-bg1.jpg', transition: "zoomOut"},
                    {src: '{{ asset('contents/front-end/layout1') }}/images/main-menu-bg2.jpg', transition: "zoomOut"},
                    {src: '{{ asset('contents/front-end/layout1') }}/images/main-menu-bg3.jpg', transition: "blur2", valign: "50%"},
                    {src: '{{ asset('contents/front-end/layout1') }}/images/main-menu-bg4.jpg', transition: "fade2"},
                    {src: '{{ asset('contents/front-end/layout1') }}/images/main-menu-bg5.jpg', transition: "swirlLeft2", valign: "50%"},
                    {src: '{{ asset('contents/front-end/layout1') }}/images/main-menu-bg6.jpg', transition: "fade2"}
                ]
            });
        });

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
    <!-- ====== JS link End ====== -->
</body>
</html>