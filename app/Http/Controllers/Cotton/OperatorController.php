<?php

namespace App\Http\Controllers\Cotton;

use App\Http\Controllers\Controller;
use App\Models\Cotton\Operator;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use App\Models\GroupAccount;
use App\Models\ClassAccount;
use App\Models\AccountCodes;

class OperatorController  extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
   {
       //
       $operator = Operator::all();   
       $banks = AccountCodes::all();
       return view('cotton.operator',compact('operator','banks'));
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
      $data['user_id']=auth()->user()->id;
      $operator= Operator::create($data);


    

      return redirect(route('operator.index'))->with(['success'=>'Operator Created Successfully']);
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
       $data =  Operator::find($id);
       return view('cotton.operator',compact('data','id'));

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
       $operator =Operator::find($id);
       $data=$request->post();
       $data['user_id']=auth()->user()->id;
       $operator->update($data);


 


       return redirect(route('operator.index'))->with(['success'=>'Operator Updated Successfully']);
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
         
       $operator = Operator::find($id);
       $operator->delete();

       return redirect(route('operator.index'))->with(['success'=>'Operator Deleted Successfully']);
   }
}
