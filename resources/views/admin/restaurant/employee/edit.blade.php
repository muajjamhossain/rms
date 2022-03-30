<!-- Modal -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">UPDATE EMPLOYEE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" enctype="multipart/form-data" data-parsley-validate="" id="formEditEmployee" data-id="{{ $employee->id }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group row custom_form_group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Name:<span class="req_star">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" value="{{$employee->userInfo->name}}" required="" data-parsley-required-message="Please enter name">
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_name">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Email:<span class="req_star">*</span></label>
                        <div class="col-sm-9">
                            <input type="emailpassword" class="form-control" name="email" required="" data-parsley-required-message="Please enter email" value="{{ $employee->userInfo->email }}">
                            @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_email">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Password:<span class="req_star">*</span></label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password" id="password">
                            @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_password">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Confirm Password:<span class="req_star">*</span></label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password_confirmation" data-parsley-equalto="#password"data-parsley-equalto-message="Password Unmatched">
                            @if ($errors->has('password_confirmation'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_password_confirmation">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Phone:<span class="req_star">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="phone" required="" data-parsley-required-message="Please enter phone" value="{{$employee->userInfo->phone}}">
                            @if ($errors->has('phone'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_phone">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('address') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Address:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="address" required=""
                            data-parsley-required-message="Please enter address" value="{{ $employee->address }}">
                            @if ($errors->has('address'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_address">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Role:<span class="req_star">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control" name="role_id" required=""
                            data-parsley-required-message="Please select a role">
                                <option value="">Select a role</option>
                                @foreach($roles as $role)
                                <option value="{{$role->role_id}}" {{ $employee->userInfo->role_id == $role->role_id ? 'selected' : '' }}>{{$role->role_name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('role_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('role_id') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_role_id">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row custom_form_group">
                        <label class="col-sm-3 control-label">Photo:</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="file" id="imgInp" name="pic" data-parsley-max-file-size="500">
                                <div style="color: #dc3545; font-size: 80%;" id="error_pic">
                                </div>
                                <img id='img-upload'/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">                
                    <button type="submit" class="btn btn-primary" id="btnUpdateemployee">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>