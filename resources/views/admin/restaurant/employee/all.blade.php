<div class="panel panel-default panel-fill">
    <div class="panel-heading"> 
        <div class="row">
            <div class="col-sm-8">
                <h3 class="panel-title">Employee</h3>
            </div>
            <div class="col-sm-4 text-right">
                @if($canAddMore)
                    <a class="btn btn-md btn-primary waves-effect card_top_button" id="addEmployee"><i class="fa fa-plus-circle"></i> Add Employee</a>
                @else
                    <a class="btn btn-md btn-primary waves-effect card_top_button" onclick="limitEmp()"><i class="fa fa-plus-circle"></i> Add Employee</a>
                @endif
            </div>
        </div>
    </div>
    @if(Session::has('employeeSuccess'))
    <script>
        Toast.fire({
          icon: 'success',
          title: '{!! session('employeeSuccess') !!}'
        })
    </script>
    @php Session::forget('employeeSuccess') @endphp
    @endif
    @if(Session::has('error'))
    <script>
        Toast.fire({
          icon: 'error',
          title: '{!! session('error') !!}'
        })
    </script>
    @php Session::forget('error') @endphp
    @endif 
    @if(Session::has('limit'))
    <script>
        Swal.fire({
          title: 'Employee limit is over!',
          text: 'Contact to Triva IT Ltd. to upgrade your package',
          icon: 'warning',
          confirmButtonText: 'Ok'
        })
    </script>
    @php Session::forget('limit') @endphp
    @endif 
    <div class="panel-body" id="allMenu"> 
        <div class="table-responsive">
            <table class="table" id="employeetable">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>email</th>
                        <th>phone</th>
                        <th>address</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Manage</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($restaurant))
                        @foreach($restaurant->employeeInfo as $employee)
                            @if(Auth::user()->role_id == 3 && $employee->userInfo->role_id == 3)
                            @else
                                <tr style="line-height: 50px;">
                                    <td>
                                        @if($employee->userInfo->photo)
                                            <img src="{{ asset('uploads/users/'.$employee->userInfo->photo) }}" alt="food" style="height: 50px; width: 50px">
                                        @endif
                                    </td>
                                    <td>{{ $employee->userInfo->name }}</td>
                                    <td>{{ $employee->userInfo->email }}</td>
                                    <td>{{ $employee->userInfo->phone }}</td>
                                    <td>{{ $employee->address }}</td>
                                    <td>{{ $employee->userInfo->userRole->role_name }}</td>
                                    <td>
                                        @if($employee->userInfo->status == 1)
                                            <button class="btn btn-success" id="employeeStatusInactive" data-id="{{ $employee->id }}">Active</button>
                                        @else
                                            <span class="btn btn-warning" id="employeeStatusActive" data-id="{{ $employee->id }}">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $employee->created_at }}</td>
                                    <td>
                                        <a data-id="{{ $employee->id }}"  id="editEmployeeButton" style="cursor: pointer;"><i class="fa fa-pencil-square fa-lg edit_icon"></i></a>
                                        <a id="deleteEmployeeButton" class="delete" data-id="{{ $employee->id }}" style="cursor: pointer;"><i class="fa fa-trash fa-lg delete_icon"></i></a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @else
                        <h3>No Data Found</h3>
                    @endif
                    
                </tbody>
            </table>
        </div>
    </div> 
</div>