@extends('layouts.admin')
@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('contents/admin')}}/assets/css/parsley.css">
@endpush
@section('content')
@php 
    $payment_way = $order->orderRestaurant->payment_way;
    if($order->billInfo) {
        $url = url('admin/bill/pendings/'.$order->slug);
    } else {
        $url = url('admin/bill/'.$order->slug);
    }
@endphp
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
                        <button data-toggle="modal" data-target="#takeBillModal" class="btn btn-md btn-primary waves-effect card_top_button" data-backdrop='static' data-keyboard='false' @if($order->orderRestaurant->discount > 0 || $order->orderRestaurant->trusted_manager == 0) onfocusout="billCal()" @endif><i class="fa fa-money" aria-hidden="true"></i> Take Bill</button>
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
                                                <td>{{$item->orderDetailMenu->name}}</td>
                                            </tr>
                                            <tr>
                                                <td>Category</td>
                                                <td>:</td>
                                                <td>{{$item->orderDetailMenu->menuCategory->name}}</td>
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
                                                    <img class="img-fluid" src="{{asset('uploads/foods/'.$item->orderDetailMenu->photo)}}" alt="photo" style="max-width: 150px" />
                                                </td>
                                            </tr>
                                        </table>
                                    @endforeach
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="takeBillModal" tabindex="-1" role="dialog" aria-labelledby="takeBillModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="takeBillModalLongTitle">Take Bill</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" enctype="multipart/form-data" data-parsley-validate="" id="billForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group row custom_form_group{{ $errors->has('bill') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Bill:<span class="req_star">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="bill" value="{{$order->total_amount}}" required="" data-parsley-required-message="Please enter total bill" id="bill" readonly>
                            @if ($errors->has('bill'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bill') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_bill">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('discount') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Discount:<span class="req_star">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control discount_amount" name="discount" value="{{ $order->orderRestaurant->discount > 0 ? $order->total_amount * $order->orderRestaurant->discount / 100 : 0 }}"  required="" data-parsley-required-message="Please enter the discount" id="discount" @if($order->orderRestaurant->trusted_manager == 1) onfocusout="billCal()" @else readonly @endif>
                            @if ($errors->has('discount'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('discount') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_discount">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row custom_form_group{{ $errors->has('vat') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Vat:<span class="req_star">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control vat_amount" name="vat" value="{{$order->orderRestaurant->vat}}" required="" data-parsley-required-message="Please enter total bill" id="vat" readonly>
                            @if ($errors->has('vat'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('vat') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_vat">
                            </div>
                        </div>
                    </div>

                    @if($order->orderRestaurant->vat_status==1)
                    <div class="form-group row custom_form_group{{ $errors->has('amount_with_vat') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Bill Amount (Vat Inc):<span class="req_star">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control bill_amount" name="amount_with_vat" value="{{old('amount_with_vat')}}"  required="" data-parsley-required-message="Please enter the bill amount" id="amount_with_vat" readonly="">
                            @if ($errors->has('amount_with_vat'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('amount_with_vat') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_amount_with_vat">
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="form-group row custom_form_group{{ $errors->has('amount_with_vat') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Bill Amount (Vat Xld):<span class="req_star">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control bill_amount" name="amount_with_vat" value="{{old('amount_with_vat')}}"  required="" data-parsley-required-message="Please enter the bill amount" id="amount_with_Xld_vat" readonly="">
                            @if ($errors->has('amount_with_vat'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('amount_with_vat') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_amount_with_vat">
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($payment_way === 0 || $order->billInfo)
                    <div class="form-group row custom_form_group{{ $errors->has('given_amount') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Customer Given:<span class="req_star">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="given_amount" value="{{old('given_amount')}}"  required="" data-parsley-required-message="Please enter the bill amount" id="given_amount">
                            @if ($errors->has('given_amount'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('given_amount') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_amount_with_vat">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('pay_by') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Pay By:<span class="req_star">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control" name="pay_by" required=""
                            data-parsley-required-message="Please select a payment way option">
                                <option value="">Select a payment way</option>
                                <option value="1">Hand Cash</option>
                                <option value="2"> Bkash</option>
                                <option value="3"> Nagad</option>
                                <option value="4"> DBBL</option>
                                <option value="5">City</option>
                                <option value="6">Food Panda</option>
                                <option value="7">Hungrynaki</option>
                                <option value="8">Pathao Food</option>
                            </select>

                            @if ($errors->has('pay_by'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('pay_by') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_pay_by">
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
                <div class="modal-footer">                
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="{{asset('contents/admin')}}/assets/js/parsley.min.js"></script>
<script>
       
    $(document).ready(function(){

            // $(".discount_amount").keyup(function(){
            //     var discountAmount = $(".discount_amount").val();

            //     if(discountAmount=='' || null){
            //         var discountAmount = $(this).val(int(0)); 
            //     }
    
            //     var bill_amount = $(".bill_amount").val();
            //     var vat_amount = $(".vat_amount").val();
    
            //     var total_bill_withOut_discount =  bill_amount - discountAmount;

            //     var total_bill_vat = total_bill_withOut_discount +  ( total_bill_withOut_discount * vat_amount / 100);

            //     $('.bill_amount').val(total_bill_vat);
    
            // });
            includeVat();
           exudeeVat();
       
    });

    function billCal(){
        exudeeVat();
        includeVat();
    }
    

    function includeVat() {
        var amount =  document.getElementById('bill').value;
        var discount = document.getElementById('discount').value;
        var vat = document.getElementById('vat').value;
        var bill_amount = amount - discount;
        var bill_amount_with_vat = bill_amount + ( bill_amount * vat / 100);
        document.getElementById('amount_with_vat').value = bill_amount_with_vat;
    }
    function exudeeVat() {
        var amount =  document.getElementById('bill').value;
        var discount = document.getElementById('discount').value;
        var vat = document.getElementById('vat').value;
        var bill_amount = amount - discount;
        var bill_amount_with_xld_vat = bill_amount - ( bill_amount * vat / 100);
        document.getElementById('amount_with_Xld_vat').value = bill_amount_with_xld_vat;
    }

    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#billForm').submit(function(e){
            e.preventDefault();
            var formData = $(this);
            $.ajax({
                url: '{{ $url }}',
                type: 'POST',
                data: formData.serialize()
            })
            .done(function(data){
                window.location.href = "{{ url('admin/bill/invoice/'.$order->slug) }}";
                $('#takeBillModal').modal('hide');
            })
            .fail(function(error){
                var error = error.responseJSON;
                $('#takeBillModal #error_bill').empty();
                $('#takeBillModal #error_discount').empty();
                $('#takeBillModal #error_error_amount_with_vat').empty();

                @if($payment_way === 0)
                $('#takeBillModal #error_pay_by').empty();
                $('#takeBillModal #error_given_amount').empty();
                @endif
                
                if(error.errors.bill != undefined) {
                    $('#takeBillModal #error_bill').append('<strong>'+error.errors.bill[0]+'</strong>');
                }
                if(error.errors.discount != undefined) {
                    $('#takeBillModal #error_discount').append('<strong>'+error.errors.discount[0]+'</strong>');
                }
                if(error.errors.amount_with_vat != undefined) {
                    $('#takeBillModal #error_amount_with_vat').append('<strong>'+error.errors.amount_with_vat[0]+'</strong>');
                }

                @if($payment_way === 0)
                if(error.errors.pay_by != undefined) {
                    $('#takeBillModal #error_pay_by').append('<strong>'+error.errors.pay_by[0]+'</strong>');
                }
                if(error.errors.given_amount != undefined) {
                    $('#takeBillModal #error_given_amount').append('<strong>'+error.errors.given_amount[0]+'</strong>');
                }
                @endif
            });
        });
    });
</script>
@endpush
