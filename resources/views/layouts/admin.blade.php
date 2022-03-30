<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Dashboard</title>
        <link rel="shortcut icon" href="{{asset('contents/admin')}}/assets/images/favicon_1.ico">
        <link href="{{asset('contents/admin')}}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('contents/admin')}}/assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('contents/admin')}}/assets/css/moltran.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('contents/admin')}}/plugins/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('contents/admin')}}/assets/css/tagsinput.css" rel="stylesheet" type="text/css" />
        @stack('css')
        <link href="{{asset('contents/admin')}}/assets/css/style.css" rel="stylesheet" type="text/css" />
        <script src="{{asset('contents/admin')}}/assets/js/modernizr.min.js"></script>
        <script src="{{asset('contents/admin')}}/assets/js/jquery.min.js"></script>
        <script src="{{asset('contents/admin')}}/plugins/sweetalert2/sweetalert2.min.js"></script>
        <script src="{{asset('contents/admin')}}/assets/js/tagsinput.js"></script>
        <script>
            window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]); !!};
        </script>
    </head>
    <body class="fixed-left">
        <div id="app">
            <div id="wrapper">
                <div class="topbar">
                    <div class="topbar-left">
                        <div class="text-center">
                            <a href="{{url('dashboard')}}" class="logo">
                                <img src="{{asset('contents/admin/assets/images/logo.png')}}" alt="logo-img" style="height: 50px">
                            </a>
                        </div>
                    </div>
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <ul class="list-inline menu-left mb-0">
                                <li class="float-left">
                                    <a href="#" class="button-menu-mobile open-left">
                                        <i class="fa fa-bars"></i>
                                    </a>
                                </li>
                                <li class="hide-phone float-left">
                                    <form role="search" class="navbar-form">
                                        <input type="text" placeholder="Type here for search..." class="form-control search-bar">
                                        <a href="#" class="btn btn-search"><i class="fa fa-search"></i></a>
                                    </form>
                                </li>
                            </ul>
                            <ul class="nav navbar-right float-right list-inline">
                                <li class="d-none d-sm-block">
                                    <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="md md-crop-free"></i></a>
                                </li>
                                <li class="dropdown open">
                                    <a href="#" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true"><img src="{{asset('uploads/users/'.App\User::where('id', auth()->user()->id)->first()->photo)}}" alt="user-img" class="rounded-circle"> </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('admin/settings')}}" class="dropdown-item"><i class="md md-settings-power mr-2"></i> Change Password</a></li>
                                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item"><i class="md md-settings-power mr-2"></i> Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="left side-menu">
                    <div class="sidebar-inner slimscrollleft">
                        <div class="user-details">
                            <div class="pull-left">
                            <img src="{{asset('uploads/users/'.App\User::where('id', auth()->user()->id)->first()->photo)}}" alt="" class="thumb-md rounded-circle">
                            </div>
                            <div class="user-info">
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-transform: capitalize;">
                                        {{auth()->user()->name}}
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('dashboard/profile')}}" class="dropdown-item"><i class="md md-face-unlock mr-2"></i> Profile<div class="ripple-wrapper"></div></a></li>
                                        <li><a href="{{url('admin/settings')}}" class="dropdown-item"><i class="md md-settings mr-2"></i> Settings</a></li>
                                        <li><a href="javascript:void(0)" class="dropdown-item"><i class="md md-lock mr-2"></i> Lock screen</a></li>
                                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item"><i class="md md-settings-power mr-2"></i> Logout</a></li>
                                    </ul>
                                </div>
                                <p class="text-muted m-0">{{'@ '.Auth::user()->userRole->role_name}}</p>
                            </div>
                        </div>
                        <div id="sidebar-menu">
                            <ul>
                                <li><a href="{{url('dashboard')}}" class="waves-effect"><i class="fa fa-home"></i><span> Dashboard </span></a></li>
                                @if(Auth::user()->role_id==1)
                                 
                                <li><a href="{{url('admin/client')}}" class="waves-effect"><i class="fa fa-users"></i><span> Clients </span></a></li>
                                <li><a href="{{url('admin/package')}}" class="waves-effect"><i class="fa fa-gift"></i><span> Packages </span></a></li>
                                <li><a href="#" class="waves-effect"><i class="fa fa-user"></i><span> Customer </span></a></li> 
                                @endif

                                @if(Auth::user()->role_id <= 3)
                                    <li><a href="{{url('admin/restaurant')}}" class="waves-effect"><i class="fa fa-cutlery"></i><span> Restaurants </span></a></li>
                                @endif
                                @if(Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                                <li class="has_sub">
                                    <a href="#" class="waves-effect"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span> Order </span><span class="pull-right"><i class="md md-add"></i></span></a>
                                    <ul class="list-unstyled">
                                        @if(Auth::user()->role_id == 3)
                                            <li><a href="{{ url('admin/create-order') }}">Create Order</a></li>
                                        @endif
                                        <li><a href="{{ url('admin/order-request') }}">Order Request</a></li>
                                        <li><a href="{{ url('admin/confirmed-order') }}">Confirm Order</a></li>
                                        <li><a href="{{url('admin/order-serve')}}">Serve Order</a></li>
                                        @if(Auth::user()->role_id == 3)
                                        <li><a href="{{url('admin/bill')}}" class="waves-effect"> Bill </a></li>
                                        @endif
                                        <li><a href="{{ url('admin/delivered-order') }}">Delivered Order</a></li>
                                        <li><a href="{{ url('admin/cancelled-order') }}">Cancelled Order</a></li>
                                        
                                    </ul>
                                </li>
                                @endif

                                 @if(Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                                <li class="has_sub">
                                    <a href="#" class="waves-effect"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span> Stock Product </span><span class="pull-right"><i class="md md-add"></i></span></a>
                                    <ul class="list-unstyled">
                                        <li class="nav-item"><a href="{{ route('category.add') }}" class="nav-link">Add Category</a></li>
                                        <li class="nav-item"><a href="{{ route('brand.add') }}" class="nav-link">Add Brand</a></li>
                                        <li class="nav-item"><a href="{{ route('size.add') }}" class="nav-link">Add Size</a></li>
                                    </ul>
                                </li>
                                 @endif

                                @if(Auth::user()->role_id == 4)
                                    <li id="request"><a href="{{url('admin/order-request')}}" class="waves-effect"><i class="fa fa-shopping-cart"></i><span> Order </span><order-request :userid="{{ Auth::user()->id }}"  :unreads="{{ auth()->user()->unreadNotifications }}"></order-request>
                                        <audio id="orderRequestNoty" muted>
                                            <source src="{{ asset('sounds/orderRequest/orderRequest.mp3') }}">
                                            <source src="{{ asset('sounds/orderRequest/orderRequest.ogg') }}">
                                            <source src="{{ asset('sounds/orderRequest/orderRequest.m4r') }}">
                                        </audio>
                                    </a></li>
                                    
                                    <li id="request"><a href="{{url('admin/order-serve')}}" class="waves-effect"><i class="fa fa-beer" aria-hidden="true"></i><span> Serve </span><serve-request :userid="{{ Auth::user()->id }}"  :unreads="{{ auth()->user()->unreadNotifications }}"></serve-request>
                                        <audio id="serveRequestNoty" muted>
                                            <source src="{{ asset('sounds/serveRequest/serveRequest.mp3') }}">
                                            <source src="{{ asset('sounds/serveRequest/serveRequest.ogg') }}">
                                            <source src="{{ asset('sounds/serveRequest/serveRequest.m4r') }}">
                                        </audio>
                                    </a></li>
                                @endif
                                @if(Auth::user()->role_id == 5)
                                <li><a href="{{ url('admin/confirmed-order') }}" class="waves-effect"><i class="fa fa-shopping-cart"></i><span> Order </span>
                                    <confirm-request :userid="{{ Auth::user()->id }}"  :unreads="{{ auth()->user()->unreadNotifications }}"></confirm-request>
                                        <audio id="confirmRequestNoty" muted>
                                            <source src="{{ asset('sounds/confirmOrder/confirmOrder.mp3') }}">
                                            <source src="{{ asset('sounds/confirmOrder/confirmOrder.ogg') }}">
                                            <source src="{{ asset('sounds/confirmOrder/confirmOrder.m4r') }}">
                                        </audio>
                                </a></li>
                                @endif
                                @if(Auth::user()->role_id == 2)
                                <li><a href="{{url('admin/statistics')}}" class="waves-effect"><i class="fa fa-bar-chart" aria-hidden="true"></i><span> Statistics</span></a></li>
                                @endif
                                @if(Auth::user()->role_id == 3)
                                    <li><a href="{{url('admin/incomes')}}" class="waves-effect"><i class="fa fa-plus-square" aria-hidden="true"></i><span> Income</span></a></li>
                                    <li><a href="{{url('admin/expense')}}" class="waves-effect"><i class="fa fa-minus-square" aria-hidden="true"></i><span> Expense</span></a></li>
                                    <!-- <li><a href="" class="waves-effect"><i class="fa fa-clock-o" aria-hidden="true"></i><span> Total Balance</span></a></li> -->
                                @endif
                               
                                @if(Auth::user()->role_id == 3 || Auth::user()->role_id == 2)
                                    <li><a href="{{url('admin/report')}}" class="waves-effect"><i class="fa fa-file-text-o" aria-hidden="true"></i><span> Report </span></a></li>
                                @endif
                                {{-- @if(Auth::user()->role_id<=4)
                                    <li class="has_sub">
                                        <a href="#" class="waves-effect"><i class="fa fa-cog"></i><span> Manage </span><span class="pull-right"><i class="md md-add"></i></span></a>
                                        <ul class="list-unstyled">
                                            <li><a href="#">Basic Information</a></li>
                                            <li><a href="#">Social Media</a></li>
                                            <li><a href="#">Contact Information</a></li>
                                        </ul>
                                    </li>
                                @endif
                                <li><a href="{{url('dashboard/recycle')}}" class="waves-effect"><i class="fa fa-trash"></i><span>Recycle Bin </span></a></li> --}}
                                {{-- <li><a href="{{url('admin/settings')}}" class="waves-effect"><i class="fa fa-cog" aria-hidden="true"></i><span> Settings </span></a></li> --}}
                                <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="waves-effect"><i class="fa fa-power-off"></i><span> Logout</span></a></li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="content-page">
                    <div class="content">
                        <div class="container-fluid">
                            @yield('content')
                        </div>
                    </div>
                    <footer class="footer">
                        Copyright © 2021 by <a target="_blank" href="https://www.beatbugsit.com/">BeatBugs IT</a>.
                    </footer>
                </div>
            </div>
        </div>
        
        <script src="{{ mix('js/app.js') }}"></script>
        <script>
        var resizefunc = [];
        </script>
        <script src="{{asset('contents/admin')}}/assets/js/bootstrap.bundle.min.js"></script>
        <script src="{{asset('contents/admin')}}/assets/js/detect.js"></script>
        <script src="{{asset('contents/admin')}}/assets/js/fastclick.js"></script>
        <script src="{{asset('contents/admin')}}/assets/js/jquery.slimscroll.js"></script>
        <script src="{{asset('contents/admin')}}/assets/js/jquery.blockUI.js"></script>
        <script src="{{asset('contents/admin')}}/assets/js/waves.js"></script>
        <script src="{{asset('contents/admin')}}/assets/js/wow.min.js"></script>
        <script src="{{asset('contents/admin')}}/assets/js/jquery.nicescroll.js"></script>
        <script src="{{asset('contents/admin')}}/assets/js/jquery.scrollTo.min.js"></script>
        <script src="{{asset('contents/admin')}}/plugins/moment/moment.min.js"></script>
        <script src="{{asset('contents/admin')}}/plugins/waypoints/lib/jquery.waypoints.js"></script>
        <script src="{{asset('contents/admin')}}/plugins/counterup/jquery.counterup.min.js"></script>
        <script src="{{asset('contents/admin')}}/assets/pages/jquery.todo.js"></script>
        {{-- <script src="{{asset('contents/admin')}}/assets/pages/jquery.dashboard.js"></script> --}}
        <script src="{{asset('contents/admin')}}/assets/js/jquery.app.js"></script>
        @stack('js')
        <script src="{{asset('contents/admin')}}/assets/js/custom.js"></script>




        <script>
         @if(Session::has('message'))
            var type ="{{Session::get('alert-type','info')}}"
            switch(type){
                case 'info':
                    toastr.info(" {{Session::get('message')}} ");
                    break;

                case 'success':
                    toastr.success(" {{Session::get('message')}} ");
                    break;

                case 'warning':
                    toastr.warning(" {{Session::get('message')}} ");
                    break;

                case 'error':
                    toastr.error(" {{Session::get('message')}} ");
                    break;
            }
        @endif
    </script>




<script type="text/javascript">
      $.ajaxSetup({
          headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
          }
      });

        // Category Wise Brand
        $(document).ready(function() {
          $('select[name="CategoryID"]').on('change', function(){
              var CategoryID = $(this).val();
              if(CategoryID) {
                  $.ajax({
                      url: "{{ route('Category-wise-Brand') }}",
                      type:"POST",
                      dataType:"json",
                      data: { CategoryID:CategoryID },
                      success:function(data) {
                         if(data == ""){
                           $('#BranId_val[name="BranID"]').empty();
                           $('#BranId_val[name="BranID"]').append('<option value="">Data Not Found! </option>');
                           $('#SizeId_val[name="SizeID"]').empty();
                           $('#SizeId_val[name="SizeID"]').append('<option value="">Data Not Found!</option>');
                           $('#ThicId_val[name="ThicID"]').empty();
                           $('#ThicId_val[name="ThicID"]').append('<option value="">Data Not Found!</option>');

                         }else{
                           $('#BranId_val[name="BranID"]').empty();
                           $('#BranId_val[name="BranID"]').append('<option value="">Select Brand</option>');
                           $('#SizeId_val[name="SizeID"]').empty();
                           $('#SizeId_val[name="SizeID"]').append('<option value="">Select Size</option>');
                           $('#ThicId_val[name="ThicID"]').empty();
                           $('#ThicId_val[name="ThicID"]').append('<option value="">Select Thickness</option>');

                       
                           $.each(data, function(key, value){
                              $('#BranId_val[name="BranID"]').append('<option value="'+ value.BranId+'">' + value.BranName + '</option>');
                           });
                         }

                      },

                  });
              } else{

              }
          });
          // Brand Wise productSize
          $('select[name="BranID"]').on('change', function(){
              var BranId = $(this).val();
              if(BranId) {
                  $.ajax({
                      url: "{{ route('Brand-wise-size') }}",
                      type:"POST",
                      dataType:"json",
                      data: { BranId:BranId },
                      success:function(data) {
                         if(data == ""){
                         
                           $('#SizeId_val[name="SizeID"]').empty();
                           $('#SizeId_val[name="SizeID"]').append('<option value="">Data Not Found!</option>');
                           $('#ThicId_val[name="ThicID"]').empty();
                           $('#ThicId_val[name="ThicID"]').append('<option value="">Data Not Found!</option>');

                         }else{
                          
                           $('#SizeId_val[name="SizeID"]').empty();
                           $('#SizeId_val[name="SizeID"]').append('<option value="">Select Size</option>');
                           $('#ThicId_val[name="ThicID"]').empty();
                           $('#ThicId_val[name="ThicID"]').append('<option value="">Select Thickness</option>');

                           $.each(data, function(key, value){
                              $('#SizeId_val[name="SizeID"]').append('<option value="'+ value.SizeId+'">' + value.SizeName + '</option>');
                           });
                         }

                      },
                  });
              } else{

              }
          });
          // product Size Wise Thickness
          $('select[name="SizeID"]').on('change', function(){
              var Size = $(this).val();
              if(Size) {
                  $.ajax({
                      url: "{{ route('size-wise-thickness') }}",
                      type:"POST",
                      dataType:"json",
                      data: { Size:Size },
                      success:function(data) {
                         if(data == ""){
                          
                           $('#ThicId_val[name="ThicID"]').empty();
                           $('#ThicId_val[name="ThicID"]').append('<option value="">Data Not Found!</option>');

                         }else{
                          
                           $('#ThicId_val[name="ThicID"]').empty();
                           $('#ThicId_val[name="ThicID"]').append('<option value="">Select Thickness</option>');

                           $.each(data, function(key, value){
                              $('#ThicId_val[name="ThicID"]').append('<option value="'+ value.ThicId+'">' + value.ThicName + '</option>');
                           });
                         }

                      },
                  });
              } else{

              }
          });
        
      });
    </script>

    </body>
</html>