<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Session;
use Image;
use Auth;
use Hash;

class ProfileController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('admin.profile.home');
    }

    public function settings()
    {
    	$user = User::find(Auth::user()->id);
    	return view('admin.profile.edit', compact('user'));
    }

    public function profileSetting(Request $request, $id)
    {
    	$user = User::find($id);
    	if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
			$this->validate($request,[
				'name' => 'required|string',
				'email' => 'required|email|unique:users,email,'.$id,
				'password' =>'nullable|min:8|confirmed',
				'phone' => 'required',
		        'photo' => 'nullable|file|mimes:jpeg,jpg,png,gif,svg|max:500'
			],[
				'name.required'=>'Please enter name!',
				'email.required'=>'Please enter email address!',
				'company_name.required'=>'Please enter company name!',
				'phone.required'=>'Please enter phone number!',
				'photo.max' => 'Max image size is 500kb'
			]);
    	} else {
    		$this->validate($request,[
    			'email' => 'required|email|unique:users,email,'.$id,
    			'password' =>'nullable|min:8|confirmed',
    		],[
    			'email.required'=>'Please enter email address!',
    		]);
    	}
    		

    	if((Auth::user()->role_id == 1 || Auth::user()->role_id == 2) && $request->hasFile('pic')){
    	    $image=$request->file('pic');
    	    $imageName='client_'.rand().'_'.time().'.'.$image->getClientOriginalExtension();
    	    Image::make($image)->save(base_path('public/uploads/users/'.$imageName));
    	    $oldPhoto = public_path()."/uploads/users/".$user->photo;
    	    if(file_exists($oldPhoto)){
    	        unlink($oldPhoto);
    	    }
    	} else {
    	    $imageName = $user->photo;
    	}

    	$user->email = $request->email;
    	if(!empty($request->password)) {
    	    $user->password = Hash::make($request->password);
    	}
    	if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
    		$user->name = $request->name;
    		$user->photo = $imageName;
    		$user->phone = $request->phone;
    	}
    	$update = $user->save();

    	if($update){
    	    Session::flash('success','value');
    	    return redirect()->back();
    	}else{
    	    Session::flash('error','value');
    	    return redirect()->back();;
    	}
    }
}
