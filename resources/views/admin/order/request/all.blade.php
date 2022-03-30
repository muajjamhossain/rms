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
                        <h3 class="card-title card_top_title"><i class="fa fa-gg-circle"></i> All Requested Orders Information</h3>
                    </div>
                    <div class="col-md-4 text-right">
                        {{-- <a href="{{url('admin/restaurant/create')}}" class="btn btn-md btn-primary waves-effect card_top_button"><i class="fa fa-plus-circle"></i> Add Restaurant</a> --}}
                    </div>
                    <div class="clearfix"></div>
                </div>

                <form action="{{ route('typrWiseOrderRequest') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title card_top_title">
                        </div>
                        <div class="col-md-4 text-right">

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="CustType" type="radio" id="dineIn" {{ @$orders[0]->type==1? 'checked' : ''}}  value="1" checked>
                                <label class="form-check-label" for="dineIn">Dine In</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="CustType" type="radio" id="takeAway" {{ @$orders[0]->type==2? 'checked' : ''}} value="2">
                                <label class="form-check-label" for="takeAway">Take Away</label>
                            </div>
                            <div class="form-check form-check-inline">
                               <button Type="submit" class="btn btn-success">SEARCH</button>
                            </div>
                            
                        </div>
                        <div class="clearfix"></div>
                    </div>
               </form>

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive" id="table">
                            <table id="datatable" class="table table-bordered custom_table mb-0 with-image">
                                <thead>
                                    <tr>
                                        <th>Phone</th>
                                        <th>Total Amount</th>
                                        <th>Table No.</th>
                                        @if(Auth::user()->role_id != 2)
                                        <th>Action</th>
                                        @endif
                                        <th>Request At</th>
                                        <th>See Order Items</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $data)
                                    <tr>
                                        <td>{{$data->phone}}</td>
                                        <td>{{$data->total_amount}}</td>
                                        <td>{{ $data->table_no }}</td>
                                        @if(Auth::user()->role_id != 2)
                                        <td>
                                            <button class="btn btn-success" id="confirm" onClick="changeStatus('{{ $data->slug }}',2)"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Confirm</button>
                                            <button class="btn btn-danger" id="cancel" onClick="changeStatus('{{ $data->slug }}',5)"><i class="fa fa-ban" aria-hidden="true"></i> Cancel</button>
                                        </td>
                                        @endif
                                        <td>{{ date('h:i:A', strtotime($data->created_at)) }}</td>
                                        <td>
                                            <a href="{{url('admin/order-request/view/'.$data->slug.'/1')}}"><i class="fa fa-eye fa-lg view_icon"></i></a>
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
@endsection
@push('js')
    <script src="{{asset('contents/admin')}}/assets/js/jquery.datatables.min.js"></script>
    <script src="{{asset('contents/admin')}}/assets/js/datatables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({ "bSort" : false });

            setInterval(function(){ 
                $.get('{{ url('admin/order-request/loadData/'.$slug) }}', function(data){
                        $('#table').empty().append(data);
                        $('#datatable').DataTable({ "bSort" : false });
                }); 
            }, 10000);

            this.changeStatus = function(slug, action){
                if(action == 2 || action == 5) {
                    $.get('{{ url('admin/order-request/data/'.$slug) }}/'+slug+'/'+action, function(data){
                        $('#table').empty().append(data);
                        $('#datatable').DataTable({ "bSort" : false });
                        window.location.reload();
                        Swal.fire({
                            title : 'Updated!',
                            text : 'Order has been updated.',
                            icon : 'success',
                            timer : 1000
                        })
                    });
                }
            }

        } );
    </script>
@endpush
