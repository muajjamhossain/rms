@extends('layouts.admin')
@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('contents/admin')}}/assets/css/pos.css">
<style>
    #token {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        border-bottom : 1px dotted #333;
    }

    #token::before {    
        content: "";
        background-image: url({{asset('uploads/logos/'.$order->orderRestaurant->logo)}});
        background-size: cover;
        position: absolute;
        top: 0px;
        right: 0px;
        bottom: 0px;
        left: 0px;
        opacity: 0.4;
    }

    #token h2 {
      position: relative;
      color: #333;  
      line-height: 0.6;
      text-align: center;
    }

    #invoice-POS #top {
    min-height: 0px;
}
</style>
@endpush
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
                    <div id="invoice-POS">
                        <!-- <div id="token" class="watermark">
                            <div class="token-info">
                                <h2>Token No: #{{ date('y', strtotime($order->created_at)) }}{{ $order->id }}</h2>
                                <h2>Pending Tokens: {{ $pending }}</h2>
                                <h2>Date : {{ date('M d, Y', strtotime($order->created_at)) }}</h2>
                                <h2>Contact Info</h2>
                                <p>
                                    Address : {{ $order->orderRestaurant->address }}</br>
                                    Email   : {{ $order->orderRestaurant->clientInfo->email }}</br>
                                    Phone   : {{ $order->orderRestaurant->phone }}</br>
                                </p>
                            </div>
                        </div> -->



                        <center id="top">
                            @if($order->orderRestaurant->logo!='')
                                <img src="{{asset('uploads/logos/'.$order->orderRestaurant->logo)}}" alt="logo" style="width: 60px; height: 60px" /> 
                            @endif
                            <div class="info">
                                <h2>{{ $order->orderRestaurant->name }}</h2>
                            </div><!--End Info-->
                        </center><!--End InvoiceTop-->
                        <div id="mid">
                            <div class="info">

                                <h2>Token No: #{{ date('y', strtotime($order->created_at)) }}{{ $order->id }}</h2>
                                <h2>Date : {{ date('M d, Y', strtotime($order->created_at)) }}</h2>
                                <h2>Contact Info</h2>
                                <p>
                                    Address : {{ $order->orderRestaurant->address }}</br>
                                    Email   : {{ $order->orderRestaurant->clientInfo->email }}</br>
                                    Phone   : {{ $order->orderRestaurant->phone }}</br>
                                </p>
                            </div>
                        </div><!--End Invoice Mid-->
                        <div id="bot">
                            <div id="table">
                                <table>
                                    <tr class="tabletitle">
                                        <td class="item"><h2>Item</h2></td>
                                        <td class="Hours"><h2>Qty</h2></td>
                                        <td class="Rate"><h2>Sub Total</h2></td>
                                    </tr>
                                    @foreach($order->detailInfo as $item)
                                    <tr class="service">
                                        <td class="tableitem"><p class="itemtext">{{ $item->orderDetailMenu->name }}</p></td>
                                        <td class="tableitem"><p class="itemtext">{{ $item->qty }}</p></td>
                                        <td class="tableitem"><p class="itemtext">{{ $order->orderRestaurant->currency_symbol }}{{ $item->unit_price * $item->qty }}</p></td>
                                    </tr>
                                    @endforeach
                                    <tr class="tabletitle">
                                        <td class="Rate">Total</td>
                                        <td></td>
                                        <td class="payment">{{$order->billInfo->amount + $order->billInfo->discount }}</td>
                                    </tr>
                                    <tr class="tabletitle">
                                        <td class="Rate">Discount(-)</td>
                                        <td></td>
                                        <td class="payment">{{$order->billInfo->discount }}</td>
                                    </tr>
                                    <tr class="tabletitle">
                                        <td class="Rate text-right">=</td>
                                        <td></td>
                                        <td class="payment">{{$order->billInfo->amount }}</td>
                                    </tr>
                                    @if($vat_status == 1)

                                        <tr class="tabletitle">
                                            <td class="Rate"><h2>Vat</h2></td>
                                            <td></td>
                                            <td class="payment"><h2>{{ $order->orderRestaurant->currency_symbol }} {{  $order->billInfo->vat }}</h2></td>
                                        </tr>
                                        @php 
                                            $total_bill = $order->billInfo->amount + $order->billInfo->vat;
                                            $given_amount = $order->billInfo->given_amount; 
                                        @endphp
                                        <tr class="tabletitle">
                                            <td class="Rate"><h2>Total</h2></td>
                                            <td></td>
                                            <td class="payment"><h2>{{ $order->orderRestaurant->currency_symbol }} {{ number_format((float)$total_bill, 2, '.', '') }}</h2></td>
                                        </tr>
                                    @else
                                        <tr class="tabletitle">
                                            <td class="Rate"><h2>*Vat Includeed</h2></td>
                                            <td></td>
                                            <td class="payment"><h2>{{ $order->orderRestaurant->currency_symbol }} {{  $order->billInfo->vat }}</h2></td>
                                        </tr>
                                        @php 
                                            $total_bill = $order->billInfo->amount + $order->billInfo->vat;
                                            $given_amount = $order->billInfo->given_amount; 
                                        @endphp
                                        <tr class="tabletitle">
                                            <td class="Rate"><h2>Total</h2></td>
                                            <td></td>
                                            <td class="payment"><h2>{{ $order->orderRestaurant->currency_symbol }} {{ number_format((float)$order->billInfo->amount, 2, '.', '') }}</h2></td>
                                        </tr>
                                    @endif
                                  


                                    <tr class="tabletitle">
                                        <td class="Rate"><h2>Given Amount</h2></td>
                                        <td></td>
                                        <td class="payment"><h2>{{ $order->orderRestaurant->currency_symbol }} {{ $given_amount }}</h2></td>
                                    </tr>
                                    <tr class="tabletitle">
                                        <td class="Rate"><h2>Returned Amount</h2></td>
                                        <td></td>
                                        <td class="payment"><h2>{{ $order->orderRestaurant->currency_symbol }} {{ number_format((float)$given_amount-$total_bill, 2, '.', '') }}</h2></td>
                                    </tr>
                                </table>
                            </div><!--End Table-->
                            <div class="legalcopy">
                                <p class="legal text-center"><strong>Thank you for coming here!</strong>  
                                </p>
                            </div>
                        </div><!--End InvoiceBot-->
                        <div class="mt-1">
                            <p class="legal text-center mb-0" style="font-size: 7px"><strong>Powered By: Beatbugs IT </strong>  
                            </p>
                        </div>
                        <br>



                        <center id="top">
                        
                            <div class="info">
                                <h2>{{ $order->orderRestaurant->name }}</h2>
                            </div><!--End Info-->
                        </center><!--End InvoiceTop-->
                        <div id="mid">
                            <div class="info">

                                <h2>Token No: #{{ date('y', strtotime($order->created_at)) }}{{ $order->id }}</h2>
                                <h2>Date : {{ date('M d, Y', strtotime($order->created_at)) }}</h2>
                                <h2>Contact Info</h2>
                                <p>
                                    Address : {{ $order->orderRestaurant->address }}</br>
                                    Email   : {{ $order->orderRestaurant->clientInfo->email }}</br>
                                    Phone   : {{ $order->orderRestaurant->phone }}</br>
                                </p>
                            </div>
                        </div><!--End Invoice Mid-->
                        <div id="bot">
                            <div id="table">
                                <table>
                                    <tr class="tabletitle">
                                        <td class="item"><h2>Item</h2></td>
                                        <td class="Hours"><h2>Qty</h2></td>
                                        <td class="Rate"><h2>Sub Total</h2></td>
                                    </tr>
                                    @foreach($order->detailInfo as $item)
                                    <tr class="service">
                                        <td class="tableitem"><p class="itemtext">{{ $item->orderDetailMenu->name }}</p></td>
                                        <td class="tableitem"><p class="itemtext">{{ $item->qty }}</p></td>
                                        <td class="tableitem"><p class="itemtext">{{ $order->orderRestaurant->currency_symbol }}{{ $item->unit_price * $item->qty }}</p></td>
                                    </tr>
                                    @endforeach
                                    <tr class="tabletitle">
                                        <td class="Rate">Total</td>
                                        <td></td>
                                        <td class="payment">{{$order->billInfo->amount + $order->billInfo->discount }}</td>
                                    </tr>
                                    <tr class="tabletitle">
                                        <td class="Rate">Discount(-)</td>
                                        <td></td>
                                        <td class="payment">{{$order->billInfo->discount }}</td>
                                    </tr>
                                    <tr class="tabletitle">
                                        <td class="Rate text-right">=</td>
                                        <td></td>
                                        <td class="payment">{{$order->billInfo->amount }}</td>
                                    </tr>
                                    @if($vat_status == 1)

                                        <tr class="tabletitle">
                                            <td class="Rate"><h2>Vat</h2></td>
                                            <td></td>
                                            <td class="payment"><h2>{{ $order->orderRestaurant->currency_symbol }} {{  $order->billInfo->vat }}</h2></td>
                                        </tr>
                                        @php 
                                            $total_bill = $order->billInfo->amount + $order->billInfo->vat;
                                            $given_amount = $order->billInfo->given_amount; 
                                        @endphp
                                        <tr class="tabletitle">
                                            <td class="Rate"><h2>Total</h2></td>
                                            <td></td>
                                            <td class="payment"><h2>{{ $order->orderRestaurant->currency_symbol }} {{ number_format((float)$total_bill, 2, '.', '') }}</h2></td>
                                        </tr>
                                    @else
                                        <tr class="tabletitle">
                                            <td class="Rate"><h2>*Vat Includeed</h2></td>
                                            <td></td>
                                            <td class="payment"><h2>{{ $order->orderRestaurant->currency_symbol }} {{  $order->billInfo->vat }}</h2></td>
                                        </tr>
                                        @php 
                                            $total_bill = $order->billInfo->amount + $order->billInfo->vat;
                                            $given_amount = $order->billInfo->given_amount; 
                                        @endphp
                                        <tr class="tabletitle">
                                            <td class="Rate"><h2>Total</h2></td>
                                            <td></td>
                                            <td class="payment"><h2>{{ $order->orderRestaurant->currency_symbol }} {{ number_format((float)$order->billInfo->amount, 2, '.', '') }}</h2></td>
                                        </tr>
                                    @endif
                                  


                                    <tr class="tabletitle">
                                        <td class="Rate"><h2>Given Amount</h2></td>
                                        <td></td>
                                        <td class="payment"><h2>{{ $order->orderRestaurant->currency_symbol }} {{ $given_amount }}</h2></td>
                                    </tr>
                                    <tr class="tabletitle">
                                        <td class="Rate"><h2>Returned Amount</h2></td>
                                        <td></td>
                                        <td class="payment"><h2>{{ $order->orderRestaurant->currency_symbol }} {{ number_format((float)$given_amount-$total_bill, 2, '.', '') }}</h2></td>
                                    </tr>
                                </table>
                            </div><!--End Table-->
                        
                        </div><!--End InvoiceBot-->
                      


                    </div><!--End Invoice-->
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