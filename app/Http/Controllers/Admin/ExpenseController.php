<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Employee;
use App\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ExpenseController extends Controller
{

	public function gatewayTotalExpAmount($id){
		if($id == 0){
			return $total = Expense::sum('amount');
		}
		return $total = Expense::where('pay_by',$id)->sum('amount');
	}

	public function incomeMinusExpense($gateway, $expAmount){
		$IncomeConObj = new IncomeController();
		$gatewayWiseIncome = $IncomeConObj->gatewayTotalIncAmount($gateway);
	    return $amount = $gatewayWiseIncome - $expAmount;

	}


    public function index()
    {
    	if(Auth::user()->role_id == 3) {
    		$slug = Employee::where('user_id', Auth::user()->id)->first()->rstrt_slug;
    		$from = Carbon::today()->subDays(7);
    		$to = Carbon::today();
    		$expenses = Expense::where('rstrt_slug', $slug)->where('created_at', '>=', $from)->latest()->get();
    		
			$handCash = $this->gatewayTotalExpAmount(1);
			$Bkash = $this->gatewayTotalExpAmount(2);
			$Nagad = $this->gatewayTotalExpAmount(3);
			$DBBL = $this->gatewayTotalExpAmount(4);
			$City = $this->gatewayTotalExpAmount(5);
			$total = $this->gatewayTotalExpAmount(0);

			return view('admin.expense.index', compact('total', 'City', 'DBBL', 'Nagad', 'Bkash', 'handCash','expenses', 'slug', 'from', 'to'));
    	}
    }
    public function gateway($gateway)
    {
    	if(Auth::user()->role_id == 3) {
    		$slug = Employee::where('user_id', Auth::user()->id)->first()->rstrt_slug;
    		$from = Carbon::today()->subDays(7);
    		$to = Carbon::today();
    		$expenses = Expense::where('rstrt_slug', $slug)->where('created_at', '>=', $from)->where('pay_by',$gateway)->latest()->get();
    		$handCash = $this->gatewayTotalExpAmount(1);
			$Bkash = $this->gatewayTotalExpAmount(2);
			$Nagad = $this->gatewayTotalExpAmount(3);
			$DBBL = $this->gatewayTotalExpAmount(4);
			$City = $this->gatewayTotalExpAmount(5);
			$total = $this->gatewayTotalExpAmount(0);
			return view('admin.expense.index', compact('total', 'City', 'DBBL', 'Nagad', 'Bkash', 'handCash','expenses', 'slug', 'from', 'to'));
    	}
    }

    public function store(Request $request)
    {
    	$this->validate($request,[
    		'rstrt_slug' => 'required',
    		'pay_by' => 'required',
    		'expense_for' => 'required',
    		'amount' => 'required|numeric'
    	],[
    		'expense_for.required' => 'Please enter the reason of expense' 
    	]);

    	$create = Expense::create($request->all());

	    $gatewayIncAmount = $this->incomeMinusExpense($request->pay_by, $request->amount);
    	return redirect('admin/expense');
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
			 $expenses = Expense::where('rstrt_slug', $slug)->whereBetween('created_at', [$from, $to])->where('pay_by',$gateway)->latest()->get();
		 }else{
			// dd(' no gateway');
			 $expenses = Expense::where('rstrt_slug', $slug)->whereBetween('created_at', [$from, $to])->latest()->get();
		 }

		    $handCash = $this->gatewayTotalExpAmount(1);
			$Bkash = $this->gatewayTotalExpAmount(2);
			$Nagad = $this->gatewayTotalExpAmount(3);
			$DBBL = $this->gatewayTotalExpAmount(4);
			$City = $this->gatewayTotalExpAmount(5);
			$total = $this->gatewayTotalExpAmount(0);

    	return view('admin.expense.index', compact('total', 'City', 'DBBL', 'Nagad', 'Bkash', 'handCash','expenses', 'slug', 'from', 'to'));
    }

    public function destroy($id)
    {
    	if(Auth::user()->role_id == 3) {
    		$slug = Employee::where('user_id', Auth::user()->id)->first()->rstrt_slug;
    		$delete = Expense::where('id', $id)->where('rstrt_slug', $slug)->delete();
    		if($delete) {
    			Session::flash('success','value');
    		} else {
    			Session::flash('error','value');
    		}
    		return redirect('admin/expense');
    	}
    }

    public function update(Request $request, $id)
    {	
    	$this->validate($request,[
    		'rstrt_slug' => 'required',
    		'expense_for' => 'required',
			'pay_by' => 'required',
    		'amount' => 'required|numeric'
    	],[
    		'expense_for.required' => 'Please enter the reason of expense' 
    	]);
    	$expense = Expense::where('id', $id)->where('rstrt_slug', $request->rstrt_slug)->first();
    	$expense->update($request->all());
    	return redirect('admin/expense');
    }
}
