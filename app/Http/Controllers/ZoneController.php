<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tariff;
use App\Models\Zone;
use App\Models\Region;
use App\Models\District;
use App\Models\Courier\CourierClient;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use File;
use Response;
use App\Imports\ImportTariff;

class ZoneController extends Controller
{

use Importable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
   {
       //
   $region = Region::all();   
  $zone = Zone::all()->where('added_by',auth()->user()->added_by);  
   $client =CourierClient::where('user_id',auth()->user()->added_by)->get();
       //$route =Tariff::all()->where('added_by',auth()->user()->added_by);     
       return view('zone.data',compact('region','client','zone'));
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
      $data['added_by']=auth()->user()->added_by;

      $route = Zone::create($data);

      return redirect(route('zones.index'))->with(['success'=>'Zone Created Successfully']);


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
  $data = Zone::find($id);
 //$zone = Zone::all(); 
 $region = Region::all(); 
      $client =CourierClient::where('user_id',auth()->user()->added_by)->get(); 
 
       return view('zone.data',compact('data','id','region','client'));

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
       $route = Zone::find($id);
   
      $data=$request->post();
         $data['added_by']=auth()->user()->added_by;
       $route->update($data);

       return redirect(route('zones.index'))->with(['success'=>'Zone Updated Successfully']);



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

       $route = Zone::find($id);
       $route->delete();

       return redirect(route('zones.index'))->with(['success'=>'Zone Deleted Successfully']);
   }


 public function findFromRegion(Request $request)
    {

        $district= District::where('region_id',$request->id)->get();                                                                                    
               return response()->json($district);

}
 public function findToRegion(Request $request)
    {

        $district= District::where('region_id',$request->id)->get();                                                                                    
               return response()->json($district);

}


    
    public function import(Request $request){

        $data = Excel::import(new ImportTariff, $request->file('file')->store('files'));
        
        return redirect()->back()->with(['success'=>'File Imported Successfull']);
    }
    
     public function sample(Request $request){
        //return Storage::download('items_sample.xlsx');
        $filepath = public_path('tariff_sample.xlsx');
        return Response::download($filepath); 
    }

}
