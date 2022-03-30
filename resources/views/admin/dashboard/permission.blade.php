@extends('layouts.admin')
@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Welcome !</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="#">Dashboard</a></li>
            <li class="active">Home</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
      <div class="card">
          <div class="card-header bg-primary">
              <h3 class="card-title card_top_title"><i class="fa fa-gg-circle"></i> Access Denied</h3>
          </div>
          <div class="card-body">
              You have no permission visit this page.
          </div>
      </div>
    </div>
</div> <!-- End row-->
@endsection
