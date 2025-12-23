<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\SystemModule;

class SystemRoleController extends Controller
{  

    public function index()
    {
        $roles = Role::all()->where('status','1')->where('disabled','0');
        return view('manage.role.price', compact('roles'));
    }

    public function create(Request $request)
    {

      
    }

    public function store(Request $request)
    {
       
        $data=$request->post();
        $data['day'] = str_replace(",","",$request->day);
        $data['month'] = str_replace(",","",$request->month);
        $data['year'] = str_replace(",","",$request->year);
        $data['status'] = '1';
       $data['added_by'] = auth()->user()->added_by;
      
       $role = Role::create($data);
        return redirect(route('system_role.index'))->with(['success'=>'Created Successfully']);
    }

    public function show($id)
    {
       
    }


    public function edit($id)
    {
        //
        
        $data = Role::find($id);
       return view('manage.role.price',compact('data','id'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        $data=$request->post();
         $data['day'] = str_replace(",","",$request->day);
        $data['month'] = str_replace(",","",$request->month);
        $data['year'] = str_replace(",","",$request->year);
        $data['status'] = '1';
      
        $role->update($data);
        
          return redirect(route('system_role.index'))->with(['success'=>'Updated Successfully']);
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        $role->update(['disabled'=> '1']);
         return redirect(route('system_role.index'))->with(['success'=>'Deleted Successfully']);
    }
}
