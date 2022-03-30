                			<div class="col-lg-8 m-auto" >
                        		<div class="cart-wapper-box">
									<div class="shopping-cart">
										@php $type = 2 @endphp
                                        @forelse(Cart::content() as $item)
                                        @if($item->options->type == 1)
                                        	@php $type = 1 @endphp
                                        @endif
    										<div class="item">
    											<div class="buttons">
    												<button class="delete-btn" onClick="deleteItem({{ $item->id }})"></button>
    											</div>

    											<div class="image">
    												<img src="{{ asset('uploads/foods/'.$item->options->photo) }}" alt="pic" class="img-fluid" style="width: 120px">
    											</div>

    											<div class="description">
    												<div class="des-text">
    													<span>{{ $item->name }}</span>
    												</div>
    											</div>

    											<div class="quantity">
    												<button class="plus-btn add-btn" type="button" onclick="updateQty({{ $item->id }}, 'inc')">
    													<i class="fas fa-plus"></i>
    												</button>
    												<input type="text" name="name" value="{{ $item->qty }}">
    												<button class="minus-btn add-btn" type="button" onclick="updateQty({{ $item->id }}, 'dec')">
    													<i class="fas fa-minus"></i>
    												</button>
    											</div>

    											<div class="total-price">
    												<span>X</span>
    												<span><b>{{ $restaurant->currency_symbol }}{{ $item->price }}</b></span>
    												<span>=</span>
    												<span><b>{{ $restaurant->currency_symbol }}{{ $item->price * $item->qty }}</b></span>
    											</div>
    										</div>
                                        @empty
                                        <div class="item">
                                            <h4>No item is added</h4>
                                        </div>
										@endforelse
										<div class="item item-total">
											<p>Total Price&nbsp;&nbsp;=&nbsp;&nbsp;<b>{{ $restaurant->currency_symbol }}{{ Cart::subtotal() }}</b></p>
										</div>
                                        @if($restaurant->vat > 0)
                                        <div class="item item-total">
                                            <p>{{ $restaurant->vat }}% vat will be added<sup><b>*</b></sup></p>
                                        </div>
                                        @endif
									</div>
                        		</div>
                		    </div>
                        		<div class="col-lg-4 m-auto">
                        			<div class="cart-wapper-box">
                        				<div class="shopping-cart-form">
                        					<h3>Customer Details</h3>
                        					<form action="{{ url('placeOrder/'.$restaurant->slug.'/'.$type) }}" method="post">
                        	                    @csrf
                                                @if($type == 2)
													<div>
														<input type="text" class="form-control" name="name" value="{{old('name')}}" required="" data-parsley-required-message="Please enter your name" placeholder="Full Name">
														@if ($errors->has('name'))
														<span class="invalid-feedback" role="alert">
															<strong>{{ $errors->first('name') }}</strong>
														</span>
														@endif
													</div>
													<div>
														<input type="text" class="form-control" name="phone" value="{{old('phone')}}" required data-parsley-required-message="Please enter your phone number" placeholder="Phone No.">
														@if ($errors->has('phone'))
														<span class="invalid-feedback" role="alert">
															<strong>{{ $errors->first('phone') }}</strong>
														</span>
														@endif
													</div>
													<div>
														<input type="email" class="form-control" name="email" value="{{old('email')}}" placeholder="Email Address">
														@if ($errors->has('email'))
														<span class="invalid-feedback" role="alert">
															<strong>{{ $errors->first('email') }}</strong>
														</span>
														@endif
													</div>
													<div>
														<input type="date"  name="delivery_date" required="" class="form-control" data-parsley-required-message="Please enter delivery date">
														@if ($errors->has('delivery_date'))
														<span class="invalid-feedback" role="alert">
															<strong>{{ $errors->first('delivery_date') }}</strong>
														</span>
														@endif
													</div>
													<div>
														<input type="time"  name="delivery_time" required="" class="form-control"
														data-parsley-required-message="Please enter delivery time">
														@if ($errors->has('delivery_time'))
														<span class="invalid-feedback" role="alert">
															<strong>{{ $errors->first('delivery_time') }}</strong>
														</span>
														@endif
													</div>
                                                @else
														@if($restaurant->table_option == 1)
															<div>
																<input type="text" class="form-control" name="table_no" value="{{old('table_no')}}" required data-parsley-required-message="Please enter your table number" placeholder="Table No.">
																@if ($errors->has('table_no'))
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $errors->first('table_no') }}</strong>
																</span>
																@endif
															</div>
														@endif
                                                @endif
													<div>
														<input type="text" class="form-control" name="phone" value="" id="datepicker" required data-parsley-required-message="Please enter your phone number" placeholder="Phone No.">
														@if ($errors->has('phone'))
														<span class="invalid-feedback" role="alert">
															<strong>{{ $errors->first('phone') }}</strong>
														</span>
														@endif
													</div>
												
													<div>
														<textarea name="" id="" class="form-control address-form-control" placeholder="Details (Optional)"></textarea>
													</div>
                        						
                        						<button type="button" class="btn" id="place-order-button">Place Order</button>
                        					</form>
                        				</div>
                        			</div>
                        		</div>	


								<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
                                                                  
								<script type="text/javascript">
									
									$( function() {
										$( "#datepicker" ).datepicker({
										changeMonth: true,
										changeYear: true
										});
									} );
								</script>
                        		<script>
                        			$(function(){
                        				$('#cart-contents').empty().append({{ Cart::content()->count() }});
                        				@if(Cart::content()->count() > 0)
                        					$('#place-order-button').removeAttr('type').attr('type', 'submit');
                        				@else
                        					$('#place-order-button').removeAttr('type').attr('type', 'button');
                        				@endif
                        			})
                        		</script>