
                <div class="row">
                    @foreach($menus as $menu)
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                            <div class="card">
                                <div class="card-header text-center">
                                    <img src="{{ asset('uploads/foods/'.$menu->photo) }}" alt="{{ $menu->name }}" class="img-fluid" style="height: 100px;">
                                </div>
                                <div class="card-body">
                                    <h4 class="text-center">{{ $menu->name }}</h4>
                                    <h6 class="text-center">Price-{{ $menu->price }}</h6>
                                </div>
                                <div class="card-footer text-center">
                                    <a style="cursor: pointer;" class="btn btn-primary" onclick="addItem({{ $menu->id }})"><i class="fa fa-plus"></i> Add</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>