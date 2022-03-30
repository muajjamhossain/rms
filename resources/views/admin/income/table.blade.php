<table id="datatable" class="table table-bordered custom_table mb-0 with-image">
    <thead>
        <tr>
            <th>SN</th>
            <th>Income For</th>
            <th>Amount</th>
            <th>Gateway</th>
            <th>Date</th>
            <th>Manage</th>
        </tr>
    </thead>
    <tbody>
        @foreach($incomes as $data)
        <tr>
            <td>
                {{ $loop->index + 1 }}
            </td>
            <td>{{$data->incom_for}}</td>
            <td>{{$data->amount}}</td>
            <td>
                @if($data->pay_by == 1) Hand Cash
                @elseif($data->pay_by == 2) Bkash
                @elseif($data->pay_by == 3) Nagad
                @elseif($data->pay_by == 4) DBBL
                @elseif($data->pay_by == 5) City
                @elseif($data->pay_by == 6) Food Panda
                @elseif($data->pay_by == 7) Hungrynaki
                @elseif($data->pay_by == 7) Pathao Food
                @endif
            </td>
            <td>{{ $data->created_at }}</td>
            <td>
                <a href="{{url('admin/client/'.$data->id)}}"><i class="fa fa-plus-square fa-lg view_icon"></i></a>
                <a href="{{url('admin/client/'.$data->id.'/edit')}}"><i class="fa fa-pencil-square fa-lg edit_icon"></i></a>
                <a href="#" class="delete" data-url="{{ url('admin/client/'.$data->id) }}" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-trash fa-lg delete_icon"></i></a>
            </td>
        </tr>
        @endforeach
            <tr>
                <td>=</td>
                <td>=</td>
                <td>Total</td>
                <td>{{ $incomes->sum('amount')}}</td>
                <td></td>
                <td></td>
            </tr>
    </tbody>
</table>