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
                    <div class="col-md-8">
                        <h3 class="card-title card_top_title"><i class="fa fa-gg-circle"></i> Menus</h3>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{url('admin/menucard/'.$rstrt_slug)}}" class="btn btn-md btn-success waves-effect card_top_button"><i class="fa fa-plus"></i> Add More</a>
                        <a href="{{ url('admin/place-order/'.$rstrt_slug) }}" class="btn btn-md btn-primary waves-effect card_top_button"><i class="fa fa-plus-circle"></i> Submit order</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive" id="table">
                            <table id="datatable" class="table table-bordered custom_table mb-0 with-image">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Sub Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(Cart::content() as $item)
                                        <tr>
                                            <td><img src="{{ asset('uploads/foods/'.$item->options->photo) }}" alt="{{ $item->name }}" style="height: 50px;"></td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td><button class="btn btn-success btn-sm" onclick="updateQty({{ $item->id }}, 'inc')"><i class="fa fa-plus"></i></button> {{ $item->qty }} <button class="btn btn-success btn-sm" onclick="updateQty({{ $item->id }}, 'dec')"><i class="fa fa-minus"></i></button></td>
                                            <td>{{ $item->qty * $item->price }}</td>
                                            <td>
                                                <button class="btn btn-danger btn-sm" style="font-weight: bold" onclick="deleteItem({{ $item->id }})">X</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <h4 class="text-right">Total: {{ Cart::subtotal() }}</h4>
                                </tfoot>
                            </table>
                        </div>
                    </div>
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
        this.deleteItem = function(id){
            $.get('{{ url('admin/deleteCartItem') }}/'+id, function(data){
                $('#table').empty().append(data);
            });
        }

        this.updateQty = function(id, action){
            $.get('{{ url('admin/updateQty') }}/'+id+'/'+action, function(data){
                $('#table').empty().append(data);
            });
        }
    </script>
@endpush
