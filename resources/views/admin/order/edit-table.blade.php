
                        <div class="table-responsive" id="table">
                            <table id="datatable" class="table table-bordered custom_table mb-0 with-image">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Sub Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(Cart::content() as $item)
                                        <tr>
                                            <td><img src="{{ asset('uploads/foods/'.$item->options->photo) }}" alt="{{ $item->name }}" style="height: 50px;"></td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td><button class="btn btn-success btn-sm" onclick="updateQty({{ $item->id }}, 'inc')"><i class="fa fa-plus"></i></button> {{ $item->qty }} <button class="btn btn-success btn-sm" onclick="updateQty({{ $item->id }}, 'dec')"><i class="fa fa-minus"></i></button></td>
                                            <td>{{ $item->qty * $item->price }}</td>
                                            <td>
                                                <button class="btn btn-danger btn-sm" style="font-weight: bold" onclick="deleteItem({{ $item->id }})">X</button> 
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <h4 class="text-right">Total: {{ Cart::subtotal() }}</h4>
                                </tfoot>
                            </table>