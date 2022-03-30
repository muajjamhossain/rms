@extends('layouts.admin')
@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Menu</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="#">Dashboard</a></li>
            <li class="active">Home</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-7">
                        <h3 class="card-title card_top_title"><i class="fa fa-gg-circle"></i> Menus</h3>
                    </div>
                    <div class="col-md-5 text-right">
                        <div class="row">
                            <div class="col-md-6">
                                <form action="" method="get" id="search-form">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn waves-effect waves-light btn-primary"><i class="fa fa-search"></i></button>
                                        </span>
                                        <input type="text" id="search-btn" name="search" class="form-control" placeholder="Search">
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <div class="dropdown" style="display: inline-block;">
                                    <button class="btn btn-md btn-secondary card_top_button dropdown-toggle waves-effect" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Category
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" onclick="cateItem(0, 'all')" style="cursor: pointer;">All</a>
                                        @foreach($categories as $category)
                                            @if(!$category->categoryMenu->isEmpty() && dining_menu($category->categoryMenu))
                                                <a class="dropdown-item" onclick="cateItem({{ $category->id }}, 'cate')" style="cursor: pointer;">{{ $category->name }}</a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ url('admin/order-request/cart/'.$slug) }}" class="btn btn-md btn-success waves-effect card_top_button"><i class="fa fa-shopping-cart"></i> Cart</a>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body" id="menu">
                <div class="row">
                    @foreach($menus as $menu)
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                            <div class="card">
                                <div class="card-header text-center">
                                    <img src="{{ asset('uploads/foods/'.$menu->photo) }}" alt="{{ $menu->name }}" class="img-fluid" style="height: 100px;">
                                </div>
                                <div class="card-body">
                                    <h4 class="text-center">{{ $menu->name }}</h4>
                                    <h6 class="text-center">Price-{{ $menu->price }}</h6>
                                </div>
                                <div class="card-footer text-center">
                                    <a style="cursor: pointer;" class="btn btn-primary" onclick="addItem({{ $menu->id }})"><i class="fa fa-plus"></i> Add</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>{{-- 
            <div class="card-footer card_footer_expode">
                <a href="#" class="btn btn-secondary waves-effect">PRINT</a>
                <a href="#" class="btn btn-warning waves-effect">EXCEL</a>
                <a href="#" class="btn btn-success waves-effect">PDF</a>
            </div> --}}
        </div>
    </div>
</div>
@endsection
@push('js')
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
    
    this.cateItem = function(id, type) {
        $.get('{{ url('admin/cateItem') }}/'+id+'/'+'{{ $rstrt_slug }}'+'/'+type, function(data){
            $('#menu').empty().append(data);
        });    
    }

    this.addItem = function(id) {
        $.get('{{ url('admin/addToCart') }}/'+id+'/'+'{{ $rstrt_slug }}', function(data){
            Toast.fire({
              icon: 'success',
              title: 'Item Added successfully'
            });
        });    
    }

    document.querySelector('#search-btn').addEventListener('keyup',function(){
        $value=$(this).val();
        $.ajax({
            type : 'get',
            url : '{{url('admin/searchItem')}}',
            data:{'search':$value},
            success:function(data){
                $('#menu').empty().append(data);
            }
        });
    })
</script>
@endpush
