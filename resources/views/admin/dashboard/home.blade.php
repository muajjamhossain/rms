@extends('layouts.admin')
@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Dashboard</h4>
        @if(Auth::user()->role_id == 2)
            <h5 class="pull-right">Expire Date: {{ date('M d, Y', strtotime($client->subs_finishing_date)) }}</h5>
        @else
            <ol class="breadcrumb pull-right">
                <li><a href="#">Dashboard</a></li>
                <li class="active">Home</li>
            </ol>
        @endif
    </div>
</div>
@if(Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="mini-stat clearfix bx-shadow bg-white">
            <span class="mini-stat-icon bg-primary"><i class="md md-account-child"></i></span>
            <div class="mini-stat-info text-right text-dark mini_stat_info">
                <span class="counter text-dark">{{ $no_of_emp }}</span>
                Employees
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="mini-stat clearfix bx-shadow bg-white">
            <span class="mini-stat-icon bg-primary"><i class="fa fa-truck"></i></span>
            <div class="mini-stat-info text-right text-dark mini_stat_info">
                <span class="counter text-dark">{{ $no_of_delivered_orders }}</span>
                Delivered Orders
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="mini-stat clearfix bx-shadow bg-white">
            <span class="mini-stat-icon bg-primary"><i class="fa fa-ban"></i></span>
            <div class="mini-stat-info text-right text-dark mini_stat_info">
                <span class="counter text-dark">{{ $no_of_cancel_order }}</span>
                Cancelled Orders
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="mini-stat clearfix bx-shadow bg-white">
            <span class="mini-stat-icon bg-primary">%</span>
            <div class="mini-stat-info text-right text-dark mini_stat_info">
                <span class="counter text-dark">{{ $vat }}</span>
                Vat
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="mini-stat clearfix bx-shadow bg-white">
            <span class="mini-stat-icon bg-primary"><i class="fa fa-money"></i></span>
            <div class="mini-stat-info text-right text-dark mini_stat_info">
                <span class="counter text-dark">{{ $income }}</span>
                Income
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="mini-stat clearfix bx-shadow bg-white">
            <span class="mini-stat-icon bg-primary"><i class="fa fa-minus-square"></i></span>
            <div class="mini-stat-info text-right text-dark mini_stat_info">
                <span class="counter text-dark">
                    @if(is_float($expense))
                        {{ $expense }}
                    @else
                        {{ round($expense) }}
                    @endif
                </span>
                Expense
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="mini-stat clearfix bx-shadow bg-white">
            <span class="mini-stat-icon bg-primary">Π</span>
            <div class="mini-stat-info text-right text-dark mini_stat_info">
                <span class="counter text-dark">{{ $income - $expense }}</span>
                Total Profit
            </div>
        </div>
    </div>
    @if(Auth::user()->role_id == 2)
    <div class="col-md-6 col-xl-3">
        <div class="mini-stat clearfix bx-shadow bg-white">
            <span class="mini-stat-icon bg-primary"><i class="fa fa-cutlery"></i></span>
            <div class="mini-stat-info text-right text-dark mini_stat_info">
                <span class="counter text-dark">{{ $no_of_restaurants }}</span>
                Restaurants
            </div>
        </div>
    </div>
    @endif
</div> <!-- End row-->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div id="columnchart_material" style="width: 100%; height: 500px;"></div>
            </div>
        </div>
    </div>
</div>
@else


<div class="row">
<div class="col-md-6 col-xl-3">
        <div class="mini-stat clearfix bx-shadow bg-white">
            <span class="mini-stat-icon bg-primary"><i class="md md-account-child"></i></span>
            <div class="mini-stat-info text-right text-dark mini_stat_info">
                <span class="counter text-dark">1000</span>
                Total Customer
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="mini-stat clearfix bx-shadow bg-white">
            <span class="mini-stat-icon bg-primary"><i class="fa fa-users"></i></span>
            <div class="mini-stat-info text-right text-dark mini_stat_info">
                <span class="counter text-dark">30</span>
                Total Client
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="mini-stat clearfix bx-shadow bg-white">
            <span class="mini-stat-icon bg-primary"><i class="fa fa-ban"></i></span>
            <div class="mini-stat-info text-right text-dark mini_stat_info">
                <span class="counter text-dark">75</span>
                Total package
            </div>
        </div>
    </div>

     <div class="col-md-6 col-xl-3">
        <div class="mini-stat clearfix bx-shadow bg-white">
            <span class="mini-stat-icon bg-primary"><i class="fa fa-cutlery"></i></span>
            <div class="mini-stat-info text-right text-dark mini_stat_info">
                <span class="counter text-dark"></span>
               Total Restaurant
            </div>
        </div>
    </div>
</div>
@endif
@endsection
@if(Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
@push('js')
<script src="{{asset('contents/admin')}}/plugins/google-chart/load.min.js"></script>

<script type="text/javascript">
  google.charts.load('current', {'packages':['bar']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Month', 'Incomes', 'Expenses', 'Profit'],
      ['Jan', {{ $monthly_incomes[0] }}, {{ $monthly_expenses[0] }}, {{ $monthly_profits[0] }}],
      ['Feb', {{ $monthly_incomes[1] }}, {{ $monthly_expenses[1] }}, {{ $monthly_profits[1] }}],
      ['Mar', {{ $monthly_incomes[2] }}, {{ $monthly_expenses[2] }}, {{ $monthly_profits[2] }}],
      ['Apr', {{ $monthly_incomes[3] }}, {{ $monthly_expenses[3] }}, {{ $monthly_profits[3] }}],
      ['May', {{ $monthly_incomes[4] }}, {{ $monthly_expenses[4] }}, {{ $monthly_profits[4] }}],
      ['June', {{ $monthly_incomes[5] }}, {{ $monthly_expenses[5] }}, {{ $monthly_profits[5] }}],
      ['July', {{ $monthly_incomes[6] }}, {{ $monthly_expenses[6] }}, {{ $monthly_profits[6] }}],
      ['Aug', {{ $monthly_incomes[7] }}, {{ $monthly_expenses[7] }}, {{ $monthly_profits[7] }}],
      ['Sep', {{ $monthly_incomes[8] }}, {{ $monthly_expenses[8] }}, {{ $monthly_profits[8] }}],
      ['Oct', {{ $monthly_incomes[9] }}, {{ $monthly_expenses[9] }}, {{ $monthly_profits[9] }}],
      ['Nov', {{ $monthly_incomes[10] }}, {{ $monthly_expenses[10] }}, {{ $monthly_profits[10] }}],
      ['Dec', {{ $monthly_incomes[11] }}, {{ $monthly_expenses[11] }}, {{ $monthly_profits[11] }}],
    ]);

    var options = {
      chart: {
        title: 'Restaurant Performance',
        subtitle: 'Monthly Incomes, Expenses, and Profit',
      }
    };

    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

    chart.draw(data, google.charts.Bar.convertOptions(options));
  }
</script>
@endpush
@endif