<table id="datatable" class="table table-bordered custom_table mb-0 with-image">
    <thead>
            <tr>
            <th>Phone</th>
            <th>Total Amount</th>
            <th>Table No.</th>
            @if(Auth::user()->role_id != 2)
            <th>Action</th>
            @endif
            <th>Request At</th>
            <th>See Order Items</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $data)
            <tr>
            <td>{{$data->phone}}</td>
            <td>{{$data->total_amount}}</td>
            <td>{{ $data->table_no }}</td>
            @if(Auth::user()->role_id != 2)
            <td>
                <button class="btn btn-success" id="confirm" onClick="changeStatus('{{ $data->slug }}',3)"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Confirm</button>
            </td>
            @endif
            <td>{{ date('h:i:A', strtotime($data->created_at)) }}</td>
            <td>
                <a href="{{url('admin/order-request/view/'.$data->slug.'/1')}}"><i class="fa fa-eye fa-lg view_icon"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>