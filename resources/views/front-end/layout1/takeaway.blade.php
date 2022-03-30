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
    {{-- <link rel="stylesheet" href="{{ asset('contents/front-end/layout1') }}/css/animate.css"> --}}
    <link href="{{asset('contents/admin')}}/plugins/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('contents/front-end/layout1') }}/css/vegas.min.css">
    <link rel="stylesheet" href="{{ asset('contents/front-end/layout1') }}/css/csshake.min.css">
    <link rel="stylesheet" href="{{ asset('contents/front-end/layout1') }}/css/style.css">
    <!-- ====== main style end ====== -->
    <script src="{{ asset('contents/front-end/layout1') }}/js/jquery-3.3.1.min.js"></script>
    <script src="{{asset('contents/admin')}}/plugins/sweetalert2/sweetalert2.min.js"></script>
</head>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
</script>
<body>
    @if(Session::has('success'))
    <script>
        
        Toast.fire({
          icon: 'success',
          title: 'Order successfully placed'
        })
    </script>
    @endif
    @if(Session::has('error'))
    <script>
        Toast.fire({
          icon: 'error',
          title: 'Something went wrong'
        })
    </script>
    @endif
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
                    
                    @if($restaurant->menu_categorised == 2)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Menu List
                        </a>
                        <ul class="nav nav-pills dropdown-menu mobilShow" id="pills-tab" aria-labelledby="navbarDropdown" role="tablist">
                            <li class="dropdown-item">
                                <a class="nav-link-drop active" id="pills-all-tab" data-toggle="pill" href="#pills-all" role="tab" aria-controls="pills-all" aria-selected="true">ALL</a>
                            </li>
                            @foreach($restaurant->categoryInfo as $category)
                                @if($category->status == 1 && takeaway_menu($category->categoryMenu))
                                    @if(!$category->categoryMenu->isEmpty())
                                        <li class="dropdown-item">
                                            <a class="nav-link-drop" id="pills-{{ str_slug($category->name) }}-tab" data-toggle="pill" href="#pills-{{ str_slug($category->name) }}" role="tab" aria-controls="pills-{{ str_slug($category->name) }}" aria-selected="true">{{ Str::upper($category->name) }}</a>
                                        </li>
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                    </li>
                    @endif
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
                            <h1>{{ $restaurant->name }}</h1>
                            <h2>{!! $restaurant->menu_heading !!}</h2>
                        </div>
                        @if($restaurant->menu_categorised == 1)
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item tab-item ml-0">
                                <a class="nav-link btn tab-btn active" id="pills-all-tab" data-toggle="pill" href="#pills-all" role="tab" aria-controls="pills-all" aria-selected="true">ALL</a>
                            </li>
                            @foreach($restaurant->categoryInfo as $category)
                                @if($category->status == 1 && takeaway_menu($category->categoryMenu))
                                    @if(!$category->categoryMenu->isEmpty())
                                        <li class="nav-item tab-item">
                                            <a class="nav-link btn tab-btn" id="pills-{{ str_slug($category->name) }}-tab" data-toggle="pill" href="#pills-{{ str_slug($category->name) }}" role="tab" aria-controls="pills-{{ str_slug($category->name) }}" aria-selected="false">{{ Str::upper($category->name) }}</a>
                                        </li>
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                        @endif
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                                <div class="main-menu-box-wrap">
                                    <div class="main-menu-box-wrap-heading">
                                        <h3>All Items</h3>
                                    </div>
                                    <div class="row">
                                        @foreach($restaurant->menuInfo as $menu)
                                            @if($menu->menuCategory->status == 1)
                                                @if($menu->status == 1 && $menu->takeaway_service == 1)
                                                    <div class="col-lg-6 col-md-10 m-auto food-box food-box-dp">
                                                        <div class="main-menu-box-sub shake-trigger">
                                                            @if($restaurant->menu_image_display == 1)
                                                                <div class="main-menu-box main-menu-box-pic">
                                                                    <img src="{{ asset('uploads/foods/'.$menu->photo) }}" alt="pic" class="img-fluid shake-little">
                                                                </div>
                                                            @endif
                                                            <div class="main-menu-box main-menu-box-text" style="width: {{ $restaurant->menu_image_display == 1 ? '': '100%' }}">
                                                                <div class="main-menu-box-heading">
                                                                    <h4>{{ $menu->name }}</h4>
                                                                    <span>{{ $restaurant->currency_symbol }} {{ $menu->price }}</span>
                                                                </div>
                                                                <p>{{ $menu->description }}</p>
                                                                <a onClick="addCart({{ $menu->id }})" class="btn shake-little"><img src="{{ asset('contents/front-end/layout1') }}/images/icon/cart-small.png" alt="pic" class="img-fluid"> Add to Cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
                                        <a id="load-more" class="top-mouse smooth-s"><span></span></a>
                                    </div>
                                </div>
                            </div>
                            @php $first = 1 @endphp
                            @forelse($restaurant->categoryInfo as $category)
                                @if($category->status == 1)
                                    <div class="tab-pane fade" id="pills-{{ str_slug($category->name) }}" role="tabpanel" aria-labelledby="pills-{{ str_slug($category->name) }}-tab">
                                        <div class="main-menu-box-wrap">
                                            <div class="main-menu-box-wrap-heading">
                                                <h3>{{ ucfirst($category->name) }} Items</h3>
                                            </div>
                                            <div class="row">
                                                @foreach($category->categoryMenu as $menu)
                                                    @if($menu->status == 1 && $menu->takeaway_service == 1)
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
                                                                        <span>{{ $restaurant->currency_symbol }} {{ $menu->price }}</span>
                                                                    </div>
                                                                    <p>{{ $menu->description }}</p>
                                                                    <a onClick="addCart({{ $menu->id }})" class="btn shake-little"><img src="{{ asset('contents/front-end/layout1') }}/images/icon/cart-small.png" alt="pic" class="img-fluid"> Add to Cart</a>
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
                                @endif
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
                    @if(is_null($restaurant->logo))
                    <img src="{{ asset('contents/front-end/layout1') }}/images/logo/menu-logo.png" alt="Logo" class="img-fluid" style="width: 100px">
                    @else
                    <img src="{{ asset('uploads/logos/'.$restaurant->logo) }}" alt="Logo" class="img-fluid" style="width: 100px">
                    @endif
                    {{-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Totam et ea, excepturi, repellat fuga cumque!</p> --}}
                </div>
            </div>
            <div class="col-lg-5 m-auto">
                {{-- <div class="footer-box text-center">
                    <h3>Join The NEWSLETTER</h3>
                    <div class="subscribe">
                        <form role="form" action="" method="post" id="sub-form">
                            <input type="email" id="sub-email" class="form-control" placeholder="Enter your email here">
                            <button type="submit" id="submit" class="footer-btn">Ok! I'm In</button>
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
    <script src="{{ asset('contents/front-end/layout1') }}/js/popper.min.js"></script>
    <script src="{{ asset('contents/front-end/layout1') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('contents/front-end/layout1') }}/js/vegas.js"></script>
    <script src="{{ asset('contents/front-end/layout1') }}/js/custom.js"></script>
    
    <script>
        $(function(){
            this.addCart = function(id){
                $.get('{{ url('addCart') }}/'+id+'/'+2, function(data){
                    $('#cart-contents').empty().append(data);
                    Toast.fire({
                      icon: 'success',
                      title: 'Item Added successfully'
                    });
                });
            }
        });
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

        @php $num = 1 @endphp
        @foreach($restaurant->categoryInfo as $category)
            @if($category->status == 1 && takeaway_menu($category->categoryMenu))
                @if(!$category->categoryMenu->isEmpty())
                    $(function () {
                        $(".food-box{{ $num }}")
                            .slice(0, 4)
                            .show();
                        $("#load-more{{ $num }}").on("click", function (e) {
                            e.preventDefault();
                            $(".food-box{{ $num }}:hidden")
                                .slice(0, 2)
                                .slideDown();
                            if ($(".food-box{{ $num }}:hidden").length == 0) {
                                $("#load-more{{ $num }}").fadeOut("slow");
                            }
                            $("html,body").animate({
                                    scrollTop: $(this).offset().top
                                },
                                1500
                            );
                        });
                    });
                    @php $num++ @endphp
                @endif
            @endif
        @endforeach
    </script>
    <!-- ====== JS link End ====== -->
</body>
</html>