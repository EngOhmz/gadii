<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fiscal;
use App\Models\SystemModule;

class FiscalController extends Controller
{  
    public function __construct()
    {
       
        
    }
    public function index()
    {  
        $permissions = Fiscal::all()->where('added_by', auth()->user()->added_by);
        return view('manage.fiscal.index', compact('permissions'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $role = Fiscal::create([
            'start' => $request->start,
            'end' => date('Y-m', strtotime("+1 year", strtotime($request->start))) ,
            'added_by' => auth()->user()->added_by
        ]);
        return redirect(route('fiscal_year.index'))->with(['success'=>'Created Successfully']);
    }

    public function show(Permission $permission)
    {
        //
    }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
       $data =  Fiscal::find($id);
       return view('manage.fiscal.index',compact('data','id'));

   }



    public function update(Request $request, $id)
    {
        $role = Fiscal::find($id);
        
        
         $role->update([
            'start' => $request->start,
            'end' => date('Y-m', strtotime("+1 year", strtotime($request->start))) ,
            'added_by' => auth()->user()->added_by
        ]);
        return redirect(route('fiscal_year.index'))->with(['success'=>'Updated Successfully']);
    }

    public function destroy($id)
    {
        $role = Fiscal::find($id);
        
        if($role->status == 0){
        $role->update(['status' => '1']);
        }
        elseif($role->status == 1){
        $role->update(['status' => '0']);
        }
        
        return redirect(route('fiscal_year.index'))->with(['success'=>'Status Changed Successfully']);
    }
}
