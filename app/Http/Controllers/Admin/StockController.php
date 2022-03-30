<?php

namespace App\Http\Controllers\Admin;

use Image;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Size;
use App\Models\Brand;
use App\Models\Stock;
use App\Models\StockCat;
use App\Models\Thickness;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class StockController extends Controller
{

    public function getBrand($id)
    {
        $data = Brand::where('BranStatus', true)->where('CateId', $id)->orderBy('BranName', 'DESC')->get();
        return response()->json($data);
    }

    public function getSize($id)
    {
        $data = Size::where('SizeStatus', true)->where('BranId', $id)->orderBy('SizeName', 'DESC')->get();
        return response()->json($data);
    }

    public function getThick($id)
    {
        $data = Thickness::where('ThicStatus', true)->where('SizeId', $id)->orderBy('ThicName', 'DESC')->get();
        return response()->json($data);
    }

    public function getAll()
    {
        return $allStock = Stock::with('cateInfo', 'brandInfo', 'sizeInfo', 'thickInfo')->orderBy('StocId', 'DESC')->get();
    }

    public function add()
    {
        $allStock = $this->getAll();
        $CateOBJ = new CategoryController();
        $allCate = $CateOBJ->getAll();

        return view('admin.stock.add', compact('allStock', 'allCate'));
    }

    public function edit($id)
    {
        $allStock = $this->getAll();
        $CateOBJ = new CategoryController();
        $allCate = $CateOBJ->getAll();

        $data = $allStock->where('StocId', $id)->firstOrFail();
        return view('admin.stock.add', compact('data', 'allCate', 'allStock'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'StocValue' => 'required|max:30',
            'CategoryID' => 'required',
            'BranID' => 'required',
            'SizeID' => 'required',
            'menu_id' => 'required',
        ], [
            'StocValue.required' => 'please enter stock amount',
            'CategoryID.required' => 'please select category name',
            'BranID.required' => 'please select brand name',
            'SizeID.required' => 'please select size',
            'StocValue.max' => 'max stock amount content is 30 number',
        ]);

        $Stock = Stock::where('CateId', $request->CategoryID)->where('BranId', $request->BranID)->where('SizeId', $request->SizeID)
                ->where('ThicId', $request->ThicID)->where('menu_id', $request->menu_id)->first();

        if ($Stock == NULL) {

            $insert = Stock::insertGetId([
                'CateId' => $request['CategoryID'],
                'BranId' => $request['BranID'],
                'SizeId' => $request['SizeID'],
                'StocValue' => $request['StocValue'],
                'menu_id' => $request['menu_id'],
                'created_at' => Carbon::now('Asia/Dhaka')->toDateTimeString(),
            ]);

            if ($insert) {
                Session::flash('success', 'new stock amount store Successfully.');
                return redirect()->route('stock.add');
            } else {
                Session::flash('error', 'please try again.');
                return redirect()->back();
            }
        } else {

            // Session::flash('error', 'This Product Already Exist.');
            // return redirect()->back();

            $id= $Stock->StocId;
            $totalStock= $Stock->StocValue+$request->StocValue;
            $sameUpdate = Stock::where('StocId',$id)->update([
                'StocValue'=>$totalStock,
            ]);
            if($sameUpdate){
                Session::flash('success','stock amount update Successfully');
                    return redirect()->route('stock.add');
            }else{
                Session::flash('error','please try again.');
                    return redirect()->back();
            } 


        }
    }


    public function update(Request $request)
    {
        $id = $request->StocId;

        $this->validate($request, [
            'StocValue' => 'required|max:30',
            'CategoryID' => 'required',
            'BranID' => 'required',
            'SizeID' => 'required',
        ], [
            'StocValue.required' => 'please enter stock amount',
            'CateId.required' => 'please select category name',
            'BranId.required' => 'please select brand name',
            'SizeId.required' => 'please select size',
            'StocValue.max' => 'max stock amount content is 30 number',
        ]);


        $update = Stock::where('StocId', $id)->update([
            'CateId' => $request['CategoryID'],
            'BranId' => $request['BranID'],
            'SizeId' => $request['SizeID'],
            'StocValue' => $request['StocValue'],
            'menu_id' => $request['menu_id'],
            'updated_at' => Carbon::now('Asia/Dhaka')->toDateTimeString(),
        ]);
        if ($update) {
            Session::flash('success', 'stock amount update Successfully.');
            return redirect()->route('stock.add');
        } else {
            Session::flash('error', 'please try again.');
            return redirect()->back();
        }
    }

    // Database Operation Methods

   
}
