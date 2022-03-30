@extends('layouts.admin')
@push('css')
<link href="{{asset('contents/admin')}}/assets/css/parsley.css" rel="stylesheet" type="text/css" />
<link href="{{asset('contents/admin')}}/assets/css/datatables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Restaurant</h4>
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
                    <div class="col-md-8">
                        <h3 class="card-title card_top_title"><i class="fa fa-gg-circle"></i> View Restaurant Information</h3>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{url('admin/restaurant')}}" class="btn btn-md btn-primary waves-effect card_top_button"><i class="fa fa-plus-circle"></i> All Restaurant</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body">
                <div class="wraper container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="bg-picture text-center" style="background-image:url('{{ asset('contents/admin') }}/assets/images/gallery/main-menu-bg5.jpg')">
                                <div class="bg-picture-overlay"></div>
                                <div class="profile-info-name">
                                    @if($restaurant->logo!='')
                                    <img class="table_image_200" src="{{asset('uploads/logos/'.$restaurant->logo)}}" alt="logo" />
                                    @else
                                    <img class="table_image_200" src="{{asset('uploads')}}/avatar-black.png" alt="photo" />
                                    @endif
                                    <h3 class="text-white">{{ $restaurant->name }}</h3>
                                </div>
                            </div>
                            <!--/ meta -->
                        </div>
                    </div>
                    <div class="row user-tabs">
                        <div class="col-lg-8 col-md-12 col-sm-12">
                            <ul class="nav nav-tabs tabs">
                                <li class="active tab">
                                    <a href="#about" data-toggle="tab" aria-expanded="false" class="active">
                                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                                        <span class="hidden-xs">About</span>
                                    </a>
                                </li>
                                <li class="tab">
                                    <a href="#employee" data-toggle="tab" aria-expanded="false" id="callEmployee">
                                        <span class="visible-xs"><i class="fa fa-user" aria-hidden="true"></i></span>
                                        <span class="hidden-xs">Employee</span>
                                    </a>
                                </li>
                                <li class="tab">
                                    <a href="#category" data-toggle="tab" aria-expanded="false">
                                        <span class="visible-xs"><i class="fa fa-list-alt"></i></span>
                                        <span class="hidden-xs">Category</span>
                                    </a>
                                </li>
                                <li class="tab">
                                    <a href="#menu" data-toggle="tab" aria-expanded="true" id="callMenu">
                                        <span class="visible-xs"><i class="fa fa-coffee"></i></span>
                                        <span class="hidden-xs">Menu</span>
                                    </a>
                                </li>
                                <li class="tab">
                                    <a href="#settings-2" data-toggle="tab" aria-expanded="false">
                                        <span class="visible-xs"><i class="fa fa-cog"></i></span>
                                        <span class="hidden-xs">Settings</span>
                                    </a>
                                </li>
                                <div class="indicator"></div>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tab-content profile-tab-content">
                                <div class="tab-pane active" id="about">
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <table class="table table-bordered table-striped table-hover custom_view_table">
                                                <tr>
                                                    <td>Name</td>
                                                    <td>:</td>
                                                    <td>{{$restaurant->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Url</td>
                                                    <td>:</td>
                                                    <td>{{$restaurant->url}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Client</td>
                                                    <td>:</td>
                                                    <td>{{$restaurant->clientInfo->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Phone</td>
                                                    <td>:</td>
                                                    <td>{{$restaurant->phone}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Address</td>
                                                    <td>:</td>
                                                    <td>{{$restaurant->address}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Status</td>
                                                    <td>:</td>
                                                    <td>
                                                        @if($restaurant->status == 1)
                                                        <span>Active</span>
                                                        @else
                                                        <span>Inacive</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Logo</td>
                                                    <td>:</td>
                                                    <td>
                                                        @if($restaurant->logo!='')
                                                        <img class="table_image_200" src="{{asset('uploads/logos/'.$restaurant->logo)}}" alt="logo" />
                                                        @else
                                                        <img class="table_image_200" src="{{asset('uploads')}}/avatar-black.png" alt="photo" />
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>QR Code</td>
                                                    <td>:</td>
                                                    <td>
                                                        {!! QrCode::size(200)->generate(url('menu/'.$restaurant->url)); !!}
                                                        <a href="{{ url('admin/qrcode/'.$restaurant->slug) }}" style="margin-left: 20px" class="btn btn-primary" target="_blank">Print View</a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="employee">

                                </div>

                                <div class="tab-pane" id="category">
                                    <div class="panel panel-default panel-fill">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <h3 class="panel-title">Categories</h3>
                                                </div>
                                                <div class="col-sm-4 text-right">
                                                    <a class="btn btn-md btn-primary waves-effect card_top_button" id="addCate"><i class="fa fa-plus-circle"></i> Add Category</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive" id="load-category">
                                                <table class="table" id="load-category-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Category</th>
                                                            <th>Created_at</th>
                                                            <th>Manage</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($restaurant->categoryInfo as $category)
                                                        <tr>
                                                            <td id="cate-name" data-id="{{ $category->id }}">{{ $category->name }}</td>
                                                            <td>{{ $category->created_at }}</td>
                                                            <td><a onClick="editCate({{ $category }})"><i class="fa fa-pencil-square fa-lg edit_icon"></i></a></td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="menu">

                                </div>

                                <div class="tab-pane" id="settings-2">
                                    <!-- Personal-Information -->
                                    <div class="panel panel-default panel-fill">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Restaurant Settings</h3>
                                        </div>
                                        <div class="panel-body">
                                            <form role="form" id="settingsForm">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Menu Heading: </label>
                                                            <div class="pt-2">
                                                                <input required type="text" class="form-control" name="menu_heading" value="{{ $restaurant->menu_heading }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    @if(Auth::user()->role_id == 2)
                                                    <div class="{{ Auth::user()->role_id == 2 ? 'col-md-4' : 'col-md-6' }}">
                                                        <div class="form-group">
                                                            <label>Vat Status: </label>
                                                            <div class="pt-2">
                                                                <input type="radio" name="vat_status" value="1" {{ $restaurant->vat_status == 1 ? 'checked' : '' }}> Include
                                                                <input type="radio" class="ml-2" name="vat_status" value="0" {{ $restaurant->vat_status == 0 ? 'checked' : '' }}> Exclude
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="{{ Auth::user()->role_id == 2 ? 'col-md-4' : 'col-md-6' }}">
                                                        <div class="form-group">
                                                            <label>Vat: </label>
                                                            <div class="pt-2" style="display: flex;">
                                                                <input required type="text" class="form-control" name="vat" value="{{ $restaurant->vat }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>discount(%): </label>
                                                            <div class="pt-2">
                                                                <input required type="text" class="form-control" name="discount" value="{{ $restaurant->discount }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @else
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Vat Status: {{ $restaurant->vat_status == 1 ? 'Include' : 'Exclude' }} </label>
                                                            <div class="pt-2">
                                                                <input type="hidden" name="vat_status" value="{{$restaurant->vat_status}}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Vat: </label>
                                                            <div class="pt-2" style="display: flex;">
                                                                <input required type="text" class="form-control" name="vat" value="{{ $restaurant->vat }}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>discount(%): </label>
                                                            <div class="pt-2">
                                                                <input required type="text" class="form-control" name="discount" value="{{ $restaurant->discount }}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @endif
                                                </div>

                                                @if(Auth::user()->role_id == 2)
                                                <div class="form-group">
                                                    <label>Trusted Manager: </label>
                                                    <div class="pt-2">
                                                        <input type="radio" name="trusted_manager" value="1" {{ $restaurant->trusted_manager == 1 ? 'checked' : '' }}> Active
                                                        <input type="radio" class="ml-2" name="trusted_manager" value="0" {{ $restaurant->trusted_manager == 0 ? 'checked' : '' }}> Inactive
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="form-group">
                                                    <label>Vat: </label>
                                                    <div class="form-group">
                                                        <label>Currency Symbol: </label>
                                                        <div class="pt-2">
                                                            <input required type="text" class="form-control" name="currency_symbol" value="{{ $restaurant->currency_symbol }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Menu Theme: </label>
                                                    <div class="pt-2">
                                                        <input type="radio" name="menu_theme" value="1" {{ $restaurant->menu_theme == 1 ? 'checked' : '' }}> Theme-1
                                                        <input type="radio" class="ml-2" name="menu_theme" value="2" {{ $restaurant->menu_theme == 2 ? 'checked' : '' }}> Theme-2
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Menu Food Image: </label>
                                                    <div class="pt-2">
                                                        <input type="radio" name="menu_image_display" value="1" {{ $restaurant->menu_image_display == 1 ? 'checked' : '' }}> Show
                                                        <input type="radio" class="ml-2" name="menu_image_display" value="0" {{ $restaurant->menu_image_display == 0 ? 'checked' : '' }}> Hide
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Menu Categorised: </label>
                                                    <div class="pt-2">
                                                        <input type="radio" name="menu_categorised" value="1" {{ $restaurant->menu_categorised == 1 ? 'checked' : '' }}> Vertical
                                                        <input type="radio" class="ml-2" name="menu_categorised" value="2" {{ $restaurant->menu_categorised == 2 ? 'checked' : '' }}> Dropdown
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Take Away: </label>
                                                    <div class="pt-2">
                                                        <input type="radio" name="takeaway_switch" value="1" {{ $restaurant->takeaway_switch == 1 ? 'checked' : '' }}> Active
                                                        <input type="radio" class="ml-2" name="takeaway_switch" value="0" {{ $restaurant->takeaway_switch == 0 ? 'checked' : '' }}> Inactive
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Table Option: </label>
                                                    <div class="pt-2">
                                                        <input type="radio" name="table_option" value="1" {{ $restaurant->table_option == 1 ? 'checked' : '' }}> Active
                                                        <input type="radio" class="ml-2" name="table_option" value="0" {{ $restaurant->table_option == 0 ? 'checked' : '' }}> Inactive
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Payment Way: </label>
                                                    <div class="pt-2">
                                                        <input type="radio" name="payment_way" value="0" {{ $restaurant->payment_way == 0 ? 'checked' : '' }}> Desk Pay
                                                        <input type="radio" class="ml-2" name="payment_way" value="1" {{ $restaurant->payment_way == 1 ? 'checked' : '' }}> Table Pay
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Invoice: </label>
                                                    <div class="pt-2">
                                                        <input type="radio" name="invoice" value="1" {{ $restaurant->invoice == 1 ? 'checked' : '' }}> Normal
                                                        <input type="radio" class="ml-2" name="invoice" value="2" {{ $restaurant->invoice == 2 ? 'checked' : '' }}> POS
                                                        <input type="radio" class="ml-2" name="invoice" value="3" {{ $restaurant->invoice == 3 ? 'checked' : '' }}> POS with Token
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save</button>
                                            </form>

                                        </div>
                                    </div>
                                    <!-- Personal-Information -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container -->
                <div id="modals"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#addCate').on('click', function() {
            const {
                value: name
            } = Swal.fire({
                title: 'Enter Category',
                input: 'text',
                inputPlaceholder: 'Category Name',
                inputAttributes: {
                    autocapitalize: 'on',
                    autocorrect: 'off'
                },
                inputValidator: (value) => {
                    if (!value) {
                        return 'You need to write something!';
                    } else {
                        var _token = '<?php echo csrf_token() ?>';
                        $.ajax({
                            type: 'POST',
                            url: '{!! url("admin/addCate/".$restaurant->slug) !!}',
                            data: {
                                _token: _token,
                                name: value
                            },
                            success: function(data) {
                                console.log(data.name);
                                $('#load-category #load-category-table tbody').append("<tr><td id='cate-name' data-id='" + data.id + "'>" + data.name + "</td><td>" + data.created_at + "</td><td><a onClick='editCate(" + JSON.stringify(data) + ")'><i class='fa fa-pencil-square fa-lg edit_icon'></i></a></td></tr>");
                            }
                        });
                    }
                }
            })
        });

        this.editCate = function(data) {
            $.get('{{ url("admin/editCate") }}/' + data.id, function(category) {
                Swal.fire({
                    title: 'Edit Category',
                    html: (category.status == 1) ? '<input id="name" class="swal2-input" value="' + category.name + '">' + '<input id="category_status" name="cate_status" type="radio" value="1" checked> Active' + '<input id="category_status" name="cate_status" type="radio" value="0" class="ml-5"> Inacive' : '<input id="name" class="swal2-input" value="' + category.name + '">' + '<input id="category_status" name="cate_status" type="radio" value="1"> Active' + '<input id="category_status" name="cate_status" type="radio" value="0" checked class="ml-5"> Inacive' + '',

                    preConfirm: function() {
                        return new Promise(function(resolve) {
                            resolve({
                                name: $('#name').val(),
                                status: $("input[name='cate_status']:checked").val()
                            })
                        })
                    },
                }).then(function(result) {
                    if (!result) {
                        return 'You need to write something!';
                    } else {
                        var _token = '<?php echo csrf_token() ?>';
                        var obj = JSON.stringify(result);
                        var value = $.parseJSON('[' + obj + ']');
                        var _token = '<?php echo csrf_token() ?>';
                        $.ajax({
                            type: 'PUT',
                            url: '{!! url("admin/editCate") !!}/' + data.id,
                            data: {
                                _token: _token,
                                name: value[0].value.name,
                                status: value[0].value.status
                            },
                            success: function(response) {
                                $('#load-category #load-category-table tbody tr #cate-name').each(function() {
                                    if ($(this).data('id') == data.id) {
                                        this.innerHTML = '';
                                        this.append(response.name);
                                    }
                                });
                            }
                        });
                    }
                })
            });
        }


        $('#callMenu').on('click', function() {
            $.get('{{ url("admin/all_menu/".$restaurant->slug) }}', function(data) {
                $('#menu').empty().append(data);
                $('#datatable').DataTable({
                    "bSort": false
                });
            });
        });

        $('#callEmployee').on('click', function() {
            $.get('{{ url("admin/employee/".$restaurant->slug) }}', function(data) {
                $('#employee').empty().append(data);
                $('#employeetable').DataTable({
                    "bSort": false
                });
            });
        });


        $('#menu').on('click', '#addMenu', function() {
            $.get('{{ url("admin/menu/create/".$restaurant->slug) }}', function(data) {
                $('#modals').empty().append(data);
                $('form').parsley('validate');
                $('#addMenuModal').modal('show');
            });
        });

        $('#menu').on('click', '#addStockMenu', function() {
            $.get('{{ url("admin/menu/create/stock/".$restaurant->slug) }}', function(data) {
                $('#modals').empty().append(data);
                $('form').parsley('validate');
                $('#addMenuStockModal').modal('show');
            });
        });

        $('#modals').on('submit', '#formAddStockMenu', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                    url: '{{ url("admin/menu/".$restaurant->slug) }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                })
                .done(function(data) {
                    $('#menu').empty().append(data);
                    $('#addMenuStockModal').modal('hide');
                    $('#datatable').DataTable({
                        "bSort": false
                    });
                })
                .fail(function(error) {
                    var error = error.responseJSON;
                    $('#modals #error_price').empty();
                    $('#modals #error_name').empty();
                    $('#modals #error_cate_id').empty();
                    $('#modals #error_pic').empty();
                    jsondata = JSON.stringify(error);
                    var obj = JSON.parse(jsondata);
                    if (obj.errors.name != undefined) {
                        $('#modals #error_name').append('<strong>' + obj.errors.name + '</strong>');
                    }
                    if (obj.errors.price != undefined) {
                        $('#modals #error_price').append('<strong>' + obj.errors.price + '</strong>');
                    }
                    if (obj.errors.cate_id != undefined) {
                        $('#modals #error_cate_id').append('<strong>' + obj.errors.cate_id + '</strong>');
                    }
                    if (obj.errors.pic != undefined) {
                        $('#modals #error_pic').append('<strong>' + obj.errors.pic + '</strong>');
                    }
                });
        });

        $('#employee').on('click', '#addEmployee', function() {
            $.get('{{ url("admin/employee/create/".$restaurant->slug) }}', function(data) {
                $('#modals').empty().append(data);
                $('form').parsley('validate');
                $('#addEmployeeModal').modal('show');
                window.Parsley.addValidator('maxFileSize', {
                    validateString: function(_value, maxSize, parsleyInstance) {
                        if (!window.FormData) {
                            alert('You are making all developpers in the world cringe. Upgrade your browser!');
                            return true;
                        }
                        var files = parsleyInstance.$element[0].files;
                        return files.length != 1 || files[0].size <= maxSize * 1024;
                    },
                    requirementType: 'integer',
                    messages: {
                        en: 'Image size limit is %s Kb'
                    }
                });
            });
        });

        $('#menu').on('click', '#editMenuButton', function() {
            var id = $(this).data('id');
            $.get('{{ url("admin/menu/edit") }}/' + id, function(data) {
                $('#modals').empty().append(data);
                $('form').parsley('validate');
                $('#editMenuModal').modal('show');
            });
        });

        $('#employee').on('click', '#editEmployeeButton', function() {
            var id = $(this).data('id');
            $.get('{{ url("admin/employee/edit") }}/' + id, function(data) {
                $('#modals').empty().append(data);
                $('form').parsley('validate');
                $('#editEmployeeModal').modal('show');
            });
        });

        $('#menu').on('click', '#deleteMenuButton', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.get('{{ url("admin/menu/delete/".$restaurant->slug) }}/' + id, function(data) {
                        $('#menu').empty().append(data);
                        $('#datatable').DataTable({
                            "bSort": false
                        });
                    });
                    Swal.fire(
                        'Deleted!',
                        'Your menu has been deleted.',
                        'success'
                    )
                }
            })
        });

        $('#employee').on('click', '#deleteEmployeeButton', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.get('{{ url("admin/employee/delete") }}/' + id, function(data) {
                        $('#employee').empty().append(data);
                        $('#datatable').DataTable({
                            "bSort": false
                        });
                    });
                    Swal.fire(
                        'Deleted!',
                        'Your employee has been deleted.',
                        'success'
                    )
                }
            })
        });

        $('#employee').on('click', '#employeeStatusInactive', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Do you want to Inacivate him?',
                text: "This employee can't use the system",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Inacivate him!'
            }).then((result) => {
                if (result.value) {
                    $.get('{{ url("admin/employee/inactivate") }}/' + id, function(data) {
                        $('#employee').empty().append(data);
                        $('#datatable').DataTable({
                            "bSort": false
                        });
                    });
                    Swal.fire(
                        'Inacivated!',
                        'Your employee has been inacivated.',
                        'success'
                    )
                }
            })
        });

        $('#employee').on('click', '#employeeStatusActive', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Do you want to active him?',
                text: "This employee will be able to use the system",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Inacivate him!'
            }).then((result) => {
                if (result.value) {
                    $.get('{{ url("admin/employee/activate") }}/' + id, function(data) {
                        $('#employee').empty().append(data);
                        $('#datatable').DataTable({
                            "bSort": false
                        });
                    });
                    Swal.fire(
                        'Acivated!',
                        'Your employee has been activated.',
                        'success'
                    )
                }
            })
        });

        $('#modals').on('submit', '#formAddMenu', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                    url: '{{ url("admin/menu/".$restaurant->slug) }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                })
                .done(function(data) {
                    $('#menu').empty().append(data);
                    $('#addMenuModal').modal('hide');
                    $('#datatable').DataTable({
                        "bSort": false
                    });
                })
                .fail(function(error) {
                    var error = error.responseJSON;
                    $('#modals #error_price').empty();
                    $('#modals #error_name').empty();
                    $('#modals #error_cate_id').empty();
                    $('#modals #error_pic').empty();
                    jsondata = JSON.stringify(error);
                    var obj = JSON.parse(jsondata);
                    if (obj.errors.name != undefined) {
                        $('#modals #error_name').append('<strong>' + obj.errors.name + '</strong>');
                    }
                    if (obj.errors.price != undefined) {
                        $('#modals #error_price').append('<strong>' + obj.errors.price + '</strong>');
                    }
                    if (obj.errors.cate_id != undefined) {
                        $('#modals #error_cate_id').append('<strong>' + obj.errors.cate_id + '</strong>');
                    }
                    if (obj.errors.pic != undefined) {
                        $('#modals #error_pic').append('<strong>' + obj.errors.pic + '</strong>');
                    }
                });
        });

        $('#modals').on('submit', '#formAddEmployee', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                    url: '{{ url("admin/employee/".$restaurant->slug) }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                })
                .done(function(data) {
                    $('#employee').empty().append(data);
                    $('#addEmployeeModal').modal('hide');
                    $('#employeetable').DataTable({
                        "bSort": false
                    });
                })
                .fail(function(error) {
                    var error = error.responseJSON;
                    $('#modals #error_name').empty();
                    $('#modals #error_email').empty();
                    $('#modals #error_password').empty();
                    $('#modals #error_password_confirmation').empty();
                    $('#modals #error_phone').empty();
                    $('#modals #error_address').empty();
                    $('#modals #error_role_id').empty();
                    $('#modals #error_pic').empty();
                    jsondata = JSON.stringify(error);
                    var obj = JSON.parse(jsondata);
                    if (obj.errors.name != undefined) {
                        $('#modals #error_name').append('<strong>' + obj.errors.name + '</strong>');
                    }
                    if (obj.errors.email != undefined) {
                        $('#modals #error_email').append('<strong>' + obj.errors.email + '</strong>');
                    }
                    if (obj.errors.password != undefined) {
                        $('#modals #error_password').append('<strong>' + obj.errors.password + '</strong>');
                    }
                    if (obj.errors.password_confirmation != undefined) {
                        $('#modals #error_password_confirmation').append('<strong>' + obj.errors.password_confirmation + '</strong>');
                    }
                    if (obj.errors.phone != undefined) {
                        $('#modals #error_phone').append('<strong>' + obj.errors.phone + '</strong>');
                    }
                    if (obj.errors.address != undefined) {
                        $('#modals #error_address').append('<strong>' + obj.errors.address + '</strong>');
                    }
                    if (obj.errors.role_id != undefined) {
                        $('#modals #error_role_id').append('<strong>' + obj.errors.role_id + '</strong>');
                    }
                    if (obj.errors.pic != undefined) {
                        $('#modals #error_pic').append('<strong>' + obj.errors.pic + '</strong>');
                    }
                });
        });

        $('#modals').on('submit', '#formEditMenu', function(e) {
            var id = $(this).data('id');
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                    url: '{{ url("admin/menu/edit") }}/' + id,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false
                })
                .done(function(data) {
                    $('#menu').empty().append(data);
                    $('#editMenuModal').modal('hide');
                    $('#datatable').DataTable({
                        "bSort": false
                    });
                })
                .fail(function(error) {
                    var error = error.responseJSON;
                    $('#modals #error_price').empty();
                    $('#modals #error_name').empty();
                    $('#modals #error_cate_id').empty();
                    jsondata = JSON.stringify(error);
                    var obj = JSON.parse(jsondata);
                    if (obj.errors.name != undefined) {
                        $('#modals #error_name').append('<strong>' + obj.errors.name + '</strong>');
                    }
                    if (obj.errors.price != undefined) {
                        $('#modals #error_price').append('<strong>' + obj.errors.price + '</strong>');
                    }
                    if (obj.errors.cate_id != undefined) {
                        $('#modals #error_cate_id').append('<strong>' + obj.errors.cate_id + '</strong>');
                    }
                });
        });

        $('#modals').on('submit', '#formEditEmployee', function(e) {
            var id = $(this).data('id');
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                    url: '{{ url("admin/employee/edit") }}/' + id,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false
                })
                .done(function(data) {
                    $('#employee').empty().append(data);
                    $('#editEmployeeModal').modal('hide');
                    $('#employeetable').DataTable({
                        "bSort": false
                    });
                })
                .fail(function(error) {
                    var error = error.responseJSON;
                    $('#modals #error_name').empty();
                    $('#modals #error_email').empty();
                    $('#modals #error_password').empty();
                    $('#modals #error_password_confirmation').empty();
                    $('#modals #error_phone').empty();
                    $('#modals #error_address').empty();
                    $('#modals #error_role_id').empty();
                    $('#modals #error_pic').empty();
                    jsondata = JSON.stringify(error);
                    var obj = JSON.parse(jsondata);
                    if (obj.errors.name != undefined) {
                        $('#modals #error_name').append('<strong>' + obj.errors.name + '</strong>');
                    }
                    if (obj.errors.name != undefined) {
                        $('#modals #error_email').append('<strong>' + obj.errors.email + '</strong>');
                    }
                    if (obj.errors.password != undefined) {
                        $('#modals #error_password').append('<strong>' + obj.errors.password + '</strong>');
                    }
                    if (obj.errors.password_confirmation != undefined) {
                        $('#modals #error_password_confirmation').append('<strong>' + obj.errors.password_confirmation + '</strong>');
                    }
                    if (obj.errors.phone != undefined) {
                        $('#modals #error_phone').append('<strong>' + obj.errors.phone + '</strong>');
                    }
                    if (obj.errors.address != undefined) {
                        $('#modals #error_address').append('<strong>' + obj.errors.address + '</strong>');
                    }
                    if (obj.errors.role_id != undefined) {
                        $('#modals #error_role_id').append('<strong>' + obj.errors.role_id + '</strong>');
                    }
                    if (obj.errors.pic != undefined) {
                        $('#modals #error_pic').append('<strong>' + obj.errors.pic + '</strong>');
                    }
                });
        });

        $('#settingsForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                    url: '{{ url("admin/restaurant/setting/".$restaurant->slug) }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false
                })
                .done(function() {
                    Swal.fire({
                        title: 'Updated!',
                        text: 'Your restaurant has been updated.',
                        icon: 'success',
                        timer: 1500
                    })
                });
        });


    });

    var limitEmp = function() {
        Swal.fire({
            title: 'Employee limit is over!',
            text: 'Contact to Triva IT Ltd. to upgrade your package',
            icon: 'warning',
            confirmButtonText: 'Ok'
        })
    }
</script>
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
    })
</script>
<script src="{{asset('contents/admin')}}/assets/js/jquery.datatables.min.js"></script>
<script src="{{asset('contents/admin')}}/assets/js/datatables.bootstrap4.min.js"></script>
<script src="{{asset('contents/admin')}}/assets/js/parsley.min.js"></script>
@endpush