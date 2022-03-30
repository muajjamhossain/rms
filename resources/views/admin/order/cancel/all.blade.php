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
@if(Session::has('success'))
    <script>
        Swal.fire({
          icon: 'success',
          title: 'Deleted!',
          text: 'Order Has Successfully Deleted!'
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
<h4 class="{{ $errors->has('to') ? ' has-error' : '' }} text-center">
    @if ($errors->has('to'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('to') }}</strong>
    </span>
    @endif
</h4>
<h4 class="{{ $errors->has('from') ? ' has-error' : '' }} text-center">
    @if ($errors->has('from'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('from') }}</strong>
    </span>
    @endif
</h4>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="card-title card_top_title"><i class="fa fa-gg-circle"></i> All Delivered Order Information
                    </div>
                    <div class="col-md-6 ">
                        <form class="form-inline pull-right" action="{{ url('admin/custom-order-report/5/'.$slug) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="inputPassword6">From:</label>
                                <input type="date" class="form-control mx-sm-3" name="from" value="{{ date('Y-m-d', strtotime($from)) }}" >
                            </div>
                            <div class="form-group">
                                <label for="inputPassword6">To:</label>
                                <input type="date" class="form-control mx-sm-3" name="to" value="{{ date('Y-m-d', strtotime($to)) }}" >
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
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
                                        <th>Email</th>
                                        <th>Cancelled By</th>
                                        <th>Cancelled From</th>
                                        <th>Order Type</th>
                                        <th>Delivery Date</th>
                                        <th>Delivery Time</th>
                                        <th>Total Amount</th>
                                        <th>Table No</th>
                                        <th>Status</th>
                                        <th>Request At</th>
                                        <th>See Order Items</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $data)
                                    <tr>
                                        <td>{{$data->name}}</td>
                                        <td>{{$data->phone}}</td>
                                        <td>{{$data->email}}</td>
                                        <td>{{$data->userInfo->name}}</td>
                                        <td>
                                            @if($data->cancel_status == 1)
                                            Request
                                            @elseif($data->cancel_status == 2)
                                            Kitchen
                                            @elseif($data->cancel_status == 3)
                                            Serve
                                            @endif
                                        </td>
                                        <td>
                                            @if($data->type == 1)
                                                Dine In
                                            @elseif($data->type == 2)
                                                Take Away
                                            @endif
                                        </td>
                                        <td>{{$data->delivery_date}}</td>
                                        <td>{{$data->delivery_time}}</td>
                                        <td>{{$data->total_amount}}</td>
                                        <td>{{$data->table_no}}</td>
                                        <td>
                                            <button class="btn btn-danger" id="cancel"><i class="fa fa-ban" aria-hidden="true"></i> Cancelled</button>
                                        </td>
                                        <td>{{ $data->created_at }}</td>
                                        <td>
                                            <a href="{{url('admin/order-request/view/'.$data->slug.'/5')}}"><i class="fa fa-eye fa-lg view_icon"></i></a>
                                            <a href="#" class="delete" data-url="{{ url('admin/order/'.$data->slug) }}" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-trash fa-lg delete_icon"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="card-footer card_footer_expode">
                <a href="#" class="btn btn-secondary waves-effect">PRINT</a>
                <a href="#" class="btn btn-warning waves-effect">EXCEL</a>
                <a href="#" class="btn btn-success waves-effect">PDF</a>
            </div> --}}
        </div>
    </div>
</div>
<!--Delete Modal Information-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="delete-form">
                @csrf
                @method('delete')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure to delete?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
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
