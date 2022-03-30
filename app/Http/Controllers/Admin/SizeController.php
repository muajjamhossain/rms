<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;
use App\Models\StockCat;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Admin\CategoryController;
use Carbon\Carbon;
use Session;
use Image;


class SizeController extends Controller{
    /*
    |--------------------------------------------------------------------------
    | DATABASE OPERATION
    |--------------------------------------------------------------------------
    */
    // ajax Method
    public function brandWiseSize(Request $request){
      $getSize = Size::where('BranId',$request->BranId)->get();
      return json_encode($getSize);
    }
    // ajax Method



      public function getAll(){
       return $allSize = Size::with('cateInfo','brandInfo')->where('SizeStatus',true)->orderBy('SizeId','DESC')->get();
    }
    /*
    |--------------------------------------------------------------------------
    | BLADE OPERATION
    |--------------------------------------------------------------------------
    */

    public function add(){
       $allSize = $this->getAll();
       $CategoryOBJ = new CategoryController();
        $allCate = $CategoryOBJ->getAll();
       return view('admin.size.add', compact('allSize', 'allCate'));
    }

    public function edit($id){
        $allSize = $this->getAll();
        $data = $allSize->where('SizeId',$id)->firstOrFail();
        $CategoryOBJ = new CategoryController();
        $allCate = $CategoryOBJ->getAll();
        return view('admin.size.add', compact('data', 'allSize', 'allCate'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'SizeName'=>'required|max:150',
            'BranID'=>'required',
            'CategoryID'=>'required',
        ],[
            'SizeName.required'=> 'please enter size name',
            'BranID.required'=> 'please select brand name',
            'SizeName.max'=> 'max size name content is 150 character',
        ]);

        $SizeName=strtolower($request->SizeName);
        $sizes = Size::where('CateId',$request->CategoryID)->where('BranId',$request->BranID)->where('SizeName',$SizeName)->count();

        if($sizes>0){

            Session::flash('error','this size allready exit, please another size.');
                return redirect()->back();
        }else{
           $insert = Size::insertGetId([
            'CateId'=>$request['CategoryID'],
            'BranId'=>$request['BranID'],
            'SizeName'=>$SizeName,
            'created_at'=>Carbon::now('Asia/Dhaka')->toDateTimeString(),
        ]);

        if($insert){
            Session::flash('success','new size store Successfully.');
                return redirect()->route('size.add');
            }else{
                Session::flash('error','please try again.');
                    return redirect()->back();
            } 
        }
        

    }


    public function update(Request $request){
        $id= $request->SizeId;
        $this->validate($request,[
            'SizeName'=>'required|max:150|unique:sizes,SizeName,'.$id.',SizeId',
            'BranId'=>'required',
            'CateId'=>'required',
        ],[
            'SizeName.required'=> 'please enter size name',
            'CateId.required'=> 'please select category name',
            'BranId.required'=> 'please select brand name',
            'SizeName.max'=> 'max size name content is 150 character',
            'SizeName.unique' => 'this size name already exists! please another name',
        ]);

        $insert = Size::where('SizeStatus',true)->where('SizeId',$id)->update([
            'CateId'=>$request['CateId'],
            'BranId'=>$request['BranId'],
            'SizeName'=>$request['SizeName'],
            'updated_at'=>Carbon::now('Asia/Dhaka')->toDateTimeString(),
        ]);

        if($insert){
            Session::flash('success','size update Successfully.');
                return redirect()->route('size.add');
        }else{
            Session::flash('error','please try again.');
                return redirect()->back();
        }

    }

}
