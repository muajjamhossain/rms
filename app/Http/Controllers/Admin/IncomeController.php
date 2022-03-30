<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Employee;
use App\Income;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class IncomeController extends Controller
{

	public function gatewayTotalIncAmount($id){
		if($id == 0){
			return $total = Income::sum('amount');
		}
		return $total = Income::where('pay_by',$id)->sum('amount');
	}



    public function index()
    {	

    	if(Auth::user()->role_id == 3) {
    		$slug = Employee::where('user_id', Auth::user()->id)->first()->rstrt_slug;
    		$from = Carbon::today()->subDays(7);
    		$to = Carbon::today();
    		$incomes = Income::where('rstrt_slug', $slug)->where('created_at', '>=', $from)->latest()->get();

			$handCash = $this->gatewayTotalIncAmount(1);
			$Bkash = $this->gatewayTotalIncAmount(2);
			$Nagad = $this->gatewayTotalIncAmount(3);
			$DBBL = $this->gatewayTotalIncAmount(4);
			$City = $this->gatewayTotalIncAmount(5);
			$FoodPanda = $this->gatewayTotalIncAmount(6);
			$Hungrynaki = $this->gatewayTotalIncAmount(7);
			$PathaoFood = $this->gatewayTotalIncAmount(8);
			$total = $this->gatewayTotalIncAmount(0);

    		return view('admin.income.index', compact('total', 'PathaoFood', 'Hungrynaki', 'FoodPanda', 'City', 'DBBL', 'Nagad', 'Bkash', 'handCash', 'incomes', 'slug', 'from', 'to'));
    	}
    }
    public function gateway($gateway)
    {
    	if(Auth::user()->role_id == 3) {
    		$slug = Employee::where('user_id', Auth::user()->id)->first()->rstrt_slug;
    		$from = Carbon::today()->subDays(7);
    		$to = Carbon::today();
    		$incomes = Income::where('rstrt_slug', $slug)->where('created_at', '>=', $from)->where('pay_by',$gateway)->latest()->get();
    		
			$handCash = $this->gatewayTotalIncAmount(1);
			$Bkash = $this->gatewayTotalIncAmount(2);
			$Nagad = $this->gatewayTotalIncAmount(3);
			$DBBL = $this->gatewayTotalIncAmount(4);
			$City = $this->gatewayTotalIncAmount(5);
			$FoodPanda = $this->gatewayTotalIncAmount(6);
			$Hungrynaki = $this->gatewayTotalIncAmount(7);
			$PathaoFood = $this->gatewayTotalIncAmount(8);
			$total = $this->gatewayTotalIncAmount(0);
			return view('admin.income.index', compact('total', 'PathaoFood', 'Hungrynaki', 'FoodPanda', 'City', 'DBBL', 'Nagad', 'Bkash', 'handCash','incomes', 'slug', 'from', 'to'));
    	}
    }

    public function store(Request $request)
    {
    	$this->validate($request,[
    		'rstrt_slug' => 'required',
    		'pay_by' => 'required',
    		'incom_for' => 'required',
    		'amount' => 'required|numeric'
    	],[
    		'incom_for.required' => 'Please enter the reason of income' 
    	]);
    	$create = Income::create($request->all());
    	return redirect('admin/incomes');
    }

    public function report(Request $request, $slug)
    {
		// dd($request->all());
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

    	$from=$request->from.' 00:00:01';
 		$to=$request->to.' 23:59:59';

 		$gateway = $request->pay_by;
		 if($gateway != 0){
			//  dd('gateway');
			 $incomes = Income::where('rstrt_slug', $slug)->whereBetween('created_at', [$from, $to])->where('pay_by',$gateway)->latest()->get();
		 }else{
			// dd(' no gateway');
			 $incomes = Income::where('rstrt_slug', $slug)->whereBetween('created_at', [$from, $to])->latest()->get();
		 }

		 
		 $handCash = $this->gatewayTotalIncAmount(1);
		 $Bkash = $this->gatewayTotalIncAmount(2);
		 $Nagad = $this->gatewayTotalIncAmount(3);
		 $DBBL = $this->gatewayTotalIncAmount(4);
		 $City = $this->gatewayTotalIncAmount(5);
		 $FoodPanda = $this->gatewayTotalIncAmount(6);
		 $Hungrynaki = $this->gatewayTotalIncAmount(7);
		 $PathaoFood = $this->gatewayTotalIncAmount(8);
		 $total = $this->gatewayTotalIncAmount(0);
    	return view('admin.income.index', compact('total', 'PathaoFood', 'Hungrynaki', 'FoodPanda', 'City', 'DBBL', 'Nagad', 'Bkash', 'handCash','incomes', 'slug', 'from', 'to'));
    }

    public function destroy($id)
    {
    	if(Auth::user()->role_id == 3) {
    		$slug = Employee::where('user_id', Auth::user()->id)->first()->rstrt_slug;
    		$delete = Income::where('id', $id)->where('rstrt_slug', $slug)->delete();
    		if($delete) {
    			Session::flash('success','value');
    		} else {
    			Session::flash('error','value');
    		}
    		return redirect('admin/incomes');
    	}
    }

    public function update(Request $request, $id)
    {	
    	$this->validate($request,[
    		'rstrt_slug' => 'required',
    		'incom_for' => 'required',
			'pay_by' => 'required',
    		'amount' => 'required|numeric'
    	],[
    		'incom_for.required' => 'Please enter the reason of incomes' 
    	]);
    	$incomes = Income::where('id', $id)->where('rstrt_slug', $request->rstrt_slug)->first();
    	$incomes->update($request->all());
    	return redirect('admin/incomes');
    }
}
