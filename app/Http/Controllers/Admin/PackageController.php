<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Package;
use Illuminate\Http\Request;
use Session;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = Package::get();
        return view('admin.package.all', compact('all'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.package.add');
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
            'name' => 'required|string|max:50|unique:packages',
            'no_of_rstrt' => 'required|numeric',
            'no_of_emp' => 'required|numeric',
            'no_of_months' => 'required|numeric',
            'price' => 'required|numeric',
            'status' => 'required'
        ]);

        $request->merge(['status' => (boolean)$request->status]);
        $create = Package::create($request->all());

        if($create){
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
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        return view('admin.package.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        $this->validate($request, [
            'name' => 'required|string|max:50|unique:packages,name,'.$package->id,
            'no_of_rstrt' => 'required|numeric',
            'no_of_emp' => 'required|numeric',
            'no_of_months' => 'required|numeric',
            'price' => 'required|numeric',
            'status' => 'required'
        ]);

        $request->merge(['status' => (boolean)$request->status]);
        $update = $package->update($request->all());

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
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        //
    }
}
