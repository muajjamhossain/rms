<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>Order Your Food</title>
    <meta name="description" content="Title">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    
    <!-- ====== Fonts start ====== -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400&display=swap" rel="stylesheet">
    <!-- ====== Fonts end ====== -->

    <!-- ====== main style start ====== -->
    <link rel="shortcut icon" href="{{ asset('contents/front-end/layout1') }}/images/logo/favicon.png">
    <link rel="stylesheet" href="{{ asset('contents/front-end/layout1') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('contents/front-end/layout1') }}/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('contents/front-end/layout1') }}/css/vegas.min.css">
    <link rel="stylesheet" href="{{ asset('contents/front-end/layout1') }}/css/csshake.min.css">
    <link rel="stylesheet" href="{{ asset('contents/front-end/layout1') }}/css/style.css">
    <style>
        #navbar-main {
            padding: 0px;
        }
        #Main-menu-part {
            padding-top: 50px;
        }
        @media print {
        * {
            -webkit-print-color-adjust: exact !important; /*Chrome, Safari */
            color-adjust: exact !important;  /*Firefox*/
          }
        }
    </style>
    <!-- ====== main style end ====== -->
    <script src="{{ asset('contents/front-end/layout1') }}/js/jquery-3.3.1.min.js"></script>
</head>

<body>
    
<section id="navbar-main" class="fixed-top banner-sticky-top">
    <div class="container pl-lg-0 pr-lg-0">
        <nav class="navbar navbar-expand-lg">
            
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
                        <a href="#" class="nav-link" onclick="printme()"><i class="fa fa-print"></i></a>
                    </li> 
                </ul>
            </div>
        </nav>
    </div>
</section>
<!-- ====== Navbar End ====== -->

<!-- ====== Main-menu-part ====== -->
<div id="print-section">
    <section id="Main-menu-part">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 m-auto">
                    <div class="white-trans" style="background: rgba(255,255,255,0.5); padding: 30px 20px;">
                        <div class="menu-heading">
                            @if(is_null($restaurant->logo))
                            <img src="{{ asset('contents/front-end/layout1') }}/images/logo/menu-logo.png" alt="Logo" class="img-fluid" style="max-width: 120px">
                            @else
                            <img src="{{ asset('uploads/logos/'.$restaurant->logo) }}" alt="Logo" class="img-fluid" style="max-width: 120px">
                            @endif
                            <h1>{{ $restaurant->name }}</h1>
                            <h2>{!! $restaurant->menu_heading !!}</h2>
                        </div>
                        <div class="qrcode text-center">
                            {!! QrCode::size(500)->generate(url('menu/'.$restaurant->url)); !!}
                        </div>
                        {{-- <p class="text-center" style="margin-top: 30px; color: #fff">Triva IT Ltd.</p> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- ====== Main-menu-part ====== -->
    <!-- ====== JS link Start ====== -->
    <script src="{{ asset('contents/front-end/layout1') }}/js/popper.min.js"></script>
    <script src="{{ asset('contents/front-end/layout1') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('contents/front-end/layout1') }}/js/vegas.js"></script>
    <script src="{{ asset('contents/front-end/layout1') }}/js/custom.js"></script>
    
    <script>
        function printme() {
            var printContents = document.getElementById('print-section').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
        $(document).ready(function(){
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
    </script>
    <!-- ====== JS link End ====== -->
</body>
</html>