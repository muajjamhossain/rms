<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;
use App\Order;
Use App\Bill;
use Illuminate\Support\Facades\Auth;


class BillController extends Controller
{
    public function index(){
    	$restaurant = Employee::where('user_id', Auth::user()->id)->first()->restaurantInfo;
    	$non_paid_bills = Order::where('rstrt_slug', $restaurant->slug)->where('payment_status', 0)->where('type',1)->orderBy('id','DESC')->get();
    	return view('admin.bill.bill', compact('non_paid_bills','restaurant'));
    }

    public function typeWiseOrder(Request $request){
        // dd($request->all());
    	$restaurant = Employee::where('user_id', Auth::user()->id)->first()->restaurantInfo;
    	$non_paid_bills = Order::where('rstrt_slug', $restaurant->slug)->where('payment_status', 0)->where('type',$request->CustType)->orderBy('id','DESC')->get();
        if($request->CustType == 1){
         return view('admin.bill.bill', compact('non_paid_bills','restaurant'));
        }
    	return view('admin.bill.bill2', compact('non_paid_bills','restaurant'));
    }


    public function show($slug){
        // dd('oookk');
    	$order = Order::where('slug', $slug)->first();
    	return view('admin.bill.view', compact('order'));
    }

    public function create(Request $request, $slug){
    	$order =  Order::where('slug', $slug)->first();
        
        if($order->orderRestaurant->payment_way == 0) {
            $this->validate($request,[
                'bill' => 'numeric|required',
                'discount' => 'numeric|required|lte:bill',
                'vat' => 'required',
                'amount_with_vat' => 'numeric|required',
                'pay_by' => 'required',
                'given_amount' => 'required'
            ]);
            $order->payment_status = 1;
            $order->save();
        } else {
            $this->validate($request,[
                'bill' => 'numeric|required',
                'discount' => 'numeric|required|lte:bill',
                'vat' => 'required',
                'amount_with_vat' => 'numeric|required'
            ]);
        }
        

        $amount = $order->total_amount;
        if($order->orderRestaurant->discount > 0 || $order->orderRestaurant->trusted_manager == 0) {
            $discount = $amount * $order->orderRestaurant->discount/100;
        } else {
            $discount = $request->discount;
        }
        $vat = ($amount-$discount)*$order->orderRestaurant->vat/100;

        $invoice = str_random(2).$order->id.str_random(2);
    	$bill = new Bill();
    	$bill->order_slug = $slug;
    	$bill->rstrt_slug = $order->rstrt_slug;
        $bill->invoice_no = $invoice;
    	$bill->discount   = $discount;
    	$bill->amount     = $amount - $discount;
        $bill->vat        = $vat;
    	if($order->orderRestaurant->payment_way == 0) {
            $bill->pay_by     = $request->pay_by;
            $bill->given_amount = $request->given_amount;
            $bill->status = 0;
        } else {
            $bill->status = 1;
        }
    	$bill->save();



            $request['rstrt_slug'] = $order->rstrt_slug;
    		$request['incom_for'] = $invoice;
			$request['pay_by'] = $request->pay_by;
    		$request['amount'] = ($amount - $discount) + (($amount-$discount)*$order->orderRestaurant->vat/100);

           $incConObj = new IncomeController();
           $insertInIncome =  $incConObj->store($request);
    }

    public function invoice($slug){
        $order = Order::where('slug', $slug)->first();
        // dd($order->orderRestaurant->vat_status);
        $vat_status = $order->orderRestaurant->vat_status;
        if($order->orderRestaurant->payment_way == 0) {
            if($order->orderRestaurant->invoice === 3) {
                $pending = Order::where('rstrt_slug', $order->rstrt_slug)->where('status', 2)->get()->count();
                return view('admin.invoice.invoice-3.index', compact('order', 'pending', 'vat_status'));
            } else {
               return view('admin.invoice.invoice-'.$order->orderRestaurant->invoice.'.index', compact('order' ,'vat_status')); 
            }
        } else if($order->orderRestaurant->payment_way == 1) {
            $table_pay = true;
            return view('admin.invoice.invoice-2.index', compact('order' , 'vat_status'));
        } 
    }

    public function pendings($slug){
        $slug = Employee::where('user_id', Auth::user()->id)->first()->rstrt_slug;
        $non_paid_bills = Bill::where('rstrt_slug', $slug)->where('status', 1)->get();
        return view('admin.bill.pending', compact('non_paid_bills','slug'));
    }

    public function updateBill(Request $request, $slug){
        $this->validate($request,[
            'bill' => 'numeric|required',
            'discount' => 'numeric|required|lte:bill',
            'vat' => 'required',
            'amount_with_vat' => 'numeric|required',
            'pay_by' => 'required',
            'given_amount' => 'required'
        ]);

        $order =  Order::where('slug', $slug)->first();
        $order->payment_status = 1;
        $order->save();

        $amount = $order->total_amount;
        if($order->orderRestaurant->discount > 0 || $order->orderRestaurant->trusted_manager == 0) {
            $discount = $amount * $order->orderRestaurant->discount/100;
        } else {
            $discount = $request->discount;
        }
        $vat = ($amount-$discount)*$order->orderRestaurant->vat/100;

        $bill = $order->billInfo;
        $bill->discount   = $discount;
        $bill->amount     = $amount - $discount;
        $bill->vat        = $vat;
        $bill->pay_by     = $request->pay_by;
        $bill->given_amount = $request->given_amount;
        $bill->status = 0;
        $bill->save();
    }
}
