<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\ConfirmRequest;
use App\Notifications\ServeRequest;
use Carbon\Carbon;
use App\Client;
use App\Order;
use App\Employee;
use App\Category;
use App\Menu;
use App\OrderDetail;
use App\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Cart;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class OrderController extends Controller{
    
    public function createOrderByManager() {
        $rstrt_slug = Employee::where('user_id', Auth::user()->id)->first()->rstrt_slug;
        Cart::destroy();
        $menus = Menu::where('rstrt_slug', $rstrt_slug)->where('dining_service', 1)->where('cate_id','!=',26)->get();
        $categories = Category::where('rstrt_slug', $rstrt_slug)->where('status', 1)->get();
        return view('admin.order.create.index', compact('menus', 'categories', 'rstrt_slug'));
    }

    public function searchItem(Request $request) {
        $rstrt_slug = Employee::where('user_id', Auth::user()->id)->first()->rstrt_slug;
        $search = $request->search;
        $menus = Menu::where('rstrt_slug', $rstrt_slug)->where('dining_service', 1)
            ->where(function($query) use ($search){
                $query->where('name', 'LIKE', '%'.$search.'%')
                ->orWhere('price', 'LIKE', '%'.$search.'%');
            })->get();
        return view('admin.order.add-more-menu', compact('menus'));
    }

    public function cart(Request $request){
        $rstrt_slug = $request->slug;
        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal = Cart::total();
        $total = Cart::subtotal() ;
        
        return response()->json(array(
        'carts' => $carts,
        'cartQty' => $cartQty,
        'cartTotal' => $cartTotal,
        'total' => $total,
        ));
        // return view('admin.order.create.cart', compact('rstrt_slug'));
    }

    public function menucard($rstrt_slug){
        $menus = Menu::where('rstrt_slug', $rstrt_slug)->where('dining_service', 1)->get();
        $categories = Category::where('rstrt_slug', $rstrt_slug)->where('status', 1)->get();
        return view('admin.order.create.index', compact('menus', 'categories', 'rstrt_slug'));
    }

    public function placeOrder($rstrt_slug) {
        $order_slug = str_random(30).rand().time();
        $restaurant = Restaurant::where('slug', $rstrt_slug)->first();

        $order = new Order();
        $order->rstrt_slug = $rstrt_slug;
        $order->slug = $order_slug;
        $order->total_amount = (float) str_replace(',', '', Cart::subtotal());
        $order->type = 1;
        $order->updated_by = Auth::user()->id;
        $order->status = 3;
        $order->avg_time = 0;
        $order->created_at = Carbon::now()->toDateTimeString();
        $order->save();

        foreach (Cart::content() as $item) {
            $order_details = new OrderDetail();
            $order_details->order_id = $order->id;
            $order_details->menu_id = $item->id;
            $order_details->unit_price = $item->price;
            $order_details->qty = $item->qty;
            $order_details->save();
        }

        $employees = Employee::where('rstrt_slug', $rstrt_slug)->get();
        if($order){
            Cart::destroy();
            Session::flash('success','value');
            foreach ($employees as $employee) {
                if($employee->userInfo->role_id == 5) {
                    $employee->userInfo->notify(new ConfirmRequest($order));
                } 
            }
            return redirect()->to('admin/order-serve');
        }else{
            Session::flash('error','value');
            return redirect()->back();
        }
    }    
    
    // Request start
    public function orderRequest(){
        if(Auth::user()->role_id == 2) {
            $client = Client::where('email', Auth::user()->email)->first();
            $restaurant = $client->restaurantInfo;
            return view('admin.order.request.index', compact('restaurant'));
        }

        if(Auth::user()->role_id == 3 ||  Auth::user()->role_id == 4) {
            $slug = Employee::where('user_id', Auth::user()->id)->first()->rstrt_slug;
            $orders = Order::where('rstrt_slug', $slug)->where('status', 1)->where('type',1)->orderBy('id', 'DESC')->get();
            return view('admin.order.request.all', compact('orders','slug'));
        }
    }

    public function typrWiseorderRequest(Request $request){
        if(Auth::user()->role_id == 2) {
            $client = Client::where('email', Auth::user()->email)->first();
            $restaurant = $client->restaurantInfo;
            return view('admin.order.request.index', compact('restaurant'));
        }

        if(Auth::user()->role_id == 3 ||  Auth::user()->role_id == 4) {
            $slug = Employee::where('user_id', Auth::user()->id)->first()->rstrt_slug;
            $orders = Order::where('rstrt_slug', $slug)->where('status', 1)->where('type',$request->CustType)->orderBy('id', 'DESC')->get();
            if($request->CustType==1){
                return view('admin.order.request.all', compact('orders','slug'));  
            }
            return view('admin.order.request.type2', compact('orders','slug'));
        }
    }

    public function allRequest($slug){
        $orders = Order::where('rstrt_slug', $slug)->where('status', 1)->orderBy('id', 'DESC')->get();
        return view('admin.order.request.all', compact('orders','slug'));
    }

    public function requestLoad($slug){
        $orders = Order::where('rstrt_slug', $slug)->where('status', 1)->orderBy('id', 'DESC')->get();
        $slug = Employee::where('user_id', Auth::user()->id)->first()->rstrt_slug;
        return view('admin.order.request.table', compact('orders', 'slug'));
    }

    public function requestData($rstrtSlug, $orderSlug, $action) {
        $slug = Employee::where('user_id', Auth::user()->id)->first()->rstrt_slug;
        $order = Order::where('slug', $orderSlug)->first();
        if($action == 2 || $action == 5){
            $order->updated_by = Auth::user()->id;
            if($action ==  5) {
                $order->cancel_status = $order->status;
            }
            $order->status = $action;
            $order->save();

           $orders = Order::where('rstrt_slug', $rstrtSlug)->where('status', 1)->orderBy('id', 'DESC')->get();

            // send notification to Chef
            $employees = Employee::where('rstrt_slug', $rstrtSlug)->get();
            foreach ($employees as $employee) {
                if($action == 2 && $employee->userInfo->role_id == 5) {
                    $employee->userInfo->notify(new ConfirmRequest($order));
                }

                // Read the notification
                $unreads = $employee->userInfo->unreadNotifications;
                if($unreads) {
                    foreach ($unreads as $unread) {
                        if($unread->data["order_id"] == $order->id && $unread->data["status"] == 1) {
                            $unread->markAsRead();
                        }
                    }
                } 
            }
        
            return view('admin.order.request.table', compact('orders', 'slug'));
        }
    }
    // RequestEnd

    // Confirm Start
    public function confirmed() {
        if(Auth::user()->role_id == 2) {
            $client = Client::where('email', Auth::user()->email)->first();
            $restaurant = $client->restaurantInfo;
            return view('admin.order.confirm.index', compact('restaurant'));
        }
        
        if(Auth::user()->role_id == 3 ||  Auth::user()->role_id == 5) {
            $slug = Employee::where('user_id', Auth::user()->id)->first()->rstrt_slug;
            $orders = Order::where('rstrt_slug', $slug)->where('status', 2)->where('type',1)->orderBy('id', 'DESC')->get();
            return view('admin.order.confirm.all', compact('orders','slug'));
        }
    }

    public function typrWiseOrderConfirmed(Request $request) {
        if(Auth::user()->role_id == 2) {
            $client = Client::where('email', Auth::user()->email)->first();
            $restaurant = $client->restaurantInfo;
            return view('admin.order.confirm.index', compact('restaurant'));
        }
        
        if(Auth::user()->role_id == 3 ||  Auth::user()->role_id == 5) {
            $slug = Employee::where('user_id', Auth::user()->id)->first()->rstrt_slug;
            $orders = Order::where('rstrt_slug', $slug)->where('status', 2)->where('type',$request->CustType)->orderBy('id', 'DESC')->get();
            if($request->CustType==1){
                return view('admin.order.confirm.all', compact('orders','slug'));  
            }
            return view('admin.order.confirm.type2', compact('orders','slug'));
        }

        
    }

    public function allConfirmed($slug){
        $orders = Order::where('rstrt_slug', $slug)->where('status', 2)->orderBy('id', 'DESC')->get();
        return view('admin.order.confirm.all', compact('orders','slug'));
    }

    public function confirmedLoad($slug){
        $orders = Order::where('rstrt_slug', $slug)->where('status', 2)->orderBy('id', 'DESC')->get();
        return view('admin.order.confirm.table', compact('orders'));
    }

    public function confirmedData($rstrtSlug, $orderSlug, $action){
        $order = Order::where('slug', $orderSlug)->first();
        if($action == 3 || $action == 5){
            if($action ==  5) {
                $order->updated_by = Auth::user()->id;
                $order->cancel_status = $order->status;
            }
            $order->status = $action;
            $order->save();

            $employees = Employee::where('rstrt_slug', $rstrtSlug)->get();
            foreach ($employees as $employee) {
                // Send the notification to waiter
                if($action == 3 && $employee->userInfo->role_id == 4) {
                    $employee->userInfo->notify(new ServeRequest($order));
                }
                // Read the notification
                $unreads = $employee->userInfo->unreadNotifications;
                foreach ($unreads as $unread) {
                    if($unread->data["order_id"] == $order->id && $unread->data["status"] == 2) {
                        $unread->markAsRead();
                    }
                } 
            }
        }

        $orders = Order::where('rstrt_slug', $rstrtSlug)->where('status', 2)->orderBy('id', 'DESC')->get();

        
        return view('admin.order.confirm.table', compact('orders'));
    }
    // Confirm End

    // Serve Start
    public function orderServe(){
        if(Auth::user()->role_id == 2) {
            $client = Client::where('email', Auth::user()->email)->first();
            $restaurant = $client->restaurantInfo;
            return view('admin.order.serve.index', compact('restaurant'));
        }

        if(Auth::user()->role_id == 3 || Auth::user()->role_id == 4) {
            $slug = Employee::where('user_id', Auth::user()->id)->first()->rstrt_slug;
            $orders = Order::where('rstrt_slug', $slug)->where('status', 3)->where('type',1)->orderBy('id', 'DESC')->get();
            return view('admin.order.serve.all', compact('orders','slug'));
        }
    }

    public function typrWiseOrdeOrderServe(Request $request){
        if(Auth::user()->role_id == 2) {
            $client = Client::where('email', Auth::user()->email)->first();
            $restaurant = $client->restaurantInfo;
            return view('admin.order.serve.index', compact('restaurant'));
        }

        if(Auth::user()->role_id == 3 || Auth::user()->role_id == 4) {
            $slug = Employee::where('user_id', Auth::user()->id)->first()->rstrt_slug;
            $orders = Order::where('rstrt_slug', $slug)->where('status', 3)->where('type',$request->CustType)->orderBy('id', 'DESC')->get();
            if($request->CustType==1){
                return view('admin.order.serve.all', compact('orders','slug'));  
            }
            return view('admin.order.serve.type2', compact('orders','slug'));
        }
    }

    public function allServe($slug){
        $orders = Order::where('rstrt_slug', $slug)->where('status', 3)->orderBy('id', 'DESC')->get();
        return view('admin.order.serve.all', compact('orders','slug'));
    }

    public function serveLoad($slug){
        $orders = Order::where('rstrt_slug', $slug)->where('status', 3)->orderBy('id', 'DESC')->get();
        return view('admin.order.serve.table', compact('orders'));
    }

    public function serveData($rstrtSlug, $orderSlug, $action){
        $order = Order::where('slug', $orderSlug)->first();
        if($action == 4 || $action == 5){
            if($action ==  5) {
                $order->updated_by = Auth::user()->id;
                $order->cancel_status = $order->status;
            }
            $order->status = $action;
            $order->save();

            $employees = Employee::where('rstrt_slug', $rstrtSlug)->get();
            foreach ($employees as $employee) {
                // Read the notification
                $unreads = $employee->userInfo->unreadNotifications;
                foreach ($unreads as $unread) {
                    if($unread->data["order_id"] == $order->id && $unread->data["status"] == 3) {
                        $unread->markAsRead();
                    }
                } 
            }
        }

        $orders = Order::where('rstrt_slug', $rstrtSlug)->where('status', 3)->orderBy('id', 'DESC')->get();

        return view('admin.order.serve.table', compact('orders'));
    }
    // Serve End

    // Delivery Start
    public function delivered(){
        if(Auth::user()->role_id == 2) {
            $client = Client::where('email', Auth::user()->email)->first();
            $restaurant = $client->restaurantInfo;
            return view('admin.order.delivery.index', compact('restaurant'));
        }

        if(Auth::user()->role_id == 3) {
            $slug = Employee::where('user_id', Auth::user()->id)->first()->rstrt_slug;
            $to = Carbon::today();
            $from = Carbon::today()->subDays(7);
            $orders = Order::where('rstrt_slug', $slug)->where('status', 4)->where('created_at', '>=', $from)->orderBy('id', 'DESC')->get();
            return view('admin.order.delivery.all', compact('orders','slug', 'from', 'to'));
        }
        
    }

    public function allDelivered($slug){
        $to = Carbon::today();
        $from = Carbon::today()->subDays(7);
        $orders = Order::where('rstrt_slug', $slug)->where('status', 4)->where('created_at', '>=', $from)->orderBy('id', 'DESC')->get();
        return view('admin.order.delivery.all', compact('orders','slug', 'from', 'to'));
    }

    // Delivery End

    // Cancelled Start
    public function cancelled() {
        if(Auth::user()->role_id == 2) {
            $client = Client::where('email', Auth::user()->email)->first();
            $restaurant = $client->restaurantInfo;
            return view('admin.order.cancel.index', compact('restaurant'));
        }

        if(Auth::user()->role_id == 3 ||  Auth::user()->role_id == 4) {
            $slug = Employee::where('user_id', Auth::user()->id)->first()->rstrt_slug;
            $to = Carbon::today();
            $from = Carbon::today()->subDays(7);
            $orders = Order::where('rstrt_slug', $slug)->where('status', 5)->where('created_at', '>=', $from)->orderBy('id', 'DESC')->get();
            return view('admin.order.cancel.all', compact('orders','slug', 'from', 'to'));
        }
    }

    public function allCancelled($slug) {
        $to = Carbon::today();
        $from = Carbon::today()->subDays(7);
        $orders = Order::where('rstrt_slug', $slug)->where('status', 5)->where('created_at', '>=', $from)->orderBy('id', 'DESC')->get();
        return view('admin.order.cancel.all', compact('orders','slug', 'from', 'to'));
    }

    public function customOrderReport(Request $request, $status, $slug){
        $this->validate($request, [
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from'
        ],[
            'from.required' => 'Report From is required',
            'to.required' => 'Report To is required',
            'from.date' => 'Report From must be a date',
            'to.date' => 'Report to must be a date',
            'to.after_or_equal' => 'To date must less than From date'
        ]);
        $from = $request->from;
        $to = $request->to;

        $orders = Order::where('rstrt_slug', $slug)->whereBetween('created_at',[$from, $to])->where('status', $status)->latest()->get();
        if($status == 4) {
            return view('admin.order.delivery.all', compact('orders','slug', 'from', 'to'));
        } else if ($status == 5) {
            return view('admin.order.cancel.all', compact('orders','slug', 'from', 'to'));
        }
    }
    // Cancelled End

    public function viewRequest($slug, $status) {
        $order = Order::where('slug', $slug)->first();
        // Read the notification
        $unreads = auth()->user()->unreadNotifications;
        foreach ($unreads as $unread) {
            if($unread->data["order_id"] == $order->id) {
                $unread->markAsRead();
            }
        }
        return view('admin.order.view', compact('order','status'));
    }

    public function editRequest($slug){
        $order = Order::where('slug', $slug)->first();
        Cart::destroy();
        foreach ($order->detailInfo as $detail) {
            Cart::add([
                'id' => $detail->orderDetailMenu->id, 
                'name' => $detail->orderDetailMenu->name, 
                'qty' => $detail->qty, 
                'price' => $detail->orderDetailMenu->price,
                'weight' => 0, 
                'options' => ['photo' => $detail->orderDetailMenu->photo, 'type' => 3]
            ]);
        }
        return view('admin.order.edit', compact('order'));
    }

    public function addToCartWithCrust(Request $request){
        // return "ok";
         $menu = Menu::where('id', $request->id)->where('rstrt_slug', $request->rstrt_slug)->first();

        // dd($request->all());
        // dd($request->sizeId);

        $price = $request->price;
        if($request->sizeId != null){
            $price = $request->sizeId;
        }

        $addonSize = 0;
        if($menu->addons == 1){
            $addonSize = $request->addonSize;
        }

        $medium = 0;
        if($request->medium != null){
            $medium = $request->medium;
        }
        $medium = 0;
        if($request->medium != null){
            $medium = $request->medium;
        }
        $sThin = 0;
        if($request->sThin != null){
            $sThin = $request->sThin;
        }
        $thick = 0;
        if($request->thick != null){
            $thick = $request->thick;
        }
        $thin = 0;
        if($request->thin != null){
            $thin = $request->thin;
        }
       
        Cart::add([
            'id' => $menu->id, 
            'name' => $menu->name, 
            'qty' => 1, 
            'price' => $price,
            'weight' => 0, 
            'options' => ['photo' => $menu->photo,
            'type' => 3,
            'medium' => $medium,
            'thin' => $thin,
            'thick' => $thick,
            'sThin' => $sThin,
            'addonSize' => $addonSize,
            ]
        ]);
    }

    public function addToCart($id, $rstrt_slug){
        $menu = Menu::where('id', $id)->where('rstrt_slug', $rstrt_slug)->first();

        Cart::add([
            'id' => $menu->id, 
            'name' => $menu->name, 
            'qty' => 1, 
            'price' => $menu->price,
            'weight' => 0, 
            'options' => ['photo' => $menu->photo, 'type' => 3]
        ]);
    }


    public function addToCartMenu($id, $rstrt_slug){
        $menu = Menu::where('id', $id)->where('rstrt_slug', $rstrt_slug)->first();

        $addonsProduct = 0;
        if($menu->addons == true){
          $addonsProduct = Menu::where('cate_id',26)->where('rstrt_slug', $rstrt_slug)->get();
        }

        $sizes = $menu->size;
        $prices = $menu->price;
        $allSize = 0;

        if($menu->size !=0){
            $allPrice = explode(',',$prices);

            $allSize = explode(',',$sizes);
            $combainArray =  array_combine($allSize,$allPrice);
        }

        return response()->json(['menu'=>$menu, 'allSize'=>$allSize, 'allPrice'=>$allPrice, 'addonsProduct'=>$addonsProduct, 'combainArray'=>$combainArray]);
    }



    public function addMore($slug, $rstrt_slug){
        $menus = Menu::where('rstrt_slug', $rstrt_slug)->where('dining_service', 1)->get();
        $categories = Category::where('rstrt_slug', $rstrt_slug)->where('status', 1)->get();
        return view('admin.order.add-more', compact('menus', 'categories', 'rstrt_slug', 'slug'));
    }


    public function cateItem($id, $rstrt_slug, $type){
        $menus = '';
        if($type == 'all') {
            $menus = Menu::where('rstrt_slug', $rstrt_slug)->where('dining_service', 1)->get();
        } else if($type == 'cate') {
            $menus = Category::where('id', $id)->where('rstrt_slug', $rstrt_slug)->first()->categoryMenu; 
        }
        return view('admin.order.add-more-menu', compact('menus'));
    }


    public function editedCart($slug){
        $order = Order::where('slug', $slug)->first();
        return view('admin.order.edit', compact('order'));
    }

    public function submitEdit($slug, $rstrt_slug) {
        $order = Order::where('slug', $slug)->where('rstrt_slug', $rstrt_slug)->first();
        foreach ($order->detailInfo as $detail) {
            $detail->delete();
        }

        $order->total_amount = (float)str_replace(',', '', Cart::subtotal());
        $order->save();

        foreach (Cart::content() as $item) {
            $order_details = new OrderDetail();
            $order_details->order_id = $order->id;
            $order_details->menu_id = $item->id;
            $order_details->qty = $item->qty;
            $order_details->unit_price = $item->price;
            $order_details->save();
        }
        Cart::destroy();
        return redirect('admin/order-request/view/'.$order->slug.'/'. 1);
    }

    public function updateQty($itemId, $action){
        foreach (Cart::content() as $item) {
            if($item->id == $itemId) {
                $rowId = $item->rowId;
                $qty = $item->qty;
            }
        }
        if($action == 'inc') {
            Cart::update($rowId, ++$qty);
        } else if($action == 'dec') {
            Cart::update($rowId, --$qty);
        }

        return view('admin.order.edit-table');
    }

    public function deleteCartItem($itemId){
        foreach (Cart::content() as $item) {
            if($item->id == $itemId) {
                $rowId = $item->rowId;
            }
        }
        Cart::remove($rowId);
        return view('admin.order.edit-table');
    }

    public function destroy($slug){
    	$delete = Order::where('slug', $slug)->first()->delete();
    	if($delete){
    	    Session::flash('success','value');
    	    return redirect()->back();
    	}else{
    	    Session::flash('error','value');
    	    return redirect()->back();;
    	}
    }

    public function requestNoty() {
        return view('admin.order.notification.request');
    }
}
