<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Region;
use App\Models\District;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
   {
       //
   $region = Region::all();   
       $route = Route::all();     
       return view('route.route',compact('route','region'));
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
 if($request->from_district_id != $request->to_district_id){
      $data=$request->post();
      $data['added_by']=auth()->user()->id;

     $from_region=Region::find($request->from_region_id);
      $to_region=Region::find($request->to_region_id);

         $from_district=District::find($request->from_district_id);
      $to_district=District::find($request->to_district_id);
      
      $data['from']=$from_region->name ." - ". $from_district->name ;
      $data['to']=$to_region->name ." - ". $to_district->name ;
      $route = Route::create($data);

      return redirect(route('routes.index'))->with(['success'=>'Route Created Successfully']);
}

else{
    return redirect(route('routes.index'))->with(['error'=>'Start Point and Destination Point cannot be the same']);

}

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
  $data =  Route::find($id);
 $region = Region::all(); 
 $from_district= District::where('region_id', $data->from_region_id)->get(); 
  $to_district= District::where('region_id', $data->to_region_id)->get();   
       return view('route.route',compact('data','id','region','from_district','to_district'));

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
       $route = Route::find($id);
    if($request->from_district_id != $request->to_district_id){
      $data=$request->post();
      $data['added_by']=auth()->user()->id;

     $from_region=Region::find($request->from_region_id);
      $to_region=Region::find($request->to_region_id);

         $from_district=District::find($request->from_district_id);
      $to_district=District::find($request->to_district_id);
      
      $data['from']=$from_region->name ." - ". $from_district->name ;
      $data['to']=$to_region->name ." - ". $to_district->name ;

       $route->update($data);

       return redirect(route('routes.index'))->with(['success'=>'Route Updated Successfully']);

}else{
    return redirect(route('routes.index'))->with(['error'=>'Start Point and Destination Point cannot be the same']);

}

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

       $route = Route::find($id);
       $route->delete();

       return redirect(route('route.index'))->with(['success'=>'Route Deleted Successfully']);
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
}
