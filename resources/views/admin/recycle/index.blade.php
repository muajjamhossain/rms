@extends('layouts.admin')
@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Recycle</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="#">Dashboard</a></li>
            <li class="active">Recycle</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-xl-3">
        <a href="{{url('dashboard/recycle/user')}}">
          <div class="mini-stat clearfix bx-shadow bg-white">
              <span class="mini-stat-icon bg-primary"><i class="md md-person"></i></span>
              <div class="mini-stat-info text-right text-dark mini_stat_info">
                  @php
                      $totalUser=App\User::where('status',0)->count();
                  @endphp
                  <span class="counter text-dark">{{$totalUser}}</span>
                  Users
              </div>
          </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-3">
        <a href="#">
          <div class="mini-stat clearfix bx-shadow bg-white">
              <span class="mini-stat-icon bg-primary"><i class="md md-panorama"></i></span>
              <div class="mini-stat-info text-right text-dark mini_stat_info">
                  <span class="counter text-dark">0</span>
                  Division Sales Officers
              </div>
          </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-3">
        <a href="#">
          <div class="mini-stat clearfix bx-shadow bg-white">
              <span class="mini-stat-icon bg-primary"><i class="md md-contacts"></i></span>
              <div class="mini-stat-info text-right text-dark mini_stat_info">
                  <span class="counter text-dark">0</span>
                  District Sales Officers
              </div>
          </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-3">
        <a href="#">
          <div class="mini-stat clearfix bx-shadow bg-white">
              <span class="mini-stat-icon bg-primary"><i class="md md-view-carousel"></i></span>
              <div class="mini-stat-info text-right text-dark mini_stat_info">
                  <span class="counter text-dark">0</span>
                  Superviser
              </div>
          </div>
        </a>
    </div>
</div> <!-- End row-->
@endsection
