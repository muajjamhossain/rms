<!-- Modal -->
<div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">ADD MENU</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('admin/menu/'.$restaurant->slug) }}" method="post" enctype="multipart/form-data" data-parsley-validate="" id="formAddMenu">
                @csrf
                <div class="modal-body">
                    <div class="form-group row custom_form_group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Name:<span class="req_star">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" value="{{old('name')}}" required="" data-parsley-required-message="Please enter name">
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_name">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('size') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Size:<span class="req_star">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" data-role="tagsinput" class="form-control tagsinput" name="size" value="{{old('size')}}"  required="" data-parsley-required-message="Please enter the size">
                            @if ($errors->has('size'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('size') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_size">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row custom_form_group{{ $errors->has('price') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Price:<span class="req_star">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" data-role="tagsinput" class="form-control tagsinput" name="price" value="{{old('price')}}"  required="" data-parsley-required-message="Please enter the price">
                            @if ($errors->has('price'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_price">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('actual_cost') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Actual Cost:<span class="req_star">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" data-role="tagsinput" class="form-control tagsinput" name="actual_cost" value="{{old('actual_cost')}}"  required="" data-parsley-required-message="Please enter the actual_cost">
                            @if ($errors->has('actual_cost'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('actual_cost') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_actual_cost">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row custom_form_group">
                        <label class="col-sm-3 control-label">Menu Tag:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="menu_tag" data-role="tagsinput" value="{{old('menu_tag')}}"   placeholder="Please enter the menu tag">
                            
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Description:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="description" value="{{old('description')}}">
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
                                <option value="{{$category->id}}">{{$category->name}}</option>
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
                        <label class="col-sm-3 control-label">Services:<span class="req_star">*</span></label>
                        <div class="col-sm-9 pt-1">
                            <input type="checkbox" class="" name="addons" value="1"> Addons
                            <input type="checkbox" class="" name="dining_service" class="ml-5" checked> Dining
                            <input type="checkbox" class="" name="takeaway_service" class="ml-5" checked> Take Away
                         
                            
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
                    <button type="submit" id="submitBtn" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function(){
        $(".tagsinput").tagsinput('items');
        $(".tagsinput").val();
    })
</script>
