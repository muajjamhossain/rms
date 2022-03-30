@extends('layouts.admin')
@push('css') 
    <link href="{{asset('contents/admin')}}/assets/css/parsley.css" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Restaurant</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="#">Dashboard</a></li>
            <li class="active">Home</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form class="form-horizontal" method="post" action="{{url('admin/restaurant/'.$restaurant->id)}}" enctype="multipart/form-data" data-parsley-validate="">
            @csrf
            @method('put')
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title card_top_title"><i class="fa fa-gg-circle"></i> Restaurant Registration</h3>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{url('admin/restaurant')}}" class="btn btn-md btn-primary waves-effect card_top_button"><i class="fa fa-th"></i> All Restaurant</a>
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
                                  title: 'Restaurant updated successfully'
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
                            <input type="text" class="form-control" name="name" value="{{$restaurant->name}}" required="" data-parsley-required-message="Please enter name">
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('url') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Url:<span class="req_star">*</span></label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="url" value="{{$restaurant->url}}" required="" data-parsley-required-message="Please enter url">
                            @if ($errors->has('url'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('url') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row custom_form_group">
                        <label class="col-sm-3 control-label">Phone:<span class="req_star">*</span></label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="phone" value="{{$restaurant->phone}}" required=""
                            data-parsley-required-message="Please enter phone number">
                        </div>
                    </div>
                    <div class="form-group row custom_form_group">
                        <label class="col-sm-3 control-label">Address:<span class="req_star">*</span></label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="address" value="{{$restaurant->address}}" required="" data-parsley-required-message="Please enter address">
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('client_id') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Client:<span class="req_star">*</span></label>
                        <div class="col-sm-4">
                            <select class="form-control" name="client_id" required=""
                            data-parsley-required-message="Please select a client">
                                <option value="">Select a client</option>
                                @foreach($clients as $client)
                                <option value="{{$client->id}}" {{ $client->id == $restaurant->client_id ? 'selected' : '' }}>{{$client->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('client_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('client_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row custom_form_group">
                        <label class="col-sm-3 control-label">Logo:</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file btnu_browse">
                                        Browse… <input type="file" name="pic" id="imgInp" data-parsley-max-file-size="500">
                                    </span>
                                </span>
                                <input type="text" class="form-control" readonly>
                            </div>
                            @if($restaurant->logo!='')
                                <img class="table_image_100" src="{{asset('uploads/logos/'.$restaurant->logo)}}" alt="logo"/ id="img-upload">
                            @else
                                <img id='img-upload'/>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row custom_form_group">
                        <label class="col-sm-3 control-label">Status:</label>
                        <div class="col-sm-7 pt-2">
                            <input type="radio" name="status" value="1" {{ $restaurant->status == 1 ? 'checked' : '' }}> Active
                            <input type="radio" class="ml-2" name="status" value="0" {{ $restaurant->status == 0 ? 'checked' : '' }}> Inactive
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
</script>
@endpush