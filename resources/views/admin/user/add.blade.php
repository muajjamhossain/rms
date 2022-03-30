@extends('layouts.admin')
@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Users</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="#">Dashboard</a></li>
            <li class="active">Home</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form class="form-horizontal" method="post" action="{{url('dashboard/user/submit')}}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title card_top_title"><i class="fa fa-gg-circle"></i> User Registration</h3>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{url('dashboard/user')}}" class="btn btn-md btn-primary waves-effect card_top_button"><i class="fa fa-th"></i> All User</a>
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
                                  title: 'Created successfully'
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
                            <input type="text" class="form-control" name="name" value="{{old('name')}}">
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row custom_form_group">
                        <label class="col-sm-3 control-label">Phone:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="phone" value="{{old('phone')}}">
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Email:<span class="req_star">*</span></label>
                        <div class="col-sm-7">
                            <input type="email" class="form-control" name="email" value="{{old('email')}}">
                            @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Password:<span class="req_star">*</span></label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" name="password" value="">
                            @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row custom_form_group">
                        <label class="col-sm-3 control-label">Confirm-Password:<span class="req_star">*</span></label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" name="password_confirmation" value="">
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('role') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">User Role:<span class="req_star">*</span></label>
                        <div class="col-sm-4">
                            <select class="form-control" name="role">
                                <option value="">Select User Role</option>
                                @foreach($allRole as $urole)
                                <option value="{{$urole->role_id}}">{{$urole->role_name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('role'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('role') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row custom_form_group">
                        <label class="col-sm-3 control-label">Photo:</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file btnu_browse">
                                        Browse… <input type="file" name="pic" id="imgInp">
                                    </span>
                                </span>
                                <input type="text" class="form-control" readonly>
                            </div>
                            <img id='img-upload'/>
                        </div>
                    </div>
                </div>
                <div class="card-footer card_footer_button text-center">
                <button type="submit" class="btn btn-primary waves-effect">REGISTRATION</a>
            </div>
        </div>
    </form>
</div>
</div>
@endsection
@push('js')

@endpush