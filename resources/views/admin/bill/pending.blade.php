@extends('layouts.admin')
@push('css') 
    <link href="{{asset('contents/admin')}}/assets/css/datatables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endpush

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
                        <h3 class="card-title card_top_title"><i class="fa fa-gg-circle"></i> All Pending Bills
                    </div>
                    <div class="col-md-4 text-right">
                        {{-- <a href="{{url('admin/bill/pendings/'.$restaurant->slug)}}" class="btn btn-md btn-primary waves-effect card_top_button"><i class="fa fa-credit-card"></i> Pending Bills</a> --}}
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
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Order Type</th>
                                        <th>Total Amount</th>
                                        <th>Invoice No.</th>
                                        <th>Action</th>
                                        <th>Request At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($non_paid_bills as $data)
                                    <tr>
                                        <td>{{$data->orderInfo->name}}</td>
                                        <td>{{$data->orderInfo->phone}}</td>
                                        <td>
                                            @if($data->orderInfo->type == 1)
                                                Dine In
                                            @elseif($data->orderInfo->type == 2)
                                                Take Away
                                            @endif
                                        </td>
                                        <td>{{$data->orderInfo->total_amount}}</td>
                                        <td>{{$data->invoice_no}}</td>
                                        <td>
                                            <a href="{{url('admin/bill/view/'.$data->orderInfo->slug)}}" class="btn btn-success" id="confirm"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Bill View</a>
                                            <a href="{{url('admin/bill/invoice/'.$data->orderInfo->slug)}}"><i class="fa fa-file-text edit_icon fa-lg" aria-hidden="true"></i></a>
                                        </td>
                                        <td>{{ $data->orderInfo->created_at }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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
    @if(Session::has('success'))
        <script>
            Swal.fire({
              icon: 'success',
              title: 'Order Placed!',
              text: 'Order Has Successfully placed!',
              timer: '1500'
            })
        </script>
    @endif
    @if(Session::has('error'))
        <script>
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        </script>
    @endif
@endpush
