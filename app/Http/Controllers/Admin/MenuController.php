<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\StockController;
use App\Menu;
use App\Models\Stock;
use App\Restaurant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class MenuController extends Controller
{
    public function index($slug)
    {
    	$restaurant = Restaurant::where('slug', $slug)->first();
    	return view('admin.restaurant.menu.all', compact('restaurant'));
    }

    public function create($slug)
    {
    	$restaurant = Restaurant::where('slug', $slug)->first();
    	return view('admin.restaurant.menu.add', compact('restaurant'));
    }

    public function createStock($slug)
    {
    	$restaurant = Restaurant::where('slug', $slug)->first();
    	return view('admin.restaurant.menu.stock', compact('restaurant'));
    }

    public function store(Request $request, $slug)
    {
		// dd($request->all());
		// dd($request->size) ?? 'nai';
	  
    	$this->validate($request, [
    		'name' => 'required',
    		'price' => 'required',
    		'pic' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048'
    	]);

    	if($request->hasFile('pic')){
    	    $image = $request->file('pic');
    	    $imageName='food_'.rand().'_'.time().'.'.$image->getClientOriginalExtension();
    	    Image::make($image)->save(base_path('public/uploads/foods/'.$imageName));
    	} else {
    	    $imageName = 'avatar.jpg';
    	}

    	$request->request->add(['photo' => $imageName]);
    	$request->request->add(['rstrt_slug' => $slug]);
        $request->merge(['dining_service' => (boolean)$request->dining_service]);
        $request->merge(['takeaway_service' => (boolean)$request->takeaway_service]);

		$data = $request->all();

		$data['size'] = 0;
		$data['addons'] = 0;
		$data['crust'] = 0;
		
		if($request->addons != null){
			// dd($request->addons);
			$data['addons'] = 1;
		}

		if($request->crust != null){
			// dd($request->addons);
			$data['crust'] = 1;
		}

		if($request->size !=null){

			$data['size'] = $request->size;
		}

		if($request->cate_id == '' || $request->cate_id == null){
			$data['cate_id'] = 25;
		}


        $create = Menu::create($data);
    	$restaurant = Restaurant::where('slug', $slug)->first();

		if($request->cate_id == '' || $request->cate_id == null){

			// $Stock = Stock::where('CateId', $request->CategoryID)
			// 	   ->where('BranId', $request->BranID)
			// 	   ->where('SizeId', $request->SizeID)
			// 	   ->first();
   
			// 	   if ($Stock == NULL){
   
				    Stock::insert([
					   'menu_id'=> $create->id,
					   'rstrt_slug'=> $slug,
					   'StocValue'=> $request->StocValue,
					   'CateId'=> $request->CategoryID,
					   'BranID'=> $request->BranID,
					   'SizeID'=> $request->SizeID,
					   'created_at' =>Carbon::now()

					]);

					Menu::where('id',$create->id)->update([
						'StocValue' => $request->StocValue,
						'stock_status' => 1,
						'addons' => 0,
					]);

				//    }else{
				// 	   $id= $Stock->StocId;
				// 	   $totalStock= $Stock->StocValue+$request->StocValue;
				// 	   $sameUpdate = Stock::where('StocId',$id)->update([
				// 		   'StocValue'=>$totalStock,
				// 	   ]);
					   
				//    }
		}
		

    	if($create){
    	    Session::flash('menuSuccess','Menu Successfully Added');
    	}else{
    	    Session::flash('error','Something Went Wrong');
        }
    	return view('admin.restaurant.menu.all', compact('restaurant'));
    }

    public function edit($id)
    {
    	$menu = Menu::findOrFail($id);
    	$restaurant = Restaurant::where('slug', $menu->rstrt_slug)->first();
    	return view('admin.restaurant.menu.edit', compact('restaurant', 'menu'));
    }

    public function update(Request $request, $id)
    {
    	$this->validate($request, [
    		'name' => 'required',
    		'price' => 'required',
    		'cate_id' => 'required',
    		'pic' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048'
    	]);
    	$menu = Menu::findOrFail($id);
    	$restaurant = Restaurant::where('slug', $menu->rstrt_slug)->first();

    	if($request->hasFile('pic')){
    	    $image=$request->file('pic');
    	    $imageName='food_'.rand().'_'.time().'.'.$image->getClientOriginalExtension();
    	    Image::make($image)->save(base_path('public/uploads/foods/'.$imageName));
    	    if($menu->photo) {
    	    	$oldPhoto = public_path()."/uploads/foods/".$menu->photo;
    	    	if(file_exists($oldPhoto)){
    	    	    unlink($oldPhoto);
    	    	}
    	    }
    	} else {
    	    $imageName = $menu->photo;
    	}
    	$request->request->add(['photo' => $imageName]);
        $request->merge(['dining_service' => (boolean)$request->dining_service]);
        $request->merge(['takeaway_service' => (boolean)$request->takeaway_service]);

    	$update = $menu->update($request->all());
    	if($update){
    	    Session::flash('menuSuccess','Menu Successfully Updated');
    		return view('admin.restaurant.menu.all', compact('restaurant'));
    	}else{
    	    Session::flash('error','Something Went Wrong');
    		return view('admin.restaurant.menu.all', compact('restaurant'));
    	}
    }

    public function destroy($slug, $id)
    {
    	$menu = Menu::findOrFail($id);
    	if($menu->photo) {
    		$oldPhoto = public_path()."/uploads/foods/".$menu->photo;
    		if(file_exists($oldPhoto)){
    		    unlink($oldPhoto);
    		}
    	}
    	$delete = $menu->delete();
		$restaurant = Restaurant::where('slug', $slug)->first();
		return view('admin.restaurant.menu.all', compact('restaurant'));
    }
}