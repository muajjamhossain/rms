@extends('layouts.admin')
@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Users</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="#">Dashboard</a></li>
            <li class="active">Home</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title card_top_title"><i class="fa fa-gg-circle"></i> View Client Information</h3>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{url('admin/client')}}" class="btn btn-md btn-primary waves-effect card_top_button"><i class="fa fa-plus-circle"></i> All Client</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <table class="table table-bordered table-striped table-hover custom_view_table">
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td>{{$client->name}}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{$client->email}}</td>
                            </tr>
                            <tr>
                                <td>Company</td>
                                <td>:</td>
                                <td>{{$client->company_name}}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>:</td>
                                <td>{{$client->phone}}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>:</td>
                                <td>{{$client->address}}</td>
                            </tr>
                            <tr>
                                <td>Number of Restaurant</td>
                                <td>:</td>
                                <td>{{$client->no_of_restaurant}}</td>
                            </tr>
                            <tr>
                                <td>Subscription Time</td>
                                <td>:</td>
                                <td>{{$client->created_at->format('d-m-Y | h:i:s a')}}</td>
                            </tr>
                            <tr>
                                <td>Subscription Close</td>
                                <td>:</td>
                                <td>
                                    @php
                                        echo Carbon\Carbon::create($client->subs_finishing_date)->format('d-m-Y');
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td>User Role</td>
                                <td>:</td>
                                <td>Admin</td>
                            </tr>
                            <tr>
                                <td>Photo</td>
                                <td>:</td>
                                <td>
                                    @if($client->photo!='')
                                        <img class="table_image_200" src="{{asset('uploads/users/'.$client->photo)}}" alt="photo"/>
                                    @else
                                        <img class="table_image_200" src="{{asset('uploads')}}/avatar-black.png" alt="photo"/>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-2"></div>
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
@endsection
