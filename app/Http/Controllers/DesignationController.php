<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departments;
use App\Models\Designation;
use App\Models\SystemModule;

class DesignationController extends Controller
{  
    public function __construct()
    {
       
        
    }
    public function index()
    {  
        $permissions = Designation::all()->where('disabled','0')->where('added_by',auth()->user()->added_by);
         $department = Departments::all()->where('disabled','0')->where('added_by',auth()->user()->added_by);
        return view('manage.designation.index', compact('permissions','department'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
       
        $role = Designation::create([
            'name' => $request->name,
           'department_id' => $request->department_id,
           'added_by' => auth()->user()->added_by,
        ]);
        return redirect(route('designations.index'));
    }

    public function show(Permission $permission)
    {
        //
    }

    public function edit(Request $request)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $role = Designation::find($request->id);
        $role->name = $request->name;
        $role->department_id = $request->department_id;
        $role->update();
        return redirect(route('designations.index'));
    }

    public function destroy($id)
    {
        $role = Designation::find($id);
        $role->update(['disabled' => '1']);
        return redirect(route('designations.index'));
    }
}
