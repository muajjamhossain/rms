<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\UserRole;
use Carbon\Carbon;
use Session;
use Image;
class UserController extends Controller{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('superadmin');
    }

    public function index(){
        $all=User::where('status',1)->orderBy('id','DESC')->get();
        return view('admin.user.all',compact('all'));
    }

    public function add(){
        $allRole=UserRole::where('role_status',1)->orderBy('role_id','ASC')->get();
        return view('admin.user.add',compact('allRole'));
    }

    public function edit($user){
        $allRole=UserRole::where('role_status',1)->orderBy('role_id','ASC')->get();
        $data=User::where('status',1)->where('id',$user)->firstOrFail();
        return view('admin.user.edit',compact('data','allRole'));
    }

    public function view($id){
        $data=User::where('status',1)->where('id',$id)->firstOrFail();
        return view('admin.user.view',compact('data'));
    }

    public function insert(Request $request){
        $this->validate($request,[
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string|min:8|confirmed',
            'role'=>'required',
        ],[
            'name.required'=>'Please enter name!',
            'email.required'=>'Please enter email address!',
            'password.required'=>'Please enter password!',
            'role.required'=>'Please select user role!',
        ]);

        $insert=User::insertGetId([
            'name'=>$request['name'],
            'phone'=>$request['phone'],
            'email'=>$request['email'],
            'password' => Hash::make($request['password']),
            'photo'=>'',
            'role_id'=>$request['role'],
            'created_at'=>Carbon::now()->toDateTimeString(),
        ]);

        if($request->hasFile('pic')){
            $image=$request->file('pic');
            $imageName='user_'.$insert.'_'.time().'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(250,250)->save(base_path('public/uploads/users/'.$imageName));

            User::where('id',$insert)->update([
                'photo'=>$imageName,
                'updated_at'=>Carbon::now()->toDateTimeString(),
            ]);
        }
        if($insert){
            Session::flash('success','value');
            return redirect('dashboard/user/add');
        }else{
            Session::flash('error','value');
            return redirect('dashboard/user/add');
        }
    }

    public function update(Request $request){
        $this->validate($request,[
            'name'=>'required|string|max:255',
            'role'=>'required',
        ],[
            'name.required'=>'Please enter name!',
            'role.required'=>'Please select user role!',
        ]);

        $user=$request['user'];
        $id=$request['id'];
        $update=User::where('status',1)->where('id',$id)->update([
            'name'=>$request['name'],
            'phone'=>$request['phone'],
            'role_id'=>$request['role'],
            'created_at'=>Carbon::now()->toDateTimeString(),
        ]);

        if($request->hasFile('pic')){
            $image=$request->file('pic');
            $imageName='user_'.$id.'_'.time().'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(250,250)->save(base_path('public/uploads/users/'.$imageName));

            User::where('id',$id)->update([
                'photo'=>$imageName,
                'updated_at'=>Carbon::now()->toDateTimeString(),
            ]);
        }

        if($update){
            Session::flash('success','value');
            return redirect('dashboard/user/view/'.$id);
        }else{
            Session::flash('error','value');
            return redirect('dashboard/user/edit/'.$id);
        }
    }

    public function softdelete(){
        $id=$_POST['modal_id'];
        $soft=User::where('status',1)->where('id',$id)->update([
            'status'=>0,
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);

        if($soft){
            Session::flash('success_soft','value');
            return redirect('dashboard/user');
        }else{
          Session::flash('error','value');
          return redirect('dashboard/user');
        }
    }

    public function restore(){
        $id=$_POST['modal_id'];
        $restore=User::where('status',0)->where('id',$id)->update([
            'status'=>1,
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);

        if($restore){
            Session::flash('restore','value');
            return redirect('dashboard/recycle/user');
        }else{
          Session::flash('error','value');
          return redirect('dashboard/recycle/user');
        }
    }

    public function delete(){
        $id=$_POST['modal_id'];
        $del=User::where('status',0)->where('id',$id)->delete();
        if($del){
            Session::flash('delete','value');
            return redirect('dashboard/recycle/user');
        }else{
          Session::flash('error','value');
          return redirect('dashboard/recycle/user');
        }
    }
}
