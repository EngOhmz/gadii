<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\SystemModule;

class BranchController extends Controller
{  
    public function __construct()
    {
       
        
    }
    public function index()
    {  
        $permissions = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
        return view('manage.branch.index', compact('permissions'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $role = Branch::create([
            'name' => $request->name,
            'added_by' => auth()->user()->added_by
        ]);
        return redirect(route('branch.index'))->with(['success'=>'Created Successfully']);
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
        $role = Branch::find($request->id);
        $role->name = $request->name;
        $role->added_by = auth()->user()->added_by;
        $role->update();
        return redirect(route('branch.index'))->with(['success'=>'Updated Successfully']);
    }

    public function destroy($id)
    {
        $role = Branch::find($id);
        $role->update(['disabled' => '1']);
        return redirect(route('branch.index'))->with(['success'=>'Deleted Successfully']);
    }
}
