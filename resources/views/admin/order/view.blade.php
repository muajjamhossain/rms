@extends('layouts.admin')
@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Order</h4>
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
                        <h3 class="card-title card_top_title"><i class="fa fa-gg-circle"></i> View Order Information</h3>
                    </div>
                    <div class="col-md-4 text-right">
                        @if($status == 1)
                            @if(Auth::user()->role_id != 2)
                            <a href="{{url('admin/order-request/edit/'.$order->slug)}}" class="btn btn-md btn-success waves-effect card_top_button"><i class="fa fa-pencil-square"></i> Edit Order</a>
                            @endif
                        <a href="{{url('admin/order-request/'.$order->rstrt_slug)}}" class="btn btn-md btn-primary waves-effect card_top_button"><i class="fa fa-plus-circle"></i> All Order</a>
                        @endif
                        @if($status == 2)
                        <a href="{{url('admin/confirmed-order/'.$order->rstrt_slug)}}" class="btn btn-md btn-primary waves-effect card_top_button"><i class="fa fa-plus-circle"></i> All Confirmed</a>
                        @endif
                        @if($status == 3)
                        <a href="{{url('admin/order-serve/'.$order->rstrt_slug)}}" class="btn btn-md btn-primary waves-effect card_top_button"><i class="fa fa-plus-circle"></i> All Serve</a>
                        @endif
                        @if($status == 4)
                        <a href="{{url('admin/delivered-order/'.$order->rstrt_slug)}}" class="btn btn-md btn-primary waves-effect card_top_button"><i class="fa fa-plus-circle"></i> All Delivered</a>
                        @endif
                        @if($status == 5)
                        <a href="{{url('admin/cancelled-order/'.$order->rstrt_slug)}}" class="btn btn-md btn-primary waves-effect card_top_button"><i class="fa fa-plus-circle"></i> All Cancelled</a>
                        @endif
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <table class="table table-bordered table-striped table-hover custom_view_table">
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td>{{$order->name}}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>:</td>
                                <td>{{$order->phone}}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{$order->email}}</td>
                            </tr>
                            <tr>
                                <td>Table No.</td>
                                <td>:</td>
                                <td>{{ $order->table_no }}</td>
                            </tr>
                            <tr>
                                <td>Total Price</td>
                                <td>:</td>
                                <td>{{$order->total_amount}}</td>
                            </tr>
                            <tr>
                                <td>Delivery Date</td>
                                <td>:</td>
                                <td>{{$order->delivery_date}}</td>
                            </tr>
                            <tr>
                                <td>Delivery Time</td>
                                <td>:</td>
                                <td>{{$order->delivery_time}}</td>
                            </tr>
                            <tr>
                                <td>Requested At</td>
                                <td>:</td>
                                <td>{{$order->created_at}}</td>
                            </tr>
                            <tr>
                                <td>Order Details</td>
                                <td>:</td>
                                <td>{{$order->details}}</td>
                            </tr>
                            <tr>
                                <td>Items</td>
                                <td>:</td>
                                <td>
                                    @foreach($order->detailInfo as $item)
                                        <table class="table table-bordered table-striped table-hover custom_view_table">
                                            <tr>
                                                <td>Name</td>
                                                <td>:</td>
                                                <td>{{$item->orderDetailMenu->name ?? ''}}</td>
                                            </tr>
                                            <tr>
                                                <td>Category</td>
                                                <td>:</td>
                                                <td>{{$item->orderDetailMenu->menuCategory->name ?? ''}}</td>
                                            </tr>
                                            <tr>
                                                <td>price</td>
                                                <td>:</td>
                                                <td>{{$item->unit_price}}</td>
                                            </tr>
                                            <tr>
                                                <td>Quantity</td>
                                                <td>:</td>
                                                <td>{{$item->qty}}</td>
                                            </tr>
                                            <tr>
                                                <td>Sub Total</td>
                                                <td>:</td>
                                                <td>{{$item->qty * $item->unit_price}}</td>
                                            </tr>
                                            <tr>
                                                <td>Photo</td>
                                                <td>:</td>
                                                <td>
                                                    <img class="img-fluid" src="{{asset('uploads/foods/'.@$item->orderDetailMenu->photo)}}" alt="photo" style="max-width: 150px" />
                                                </td>
                                            </tr>
                                        </table>
                                    @endforeach
                                </td>
                            </tr>
                            {{-- 
                            <tr>
                                <td>Phone</td>
                                <td>:</td>
                                <td>{{$client->phone}}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>:</td>
                                <td>{{$client->address}}</td>
                            </tr>
                            <tr>
                                <td>Number of Restaurant</td>
                                <td>:</td>
                                <td>{{$client->no_of_restaurant}}</td>
                            </tr>
                            <tr>
                                <td>Subscription Time</td>
                                <td>:</td>
                                <td>{{$client->created_at->format('d-m-Y | h:i:s a')}}</td>
                            </tr>
                            <tr>
                                <td>Subscription Close</td>
                                <td>:</td>
                                <td>
                                    @php
                                        echo Carbon\Carbon::create($client->subs_finishing_date)->format('d-m-Y');
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td>User Role</td>
                                <td>:</td>
                                <td>Admin</td>
                            </tr>
                            <tr>
                                <td>Photo</td>
                                <td>:</td>
                                <td>
                                    @if($client->photo!='')
                                        <img class="table_image_200" src="{{asset('uploads/users/'.$client->photo)}}" alt="photo"/>
                                    @else
                                        <img class="table_image_200" src="{{asset('uploads')}}/avatar-black.png" alt="photo"/>
                                    @endif
                                </td>
                            </tr> --}}
                        </table>
                    </div>
                    <div class="col-md-2"></div>
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
