<!-- Modal -->
<div class="modal fade" id="editMenuModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">UPDATE MENU</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" enctype="multipart/form-data" data-parsley-validate="" id="formEditMenu" data-id="{{ $menu->id }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group row custom_form_group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Name:<span class="req_star">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" value="{{$menu->name}}" required="" data-parsley-required-message="Please enter name">
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_name">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('price') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Price:<span class="req_star">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="price" value="{{$menu->price}}" required="" data-parsley-required-message="Please enter the price">
                            @if ($errors->has('price'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_price">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Description:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="description" value="{{$menu->description}}">
                            @if ($errors->has('description'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('cate_id') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Category:<span class="req_star">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control" name="cate_id" required=""
                            data-parsley-required-message="Please select a category">
                                <option value="">Select a category</option>
                                @foreach($restaurant->categoryInfo as $category)
                                <option value="{{$category->id}}" {{ $category->id == $menu->cate_id ? 'selected' : '' }}>{{$category->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('cate_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('cate_id') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_cate_id">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row custom_form_group">
                        <label class="col-sm-3 control-label">Status:</label>
                        <div class="col-sm-9 pt-2">
                            <input type="radio" name="status" value="1" {{ $menu->status == 1 ? 'checked' : '' }}> Active
                            <input type="radio" class="ml-2" name="status" value="0" {{ $menu->status == 0 ? 'checked' : '' }}> Inactive
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('service') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Services:<span class="req_star">*</span></label>
                        <div class="col-sm-9 pt-1">
                            <input type="checkbox" class="" name="dining_service" {{ $menu->dining_service ? 'checked' : '' }}> Dining
                            <input type="checkbox" class="" name="takeaway_service" class="ml-5" {{ $menu->takeaway_service == 1 ? 'checked' : '' }}> Take Away
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_name">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row custom_form_group">
                        <label class="col-sm-3 control-label">Photo:</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="file" id="imgInp" name="pic">
                                <div style="color: #dc3545; font-size: 80%;" id="error_pic">
                                </div>
                                <img id='img-upload'/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">                
                    <button type="submit" class="btn btn-primary" id="btnUpdateMenu">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>