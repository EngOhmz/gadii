<?php

namespace App\Http\Controllers\Cotton;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Cotton\Levy;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\GroupAccount;
use App\Models\ClassAccount;
use App\Models\AccountCodes;

class DistrictController  extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
   {
       //
       $operator = District::all();   
       $region = Region::all();
       return view('cotton.district',compact('operator','region'));
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
       if($request->levy_status == '1'){
          $levy=Levy::where('required','0')->first();
      $data['levy_id']=$levy->id;
       }
      $data['added_by']=auth()->user()->id;
      $operator= District::create($data);


    

      return redirect(route('district.index'))->with(['success'=>' Created Successfully']);
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
       $data =  District::find($id);
         $region = Region::all();
       return view('cotton.district',compact('data','id','region'));

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
       $operator =District::find($id);
       $data=$request->post();
         if($request->levy_status == '1'){
          $levy=Levy::where('required','0')->first();
      $data['levy_id']=$levy->id;
       }
       $operator->update($data);

        
 


       return redirect(route('district.index'))->with(['success'=>' Updated Successfully']);
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
         
       $operator = District::find($id);
       $operator->delete();

       return redirect(route('district.index'))->with(['success'=>' Deleted Successfully']);
   }
}
