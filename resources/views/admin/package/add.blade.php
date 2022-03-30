@extends('layouts.admin')
@push('css') 
    <link href="{{asset('contents/admin')}}/assets/css/parsley.css" rel="stylesheet" type="text/css" />
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
<div class="row">
    <div class="col-lg-12">
        <form class="form-horizontal" method="post" action="{{url('admin/package')}}" enctype="multipart/form-data" data-parsley-validate="">
            @csrf
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title card_top_title"><i class="fa fa-gg-circle"></i> Create Package</h3>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{url('admin/package')}}" class="btn btn-md btn-primary waves-effect card_top_button"><i class="fa fa-th"></i> All Packages</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="card-body card_form">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-7">
                            @if(Session::has('success'))
                            <script>
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    onOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    }
                                })
                                Toast.fire({
                                  icon: 'success',
                                  title: 'Package Added successfully'
                                })
                            </script>
                            @endif
                            @if(Session::has('error'))
                            <script>
                                Toast.fire({
                                  icon: 'error',
                                  title: 'Something went wrong'
                                })
                            </script>
                            @endif
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Name:<span class="req_star">*</span></label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="name" value="{{old('name')}}" required="" data-parsley-required-message="Please enter the name of the package">
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('no_of_rstrt') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Restaurants:<span class="req_star">*</span></label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" name="no_of_rstrt" value="{{old('no_of_rstrt')}}" required="" data-parsley-required-message="Please enter the number of restaurant">
                            @if ($errors->has('no_of_rstrt'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('no_of_rstrt') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('no_of_emp') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Employees:<span class="req_star">*</span></label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" name="no_of_emp" value="{{old('no_of_emp')}}" required="" data-parsley-required-message="Please enter the number of employees">
                            @if ($errors->has('no_of_emp'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('no_of_emp') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('no_of_months') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Months:<span class="req_star">*</span></label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" name="no_of_months" value="{{old('no_of_months')}}" required="" data-parsley-required-message="Please enter the number of months">
                            @if ($errors->has('no_of_months'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('no_of_months') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('price') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Price:<span class="req_star">*</span></label>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" name="price" value="{{old('price')}}" required="" data-parsley-required-message="Please enter the price">
                            @if ($errors->has('price'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row custom_form_group">
                        <label class="col-sm-3 control-label">Status:</label>
                        <div class="col-sm-7 pt-2">
                            <input type="radio" name="status" value="1"> Active
                            <input type="radio" class="ml-2" name="status" value="0"> Inactive
                        </div>
                    </div>
                </div>
                <div class="card-footer card_footer_button text-center">
                <button type="submit" class="btn btn-primary waves-effect">Create</a>
            </div>
        </div>
    </form>
</div>
</div>
@endsection
@push('js')
<script src="{{asset('contents/admin')}}/assets/js/parsley.min.js"></script>
@endpush