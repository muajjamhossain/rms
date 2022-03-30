<?php

namespace App\Http\Controllers\Admin;

use App\Restaurant;
use App\Client;
use App\Category;
use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use PDF;
use App;
use View;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role_id == 1){
            $restaurant = Restaurant::orderBy('id', 'DESC')->get();
            return view('admin.restaurant.all',compact('restaurant'));
        }

        if(Auth::user()->role_id == 2){
            $client = Client::where('email', Auth::user()->email)->first();
            $restaurant = $client->restaurantInfo;
            return view('admin.restaurant.all',compact('restaurant'));
        }

        if(Auth::user()->role_id == 3){
            $restaurant = Employee::where('user_id', Auth::user()->id)->first()->restaurantInfo;
            return view('admin.restaurant.view', compact('restaurant'));
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role_id == 1){
            $clients = Client::get();
        } else {
            $clients = '';
        }

        if(Auth::user()->role_id == 2){
            $client_id = Client::where('email', Auth::user()->email)->first()->id;
        } else {
            $client_id = '';
        }
        
        return view('admin.restaurant.add', compact('clients', 'client_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:180',
            'url' => 'required|string|unique:restaurants',
            'phone' => 'required',
            'address' => 'required',
            'client_id' => 'required',
            'pic' => 'nullable|file|mimes:jpeg,jpg,png,gif,svg|max:500'
        ], [
            'name.required'=>'Please enter name!',
            'url.required'=>'Please enter url!',
            'phone.required'=>'Please enter phone number!',
            'address.required'=>'Please enter address!',
            'client_id.required'=>'Please enter a client!',
            'pic.required' => 'Max image size is 500kb'
        ]);

        $client = Client::where('id', $request->client_id)->first();
        $limit = $client->packageInfo->no_of_rstrt;
        $alreadyAdded = $client->restaurantInfo->count();
        if($alreadyAdded < $limit) {
            if($request->hasFile('pic')){
                $image=$request->file('pic');
                $imageName='logos_'.rand().'_'.time().'.'.$image->getClientOriginalExtension();
                Image::make($image)->save(base_path('public/uploads/logos/'.$imageName));
            } else {
                $imageName = 'logo.png';
            }
            $request->request->add(['logo' => $imageName]);
            $request->merge(['slug' => 'restaurant'.rand().time()]);
            $request->merge(['url' => str_slug($request->url)]);

            $create = Restaurant::create($request->all());

            if($create){
                Session::flash('success','value');
                return redirect()->back();
            }else{
                Session::flash('error','value');
                return redirect()->back();;
            }
        } else {
            Session::flash('limit','value');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show(Restaurant $restaurant)
    {
        return view('admin.restaurant.view', compact('restaurant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function edit(Restaurant $restaurant)
    {
        $clients = Client::get();
        return view('admin.restaurant.edit', compact('restaurant', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $this->validate($request, [
            'name' => 'required|string|max:180',
            'url' => 'required|string|unique:restaurants,url,'.$restaurant->id,
            'phone' => 'required',
            'address' => 'required',
            'client_id' => 'required',
            'pic' => 'nullable|file|mimes:jpeg,jpg,png,gif,svg|max:500'
        ], [
            'name.required'=>'Please enter name!',
            'url.required'=>'Please enter url!',
            'phone.required'=>'Please enter phone number!',
            'address.required'=>'Please enter address!',
            'client_id.required'=>'Please enter a client!',
            'pic.required' => 'Max image size is 500kb'
        ]);

        if($request->hasFile('pic')){
            $image=$request->file('pic');
            $imageName='logos_'.rand().'_'.time().'.'.$image->getClientOriginalExtension();
            Image::make($image)->save(base_path('public/uploads/logos/'.$imageName));
            $oldPhoto = public_path()."/uploads/logos/".$restaurant->logo;
            if(file_exists($oldPhoto)){
                unlink($oldPhoto);
            }
        } else {
            $imageName = $restaurant->logo;
        }
        $request->request->add(['logo' => $imageName]);
        $request->merge(['url' => str_slug($request->url)]);


        $update = $restaurant->update($request->all());

        if($update){
            Session::flash('success','value');
            return redirect()->back();
        }else{
            Session::flash('error','value');
            return redirect()->back();;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant)
    {
        $delete = $restaurant->delete();
        if($delete){
            Session::flash('success','value');
            return redirect()->back();
        }else{
            Session::flash('error','value');
            return redirect()->back();;
        }
    }

    public function addCate(Request $request, $slug)
    {
        $this->validate($request, [
            'name'=>'required|string'
        ]);

        $restaurant = Restaurant::where('slug', $slug)->first();
        if(!empty($restaurant)) {
            $request->request->add(['rstrt_slug' => $restaurant->slug]);
            Category::create($request->all());
            $category = Category::orderBy('id', 'DESC')->first();
        } else {
            $category = null;
        }
        return $category;
    }

    public function editCate($id)
    {
        $category = Category::findOrFail($id);
        return $category;
    }

    public function updateCate(Request $request, $id)
    {
        $this->validate($request, [
            'name'=>'required|string'
        ]);

        $request->merge(['status' => (boolean)$request->status]);
        Category::where('id', $id)->first()->update($request->all());
        $category = Category::where('id', $id)->first();

        return $category;
    }

    public function setting(Request $request,$slug)
    {
        $this->validate($request, [
            'menu_heading' => 'required',
            'menu_theme' => 'required',
            'menu_image_display' => 'required',
            'menu_categorised' => 'required',
            'takeaway_switch' => 'required',
            'currency_symbol' => 'required|string|max:10',
            'table_option' => 'required',
            'vat' => 'required',
            'invoice' => 'required',
            'payment_way' => 'required'
        ]);
        $restaurant =  Restaurant::where('slug', $slug)->first();

        if(Auth::user()->role_id == 2 || (Auth::user()->role_id == 3 && $restaurant->trusted_manager == 1)) {
            $discount = $request->discount;
        } else  {
            $discount = $restaurant->discount;
        }

        $restaurant->menu_image_display = (boolean)$request->menu_image_display;
        $restaurant->menu_theme = $request->menu_theme;
        $restaurant->menu_heading = $request->menu_heading;
        $restaurant->menu_categorised = $request->menu_categorised;
        $restaurant->takeaway_switch = (boolean)$request->takeaway_switch;
        $restaurant->currency_symbol = $request->currency_symbol;
        $restaurant->table_option = (boolean)$request->table_option;
        $restaurant->trusted_manager = (boolean)$request->trusted_manager;
        $restaurant->vat = $request->vat;
        $restaurant->vat_status = $request->vat_status;
        $restaurant->discount = $discount;
        $restaurant->invoice = $request->invoice;
        $restaurant->payment_way = $request->payment_way;
        $restaurant->save();
    }

    public function qrcode($rstrt_slug){
        $restaurant = Restaurant::where('slug', $rstrt_slug)->first();
        return view('front-end.layout'.$restaurant->menu_theme.'.qrcode', compact('restaurant'));
    }

    public function subscription(){
        return view('auth.subscription');
    }

    public function error404(){
        return view('errors.404');
    }
}
