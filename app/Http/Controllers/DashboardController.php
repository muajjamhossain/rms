<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Restaurant;
use App\Employee;
use App\Expense;
use App\Client;
use App\Order;
use App\User;
use App\Bill;
use Auth;

class DashboardController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        if(Auth::user()->role_id == 3) {
            $restaurant = Employee::where('user_id', Auth::user()->id)->first()->restaurantInfo;
            $statis = $this->statisticsData($restaurant);

            $no_of_emp = $statis['no_of_emp'];
            $no_of_delivered_orders = $statis['no_of_delivered_orders'];
            $no_of_cancel_order = $statis['no_of_cancel_order'];
            $income = $statis['income'];
            $expense = $statis['expense'];
            $vat = $statis['vat'];
            $monthly_incomes = $statis['monthly_incomes'];
            $monthly_expenses = $statis['monthly_expenses'];
            $monthly_profits = $statis['monthly_profits'];

            return view('admin.dashboard.home', compact('no_of_emp', 'no_of_delivered_orders', 'no_of_cancel_order','income', 'vat', 'expense', 'monthly_incomes', 'monthly_expenses', 'monthly_profits'));
        }
        if(Auth::user()->role_id == 2) {
            $client = Client::where('email', Auth::user()->email)->first();
            $restaurants = $client->restaurantInfo;
            $no_of_restaurants = $restaurants->count();
            $no_of_emp = 0;
            $no_of_delivered_orders = 0;
            $no_of_cancel_order = 0;
            $income = 0;
            $vat = 0;
            $expense = 0;
            $monthly_incomes = array(0,0,0,0,0,0,0,0,0,0,0,0);
            $monthly_expenses = array(0,0,0,0,0,0,0,0,0,0,0,0);
            $monthly_profits = array(0,0,0,0,0,0,0,0,0,0,0,0);
            foreach ($restaurants as $restaurant) {
                $statis = $this->statisticsData($restaurant);
                $no_of_emp += $statis['no_of_emp'];
                $no_of_delivered_orders += $statis['no_of_delivered_orders'];
                $no_of_cancel_order += $statis['no_of_cancel_order'];
                $income += $statis['income'];
                $expense += $statis['expense'];
                $vat += $statis['vat'];
                foreach ($monthly_incomes as $index => $value) {
                    $monthly_incomes[$index] += $statis['monthly_incomes'][$index];
                }
                foreach ($monthly_expenses as $index => $value) {
                    $monthly_expenses[$index] += $statis['monthly_expenses'][$index];
                }
                foreach ($monthly_profits as $index => $value) {
                    $monthly_profits[$index] += $statis['monthly_profits'][$index];
                }
            }
            return view('admin.dashboard.home', compact('no_of_emp', 'no_of_delivered_orders', 'no_of_cancel_order', 'no_of_restaurants', 'income', 'vat', 'expense', 'monthly_incomes', 'monthly_expenses', 'monthly_profits','client'));
        }
        return view('admin.dashboard.home');
    }

    public function statistics()
    {
        $client = Client::where('email', Auth::user()->email)->first();
        $restaurants = $client->restaurantInfo;
        return view('admin.statistics.index', compact('restaurants'));
    }

    public function restaurantStatistics($slug)
    {
        $restaurant = Restaurant::where('slug', $slug)->first();
        $statistics_type = 2; // type 2 means single restaurant view
        $statis = $this->statisticsData($restaurant);

        $no_of_emp = $statis['no_of_emp'];
        $no_of_delivered_orders = $statis['no_of_delivered_orders'];
        $no_of_cancel_order = $statis['no_of_cancel_order'];
        $income = $statis['income'];
        $expense = $statis['expense'];
        $vat = $statis['vat'];
        $monthly_incomes = $statis['monthly_incomes'];
        $monthly_expenses = $statis['monthly_expenses'];
        $monthly_profits = $statis['monthly_profits'];

        return view('admin.statistics.statis', compact('no_of_emp', 'no_of_delivered_orders', 'no_of_cancel_order','income', 'vat', 'expense', 'monthly_incomes', 'monthly_expenses', 'monthly_profits'));
    }

    public function statisticsData($restaurant)
    {
        $no_of_emp = $restaurant->employeeInfo->count();

        $delivered_orders = Order::where('rstrt_slug', $restaurant->slug)->where('payment_status', 1)->latest()->get();
        $no_of_delivered_orders = $delivered_orders->count();
        $income = 0;
        $vat = 0;
        foreach ($delivered_orders as $order) {
            $income += $order->billInfo->amount;
            $vat += $order->billInfo->vat;
        }

        $no_of_cancel_order = Order::where('rstrt_slug', $restaurant->slug)->where('status', 5)->count();

        $expense = Expense::where('rstrt_slug', $restaurant->slug)->sum('amount');

        $incomes_per_month = Bill::select(DB::raw("SUM(amount) as amount"))
            ->where('rstrt_slug', $restaurant->slug)
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('amount');

        $income_months = Bill::select(DB::raw("Month(created_at) as month"))
            ->where('rstrt_slug', $restaurant->slug)
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('month');

        $monthly_incomes  = array(0,0,0,0,0,0,0,0,0,0,0,0);

        foreach ($income_months as $index => $month) {
            $monthly_incomes[$month - 1] = $incomes_per_month[$index];
        }

        $expenses_per_month = Expense::select(DB::raw("SUM(amount) as amount"))
            ->where('rstrt_slug', $restaurant->slug)
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('amount');

        $expense_months = Expense::select(DB::raw("Month(created_at) as month"))
            ->where('rstrt_slug', $restaurant->slug)
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('month');

        $monthly_expenses = array(0,0,0,0,0,0,0,0,0,0,0,0);

        foreach ($expense_months as $index => $month) {
            $monthly_expenses[$month - 1] = $expenses_per_month[$index];
        }

        $monthly_profits  = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach ($monthly_profits as $index => $profit) {
            $monthly_profits[$index] = $monthly_incomes[$index] - $monthly_expenses[$index];
        }

        $finalReturn = array();
        $finalReturn['no_of_emp'] = $no_of_emp;
        $finalReturn['no_of_delivered_orders'] = $no_of_delivered_orders;
        $finalReturn['no_of_cancel_order'] = $no_of_cancel_order;
        $finalReturn['income'] = $income;
        $finalReturn['expense'] = $expense;
        $finalReturn['vat'] = $vat;
        $finalReturn['monthly_incomes'] = $monthly_incomes;
        $finalReturn['monthly_expenses'] = $monthly_expenses;
        $finalReturn['monthly_profits'] = $monthly_profits;

        return $finalReturn;
    }

    // public function permission(){
    //     return view('admin.dashboard.permission');
    // }

    // public function invoice(){
    //     return view('admin.invoice.index');
    // }
}
