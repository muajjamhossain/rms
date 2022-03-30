@extends('layouts.admin')
@push('css') 
    <link href="{{asset('contents/admin')}}/assets/css/datatables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Expense</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="#">Dashboard</a></li>
            <li class="active">Home</li>
        </ol>
    </div>
</div>
@if(Session::has('success'))
    <script>
        Swal.fire({
          icon: 'success',
          title: 'Deleted!',
          text: 'Expense Has Successfully Deleted!',
          timer: 2000
        })
    </script>
@endif
@if(Session::has('error'))
    <script>
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Something went wrong!'
        })
    </script>
@endif
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <form action="{{ url('admin/expense') }}" method="post">
                @csrf
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title card_top_title"><i class="fa fa-eye"></i> Add Expense </h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="card-body">
                    <input type="text" value="{{ $slug }}" name="rstrt_slug" hidden="">
                    <div class="form-group row custom_form_group{{ $errors->has('expense_for') ? ' has-error' : '' }}">
                        <label class="col-sm-4 control-label">Report From:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="expense_for" placeholder="Write Expense info">
                            @if ($errors->has('expense_for'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('expense_for') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('pay_by') ? ' has-error' : '' }}">
                        <label class="col-sm-4 control-label">Pay By:<span class="req_star">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="pay_by" required=""data-parsley-required-message="Please select a payment way option">
                                <option value="">Select a payment way</option>
                                <option value="1">Hand Cash == <strong>{{$handCash}}</strong></option>
                                <option value="2"> Bkash == <strong>{{$Bkash}}</strong></option>
                                <option value="3"> Nagad == <strong>{{$Nagad}}</strong></option>
                                <option value="4"> DBBL == <strong>{{$DBBL}}</strong></option>
                                <option value="5">City == <strong>{{$City}}</strong></option>
                            </select>

                            @if ($errors->has('pay_by'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('pay_by') }}</strong>
                            </span>
                            @endif
                            <div style="color: #dc3545; font-size: 80%;" id="error_pay_by">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row custom_form_group{{ $errors->has('amount') ? ' has-error' : '' }}">
                        <label class="col-sm-4 control-label">Amount:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="amount" placeholder="Enter Expense amount">
                            @if ($errors->has('amount'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('amount') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary" type="sumbit">Submit</button>
                </div>
            </form>

            <!-- <div class="row d-flex">
                <div class="col-md-12 ml-2">
                    <h4>Hand Cash : <strong>{{$handCash}}</strong></h4>
                    <h4>Bkash : <strong>{{$Bkash}}</strong></h4>
                    <h4>Nagad : <strong>{{$Nagad}}</strong></h4>
                    <h4>DBBL : <strong>{{$DBBL}}</strong></h4>
                    <h4>City : <strong>{{$City}}</strong></h4>
                    <h4>Total : <strong>{{$total}}</strong></h4>
                </div>
            </div> -->
        </div>
        
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-4">
                        <h3 class="card-title card_top_title"><i class="fa fa-gg-circle"></i> All Expense Information</h3>
                    </div>


                    <div class="col-md-8 d-flex text-right" style="align-items: center">
                            <a href="{{ url('admin/expense') }}" class="btn btn-info btn-sn">ALL</a>
                            <a href="{{ url('admin/expense/gateway/1') }}" class="btn btn-success btn-sn">Hand Cash</a>
                            <a href="{{ url('admin/expense/gateway/2') }}" class="btn btn-primary btn-sn">Bkash</a>
                            <a href="{{ url('admin/expense/gateway/3') }}" class="btn btn-secondary btn-sn"> Nagad</a>
                            <a href="{{ url('admin/expense/gateway/4') }}" class="btn btn-success btn-sn">DBBL</a>
                            <a href="{{ url('admin/expense/gateway/5') }}" class="btn btn-danger btn-sn">City</a>
                        </div>


                    <div class="clearfix"></div>
                </div>


                <div class="row">

                    <form class="form-inline pull-right" action="{{ url('admin/custom-expense-report/'.$slug) }}" method="post">
                            @csrf
                            <div class="col-md-4 d-flex text-right">
                                <div class="form-group row custom_form_group">
                                    <label class="col-sm-4 control-label">Pay By :</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="pay_by" required=""
                                        data-parsley-required-message="Please select a payment way option">
                                            <option value="0">All payment way</option>
                                            <option value="1">Hand Cash</option>
                                            <option value="2">Bkash</option>
                                            <option value="3">Nagad</option>
                                            <option value="4">DBBL</option>
                                            <option value="5">City</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8 d-flex text-right">
                                <div class="form-group">
                                    <label for="inputPassword6">From:</label>
                                    <input type="date" class="form-control mx-sm-3" name="from" value="{{ date('Y-m-d', strtotime($from)) }}" >
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword6">To:</label>
                                    <input type="date" class="form-control mx-sm-3" name="to" value="{{ date('Y-m-d', strtotime($to)) }}" >
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>

                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive" id="expenseTable">
                            <table id="datatable" class="table table-bordered custom_table mb-0 with-image">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Expense For</th>
                                        <th>Gateway</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expenses as $data)
                                    <tr>
                                        <td>
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td>{{$data->expense_for}}</td>
                                        <td>
                                            @if($data->pay_by == 1) Hand Cash
                                            @elseif($data->pay_by == 2) Bkash
                                            @elseif($data->pay_by == 3) Nagad
                                            @elseif($data->pay_by == 4) DBBL
                                            @elseif($data->pay_by == 5) City
                                            @endif
                                       </td>
                                        <td>{{$data->amount}}</td>
                                        <td>{{ $data->created_at }}</td>
                                        <td>
                                            <a onClick="editExpense('{{ $data->expense_for }}',{{ $data->amount }}, '{{ url('admin/expense/edit/'.$data->id) }}')"><i class="fa fa-pencil-square fa-lg edit_icon" data-toggle="modal" data-target="#editModal"></i></a>
                                            <a href="#" class="delete" data-url="{{ url('admin/expense/'.$data->id) }}" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-trash fa-lg delete_icon"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach

                                    <tr>
                                        <td>=</td>
                                        <td>=</td>
                                        <td>Total</td>
                                        <td>{{ $expenses->sum('amount')}}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer card_footer_expode">
                <a href="#" class="btn btn-secondary waves-effect">PRINT</a>
                <a href="#" class="btn btn-warning waves-effect">EXCEL</a>
                <a href="#" class="btn btn-success waves-effect">PDF</a>
            </div>
        </div>
    </div>
</div>
<!--Delete Modal Information-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="delete-form">
                @csrf
                @method('delete')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure to delete?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" id="edit-form" method="post">
                @csrf
                @method('put')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Expense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" value="{{ $slug }}" name="rstrt_slug" hidden="">
                    <div class="form-group row custom_form_group{{ $errors->has('expense_for') ? ' has-error' : '' }}">
                        <label class="col-sm-4 control-label">Report From:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="expense_for" id="expense_for">
                            @if ($errors->has('expense_for'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('expense_for') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                        <div class="form-group row custom_form_group">
                            <label class="col-sm-4 control-label">Pay By :</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="pay_by" required=""
                                data-parsley-required-message="Please select a payment way option">
                                    <option value="0">All payment way</option>
                                    <option value="1">Hand Cash</option>
                                    <option value="2">Bkash</option>
                                    <option value="3">Nagad</option>
                                    <option value="4">DBBL</option>
                                    <option value="5">City</option>
                                </select>
                            </div>
                        </div>

                    <div class="form-group row custom_form_group{{ $errors->has('amount') ? ' has-error' : '' }}">
                        <label class="col-sm-4 control-label">Amount:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="amount" id="amount">
                            @if ($errors->has('amount'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('amount') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('js')
    <script src="{{asset('contents/admin')}}/assets/js/jquery.datatables.min.js"></script>
    <script src="{{asset('contents/admin')}}/assets/js/datatables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({ "bSort" : false });
        });

        function editExpense(expense_for, amount, url) {
            document.getElementById('expense_for').value = expense_for;
            document.getElementById('amount').value = amount;
            document.getElementById('edit-form').setAttribute("action", url);
        }
    </script>
@endpush
