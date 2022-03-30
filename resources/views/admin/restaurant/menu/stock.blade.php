<!-- Modal -->
<div class="modal fade" id="addMenuStockModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">ADD MENU (STOCK)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('admin/menu/'.$restaurant->slug) }}" method="post" enctype="multipart/form-data" data-parsley-validate="" id="formAddStockMenu">
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
                    <div class="form-group row custom_form_group{{ $errors->has('price') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Price:<span class="req_star">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="price" value="{{old('price')}}"  required="" data-parsley-required-message="Please enter the price">
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
                            <input type="text" class="form-control" name="actual_cost" value="{{old('actual_cost')}}"  required="" data-parsley-required-message="Please enter the actual_cost">
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
                            <input type="text" class="form-control tagsinput" data-role="tagsinput"  name="menu_tag" value="{{old('menu_tag')}}"   placeholder="Please enter the menu tag">
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Description:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="description" value="{{old('description')}}">
                            <input type="hidden" name="stock_status" value="1">
                            <input type="hidden" class="form-control tagsinput" name="size" value="0" >
                            @if ($errors->has('description'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
               
                    <div class="form-group row custom_form_group">
                        <label class="col-sm-3 control-label">Services:<span class="req_star">*</span></label>
                        <div class="col-sm-9 pt-1">
                            <input type="checkbox" class="" name="dining_service" checked> Dining
                            <input type="checkbox" class="" name="takeaway_service" class="ml-5" checked> Take Away
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_name">
                            </div>
                        </div>
                    </div>
               
                    <!-- stock code -->
                    @php  
                          use App\Http\Controllers\Admin\CategoryController;
                          $CateOBJ = new CategoryController();
                          $allCate = $CateOBJ->getAll();
                    @endphp
                    <div class="form-group row custom_form_group {{ $errors->has('CategoryID') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Category Name:<span class="req_star">*</span></label>
                        <div class="col-sm-7">
                          <select class="form-control" name="CategoryID" id="CateId_val">
                            <option value="">Select Category</option>
                            @foreach ($allCate as $cat)
                             <option value="{{ $cat->CateId }}" {{ (@$data->CateId==$cat->CateId)?'selected': '' }}>{{ $cat->CateName }}</option>
                            @endforeach
                          </select>
                          @if ($errors->has('CategoryID'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('CategoryID') }}</strong>
                              </span>
                          @endif
                        </div>
                    </div>

                    <div class="form-group row custom_form_group {{ $errors->has('BranID') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Brand Name:<span class="req_star">*</span></label>
                        <div class="col-sm-7">
                          <select class="form-control" name="BranID" id="BranId_val">
                            @if(@$data)
                            <option value="{{ @$data->BranId }}">{{ @$data->brandInfo->BranName }}</option>
                            @else
                            <option value="">Select Brand</option>
                            @endif
                          </select>
                          @if ($errors->has('BranID'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('BranID') }}</strong>
                              </span>
                          @endif
                        </div>
                    </div>

                    <div class="form-group row custom_form_group {{ $errors->has('SizeID') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Size Name:<span class="req_star">*</span></label>
                        <div class="col-sm-7">
                          <select class="form-control" name="SizeID" id="SizeId_val">
                            @if(@$data)
                            <option value="{{ @$data->SizeId }}">{{ @$data->sizeInfo->SizeName }}</option>
                            @else
                            <option value="">Select Size</option>
                            @endif
                          </select>
                          @if ($errors->has('SizeID'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('SizeID') }}</strong>
                              </span>
                          @endif
                        </div>
                    </div>

                    <!-- <div class="form-group row custom_form_group {{ $errors->has('ThicID') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Thickness Name:<span class="req_star">*</span></label>
                        <div class="col-sm-7">
                          <select class="form-control" name="ThicID" id="ThicId_val">
                            @if(@$data)
                            <option value="{{ @$data->ThicId }}">{{ @$data->thickInfo->ThicName }}</option>
                            @else
                            <option value="">Select Thickness</option>
                            @endif
                          </select>
                          @if ($errors->has('ThicID'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('ThicID') }}</strong>
                              </span>
                          @endif
                        </div>
                    </div> -->

                    <div class="form-group row custom_form_group {{ $errors->has('StocValue') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Initial Stock :<span class="req_star">*</span></label>
                        <div class="col-sm-7">
                          <input type="number" placeholder="Stock Value" class="form-control" id="StocValue" name="StocValue" value="{{(@$data)?@$data->StocValue:old('StocValue')}}">
                          <input type="hidden" name="StocId" value="{{@$data->StocId ?? ''}}">
                          @if ($errors->has('StocValue'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('StocValue') }}</strong>
                              </span>
                          @endif
                        </div>
                    </div>
                    <!-- stock code -->
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





<!-- <script>
    $(document).ready(function(){
        $('#stockProduct').click(function(){
            if($(this).prop("checked") == true){
                // alert('You can rock now...');
                $('.myHiddenClass').removeClass('d-none');
                $('.myHiddenClass').addAttr('required',true);
                $('.myHiddenClass').prop('required',true);
                

            }else if($(this).prop("checked") == false){
                $('.myHiddenClass').addClass('d-none');
                $('.myHiddenClass').removeAttr('required');
                $('.myHiddenClass').prop('required',false);
            }

        });
    });
</script>
 -->

 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function(){
        $(".tagsinput").tagsinput('items');
        $(".tagsinput").val();
    })
</script>


<script type="text/javascript">
      $.ajaxSetup({
          headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
          }
      });

        // Category Wise Brand
        $(document).ready(function() {
          $('select[name="CategoryID"]').on('change', function(){
              var CategoryID = $(this).val();
              if(CategoryID) {
                  $.ajax({
                      url: "{{ route('Category-wise-Brand') }}",
                      type:"POST",
                      dataType:"json",
                      data: { CategoryID:CategoryID },
                      success:function(data) {
                         if(data == ""){
                           $('#BranId_val[name="BranID"]').empty();
                           $('#BranId_val[name="BranID"]').append('<option value="">Data Not Found! </option>');
                           $('#SizeId_val[name="SizeID"]').empty();
                           $('#SizeId_val[name="SizeID"]').append('<option value="">Data Not Found!</option>');
                           $('#ThicId_val[name="ThicID"]').empty();
                           $('#ThicId_val[name="ThicID"]').append('<option value="">Data Not Found!</option>');

                         }else{
                           $('#BranId_val[name="BranID"]').empty();
                           $('#BranId_val[name="BranID"]').append('<option value="">Select Brand</option>');
                           $('#SizeId_val[name="SizeID"]').empty();
                           $('#SizeId_val[name="SizeID"]').append('<option value="">Select Size</option>');
                           $('#ThicId_val[name="ThicID"]').empty();
                           $('#ThicId_val[name="ThicID"]').append('<option value="">Select Thickness</option>');

                       
                           $.each(data, function(key, value){
                              $('#BranId_val[name="BranID"]').append('<option value="'+ value.BranId+'">' + value.BranName + '</option>');
                           });
                         }

                      },

                  });
              } else{

              }
          });
          // Brand Wise productSize
          $('select[name="BranID"]').on('change', function(){
              var BranId = $(this).val();
              if(BranId) {
                  $.ajax({
                      url: "{{ route('Brand-wise-size') }}",
                      type:"POST",
                      dataType:"json",
                      data: { BranId:BranId },
                      success:function(data) {
                         if(data == ""){
                         
                           $('#SizeId_val[name="SizeID"]').empty();
                           $('#SizeId_val[name="SizeID"]').append('<option value="">Data Not Found!</option>');
                           $('#ThicId_val[name="ThicID"]').empty();
                           $('#ThicId_val[name="ThicID"]').append('<option value="">Data Not Found!</option>');

                         }else{
                          
                           $('#SizeId_val[name="SizeID"]').empty();
                           $('#SizeId_val[name="SizeID"]').append('<option value="">Select Size</option>');
                           $('#ThicId_val[name="ThicID"]').empty();
                           $('#ThicId_val[name="ThicID"]').append('<option value="">Select Thickness</option>');

                           $.each(data, function(key, value){
                              $('#SizeId_val[name="SizeID"]').append('<option value="'+ value.SizeId+'">' + value.SizeName + '</option>');
                           });
                         }

                      },
                  });
              } else{

              }
          });
          // product Size Wise Thickness
        //   $('select[name="SizeID"]').on('change', function(){
        //       var Size = $(this).val();
        //       if(Size) {
        //           $.ajax({
        //               url: "{{ route('size-wise-thickness') }}",
        //               type:"POST",
        //               dataType:"json",
        //               data: { Size:Size },
        //               success:function(data) {
        //                  if(data == ""){
                          
        //                    $('#ThicId_val[name="ThicID"]').empty();
        //                    $('#ThicId_val[name="ThicID"]').append('<option value="">Data Not Found!</option>');

        //                  }else{
                          
        //                    $('#ThicId_val[name="ThicID"]').empty();
        //                    $('#ThicId_val[name="ThicID"]').append('<option value="">Select Thickness</option>');

        //                    $.each(data, function(key, value){
        //                       $('#ThicId_val[name="ThicID"]').append('<option value="'+ value.ThicId+'">' + value.ThicName + '</option>');
        //                    });
        //                  }

        //               },
        //           });
        //       } else{

        //       }
        //   });
        
      });
    </script>
