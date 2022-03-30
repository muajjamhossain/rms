<?php

namespace App\Http\Controllers\Admin;

use App\Client;
use App\User;
use App\Package;
use App\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Session;
use Image;
use Hash;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = Client::get();
        return view('admin.client.all', compact('all'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packages = Package::where('status', 1)->get();
        return view('admin.client.add', compact('packages'));
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
            'email' => 'required|string|email|max:180|unique:users',
            'password'=>'required|string|min:8|confirmed',
            'company_name' => 'required|string|max:180',
            'phone' => 'required',
            'address' => 'required',
            'package_id' => 'required',
            'pic' => 'nullable|file|mimes:jpeg,jpg,png,gif,svg|max:500'
        ], [
            'name.required'=>'Please enter name!',
            'email.required'=>'Please enter email address!',
            'password.required'=>'Please enter password!',
            'company_name.required'=>'Please enter company name!',
            'phone.required'=>'Please enter phone number!',
            'address.required'=>'Please enter address!',
            'package_id.required'=>'Please enter how many restaurants this client can add!',
            'pic.required' => 'Max image size is 500kb'
        ]);

        if($request->hasFile('pic')){
            $image=$request->file('pic');
            $imageName='client_'.rand().'_'.time().'.'.$image->getClientOriginalExtension();
            Image::make($image)->save(base_path('public/uploads/users/'.$imageName));
        } else {
            $imageName = 'avatar.jpg';
        }
        $request->request->add(['photo' => $imageName]);
        $request->request->add(['package_at' => Carbon::now()]);
        $request->request->add(['role_id' => 2]);
        $request->merge(['password' => Hash::make($request->password)]);

        $userCreate=User::create($request->all());
        $clientCreate = Client::create($request->all());

        $payment = new Payment();
        $payment->client_id = $clientCreate->id;
        $payment->package_id = $clientCreate->package_id;
        $payment->discount = $request->discount;
        $payment->amount = $clientCreate->PackageInfo->price - $payment->discount;
        $payment->save();

        if($userCreate){
            Session::flash('success','value');
            return redirect()->back();
        }else{
            Session::flash('error','value');
            return redirect()->back();;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return view('admin.client.view', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('admin.client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $user = User::where('email', $client->email)->first();
        $this->validate($request, [
            'name' => 'required|string|max:180',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:8|confirmed',
            'company_name' => 'required|string|max:180',
            'phone' => 'required',
            'address' => 'required',
            'package_id' => 'required',
            'photo' => 'nullable|file|mimes:jpeg,jpg,png,gif,svg|max:500'
        ], [
            'name.required'=>'Please enter name!',
            'email.required'=>'Please enter email address!',
            'company_name.required'=>'Please enter company name!',
            'phone.required'=>'Please enter phone number!',
            'address.required'=>'Please enter address!',
            'package_id.required'=>'Please enter how many restaurants this client can add!',
            'photo.max' => 'Max image size is 500kb'
        ]);

        if($client->package_id != $request->package_id) {
            $request->request->add(['package_at' => Carbon::now()]);
        }

        if($request->hasFile('pic')){
            $image=$request->file('pic');
            $imageName='client_'.rand().'_'.time().'.'.$image->getClientOriginalExtension();
            Image::make($image)->save(base_path('public/uploads/users/'.$imageName));
            $oldPhoto = public_path()."/uploads/users/".$client->photo;
            if(file_exists($oldPhoto)){
                unlink($oldPhoto);
            }
        } else {
            $imageName = $client->photo;
        }
        $request->request->add(['photo' => $imageName]);

        $user->name = $request->name;
        $user->email = $request->email;
        if(!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->photo = $imageName;
        $user->phone = $request->phone;
        $user->status = (boolean)$request->status;
        $update = $user->save();
        $client->update($request->all());

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
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        foreach($client->restaurantInfo as $restaurant) {
            $restaurant->delete();
        }

        $delete = $client->delete();

        if($delete){
            Session::flash('success','value');
            return redirect()->back();
        }else{
            Session::flash('error','value');
            return redirect()->back();
        }
    }

    public function editPackage($id)
    {   
        $client = Client::find($id);
        $packages = Package::where('status', 1)->get();
        return view('admin.client.edit-package', compact('client', 'packages'));
    }

    public function updatePackage(Request $request, $id)
    {
        $client = Client::find($id);
        $newPackage = Package::find($request->package_id);
        $rstrts = $client->restaurantInfo;
        $cur_emps = 0;
        foreach ($rstrts as $rstrt) {
            $cur_emps += $rstrt->employeeInfo->count();
        }
        $cur_rstrt = $rstrts->count();

        if($cur_rstrt <= $newPackage->no_of_rstrt && $cur_emps <= $newPackage->no_of_emp) {
            $client->package_id = $request->package_id;
            $client->package_at = Carbon::now();
            $client->save();

            $payment = new Payment();
            $payment->client_id = $client->id;
            $payment->package_id = $client->package_id;
            $payment->discount = $request->discount;
            $payment->amount = $client->PackageInfo->price - $payment->discount;
            $update = $payment->save();

            if($update){
                Session::flash('success','value');
            }else{
                Session::flash('error','value');
            }
        } else {
            Session::flash('limit','value');
        }
        return redirect()->back();
        
    }
}
