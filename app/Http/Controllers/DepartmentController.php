<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departments;
use App\Models\SystemModule;

class DepartmentController extends Controller
{  
    public function __construct()
    {
       
        
    }
    public function index()
    {  
        $permissions = Departments::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
        return view('manage.department.index', compact('permissions'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $role = Departments::create([
            'name' => $request->name,
            'added_by' => auth()->user()->added_by
        ]);
        return redirect(route('departments.index'));
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
        $role = Departments::find($request->id);
        $role->name = $request->name;
        $role->added_by = auth()->user()->added_by;
        $role->update();
        return redirect(route('departments.index'));
    }

    public function destroy($id)
    {
        $role = Departments::find($id);
        $role->update(['disabled' => '1']);
        return redirect(route('departments.index'));
    }
    
    public function save_department(Request $request){
       
      //dd($request->all());

       $data = $request->all();   
       $data['added_by'] = auth()->user()->added_by;
        $client = Departments::create($data);
        
      

  if(!empty($client)){
    
            return response()->json($client);
         }

       
   }
   
   
   
    
    
}
