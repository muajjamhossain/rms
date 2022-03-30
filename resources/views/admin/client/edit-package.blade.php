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
        <form class="form-horizontal" method="post" action="{{url('admin/edit-package/'.$client->id)}}" enctype="multipart/form-data" data-parsley-validate="">
            @csrf
            @method('put')
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title card_top_title"><i class="fa fa-gg-circle"></i> Update Package</h3>
                        </div>
                        <div class="col-md-4 text-right">
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
                                  title: 'Package updated successfully'
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
                            @if(Session::has('limit'))
                            <script>
                                Swal.fire({
                                    title: 'This package is not eligible',
                                    text: 'Please check your running employees and restaurants',
                                    icon: 'warning',
                                    confirmButtonText: 'Ok'
                                })
                            </script>
                            @endif
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('package_id') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Package:<span class="req_star">*</span></label>
                        <div class="col-sm-7">
                            <select name="package_id" class="form-control" required data-parsley-required-message="Please select a package" onfocusout="getPrice()" id="package">
                                <option value="">Select a package</option>
                                @foreach($packages as $package)
                                    <option value="{{ $package->id }}" {{ $package->id == $client->packageInfo->id ? 'selected' : '' }}>{{ $package->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('package_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('package_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('price') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Price:<span class="req_star">*</span></label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="price" id="price" readonly value="{{ $client->packageInfo->price }}">
                            @if ($errors->has('price'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('discount') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Discount:<span class="req_star">*</span></label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="discount" id="discount" value="0">
                            @if ($errors->has('discount'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('discount') }}</strong>
                            </span>
                            @endif
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

    function getPrice() {
        var packageId, price;
        packageId = document.querySelector('#package').value;
        @foreach($packages as $package)
            if(packageId == {{ $package->id }}) {
                price = {{ $package->price }};
            }
        @endforeach
        document.querySelector('#price').value = price;
    }

</script>
@endpush