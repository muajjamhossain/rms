<div class="panel panel-default panel-fill">
    <div class="panel-heading"> 
        <div class="row">
            <div class="col-sm-6">
                <h3 class="panel-title">Menu</h3>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ url('menu/'.$restaurant->url) }}" class="btn btn-success btn-md waves-effect card_top_button" target="_blank"><i class="fa fa-eye fa-lg"></i> See Menu</a>
                <a class="btn btn-md btn-primary waves-effect card_top_button" id="addMenu"><i class="fa fa-plus-circle"></i> Add Menu</a>
                <a class="btn btn-md btn-primary waves-effect card_top_button" id="addStockMenu"><i class="fa fa-plus-circle"></i> Add Menu (Stock)</a>
            </div>
        </div>
    </div>
    @if(Session::has('menuSuccess'))
    <script>
        Toast.fire({
          icon: 'success',
          title: '{!! session("menuSuccess") !!}'
        })
    </script>
    @php Session::forget('menuSuccess') @endphp
    @endif
    @if(Session::has('error'))
    <script>
        Toast.fire({
          icon: 'error',
          title: '{!! session("error") !!}'
        })
    </script>
    @php Session::forget('error') @endphp
    @endif 
    <div class="panel-body" id="allMenu"> 
        <div class="table-responsive">
            <table class="table" id="datatable">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Menu</th>
                        <th>Price</th>
                        <th>Tag</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Manage</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($restaurant))
                        @foreach($restaurant->menuInfo as $menu)

                            <tr style="line-height: 50px;">
                                <td>
                                    @if($menu->photo)
                                        <img src="{{ asset('uploads/foods/'.$menu->photo) }}" alt="food" style="height: 50px; width: 50px">
                                    @endif
                                </td>
                                <td>{{ $menu->name }}</td>
                                <td>{{ $menu->price }}</td>
                                <td>{{ $menu->menu_tag }}</td>
                                <td>{{ $menu->description }}</td>
                                <td>{{ $menu->menuCategory->name ?? $menu->stockAmount->cateInfo->CateName }}</td>
                                <td>{{ $menu->stockAmount->StocValue ?? 'Not Available' }}</td>
                                <td>
                                    @if($menu->status == 1)
                                        <span class="badge badge-success">Published</span>
                                    @else
                                        <span class="badge badge-warning">Unpublished</span>
                                    @endif
                                </td>
                                <td>{{ $menu->created_at }}</td>
                                <td>
                                    <a data-id="{{ $menu->id }}"  id="editMenuButton" style="cursor: pointer;"><i class="fa fa-pencil-square fa-lg edit_icon"></i></a>
                                    <a href="#" id="deleteMenuButton" class="delete" data-id="{{ $menu->id }}"><i class="fa fa-trash fa-lg delete_icon"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <h3>No Data Found</h3>
                    @endif
                    
                </tbody>
            </table>
        </div>
    </div> 
</div>