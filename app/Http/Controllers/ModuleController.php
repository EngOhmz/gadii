<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SystemModule;
use App\Models\Permission;
use Illuminate\Http\Request;

class ModuleController  extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
   {
       //
       $module = SystemModule::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();     
       return view('manage.module.data',compact('module'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
       //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
       //

      $data=$request->post();
      $data['added_by'] = auth()->user()->added_by;
      $module = SystemModule::create($data);
      
      $role = Permission::create([
            'slug' => $request->slug ."-menu",
            'sys_module_id' => $module->id,
             'name' => $request->name ." Menu",
             'hidden' => '1',
        ]);


      return redirect(route('system_module.index'))->with(['success'=>'Created Successfully']);
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
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
       $data =  SystemModule::find($id);
       return view('manage.module.data',compact('data','id'));

   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id)
   {
       //
       $module = SystemModule::find($id);
       $data=$request->post();
      $data['added_by'] = auth()->user()->added_by;
       $module->update($data);

         $role = Permission::where('sys_module_id',$id)->where('hidden',1)->update([
            'slug' => $request->slug ."-menu",
            'sys_module_id' => $module->id,
             'name' => $request->name ." Menu",
             'hidden' => '1',
        ]);

         
       return redirect(route('system_module.index'))->with(['success'=>'Updated Successfully']);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
       //

       $module = SystemModule::find($id);
 
       $module->update(['disabled'=> '1']);;

       return redirect(route('system_module.index'))->with(['success'=>'Deleted Successfully']);
   }
}
