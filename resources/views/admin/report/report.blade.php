@extends('layouts.admin')
@push('css') 
    <link href="{{asset('contents/admin')}}/assets/css/datatables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Report</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="#">Dashboard</a></li>
            <li class="active">Home</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <div class="card">
            <form action="{{ url('admin/custom-report/'.$restaurant->slug) }}" method="post">
                @csrf
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title card_top_title"><i class="fa fa-eye"></i> See Custom Report </h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row custom_form_group{{ $errors->has('from') ? ' has-error' : '' }}">
                        <label class="col-sm-4 control-label">Report From:</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" name="from" value="{{ date('Y-m-d', strtotime($from)) }}">
                            @if ($errors->has('from'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('from') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('to') ? ' has-error' : '' }}">
                        <label class="col-sm-4 control-label">Report To:</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" name="to" value="{{ date('Y-m-d', strtotime($to)) }}">
                            @if ($errors->has('to'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('to') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row custom_form_group">
                        <label class="col-sm-4 control-label">Payment Gateway:<span class="req_star">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="pay_by">
                                <option value="0">All</option>
                                <option value="1">Hand Cash</option>
                                <option value="2"> Bkash</option>
                                <option value="3"> Nagad</option>
                                <option value="4"> DBBL</option>
                                <option value="5">City</option>
                                <option value="6">Food Panda</option>
                                <option value="7">Hungrynaki</option>
                                <option value="8">Pathao Food</option>
                            </select>

                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary" type="sumbit">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="fa fa-file-text" aria-hidden="true"></i> Short Report From {{ date('M d, Y', strtotime($from)) }} to {{ date('M d, Y', strtotime($to)) }}</h2>
            </div>
            <div class="card-body">
                <div id="short-report">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="fa fa-truck" aria-hidden="true"></i> Delivered Orders</h4>
                                </div>
                                <div class="card-body">
                                    <div class="badge badge-success">
                                        {{ $delivered_orders->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="fa fa-ban" aria-hidden="true"></i> Cancelled Orders</h4>
                                </div>
                                <div class="card-body">
                                    <div class="badge badge-warning">
                                        {{ $num_of_cancel_orders }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><span>%</span> Total Vat</h4>
                                </div>
                                <div class="card-body">
                                    <div class="badge badge-secondary">
                                         {{@$currency.' '.@$vat }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="fa fa-money" aria-hidden="true"></i> Total Income</h4>
                                </div>
                                <div class="card-body">
                                    <div class="badge badge-info">
                                        {{ @$currency.' '.@$income }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="fa fa-minus-square" aria-hidden="true"></i> Total Expense</h4>
                                </div>
                                <div class="card-body">
                                    <div class="badge badge-danger">
                                        @if(is_float($expense))
                                        {{@$currency}} {{ $expense }}
                                        @else
                                        {{@$currency}} {{ round($expense) }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><span>π</span></i> Total Profit</h4>
                                </div>
                                <div class="card-body">
                                    <div class="badge badge-primary">
                                       {{@$currency}} {{ $income - $expense }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-4">
                      <h4 class="card-title">Paid Orders</h4>
                    </div>
                    <div class="col-md-8 d-flex text-right" style="align-items: center">
                      <a href="{{ url('admin/report') }}" class="btn btn-info btn-sn">ALL</a>
                      <a href="{{ url('admin/report/gateway/1') }}" class="btn btn-success btn-sn">Hand Cash</a>
                      <a href="{{ url('admin/report/gateway/2') }}" class="btn btn-primary btn-sn">Bkash</a>
                      <a href="{{ url('admin/report/gateway/3') }}" class="btn btn-secondary btn-sn"> Nagad</a>
                      <a href="{{ url('admin/report/gateway/4') }}" class="btn btn-success btn-sn">DBBL</a>
                      <a href="{{ url('admin/report/gateway/5') }}" class="btn btn-danger btn-sn">City</a>
                      <a href="{{ url('admin/report/gateway/6') }}" class="btn btn-warning btn-sn">Food Panda</a>
                      <a href="{{ url('admin/report/gateway/7') }}" class="btn btn-info btn-sn">Hungrynaki</a>
                      <a href="{{ url('admin/report/gateway/8') }}" class="btn btn-success btn-sn">Pathao Food</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table">
                    <table id="datatable" class="table table-bordered custom_table mb-0">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Inv No.</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Confirmed By</th>
                                <th>Order Type</th>
                                <th>Total Bill</th>
                                <th>Discount</th>
                                <th>Vat</th>
                                <th>Bill</th>
                                <th>Payment By</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($delivered_orders as $data)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $data->billInfo->invoice_no }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->phone }}</td>
                                    <td>{{ @$data->userInfo->name ?? '' }}</td>
                                    <td>
                                        @if($data->type == 1)
                                            Dine In
                                        @elseif($data->type == 2)
                                            Take Away
                                        @endif
                                    </td>
                                    <td>{{ $data->total_amount }}</td>
                                    <td>{{ $data->billInfo->discount }}</td>
                                    <td>{{ $data->billInfo->vat }}</td>
                                    <td>{{ $data->billInfo->amount + $data->billInfo->vat }}</td>
                                    <td>
                                            @if($data->billInfo->pay_by == 1) Hand Cash
                                            @elseif($data->billInfo->pay_by == 2) Bkash
                                            @elseif($data->billInfo->pay_by == 3) Nagad
                                            @elseif($data->billInfo->pay_by == 4) DBBL
                                            @elseif($data->billInfo->pay_by == 5) City
                                            @elseif($data->billInfo->pay_by == 6) Food Panda
                                            @elseif($data->billInfo->pay_by == 7) Hungrynaki
                                            @elseif($data->billInfo->pay_by == 7) Pathao Food
                                            @endif
                                    </td>
                                    <td>{{ $data->created_at }}</td>
                                    <td>
                                        <a href="{{url('admin/order-request/view/'.$data->slug.'/6')}}"><i class="fa fa-eye fa-lg view_icon"></i></a>
                                        <a href="{{url('admin/bill/invoice/'.$data->slug)}}"><i class="fa fa-file-text edit_icon fa-lg" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                                <tr>
                                    <td>Total</td>
                                    <td>==</td>
                                    <td>==</td>
                                    <td>==</td>
                                    <td>==</td>
                                    <td>==</td>
                                    <td> {{$total_amount}}</td>
                                    <td>  {{$discount}}</td>
                                    <td> {{$vat}}</td>
                                    <td> {{$income + $vat}}</td>
                                    <td>==</td>
                                    <td>==</td>
                                    <td>==</td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>              
    </div>
</div>                      
@endsection
@push('js')
    <script src="{{asset('contents/admin')}}/assets/js/jquery.datatables.min.js"></script>
    <script src="{{asset('contents/admin')}}/assets/js/datatables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({ "bSort" : false });
        } );
    </script>
@endpush
