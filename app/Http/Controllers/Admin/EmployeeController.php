<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Restaurant;
use App\UserRole;
use App\User;
use App\Employee;
use Session;
use Image;
use Hash;

class EmployeeController extends Controller
{
    public function index($slug)
    {
    	$restaurant = Restaurant::where('slug', $slug)->first();
        $client = $restaurant->clientInfo;
        $limit  = $client->packageInfo->no_of_emp;
        $added = 0;
        foreach ($client->restaurantInfo as $rstrt) {
            $added += $rstrt->employeeInfo->count();
        }
        if($limit > $added) {
            $canAddMore = true;
        } else {
            $canAddMore = false;
        }
    	return view('admin.restaurant.employee.all', compact('restaurant', 'canAddMore'));
    }

    public function create($slug)
    {
    	$restaurant = Restaurant::where('slug', $slug)->first();
    	$roles = UserRole::where('role_type', 2)->get();
    	return view('admin.restaurant.employee.add', compact('restaurant', 'roles'));
    }

    public function store(Request $request, $slug)
    {
    	$restaurant = Restaurant::where('slug', $slug)->first();
    	$this->validate($request, [
    		'name' => 'required|string|max:50',
    		'email' => 'required|email|max:100|unique:users',
    		'password' => 'required|string|min:8|confirmed',
    		'phone' => 'required|string|max:20',
    		'address' => 'required|string',
    		'pic' => 'image|mimes:jpg,png,jpeg',
    		'role_id' => 'required'
    	]);

        $client = $restaurant->clientInfo;
        $limit  = $client->packageInfo->no_of_emp;
        $added = 0;
        foreach ($client->restaurantInfo as $rstrt) {
            $added += $rstrt->employeeInfo->count();
        }
        if($limit > $added) {
            if($request->hasFile('pic')){
                $image=$request->file('pic');
                $imageName='employee_'.$request->name.'_'.rand().time().'.'.$image->getClientOriginalExtension();
                Image::make($image)->save(base_path('public/uploads/users/'.$imageName));
            } else {
                $imageName = 'avatar.jpg';
            }

            $request->request->add(['photo' => $imageName]);
            $request->merge(['password' => Hash::make($request->password)]);

            $user = User::create($request->all());

            $employee = new Employee();
            $employee->address = $request->address;
            $employee->user_id = $user->id;
            $employee->rstrt_slug = $slug;
            $create = $employee->save();

            if($create){
                Session::flash('employeeSuccess','New Employee Added');
            }else{
                Session::flash('error','Something Went Wrong');
            }
        } else {
            Session::flash('limit','Limit is over');
        }
    	return view('admin.restaurant.employee.all', compact('restaurant'));
    }

    public function edit($id)
    {
    	$employee = Employee::findOrFail($id);
    	$roles = UserRole::where('role_type', 2)->get();
    	return view('admin.restaurant.employee.edit', compact('employee', 'roles'));
    }

    public function update(Request $request, $id)
    {
    	$employee = Employee::findOrFail($id);
    	$restaurant = $employee->restaurantInfo;
    	$user = $employee->userInfo;
    	$this->validate($request, [
    		'name' => 'required|string|max:50',
    		'email' => 'required|email|max:100|unique:users,email,'.$user->id,
    		'password' => 'nullable|string|min:8|confirmed',
    		'phone' => 'required|string|max:20',
    		'address' => 'required|string',
    		'pic' => 'image|mimes:jpg,png,jpeg',
    		'role_id' => 'required'
    	]);

    	if($request->hasFile('pic')){
    	    $image=$request->file('pic');
    	    $imageName='employee_'.$request->name.'_'.rand().time().'.'.$image->getClientOriginalExtension();
    	    Image::make($image)->save(base_path('public/uploads/users/'.$imageName));
    	    $oldPhoto = public_path()."/uploads/users/".$user->photo;
    	    if(file_exists($oldPhoto)){
    	        unlink($oldPhoto);
    	    }
    	} else {
    	    $imageName = $user->photo;
    	}
    	$request->request->add(['photo' => $imageName]);
    	if(!empty($request->password)) {
            $password = Hash::make($request->password);
        }else{
        	$password = $user->password;
        }
        $request->merge(['password' => $password]);
        $user->update($request->all());
        $update = $employee->update($request->all());

        if($update){
    	    Session::flash('employeeSuccess','Employee Successfully Updated');
    	}else{
    	    Session::flash('error','Something Went Wrong');
    	}
		return view('admin.restaurant.employee.all', compact('restaurant'));
    }

    public function destroy($id)
    {
    	$employee = Employee::findOrFail($id);
    	$restaurant = $employee->restaurantInfo;
    	$user = $employee->userInfo;
    	$employee->delete();
    	if($user->photo) {
    		$oldPhoto = public_path()."/uploads/users/".$user->photo;
    		if(file_exists($oldPhoto)){
    		    unlink($oldPhoto);
    		}
    	}
    	$user->forceDelete();
    	return view('admin.restaurant.employee.all', compact('restaurant'));
    }

    public function inactivate($id)
    {
    	$employee = Employee::findOrFail($id);
    	$restaurant = $employee->restaurantInfo;
    	$user = $employee->userInfo;
    	$user->status = 0;
    	$user->save();
    	return view('admin.restaurant.employee.all', compact('restaurant'));
    }

    public function activate($id)
    {
    	$employee = Employee::findOrFail($id);
    	$restaurant = $employee->restaurantInfo;
    	$user = $employee->userInfo;
    	$user->status = 1;
    	$user->save();
    	return view('admin.restaurant.employee.all', compact('restaurant'));
    }
}
