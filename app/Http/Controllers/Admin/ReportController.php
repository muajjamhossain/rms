<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Client;
use App\Employee;
use Carbon\Carbon;
use App\Order;
use App\Bill;
use App\Expense;
use App\Restaurant;

class ReportController extends Controller{

    public function index(){
        if(Auth::user()->role_id == 3) {
            $restaurant = Employee::where('user_id', Auth::user()->id)->first()->restaurantInfo;
            $currency = $restaurant->currency_symbol;
   			$to = Carbon::today();
            $from = Carbon::today()->subDays(7);
            $delivered_orders = Order::with('billInfo')->where('rstrt_slug', $restaurant->slug)->where('created_at', '>=', $from)->where('payment_status', 1)->latest()->get();
            $num_of_cancel_orders = Order::where('rstrt_slug', $restaurant->slug)->where('created_at', '>=', $from)->where('status', 5)->count();
            
            $income = 0;
            $vat = 0;
            $discount = 0;
            $total_amount = 0;
            foreach ($delivered_orders as $order) {
                $total_amount += $order->total_amount;
                $income += $order->billInfo->amount;
                $vat += $order->billInfo->vat;
                $discount += $order->billInfo->discount;
            }

            $expense = Expense::where('rstrt_slug', $restaurant->slug)->whereBetween('created_at', [$from,$to])->sum('amount');

    		return view('admin.report.report', compact('restaurant', 'currency', 'total_amount', 'discount', 'delivered_orders', 'num_of_cancel_orders', 'income','expense', 'vat', 'from', 'to'));
    	}

        if(Auth::user()->role_id == 2) {
            $client = Client::where('email', Auth::user()->email)->first();
            $restaurant = $client->restaurantInfo;
            return view('admin.report.index', compact('restaurant'));
        }
    }

    public function gateway($gateway){
        // dd($gateway);
        if(Auth::user()->role_id == 3) {
            $restaurant = Employee::where('user_id', Auth::user()->id)->first()->restaurantInfo;
            $currency = $restaurant->currency_symbol;
   			$to = Carbon::today();
            $from = Carbon::today()->subDays(7);

            $delivered_orders = Order::with('billInfo')->where('rstrt_slug', $restaurant->slug)->where('created_at', '>=', $from)->where('payment_status', 1)->latest()->get();
            $num_of_cancel_orders = Order::where('rstrt_slug', $restaurant->slug)->where('created_at', '>=', $from)->where('status', 5)->count();
            
            $typeWise = Bill::with('orderInfo.userInfo')->where('rstrt_slug',$restaurant->slug)->where('created_at', '>=', $from)->where('pay_by',$gateway)->get();
           
            $income = 0;
            $vat = 0;
            $discount = 0;
            $total_amount = 0;
            foreach ($typeWise as $order) {
                $total_amount += $order->orderInfo->total_amount;
                $income += $order->amount;
                $vat += $order->vat;
                $discount += $order->discount;
            }


            $expense = Expense::where('rstrt_slug', $restaurant->slug)->whereBetween('created_at', [$from,$to])->sum('amount');

    		return view('admin.report.report-type', compact('restaurant', 'currency', 'total_amount', 'discount', 'delivered_orders', 'num_of_cancel_orders', 'income','expense', 'vat', 'from', 'to', 'typeWise'));
    	}

        if(Auth::user()->role_id == 2) {
            $client = Client::where('email', Auth::user()->email)->first();
            $restaurant = $client->restaurantInfo;
            return view('admin.report.index', compact('restaurant'));
        }
    }



    public function report($slug){
        $restaurant = Restaurant::where('slug', $slug)->first();
        $currency = $restaurant->currency_symbol;
        $to = Carbon::today();
        $from = Carbon::today()->subDays(7);
        $delivered_orders = Order::with('billInfo')->where('rstrt_slug', $restaurant->slug)->where('created_at', '>=', $from)->where('payment_status', 1)->latest()->get();
        $num_of_cancel_orders = Order::where('rstrt_slug', $restaurant->slug)->where('created_at', '>=', $from)->where('status', 5)->count();
        
        $income = 0;
        $vat = 0;
        $discount = 0;
        $total_amount = 0;
        foreach ($delivered_orders as $order) {
            $total_amount += $order->total_amount;
            $income += $order->billInfo->amount;
            $vat += $order->billInfo->vat;
            $discount += $order->billInfo->discount;
        }
        $expense = Expense::where('rstrt_slug', $restaurant->slug)->whereBetween('created_at', [$from,$to])->sum('amount');

        return view('admin.report.report', compact('restaurant', 'total_amount', 'discount', 'delivered_orders', 'num_of_cancel_orders', 'income','expense', 'vat', 'from', 'to'));
    }


    public function customReport(Request $request, $slug){
        // dd($request->pay_by);
    	$this->validate($request, [
    		'from' => 'required|date',
    		'to' => 'required|date|after_or_equal:from'
    	],[
    		'from.required' => 'Report From is required',
    		'to.required' => 'Report To is required',
    		'from.date' => 'Report From must be a date',
    		'to.date' => 'Report to must be a date',
    		'to.after_or_equal' => 'Report To date must less than Report From date'
    	]);
 		$restaurant = Restaurant::where('slug', $slug)->first();
 		$from=$request->from.' 00:00:01';
 		$to=$request->to.' 23:59:59';

 		$delivered_orders = Order::with('billInfo')->where('rstrt_slug', $restaurant->slug)->whereBetween('created_at',[$from, $to])->where('payment_status', 1)->latest()->get();

 		$num_of_cancel_orders = Order::with('billInfo')->where('rstrt_slug', $restaurant->slug)->whereBetween('created_at',[$from, $to])->where('status', 5)->count();
         
         if($request->pay_by != 0){
            $delivered_orders = Order::with('billInfo')->where('rstrt_slug', $restaurant->slug)->whereBetween('created_at',[$from, $to])->where('payment_status', 1)->where('type',$request->pay_by)->latest()->get();

 		    $num_of_cancel_orders = Order::with('billInfo')->where('rstrt_slug', $restaurant->slug)->whereBetween('created_at',[$from, $to])->where('status', 5)->where('type',$request->pay_by)->count();
         
         }
         $income = 0;
         $vat = 0;
         $discount = 0;
         $total_amount = 0;
         foreach ($delivered_orders as $order) {
             $total_amount += $order->total_amount;
             $income += $order->billInfo->amount;
             $vat += $order->billInfo->vat;
             $discount += $order->billInfo->discount;
         }

        $expense = Expense::where('rstrt_slug', $restaurant->slug)->whereBetween('created_at', [$from,$to])->sum('amount');

 		return view('admin.report.report', compact('restaurant', 'total_amount', 'discount', 'delivered_orders', 'num_of_cancel_orders', 'income','expense', 'vat', 'from', 'to'));
    }
}
