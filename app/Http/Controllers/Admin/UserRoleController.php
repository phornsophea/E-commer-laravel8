<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRoleController extends Controller
{
    public function index()
    {
        $collection = UserRole::orderBy('serial','ASC')->get();
        return view('admin.user_role.index',compact('collection'));
    }

    public function update(Request $request)
    {
        $user_role = UserRole::find($request->id);
        $user_role->name = $request->name;
        $user_role->serial = $request->serial;
        $user_role->creator = Auth::user()->id;
        $user_role->updated_at = Carbon::now()->toDateTimeString();
        $user_role->save();

        return redirect()->back()->with('success','data updated');
    }

     public function create()
    {
        $user_roles = UserRole::orderBy('serial','DESC')->get();
        return view('admin.user_role.create',compact('user_roles'));
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => ['required'],
            'serial' => ['required'],
            'slug' => ['required'],
            'status' => ['required'],
        ]);

        $userrole = new UserRole();
        $userrole->name = $request->name;
        $userrole->serial = $request->serial;
        $userrole->slug = $request->slug;
        $userrole->status = $request->status;
        $userrole->created_at = Carbon::now()->toDateTimeString();
        // $userrole->creator = Auth::user()->id;
        $userrole->save();
        

        // return $userrole;
         
         // $userrole->slug = $userrole->id.uniqid(10);
        // dd($request->all());
        //function_body
        return redirect('user-role/index')->with('success','data added');
    }
    public function destoy(Request $request){
        $UserRole=UserRole::find($request->id);
        $UserRole->status= 0;
        // $UserRole->create = Auth::UserRole()->id;
        $UserRole->save();

        return redirect('user-role/index')->with('message','Delete Success!');

    }
}
