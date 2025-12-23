<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Hotel\Client;
use App\Models\Hotel\RoomType;
use App\Models\Restaurant\POS\Activity;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Importable;
use App\Imports\ImportClient ;
use Response;

class RoomTypeController  extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
   {
       //
       $type = RoomType::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();     
       return view('hotel.items.type',compact('type'));
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
      $client = RoomType::create($data);


      return redirect(route('room_type.index'))->with(['success'=>'Created Successfully']);
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
       $data =  RoomType::find($id);
       return view('hotel.items.type',compact('data','id'));

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
       $client = RoomType::find($id);
       $data=$request->post();
      $data['added_by'] = auth()->user()->added_by;
       $client->update($data);


          
       return redirect(route('room_type.index'))->with(['success'=>'Updated Successfully']);
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

       $client = RoomType::find($id);
 
       $client->update(['disabled'=> '1']);;

       return redirect(route('room_type.index'))->with(['success'=>'Deleted Successfully']);
   }
   
     public function import(Request $request){
      
        
        $data = Excel::import(new ImportClient, $request->file('file')->store('files'));
        
        return redirect()->back()->with('success', 'File Imported Successfully');
    }
    
     public function sample(Request $request){

       $filepath = public_path('client_sample.xlsx');
       return Response::download($filepath);
    }
   
}
