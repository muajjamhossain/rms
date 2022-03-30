<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecycleController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('admin.recycle.index');
    }

    public function user(){
        return view('admin.recycle.user');
    }

}
