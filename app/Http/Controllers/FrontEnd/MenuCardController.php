<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\OrderRequest;
use App\Restaurant;
use App\Order;
use App\OrderDetail;
use App\Employee;
use App\Income;
use Cart;
use Carbon\Carbon;
use Session;
use notification;

class MenuCardController extends Controller
{

    public function dataInsert(Request $request){

        dd($request->all());
        // $name = $request->name;
        //  $date['rstrt_slug'] = $request->file;
        //  $date['pay_by'] = $request->name;
        //  $date['incom_for'] = 22;
        //  $date['amount'] = 22;
        //  if($request->hasFile('file')){
        //     $file = $request->file('file');
        //     $fileName = "file_".date().$file->getClientOriginalExtension();

        //     Image:: make
        //  }

        // $date = Income::create($request->all());
        
        //     return response()->json(['success'=>'successfully insert']);
        

    }


    public function index($url){
        $restaurant = Restaurant::where('url', $url)->firstOrFail();
        // dd($restaurant->menu_theme);
    	return view('front-end.layout'.$restaurant->menu_theme.'.index', compact('restaurant'));
    }

    public function takeaway($url)
    {
    	$restaurant = Restaurant::where('url', $url)->firstOrFail();
    	if($restaurant->takeaway_switch  == 1) {
    		return view('front-end.layout'.$restaurant->menu_theme.'.takeaway', compact('restaurant'));
    	} else {
    		return redirect()->to('menu/'.$url);
    	}
    	
    }

    public function cart($url)
    {
        $restaurant = Restaurant::where('url', $url)->firstOrFail();
        // dd($restaurant->menu_theme);
        return view('front-end.layout'.$restaurant->menu_theme.'.cart', compact('restaurant'));
    }

    public function placeOrder(Request $request, $slug, $type)
    {
        if($type == 2) {
            $this->validate($request,[
                'name' => 'required|string|max:50',
                'phone' => 'required',
                'delivery_date' => 'required',
                'delivery_time' => 'required'
            ]);
            
        $request->merge(['delivery_time' => Carbon::create($request->delivery_time)->format('g:i A')]);
        }
        
        $order_slug = str_random(30).$request->name.rand().time();
        $restaurant = Restaurant::where('slug', $slug)->first();

        $request->request->add(['rstrt_slug' => $slug]);
        $request->request->add(['total_amount' => (float) str_replace(',', '', Cart::subtotal())]);
        $request->request->add(['slug' => $order_slug]);
        $request->request->add(['type' => $type]);
        $request->merge(['created_at' => Carbon::now()->toDateTimeString()]);

        $request['avg_time'] = 0;

        $order = Order::create($request->all());
        $order_id = $order->id;


        foreach (Cart::content() as $item) {
            $order_details = new OrderDetail();
            $order_details->order_id = $order_id;
            $order_details->menu_id = $item->id;
            $order_details->unit_price = $item->price;
            $order_details->qty = $item->qty;
            $order_details->save();
        }

        $employees = Employee::where('rstrt_slug', $slug)->get();
        
        if($order){
            Cart::destroy();
            Session::flash('success','value');
            foreach ($employees as $employee) {
                if($employee->userInfo->role_id == 4) {
                    $employee->userInfo->notify(new OrderRequest($order));
                } 
            }
            return redirect()->to('menu/'.$restaurant->url);
        }else{
            Session::flash('error','value');
            return redirect()->to('menu/'.$restaurant->url);
        }
    }
}
