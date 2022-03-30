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
                                <input type="hidden" class="productCartViewClass" id="productCartViewId" value="{{ $rstrt_slug }}">
                                <!-- <input type="text" class="" id="viewCount" value=""> -->
                                <a href="{{ url('admin/place-order/'.$rstrt_slug) }}" class="btn btn-md btn-success waves-effect card_top_button"><i class="fa fa-plus-circle"></i> Submit order</a>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">

                    <!-- product show -->
                    <div class="col-8">
                        <div class="row" id="menu">
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
                                        @if($menu->size !=0 || $menu->crust !=0)

                                            <a style="cursor: pointer;" class="btn btn-primary" id="passMenuId" data-id="{{$menu->id}}" data-toggle="modal" data-target="#addToCartModal"><i class="fa fa-plus"></i> Add</a>
                                        @else

                                            <a style="cursor: pointer;" class="btn btn-primary" onclick="addItem({{ $menu->id }})"><i class="fa fa-plus"></i> Add</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- product show -->

                    <!-- cart -->
                    <div class="col-4" style="border: 1px dotted red">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered custom_table mb-0 with-image">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Sub-Total</th>
                                                <th>Action</th>
                                                <th>Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableCart">

                                        </tbody>
                                        <tfoot>

                                            <h4 class="text-right">Total: <strong id="totalCount"></strong> </h4>

                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- cart -->

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





<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="addToCartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-white bg-danger" style="max-width: 18rem;">
                            <div class="card-header">Header</div>
                            <div class="card-body">
                                <img src="" id="menuPhoto" class="card-img-top" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-group">
                            <input type="hidden" id="rstrt_slug" value="{{$rstrt_slug}}">
                            <li class="list-group-item">Name :<strong id="menuName"></strong></li>
                            <li class="list-group-item">Price :<strong id="menuPrice"></strong></li>
                            <li class="list-group-item">Size :<strong id="menuSize"></strong></li>
                        </ul>

                    </div>
                    <div class="col-md-4">
                        <div class="form-group nonASize">
                            <label for="size"> Select Size</label>
                            <select class="form-control" name="sizeId" id="sizeId">
                            </select>
                        </div>

                        <div id="crustProduct">
                        <input type="checkbox" id="thin" name="thin" value="1">
                        <label for="thin"> Thin</label><br>
                        <input type="checkbox" id="medium" name="medium" value="2">
                        <label for="medium"> Medium</label><br>
                        <input type="checkbox" id="thick" name="thick" value="3">
                        <label for="thick"> Thick</label><br>
                        <input type="checkbox" id="sThin" name="sThin" value="4">
                        <label for="sThin"> Super Thin</label><br>
                    </div>
                    </div>
                   
                </div>
                <div class="row">
                    <!-- <div class="col-md-8">
                        <ul class="list-group pt-5" id="addonsProduct">
                           
                        </ul>
                    </div> -->
                    <!-- <div class="col-md-4" id="crustProduct">
                        <input type="checkbox" id="thin" name="thin" value="1">
                        <label for="thin"> Thin</label><br>
                        <input type="checkbox" id="medium" name="medium" value="2">
                        <label for="medium"> Medium</label><br>
                        <input type="checkbox" id="thick" name="thick" value="3">
                        <label for="thick"> Thick</label><br>
                        <input type="checkbox" id="sThin" name="sThin" value="4">
                        <label for="sThin"> Super Thin</label><br>
                    </div> -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="modalMenuId" onclick="addItemWithCrust({{ $menu->id }})">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    // modal code
    $(document).on("click", "#passMenuId", function() {
        var menuId = $(this).data('id');

        $.get('{{ url("admin/menu/for/addToCart") }}/' + menuId + '/' + '{{ $rstrt_slug }}', function(data) {
            // console.loge(data);
            $('#menuName').text(data.menu.name);
            $('#menuPrice').text(data.menu.price);
            
            $('#menuPhoto').attr('src', '/uploads/foods/'+data.menu.photo);


            // crust
            if(data.menu.stock_status == 0){
                $('#crustProduct').show();
            }else{
                $('#crustProduct').hide();
            }
            // multiple size code
            if(data.allSize != 0) {
                $('#menuSize').text(data.menu.size);

                $('select[id="sizeId"]').empty();
                $('.nonASize').show();
                $('select[id="sizeId"]').append('<option>Please Select Size </option>');

                // array_combine($allPrice,$allSize);


                $.each(data.combainArray, function(key, value) {
                    $('select[id="sizeId"]').append('<option value="' + value + '">' +value+'TK & Size'+ key + '</option>');
                });
            }else{
                $('#menuSize').text('Size N/A');

                $('select[id="sizeId"]').empty();
                $('select[id="sizeId"]').append('<option> Size N/A </option>');
                $('.nonASize').hide();
            }

            // add ons code
            if(data.menu.addons == true){
                $('#addonsProduct').show();
                $('ul[id="addonsProduct"]').empty();
                $('ul[id="addonsProduct"]').append('<li class="list-group-item">Add Ons :<strong>List</strong></li>');
               
                $.each(data.addonsProduct, function(key, value){
                    $('ul[id="addonsProduct"]').append('<li class="list-group-item">'+value.name+ ':<strong>'+value.size+'</strong><input class="form-control-sm" type="text" id="addonSize" name="addonSize[]"></li>');
                });
            }else{
                $('#addonsProduct').hide();
                $('ul[id="addonsProduct"]').empty();
            }

           
        });

    });




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
        productCartView();
        $.get('{{ url("admin/cateItem") }}/' + id + '/' + '{{ $rstrt_slug }}' + '/' + type, function(data) {
            $('#menu').empty().append(data);
        });
        // productCartView(id);
    }

    this.addItem = function(id) {
        // alert(id);
        
        $.get('{{ url("admin/addToCart") }}/' + id + '/' + '{{ $rstrt_slug }}', function(data) {
            Toast.fire({
                icon: 'success',
                title: 'Item Added successfully'
            });
            productCartView();
        });
    }

    this.addItemWithCrust = function(id) {
        // alert(id);
        var rstrt_slug = $('#rstrt_slug').val();
        var id = id;
        var price = $('#menuPrice').val();
        var name = $('#menuName').val();
        var thin = $('#thin').val();
        var medium = $('#medium').val();
        var thick = $('#thick').val();
        var sThin = $('#sThin').val();
        var sizeId = $('#sizeId').val();
        var menuSize = $('#menuSize').val();
        var addonSize = $('#addonSize').val();

        // alert(rstrt_slug);
        $.ajax({
            type: "post",
            url: '{{url("admin/addToCart")}}',
            data:{id:id, rstrt_slug:rstrt_slug,
                name:name, price:price,
                thin:thin, medium:medium,
                thick:thick, sThin:sThin,
                sizeId:sizeId, 
                menuSize:menuSize,
                addonSize:addonSize
            },
            dateType: "json",
            success: function(data){
                    Toast.fire({
                    icon: 'success',
                    title: 'Item Added successfully'
                });
               productCartView();
            }

        });
        
    }

    document.querySelector('#search-btn').addEventListener('keyup', function() {
        $value = $(this).val();
        $.ajax({
            type: 'get',
            url: '{{url("admin/searchItem")}}',
            data: {
                'search': $value
            },
            success: function(data) {
                $('#menu').empty().append(data);
                productCartView();
            }
        });
        // productCartView(id);
    })
</script>

<script>
    $('document').ready(function() {
        productCartView();

    });



    function productCartView() {
        var slug = $('#productCartViewId').val();
        // alert(slug)
        if (slug) {
            $.ajax({
                type: 'POST',
                url: '{{route("cart.view.page")}}',
                data: {
                    slug: slug
                },
                dateType: 'json',
                success: function(response) {
                    // $('#viewCount').val(response.cartTotal);
                    $('#totalCount').text(response.total);

                    if (response.carts) {
                        var rows = "";
                        $.each(response.carts, function(key, value) {
                            rows +=
                                `
                                    <tr>
                                        <td>${ value.name }</td>
                                        <td>${ value.price }</td>
                                        <td>${ value.qty } </td>
                                        <td>${ value.qty * value.price }</td>
                                        <td><button class="btn btn-success btn-sm" onclick="updateQty(${ value.id }, 'inc')"><i class="fa fa-plus"></i></button> ${ value.qty } <button class="btn btn-success btn-sm" onclick="updateQty(${ value.id }, 'dec')"><i class="fa fa-minus"></i></button></td>
                                        <td>
                                            <button class="btn btn-danger btn-sm" style="font-weight: bold" onclick="deleteItem(${ value.id })">X</button>
                                        </td>
                                    </tr>                                    
                                    `
                        });

                        $('#tableCart').html(rows);


                    } // endif

                } //success



            });
        }
    }
</script>



<script>
    this.deleteItem = function(id) {
        $.get('{{ url("admin/deleteCartItem") }}/' + id,
            function(data) {
                $('#table').empty().append(data);
                productCartView();
            });
    }

    this.updateQty = function(id, action) {
        $.get('{{ url("admin/updateQty") }}/' + id + '/' + action,
            function(data) {
                $('#table').empty().append(data);
                productCartView();
            });
    }
</script>

@endpush