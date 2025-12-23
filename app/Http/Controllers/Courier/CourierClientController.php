<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use App\Models\Courier\CourierClient;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class CourierClientController  extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
   {
       //
       $client = CourierClient::where('user_id',auth()->user()->added_by)->get();     
       return view('courier.client',compact('client'));
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
       //added_by

      $data=$request->post();
      $data['user_id']=auth()->user()->added_by;
      $data['added_by']=auth()->user()->added_by;
      $client = CourierClient::create($data);

/*
  $user = User::create([
            'name' => $request['name'],          
            'email' => $request['email'],
            'address' => $request['address'],
            'password' => Hash::make(11223344),
            'phone' => $request['phone'],
            'client_id'=>$client->id,
            'added_by' => auth()->user()->added_by,
            'status' => 1,
       'department_id' => 0,
        'designation_id' => 0,
        'joining_date' => 0,
        ]);
        
        $user->roles()->detach();
        $role_id = Role::where('slug','CLIENT')->first();
        $user->roles()->attach($role_id->id);
      
       
*/
      return redirect(route('courier_client.index'))->with(['success'=>'Client Created Successfully']);
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
       $data =  CourierClient::find($id);
       return view('courier.client',compact('data','id'));

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
       $client = CourierClient::find($id);
       $data=$request->post();
       $data['user_id']=auth()->user()->added_by;
       $client->update($data);

/*
        $user = User::where('client_id',$id)->update([
            'name' => $request['name'],          
            'email' => $request['email'],
            'address' => $request['address'],
            'phone' => $request['phone'],
        ]);
*/        
       return redirect(route('courier_client.index'))->with(['success'=>'Client Updated Successfully']);
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

       $client = CourierClient::find($id);
       $client->delete();

       return redirect(route('courier_client.index'))->with(['success'=>'Client Deleted Successfully']);
   }
}
