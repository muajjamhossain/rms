@extends('layouts.admin')
@push('css') 
    <link href="{{asset('contents/admin')}}/assets/css/datatables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Packages</h4>
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
          text: 'Package Has Successfully Deleted!'
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
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title card_top_title"><i class="fa fa-gg-circle"></i> All Packages</h3>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{url('admin/package/create')}}" class="btn btn-md btn-primary waves-effect card_top_button"><i class="fa fa-plus-circle"></i> Add Package</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered custom_table mb-0 with-image">
                                <thead>
                                    <tr>
                                        <th>Sl NO.</th>
                                        <th>Name</th>
                                        <th>Restaurants</th>
                                        <th>Employees</th>
                                        <th>Duration</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($all as $data)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{$data->name}}</td>
                                        <td>{{$data->no_of_rstrt}}</td>
                                        <td>{{$data->no_of_emp}}</td>
                                        <td>{{$data->no_of_months}} months</td>
                                        <td>{{$data->price}}</td>
                                        <td>
                                            @if($data->status == 1)
                                                <span class="badge badge-success">Published</span>
                                            @else
                                                <span class="badge badge-warning">Unpublished</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{url('admin/package/'.$data->id.'/edit')}}"><i class="fa fa-pencil-square fa-lg edit_icon"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer card_footer_expode">
                <a href="#" class="btn btn-secondary waves-effect">PRINT</a>
                <a href="#" class="btn btn-warning waves-effect">EXCEL</a>
                <a href="#" class="btn btn-success waves-effect">PDF</a>
            </div>
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
