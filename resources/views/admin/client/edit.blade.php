@extends('layouts.admin')
@push('css') 
    <link href="{{asset('contents/admin')}}/assets/css/parsley.css" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Clients</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="#">Dashboard</a></li>
            <li class="active">Home</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form class="form-horizontal" method="post" action="{{url('admin/client/'.$client->id)}}" enctype="multipart/form-data" data-parsley-validate="">
            @csrf
            @method('put')
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title card_top_title"><i class="fa fa-gg-circle"></i> Update Client</h3>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{url('admin/edit-package/'.$client->id)}}" class="btn btn-md btn-success waves-effect card_top_button"><i class="fa fa-gift"></i> Package Enroll</a>
                            <a href="{{url('admin/client')}}" class="btn btn-md btn-primary waves-effect card_top_button"><i class="fa fa-th"></i> All Client</a>
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
                                  title: 'Client updated successfully'
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
                            <input type="text" class="form-control" name="name" value="{{$client->name}}" required="" data-parsley-required-message="Please enter name">
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Email:<span class="req_star">*</span></label>
                        <div class="col-sm-7">
                            <input type="email" class="form-control" name="email" value="{{$client->email}}" data-parsley-type="email" required="" data-parsley-required-message="Please enter email">
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
                            <input type="password" class="form-control" name="password" minlength="8" value="" data-parsley-minlength="8" id="password"data-parsley-minlength-message="Please enter a password with minimum 8 digit">
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
                            <input type="password" class="form-control" name="password_confirmation" data-parsley-equalto="#password" data-parsley-required-message="Please enter the password again" data-parsley-equalto-message="This confirm password is not the same as password">
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('company_name') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Company Name:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="company_name" value="{{$client->company_name}}">
                            @if ($errors->has('company_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('company_name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row custom_form_group">
                        <label class="col-sm-3 control-label">Phone:<span class="req_star">*</span></label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="phone" value="{{$client->phone}}" required=""
                            data-parsley-required-message="Please enter phone number">
                        </div>
                    </div>
                    <div class="form-group row custom_form_group">
                        <label class="col-sm-3 control-label">Address:<span class="req_star">*</span></label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="address" value="{{$client->address}}" required="" data-parsley-required-message="Please enter address">
                        </div>
                    </div>
                    <div class="form-group row custom_form_group">
                        <label class="col-sm-3 control-label">Photo:</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file btnu_browse">
                                        Browse… <input type="file" name="pic" id="imgInp" data-parsley-max-file-size="500">
                                    </span>
                                </span>
                                <input type="text" class="form-control" readonly>
                            </div>
                            @if($client->photo!='')
                                <img class="table_image_100" src="{{asset('uploads/users/'.$client->photo)}}" alt="photo"/ id="img-upload">
                            @else
                                <img id='img-upload'/>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row custom_form_group">
                        <label class="col-sm-3 control-label">Status:</label>
                        <div class="col-sm-7 pt-2">
                            <input type="radio" name="status" value="1" {{ $client->status == 1 ? 'checked' : '' }}> Active
                            <input type="radio" class="ml-2" name="status" value="0" {{ $client->status == 0 ? 'checked' : '' }}> Inactive
                        </div>
                    </div>
                </div>
                <div class="card-footer card_footer_button text-center">
                <button type="submit" class="btn btn-primary waves-effect">UPDATE</a>
            </div>
        </div>
    </form>
</div>
</div>
@endsection
@push('js')
<script src="{{asset('contents/admin')}}/assets/js/parsley.min.js"></script>
<script>
    window.Parsley.addValidator('maxFileSize', {
      validateString: function(_value, maxSize, parsleyInstance) {
        if (!window.FormData) {
          alert('You are making all developpers in the world cringe. Upgrade your browser!');
          return true;
        }
        var files = parsleyInstance.$element[0].files;
        return files.length != 1  || files[0].size <= maxSize * 1024;
      },
      requirementType: 'integer',
      messages: {
        en: 'This file should not be larger than %s Kb'
      }
    });

    $(function(){
        $('#date').val(moment('{{ $client->subs_finishing_date }}').format('YYYY-MM-DD'));
    })
</script>
@endpush