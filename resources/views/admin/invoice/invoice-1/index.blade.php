@extends('layouts.admin')
@section('content')
<div class="full-body">
    <div class="row bread_part">
        <div class="col-sm-12 bread_col">
            <h4 class="pull-left page-title bread_title">Invoice</h4>
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
                            <h3 class="card-title card_top_title"><i class="fa fa-gg-circle"></i> Billing Invoice</h3>
                        </div>
                        <div class="col-md-4 text-right">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="card-body" id="section-to-print">
                    <div class="clearfix">
                        <div class="row">
                            <div class="col-sm-4">
                                <h4 class="pull-left">
                                    @if($order->orderRestaurant->logo!='')
                                        <img style="width: 50px" src="{{asset('uploads/logos/'.$order->orderRestaurant->logo)}}" alt="logo"/>
                                    @else
                                        <img style="width: 50px" src="{{asset('uploads')}}/avatar-black.png" alt="photo"/>
                                    @endif
                                </h4>
                            </div>
                            <div class="col-sm-4">
                                <h2 class="text-center">{{ $order->orderRestaurant->name }}</h2>
                            </div>
                            <div class="col-sm-4">
                                <h4 class="pull-right">Invoice # <br>
                                    <strong>{{ $order->billInfo->invoice_no }}</strong>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-left m-t-30">
                                <address>
                                    @if($order->name)
                                        <strong>{{ $order->name }}</strong><br>
                                    @endif
                                    @if($order->phone)
                                        <span>Phone:</span> {{ $order->phone }}<br>
                                    @endif
                                    @if($order->email)
                                        <span>Email:</span> {{ $order->email }}
                                    @endif
                                </address>
                            </div>
                            <div class="pull-right m-t-30">
                                <p style="margin-bottom: 0"><strong>Order Date: </strong> {{ date('M d, Y', strtotime($order->created_at)) }}</p>
                                <p style="margin-top: 0"><strong>Order ID: </strong> #{{ date('Y', strtotime($order->created_at)) }}{{ $order->id }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="m-h-50"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table m-t-30">
                                    <thead>
                                        <tr><th>#</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Unit Cost</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr></thead>
                                    <tbody>
                                        @foreach($order->detailInfo as $item)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $item->orderDetailMenu->name }}</td>
                                                <td>{{ $item->orderDetailMenu->menuCategory->name }}</td>
                                                <td>{{ $order->orderRestaurant->currency_symbol }}{{ $item->unit_price }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $order->orderRestaurant->currency_symbol }}{{ $item->unit_price * $item->qty }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="border-radius: 0px;">
                        <div class="col-md-3 offset-9">
                            <p class="text-right"><b>Sub-total:</b> {{ $order->total_amount }}</p>
                            <p class="text-right">Discount: {{ $order->billInfo->discount }}</p>
                            <p class="text-right">VAT: {{ $order->orderRestaurant->vat }}%</p>
                            <hr>
                            @php 
                                $total_bill = $order->billInfo->amount + $order->billInfo->vat;
                                $given_amount = $order->billInfo->given_amount; 
                            @endphp
                            <h3 class="text-right">{{ $order->orderRestaurant->currency_symbol }} {{ number_format((float)$total_bill, 2, '.', '') }}</h3>
                            <hr>
                            <p class="text-right"><b>Given Amount:</b> {{ $given_amount }}</p>
                            <p class="text-right"><b>Returned Amount:</b> {{ number_format((float)$given_amount-$total_bill, 2, '.', '') }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="hidden-print">
                        <div class="pull-right">
                            <a href="#" class="btn btn-inverse waves-effect waves-light" onclick="printme()"><i class="fa fa-print"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>

@endsection
@push('js')
    <script>
        function printme() {
            var printContents = document.getElementById('section-to-print').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endpush

