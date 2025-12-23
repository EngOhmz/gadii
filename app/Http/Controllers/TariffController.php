<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tariff;
use App\Models\Region;
use App\Models\District;
use App\Models\Zone;
use App\Models\Courier\CourierClient;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use File;
use Response;
use App\Imports\ImportTariff;

class TariffController extends Controller
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
   $client =CourierClient::all();   
       $route =Tariff::all()->where('added_by',auth()->user()->added_by);     
       return view('tariff.data',compact('route','region','client','zone'));
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
      $z= Zone::find($request->zone_id);
       $data['zone_name']=$z->name;
      $data['added_by']=auth()->user()->added_by;


      $route = Tariff::create($data);

      return redirect(route('tariff.index'))->with(['success'=>'Tariff Created Successfully']);

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
  $data = Tariff::find($id);
 $zone = Zone::all()->where('added_by',auth()->user()->added_by);  
 $region = Region::all(); 
      $client =CourierClient::all();   
 $from_district= District::where('region_id', $data->from_region_id)->get(); 
  $to_district= District::where('region_id', $data->to_region_id)->get();   
       return view('tariff.data',compact('data','id','region','from_district','to_district','client','zone'));

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
        $route = Tariff::find($id);
   
      $data=$request->post();
         $z= Zone::find($request->zone_id);
       $data['zone_name']=$z->name;
      $data['added_by']=auth()->user()->added_by;

       $route->update($data);

       return redirect(route('tariff.index'))->with(['success'=>'Tariff Updated Successfully']);

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

       $route = Tariff::find($id);
       $route->delete();

       return redirect(route('tariff.index'))->with(['success'=>'Tariff Deleted Successfully']);
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
